'use strict';

require.config({
	baseUrl: "/",
	paths: {
		jquery: 'vendor/js/jquery-2.1.3.min',
		bootstrap: 'vendor/js/bootstrap-3.3.2.min',
		marked: 'vendor/js/marked-0.3.3.min',
		highlight: 'vendor/components/highlight-8.4/highlight.pack',
    },
	shim: {
		bootstrap: {
			deps: ['jquery']
		}
	}
});

require(['bootstrap']);