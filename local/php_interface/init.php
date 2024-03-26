<?php
define('SUPER_ENTITY_TYPE_ID', 171);
define('SHOW_GROUP_ID', 10);

\Bitrix\Main\Loader::registerAutoLoadClasses(null, array(
    '\Custom\SmartProcess\Container' => '/bitrix/php_interface/lib/Smartprocess/Container.php',
    '\Custom\SmartProcess\Factory' => '/bitrix/php_interface/lib/Smartprocess/Factory.php',
));

if (class_exists('\Bitrix\Main\DI\ServiceLocator')) {
    $serviceLocator = \Bitrix\Main\DI\ServiceLocator::getInstance();
    $serviceLocator->addInstanceLazy('crm.service.container', [
        'className' => '\\Custom\\SmartProcess\\Container',
    ]);

    unset($serviceLocator);
}