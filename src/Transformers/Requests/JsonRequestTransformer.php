<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Transformers\Requests;


use ExampleCommentServiceClient\Transformers\RequestTransformerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class JsonRequestTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Requests
 */
class JsonRequestTransformer implements RequestTransformerInterface
{
    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private StreamInterface $streamInterface;

    /**
     * JsonRequestTransformer constructor.
     *
     * @param \Psr\Http\Message\StreamInterface $streamInterface
     */
    public function __construct(
        StreamInterface $streamInterface
    ) {
        $this->streamInterface = $streamInterface;
    }

    /**
     * @param $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function transform($request): RequestInterface
    {
        if (!($request->request instanceof RequestInterface)) {
            throw new \InvalidArgumentException('RequestInterface should be set on request');
        }

        return $request->request;
    }

    /**
     * @param $request
     * @param $type
     */
    protected function checkType($request, $type)
    {
        if (!($request instanceof $type)) {
            throw new \InvalidArgumentException(
                'Request should be of type ' . $type
            );
        }
    }

    /**
     * @param $data
     * @param $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function returnRequestWithAppendedData($data, &$request): RequestInterface
    {
        $stream = $this->getStream();
        $stream->write(\GuzzleHttp\json_encode($data));
        $request->request->withBody($stream);

        return $request->request;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function getStream()
    {
        return $this->streamInterface;
    }
}
