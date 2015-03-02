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
		jAnswersBlock = $('#question-answers-block'),
		jTypeSelect = $('#question-type'),
		answersType = parseInt(jTypeSelect.val()),
		jAnswersActiveArea = jAnswersBlock.find('#active-answers-' + answersType),

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

	preview.setDefaultLanguage(selectedLanguage);
	updateCategoriesAutocomplete(selectedLanguage);

	jTypeSelect.on('change', function() {
		answersType = parseInt($(this).val());
		switch (answersType) {
			case TYPE_RADIOS:
			case TYPE_CHECKBOXES:
				jAnswersBlock.removeClass('hidden');
				jAnswersBlock.find('.active-answers-area').addClass('hidden');
				jAnswersActiveArea = jAnswersBlock.find('#active-answers-' + answersType)
					.removeClass('hidden');
				break;
			case TYPE_SINGLE_LINE:
			case TYPE_MULTI_LINE:
			default:
				jAnswersBlock.addClass('hidden');
				break;
		}
	});

	$('.answers-container').on('change', '.correct-switch', function() {
		var jElement = $(this);
		jElement.siblings('label').toggleClass('glyphicon-remove-circle glyphicon-ok-circle');
		jElement.parent('.answer-correct-toggle').toggleClass('answer-correct-ok answer-correct-wrong');
	});

	$('.answers-container').on('click', '.answer-correct-toggle', function() {
		var jElement = $(this),
			jSwitch = jElement.find('.correct-switch'),
			prevState = jSwitch.prop('checked');
		jSwitch.prop('checked', !prevState).trigger('change');
		if (TYPE_RADIOS === answersType) {
			jAnswersActiveArea.find('.answer-correct-ok .correct-switch')
				.not(jSwitch)
				.prop('checked', false)
				.trigger('change');
		}
	});

	$('.answers-container').on('click', '.answer-remove', function() {
		$(this).parents('.answer-wrapper').remove();
	});

	$('.add-answer').on('click', function() {
		var template = jAnswersActiveArea.find('.answer-template').clone();
		template.attr('name', template.attr('data-name'))
			.removeAttr('data-name')
			.removeClass('answer-template')
			.appendTo(jAnswersActiveArea);
	});

	$('#question-suggest').on('submit', function() {
		var text = $.trim(editor.getValue());
		console.log(text);
		$.ajax({
			url: '/questions/suggest',
			type: 'POST',
			data: $(this).serialize()
		});
		return false;
	})
})