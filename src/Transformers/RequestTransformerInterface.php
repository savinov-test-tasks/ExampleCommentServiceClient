<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Transformers;

use Psr\Http\Message\RequestInterface;

interface RequestTransformerInterface
{
    public function transform($request): RequestInterface;
}
