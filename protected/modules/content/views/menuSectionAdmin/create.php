<?php

$this->page_title.= ' :: ' . $menu->name;

$this->tabs = array(
    "управление разделами" => $this->createUrl($back, array("menu_id" => $menu->id))
);

echo $form;
