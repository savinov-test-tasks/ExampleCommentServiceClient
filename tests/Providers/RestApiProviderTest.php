<?php declare(strict_types=1);

use ExampleCommentServiceClient\Providers\RestApiProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RestApiProviderTest extends \PHPUnit\Framework\TestCase
{
    const RESOURCE_URI = 'example.com/comments';

    public function getRestApiProvider($mock, &$container)
    {
        $history = Middleware::history($container);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        return new RestApiProvider(new Client(['handler' => $handlerStack]));
    }

    public function testGetRequest()
    {
        $payload = [
            'data' => 'test',
        ];

        $mock = new MockHandler(
            [
                new Response(200, [], 'Hello, World'),
                new Response(200, [], json_encode($payload)),
            ]
        );

        $container = [];

        $restApiProvider = $this->getRestApiProvider($mock, $container);

        $request = new GuzzleHttp\Psr7\Request('GET', self::RESOURCE_URI);

        try {
            $restApiProvider->get($request, []);
        } catch (Exception $e) {
            $this->assertEquals('json_decode error: Syntax error', $e->getMessage());
        }

        $this->assertEquals(
            $payload,
            json_decode((string) $restApiProvider->get($request)->getBody(), true)
        );

        $this->checkContainerCases(
            [0 => function (RequestInterface $request, ResponseInterface $response) {
                $this->assertEquals('GET', $request->getMethod());
                $this->assertEquals(self::RESOURCE_URI, $request->getUri());
            }],
            $container
        );
    }

    public function testAccessTokenWasSent()
    {
        $payload = [
            'data' => 'test',
        ];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($payload)),
            ]
        );

        $container = [];

        $restApiProvider = $this->getRestApiProvider($mock, $container);

        $testToken = 'TEST';
        $restApiProvider->setAccessToken($testToken);

        $request = new GuzzleHttp\Psr7\Request('GET', self::RESOURCE_URI);

        $restApiProvider->get($request, []);

        $this->checkContainerCases(
            [0 => function (
                RequestInterface $request,
                ResponseInterface $response
            ) use ($testToken) {
                $this->assertArrayHasKey('Authorization', $request->getHeaders());
                $this->assertEquals(
                    'OAuth ' . $testToken,
                    $request->getHeader('Authorization')[0]
                );
            }],
            $container
        );
    }

    public function testSendsRequestInterface()
    {
        $payload = [
            'data' => 'test',
        ];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($payload)),
            ]
        );

        $container = [];

        $restApiProvider = $this->getRestApiProvider($mock, $container);

        $method = 'GET';
        $uri = '/test';
        $request = new GuzzleHttp\Psr7\Request($method, $uri, []);

        $restApiProvider->request($request, []);

        $this->checkContainerCases(
            [0 =>
                function (
                    RequestInterface $request,
                    ResponseInterface $response
                ) use (
                    $method,
                    $uri
                ) {
                    $this->assertEquals($method, $request->getMethod());
                    $this->assertEquals($uri, $request->getUri());
                },
            ],
            $container
        );
    }

    private function checkContainerCases($cases, &$container = [])
    {
        for ($it = 0, $transaction = $container[$it]; $it < count($container); $it++) {
            /**
             * @var $request GuzzleHttp\Psr7\Request
             * @var $response GuzzleHttp\Psr7\Response
             */
            $request = $transaction['request'];
            $response = $transaction['response'];

            if (isset($cases[$it])) {
                $cases[$it]($request, $response);
            }
        }
    }
}
