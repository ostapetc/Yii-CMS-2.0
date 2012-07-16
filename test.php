<?php

function v($a)
{
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}


QuizQuestion::model()->deleteAll();

$c = file_get_contents("http://koduleht.eu/phpzendtest/taketest.php?1");
$c = iconv('ISO-8859-1', 'utf-8', $c);

$doc = new DOMDocument();
$doc->encoding = 'UTF-8';
$doc->loadHTML($c);

$xpath = new DOMXPath($doc);

$query = $xpath->query('//div[@class="qbox"]');
foreach ($query as $i => $div)
{
    $topic_id = 6;

    $div_content = $doc->saveXML($div);
    //$div_content = str_replace(array("\n", "\r", "\n\r", "\r\n", "\t"), "null", $div_content);

    preg_match('|<h4>(.*?)</h4>|is', $div_content, $question);
    $question = trim($question[1]);

    if ($i != 10) continue;


    $q = new QuizQuestion();
    $q->text = $question;
    $q->topic_id = $topic_id;
    if (!$q->save())
    {
        v($q->errors);
        die;
    }

    preg_match_all('|<label for="[0-9a-zA-z]+">(.*?)</label>|is', $div_content, $answers);
    $answers = $answers[1];

    foreach ($answers as $answer)
    {
        $answer = trim($answer->nodeValue);

        $a = new QuizAnswer();
        $a->question_id = $q->id;
        $a->text = $answer;
        if (!$a->save())
        {
            v($a->errors);
            die;
        }
    }
}
