function handleFile(ed)
{
	var url = window.prompt('Veuillez saisir l\'URL du fichier', 'http://domain.tld');
	var label = window.prompt('Veuillez saisir le label du lien', 'label');
	if(url != null && label != null){
		ed.execCommand('mceInsertContent', false, '[fichier url="'+url+'"]'+label+'[/fichier]<br>\n<br>\n');
	}
}

(function() {
	tinymce.create('tinymce.plugins.scfichier', {
		init : function(ed, url) {
			ed.addButton('scfichier', {
				title : 'Fichier',
				image : url.substr(0, url.length - 2)+'images/tinymce/file.png',
				onclick : function() {
					handleFile(ed);
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Shortcode fichier",
				author : 'Aurelien Bonnal',
				authorurl : 'http://www.lajungle.fr',
				infourl : '',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('scfichier', tinymce.plugins.scfichier);
	acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ){
		ed.addButton('scfichier', {
			title : 'Shortcode fichier',
			onclick : function() {
				handleFile(ed);
			}
		});
	});
})();
