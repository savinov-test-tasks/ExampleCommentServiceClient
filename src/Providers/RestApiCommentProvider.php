<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Providers;


use ExampleCommentServiceClient\Models\Comment;

use ExampleCommentServiceClient\Models\Requests\BaseRequest;
use ExampleCommentServiceClient\Models\Requests\GetComments as GetCommentsRequest;
use ExampleCommentServiceClient\Models\Responses\GetComments as GetCommentsResponse;

use ExampleCommentServiceClient\Models\Requests\AddComment as AddCommentRequest;
use ExampleCommentServiceClient\Models\Responses\AddComment as AddCommentResponse;

use ExampleCommentServiceClient\Models\Requests\UpdateComment as UpdateCommentRequest;
use ExampleCommentServiceClient\Models\Responses\UpdateComment as UpdateCommentResponse;
use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RestApiCommentProvider
 *
 * @package ExampleCommentServiceClient\Providers
 */
class RestApiCommentProvider implements CommentApiProviderInterface
{
    /**
     * @var RestApiProviderInterface
     */
    private RestApiProviderInterface $restApiProvider;

    private string $resourceUri;

    /**
     * RestApiCommentProvider constructor.
     *
     * @param \ExampleCommentServiceClient\Providers\RestApiProviderInterface $restApiProvider
     * @param string                                                          $resourceUri
     */
    public function __construct(RestApiProviderInterface $restApiProvider, string $resourceUri)
    {
        $this->restApiProvider = $restApiProvider;
        $this->resourceUri = $resourceUri;
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\GetComments               $request
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\GetComments
     */
    public function getComments(
        GetCommentsRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): GetCommentsResponse {
        $this->setRequestInterfaceOnRequest($request, 'GET', $this->buildUri());
        return $this->constructResponse(
            $this->restApiProvider->get($requestTransformer->transform($request)),
            $responseTransformer
        );
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\AddComment                $request
     *
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\AddComment
     */
    public function addComment(
        AddCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): AddCommentResponse {
        $this->setRequestInterfaceOnRequest($request, 'POST', $this->buildUri());
        return $this->constructResponse(
            $this->restApiProvider->post($requestTransformer->transform($request)),
            $responseTransformer
        );
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\UpdateComment             $request
     *
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\UpdateComment
     */
    public function updateComment(
        UpdateCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): UpdateCommentResponse {
        $this->setRequestInterfaceOnRequest($request, 'PUT', $this->buildUri([$request->getId()]));
        return $this->constructResponse(
            $this->restApiProvider->put($requestTransformer->transform($request)),
            $responseTransformer
        );
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface                                    $baseResponse
     *
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return mixed
     */
    private function constructResponse(
        ResponseInterface $baseResponse,
        ResponseTransformerInterface $responseTransformer
    ) {
        return $responseTransformer->transform($baseResponse);
    }

    private function buildUri($paths = [], array $parameters = [])
    {
        return join(
            '?',
            [
                join('/', array_merge([$this->resourceUri], $paths)), http_build_query($parameters)
            ]
        );
    }

    private function setRequestInterfaceOnRequest(
        BaseRequest &$request,
        $method,
        $uri
    ) {
        if (isset($request->request) && $request->request instanceof RequestInterface) {
            return;
        }

        $request->request = $this->restApiProvider->getRequestInterface($method, $uri);
    }
}
