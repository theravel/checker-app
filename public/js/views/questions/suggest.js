require([
	'jquery',
	'components/markdown-editor'
], function($, editor) {

	$('#question-program-lang').on('change', function() {
		var language = $(this).val();
		editor.setDefaultLanguage(language);
	});

})