<?php
namespace Ameton\Components;

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
class NewsCommentsComponent extends \CBitrixComponent implements Controllerable
{
    private array $elements = [];
    private array $preparedElements = [];
    public function executeComponent()
    {
        Loader::includeModule('ameton.comments');
        $this->prepareElements();
        $this->prepareElementStructure();
        $this->arResult['ELEMENTS'] = $this->preparedElements;
        $this->includeComponentTemplate();
    }

    public function prepareElementStructure(): void
    {
        foreach ($this->elements as $element) {
            $this->preparedElements[$element['level']] = $element;
        }
    }

    public function prepareElements(): void
    {
        $elementObject = \Ameton\Comments\Orm\CommentsTable::getList([
            'filter' => $this->getFilter(),
            'select' => $this->getSelect(),
            'order'   => $this->getOrder(),
        ]);

        while ($element = $elementObject->fetch()) {
            $this->elements[] = $element;
        }
    }

    private function getOrder(): array
    {
        return [
            'comment_date' => 'DESC',
        ];
    }

    private function getFilter(): array
    {
        return [
            'news_id' => $this->arParams['ELEMENT_ID'],
            'level' => [
                0,
                1,
            ],
        ];
    }

    private function getSelect(): array
    {
        return [
            'news_id',
            'id',
            'parent_id',
            'author_name',
            'comment_text',
            'comment_date',
            'reply_count',
            'comment_path',
            'level',
        ];
    }

    public function listKeysSignedParameters(): array
    {
        return [
            'ELEMENT_ID',
        ];
    }

    public function configureActions(): array
    {
        return [
            'getChildrenComments' => [
                'prefilters' => [],
            ],
        ];
    }

    public function getChildrenCommentsAction(int $parentCommentId): array
    {
        return [
            'same' => $parentCommentId,
        ];
    }
}
