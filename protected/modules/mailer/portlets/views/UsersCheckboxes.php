<?
$assets_url = $this->module->assetsUrl();
?>

<script type="text/javascript" src="<? echo $assets_url . "/js/UsersCheckboxes.js"; ?>"></script>

<link rel="stylesheet" type="text/css" href="<? echo $assets_url . "/css/UsersCheckboxes.css"; ?>" />

<table id="rch_tpl" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="2"><b>Получатели:</b></td>
    </tr>
    <? foreach ($roles as $role): ?>
        <?
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
                <a href="" class="role_link">+ <? echo $role->description; ?></a>
                
                <table cellpadding="0" cellspacing="0" class="uch_tbl">
                    <? foreach ($users as $user): ?>
                    	<?
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
                                <input type="checkbox" name="users_ids[]" class="user_checkbox" value='<? echo $user->id; ?>' <? echo $checked; ?>>
                            </td>
                            <td>
                                <? echo $user->name; ?>
                            </td>
                        </tr>
                    <? endforeach ?>
                </table>
            </td>
        </tr>
    <? endforeach ?>
</table>