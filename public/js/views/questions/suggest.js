require([
	'jquery',
	'components/markdown-editor/markdown-editor',
	'components/markdown-view/markdown-view',
	'tagIt',
], function($, MarkdownEditor, MarkdownView) {

	var preview = new MarkdownView(),
		editor = new MarkdownEditor(preview),
		jLanguageSelector = $('#question-program-lang'),
		selectedLanguage = jLanguageSelector.val(),
		categoriesAutocomplete = [],

		updateCategoriesAutocomplete = function(selectedLanguage) {
			$.ajax({
				url: '/questions/categories',
				data: {
					language: selectedLanguage
				},
				dataType: 'json',
				success: function(data) {
					categoriesAutocomplete = data;
				},
				error: function(request, status, error) {
					console.error(request, status, error);
				}
			})
		}
	;

	$('#question-categories').tagit({
		autocomplete: {
			source: function(request, response) {
				var term = request.term.toLowerCase(),
					matches = [];
				
				for (var i = 0; i < categoriesAutocomplete.length; i++) {
					var name = categoriesAutocomplete[i].name.toLowerCase();
					if (0 === name.indexOf(term)) {
						matches.push({
							label: categoriesAutocomplete[i].name,
							value: categoriesAutocomplete[i].id
						});
					}
				}
				response(matches);
			}
		}
	});

	jLanguageSelector.on('change', function() {
		selectedLanguage = $(this).val();
		preview.setDefaultLanguage(selectedLanguage);
		editor.updateView();
		updateCategoriesAutocomplete(selectedLanguage);
	});

	updateCategoriesAutocomplete(selectedLanguage);

})