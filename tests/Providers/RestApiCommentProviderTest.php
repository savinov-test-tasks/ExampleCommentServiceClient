<?php declare(strict_types=1);

use ExampleCommentServiceClient\Providers\RestApiCommentProvider;
use ExampleCommentServiceClient\Providers\RestApiProviderInterface;
use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;
use Psr\Http\Message\ResponseInterface;


class RestApiCommentProviderTest extends \PHPUnit\Framework\TestCase
{
    private RestApiCommentProvider $restApiCommentProvider;
    private $mockRestApiProvider;
    private $mockRequestTransformer;
    private $mockResponseTransformer;
    private $mockResponseInterface;

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

        $this->restApiCommentProvider = new RestApiCommentProvider(
            $this->mockRestApiProvider,
            'test'
        );
    }

    public function testShouldCreateComment()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\AddComment::class
        )->getMock();

        $mockResponse = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Responses\AddComment::class
        )->getMock();

        $this->mockResponseTransformer
            ->expects($this->once())
            ->method('transform')
            ->willReturn($mockResponse);

        $this->mockRestApiProvider
            ->expects($this->once())
            ->method('post')
            ->willReturn($this->mockResponseInterface);

        $result = $this->restApiCommentProvider->addComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertSame($mockResponse, $result);
    }

    public function testShouldUpdateComment()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\UpdateComment::class
        )->getMock();

        $mockRequest->expects($this->once())->method('getId')->willReturn(3);

        $mockResponse = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Responses\UpdateComment::class
        )->getMock();

        $this->mockResponseTransformer
            ->expects($this->once())
            ->method('transform')
            ->willReturn($mockResponse);

        $this->mockRestApiProvider
            ->expects($this->once())
            ->method('put')
            ->willReturn($this->mockResponseInterface);

        $result = $this->restApiCommentProvider->updateComment(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertSame($mockResponse, $result);
    }

    public function testShouldGetComments()
    {
        $mockRequest = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Requests\GetComments::class
        )->getMock();

        $mockResponse = $this->getMockBuilder(
            \ExampleCommentServiceClient\Models\Responses\GetComments::class
        )->getMock();

        $this->mockResponseTransformer
            ->expects($this->once())
            ->method('transform')
            ->willReturn($mockResponse);

        $this->mockRestApiProvider
            ->expects($this->once())
            ->method('get')
            ->willReturn($this->mockResponseInterface);

        $result = $this->restApiCommentProvider->getComments(
            $mockRequest,
            $this->mockRequestTransformer,
            $this->mockResponseTransformer
        );

        $this->assertSame($mockResponse, $result);
    }
}
