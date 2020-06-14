<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Providers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RestApiProviderInterface
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(
        RequestInterface $request
    ): ResponseInterface;

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function put(RequestInterface $request): ResponseInterface;

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post(RequestInterface $request): ResponseInterface;

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(RequestInterface $request): ResponseInterface;

    public function getRequestInterface($method, $uri): RequestInterface;
}
