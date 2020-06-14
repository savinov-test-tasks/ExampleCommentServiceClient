<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Transformers\Responses;


use ExampleCommentServiceClient\Models\ApiError;
use ExampleCommentServiceClient\Models\Responses\BaseResponse;
use ExampleCommentServiceClient\Transformers\ResponseTransformerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class JsonResponseTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Responses
 */
class JsonResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @var string
     */
    private static string $baseModelClassName = BaseResponse::class;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \ExampleCommentServiceClient\Models\Responses\BaseResponse
     */
    public function transform(ResponseInterface $response): BaseResponse
    {
        $data = \GuzzleHttp\json_decode($response->getBody(), true);

        /** @var \ExampleCommentServiceClient\Models\Responses\BaseResponse $object */
        $object = new self::$baseModelClassName;
        $object->response = $response;
        $object->rawData = $data;

        if (isset($data['errors'])) {
            $object->errors = array_map(
                fn ($error) => new ApiError($error['code'], $error['message']),
                $data['errors']
            );
        }

        return $object;
    }
}
