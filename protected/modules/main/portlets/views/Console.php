<script type="text/javascript">
    $(document).ready(function()
    {

        /* First console */
        var console = $('<div class="admin-console">');

        $('body').append(console);
        var controller = console.console({
            promptLabel: '> ',
            autofocus: false,
            animateScroll:true,
            promptHistory: true,
            commandValidate:function(line){
                if (line == "") return false;
                else return true;
            },
            commandHandle: function(line, report)
            {
                controller.ajaxloader = $('<span class="ajax-loader"> | Loading...</span>');
                controller.inner.find('.jquery-console-prompt:last').append(controller.ajaxloader);

                $.post("/main/helpAdmin/console", {command:line}, function(data) {
                    report(data);
                    controller.ajaxloader.remove();
                }, 'html');
            },
            charInsertTrigger:function(keycode,line){
                if (keycode == '`'.charCodeAt(0) || keycode == 'ё'.charCodeAt(0))
                {
                    tilda();
                    return false;
                }
                return true;
            }
        });

        var tilda = function() {
            console.slideToggle('normal', function() {
                if ($(this).is(':visible'))
                {
                    console.click();
                }
                else
                {
                    $('#main').click();
                }
            });
        };
        $('body').bind('keydown', "`", tilda);
    });
</script>
