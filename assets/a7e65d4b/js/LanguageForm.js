$(function() {

    $languageId = $("#Language_id");
    $languageId.after("<span id='lang_label'></span>");

    loadLanguageIcon($languageId);

    $languageId.change(function() {
        loadLanguageIcon($(this));
    });

    function loadLanguageIcon($select) {
        var lang_id = $select.val();
        if (lang_id)
        {
            $('#lang_label').html('<img src="/img/icons/flags/' + lang_id + '.png" border="0" />');
        }
        else
        {
            $('#lang_label').html('');
        }
    }
});