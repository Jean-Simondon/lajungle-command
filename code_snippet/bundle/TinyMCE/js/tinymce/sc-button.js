function handleButton(ed)
{
	var url = window.prompt('Veuillez saisir l\'URL du lien', 'http://domain.tld');
	var label = window.prompt('Veuillez saisir le label du lien', 'label');
	if(url != null && label != null){
		var ext = window.confirm('Lien externe ?');
		ext = ext?'type=externe':'type=normal';
		ed.execCommand('mceInsertContent', false, '[bouton url="'+url+'" '+ext+']'+label+'[/bouton] <br>\n<br>\n');
	}
}

(function() {
	tinymce.create('tinymce.plugins.scbouton', {
		init : function(ed, url) {
			ed.addButton('scbouton', {
				title : 'Bouton',
				image : url.substr(0, url.length - 2)+'images/tinymce/button.png',
				onclick : function() {
					handleButton(ed);
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Shortcode Bouton",
				author : 'Aurelien Bonnal',
				authorurl : 'http://www.lajungle.fr',
				infourl : '',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('scbouton', tinymce.plugins.scbouton);
	acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ){
		ed.addButton('scbouton', {
			title : 'Shortcode Lien',
			onclick : function() {
				handleButton(ed);
			}
		});
	});
})();
