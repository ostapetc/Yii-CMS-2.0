<? if ($sections): ?>
    <div class="sections">
        <span class="glyphicon-briefcase"></span>
        <? foreach ($sections as $i => $section): ?>
            <? if ($i > 0): ?>,  <? endif; ?>
            <?= CHtml::link($section->name, $this->createUrl('/page/section/' . $section->id), array('class' => 'section', 'title' => $section->name)); ?>
        <? endforeach ?>
    </div>
<? endif ?>