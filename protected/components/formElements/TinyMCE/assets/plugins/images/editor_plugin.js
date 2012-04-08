/**
 * @author Antonov Andrey http://dustweb.ru/
 * @copyright Copyright � 2008-2009, Antonov A Andrey, All rights reserved.
 */

(function() {
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('example');
	tinymce.create('tinymce.plugins.ImagesPlugin', {
		init : function(ed, url) {
			// Register commands
			ed.addCommand('mceImages', function() {
				ed.windowManager.open({
					file : url + '/images.htm',
					width : 700 + parseInt(ed.getLang('images.delta_width', 0)),
					height : 550 + parseInt(ed.getLang('images.delta_height', 0)),
					inline: true,
					popup_css : false
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('images', {
				title : 'Images Manager',
				cmd : 'mceImages',
				image : url + '/img/icon.gif'
			});
		},

		getInfo : function() {
			return {
				longname : 'Images Manager',
				author : 'Antonov Andrey',
				authorurl : 'http://dustweb.ru',
				infourl : 'http://dustweb.ru/log/projects/tinymce_images/',
				version : '1.1 beta 2'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('images', tinymce.plugins.ImagesPlugin);
})();