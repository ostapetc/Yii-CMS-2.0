$(function()
{
    var $object_id     = $('#MetaTag_object_id');
    var $model_id      = $('#MetaTag_model_id');
    var $submit        = $('#meta_tag_submit');
    var $meta_tag_id   = $('#MetaTag_id');


    if (!$model_id.val())
    {
        blockObjectIdElement();
    }

    $model_id.change(function()
    {
        var model_id = $(this).val();

        if (model_id)
        {
            loadModelObjects(model_id);
        }
        else
        {
            clearFieldsVal();
            blockObjectIdElement();
        }
    });


    function blockObjectIdElement()
    {
        $object_id.html('<option>выберите модель</option>');
        $object_id.attr('disabled', true);
    }


    function loadModelObjects(model_id, object_id)
    {
        $.getJSON('/main/MetaTagAdmin/getModelObjects', {'model_id' : model_id, 'object_id' : object_id}, function(objects)
        {
            var options = "<option value=''>не выбран</option>";

            if (objects)
            {
                for (var id in objects)
                {
                    var selected = "";

                    if (object_id && object_id == id)
                    {
                        selected = "selected";
                    }

                    options+= "<option value='" + id + "' " + selected + ">" + objects[id] + "</option>";
                }

                $object_id.html(options);
                $object_id.attr('disabled', false);
            }
        });
    }


    function clearFieldsVal()
    {
        $('#MetaTag_title, #MetaTag_description, #MetaTag_keywords').val("");
    }
});


