<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Responses;


use ExampleCommentServiceClient\Models\Comment;

/**
 * Class UpdateComment
 *
 * @package ExampleCommentServiceClient\Models\Responses
 */
class UpdateComment extends BaseResponse
{
    /**
     * @var Comment
     */
    public Comment $data;
}
