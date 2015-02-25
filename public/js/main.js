'use strict';

require.config({
	baseUrl: "/js",
	paths: {
		jquery: 'lib/jquery-2.1.3.min',
		bootstrap: 'lib/bootstrap-3.3.2.min',
		marked: 'lib/marked-0.3.3.min',
    },
	shim: {
		bootstrap: {
			deps: ['jquery']
		}
	}
});

require(['bootstrap']);