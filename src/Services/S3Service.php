<?php

namespace SE\SDK\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{File, Storage};
use Spatie\Image\{Image, Manipulations};
use Webpatser\Uuid\Uuid;

final class S3Service
{
    const DEFAULT_DIRECTORY = 'temp';
    const DEFAULT_EXTENSION = 'jpg';
    const DEFAULT_ACCESS = 'public';

    /** @var Storage $storage*/
    private $storage;

    /** @var string $env*/
    private $env;

    public function __construct()
    {
//        $this->storage = Storage::cloud();
        $this->storage = Storage::disk('do_spaces');
        $this->env = config('app.env');
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        }

        return $this->storage->$method(...$parameters);
    }

    public function putFiles(array $files, $directory = self::DEFAULT_DIRECTORY): array
    {
        $return = [];

        foreach ($files as $file) {
            $return[] = $this->putFile($file, $directory);
        }

        return $return;
    }

    public function putFile(UploadedFile $file, $directory = self::DEFAULT_DIRECTORY): string
    {
        $directory = $this->getDirectory($directory);
        $filename = $this->getUniqueFileName($file);
        $this->storage->putFileAs($directory, $file, $filename, self::DEFAULT_ACCESS);

        return $this->storage->url("{$directory}{$filename}");
    }

    public function putFileFromUrl(string $url, $directory = self::DEFAULT_DIRECTORY): ?string
    {
        $url = preg_replace_callback('/[^\x20-\x7f]/', function($match) {
            return urlencode($match[0]);
        }, $url); // encoding only on non-ASCII characters

        try {
            $info = pathinfo($url);
            $client = new Client();
            $res = $client->get($url);
            $contents = (string) $res->getBody()->getContents();
            $file = "/tmp/{$info['basename']}";
            File::put($file, $contents);
        } catch (Exception $e) {
            report($e);

            return null;
        }

        $uploadedFile = new UploadedFile($file, $info['basename']);

        return $this->putFile($uploadedFile, $directory, self::DEFAULT_ACCESS);
    }

    public function putFileFromBase64(string $base64data, $directory = self::DEFAULT_DIRECTORY): ?string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64data)) {
            // directory
            $directory = $this->getDirectory($directory);

            // file data
            $file = substr($base64data, strpos($base64data, ',') + 1);
            $file = base64_decode($file);

            // filename
            $filename = $this->getUniqueFileName();

            // extension
            preg_match("/^data\:image\/([a-z]+)\;base64*./", $base64data, $matches);
            $extension = self::DEFAULT_EXTENSION;
            if ($matches) {
                $extension = $matches[1];
            }
            $filename .= ".{$extension}";

            // put file
            $this->storage->put("{$directory}{$filename}", $file, self::DEFAULT_ACCESS);

            return $this->storage->url("{$directory}{$filename}");
        }

        return null;
    }

    public function putFileThumbFromBase64(string $base64data, $directory = self::DEFAULT_DIRECTORY): ?string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64data)) {
            // directory
            $directory = $this->getDirectory($directory);

            // file data
            $file = substr($base64data, strpos($base64data, ',') + 1);
            $file = base64_decode($file);

            // filename
            $filename = $this->getUniqueFileName();

            // extension
            preg_match("/^data\:image\/([a-z]+)\;base64*./", $base64data, $matches);
            $extension = self::DEFAULT_EXTENSION;
            if ($matches) {
                $extension = $matches[1];
            }
            $filename .= ".{$extension}";

            // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
            $tmpFile = tempnam(sys_get_temp_dir(), 'se_sdk');
            File::put($tmpFile, $file);

            Image::load($tmpFile)
                ->crop(Manipulations::CROP_CENTER,
                    config('se_sdk.s3.thumb.width'),
                    config('se_sdk.s3.thumb.height'))
                ->save();

            $file = File::get($tmpFile);

            // put file
            $this->storage->put("{$directory}{$filename}", $file, self::DEFAULT_ACCESS);

            return $this->storage->url("{$directory}{$filename}");
        }

        return null;
    }

    public function files(string $directory = self::DEFAULT_DIRECTORY, bool $recursive = false): array
    {
        $directory = $this->getDirectory($directory);

        return $this->storage->files($directory, $recursive);
    }

    private function getDirectory(string $directory): string
    {
        $directory = $directory ?: self::DEFAULT_DIRECTORY;

        return "{$this->env}/{$directory}/";
    }

    private function getUniqueFileName(UploadedFile $file = null): string
    {
        $filename = Uuid::generate()->string;

        if (! is_null($file)) {
            $filename .= $file->getClientOriginalExtension()
                ? ".{$file->getClientOriginalExtension()}" // extension
                : null;
        }

        return $filename;
    }
}