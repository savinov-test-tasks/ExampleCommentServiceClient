<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Providers;

use ExampleCommentServiceClient\Models\Comment;

use ExampleCommentServiceClient\Models\Requests\GetComments as GetCommentsRequest;
use ExampleCommentServiceClient\Models\Responses\GetComments as GetCommentsResponse;

use ExampleCommentServiceClient\Models\Requests\AddComment as AddCommentRequest;
use ExampleCommentServiceClient\Models\Responses\AddComment as AddCommentResponse;

use ExampleCommentServiceClient\Models\Requests\UpdateComment as UpdateCommentRequest;
use ExampleCommentServiceClient\Models\Responses\UpdateComment as UpdateCommentResponse;

use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;
use ExampleCommentServiceClient\Transformers\TransformerInterface;

/**
 * Interface CommentApiProviderInterface
 *
 * @package ExampleCommentServiceClient\Providers
 */
interface CommentApiProviderInterface
{
    /**
     * @param GetCommentsRequest                                                     $request
     *
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return GetCommentsResponse
     */
    public function getComments(
        GetCommentsRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): GetCommentsResponse;

    /**
     * @param AddCommentRequest                                                      $request
     *
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return AddCommentResponse
     */
    public function addComment(
        AddCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): AddCommentResponse;

    /**
     * @param UpdateCommentRequest                                                   $request
     *
     * @param RequestTransformerInterface  $requestTransformer
     * @param ResponseTransformerInterface $responseTransformer
     *
     * @return UpdateCommentResponse
     */
    public function updateComment(
        UpdateCommentRequest $request,
        RequestTransformerInterface $requestTransformer,
        ResponseTransformerInterface $responseTransformer
    ): UpdateCommentResponse;
}
