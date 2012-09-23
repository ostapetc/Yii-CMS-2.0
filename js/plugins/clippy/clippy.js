(function($)
{
    $.fn.clippy = function(text, bgcolor)
    {
        var swf = '/js/plugins/clippy/clippy.swf';
        if (!bgcolor)
        {
            var node = $(this);
            while (node.css('background-color') == 'transparent' && node.length)
            {
                node = node.parent();
            }
            if (!node.length)
            {
                bgcolor = '#ffffff';
            }
            else
            {
                bgcolor = node.css('background-color');
            }
        }
        var m = bgcolor.match(/^rgb\(\s*(\d+),\s*(\d+)\s*,\s*(\d+)\s*\)$/i)
        if (m)
        {
            var r = parseInt(m[1], 10),
                g = parseInt(m[2], 10),
                b = parseInt(m[3], 10);
            bgcolor = '#' + r.toString(16) + g.toString(16) + b.toString(16);
        }
        $(this)
            .after($('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="110" height="14" id="clippy"> <param name="movie" value="' + swf + '"/> <param name="allowScriptAccess" value="always" /> <param name="quality" value="high" /> <param name="scale" value="noscale" /> <param NAME="FlashVars" value="text=' + escape(text) + '> <param name="bgcolor" value="' + bgcolor + '"> <embed src="' + swf + '" width="110" height="14" name="clippy" quality="high" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="text=' + escape(text) + '" bgcolor="' + bgcolor + '" /> </object>'))
            .after('&nbsp;');
    };
})(jQuery);
