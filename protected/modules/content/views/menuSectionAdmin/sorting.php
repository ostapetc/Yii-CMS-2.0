<?
$this->page_title = $this->t('admin', 'Сортировка пунктов меню');

$this->tabs = [
    $this->t('admin', 'Управление пунктами меню')  => $this->createUrl("manage", ['menu_id'=> $menu_id]),
];

?>

<div class="sortable-list">
    <?
    $this->widget('content.portlets.NestedSortable', [
        'model'    => MenuSection::model(),
        'sortable' => true,
        'root_id'  => $root_id,
        'id'       => 'menu_section_sorting'
    ]);
    ?>
</div>