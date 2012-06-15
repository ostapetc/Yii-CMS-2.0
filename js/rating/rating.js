$(function() {
    $('.rating-vote.minus, .rating-vote.plus').click(function() {
        var that = $(this);

        var params = {
            'Rating[object_id]' : $(this).attr('object_id'),
            'Rating[model_id]'  : $(this).attr('model_id'),
            'Rating[value]'     : $(this).attr('value')
        };

        $.post('/social/rating/create', params, function(rating_html) {
            that.parent().find('.rating-value').replaceWith(rating_html);
        });
    });
});