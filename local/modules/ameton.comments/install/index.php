<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

Loc::loadMessages(__FILE__);

class ameton_comments extends CModule
{
    public $MODULE_ID = 'ameton.comments';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;

    function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__ . '/version.php');

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('AMETON_COMMENTS_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('AMETON_COMMENTS_MODULE_DESC');

        $this->PARTNER_NAME = Loc::getMessage('AMETON_COMMENTS_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('AMETON_COMMENTS_PARTNER_URI');
    }

    private function getEntities()
    {
        return [
            \Ameton\Comments\Orm\CommentsTable::class,
        ];
    }

    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '20.00.00');
    }

    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        } else {
            return dirname(__DIR__);
        }
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if ($this->isVersionD7()) {
            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);

            $this->InstallDB();
        } else {
            $APPLICATION->ThrowException(Loc::getMessage('AMETON_COMMENTS_INSTALL_ERROR_VERSION'));
        }
    }

    public function DoUninstall()
    {
        $this->UnInstallDB();

        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installFiles($arParams = array())
    {
        $component_path = $this->GetPath() . '/install/components';

        if (\Bitrix\Main\IO\Directory::isDirectoryExists($component_path)) {
            CopyDirFiles($component_path, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components', true, true);
        } else {
            throw new \Bitrix\Main\IO\InvalidPathException($component_path);
        }

        $js_path = $this->GetPath() . '/install/js';

        if (\Bitrix\Main\IO\Directory::isDirectoryExists($js_path)) {
            CopyDirFiles($js_path, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/js', true, true);
        } else {
            throw new \Bitrix\Main\IO\InvalidPathException($js_path);
        }

        CopyDirFiles($this->GetPath() . '/install/public', $_SERVER['DOCUMENT_ROOT'] . '/', true, true);

    }

    public function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        $entities = $this->getEntities();

        foreach ($entities as $entity) {
            if (!Application::getConnection($entity::getConnectionName())->isTableExists($entity::getTableName())) {
                Base::getInstance($entity)->createDbTable();
            }
        }
    }

    public function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        $connection = \Bitrix\Main\Application::getConnection();

        $entities = $this->getEntities();

        foreach ($entities as $entity) {
            if (Application::getConnection($entity::getConnectionName())->isTableExists($entity::getTableName())) {
                $connection->dropTable($entity::getTableName());
            }
        }
    }

    public function InstallEvents()
    {
        $eventManager = EventManager::getInstance();
        // @TODO установка событиый
        return true;
    }

    public function UnInstallEvents()
    {
        $eventManager = EventManager::getInstance();
        // @TODO удаление событиый
        return true;
    }
}
