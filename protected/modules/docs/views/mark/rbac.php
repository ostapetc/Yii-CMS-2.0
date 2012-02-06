#Модуль: rbac (ограничение доступа)

Для разграничения прав доступа используется стандартная для `Yii` методика `RBAC`,
ознакомиться с ней можно в статьях: ["Аутентификация и авторизация"](http://yiiframework.ru/doc/guide/ru/topics.auth)
и ["RBAC и описание ролей в файле"](http://yiiframework.ru/doc/cookbook/ru/access.rbac.file)

По умолчанию в `BaseController::beforeAction` проверяется имеет ли пользователь доступ к
запрашиваемому действию. Делается это следующим образом:
- формируется название операции `ucfirst($controller_id) . '_' . ucfirst($action_id)`
- выполняется проверка доступа пользователя с помощью функции `RbacModule::isAllow`
- если доступ запрещен вызывается функция `BaseController::forbidden`
- если доступ разрешен выполняется логирование, а затем запрашиваемое действие


##AR Модели Rbac

Средств `CPhpAuthManager` достаточно для работы с базой.
Однако для хранения сложной логики и реализации административного интерфейса
созданы `AR` модели для таблиц БД: `AuthAssignment`,`AuthItem`,`AuthItemChild`

Опишем некоторые функции которые есть в данных моделях.

`AuthAssignment::getUsersIds($roles)` - для массива ролей возвращает список пользователей имеющих данные роли
`AuthItemChild::constructName($controller_id, $action_id)` - формирует имя операции для по `id` контроллера и экшна
`AuthItemChild::getAllowedTasks($role)` - для роли возвращает массив разрешенных задач

##Методы модуля Rbac

- `public static function isAllow($item_name)` - проверяет доступ для текущего пользователя.
- `public static function isItemAllow($role, $item_name, $module = null)` - проверяет доступ для произвольной роли
- `public static function isObjectAllow($model_id, $object_id, $action)` - проверяет доступ к объекту для
текущего пользователя
- `public static function isObjectItemAllow($role, $model_id, $object_id, $action)` - проверяет разрешено
ли данное действие с объектом для заданной роли

##Разграничение доступа для конкретных объектов.

Зачем это нужно? Например: для каждой категории новостей своя группа редакторов

Модель одна `NewsSection`, `action` который отвечает за редактирование новостей так же один.
Но редакторы одной категории не должны иметь доступа к редактированию другой.

Для реализации этого функционала используется модель `AuthObject` модуля `Rbac`.

**Пример:** таблица `AuthObject`:


object_id    |     model_id     |     role              |    action
-------------|------------------|-----------------------|--------------
    2	     |    NewsSection	|     admin             |     Edit
    2	     |    NewsSection	|     admin	            |     View
    2	     |    NewsSection	|     admin_sertifikate	|     Edit
    2	     |    NewsSection	|     admin_sertifikate	|     View
    2	     |    NewsSection	|     admin_sklad		|     Edit
    2	     |    NewsSection	|     admin_sklad		|     View
    2	     |    NewsSection	|     admin_tarif		|     View
    2	     |    NewsSection	|     diller		    |     View


**Список функции модели `AuthObject`**

- `public function getObjectsIds($model_id, $action, $role)` - Для заданных значений модели, действия и
роли возвращает список разрешенных `id`
- `public function getRolesNames($model_id, $object_id)` - Для заданных модели и `id`
возвращает список ролей которые имеют


**Служебные функции модели `AuthObject`**

- `public static function addObjectsAndAllowToAll($objects)` -  для всех переданных объектов добавляет
записи в БД и разрешает все действия с ними всем ролям




##API Rbac и назначение прав

Для назначения прав нужно пройти по адресу `/rbac/roleAdmin/manage` выбрать роль, после чего можно будет
назначить права доступа для различных модулей связанных с меню сайта.

Что бы добавить в ваш модуль возможность разграничения прав, нужно что бы главный файл вашего модуля
реализовывал функцию `getTasksDataProvider` которая будет возвращать ArrayDataProvider тех задач,
ограничение на которые вы бы хотели регулировать. Элементы массивов могут быть 2-х видов:


~~~
[php]
//для ограничения доступа к объектам
array(
    'id'        => 'NewsSection_' . $obj->id,
    'model_id'  => 'NewsSection',
    'object_id' => $obj->id,
    'title'     => $obj->name
);

//для ограничения доступа к задачам, которые вы хотите использовать в коде
array(
    'id'        => 'SecretNews_View',
    'task_id'   => 'SecretNews_View',
    'title'     => $obj->name
);
~~~

Пример реализации функции `getTasksDataProvider`:

~~~
[php]
public function getTasksDataProvider()
{
    $objects = NewsSection::model()->findAll();  //установим возможность разграничения прав для категорий новостей
    $items   = array();
    foreach ($objects as $obj)
    {
        $items[] = array(
            'id'        => 'NewsSection_' . $obj->id,
            'model_id'  => 'NewsSection',
            'object_id' => $obj->id,
            'title'     => $obj->name
        );
    }

    return new CArrayDataProvider($items);
}
~~~

##FAQ:

**Как получить всех пользователей, которым разрешен доступ к данному объекту?**

- `AuthObject::public function getRolesNames($model_id, $object_id)` - получаем роли имеющие доступы к объекту.
- `AuthAssignment::public function getUsersIds($roles)` - получаем всех ползователей для данных ролей.




