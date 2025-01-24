<?php

use Bitrix\Main\Localization\Loc;

IncludeModuleLangFile(__FILE__);

global $APPLICATION;

if (!$APPLICATION->GetGroupRight("dvtoid.example") > "D") {
    return false;
}

// https://dev.1c-bitrix.ru/api_help/main/general/admin.section/menu.php
return [
    [
        'parent_menu' => 'global_menu_content',
        'text' => Loc::getMessage('#MESS#_MENU_TEXT'),
        'title' => Loc::getMessage('#MESS#_MENU_TITLE'),
        'items_id' => 'dvtoid_example_menu',
        'icon' => 'dvtoid_example_menu_icon',
        'page_icon' => 'dvtoid_example_menu_icon',
        'sort' => '10000',
        'items' => [
            [
                "sort" => "10",
                'items_id' => 'dvtoid_example_menu_page',
                "text" => Loc::getMessage('#MESS#_MENU_PAGE_TEXT'),
                "title" => Loc::getMessage('#MESS#_MENU_PAGE_TITLE'),
                'url' => 'dvtoid.example.page.php?lang=' . LANGUAGE_ID,
            ],
        ]
    ]
];