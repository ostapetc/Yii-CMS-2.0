$(function() {
    $.ajaxSetup({
        'complete' : function(res) {
            try {
                var json = $.parseJSON(res.responseText);
                if (json.errors) {
                    var errors_text = '';
                    for (var i in json.errors)
                    {
                        errors_text+= json.errors[i]['error'] + "\n";
                    }

                    showMessage('error', errors_text);
                }
            }
            catch(e){}

            if (jQuery().checkRights) {
                $('body').checkRights();
            }
        },

        'error' : function(res) {
            showMessage('error', res.responseText.toString().stripTags());
        }
    });
});