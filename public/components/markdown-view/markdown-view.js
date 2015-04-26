define([
	'vendor/js/marked-0.3.3.min',
	'vendor/components/highlight-8.4/highlight.pack',
], function(marked, hljs) {

	var MarkdownView = function() {

		var defaultLanguage,
			jViewPanel = $('#markdown-view'),
			languageAliases = {
				js: 'javascript',
				html: 'xml'
			},

			init = function() {
				setDefaultLanguage(jViewPanel.data('lang'));
				try {
					setValue(jViewPanel.data('value'));
				} catch (e) {
					// data-vale attribute is not defined
				}
			},

			setDefaultLanguage = function(lang) {
				defaultLanguage = lang;
			},

			setValue = function(value) {
				if (typeof value !== 'string') {
					throw 'Invalid value';
				}
				var equation = value.replace(/<equation>((.*?\n)*?.*?)<\/equation>/ig, function(a, b){
					return '<img src="http://latex.codecogs.comp/ng.latex?' + encodeURIComponent(b) + '" />';
				});
				jViewPanel.html(marked(equation));
			}
		;

		marked.setOptions({
			sanitize: true,
			highlight: function(code, lang){
				if (!lang) {
					lang = defaultLanguage;
				}
				if (languageAliases[lang]) {
					lang = languageAliases[lang];
				}
				var languages = hljs.listLanguages(),
					index = languages.indexOf(lang);
				return (index >= 0) ?
					hljs.highlight(lang, code).value :
					code;
			}
		});

		init();

		this.setValue = setValue;
		this.setDefaultLanguage = setDefaultLanguage;
	}

	return MarkdownView;

});