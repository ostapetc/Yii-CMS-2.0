<?php
$this->page_title.= " :: {$role->description}";

$cs = Yii::app()->clientScript;
$cs->registerScriptFile($this->module->assetsUrl() . '/js/rolesTasks.js');
$cs->registerCssFile($this->module->assetsUrl() . '/css/rolesTasks.css');
?>

<?php if ($tasks): ?>
    <table width="100%" cellspacing="0">
        <?php foreach ($tasks as $task): ?>
            <?php
            $allow = in_array($task->name, $allowed_tasks);
            ?>

            <tr task='<?php echo $task->name; ?>' class="<?php echo $allow ? 'allow_tr' : 'deny_tr'; ?>">
                <td style="padding-top: 14px;">
                    <h4><?php echo $task->description; ?></h4>
                </td>
                <td class="links_td">
                    <?php if ($allow): ?>
                        <a href="#" class="deny_link">Запретить</a>
                    <?php else: ?>
                        <a href="#" class="allow_link">Разрешить</a>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php else: ?>
    <?php echo $this->msg("Для начала нужно добавить задачи!", "warning"); ?>
<?php endif ?>

<input type="hidden" id="curr_role" value="<?php echo $role->name; ?>">
