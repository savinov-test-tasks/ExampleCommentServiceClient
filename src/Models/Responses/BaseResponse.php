<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Responses;

use ExampleCommentServiceClient\Models\ApiError;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseResponse
 *
 * @package ExampleCommentServiceClient\Models\Responses
 */
class BaseResponse
{
    /**
     * @var ApiError[]
     */
    public array $errors;

    /**
     * @var ResponseInterface
     */
    public ResponseInterface $response;

    public array $rawData;
}
