<?php

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Request;
use Bitrix\Main\Server;

Loc::loadMessages(__FILE__);

if (class_exists('dvtoid_example')) {
    return;
}

class dvtoid_example extends CModule
{
    public $MODULE_ID = 'dvtoid.example';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS = 'Y';

    /** @var Server */
    protected Server $server;

    /** @var Request */
    protected Request $request;

    public function __construct()
    {
        $arModuleVersion = [];

        require __DIR__ . '/version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_NAME = Loc::getMessage('#MESS#_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('#MESS#_MODULE_DESCRIPTION');

        $this->PARTNER_NAME = Loc::getMessage('#MESS#_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('#MESS#_PARTNER_URI');

        $context = Application::getInstance()->getContext();
        $this->server = $context->getServer();
        $this->request = $context->getRequest();
    }

    public function DoInstall(): bool
    {
        global $APPLICATION;

        if (!$this->isVersionD7()) {
            $APPLICATION->ThrowException(Loc::getMessage('#MESS#_INSTALL_ERROR_VERSION'));
            return false;
        }

        try {
            Loader::includeModule($this->MODULE_ID);

            $this->InstallDB();
            $this->InstallEvents();
            $this->InstallFiles();

            ModuleManager::registerModule($this->MODULE_ID);

            return true;

        } catch (Exception $e) {
            $APPLICATION->ThrowException(Loc::getMessage('#MESS#_INSTALL_ERROR', ['#ERROR#', $e->getMessage()]));
            return false;
        }
    }

    public function DoUninstall(): void
    {
        global $APPLICATION, $step, $obModule;

        if ($step < 2) {
            $APPLICATION->IncludeAdminFile(GetMessage('#MESS#_UNINSTALL_TITLE'), __DIR__ . '/unstep1.php');
        } elseif ($step == 2) {
            $GLOBALS['CACHE_MANAGER']->CleanAll();
            ModuleManager::unRegisterModule($this->MODULE_ID);

            $this->UnInstallDB(['savedata' => $_REQUEST['savedata'] ?? false]);
            $this->UnInstallEvents();
            $this->UnInstallFiles();

            $obModule = $this;
            $APPLICATION->IncludeAdminFile(GetMessage('#MESS#_UNINSTALL_TITLE'), __DIR__ . '/unstep2.php');
        }
    }

    public function InstallDB($arParams = []): bool
    {
        /*
        global $APPLICATION;

        try {
            $db = Application::getConnection();

            $exampleTableName = ExampleTable::getTableName();
            if (!$db->isTableExists($exampleTableName)) {
                ExampleTable::getEntity()->createDbTable();
                $db->createIndex($exampleTableName, 'SOME_ID', 'SOME_ID');
            }

        } catch (Exception $e) {
            $APPLICATION->ThrowException(Loc::getMessage('#MESS#_INSTALL_ERROR', ['#ERROR#', $e->getMessage()]));
            return false;
        }
        */

        return true;
    }

    public function UnInstallDB($arParams = []): bool
    {
        /*
        global $APPLICATION;

        try {
            Loader::includeModule($this->MODULE_ID);

            Option::delete($this->MODULE_ID);

            $db = Application::getConnection();
            $db->dropTable(ExampleTable::getTableName());

            CAgent::RemoveModuleAgents($this->MODULE_ID);

        } catch (Exception) {
            $APPLICATION->ThrowException(Loc::getMessage('#MESS#_INSTALL_ERROR', ['#ERROR#', $e->getMessage()]));
            return false;
        }
        */

        return true;
    }

    public function InstallEvents(): bool
    {
        $em = EventManager::getInstance();
        $em->registerEventHandler('main', 'OnPageStart', $this->MODULE_ID);
        //$em->registerEventHandler('rest', 'OnRestServiceBuildDescription', $this->MODULE_ID, 'Dvtoid\Example\Rest', 'OnRestServiceBuildDescription');
        return true;
    }

    public function UnInstallEvents(): bool
    {
        $em = EventManager::getInstance();
        $em->unRegisterEventHandler('main', 'OnPageStart', $this->MODULE_ID);
        //$em->unRegisterEventHandler('rest', 'OnRestServiceBuildDescription', $this->MODULE_ID, 'Dvtoid\Example\\Rest', 'OnRestServiceBuildDescription');
        return true;
    }

    public function InstallFiles($arParams = []): bool
    {
        $root = $this->server->getDocumentRoot();

        CopyDirFiles(__DIR__ . '/admin/', $root . '/bitrix/admin', true, true);
        CopyDirFiles(__DIR__ . "/themes", $root . "/bitrix/themes", true, true);
        CopyDirFiles(__DIR__ . "/js/", $root . "/bitrix/js/", true, true);

        return true;
    }

    public function UnInstallFiles(): bool
    {
        $root = $this->server->getDocumentRoot();

        DeleteDirFiles(__DIR__ . "/admin/", $root . "/bitrix/admin/");
        DeleteDirFiles(__DIR__ . "/themes/.default", $root . "/bitrix/themes/.default");
        Directory::deleteDirectory($root . "/bitrix/themes/.default/icons/" . $this->MODULE_ID . "/");
        Directory::deleteDirectory($root . "/bitrix/js/" . $this->MODULE_ID . "/");

        return true;
    }

    private function isVersionD7(): bool
    {
        return version_compare(ModuleManager::getVersion("main"), "14.00.00") >= 0;
    }
}
