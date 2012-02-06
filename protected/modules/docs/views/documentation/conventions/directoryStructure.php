#Структура директорий

Вместе с Проектной документацией должны быть переданы файлы относящиеся к проекту.


**Файлы проекта должны распологатся в следующих директориях:**

- `/assets` — папка для автоматической публикации статических ресурсов модулей ПО и фреймворка;
- `/css` — стили сайта;
- - `/css/admin` - стили админ-панели
- - `/css/site` — стили конкретного проекта
- `/img` — картинки макета сайта;
- - `/img/admin` — картинки ПУ;
- - `/img/site` — картинки  ПО;
- `/js` — javascript скрипты;
- - `/js/admin` -  javascript скрипты  админ-панели
- - `/js/plugins` — содержит плагины в каждой отдельной папке
- - `/js/site` — javascript скрипты конкретного проекта
- `/protected` —папка с ограниченными правами доступа.
- - `/protected/commands` — консольные команды приложения, например скрипты которые работаю по cron;
- - `/protected/components` — компоненты  приложения;
- - `/protected/extensions` — сторонние расширения фреймворка;
- - `/protected/libs` — содержит библиотеки, само ядро фреймворка yii, библиотеку для работы с почтой, библиотека для работы с excel и т.д.;
- - `/protected/messages` — перевод общих слов и фраз на различные языки;
- - `/protected/modules` – модули;
- - `/protected/tests` — тесты ПО.
- - `/protected/views/layouts` — шаблоны верстки. Частичные шаблоны, такие как шапка сайта и подвал сайта должны начинаться с прочерка _header.php, _footer.php;
- `/upload` — папка для загрузки на сервер фалов  пользователями.
- `/index.php` — единая точка входа приложения, обрабатывает все запросы к сайту за исключением статических файлов (js, images,css).
- `/modules` — содержит модули в каждой отдельной папке

**Ниже представлен пример файлов структуры ПО «Документы»:**

- `/documents/controllers` — контроллеры модуля;
- - `/documents/controllers/DocumentAdminController` — контроллер модуля, в котором описаны действия для ПУ;
- - `/documents/controllers/DocumentController` — контроллеры модуля,  в котором описаны действия для публичной части сайта;
- `/documents/components` – компоненты
- `/documents/forms` — формы модуля;
- `/documents/messages` — содержит переводы если ПО поддерживает несколько языков;
- `/documents/data` – содержит документацию и дамп нужной части базы;
- `/documents/models` — модели модуля;
- `/documents/portlets` – содержит портлеты(виджеты) модуля
- `/documents/views` — скрипты видов модуля;
- - `/documents/views/document` — скрипты видов для клиентской части ПО;
- - `/documents/views/documentAdmin` - скрипты видов для ПУ;
- - `/documents/views/documentAdmin/create.php` — добавление документа;
- - `/documents/views/documentAdmin/manage.php` — управление документами;
- - `/documents/views/documentAdmin/update.php` — редактирование документа;
- - `/documents/views/documentAdmin/view.php` — просмотр документа;
- - `/documents/views/document/index.php` — список документов на сайте;
- - `/documents/views/document/view.php` — просмотр документа на сайте;
- `/documents/DocumentsModule.php` — основной класс модуля;

