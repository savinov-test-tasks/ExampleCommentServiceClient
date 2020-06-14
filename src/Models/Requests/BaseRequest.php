<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models\Requests;

use Psr\Http\Message\RequestInterface;

/**
 * Class BaseRequest
 *
 * @package ExampleCommentServiceClient\Models\Requests
 */
class BaseRequest
{
    /**
     * @var \Psr\Http\Message\RequestInterface
     */
    public RequestInterface $request;
}
