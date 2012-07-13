$(function() {
    $('.os-date-picker').each(function() {
        var $picker = $(this);

        $(this).find('input, select').change(function() {
            var date = [
                $picker.find('.year').val(),
                $picker.find('.month').val(),
                $picker.find('.day').val()
            ].join('-');

            $picker.find('.date-value').val(date);
        });
    })
});