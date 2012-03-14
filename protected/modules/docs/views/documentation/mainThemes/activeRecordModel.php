#ActiveRecordModel

###Labels для атрибутов  {#labels}

`Labels` для атрибутов берутся из комментариев к полям в БД


###Scopes  {#scopes}

По умолчанию доступны следующие `scopes`:

~~~
[php]
public function limit($num)
public function offset($num)
public function in($row, $values, $operator = 'AND')
public function notIn($row, $values, $operator = 'AND')
public function notEqual($param, $value)
public function last()
public function published()
public function ordered()
~~~

###Подключаемые поведения  {#behaviors}

По умолчанию всегда подключены следующие поведения:

- `NullValueBehavior` - записывает `null` в пустые поля для которых есть `allowNull`
- `UserForeignKeyBehavior` - `если имеется не заданный атрибу `user_id`, то он устанавливается в Yii::app()->user->id
- `UploadFileBehavior` - автоматически загружает файлы
- `DateFormatBehavior` - автоматически форматирует даты нужным образом
- `TimestampBehavior` - автоматически выставляет значения `date_create` и `date_update`
- `MaxMinBehavior` - содержит функции поиска максимума/минимума по заданному атрибуту


###Дополнительные функции добавляемые поведениями  {#additional_funcitons}

**MaxMinBehavior**

- `public function min($attr)` - находит минимум в БД для заданного атрибута модели
- `public function max($attr)` - находит максимум в БД для заданного атрибута модели

**UploadFileBehavior**

Позволяет использовать следующий синтаксис в моделях для автоматической загрузки файлов

~~~
[php]
public function uploadFiles()
{
    return array(
        'photo' => array('dir' => self::PHOTOS_DIR)
    );
}
~~~


###Возможность использования "негорбатого" стиля  {#non_camel_style}

Добавлена поддержка "негорбатого" написания полей класса,
т.е. для геттера вида `getUserInfo` вы можете писать `$model->user_info`,
и геттер отработает.
Для сеттеров ситуация аналогичная.
