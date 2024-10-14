<?php

declare(strict_types=1);
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arResult
 * @var $arParams
 * @var CMain $APPLICATION
 */

$APPLICATION->IncludeComponent(
    'ameton:news.detail',
    '',
    [
        'IBLOCK_ID' => 1,
        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
        'ELEMENT_SORT_FIELD' => 'ACTIVE_FROM',
        'ELEMENT_SORT_FIELD2' => 'SORT',
        'ELEMENT_SORT_ORDER' => 'DESC',
        'ELEMENT_SORT_ORDER2' => 'ASC',
        'FIELDS' => ['NAME', 'ID'],
        'PROPERTY_CODE' => [],
        'CACHE_TIME' => '0',
        'LINK_ELEMENTS_URL' => '/news/',
    ]
);

$APPLICATION->IncludeComponent(
    'ameton:news.comments',
    '',
    [
        'IBLOCK_ID' => 1,
        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
    ],
);
