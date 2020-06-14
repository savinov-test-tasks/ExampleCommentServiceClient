<?php declare(strict_types=1);


namespace ExampleCommentServiceClient\Transformers\Responses;


use ExampleCommentServiceClient\Models\Comment;
use ExampleCommentServiceClient\Models\Responses\AddComment;
use ExampleCommentServiceClient\Transformers\CommentTransformer;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AddCommentResponseTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Responses
 */
class AddCommentResponseTransformer extends JsonResponseTransformer
{
    /**
     * @var string
     */
    private static string $baseModelClassName = AddComment::class;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \ExampleCommentServiceClient\Models\Responses\AddComment
     */
    public function transform(ResponseInterface $response): AddComment
    {
        /** @var \ExampleCommentServiceClient\Models\Responses\AddComment $object */
        $object = new self::$baseModelClassName;

        foreach (parent::transform($response) as $key => $value) {
            $object->{$key} = $value;
        }

        $commentTransformer = new CommentTransformer();
        $object->data = $commentTransformer->transform($object->rawData['data']);

        return $object;
    }
}
