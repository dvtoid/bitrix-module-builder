<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;

/**
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global $Update
 * @global $Apply
 * @global $RestoreDefaults
 * @global $mid
 */

// Проверка прав
$modulePerms = $APPLICATION->GetGroupRight($mid);
if ($modulePerms < 'R') {
    return;
}

// Получение конфигурации табов и опций
$options = require __DIR__ . '/options_conf.php';

// Вывод
Gelion\BitrixOptions\Form::generate('dvtoid.example', $options);
