<script type="text/javascript">

$(function()
{
    $("#ArticleSection_in_sidebar").click(function() 
    {      
        if ($(this).attr('checked')) 
        {
            $.getJSON('/articles/ArticleSectionAdmin/GetSectionInSidebar', function(section) 
            {   
                if (section) 
                {   
                    var msg = "Данный раздел будет отображаться на главной странице вместо раздела - " + section.name;
                    
                    $("#sidebar_msg").html(msg);

                    $("#sideBarDialog").dialog('open');
                }
            });
        }      
    });
});

</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'sideBarDialog',
    'options' => array(
        'title'   => 'Внимание!', 
        'modal'   => true, 
        'autoOpen' => false,
        'buttons' => array(
            'применить' => 'js:function() {$(this).dialog("close")}',
            'отмена'    => 'js:function() {
                $("#ArticleSection_in_sidebar").attr("checked", false);
                $(this).dialog("close");
            }'
        )
    )
));
?>

<div id="sidebar_msg"></div>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

