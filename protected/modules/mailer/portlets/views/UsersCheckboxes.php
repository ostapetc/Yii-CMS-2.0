<?php
$assets_url = $this->module->assetsUrl();
?>

<script type="text/javascript" src="<?php echo $assets_url . "/js/UsersCheckboxes.js"; ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $assets_url . "/css/UsersCheckboxes.css"; ?>" />

<table id="rch_tpl" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2"><b>Получатели:</b></td>
    </tr>
    <?php foreach ($roles as $role): ?>
        <?php
        $users = $role->users;
        if (!$users)
        {
            continue;
        }
        ?>
        <tr>
            <td class="ch_td" align="left">
                <input type="checkbox" class="role_checkbox">
            </td>
            <td>
                <a href="" class="role_link">+ <?php echo $role->description; ?></a>
                
                <table cellpadding="0" cellspacing="0" class="uch_tbl">
                    <?php foreach ($users as $user): ?>
                    	<?php
						$checked = '';
						
						if (isset($_POST['users_ids'])) 
						{
							if (in_array($user->id, $_POST['users_ids'])) 
							{
								$checked = 'checked';
							}
						}
						else 
						{
							if (in_array($user->id, $users_ids)) 
							{
								$checked = 'checked';	
							}
						}
                    	?>
                        <tr>
                            <td class="checkbox_td">
                                <input type="checkbox" name="users_ids[]" class="user_checkbox" value='<?php echo $user->id; ?>' <?php echo $checked; ?>>
                            </td>
                            <td>
                                <?php echo $user->name; ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </td>
        </tr>
    <?php endforeach ?>
</table>