<h4>Разделы</h4>

<? if ($sections): ?>
    <?
    $this->widget('BootMenu', array(
        'items'       => $sections,
        'encodeLabel' => false,
        'htmlOptions' => array(
            'id' => 'sections-menu'
        )
    ));
    ?>
<? else: ?>
    <span class="italic-12">Разделы отсутствуют</span>
<? endif ?>

