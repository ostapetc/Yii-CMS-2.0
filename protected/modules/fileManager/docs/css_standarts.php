#Примеры для верстальщиков

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

/* remember to highlight inserts somehow! */
ins { text-decoration: none }
del { text-decoration: line-through }

/* tables still need 'cellspacing="0"' in the markup */
table { border-collapse: collapse; border-spacing: 0 }
table, th, td { vertical-align: middle }

/* This helps to make newer HTML5 elements behave like DIVs in older browers */
article, aside, details, figcaption, figure, dialog,
footer, header, hgroup, menu, nav, section {
    display:block
}

/* float:none prevents the span-x classes from breaking table-cell display */
caption, th, td {
  text-align: left;
  font-weight: normal;
  float:none !important
}

/* Remove possible quote marks (") from <q>, <blockquote>. */
blockquote:before, blockquote:after, q:before, q:after { content: ''; }
blockquote, q { quotes: "" ""; }

/* Remove annoying border on linked images.
я намеренно использовал img, а не a img, потому что в этом случае браузер не будет для каждой картинки
проверять, находится ли она в а. Это ускоряет отрисовку.
*/
img { border: none; outline: none;}

/* Remember to define your own focus styles! */
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

<div class="pager">Страницы:
    <ul class="yiiPager">
        <li class="first hidden"><a href="">Первая</a></li>
        <li class="previous hidden"><a href="">Предыдущая</a></li>
        <li class="page selected"><span>1</span></li>
        <li class="page"><a href="">2</a></li>
        <li class="next"><a href="">Следующая</a></li>
        <li class="last"><a href="">Последняя</a></li>
    </ul>
</div>

~~~
[html]
<div class="pager">Страницы:
    <ul class="yiiPager">
        <li class="first hidden"><a href="">Первая</a></li>
        <li class="previous hidden"><a href="">Предыдущая</a></li>
        <li class="page selected"><span>1</span></li>
        <li class="page"><a href="">2</a></li>
        <li class="next"><a href="">Следующая</a></li>
        <li class="last"><a href="">Последняя</a></li>
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
		<li class="all selected"><span>All</span></li>
		<li class="page"><a href="">А</a></li>
		<li class="page hidden"><span>Б</span></li>
		<li class="page hidden"><span>В</span></li>
		<li class="page hidden"><span>Г</span></li>
		<li class="page hidden"><span>Д</span></li>
		<li class="page hidden"><span>Е</span></li>
		<li class="page hidden"><span>Ё</span></li>
		<li class="page hidden"><span>Ж</span></li>
		<li class="page hidden"><span>З</span></li>
		<li class="page hidden"><span>И</span></li>
		<li class="page hidden"><span>Й</span></li>
		<li class="page hidden"><span>К</span></li>
		<li class="page hidden"><span>Л</span></li>
		<li class="page hidden"><span>М</span></li>
		<li class="page hidden"><span>Н</span></li>
		<li class="page hidden"><span>О</span></li>
		<li class="page hidden"><span>П</span></li>
		<li class="page hidden"><span>Р</span></li>
		<li class="page hidden"><span>С</span></li>
		<li class="page hidden"><span>Т</span></li>
		<li class="page hidden"><span>У</span></li>
		<li class="page hidden"><span>Ф</span></li>
		<li class="page hidden"><span>Х</span></li>
		<li class="page hidden"><span>Ц</span></li>
		<li class="page hidden"><span>Ч</span></li>
		<li class="page hidden"><span>Щ</span></li>
		<li class="page hidden"><span>Ш</span></li>
		<li class="page hidden"><span>Ь</span></li>
		<li class="page hidden"><span>Ы</span></li>
		<li class="page hidden"><span>Ъ</span></li>
		<li class="page hidden"><span>Э</span></li>
		<li class="page hidden"><span>Ю</span></li>
		<li class="page hidden"><span>Я</span></li>
	</ul>
</div>

~~~
[html]
<div class="alphaPager">
	<ul class="yiiAlphaPager">
		<li class="all selected"><span>All</span></li>
		<li class="page"><a href="">А</a></li>
		<li class="page hidden"><span>Б</span></li>
		<li class="page hidden"><span>В</span></li>
		<li class="page hidden"><span>Г</span></li>
		<li class="page hidden"><span>Д</span></li>
		<li class="page hidden"><span>Е</span></li>
		<li class="page hidden"><span>Ё</span></li>
		<li class="page hidden"><span>Ж</span></li>
		<li class="page hidden"><span>З</span></li>
		<li class="page hidden"><span>И</span></li>
		<li class="page hidden"><span>Й</span></li>
		<li class="page hidden"><span>К</span></li>
		<li class="page hidden"><span>Л</span></li>
		<li class="page hidden"><span>М</span></li>
		<li class="page hidden"><span>Н</span></li>
		<li class="page hidden"><span>О</span></li>
		<li class="page hidden"><span>П</span></li>
		<li class="page hidden"><span>Р</span></li>
		<li class="page hidden"><span>С</span></li>
		<li class="page hidden"><span>Т</span></li>
		<li class="page hidden"><span>У</span></li>
		<li class="page hidden"><span>Ф</span></li>
		<li class="page hidden"><span>Х</span></li>
		<li class="page hidden"><span>Ц</span></li>
		<li class="page hidden"><span>Ч</span></li>
		<li class="page hidden"><span>Щ</span></li>
		<li class="page hidden"><span>Ш</span></li>
		<li class="page hidden"><span>Ь</span></li>
		<li class="page hidden"><span>Ы</span></li>
		<li class="page hidden"><span>Ъ</span></li>
		<li class="page hidden"><span>Э</span></li>
		<li class="page hidden"><span>Ю</span></li>
		<li class="page hidden"><span>Я</span></li>
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

ul.yiiAlphaPager a:hover
{
}

ul.yiiAlphaPager .hidden a
{
    color:#888888;
}
ul.yiiAlphaPager .selected span
{
	color:#FFF;
    background: #0e509e;
}


/* Uncomment following line to hide the ALL-button */
/*ul.alphaPager .all { display:none; }*/
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


