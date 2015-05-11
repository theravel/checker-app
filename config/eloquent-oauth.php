<?php

return [
	'table' => 'oauth_identities',
	'providers' => [
		'facebook' => [
			'id' => env('OAUTH_FACEBOOK_ID'),
			'secret' => env('OAUTH_FACEBOOK_SECRET'),
			'redirect' => env('PUBLIC_SCHEME') . '://' . env('PUBLIC_URL') . '/auth/oauth-login/facebook',
			'scope' => [],
		],
		'google' => [
			'id' => env('OAUTH_GOOGLE_ID'),
			'secret' => env('OAUTH_GOOGLE_SECRET'),
			'redirect' => env('PUBLIC_SCHEME') . '://' . env('PUBLIC_URL') . '/auth/oauth-login/google',
			'scope' => [],
		],
		'github' => [
			'id' => env('OAUTH_GITHUB_ID'),
			'secret' => env('OAUTH_GITHUB_SECRET'),
			'redirect' => env('PUBLIC_SCHEME') . '://' . env('PUBLIC_URL') . '/auth/oauth-login/github',
			'scope' => [],
		],
//		'linkedin' => [
//			'id' => '12345678',
//			'secret' => 'y0ur53cr374ppk3y',
//			'redirect' => 'https://example.com/your/linkedin/redirect',
//			'scope' => [],
//		],
//		'instagram' => [
//			'id' => '12345678',
//			'secret' => 'y0ur53cr374ppk3y',
//			'redirect' => 'https://example.com/your/instagram/redirect',
//			'scope' => [],
//		],
//		'soundcloud' => [
//			'id' => '12345678',
//			'secret' => 'y0ur53cr374ppk3y',
//			'redirect' => 'https://example.com/your/soundcloud/redirect',
//			'scope' => [],
//		],
//		'strava' => [
//			'id' => '12345678',
//			'secret' => 'y0ur53cr374ppk3y',
//			'redirect' => 'https://example.com/your/strava/redirect',
//			'scope' => [],
//		],
	],
];
