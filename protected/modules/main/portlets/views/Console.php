<script type="text/javascript">
    $(document).ready(function()
    {
        /* First console */
        var console = $('<div class="admin-console">');

        $('body').append(console);
        var controller = console.console({
            promptLabel: '> ',
            autofocus: false,
            animateScroll: true,
            promptHistory: true,
            commandHandle: function(line, report)
            {
                controller.ajaxloader = $('<p class="ajax-loader">Loading...</p>');
                controller.inner.append(controller.ajaxloader);

//                $.post("http://tryhaskell.org/haskell.json?method=eval&pad=handleJSON&expr=" + encodeHex(line) + "&random=" + Math.random());
            }
        });

        var tilda = function() {
            console.slideToggle();
        };
        $('body').bind('keydown', "`", tilda);
    });
</script>
