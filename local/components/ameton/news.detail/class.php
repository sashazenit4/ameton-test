<?php
namespace Ameton\Components;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Loader;
class NewsDetailComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        Loader::includeModule('ameton.comments');
        Loader::includeModule('iblock');
        $news = ElementTable::getByPrimary($this->arParams['IBLOCK_ID'])->fetch();
        $this->arResult['NEWS_TITLE'] = $news['NAME'];
        $this->arResult['NEWS_ID'] = $news['ID'];
        $this->includeComponentTemplate();
    }
}
