<?php

namespace SE\SDK\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{File, Storage};
use Illuminate\Support\Str;
use Spatie\Image\{Image, Manipulations};
use Webpatser\Uuid\Uuid;

final class S3Service
{
    const DEFAULT_DIRECTORY = 'temp';
    const DEFAULT_EXTENSION = 'jpg';
    const DEFAULT_ACCESS = 'public';
    const PRIVATE_ACCESS = 'private';

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

    public function putFiles(array $files, $directory = self::DEFAULT_DIRECTORY, $access = self::DEFAULT_ACCESS): array
    {
        $return = [];

        foreach ($files as $file) {
            $return[] = $this->putFile($file, $directory, $access);
        }

        return $return;
    }

    public function putFile(UploadedFile $file, $directory = self::DEFAULT_DIRECTORY, $access = self::DEFAULT_ACCESS, bool $originalName = true): string
    {
        $directory = $this->getDirectory($directory);
        $filename = $this->getUniqueFileName($file, $originalName);
        $this->storage->putFileAs($directory, $file, $filename, $access);

        return $this->storage->url("{$directory}{$filename}");
    }

    public function putFileFromUrl(string $url, $directory = self::DEFAULT_DIRECTORY, $access = self::DEFAULT_ACCESS): ?string
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

        return $this->putFile($uploadedFile, $directory, $access);
    }

    public function putFileFromBase64(string $base64data, $directory = self::DEFAULT_DIRECTORY, $access = self::DEFAULT_ACCESS): ?string
    {
        if (preg_match('/^data:image\/([\w+.]+);base64,/', $base64data)) {
            // directory
            $directory = $this->getDirectory($directory);

            // file data
            $file = substr($base64data, strpos($base64data, ',') + 1);
            $file = base64_decode($file);

            // filename
            $filename = $this->getUniqueFileName();

            // extension
            preg_match("/^data:image\/([\w+.]+);base64*./", $base64data, $matches);
            $extension = self::DEFAULT_EXTENSION;
            if ($matches) {
                $extension = $matches[1];
            }
            $filename .= ".{$extension}";

            // put file
            $this->storage->put("{$directory}{$filename}", $file, $access);

            return $this->storage->url("{$directory}{$filename}");
        }

        return null;
    }

    public function putFileThumbFromBase64(string $base64data, $directory = self::DEFAULT_DIRECTORY, $access = self::DEFAULT_ACCESS): ?string
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
            $this->storage->put("{$directory}{$filename}", $file, $access);

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

    private function getUniqueFileName(UploadedFile $file = null, bool $originalName = true): string
    {
        $filename = Uuid::generate()->string;

        if (! is_null($file) && $originalName) {
            $filename = $this->getOriginalName($file);
//            $filename .= $file->getClientOriginalExtension()
//                ? ".{$file->getClientOriginalExtension()}" // extension
//                : null;
        }

        return $filename;
    }

    private function getOriginalName(UploadedFile $file): string
    {
        $filename = $file->getClientOriginalName();
        $fileNameArr = explode('.', $filename);
        array_pop($fileNameArr);
        $filename = implode('_', $fileNameArr);
        $filename = str_replace(' ', '_', $filename);
        $filename = Str::slug($filename, '_');
        $filename .= $file->getClientOriginalExtension()
            ? ".{$file->getClientOriginalExtension()}" // extension
            : null;

        return $filename;
    }
}