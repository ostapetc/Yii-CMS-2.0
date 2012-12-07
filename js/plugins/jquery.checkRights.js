/**
 * Author: Остапец Артем
 */

(function($) {
    var options = [];

    $.fn.checkRights = function() {
        this.find('*[data-role]').not('.auth-failed').each(function() {
            var role = $(this).data('role');
            if (role != Yii.app.user.role) {
                if (role == 'user') {
                    $(this).css({
                        opacity : 0.3,
                        cursor  :'not-allowed'
                    }).attr('title', 'Войдите чтобы воспользоваться этой функцией');

                    $(this).addClass('auth-failed');
                }
            }
        });
    }
}(jQuery));
