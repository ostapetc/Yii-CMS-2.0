function blockUI()
{
    $.blockUI({
        message:'<h2>Пожалуйста, подождите...</h2>',
        css:{
            border:'none',
            padding:'15px',
            backgroundColor:'#000',
            '-webkit-border-radius':'10px',
            '-moz-border-radius':'10px',
            opacity:.5,
            color:'#fff'
        }
    });
}

function unblockUI()
{
    $.unblockUI();
}

function hint(text)
{
    $.jGrowl(text,
        {
            closer:false,
            speed:500,
            life:7000
        });
}