require([
	'jquery',
	'components/markdown-editor/markdown-editor',
	'components/markdown-view/markdown-view',
	'tagIt',
], function($, MarkdownEditor, MarkdownView) {
	'use strict';

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
		jAnswersActiveArea = jAnswersBlock.find('#active-answers-' + answersType)
	;


	/*** categories-tags ***/
	var updateCategoriesAutocomplete = function(selectedLanguage) {
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


	/*** answers area ***/
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
		resetAnswerType();
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
		validationCheck.noAnswers();
	});


	/*** validation and submit ***/
	var jErrorMessages = {
			emptyText: $('#error-empty-text'),
			noAnswers: $('#error-no-answers'),
			emptyAnswer: $('#error-empty-answer'),
			noCorrect: $('#error-no-correct')
		},
		validationCheck = {
			emptyText: function() {
				jErrorMessages.emptyText.toggleClass('hidden', editor.getValue().length > 0);
				return editor.getValue().length > 0;
			},
			noAnswers: function() {
				if ([TYPE_SINGLE_LINE, TYPE_MULTI_LINE].indexOf(answersType) >= 0) {
					jErrorMessages.noAnswers.addClass('hidden');
					return true;
				}
				var answers = jAnswersActiveArea.find('.answer-wrapper:visible');
				jErrorMessages.noAnswers.toggleClass('hidden', answers.length > 1);
				return answers.length > 1;
			},
			emptyAnswer: function() {
				var hasEmpty = false;
				jAnswersActiveArea.find('input[type="text"]:visible').each(function() {
					if (!$.trim($(this).val()).length) {
						hasEmpty = true;
					}
				});
				jErrorMessages.emptyAnswer.toggleClass('hidden', !hasEmpty);
				return !hasEmpty;
			},
			noCorrect: function() {
				if ([TYPE_SINGLE_LINE, TYPE_MULTI_LINE].indexOf(answersType) >= 0) {
					jErrorMessages.noCorrect.addClass('hidden');
					return true;
				}
				var hasFlagged = jAnswersActiveArea.find('input:checked').length > 0;
				jErrorMessages.noCorrect.toggleClass('hidden', hasFlagged);
				return hasFlagged;
			}
		},
		resetAnswerType = function() {
			$('#validation-errors .alert').addClass('hidden');
		}
	;

	$('.answers-container').on('keyup', 'input[type="text"]', function() {
		if ($.trim($(this).val()).length > 0) {
			validationCheck.emptyAnswer();
		}
	});

	editor.addEventHandler('change', function() {
		if (editor.getValue().length > 0) {
			validationCheck.emptyText();
		}
	});

	$('#question-suggest').on('submit', function() {
		var valid = true;
		valid &= validationCheck.emptyText();
		valid &= validationCheck.noAnswers();
		valid &= validationCheck.emptyAnswer();
		valid &= validationCheck.noCorrect();
		if (valid) {
			$.ajax({
				url: '/questions/suggest',
				type: 'POST',
				data: $(this).serialize()
			});
		} else {
			$('html, body').animate({scrollTop: 0}, 300);
		}
		return false;
	});
})