<?php
$this->beginWidget('CMarkdown', array('purifyOutput'=> true));
?>
#Примеры для верстальщиков


#####Хлебные крошки

~~~
[html]
<div class="breadcrumbs">
    <a href="">Статьи</a>
    <span> / </span>
    <a href="">Личное</a>
    <span> / </span>
    <span class="current">Как я провел лето</span>
</div>
~~~



Для того, что бы упростить задачу верстальщикам и программистам, у нас есть базовый каркас
страницы. Смысл его не в том, что бы жестко ограничить верстку, а в том, что бы верстальщики
пользовались одними и теми же идентификаторами. Всякое в жизни бывает: у сайта может не быть
шапки или футера, но если они есть, то используйте индентификаторы из этого файла.
    
####Обязательные требования:

1. strict doctype
2. utf-8
3. Используйте комментарии в css файлах. Не нужно описывать все, но хотябы главные
блоки и стили разных страниц, обозначить нужно
4. Используйте комментарии в HTML коде. Особенно удобно, когда указывается что закрывает `</div>`
Мой редактор мне показвает, что закрывает каждый див, даже если открывающийся тег за границами экрана
Но все равно удобно, когда есть комментарии.    
5. Классы именуются через дефис, НЕ через подчеркивание.
6. Мы используем @import url("reset.css");

~~~
[html]
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="main-menu"></div>
    </div>
    <div class="content">
        <div class="breadcrumbs"></div>
        <div class="sidebar-left"></div>
        <div class="sidebar-right"></div>
    </div>
    <div id="footer">
        <div class="copyright"></div>
        <div class="social"></div>
        <div class="developers">Сделано в <span>ООО "Арт Проект"</span><br/>
            <a href="http://kupitsite.ru" target="_blank">
                Разработка автоматизированных систем управления
            </a>
        </div>
    </div>
</div>
</body>
</html>
~~~

##reset.css##

~~~
[css]
*{
    margin:0;
    padding:0
}

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, dialog, figure, footer, header,
hgroup, nav, section {
    border: 0; outline: 0;
    font: inherit;
    font-size: 100%;
    vertical-align: baseline;
    background: transparent
}
body { line-height: 1 }
ol, ul { list-style: none }

/* не забудьте каким-либо образом подчеркнуть или выделить вставки! */
ins { text-decoration: none }
del { text-decoration: line-through }

/* tables должен иметь 'cellspacing="0"' в разметке */
table { border-collapse: collapse; border-spacing: 0 }
table, th, td { vertical-align: middle }

/* это помогает придать HTML5 элементам поведение DIV блоков в старых браузерах*/
article, aside, details, figcaption, figure, dialog,
footer, header, hgroup, menu, nav, section {
    display:block
}

/* float:none защищает span-x классы неверного отображения table-cell */
caption, th, td {
  text-align: left;
  font-weight: normal;
  float:none !important
}

/* Удаляем возможные кавычки (") из <q>, <blockquote>. */
blockquote:before, blockquote:after, q:before, q:after { content: ''; }
blockquote, q { quotes: "" ""; }

/* Удаляем окаймление изображений, которые находятся в ссылках.
я намеренно использовал img, а не a img, потому что в этом случае браузер не будет для каждой картинки
проверять, находится ли она в а. Это ускоряет отрисовку.
*/
img { border: none; outline: none;}

/* Не забудьте определить свой собственный стиль для focus! */
:focus { outline: 0; }
~~~


##Таблица классов (используйте их)

Класс               | Назначение
--------------------| -------------
**Шапка сайта**     |
header              | враппер
logo                | логотип
tel                 | телефон
breadcrumbs         | хлебные крошки, содержит в себе теги a, span.
main-menu           | главное меню
                    |
**Футер**           |
footer              | враппер
copyright           | права обладателя
developers          | разработчики
social              | ссылки на социальные сети
last                | последний (не используйте :last-child)
first               | первый (не используйте :first-child)
                    |
**Вспомогательные** |
odd                 | нечетный
even                | четный
close               | ссылка закрытия модального окна или чего-то подобного
open                | ссылка открытия модального окна или чего-то подобного
language-switcher   | панелька переключения языков
ru                  | русский
en                  | английский
divider             | разделитель
                    |
**Социальные сети** |
vkontakte           |
moi-mir             |
facebook            |
odnoklassniki       |
livejournal         |
myspace             |
twitter             |
yandex              |
google-plus         |
                    |
**Отображение статей**|
article-title       | заголовок статьи, при ее полном отображении
article-link        | ссылка на статьи, заголовок новости при отображении списка новостей
article-content     | контент статьи, при отображении списка новостей
article-full-content| контент статьи, при ее полном отображении
article-more        | ссылка на статью, заголовок новости при отображении списка новостей
article-date        | дата написания статьи
article-author      | автор статьи
article-subtitle    | подзаголовок статьи
article-section     | раздел, которому принадлежит статья
                    | для подобных разделов, но с иным дизайном используйте этот же принцип построения селекторов: news-title, если дизайны схожие лучше использовать одни селекторы.
                    |
**Комментарии/Отзывы**     |
hreview             | враппер
version             | версия
summary             | заголовок отзыва или краткая аннотация
reviewer            | отавивший отзыв
dtreviewed          | дата написания
rating              | рейтинг комментариев
permalink           | класс тега a, который является ссылкой на полный текст отзыва или якорь на странице для легкого нахождения комментария
                    |
**Продукты**        |
hproduct            | враппер
name                | название товара
brand               | брэнд
category            | категория
price               | цена
description         | описание
photo               | фото
url                 | ссылка на полное описание продукта, может содержать rel='product'
review              | отзывы о продукте
quantity	        | Количество товаров, доступных в рамках данного предложения
seller              | продавец товара
currency            | Валюта, в которой указана цена товара
listing             | Здесь указываем кто продает данный товар, когда товар будет доступен и т.д.
                    |
**События**         |
location            | местоположение
url                 | ссылка на страницу, связанную с событием
dtend               | дата окончания
duration            | продолжительность
description         | Расширенное описание
                    |
**Координаты**      |
Формат такой        | `<div class="geo">Йеллоунайф: <span class="latitude">62.442</span>; <span class="longitude">-114.398</span></div>`
                    |
**Адреса**          |
postal-code         | почтовый код
country-name        | название страны
region              | регион
street-address      | улица(дом, улица, квартира и прочее мелкое)
region              | штат/автономный округ/федерация
                    |
**Резюме**          |
hResume             | враппер
title               | Специальность
summary             | Квалификация, достигнутые цели
affiliation         | принадлежность к компании
contact             | контакты
education           | образование
experience          | опыт
skill               | дополнительные навыки
description         | Описание

\* комбинировать классы из этой таблицы не нужно.
Т.е. не делайте селекторы вида header-logo,
вместо этого используйте .header .logo


####Постраничная навигация

1. Можно удалять слова Первая/Предыдущая и т.п.
    но все равно нужно будет описать стиль hidden. (что бы не занимали место всякие паддинги)  
2. Стили для этого виджета описываются в отдельном файле: pager.css

<div class="pager">
<ul class="yiiPager">
<li class="first hidden"><div class="nav_left"></div><div class="nav_center"><a href="">Первая</a></div><div class="nav_right"></div></li>
<li class="previous hidden"><div class="nav_left"></div><div class="nav_center"><a href="">Предыдущая</a></div><div class="nav_right"></div></li>
<li class="page selected"><div class="nav_left"></div><div class="nav_center"><span>1</span></div><div class="nav_right"></div></li>
<li class="page"><div class="nav_left"></div><div class="nav_center"><a href="">2</a></div><div class="nav_right"></div></li>
...
<li class="next"><div class="nav_left"></div><div class="nav_center"><a href="">Следующая</a></div><div class="nav_right"></div></li>
<li class="last"><div class="nav_left"></div><div class="nav_center"><a href="">Последняя</a></div><div class="nav_right"></div></li>
</ul>
</div>

~~~
[html]
<div class="pager">
<ul class="yiiPager">
<li class="first hidden"><div class="nav_left"></div><div class="nav_center"><a href="">Первая</a></div><div class="nav_right"></div></li>
<li class="previous hidden"><div class="nav_left"></div><div class="nav_center"><a href="">Предыдущая</a></div><div class="nav_right"></div></li>
<li class="page selected"><div class="nav_left"></div><div class="nav_center"><span>1</span></div><div class="nav_right"></div></li>
<li class="page"><div class="nav_left"></div><div class="nav_center"><a href="">2</a></div><div class="nav_right"></div></li>
...
<li class="next"><div class="nav_left"></div><div class="nav_center"><a href="">Следующая</a></div><div class="nav_right"></div></li>
<li class="last"><div class="nav_left"></div><div class="nav_center"><a href="">Последняя</a></div><div class="nav_right"></div></li>
</ul>
</div>
~~~
    
~~~
[css]
ul.yiiPager
{
    text-align: center;
    display: block;
    padding: 5px 0 5px;
}

ul.yiiPager *
{
	display:inline;
}

ul.yiiPager span{
    background: #9aafe5;
    width:20px;
    height:19px;
    text-align: center;
    color:#FFF;
    font-size: 14px;
    padding:1px 6px;
}

ul.yiiPager a:link,
ul.yiiPager a:visited
{
    text-decoration: none;
    color:#272727;
    font-size: 14px;
    width: 20px;
    height:19px;
    text-align: center;
}

ul.yiiPager .page a
{
    padding:1px 6px;
	font-weight:normal;
}

ul.yiiPager a:hover
{
    text-decoration: underline;

}

ul.yiiPager .hidden a
{
	/*border:solid 1px #DEDEDE;*/
	color:#888888 !important;
    display: none;
}

/**
 * Hide first and last buttons by default.
 */
ul.yiiPager .first,
ul.yiiPager .last
{
	/*display:none;*/
}
~~~
    

####Постраничная алфавитная навигация
1. Внутри каждой буквы может потребоваться отдельная постраничная навигация,
		поэтому нужно заранее продумать как она будет выглядеть
		обычно в верстке это выглядит так:  
		`<div class="pager"><ul class="yiiPager">...</ul></div>`  
		`<div class="alphaPager"><ul class="yiiAlphaPager">...</ul></div>`
2. Стили для этого виджета описываются в отдельном файле: alphapager.css

<div class="alphaPager">
<ul class="yiiAlphaPager">
<li class="page hidden"><div class="wrap_alpha"><span>А</span></div></li>
<li class="page"><div class="wrap_alpha"><a href="">Б</a></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>В</span></div></li>
...
<li class="page hidden"><div class="wrap_alpha"><span>Э</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Ю</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Я</span></div></li>
<br/>
<li class="page hidden"><div class="wrap_alpha"><span>A</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>B</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><a href="">C</a></div></li>
...
<li class="page hidden"><div class="wrap_alpha"><span>X</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Y</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Z</span></div></li>
<li class="all selected"><div class="wrap_alpha"><a href="">#</a></div></li>
</ul>
</div>

~~~
[html]
<div class="alphaPager">
<ul class="yiiAlphaPager">
<li class="page hidden"><div class="wrap_alpha"><span>А</span></div></li>
<li class="page"><div class="wrap_alpha"><a href="">Б</a></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>В</span></div></li>
...
<li class="page hidden"><div class="wrap_alpha"><span>Э</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Ю</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Я</span></div></li>
<br/>
<li class="page hidden"><div class="wrap_alpha"><span>A</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>B</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><a href="">C</a></div></li>
...
<li class="page hidden"><div class="wrap_alpha"><span>X</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Y</span></div></li>
<li class="page hidden"><div class="wrap_alpha"><span>Z</span></div></li>
<li class="all selected"><div class="wrap_alpha"><a href="">#</a></div></li>
</ul>
</div>
~~~

~~~
[css]
ul.yiiAlphaPager
{
	font-size:11px;
	border:0;
	margin:0;
	padding:0;
	line-height:200%;
	display:block;
    text-align:center
}
ul.yiiAlphaPager *
{
	display:inline;
}
ul.yiiAlphaPager a, ul.yiiAlphaPager span {
    padding:1px 6px;
}
ul.yiiAlphaPager a:link,
ul.yiiAlphaPager a:visited
{
	font-weight:bold;
	color:#0e509e;
	text-decoration:none;
}
ul.yiiAlphaPager .page a
{
	font-weight:normal;
}
ul.yiiAlphaPager a:hover{}
ul.yiiAlphaPager .hidden a
{
    color:#888888;
}
ul.yiiAlphaPager .selected span
{
	color:#FFF;
    background: #0e509e;
}
//ul.alphaPager .all { display:none; } это класс кнопки при нажатии на которую выведутся все статьи
~~~


####Хлебные крошки
1. Разделитель можно менять.



~~~
[html]
<div class="breadcrumbs">
    <a href="">Статьи</a>
    <span> / </span>
    <a href="">Личное</a>
    <span> / </span>
    <span class="current">Как я провел лето</span>
</div>
~~~


  


####Формы
1. при необходимости можно заносить содержимое label внутрь input
2. js не должен обращаться к
<э></э>лементам формы через id или name.
3. используйте [type=text] для обращения к элементам формы

~~~
[html]
<div class="form">
    <form enctype="multipart/form-data" action="" method="post">
        <dl class="inline">
            <dd>
                <div class="dropdownlist">
                    <select>
                        <option value="">Вид объекта</option>
                        <option value="1">Жилой</option>
                        <option value="2">Не жилой</option>
                    </select>
                </div>
            </dd>
        </dl>
        <dl class="inline">
            <dd>
                <input type="text" value="Обслуживающая компания" />
            </dd>
        </dl>
        <br/>
        <dl class="inline">
            <dd>
                <div class="dropdownlist">
                    <select>
                        <option value="">Расположение</option>
                        <option value="1">Москва</option>
                        <option value="2">Московская Область</option>
                    </select>
                </div>
            </dd>
        </dl>
        <dl class="inline">
            <dd>
                <input type="text" value="Расстояние до МКАД, км"/>
            </dd>
        </dl>
        <dl>
            <dd>
                <div class="attach">
                    <input class="file_fake" type="text" readonly="readonly" value="План помещения"/>
                    <span class="file" title="Выбрать файл">
                        <input type="hidden" value="" />
                        <input type="file"/>
                        <input type="button" class="file_select_btn" value=""/>
                    </span>
                </div>
            </dd>
        </dl>
        <dl>
            <dd>
                <input type="text" value="Общий метраж"/>
            </dd>
        </dl>
        <dl>
            <dd>
                <textarea>Комментарий</textarea>
                <span class="counter">Осталось 20 символов</span>
            </dd>
        </dl>
        <dl>
            <dd>
                <div class="buttons">
                    <input value="Отправить" type="submit"/>
                </div>
            </dd>
        </dl>
    </form>
</div>
~~~

~~~
[css]
form dl {
    display: block;
    margin: 0 0 8px;
    padding: 5px 0 0 0;
}

form dl.inline {
    display: inline-block;
}

form dl.hide {
    display: none;
}

form a {
    display: block;
}

form input[type=text], form textarea, form inpu[type=submit], form div.dropdownlist {
    border: none;
    display: block;
    outline: none;
}

form input[type=text], form textarea, form div.dropdownlist, form div.dropdownlist *{
    font: 11px/1.8em Tahoma, sans-serif;
    color: #353535;
}

form input[type=text] {
    width: 183px;
    height: 31px;
    background: url(images/input.png) no-repeat;
    margin: 0;
    padding: 0 8px;
    overflow: hidden;
    position: relative;
}

form textarea {
    width: 384px;
    height: 110px;
    background: url(images/textarea.png) no-repeat;
    padding: 8px;
    margin: 0 0 23px 0;
}

form input[type=submit] {
    width: 103px;
    height: 27px;
    background: url(images/submit.png) no-repeat;
    font-size: 14px;
    color: #000;
    line-height: 2;
    margin: 0 0 35px 0;
    text-align: center;
    cursor: pointer;
}

form input[type=submit]:hover {
    background: url(images/submit_hover.png) no-repeat;
}

form div.dropdownlist {
    width: 183px;
    height: 31px;
    background: url(images/input.png) no-repeat;
    padding: 0 8px;
    margin: 0 20px 0 0;
}

form select {
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    height: 20px;
    margin: 6px 0 0 0;
    outline: medium none;
    padding: 0;
    width: 185px;
}

form select option {
    background: #fff;
}

/*надпись "осталось столько-то символов" и ошибки*/
form .counter, form .errorMessage {
    color: #C00;
}

form .file-input-box {
    position: relative;
    width: 287px;
    height: 31px;
    background: url(images/input_file.png) no-repeat right top;
    cursor: pointer;
}

form .file-input {
    position: absolute;
    right: 0;
    top: 0;
    width: 287px;
    height: 31px;
    font-size: 99px;
    cursor: pointer;
    filter: alpha(opacity = 0);
    filter: progid:DXImageTransform.Microsoft.Alpha(opacity = 0); /* IE 5.5+*/
    -moz-opacity: 0; /* Mozilla 1.6 и ниже */
    -khtml-opacity: 0; /* Konqueror 3.1, Safari 1.1 */
    opacity: 0; /* CSS3 - Mozilla 1.7b +, Firefox 0.9 +, Safari 1.2+, Opera 9 */
}

form input.input-middle {
    width: 97px !important;
    background: url(images/input_middle.png) no-repeat !important;
}
~~~


    
    
##Рекомендации:

1. Мы ничего не верстаем таблицами... кроме таблиц.
        нечто можно назвать таблицей, если у нее есть хотябы заголовки у всех колонок.
        Иначе используем дивную верстку.
2. Верстка в этом документе приведена со стандартными классами
        менять их дело не сложное, но бессмысленное, поэтому делать это не нужно
3. Старайтесь не использовать атрибут id
    > во-первых любые из приведенных ниже элементов могут встретиться на странице 2 раза
        и в этом случае придется копипастить стили для другого id
    > во-вторых для многих элементов система генерурет id сама, нет смысла создавать конфликты
4. Зеленый свет html валидатора: http://validator.w3.org/#validate_by_input
5. Зеленый свет css валидатора: http://jigsaw.w3.org/css-validator/#validate_by_input
6. Используйте понятные имена классов, которые несут смысловую нагрузку, но не
    говорят о том, как элемент выглядит. Т.е. использование слов big, gray, bold, small
    и т.д. не рекомендуется. Весь смысл css в том, что бы отделить дизайн от структуры
    и при изменении дизайна small-title - может стать большим жирным красным... извращений много
7. Если нужно вывести текст заглавными буквами используйте uppercase
8. Старайтесь придерживаться логического порядка элементов. Т.е. если сайдбар идет после
    контента, то и в верстке он должен быть после контента. Это всего лишь рекомендация.
9. Для форм используйте: input[type=val](использовать [att~=val],[att|=val],[att^=val] думаю не стоит)
10. block элементы не должны располагаться в inline элементах (это bad practices)



<?php
$this->endWidget();
?>