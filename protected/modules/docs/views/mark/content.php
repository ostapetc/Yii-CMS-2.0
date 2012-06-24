#Модуль: content (контент) {#content}

Модуль служит для предоставления базового функционала приложения.
- меню
- статические страницы
- виджеты обработки текста

##Модели

- `Menu` - Меню
- `MenuSection` - Отдельная ссылка в меню. NestedSet - дерево с множеством корней.
- `Page` - Статическая страница.
- `PageBlock` - Блок текста. Используются они для вывода текста,
    который встречается в одном месте, и не зависит от других моделей. Например: Seo-тексты

##Портлеты

**Truncate**

Обрезает `$content` используя плагин [jTruncate](http://www.jeremymartin.name/projects.php?project=jTruncate)
~~~
[php]
$this->widget('content.portlets.Truncate', array(
    'id' => 'index_text',
    'content' => $content
    'options' => array(
        'length' => 1200
    )
))
~~~

**TopMenu**

Портлет для создания основного меню навигации, содержит несколько алгоритмов определения текущего активного пункта меню.

**NestedTree**

Используется для реализаци сортировки `NestedSet` деревьев.

Пример использования:

~~~
[php]
$this->widget('content.portlets.NestedTree', array(
    'model'    => MenuSection::model(),
    'sortable' => true,
    'root_id'  => $root_id,
    'id'       => 'category_sorting'
));
~~~