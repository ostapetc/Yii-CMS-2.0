$(function()
{
    var uploader = $('#uploader').pluploadQueue();
    uploader.bind('FileUploaded', function(up, file, res) {
        if (this.total.queued == 0)
        {
            location.href = location.href;
        }
    });
});