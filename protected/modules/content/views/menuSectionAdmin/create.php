<?

$this->page_title.= ' :: ' . $menu->name;

$this->tabs = [
    "управление разделами" => $this->createUrl($back, ["menu_id" => $menu->id])
];

echo $form;
