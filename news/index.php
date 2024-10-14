<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Новости");

$APPLICATION->IncludeComponent('ameton:news.router', 'news', [
    'IBLOCK_CODE' => 'news',
    'SEF_FOLDER' => '/news/',
    'SEF_URL_TEMPLATES' => [
        'list' => '',
        'detail' => '#ELEMENT_ID#/',
    ],
]);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
