var $ = jQuery.noConflict();
jQuery(document).ready(function ($) {

	function handleTexte(ed)
	{
		
		// Travail en cours
		// function getSelectionText() {
		// 	var text = "";
		// 	if (window.getSelection) {
		// 		text = window.getSelection().toString();
		// 	} else if (document.selection && document.selection.type != "Control") {
		// 		text = document.selection.createRange().text;
		// 	}
		// 	return text;
		// }

		// if( content == null ) {
		// 	console.log(content);
		// 	content = getSelectionText();
		// 	console.log(content);
		// }

		var content = window.prompt('Veuillez entrer le texte à mettre en avant');
		if( content != null ) {
			ed.execCommand('mceInsertContent', false, '[texte]'+content+'[/texte] <br>\n<br>\n');
		}

	}

	(function() {

		tinymce.create('tinymce.plugins.sctexte', {
			init : function(ed, url) {
				ed.addButton('sctexte', {
					title : 'Texte mis en avant',
					image : url.substr(0, url.length - 2)+'images/tinymce/texte.png',
					onclick : function() {
						handleTexte(ed);
					}
				});
			},
			createControl : function(n, cm) {
				return null;
			},
			getInfo : function() {
				return {
					longname : "Shortcode Texte",
					author : 'Aurelien Bonnal',
					authorurl : 'http://www.lajungle.fr',
					infourl : '',
					version : "1.0"
				};
			}
		});

		tinymce.PluginManager.add('sctexte', tinymce.plugins.sctexte);

		acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ){
			ed.addButton('sctexte', {
				title : 'Shortcode Texte',
				onclick : function() {
					handleTexte(ed);
				}
			});
		});

	})();

});