<?php

namespace App\Custom;

use App\Models\Files as FilesModel;

class CFiles extends Files
{
    public $files;

    private $fileDir;

    /**
     * Files constructor.
     */
    function __construct()
    {
        $this->fileDir = '/uploads/files';
//        $this->files = new FilesModel();
    }

    public function getById($id)
    {
        $arFile = [];
        $file = FilesModel::find($id);;
        if (!empty($file->id))
            $arFile = $file->toArray();
        return $arFile;
    }


    public function upload(array $arFile)
    {
        if (empty($arFile)) {
            return false;
        }
        $arStatus = $this->getArStatus();
        $filePathDir = $this->fileDir . "/" . $arFile['type'] . "/" . time() . "/" . md5(microtime());
        $fileUploadPathDir = $this->getUploadPath($filePathDir);

        if (!mkdir($fileUploadPathDir, 0775, true)) {
            $arStatus['error'][] = [
                "message" => "Не удалось создать папку {$fileUploadPathDir}"
            ];
        }

        if ($arFile['file']->move($fileUploadPathDir, $arFile['name'])) {
            unset($arFile['file']);
            unset($arFile['tmp_link']);
            $arFile['file_url'] = $filePathDir . "/" . $arFile['name'];

        } else {
            $arStatus['error'][] = [
                "message" => "Не удалось загрузить файл {$fileUploadPathDir}/{$arFile['name']}"
            ];
        }

        if (!$arFile['id'] = $this->save($arFile)) {
            $arStatus['error'][] = [
                "message" => "Не удалось сохранить файл {$fileUploadPathDir}/{$arFile['name']} в базу данных"
            ];
        } else {
            $arStatus['fileInfo'] = $arFile;
            $arStatus['status'] = true;
            $arStatus['error']['count'] = count($arStatus['error']);
        }


        return $arStatus;
    }

    private function save($arFile)
    {
        $file = new FilesModel();

        $file->name = $arFile['name'];
        $file->link = $arFile['file_url'];
        $file->type = $arFile['type'];
        $file->mime = $arFile['mime'];
        $file->size = $arFile['size'];

        if (!$file->save()) {
            return false;
        }

        return $file->id;

    }

}
