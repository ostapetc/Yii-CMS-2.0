**TextComponent**

Компонент приложения, додступный через Yii::app()->text. Содержит функции форматирования текста.

- `public function cut($text, $length, $tail = "")` - обрезает текст
до заданного количества символов и в конце ставит `$tail`
- `public function toUrl` - транслитерирует текст
- `public function translit($string)` - транслитерирует текст
- `public function alphabetRu()` - Возвращает массив с русским алфавитом
- `public function alphabetEn()` - Возвращает массив с английским алфавитом
- `function antimat($string, $replaces = "<font color=red>цетзура</font> ")` - Заменяет маты заданной
строки на произвольный элемент массива переданного вторым элементом(можно передать просто строку)
- `public function lipsumParagraphs($count = 0, $words = 0, $loremIpsumFirst = true, $wrapperTag = 'p')` -
Генерирует заданное колличество паракрафов с текстом.
- `public function lipsumWords($count = 0, $loremIpsumFirst = true)` - Генерирует заданное колличество слов
- `public function parseTemplate($str, $data)` - Заменяет переменные формата
{{SOME_VAR}} заданными значениям, формат 2-го аргумента `array( SOME_VAR => 'value', ... )`
- `public function parseTemplateFile($file, $data)` - Парсит файл с помощью метода `parseTemplate`
- `public static function underscoreToCamelcase($string)` - Меняет стиль кодирования
- `public static function camelCaseToUnderscore($string)` - Меняет стиль кодирования

