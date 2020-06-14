<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Transformers\Responses;

use ExampleCommentServiceClient\Models\Responses\GetComments;
use ExampleCommentServiceClient\Transformers\CommentTransformer;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GetCommentsResponseTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Responses
 */
class GetCommentsResponseTransformer extends JsonResponseTransformer
{
    /**
     * @var string
     */
    private static string $baseModelClassName = GetComments::class;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \ExampleCommentServiceClient\Models\Responses\GetComments
     */
    public function transform(ResponseInterface $response): GetComments
    {
        /** @var \ExampleCommentServiceClient\Models\Responses\GetComments $object */
        $object = new self::$baseModelClassName;

        foreach (parent::transform($response) as $key => $value) {
            $object->{$key} = $value;
        }

        $commentTransformer = new CommentTransformer();

        $object->data = array_map(
            fn ($comment) => $commentTransformer->transform($comment),
            $object->rawData['data']
        );

        return $object;
    }
}
