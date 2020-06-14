<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Providers;

use ExampleCommentServiceClient\Models\Requests\AddComment as AddCommentRequest;
use ExampleCommentServiceClient\Models\Requests\GetComments as GetCommentsRequest;
use ExampleCommentServiceClient\Models\Requests\UpdateComment as UpdateCommentRequest;
use ExampleCommentServiceClient\Models\Responses\AddComment as AddCommentResponse;
use ExampleCommentServiceClient\Models\Responses\GetComments as GetCommentsResponse;
use ExampleCommentServiceClient\Models\Responses\UpdateComment as UpdateCommentResponse;
use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;

use Psr\SimpleCache\CacheInterface;

/**
 * Class CachingCommentApiProvider
 *
 * @package ExampleCommentServiceClient\Providers
 */
class CachingCommentApiProvider implements CommentApiProviderInterface
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    private CacheInterface $cache;
    /**
     * @var \ExampleCommentServiceClient\Providers\CommentApiProviderInterface
     */
    private CommentApiProviderInterface $provider;

    /**
     * CachingCommentApiProvider constructor.
     *
     * @param \Psr\SimpleCache\CacheInterface                                    $cache
     * @param \ExampleCommentServiceClient\Providers\CommentApiProviderInterface $provider
     */
    public function __construct(CacheInterface $cache, CommentApiProviderInterface $provider)
    {
        $this->cache = $cache;
        $this->provider = $provider;
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\GetComments               $request
     * @param \ExampleCommentServiceClient\Transformers\RequestTransformerInterface  $requestTransformer
     * @param \ExampleCommentServiceClient\Transformers\ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\GetComments
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getComments(
        GetCommentsRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): GetCommentsResponse {
        $cacheKey = $this->calculateKeyFromRequest($request);
        $data = $this->cache->get($cacheKey);

        if ($data) {
            return $data;
        }

        $data = $this->provider->getComments($request, $requestTransformer, $responseTransformer);
        $this->cache->set($cacheKey, $data);

        return $data;
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\AddComment                $request
     * @param \ExampleCommentServiceClient\Transformers\RequestTransformerInterface  $requestTransformer
     * @param \ExampleCommentServiceClient\Transformers\ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\AddComment
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function addComment(
        AddCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): AddCommentResponse {
        $cacheKey = $this->calculateKeyFromRequest($request);
        $data = $this->cache->get($cacheKey);

        if ($data) {
            return $data;
        }

        $data = $this->provider->addComment($request, $requestTransformer, $responseTransformer);
        $this->cache->set($cacheKey, $data);

        return $data;
    }

    /**
     * @param \ExampleCommentServiceClient\Models\Requests\UpdateComment             $request
     * @param \ExampleCommentServiceClient\Transformers\RequestTransformerInterface  $requestTransformer
     * @param \ExampleCommentServiceClient\Transformers\ResponseTransformerInterface $responseTransformer
     *
     * @return \ExampleCommentServiceClient\Models\Responses\UpdateComment
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function updateComment(
        UpdateCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): UpdateCommentResponse {
        $cacheKey = $this->calculateKeyFromRequest($request);
        $data = $this->cache->get($cacheKey);

        if ($data) {
            return $data;
        }

        $data = $this->provider->updateComment($request, $requestTransformer, $responseTransformer);
        $this->cache->set($cacheKey, $data);

        return $data;
    }

    private function calculateKeyFromRequest($request)
    {
        return spl_object_hash($request);
    }

}
