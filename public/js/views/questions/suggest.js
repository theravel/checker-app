require([
	'jquery',
	'components/markdown-editor/markdown-editor',
	'components/markdown-view/markdown-view',
	'tagIt',
], function($, MarkdownEditor, MarkdownView) {

	var TYPE_SINGLE_LINE = 1,
		TYPE_MULTI_LINE = 2,
		TYPE_RADIOS = 3,
		TYPE_CHECKBOXES = 4;

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
		allowSpaces: true,
		placeholderText: $('#t-categories-placeholder').text(),
		autocomplete: {
			source: function(request, response) {
				var term = request.term.toLowerCase(),
					matches = [];
				
				for (var i = 0; i < categoriesAutocomplete.length; i++) {
					var name = categoriesAutocomplete[i].toLowerCase();
					if (0 === name.indexOf(term)) {
						matches.push(categoriesAutocomplete[i]);
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

	$('#question-type').on('change', function() {
		var type = $(this).val();
	});

	$('.answers-container').on('click', '.answer-correct-toggle', function() {
		var jElement = $(this);
		jElement.toggleClass('answer-correct-ok answer-correct-wrong');
		jElement.find('label').toggleClass('glyphicon-remove-circle glyphicon-ok-circle');
		if (jElement.hasClass('answer-correct-ok')) {
			;
		} else {
			// @TODO checkboxes/radios
		}
	});

	$('.answers-container').on('click', '.answer-remove', function() {
		$(this).parents('.answer-wrapper').remove();
	});

	$('.add-answer').on('click', function() {
		var container = $(this).parents('.answers-container');
		$('.answer-template').clone()
				.removeClass('answer-template')
				.appendTo(container);
	});
})