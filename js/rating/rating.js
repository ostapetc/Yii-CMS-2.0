$(function() {
    $('.rating-img').click(function() {
        var params = {
            'Rating[object_id]' : $(this).attr('object_id'),
            'Rating[model_id]'  : $(this).attr('model_id'),
            'Rating[value]'     : $(this).attr('value')
        };

        $.post('/rating/rating/create', params, function(res) {

        }, 'json');
    });
});