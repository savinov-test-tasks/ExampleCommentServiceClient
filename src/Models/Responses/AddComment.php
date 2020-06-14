<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Responses;


use ExampleCommentServiceClient\Models\Comment;

/**
 * Class AddComment
 *
 * @package ExampleCommentServiceClient\Models\Responses
 */
class AddComment extends BaseResponse
{
    /**
     * @var \ExampleCommentServiceClient\Models\Comment
     */
    public Comment $data;
}
