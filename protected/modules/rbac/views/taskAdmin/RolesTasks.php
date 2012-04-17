<?
$this->page_title.= " :: {$role->description}";

$cs = Yii::app()->clientScript;
$cs->registerScriptFile($this->module->assetsUrl() . '/js/rolesTasks.js');
$cs->registerCssFile($this->module->assetsUrl() . '/css/rolesTasks.css');
?>

<? if ($tasks): ?>
    <table width="100%" cellspacing="0">
        <? foreach ($tasks as $task): ?>
            <?
            $allow = in_array($task->name, $allowed_tasks);
            ?>

            <tr task='<? echo $task->name; ?>' class="<? echo $allow ? 'allow_tr' : 'deny_tr'; ?>">
                <td style="padding-top: 14px;">
                    <h4><? echo $task->description; ?></h4>
                </td>
                <td class="links_td">
                    <? if ($allow): ?>
                        <a href="#" class="deny_link">Запретить</a>
                    <? else: ?>
                        <a href="#" class="allow_link">Разрешить</a>
                    <? endif ?>
                </td>
            </tr>
        <? endforeach ?>
    </table>
<? else: ?>
    <? echo $this->msg("Для начала нужно добавить задачи!", "warning"); ?>
<? endif ?>

<input type="hidden" id="curr_role" value="<? echo $role->name; ?>">
