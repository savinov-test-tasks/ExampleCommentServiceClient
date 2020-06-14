<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class RestApiProvider
 *
 * @package ExampleCommentServiceClient\Providers
 */
class RestApiProvider implements RestApiProviderInterface
{
    /**
     * @var Client
     */
    private Client $guzzleClient;

    /**
     * @var string
     */
    private string $accessToken;

    /**
     * RestApiProvider constructor.
     *
     * @param \GuzzleHttp\Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $accessToken
     *
     * @return $this
     */
    public function setAccessToken(string $accessToken): RestApiProvider
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface|null $request
     * @param                                         $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(RequestInterface $request, $options)
    {
        return $this->guzzleClient->send($request, array_merge($options, $this->buildOptions()));
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->request($request, $options);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->request($request, $options);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->request($request, $options);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array                              $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(RequestInterface $request, array $options = []): ResponseInterface
    {
        return $this->request($request, $options);
    }

    /**
     * @param array $appendOptions
     *
     * @return array
     */
    private function buildOptions($appendOptions = [])
    {
        return array_merge(
            [
                RequestOptions::HEADERS => $this->getRequestHeaders(),
            ],
            $appendOptions
        );
    }

    /**
     * @return iterable
     */
    private function getRequestHeaders(): iterable
    {
        $headers = [
            'Accept' => 'application/json',
        ];

        if (isset($this->accessToken)) {
            $headers['Authorization'] = 'OAuth ' . $this->accessToken;
        }

        return $headers;
    }

    /**
     * @param $method
     * @param $uri
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequestInterface($method, $uri): RequestInterface
    {
        return new Request($method, $uri);
    }
}
