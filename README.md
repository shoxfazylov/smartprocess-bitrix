# Кастомизация Смарт-процессов в Bitrix24

### Шаг 1. Подмена контейнера crm
Как вы знаете из главы Процессы все взаимодействие с смарт-процессами осуществляется через контейнер (\Bitrix\Crm\Service\Container), получить который можно следующим кодом:
```php
use \Bitrix\Crm\Service;

/**
* @var Container
*/
$container = Service\Container::getInstance();
```
Однако, внутри себя `getInstance()` метод представляет ни что иное, как обращение к `DI\ServiceLocator` (подробнее в документации) и если мы заглянем внутрь этого метода, то увидим ни что иное как получение `crm.service.container` сервиса

Так как контейнер является общим объектом для CRM и для нашей кастомной сущности, выносить его подмену в наше пространство имен не является корректным шагом.


> Почему это не корректный шаг? Завтра может появится новый смарт-процесс со своей логикой работы и добавлять подмену фабрики для него в пространстве имен другой механике - плохая затея.

Так как контейнер общая часть для всех модулей CRM, целесообразно будет выделить его в соответсвующее пространство имен. Пусть это будет `Custom\SmartProcess\Container`.

