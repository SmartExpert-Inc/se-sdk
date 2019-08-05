<?php

namespace SE\SDK\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

final class S3Service
{
    const DEFAULT_FOLDER = '_tmp';

    /** @var Storage $storage*/
    private $storage;

    /** @var string $env*/
    private $env;

    public function __construct()
    {
        $this->storage = Storage::cloud();
        $this->env = config('app.env');
    }

    /**
     * Put array of files
     * @param array $files
     * @param string $folder
     * @return array
     * @throws Exception
     */
    public function putFiles(array $files, $folder = self::DEFAULT_FOLDER): array
    {
        $return = [];
        foreach ($files as $file) {
            $return[] = $this->putFile($file, $folder);
        }
        return $return;
    }

    /**
     * Put file
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     * @throws Exception
     */
    public function putFile(UploadedFile $file, $folder = self::DEFAULT_FOLDER): string
    {
        $folder = $folder ?: self::DEFAULT_FOLDER;
        $folder = "{$this->env}/{$folder}";

        $filename = $this->generateName($file);
        $this->storage->putFileAs($folder, $file, $filename);
        $path = $this->storage->url("{$folder}{$filename}");

        return $path;
    }

    /**
     * Put file from url
     * @param string $url
     * @param string $folder
     * @return string|null
     * @throws Exception
     */
    public function putFileFromUrl(string $url, $folder = self::DEFAULT_FOLDER): ?string
    {
        $url = preg_replace_callback('/[^\x20-\x7f]/', function($match) {
            return urlencode($match[0]);
        }, $url); // encoding only on non-ASCII characters
        try {
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $file = "/tmp/{$info['basename']}";
            file_put_contents($file, $contents);
        } catch (Exception $e) {
            report($e);
            return null;
        }
        $uploadedFile = new UploadedFile($file, $info['basename']);
        return $this->putFile($uploadedFile, $folder);
    }

    /**
     * Generate unique filename
     * @param UploadedFile $file
     * @return string
     * @throws Exception
     */
    private function generateName(UploadedFile $file): string
    {
        $filename = Uuid::generate()->string;
        $extension = $file->getClientOriginalExtension()
            ? ".{$file->getClientOriginalExtension()}"
            : null;
        return "{$filename}{$extension}";
    }
}