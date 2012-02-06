#Модуль: Каталог продукции (products)

##Модели

- Category - Категории товаров
- Product - Продукты
- ProductProperties - Произвольные свойства продуктов (их может быть сколько угодно)
- Metadata - Данные о том какие свойства имеют товары принадлежащие к данной категории
- PropertyGroup - Группа свойств (иногда их нужно группировать для дизайна или удобства)
- PropertyValidator - Правила проверки, которым будут должны удовлетворять свойства

- Producer - Производители
- ProductVariant - Варианты товара (например размеры у одежды), каждый вариант имеет свою цену.

**Пояснения к моделям**

В корзину ложится именно модель ProductVariant - т.к. она имеет цену.

Каждый товар может принадлежать сразу нескольким категориям Many_Many

**Metadata**

- `public static function constructValidators($categories = null, $metadatas = null)`
Конструирует rules для ProductProperties.
Принимает либо категории к которым принадлежит товар, либо массив моделей Metadata

- `public static function getAllMetadata($groups = null)`
возвращает метаданные пренадлежащие заданным группам в массиве, исключает повторы

- `public static function getFormElements($groups = null, $metadatas = null)`
Конструирует форму для ProductProperties.
Возвращает массив элементов формы

- `public static function getForm($parent_form, $groups)`
Встраивает в заданную форму поля для редактирования динамических данных
Возвращает: конфигурацию формы с динамическими параметрами
Пример использования:

~~~
[php]
$form_data = Metadata::getForm('products.ProductForm', $product->categories);
$form = new BaseForm($form_data);
//т.к. используется механизм подформ Yii, то к модели ProductProperties можно будет обратиться таке:
$form['properties']->model;
//а к модели Product так:
$form['product']->model
~~~

**ProductProperties**

- `public function getAllMetadata()`
возврящает все матаданные для данной модели свойств товара, сгруппированный по group_id.
Пример вывода свойств:

~~~
[php]
foreach ($product->all_metadata as $group_id => $group)
{
    $gr = PropertyGroup::model()->findByPk($group_id);
    echo CHtml::tag('h2', array(), $gr->title);

    $prop_html = '';
    foreach ($group as $item)
    {
        $prop_html .= $item->title . ': ' . $product->getProperty($item->name);
        $prop_html .= '<br/>';
    }
    echo CHtml::tag('p', array(), $prop_html);
}
~~~


**Product**

- `public function getAllRelevantProducts()`
Товары можно связывать друг с другом.
Возвращает все связанные товары с данным.

- `public function inCategory($category)`
Scope - который принимает объект Category и ограничивает выборку товаров только товарами из данной категории

- `public function autocomplete($term)`
Scope - который принимает строку и ограничивает выборку товаров только товарами,
название которых содержит эту подстроку, используется для jQuery.UI.Autocomlete

- `public function getReadablePrice()`
Возвращает удобную для чтения цену товара.
Если копейки = 0, то выводиться они не будут
Если копейки != 0, то выводиться будут только 2 первыйх разряда

- `public function getProperty($property_name)`
Специальная прокси функция, которая позволит подменять хранилища свойств
доступ к свойствам должен осществляться только через нее
Возвращает значение свойства

- `public function getAllMetadata($grouping = false)`
Возврящает массив моделей Metadata - всех динамических свойств

- `public function getAllPropertiesArray()`
Возвращает array вида {название свойства}=>{значение свойства}

**Category**

- `public function getNbspTitle()`
Возвращает название категории с `($this->depth - 1) * 3` - знаками &nbsp; в начале.
Ее можно использовать для простого табличного вывода

- `public static function getHtmlTree()`
Возвращает дерево в виде вложенных списков. Не использует рекурсию.

**Дополнительные Модели**

- ColumnModel - Модель используемая для создания и редактирования колонок в БД.
        Имеет API подобный ActiveRecord, но вместо insert, update, delete использует соответствующий Alter синтаксис
        Инкапсулирует в себе все нужные валидатори, предоставляет поддержку событий.

*Сейчас часть логики по управлению столбцами все еще находится в модели Metadata, но ее нужно полностью перенести в ColumnModel*

**Остальныме модели являются тривиальными**


##Компоненты

###Компоненты Админки

**AllInOneInput**
Разбивает содержимое текста по delimeter, и превращает части в набор кнопок.
При сабмите и валидации формы на сервер приходит строка, соединенная по delimeter.
Поддерживается сортировка, удаление и добавление новыйх элементов.
Применяется для хранения множеств, в текстовых полях.
Пример использования:
~~~
[php]
'items' => array('type' => 'AllInOneInput'),
~~~

**NestedTree**
Компонент для отображения и сортировки NestedSet деревьев.
Пример использования:
~~~
[php]
$this->widget('products.portlets.NestedTree', array(
    'model'    => Category::model(),
    'sortable' => true,
    'id'       => 'category_sorting'
));
~~~

**MultiAutocomplete**
Доработанный UI.Autocomplete, выборанные элементы преобразуются в кнопки, которые можно удалять.
Работает подобно multiselect

**PriceColumn**
Колонка отвечающая за вывод и редактирование цен. Если у нас есть несколько вариантов цен, то по умолчанию
выводится только первая и при редактировании изменяются цены для всех вариантов. Но можно перейти в полный
режим, в котором доступны для изменения отдельные варианты товара.



###Компоненты Клиента

**CartGrid**
Компонент, который выводит таблицу купленных товаров.
Используется для регистрации нужных скриптов, и вывода статистики в summary
Пример создания DataProvider'a для элементов корзины:
~~~
[php]
$positions = Yii::app()->cart->getPositions();
$dp        = new CArrayDataProvider(array_values($positions), array(
    'id'        => 'cart-summary',
    'pagination'=> false
));
~~~

**ChangeQuantityColumn**
Колонка, для изменения количества купленных товаров. Доступны стрелочки +1/-1 и поле ввода, куда можно вписать только цифры

**TreeGridView**
Используется для представления деревьев в табличном виде, с возможностью скрытия поддеревьев.


##Сохранение данных

**WithRelatedBehavior**
Поведение, которое сохраняет связанные модели, при этом работа с внешними ключами полностью автоматизируется.
Подробную документацию можно скачать [здесь]: (http://yiiext.github.com/extensions/with-related-behavior/readme.ru.html)
Этот компонент всегда разрывал связи преред сохранением, пришлось это изменить,
что бы иметь возможность хранить данные в промежуточных таблицах(например порядок сортировки продуктов внутри категории)
Так же в поведение был добавлен метод clear, который разрывает связи между моделями

~~~
[php]
//Пример сохранения модели Product
if ($form->submitted('submit'))
{
    $product                    = $form['product']->model;
    $product->properties        = $form['properties']->model;
    $product->categories        = Category::model()->findAllByPk($product->categories);
    $product->relevant_products = Product::model()->findAllByPk($product->relevant_products_arr);

    $saved = $product->withRelated->save(false, array(
        'properties', 'categories', 'relevant_products'
    ));

    if ($saved)
    {
        $this->redirect($this->url('manage'));
    }
}
//При этом нужно оставить только те связи которые пришли с клиента
//Это относится только к Many_Many связям.
public function beforeSave()
{
    if (parent::beforeSave())
    {
        if (!$this->isNewRecord)
        {
            $this->withRelated->clear(array(
                'categories'        => $this->categories, // что бы не терлись данные, которые находятся в смежной таблице
                'relevant_products' => array(),           // удаляем все, потому что связи у нас двусторонние, а значит нужно избежать дублирования
                'depend_products'   => array()            // и в другую сторону то же самое
            ));
        }
        return true;
    }
    return false;
}

//А так же не забыть соблюсти целостность внешних ключей перед удалением
//Иначе MySql не даст нам удалить запись
public function beforeDelete()
{
    if (parent::beforeDelete())
    {
        try
        {
            if ($this->properties)
            {
                $this->properties->delete();
            }

            $this->withRelated->clear(array(
                'categories'        => array(),
                'relevant_products' => array(),
                'depend_products'   => array()
            ));

            return true;
        } catch (CException $e)
        {
            $this->rollback($e);
        }
    }
    return false;
}
~~~


**API Корзины**

Контроллер CartController имеет следующие action'ы:

- `public function actionPut($id, $quantity = 1)`
- `public function actionUpdate($id, $quantity)`
- `public function actionRemove($id)`
- `public function actionManage()`

Все action'ы принимают $id в формате `IECartPosition::getId()`, т.е. `ModelClass_ObjectId(ProductVariant_159)`
Подробно компонент cart рассмотрен [здесь](http://yiiext.github.com/extensions/shopping-cart-component/readme.ru.html)



