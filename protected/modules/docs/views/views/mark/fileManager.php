[#big]
#Модуль: FileManager

Модуль содержащий в себе классы для загрузки, отображения, изменения файлов. Основная цель -
разграничение логики хранения файлов на жестком диске и их использованием(пользователь не знает
где на самом деле хранятся файлы).
Это позволяет ограничивать доступ к файлам и отдавать на скачивание под любым именем.

##Портлеты

**Uploader**

Любой модели вы можете добавить функциональность загрузки произвольного количества файлов.

- Добавьте в модель поведение:
~~~
[php]
'FileManager'     => array(
     'class'          => 'application.components.activeRecordBehaviors.AttachmentBehavior',
     'attached_class' => 'FileManager'
),
~~~

- Добавьте в модель relation:
~~~
[php]
'files'    => array(
    self::HAS_MANY,
    'FileManager',
    'object_id',
    'condition' => 'files.model_id = "' . get_class($this) . '" AND files.tag="files"',
    'order'     => 'files.order DESC'
)
//здесь tag - это группа файлов(тег). вы можете разделить файлы на группы (изображения, файлы, видео).
//Тогда для каждой группы нужно будет прописать свой relation.
//Задавайте одинаковые имена для relation и тега. Это упростит вам работу.
~~~

- Добавьте в форму элемент для массовой загрузки файлов:
~~~
[php]
'files' => array(                  //здесь files - имя relaion, которое вы задали в модели
    'type'      => 'file_manager',
    'data_type' => 'any',           //допустимые форматы файлов для загрузки. any|document|image|sound|video
    'title'     => 'Фото объектов',
    'tag'       => 'files'         //здесь тоже
)
~~~


**FileList**

Вывести загруженные файлы можно с помощью виджета:
~~~
[php]
$this->widget('fileManager.portlets.FileList', array(
    'model' => $model,
    'tag' => 'files'
))
~~~
Виджет уже содержит css стили и иконки форматов файлов


