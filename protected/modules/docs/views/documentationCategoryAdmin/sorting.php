<?php
$this->page_title = $this->t('admin', 'update');

$this->tabs = array(
    $this->t('admin', 'manage')  => $this->createUrl("manage"),
    $this->t('admin', 'sorting') => $this->createUrl("sorting"),
    $this->t('admin', 'create')  => $this->createUrl("create", array('parent_id'=>1)),
);

?>
<div>
    Это страница для сортировки категорий.<br/>
    Для удобства использования сайта созданы некоторые ограничения:<br/>
    Нельзя главную категорией сделать второстепенной и наоборот.<br/>
    В остальном вы имеете полную своботу их перемещения.<br/>
</div>
<?php
$this->widget('content.portlets.NestedSortable', array(
    'model'    => Documentation::model(),
    'sortable' => true,
    'id'       => 'docs_sorting'
));