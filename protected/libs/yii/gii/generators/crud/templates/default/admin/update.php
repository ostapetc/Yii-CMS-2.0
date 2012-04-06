<?php
echo '<?php

$this->tabs = array(
    \'управление\' => $this->createUrl(\'manage\'),
    \'просмотр\'   => $this->createUrl(\'view\', array(\'id\' => $form->model->id))
);';
?>

<?php echo "\n" . 'echo $form;'; ?>
