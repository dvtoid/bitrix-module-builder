<?php

global $APPLICATION;

IncludeModuleLangFile(__FILE__);

foreach (GetModuleEvents('dvtoid.example', 'OnModuleUnInstall', true) as $arEvent) {
    ExecuteModuleEventEx($arEvent);
}
?>

<form action="<?= $APPLICATION->GetCurPage(); ?>">
    <?= bitrix_sessid_post(); ?>
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="hidden" name="id" value="dvtoid.example">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?php CAdminMessage::ShowMessage(GetMessage("#MESS#_WARNING")); ?>
    <input type="submit" name="inst" value="<?= GetMessage('MOD_UNINST_DEL') ?>">
</form>
