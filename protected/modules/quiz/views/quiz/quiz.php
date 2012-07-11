<style type="text/css">
    code {
        display: block;
    }
</style>

<?
$chars = range('A', 'Z');
?>

<? foreach ($choices as $i => $choice): ?>
    <div style="padding: 30px 0;border-bottom: 1px solid #C0C0C0">
        <strong><?= ++$i ?>. <?= $choice->question->text ?></strong>
        <br/>

            <? foreach ($choice->question->answers as $i => $answer): ?>
                <?= $chars[$i] ?>) <?= $answer->text ?>
            <? endforeach ?>
        </ul>
    </div>
<? endforeach ?>