<style type="text/css">
    #recipients_div {
        display: none;
    }
</style>


<script type="text/javascript">
    $(function()
    {
        $('#show_recipients_l').click(function()
        {
            $('#recipients_div').slideToggle();
            return false;
        });
    });
</script>

    
<a href='' id='show_recipients_l'>Показать</a>

<br><br>    

<div id='recipients_div'>
    <? foreach ($grouped_users as $role_desc => $user_names):?>
        <b><? echo $role_desc; ?></b><br/>
        <? echo implode(', ', $user_names); ?>
        <br/>
        <br>
    <? endforeach ?>
</div>