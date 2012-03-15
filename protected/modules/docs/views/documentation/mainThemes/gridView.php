#Компонент GridView

Этот стандартный компонент `yii`, который расширен функциями:
- Drag&Drop сортировки
- Форматирования дат
- Массового удаления записей
- Изменения количества выводимых на страницу записей

> **Примечание:**
Для административной панели используется компонент `AdminGrid`.
Методы настройки у него такие же, как у компонента `GridView`

###Drag&Drop Сортировка  {#sortable}

Для реализации обычной сортировки (записей между собой, либо записей
принадлежащих какой-то категории) нужно выполнить следующие шаги:

- Использовать класс `GridView` с параметром `sortable=>true`
- Добавить в модель поведение:
~~~
[php]
'sortable'    => array(
    'class'=> 'ext.sortable.SortableBehavior'
),
~~~
- В методе `search` модели установить поле по которому нужно сортировать:
`$criteria->order = $alias.'.order DESC';`

###Drag&Drop Сортировка в отношении Many_Many  {#many_many_sortalbe}

Бывает необходимо хранить порядок сортировки для каждой категории, при условии, что объекты
принадлежат категории через `Many_Many` отношение.

В таком случае в промежуточной таблице заводится поле `order`

- Использовать класс `GridView` с параметром `sortable=>true`
- Добавить в модель поведение:
~~~
[php]
'sortable'    => array(
    'class'=> 'ext.sortable.SortableBehavior'
),
~~~
- В методе `search` модели установить поле по которому нужно сортировать:
`$criteria->order = $alias.'.order DESC';`


###Массовое удаление   {#mass_removal}

- `mass_removal=>true`

###Подсказка о работе фильтров  {#hints}

- `filter_hint=>'Some text'`

###Вывод даты  {#dates}

Для вывода даты предусмотрена специальный класс колонки `DateColumn` ().
Она позволяет выводить даты в заданном формате, а так же предоставляет
возможность фильтрации записей по временному диапазону.

> **Примачание:** Пользовательский интерфейс не позволит быть начальной дате больше чем конечной.

Использование:
~~~
[php]
array(
     'class'=>"DateColumn",
     'name'=>'date',
),
~~~

Отправляются данные на сервер в виде `_{name}_start` и `_{name}_end` где `name` - имя атрибута.
Для возможности фильтрации по временному диапазону, нужно добавить в метод `search` модели:

~~~
[php]
$criteria = $this->addTimeDiapasonCondition($criteria, $attribute_name);
~~~

###Создание колонки со сложным клиентским поведением  {#your_column}

Для создания колонки со сложным клиентским поведением существует базовый плагин
`/js/packages/adminBaseClasses/gridBase.js` подключается автоматически.
Этот плагин берет на себя работу по синхронизации с плагином `yiiGridView`,
а так же предоставляет простой API для реализации на его основе своих плагинов.

Плагин изначально вызывает метод `_initHandlers` используйте его для инициализации
своих скриптов. После `ajaxUpdate`(метод `yiiGridView`) `_initHandlers` будет вызван
повторно, поэтому нет необходимости использовать live или delegate.

На одну таблицу можо вешать неограниченное количество плагинов основанных на CmsUI.gridBase.
Но, т.к. мы зависим от yiiGridView, то инициализация этих плагинов, должна произойти
после инициализации yiiGridView
Т.е. если вы хотите проинициализировать плагин из какой-либо колонки, то для этого в
компоненте GridView предусмотренно событие onRegisterScript.
В методе init колонки, используйте $this->grid->onRegisterScript = array($this, 'registerScript');
и в методе registerScript вашей колонки регистрируйте любые скрипты.

