require([
	'jquery',
	'components/markdown-editor/markdown-editor',
	'components/markdown-view/markdown-view',
], function($, MarkdownEditor, MarkdownView) {

	var view = new MarkdownView(),
		editor = new MarkdownEditor(view)
	;

	$('#question-program-lang').on('change', function() {
		var language = $(this).val();
		view.setDefaultLanguage(language);
		editor.updateView();
	});

})