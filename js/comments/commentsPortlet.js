$.widget('cmsUI.commentList', {
    options: {
        version: '0.2',
        form_selector: '#comment-form',
        label_selector: "#comment-label",
        comments_list_selector: "#comments-div",
        create_comments_url: "/comments/comment/create",
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
    bindTo: function(link)
    {
        var widget = this;
        $("input[name='Comment[model_id]']", widget.form).val(link.data('model-id'));
        $("input[name='Comment[object_id]']", widget.form).val(link.data('object-id'));
        widget.form.attr('action', link.data('comments-url'));
    },
    setLoading: function() {
        var widget = this;
        var $loading_div = $('<div>загрузка комментариев...</div>').css('text-align', 'center');
        widget.list.html($loading_div);
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

            $.post(widget.options.create_comments_url, params, function(res)
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
    loadCommentsList: function (opts)
    {
        //TODO: add cache! or make it outside?
        var widget = this;
        var update_url = widget.options.comments_list_url;
        if (opts && opts.url) {
            update_url = opts.url;
        }

        var oid = $("input[name='Comment[object_id]']", widget.form).val(),
            mid = $("input[name='Comment[model_id]']", widget.form).val();

        $.get(update_url, {
            object_id : oid,
            model_id  : mid
        },
        function(html)
        {
            widget.list.html(html);
        }, 'html');
    }
});