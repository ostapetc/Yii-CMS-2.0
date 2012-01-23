<?php 
$this->page_title = 'Добавление всех операций из модулей'; 

$this->tabs = array(
    'Операции' => $this->createUrl('manage'),
);
?>

<?php if ($actions): ?>
 
    <form method="post">
        <table class="no_borders_table">
            <?php $t = array(); ?>
            <?php foreach ($actions as $name => $title): ?>
            
                <?php $t[]=$name; ?>
        
                <tr>
                    <td>
                        <?php echo $name; ?>
                        <input type="hidden" name="actions[]" value="<?php echo $name; ?>">
                    </td>
                    <td>
                        &nbsp;
                        <b>Описание:</b> &nbsp;
                        <input type="text" name="description[]"  value="<?php echo $title; ?>" class="text">
                    </td>
                </tr>
            
            <?php endforeach ?>
            
            <tr>
                <td>
                    <input type="submit" value="Добавить" class="submit small">
                </td>
            </tr>
        
        </table>
    </form>  
    
<?php else: ?>

    <?php echo $this->msg("Все задачи уже добавлены!", "info"); ?>
    
<?php endif ?>
