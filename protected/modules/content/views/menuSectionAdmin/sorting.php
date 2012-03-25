<?php
$this->page_title = $this->t('admin', 'Сортировка пунктов меню');

$this->tabs = array(
    $this->t('admin', 'Управление пунктами меню')  => $this->createUrl("manage", array('menu_id'=> $menu_id)),
);

?>

<div class="sortable-list">
    <?php
    $this->widget('content.portlets.NestedSortable', array(
        'model'    => MenuSection::model(),
        'sortable' => true,
        'root_id'  => $root_id,
        'id'       => 'menu_section_sorting'
    ));
    ?>
</div>