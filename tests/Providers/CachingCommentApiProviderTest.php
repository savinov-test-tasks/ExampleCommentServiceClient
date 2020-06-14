<?php


use ExampleCommentServiceClient\Providers\CachingCommentApiProvider;
use ExampleCommentServiceClient\Providers\RestApiCommentProvider;
use ExampleCommentServiceClient\Providers\RestApiProviderInterface;
use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;
use Psr\Http\Message\ResponseInterface;
use ExampleCommentServiceClient\Providers\CommentApiProviderInterface;

class CachingCommentApiProviderTest extends \PHPUnit\Framework\TestCase
{
    private $mockRestApiCommentProvider;
    private CachingCommentApiProvider $cachingProvider;
    private $mockRestApiProvider;
    private $mockRequestTransformer;
    private $mockResponseTransformer;
    private $mockResponseInterface;
    private $mockCache;

    public function setUp(): void
    {
        $this->mockRequestTransformer = $this->getMockBuilder(
            RequestTransformerInterface::class
        )->getMock();
        $this->mockResponseTransformer = $this->getMockBuilder(
            ResponseTransformerInterface::class
        )->getMock();

        $this->mockResponseInterface = $this->getMockBuilder(
            ResponseInterface::class
        )->getMock();

        $this->mockRestApiProvider = $this->getMockBuilder(
            RestApiProviderInterface::class
        )->getMock();

        $this->mockRestApiCommentProvider = $this->getMockBuilder(
            CommentApiProviderInterface::class
        )->getMock();

        $this->mockCache = $this->getMockBuilder(
            Psr\SimpleCache\CacheInterface::class
        )->getMock();

        $this->cachingProvider = new CachingCommentApiProvider(
            $this->mockCache,
            $this->mockRestApiCommentProvider
        );
    }

    public function testRequestHitCache()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\AddComment::class
        )->getMock();

        $mockResponse = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Responses\AddComment::class
        )->getMock();

        $this->mockCache
            ->expects($this->once())
            ->method('get')
            ->willReturn($mockResponse);

        $result = $this->cachingProvider->addComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertEquals($mockResponse, $result);
    }

    public function testRequestHitCacheOnSameRequests()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\AddComment::class
        )->getMock();

        $cache = [];
        $cacheHits = 0;

        $this->mockCache
            ->expects($this->exactly(2))
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($key, $default) use (&$cache, &$cacheHits) {
                        if (isset($cache[$key])) {
                            $cacheHits++;
                            return $cache[$key];
                        }

                        return $default;
                    }
                )
            );

        $this->mockCache
            ->expects($this->exactly(1))
            ->method('set')
            ->will(
                $this->returnCallback(
                    function ($key, $data) use (&$cache) {
                        $cache[$key] = $data;
                    }
                )
            );

        $this->cachingProvider->addComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertEquals(0, $cacheHits);

        $this->cachingProvider->addComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertEquals(1, $cacheHits);
    }

    public function testRequestMissCacheOnDifferentRequests()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\AddComment::class
        )->getMock();

        $mockRequestAnother = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\AddComment::class
        )->getMock();

        $cache = [];
        $cacheHits = 0;

        $this->mockCache
            ->expects($this->exactly(2))
            ->method('get')
            ->will(
                $this->returnCallback(
                    function ($key, $default) use (&$cache, &$cacheHits) {
                        if (isset($cache[$key])) {
                            $cacheHits++;
                            return $cache[$key];
                        }

                        return $default;
                    }
                )
            );

        $this->mockCache
            ->expects($this->exactly(2))
            ->method('set')
            ->will(
                $this->returnCallback(
                    function ($key, $data) use (&$cache) {
                        $cache[$key] = $data;
                    }
                )
            );

        $this->mockRestApiCommentProvider
            ->expects($this->exactly(2))
            ->method('addComment');

        $this->cachingProvider->addComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertEquals(0, $cacheHits);

        $this->cachingProvider->addComment(
            $mockRequestAnother,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertEquals(0, $cacheHits);
    }
}
