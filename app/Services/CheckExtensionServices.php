<?php

namespace App\Services;

class CheckExtensionServices
{
    public static function checkExtension($fileData, $extension)
    {

        // 拡張子を小文字に変換
        $extension = mb_strtolower($extension);

        //拡張子ごとに base64エンコード実施
        if ($extension = 'jpg') {
            $data_url = 'data:image/jpg;base64,' . base64_encode($fileData);
        }

        if ($extension = 'jpeg') {
            $data_url = 'data:image/jpg;base64,' . base64_encode($fileData);
        }

        if ($extension = 'png') {
            $data_url = 'data:image/png;base64,' . base64_encode($fileData);
        }

        if ($extension = 'gif') {
            $data_url = 'data:image/gif;base64,' . base64_encode($fileData);
        }

        return $data_url;
    }
}
