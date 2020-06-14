<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Responses;

use ExampleCommentServiceClient\Models\Comment;

/**
 * Class GetComments
 *
 * @package ExampleCommentServiceClient\Models\Responses
 */
class GetComments extends BaseResponse
{
    /**
     * @var Comment[]
     */
    public array $data;
}
