<?
$this->page_title = 'Добавление всех операций из модулей';
?>

<? if ($actions): ?>
 
    <form method="post">
        <table class="no_borders_table">
            <? $t = array(); ?>
            <? foreach ($actions as $name => $title): ?>
            
                <? $t[]=$name; ?>
        
                <tr>
                    <td>
                        <? echo $name; ?>
                        <input type="hidden" name="actions[]" value="<? echo $name; ?>">
                    </td>
                    <td>
                        &nbsp;
                        <b>Описание:</b> &nbsp;
                        <input type="text" name="description[]"  value="<? echo $title; ?>" class="text">
                    </td>
                </tr>
            
            <? endforeach ?>
            
            <tr>
                <td>
                    <input type="submit" value="Добавить" class="submit small">
                </td>
            </tr>
        
        </table>
    </form>  
    
<? else: ?>

    <? echo $this->msg("Все задачи уже добавлены!", "info"); ?>
    
<? endif ?>
