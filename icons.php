<link rel="stylesheet" type="text/css" href="/css/icons.css" />


<?
$c = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/css/icons.css');
preg_match_all('/\.(glyphicon-.*){/', $c, $classes);
?>

<? foreach ($classes[1] as $class): ?>
    <span class="<?= $class ?>"></span>
    <?= $class ?>
    <br/>
<? endforeach ?>

<?
$icons = scandir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'glyphicons');
?>

<? foreach ($icons as $icon): ?>
    <img src="/img/glyphicons/<?= $icon ?>"/>
    <br/>
    <?= $icon ?>
    <br/>
<? endforeach ?>