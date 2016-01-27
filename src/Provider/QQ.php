<?php

namespace Azonwan\Auth\QQ\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class QQ extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Domain
     *
     * @var string
     */
    public $domain = 'https://graph.qq.com';


    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->domain.'/oauth2.0/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->domain.'/oauth2.0/token';
    }

    public function getBaseAccessOpenIdUrl(array $params)
    {
        return $this->domain.'/oauth2.0/me';
    }
    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->domain.'/user/get_user_info';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * Check a provider response for errors.
     *
     * @link   https://developer.github.com/v3/#client-errors
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['message'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }


    /**
     * Returns the method to use when requesting an access token.
     *
     * @return string HTTP method
     */
    protected function getAccessTokenMethod()
    {
        return self::METHOD_GET;
    }



    /**
     * Requests an access token using a specified grant and option set.
     *
     * @param  mixed $grant
     * @param  array $options
     * @return AccessToken
     */
    public function getAccessToken($grant, array $options = [])
    {
        $grant = $this->verifyGrant($grant);

        $params = [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
        ];

        $params   = $grant->prepareRequestParameters($params, $options);
        $request  = $this->getAccessTokenRequest($params);
        $response = $this->getResponse($request);
        $token    = $this->createAccessToken($response, $grant);

        return $token;
    }


    public function getAccessOpenId($grant, array $options = [])
    {
        $grant = $this->verifyGrant($grant);

        $params = [];
        $params   = $grant->prepareRequestParameters($params, $options);
        $method  = self::METHOD_GET;
        $url     = $this->getAccessOpenIdUrl($params);

        $request = $this->getRequest($method, $url, $options);
        $response = $this->getResponse($request);

        $openid = isset($response['openid']) ? $response['openid'] : '';
        return $openid;
    }


    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $user = new QQResourceOwner($response);

        return $user->setDomain($this->domain);
    }


    protected function getAccessOpenIdUrl(array $params)
    {
        $url = $this->getBaseAccessOpenIdUrl($params);

        if ($this->getAccessTokenMethod() === self::METHOD_GET) {
            $query = http_build_query($params);
            return $this->appendQuery($url, $query);
        }

        return $url;
    }


    public function getResourceOwner(AccessToken $token, $options)
    {
        $response = $this->fetchResourceOwnerDetails($token, $options);

        return $this->createResourceOwner($response, $token);
    }

    protected function fetchResourceOwnerDetails(AccessToken $token, $options)
    {
        $url = $this->getResourceOwnerDetailsUrl($token);

        $url = $url . "?" . http_build_query($options);
        $response = file_get_contents($url);

        return $this->parseJson($response);

    }
}
