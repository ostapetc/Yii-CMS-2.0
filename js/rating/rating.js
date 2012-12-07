$(function() {
    $('.rating-vote.minus, .rating-vote.plus').click(function() {
        var that  = $(this);
        var value = $(this).data('value');

        that.addClass('glyphicon-na');
        that.siblings('.rating-vote').removeClass('glyphicon-na');

        var params = {
            'Rating[object_id]' : that.data('object'),
            'Rating[model_id]'  : that.data('model'),
            'Rating[value]'     : value
        };

        console.log(params);

        $.post('/social/rating/create', params, function(rating_html) {
            that.parent().find('.rating-value').replaceWith(rating_html);

            if (parseInt(value)) {
               //that.add
            }
            else {

            }
        });
    });
});