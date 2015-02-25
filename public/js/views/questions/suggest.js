require([
	'jquery',
	'components/markdown-editor/markdown-editor',
	'components/markdown-view/markdown-view',
], function($, MarkdownEditor, MarkdownView) {

	var preview = new MarkdownView(),
		editor = new MarkdownEditor(preview)
	;

	$('#question-program-lang').on('change', function() {
		var language = $(this).val();
		preview.setDefaultLanguage(language);
		editor.updateView();
	});

})