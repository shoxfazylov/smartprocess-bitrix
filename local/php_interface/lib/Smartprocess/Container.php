<?php

namespace Custom\SmartProcess;

use \Bitrix\Main;
use \Bitrix\Crm\Service;

Main\Loader::requireModule('crm');

class Container extends Service\Container
{
    public function getFactory(int $entityTypeId): ?Service\Factory
    {
        if ( $entityTypeId == SUPER_ENTITY_TYPE_ID )
        {
            // Сгенерируем название сервиса ->
            $identifier = static::getIdentifierByClassName(static::$dynamicFactoriesClassName, [$entityTypeId]);
            // ... и проверим - вдруг уже есть объект класса?
            if ( Main\DI\ServiceLocator::getInstance()->has($identifier) )
            {
                return Main\DI\ServiceLocator::getInstance()->get($identifier);
            }

            // Объекта нет. Получим 'объект смарт-процесса'
            $type = $this->getTypeByEntityTypeId($entityTypeId);
            if ( !$type )
            {
                // Не получилось, смарт-процесс удален
                return null;
            }

            // Создадим фабрику, запомним ее
            $factory = new Factory($type);
            Main\DI\ServiceLocator::getInstance()->addInstance(
                $identifier,
                $factory
            );
            // Вернем подмененную фабрику
            return $factory;
        }
        // Если тип не наш - передаем в родительский метод
        return parent::getFactory($entityTypeId);
    }

}