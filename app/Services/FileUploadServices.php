<?php 

namespace App\Services;

class FileUploadServices
{
    public static function fileUpload($imageFile) {
        // ファイル名をフルで取得
        $filenameWithExt = $imageFile->getClientOriginalName();

        // ファイル名のみ取得
        $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // 拡張子のみ取得
        $extension = $imageFile->getClientOriginalExtension();

        // DBに保存する名前を格納
        $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

        // 画像ファイルパスを取得
        $fileData = file_get_contents($imageFile->getRealPath());

        $list = [$extension, $fileNameToStore, $fileData];

        return $list;
    }
}