<?php

require('vendor/autoload.php');

use ren1244\PDFWriter\PDFWriter;
use ren1244\PDFWriter\PageMetrics;

function drawEnvelope($pdf, $x, $y, $code1, $add1, $reciver, $code2, $add2)
{
    $pdf->svg->addSvg('img/信封向量圖.svg', $x - 0.5, $y - 0.5, 101, 221);

    $pdf->font->setFont('kaiTW98', 10);
    $pdf->text->setRect($x + 45, $y + 20, 50, 10);
    $pdf->text->addText('請寫收件人郵遞區號', [
        'cellAlign' => 8,
        'color' => 'FF0000'
    ]);

    $pdf->text->setRect($x + 7, $y + 212, 50, 10);
    $pdf->text->addText('寄件人郵遞區號', [
        'cellAlign' => 8,
        'color' => 'FF0000'
    ]);

    $pdf->text->setRect($x + 7.5, $y + 10, 20, 20);
    $pdf->text->addTextV("郵票\n正貼", [
        'wordSpace' => 8,
        'lineSpace' => 12,
        'cellAlign' => 5,
        'color' => 'FF0000'
    ]);

    // 收件人地址
    $pdf->font->setFont('kaiTW98', 18);
    $pdf->text->setRect($x + 65, $y + 35, 35, 150);
    $pdf->text->addTextV($add1, [
        'wordSpace' => 4,
        'cellAlign' => 8
    ]);

    // 收件人
    $pdf->font->setFont('kaiTW98', 30);
    $pdf->text->setRect($x + 35, $y + 35, 30, 150);
    $pdf->text->addTextV($reciver, [
        'wordSpace' => 12,
        'cellAlign' => 5
    ]);

    // 寄件人地址
    $pdf->font->setFont('kaiTW98', 18);
    $pdf->text->setRect($x, $y + 35, 35, 150);
    $pdf->text->addTextV($add2, [
        'wordSpace' => 4,
        'lineSpace' => 6,
        'cellAlign' => 2,
        'textAlign' => 'end'
    ]);

    // 郵遞區號
    $arr = [
        [
            'code' => $code1,
            'x' => 45,
            'y' => 10
        ],
        [
            'code' => $code2,
            'x' => 7,
            'y' => 202
        ]
    ];
    foreach ($arr as $info) {
        $code = $info['code'];
        $idx = 0;
        $tx = $info['x'] + $x;
        $ty = $info['y'] + $y;
        for ($i = 0; $i < 2; ++$i) {
            for ($k = 0; $k < 3; ++$k) {
                $pdf->font->setFont('kaiTW98', 12);
                $pdf->text->setRect($tx + 8 * $k, $ty, 6, 8);
                $pdf->text->addText($code[$idx + $k], [
                    'cellAlign' => 5,
                ]);
            }
            $tx += 28;
            $idx += 4;
        }
    }
}

$pdf = new PDFWriter([
    'svg' => ren1244\PDFWriter\Ext\Svg::class
]);
$pdf->font->addFont('kaiTW98', true);

$pdf->addPage('A4');

drawEnvelope(
    $pdf,
    30,
    20,
    '106-409',
    '臺北市大安區金山南路 2 段 55 號',
    '陳某某　小姐　啟',
    '408-770',
    "臺中市南屯區向上路 2 段 199 號\n林某某　緘"
);

$pdf->font->setFont('kaiTW98', 16);
$pdf->svg->addSvg('img/Ghostscript_Tiger.svg', 150, 8, 50);
$pdf->text->setRect(150, 60, 50, 50);
$pdf->text->addText("較複雜的 SVG", [
    'cellAlign' => 8
]);

$pdf->svg->addSvg('img/NewTux.svg', 150, 80, 50);
$pdf->text->setRect(150, 135, 50, 50);
$pdf->text->addText("尚未完美支援\n這張可能是使用漸層的關係", [
    'cellAlign' => 8
]);

// 輸出
header('Content-Disposition: inline; filename="直書範例-信封.pdf"');
$pdf->output();
