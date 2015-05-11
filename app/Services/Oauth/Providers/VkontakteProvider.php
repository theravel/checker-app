<?php namespace Forestest\Services\Oauth\Providers;

use AdamWathan\EloquentOAuth\Providers\Provider;
use AdamWathan\EloquentOAuth\Exceptions\InvalidAuthorizationCodeException;

class VkontakteProvider extends Provider
{
	protected $authorizeUrl = 'https://oauth.vk.com/authorize';
	protected $accessTokenUrl = 'https://oauth.vk.com/access_token';
	protected $userDataUrl = 'https://api.vk.com/method/users.get?fields=%s&access_token=%s';
	protected $userEmail;
	protected $emptyEmailReplacement = '%s@vk.com';

	protected $userDataFields = [
		'nickname',
		'photo_100',
	];

	protected $scope = [
		'email',
	];

	/*** Override logic ***/
	protected function buildUserDataUrl()
	{
		return sprintf(
			$this->getUserDataUrl(),
			implode(',', $this->userDataFields),
			$this->accessToken
		);
	}

	/*** Implement abstract methods ***/
	protected function getAuthorizeUrl()
	{
		return $this->authorizeUrl;
	}

	protected function getAccessTokenBaseUrl()
	{
		return $this->accessTokenUrl;
	}

	protected function getUserDataUrl()
	{
		return $this->userDataUrl;
	}

	protected function parseTokenResponse($response)
	{
		$json = json_decode($response);
		if (!isset($json->access_token)) {
			throw new InvalidAuthorizationCodeException;
		}
		if (isset($json->email)) {
			$this->userEmail = $json->email;
		}
		return $json->access_token;
	}

	protected function parseUserDataResponse($response)
	{
		$json = json_decode($response, true);
		if (isset($json['response'][0])) {
			return $json['response'][0];
		} else {
			throw new \UnexpectedValueException('VK response seems invalid');
		}
	}

	protected function userId()
	{
		return $this->getProviderUserData('uid');
	}

	protected function nickname()
	{
		$nickname = $this->getProviderUserData('nickname');
		if ($nickname) {
			return $nickname;
		} else {
			return sprintf(
				'%s %s',
				$this->firstName(),
				$this->lastName()
			);
		}
	}

	protected function firstName()
	{
		return $this->getProviderUserData('first_name');
	}

	protected function lastName()
	{
		return $this->getProviderUserData('last_name');
	}

	protected function imageUrl()
	{
		return $this->getProviderUserData('photo_100');
	}

	protected function email()
	{
		if (null === $this->userEmail) {
			// Vkontakte allows users to provide no email
			$this->userEmail = sprintf($this->emptyEmailReplacement, $this->userId());
		}
		return $this->userEmail;
	}

}
