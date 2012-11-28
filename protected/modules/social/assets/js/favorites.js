$(function() {
    $('.favorite a.user').live('click', function() {
        var object_id = $(this).attr('object_id');
        var model_id  = $(this).attr('model_id');
        var link      = $(this);

        var params = {
            'Favorite[object_id]' : object_id,
            'Favorite[model_id]'  : model_id
        }

        $.post('/social/favorite/createOrDelete', params, function(res) {
            $('#favs_count_' + object_id + '_' + model_id).html(res.count);

            if (res.action == 'create')
            {
                link.removeClass('glyphicon-dislikes').addClass('glyphicon-star');
                showMessage('success', 'добавлено в избранное');
            }
            else
            {
                link.removeClass('glyphicon-star').addClass('glyphicon-dislikes');
                showMessage('success', 'удалено из избранного');
            }
        }, 'json');

        return false;
    });
});