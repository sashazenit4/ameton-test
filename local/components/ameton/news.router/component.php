<?php

/**
 * @var array $arParams
 */

declare(strict_types=1);

use Bitrix\Iblock\Component\Tools;

(defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) || die();

$arDefaultUrlTemplates404 = [];
$arDefaultVariableAliases404 = [];
$arDefaultVariableAliases = [];
$arComponentVariables = ['SECTION_CODE', 'ELEMENT_CODE'];
$arVariables = [];
$b404 = false;

$arParams['SEF_URL_TEMPLATES']['listIndex'] = 'index.php';

$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
    $arDefaultUrlTemplates404,
    $arParams['SEF_URL_TEMPLATES']
);
$arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
    $arDefaultVariableAliases404,
    $arParams['VARIABLE_ALIASES']
);
$engine = new CComponentEngine($this);
$componentPage = $engine->guessComponentPath($arParams['SEF_FOLDER'], $arUrlTemplates, $arVariables);

$b404 |= empty($componentPage);

CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

$arResult = [
    'FOLDER' => $arParams['SEF_FOLDER'],
    'URL_TEMPLATES' => $arUrlTemplates,
    'VARIABLES' => $arVariables,
    'ALIASES' => $arVariableAliases
];

$iblockId = 1;

if (0 === $iblockId) {
    $b404 = true;
} else {
    $arResult['IBLOCK_ID'] = $iblockId;
}

if ($b404) {
    Tools::process404('', true, true, true);
}

$componentPage = 'listIndex' === $componentPage ? 'list' : $componentPage;

$this->IncludeComponentTemplate($componentPage);
