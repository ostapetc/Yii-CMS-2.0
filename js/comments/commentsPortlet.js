$.widget('cmsUI.commentList', {
    options: {
        version: '0.2',
        form_selector: '#comment-form',
        label_selector: "#comment-label",
        comments_list_selector: "#comments-div",
        comments_list_url: "/comments/comment/list",
        is_hidden: false
    },
    form : null,
    label : null,
    list : null,
    _create:function()
    {
        var widget = this;
        widget.form = $(widget.options.form_selector, widget.element);
        widget.label = $(widget.options.label_selector, widget.element);
        widget.list = $(widget.options.comments_list_selector, widget.element);

        widget.setLoading();
        widget._initAnswers();
        widget._initForm();
        if (!widget.options.is_hidden)
        {
            widget.loadCommentsList();
        }
    },
    _initForm:function()
    {
        var widget = this;

        widget.form.submit(function()
        {
            var params = {};

            widget.form.find('input, textarea').each(function()
            {
                params[$(this).attr('name')] = $(this).val();
            });

            $.post(widget.form.attr('action'), params, function(res)
            {
                widget.loadCommentsList();
                $("textarea[name='Comment[text]']", widget.form).val("");
                $("input[name='Comment[parent_id]']", widget.form).val("");
                widget.label.html(widget.label.attr('label'));
            });

            return false;
        });
    },
    _initAnswers: function()
    {
        var widget = this;
        $('a.answer').live('click', function()
        {
            var comment_id = $(this).attr('comment_id');
            var user_name  = $(this).attr('user_name');

            $("input[name='Comment[parent_id]']", widget.form).val(comment_id);

            widget.label.html(widget.label.attr('label') + '<strong> → ' + user_name + '</strong>');

            location.href = '#comment-form';
            return false;
        });
    },
    bindToLink: function(link)
    {
        var widget = this;
        $("input[name='Comment[model_id]']", widget.form).val(link.data('model-id'));
        $("input[name='Comment[object_id]']", widget.form).val(link.data('object-id'));
        widget.options.comments_list_url = link.data('comments-url');

    },
    setLoading: function()
    {
        var widget = this;
        var $loading_div = $('<div>Загрузка комментариев...</div>').css('text-align', 'center');
        widget.list.html($loading_div);
    },
    loadCommentsList: function (opts)
    {
        //TODO: add cache! or make it outside?
        var widget = this;
        $.get( widget.options.comments_list_url, {
                object_id : $("input[name='Comment[object_id]']", widget.form).val(),
                model_id  : $("input[name='Comment[model_id]']", widget.form).val()
            },
            function(html)
            {
                widget.list.html(html);
            }, 'html'
        );
    }
});