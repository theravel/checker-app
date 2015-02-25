define([
	'jquery',
	'vendor/components/codemirror-5.0/lib/codemirror',
	'vendor/components/codemirror-5.0/mode/gfm/gfm',
], function($, CodeMirror) {

	var MarkdownEditor = function(markdownView) {

		var jEditorArea = $('#editor-area'),
			jInput = $('#editor-input'),
			jPreview = $('#markdown-view'),
			jPreviewBtn = $('#editor-preview-btn'),
			jEditBtn = $('#editor-edit-btn'),
			jEnableFullscreenBtn = $('#enable-fullscreen-btn'),
			jExitFullscreenBtn = $('#exit-fullscreen-btn'),
			editorArea = jEditorArea.get(0),

			editor = CodeMirror.fromTextArea($('#code').get(0), {
				mode: 'gfm',
				lineNumbers: true,
				matchBrackets: true,
				lineWrapping: false,
				theme: 'default',
				indentUnit: 4
			}),

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

			updateView = function() {
				markdownView.setValue(editor.getValue());
			}
		;

		jPreviewBtn.on('click', function() {
			updateView();
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

		this.updateView = updateView;
	}

	return MarkdownEditor;

});