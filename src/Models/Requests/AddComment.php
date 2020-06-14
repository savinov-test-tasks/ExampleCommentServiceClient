<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Requests;


use ExampleCommentServiceClient\Models\Comment;

/**
 * Class AddComment
 *
 * @package ExampleCommentServiceClient\Models\Requests
 */
class AddComment extends BaseRequest
{
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $text;
}
