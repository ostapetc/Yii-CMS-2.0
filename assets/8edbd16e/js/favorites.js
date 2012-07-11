$(function() {
    $('.favorite a.user').live('click', function() {
        var object_id = $(this).attr('object_id');
        var model_id  = $(this).attr('model_id');
        var link      = $(this);

        var params = {
            'Favorite[object_id]' : object_id,
            'Favorite[model_id]'  : model_id
        }

        $.post('/social/favorite/create', params, function(res) {
            $('#favs_count_' + object_id + '_' + model_id).html(res.count);

            link.attr({
                'title'   : link.attr('added_msg'),
                'class'   : 'added',
                'onclick' : 'return false;'
            });
        }, 'json');

        return false;
    });
});