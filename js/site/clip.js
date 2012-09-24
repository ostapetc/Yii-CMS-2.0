/**
 * required jquery.clipboard plugin
 */
ZeroClipboard.setMoviePath('/js/plugins/clip/ZeroClipboard10.swf');
$(document).ready(function()
{
    $("[data-clip]").each(function(a, b)
    {
        var self = $(b);
        var clip = new ZeroClipboard.Client();
        clip.glue(b);
        clip.addEventListener('mouseDown', function(client)
        {
            clip.setText(self.data('clip'));
        });
    });

});