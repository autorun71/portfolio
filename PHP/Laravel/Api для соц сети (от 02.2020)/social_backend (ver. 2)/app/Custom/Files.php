<?php

namespace App\Custom;

use Illuminate\Http\UploadedFile;

class Files
{
    private $uploadPath;
    private $arStatus = [
        "fileInfo" => [],
        "error" => [],
        "status" => false,
    ];
    private $arFile = [
        "name" => null,
        "type" => null,
        "tmp_link" => null,
        "size" => null,
        "mime" => null
    ];

    public function getArFile()
    {
        return $this->arFile;
    }

    public function makeFileArray(UploadedFile $file)
    {
        if (!$file->isValid()) {
            return null;
        }
        $arFile = $this->arFile;
        $arFile['name'] = $file->hashName();
        $arFile['type'] = $file->getMimeType();
        $arFile['mime'] = self::getMimeTypeByName($file->hashName());
        $arFile['tmp_link'] = $file->getPathName();
        $arFile['size'] = $file->getSize();
        $arFile['file'] = $file;

        return $arFile;
    }

    public static function getMimeTypeByName(string $fileName)
    {
        $arFileName = explode('.', $fileName);

        return array_pop($arFileName);
    }

    private function makeUploadPath($path)
    {
        $this->uploadPath = public_path() . "/" . trim($path, '/');
    }

    public function getUploadPath($path = false)
    {
        if ($path) {
            $this->makeUploadPath($path);
        }

        return $this->uploadPath;
    }

    public function getArStatus() {
        return $this->arStatus;
    }
}
