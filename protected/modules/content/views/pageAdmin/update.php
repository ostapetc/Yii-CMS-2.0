<?
$this->page_title = t('Рекдирование страницы');

$this->tabs = [
    'список страниц'    => $this->createUrl('manage'),
    'просмотр страницы' => $this->createUrl('view', ['id' => $form->model->id])
];

echo $form;
