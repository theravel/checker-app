<?php namespace Forestest\Providers;

use AdamWathan\EloquentOAuth\EloquentOAuthServiceProvider;

class OauthServiceProvider extends EloquentOAuthServiceProvider {

	private $additionalProviderLookup = [
		'vk' => 'Forestest\\Services\\Oauth\\Providers\\VkontakteProvider',
	];

	public function __construct($app)
	{
		parent::__construct($app);
		$this->providerLookup = array_merge(
			$this->providerLookup,
			$this->additionalProviderLookup
		);
	}

}
