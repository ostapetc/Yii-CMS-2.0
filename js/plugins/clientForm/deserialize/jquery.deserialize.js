/**
 * @author Maxim Vasiliev
 * Date: 21.01.2010
 * Time: 14:00
 */

(function($)
{
	/**
	 * jQuery.deserialize plugin
	 * Fills elements in selected containers with data extracted from URLencoded string
	 * @param data URLencoded data
	 * @param clearForm if true form will be cleared prior to deserialization
	 */
	$.fn.deserialize = function(data, clearForm)
	{
		this.each(function(){
			deserialize(this, data, !!clearForm);
		});
	};

	/**
	 * Fills specified form with data extracted from string
	 * @param element form to fill
	 * @param data URLencoded data
	 * @param clearForm if true form will be cleared prior to deserialization
	 */
	function deserialize(element, data, clearForm)
	{
		var splits = decodeURIComponent(data).split('&'),
			i = 0,
			split = null,
			key = null,
			value = null,
			splitParts = null;

		if (clearForm)
		{
			$('input[type="checkbox"],input[type="radio"]', element).removeAttr('checked');
			$('select,input[type="text"],input[type="password"],input[type="hidden"],textarea', element).val('');
		}

		var kv = {};
		while(split = splits[i++]){
			splitParts = split.split('=');
			key = splitParts[0] || '';
			value = (splitParts[1] || '').replace(/\+/g, ' ');

			if (key != ''){
				if( key in kv ){
					if( $.type(kv[key]) !== 'array' )
						kv[key] = [kv[key]];

                    kv[key].push(value);

				}else
					kv[key] = value;
			}
		}

		for( key in kv ){
			value = kv[key];

            var elems;
            if ($.isArray(value))
            {
                var singleVal = value.pop();
                elems = $('input[type="checkbox"][name="'+ key +'"][value="'+ singleVal +'"],input[type="radio"][name="'+ key +'"][value="'+ singleVal +'"]', element).attr('checked', 'checked');
            }
            else
            {
                elems = $('input[type="checkbox"][name="'+ key +'"][value="'+ value +'"],input[type="radio"][name="'+ key +'"][value="'+ value +'"]', element).attr('checked', 'checked');
            }
            if (elems.length == 0)
            {
                $('select[name="'+ key +'"],input[type="text"][name="'+ key +'"],input[type="password"][name="'+ key +'"],input[type="hidden"][name="'+ key +'"],textarea[name="'+ key +'"]', element).val(value);
            }
		}
    }

})(jQuery);