#WebModule

- `public function assetsUrl()` - возвращает путь до опубликованной директории assets текущего модуля.
- `public static function getShortId()` - возвращает короткий id модуля,
    его можно использовать для обращение к модулю через `Yii::app()->getModule($short_id)`
