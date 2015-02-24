define([
    'jquery'
], function($) {

	var MarkdownEditor = function() {

		var jEditorArea = $('#editor-area'),
			jInput = $('#editor-input'),
			jPreview = $('#editor-preview'),
			jPreviewBtn = $('#editor-preview-btn'),
			jEditBtn = $('#editor-edit-btn'),
			jEnableFullscreenBtn = $('#enable-fullscreen-btn'),
			jExitFullscreenBtn = $('#exit-fullscreen-btn'),
			editorArea = jEditorArea.get(0),
			defaultLanguage,

			editor = CodeMirror.fromTextArea($('#code').get(0), {
				mode: 'gfm',
				lineNumbers: true,
				matchBrackets: true,
				lineWrapping: false,
				theme: 'default',
				indentUnit: 4
			}),
			languageOverrides = {
				js: 'javascript',
				html: 'xml'
			},

			enableFullScreen = function(element) {
				if (element.requestFullScreen) {
					element.requestFullScreen();
				} else if (element.mozRequestFullScreen) {
					element.mozRequestFullScreen();
				} else if (element.webkitRequestFullScreen) {
					element.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
				} else if (element.msRequestFullscreen) {
					// does someone really use it?
					element.msRequestFullscreen();
				}
			},

			exitFullScreen = function() {
				if (document.exitFullscreen) {
					document.exitFullscreen();
				} else if (document.mozExitFullscreen) {
					document.mozExitFullscreen();
				} else if (document.webkitExitFullscreen) {
					document.webkitExitFullscreen();
				} else if (document.msExitFullscreen) {
					document.msExitFullscreen();
				}
			},

			triggerFullscreenExit = function() {		
				$(jEnableFullscreenBtn).removeClass('hidden');
				$(jExitFullscreenBtn).addClass('hidden');
				jEditorArea.removeClass('panel-fullscreen');
				exitFullScreen();
			},

			setOutput = function(val) {
				var equation = val.replace(/<equation>((.*?\n)*?.*?)<\/equation>/ig, function(a, b){
					return '<img src="http://latex.codecogs.comp/ng.latex?' + encodeURIComponent(b) + '" />';
				});
				jPreview.html(marked(equation));
			},

			setDefaultLanguage = function(lang) {
				defaultLanguage = lang;
				setOutput(editor.getValue());
			}
			;

		marked.setOptions({
			highlight: function(code, lang){
				if (!lang) {
					lang = defaultLanguage;
				}
				if (languageOverrides[lang]) {
					lang = languageOverrides[lang];
				}
				return hljs.LANGUAGES[lang] ?
					hljs.highlight(lang, code).value :
					code;
			}
		});

		jPreviewBtn.on('click', function() {
			setOutput(editor.getValue());
			$([jInput, jPreview, jPreviewBtn, jEditBtn]).toggleClass('hidden');
		});

		jEditBtn.on('click', function() {
			$([jInput, jPreview, jPreviewBtn, jEditBtn]).toggleClass('hidden');
		});

		jEnableFullscreenBtn.on('click', function() {
			$([jEnableFullscreenBtn, jExitFullscreenBtn]).toggleClass('hidden');
			jEditorArea.addClass('panel-fullscreen');
			enableFullScreen(editorArea);
		});

		jExitFullscreenBtn.add('#editor-help-btn').on('click', triggerFullscreenExit);

		this.setDefaultLanguage = setDefaultLanguage;
	}

	return new MarkdownEditor();

});