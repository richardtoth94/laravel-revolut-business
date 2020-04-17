<?php

namespace tbclla\Revolut\Repositories;

use Illuminate\Support\Facades\Cache;
use tbclla\Revolut\Auth\AccessToken;
use tbclla\Revolut\Auth\RefreshToken;
use tbclla\Revolut\Interfaces\TokenRepository;

class CacheTokenRepository implements TokenRepository
{
	/**
	 * The cache key prefix
	 * 
	 * @var string
	 */
	const PREFIX = 'revolut-token.';

	public function getAccessToken()
	{
		return Cache::get(self::PREFIX . AccessToken::TYPE);
	}

	public function getRefreshToken()
	{
		return Cache::get(self::PREFIX . RefreshToken::TYPE);
	}

	public function createAccessToken(string $value)
	{
		$accessToken = new AccessToken([
			'value' => $value
		]);

		Cache::tags(['revolut', 'access_tokens'])->put(
			self::PREFIX . AccessToken::TYPE,
			$accessToken,
			$accessToken->getExpiration()
		);

		return $accessToken;
	}

	public function createRefreshToken(string $value)
	{
		$refreshToken = new RefreshToken([
			'value' => $value
		]);

		Cache::tags(['revolut', 'refresh_token'])->put(
			self::PREFIX . RefreshToken::TYPE,
			$refreshToken,
			$refreshToken->getExpiration()
		);

		return $refreshToken;
	}
}
