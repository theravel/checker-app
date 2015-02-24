'use strict';

require.config({
	baseUrl: "/js",
    paths: {
        jquery: 'lib/jquery-2.1.3.min',
		bootstrap: 'lib/bootstrap-3.3.2.min'
    },
	shim: {
        bootstrap: {
            deps: ['jquery']
        }
	}
});

require(['bootstrap']);

require([
	'jquery',
	'components/markdown-editor'
], function($, editor) {

	$('#question-program-lang').on('change', function() {
		var language = $(this).val();
		editor.setDefaultLanguage(language);
	});

})