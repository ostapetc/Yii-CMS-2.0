#Виджеты для форм:

Все виджеты для форм находятся в директории `application.components.formWidgets`

###Список алиасов  {#aliaces}

Списоки алиасов ядра прописываются в файлах: `AdminFormInputElement` и `ClientFormInputElement`

Алиас используемый в форме | Реальный виджет
---------------------------|---------------------------------------------
`checkbox`                 | `IphoneCheckbox`
`alias`                    | `AliasField`
`captcha`                  | `Captcha`
`all_in_one_input`         | `EMultiSelect`
`multi_select`             | `AllInOneInput`
`multi_autocomplete`       | `MultiAutocomplete`
`date`                     | `FJuiDatePicker`
`editor`                   | `TinyMCE`
`autocomplete`             | `zii.widgets.jui.CAutoComplete`
`meta_tags`                | `main.portlets.MetaTags`
`file_manager`             | `fileManager.portlets.Uploader`


###Общий список виджетов  {#widgets}

Виджет                              | Зачем нужен
------------------------------------|---------------------------------------------------------------------------
`checkbox`                          | Красивый чекбокс. [источник](http://awardwinningfjords.com/2009/06/16/iphone-style-checkboxes.html)
`multi_select`                      | Функциональный мультиселект. [источник](http://quasipartikel.at/multiselect/)
`multi_autocomplete`                | Автокомплит с возможностью выбора нескольких вариантов, мультиселект для большого объема данных
`alias`                             | Автогенерация `url` и алиасов
`chosen`                            | Украшение выпадающего списка
`date`                              | `jQuery.UI.DatePicker` с возможностью задания диапазона дат.
`editor`                            | Редактор текста
`autocomplete`                      | `jQuery.UI.Autocomplete`
`file_manager`                      | Загрузка серии файлов
`all_in_one_input`                  | Редактирование текстовой информации с разделителями(например ';')
`main.portlets.MetaTags`            | Добавление метатегов к записям


###Основные виджеты  {#basic_widgets}

- **alias**

Добавляет `disabled` поле в форму, автоматически заполняемую текстом из поля `source`, транслитерируя
перед этим текст из поля `source`. Нетекстовые символы и прочий мусор удаляются

Обязательный параметр `source` - имя атрибута источника

Скрытое поле выводится для того, что бы сохранить валидацию, т.к. `jquery.serialize и гнорирует `disabled` поля

Пример использования:

~~~
[php]
'title' => array('type' => 'text'),
'url'   => array('type' => 'alias', 'source' => 'title'),
~~~

- **file_manager**

Подробное описание находится в модуле [fileManager](/index.php/fileManager)

- **chosen**

Это просто украшение, настройки абсолютно такие же, как и при использование `dropdownlist`

- **main.components.AllInOneInput**

Используется для редактирования текста с разделителями. Вместо строки выводит набор элементов
которым можно удалять, сортировать, добавлять новые. При этом на сервер отправляется всегда
собранная из элементов строка через заданный разделитель.

- **multi_autocomplete**

Функциональный мультиселект для работы с большими объемами данных. Работает на базе jQuery.UI.Autocomplete

~~~
[php]
'categories' => array(
    'type'     => 'multi_select',
    'selected' => 'all_relevant_products',
    'url'      => '/products/productAdmin/productsAsJson'
),
~~~

- **multi_select**

Функциональный мультиселект: поддерживает сортировку, фильтрацию, массовое добавление/удаление

~~~
[php]
'categories' => array(
    'type'     => 'multi_select',
    'items'    => CHtml::listData(Category::model()->findAll(), 'id', 'title'),
    'onchange' => "js:function() {}",
    'hint'     => 'Текст который будет выведен во всплывающей подсказке'
),
~~~

- **main.portlets.MetaTags**

Добавляет 3 `input'а` в форму редактирования для того что бы ввести ключевые слова, описание и тайтл.


#Создание своих виджетов

Все виджеты наследуют классы `InputWidget` или `JuiInputWidget`

Для всех `JuiInputWidget` доступны дополнительные методы рендеринга:

- `public function renderDialog($view, $params = array(), $return = false)` - Выводит ссылку
по нажатию на которую отображается диалоговое окно с отрендеренным контентом. Параметры для
диалогового окна можно задать в `$params['dialogOptions']`. Набор параметров аналогичен `CJuiDialog`
текст ссылки задается через `$params['dialogOptions']['title']`;
Основной особенностью данного метода является то, что по умолчанию диалоговое окно в `DOM`-дереве
является дочерним элементом `body`, поэтому вывести часть формы в диалоговое окно невозможно,
т.к. при сабмите эта часть формы будет находиться вне тега `form`. Однако метод `renderDialog`
добавляет дополнительную логику, которая изначально помещает выведенный `html` внутрь `form`,
при открытии диалогового окна перемещает его из `form` в диалоговое окно,
и после закрытия диалогового окна, так же возвращает внутрь `form`.
Таким образом во время `submit`, выведенный `html` будет внутри `form`, хотя работать с ним
пользователь будет в модальном окне.