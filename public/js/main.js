'use strict';

require.config({
	baseUrl: "/",
	paths: {
		jquery: 'vendor/js/jquery-2.1.3.min',
		jqueryUi: 'vendor/components/jquery-ui-1.11.3/jquery-ui.min',
		bootstrap: 'vendor/js/bootstrap-3.3.2.min',
		tagIt: 'vendor/components/tagit-2.0/tag-it.min',
    },
	shim: {
		jqueryUi: {
			deps: ['jquery']
		},
		bootstrap: {
			deps: ['jquery']
		},
		tagIt: {
			deps: ['jqueryUi']
		}
	}
});

require(['bootstrap']);