<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Transformers;

use Psr\Http\Message\ResponseInterface;

interface ResponseTransformerInterface
{
    public function transform(ResponseInterface $response);
}
