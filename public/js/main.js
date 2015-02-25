'use strict';

require.config({
	baseUrl: "/",
	paths: {
		jquery: 'vendor/js/jquery-2.1.3.min',
		bootstrap: 'vendor/js/bootstrap-3.3.2.min',
    },
	shim: {
		bootstrap: {
			deps: ['jquery']
		}
	}
});

require(['bootstrap']);