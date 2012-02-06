**BaseForm**

- Конструктор `public function __construct($config, $model = null, $parent = null)`
может принимать сокращенный алиас конфигурационного файла в виде '{module_class}.{form_name}'
либо массив конфигурации формы
- `public static function getFullAlias($alias)` возвращает полный алиас по сокращенному
- `public static function getFormConfig($alias)` принимает сокращенный алиас
и возвращает массив с настройками. Если вместо алиаса отдать массив, то будет возвращен он же.
- Если форма была создана из административного контроллера, то шаблоном для вывода каждого элемента,
будет служить `//layouts/_adminForm.php` иначе `//layouts/_form.php`

