<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Requests;


/**
 * Class UpdateComment
 *
 * @package ExampleCommentServiceClient\Models\Requests
 */
class UpdateComment extends BaseRequest
{
    /**
     * @var int
     */
    public int $id;
    /**
     * @var array
     */
    public array $updatedFields;

    public function getId()
    {
        return $this->id;
    }
}
