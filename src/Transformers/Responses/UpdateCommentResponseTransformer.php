<?php declare(strict_types=1);


namespace ExampleCommentServiceClient\Transformers\Responses;


use ExampleCommentServiceClient\Models\Responses\UpdateComment;
use ExampleCommentServiceClient\Transformers\CommentTransformer;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UpdateCommentResponseTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Responses
 */
class UpdateCommentResponseTransformer extends JsonResponseTransformer
{
    /**
     * @var string
     */
    private static string $baseModelClassName = UpdateComment::class;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \ExampleCommentServiceClient\Models\Responses\UpdateComment
     */
    public function transform(ResponseInterface $response): UpdateComment
    {
        /** @var \ExampleCommentServiceClient\Models\Responses\UpdateComment $object */
        $object = new self::$baseModelClassName;

        foreach (parent::transform($response) as $key => $value) {
            $object->{$key} = $value;
        }

        $commentTransformer = new CommentTransformer();
        $object->data = $commentTransformer->transform($object->rawData['data']);

        return $object;
    }
}
