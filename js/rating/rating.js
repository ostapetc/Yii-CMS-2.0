$(function() {
    $('.rating-vote.minus, .rating-vote.plus').click(function() {
        var that = $(this);

        that.parent().find('.rating-vote').each(function() {
            $(this).attr('class', $(this).attr('class').replace('minus', 'minus-na').replace('plus', 'plus-na'));
            $(this).unbind('click');
        });

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