$(function() {
    $('.add-friend-btn').live('click', function() {
        var $view_item = $(this).parents('table:eq(0)');

        var params = {
            friend_id : $(this).attr('friend_id'),
            return    : 'user_view_item'
        };

        $.post('/social/friend/create', params, function(user_view_item) {
            $view_item.next().remove();
            $view_item.replaceWith(user_view_item);
        });
    });
});