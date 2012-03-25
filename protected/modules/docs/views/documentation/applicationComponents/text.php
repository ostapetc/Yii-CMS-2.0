#TextComponent

Компонент приложения, додступный через Yii::app()->text. Содержит функции форматирования текста.

- `public static function cut($text, $length, $delim = '., -:;', $tail= "")` - обрезает текст
до заданного количества символов и в конце ставит `$tail`
- `public static function translit($string)` - транслитерирует текст
- `function antimat($string, $replace = "<font color=red>цетзура</font> ")` - удаляет не цензурные
выражения из текста, вместо них вставляет $replace
- `public function lipsumParagraphs($count = 0, $words = 0, $loremIpsumFirst = true, $wrapperTag = 'p')` -
Генерирует заданное колличество паракрафов с текстом.
- `public function lipsumWords($count = 0, $loremIpsumFirst = true)` - Генерирует заданное колличество слов

