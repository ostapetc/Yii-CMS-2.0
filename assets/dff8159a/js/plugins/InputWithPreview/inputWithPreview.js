(function($){
	$.fn.inputWithPreview = function(options) {

		var defaults = {
            title:'',
            pattern:''
		};

		var options = $.extend(defaults, options);

        var span = $('<span class="activity-input-result-wrapper">').append($('<span>').text(options.title));
        var link = $('<a class="activity-input-result">');
        var input = $(this);
        span.append(link).insertAfter($(this));

        var change = function() {
            var value = options.pattern.replace('{value}', input.val());

            link.attr('href', value).text(value);
        };
        input.change(change);
        change();

	};
})(jQuery);
