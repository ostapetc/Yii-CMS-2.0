<script type="text/javascript">
    $(function() {
        var $loading_div   = $('<div>загрузка комментариев...</div>').css('text-align', 'center');
        var $comments_div  = $('#comments-div');
        var $comment_label = $('#comment-label');

        $comments_div.html($loading_div);

        loadCommentsList();

        $('.comment-answer').live('click', function() {
            var comment_id = $(this).attr('comment_id');
            var user_name  = $(this).attr('user_name');

            $("input[name='Comment[parent_id]']").val(comment_id);

            $comment_label.html($comment_label.attr('label') + '<strong> → ' + user_name + '</strong>');
            $('');

            location.href = '#comment-form';
            return false;
        });

        $('#comment-form').submit(function() {
            var params = {};

            $('#comment-form').find('input, textarea').each(function() {
                params[$(this).attr('name')] = $(this).val();
            });

            $.post('/comments/comment/create', params, function(res) {
                loadCommentsList();
                $("textarea[name='Comment[text]']").val("");
            });

            return false;
        });

        function loadCommentsList() {
            var object_id = $("input[name='Comment[object_id]']").val();
            var model_id  = $("input[name='Comment[model_id]']").val();

            $.get('/comments/comment/list/object_id/' + object_id + '/model_id/' + model_id, function(html) {
                $comments_div.html(html);
            });
        }
    });
</script>

<div id="comments-div">

</div>

<? if (!Yii::app()->user->isGuest): ?>
    <?= CHtml::link('', 'comment-form'); ?>
    <?= CHtml::beginForm('/comments/comment/create', 'post', array('id' => 'comment-form')) ?>
    <?= CHtml::label('Комментарий', 'Comment[text]', array('label' => 'Комментарий', 'id' => 'comment-label')) ?>
    <?= CHtml::textArea('Comment[text]', null, array('style' => 'width: 100%')) ?> <br/>
    <?= CHtml::hiddenField('Comment[object_id]', $object_id); ?>
    <?= CHtml::hiddenField('Comment[model_id]', $model_id); ?>
    <?= CHtml::hiddenField('Comment[parent_id]'); ?>
    <?= CHtml::submitButton('Добавить') ?>
    <?= CHtml::endForm() ?>
<? else: ?>
    <?= Controller::msg('Комментировать могут только зарегистрированные пользователи!', 'warning') ?>
<? endif ?>