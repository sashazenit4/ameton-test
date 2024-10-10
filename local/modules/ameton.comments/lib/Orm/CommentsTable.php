<?php
namespace Ameton\Comments\Orm;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\Type\DateTime;

/**
 * Class CommentsTable
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> news_id int mandatory
 * <li> parent_id int optional
 * <li> author_name string(255) mandatory
 * <li> comment_text text mandatory
 * <li> comment_date datetime optional default current datetime
 * <li> reply_count int optional default 0
 * <li> comment_path string(255) mandatory
 * <li> level int optional default 1
 * </ul>
 *
 * @package Ameton\Comments\Orm
 **/

class CommentsTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'comments_denormalized';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            'id' => (new IntegerField('id',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_ID_FIELD'))
                ->configurePrimary(true)
                ->configureAutocomplete(true)
            ,
            'news_id' => (new IntegerField('news_id',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_NEWS_ID_FIELD'))
                ->configureRequired(true)
            ,
            'parent_id' => (new IntegerField('parent_id',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_PARENT_ID_FIELD'))
            ,
            'author_name' => (new StringField('author_name',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 255),
                        ];
                    },
                ]
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_AUTHOR_NAME_FIELD'))
                ->configureRequired(true)
            ,
            'comment_text' => (new TextField('comment_text',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_COMMENT_TEXT_FIELD'))
                ->configureRequired(true)
            ,
            'comment_date' => (new DatetimeField('comment_date',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_COMMENT_DATE_FIELD'))
                ->configureDefaultValue(function()
                {
                    return new DateTime();
                })
            ,
            'reply_count' => (new IntegerField('reply_count',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_REPLY_COUNT_FIELD'))
                ->configureDefaultValue(0)
            ,
            'comment_path' => (new StringField('comment_path',
                [
                    'validation' => function()
                    {
                        return[
                            new LengthValidator(null, 255),
                        ];
                    },
                ]
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_COMMENT_PATH_FIELD'))
                ->configureRequired(true)
            ,
            'level' => (new IntegerField('level',
                []
            ))->configureTitle(Loc::getMessage('DENORMALIZED_ENTITY_LEVEL_FIELD'))
                ->configureDefaultValue(1)
            ,
        ];
    }
}
