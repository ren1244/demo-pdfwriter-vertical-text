<?php

/**
 * 確認字型讀取到 PDFWriter
 * 名稱設為 kaiTW98
 */

use ren1244\PDFWriter\FontLib\FontLoader;

// 使用時用這個當字型名稱
$fontname = 'kaiTW98';

// 確認有沒有這個檔案
$checkFile = __DIR__ . "/vendor/ren1244/pdfwriter/fonts/custom/$fontname.json";

// 沒有的話讀取此檔案
$srcFont = __DIR__ . '/font/TW-Kai-98_1.ttf';


if (!file_exists($checkFile)) {
    if (!file_exists($srcFont)) {
        echo '找不到字型';
        exit();
    }
    FontLoader::loadFile($srcFont, $fontname);
}
