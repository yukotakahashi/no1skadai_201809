<?php

require_once("GoogleSpread.php");
mb_internal_encoding("UTF-8");

$spread = new GoogleSpread();
// スプレッドシートから中身を取得
$spreadResult = $spread->getSpreadsheetsInfo();
// 取得した値を表示
foreach ($spreadResult as $resultStr) {
    echo $resultStr . "\n";
}
