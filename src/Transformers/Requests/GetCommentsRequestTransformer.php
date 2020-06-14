<?php declare(strict_types=1);


namespace ExampleCommentServiceClient\Transformers\Requests;

use ExampleCommentServiceClient\Models\Requests\BaseRequest;
use ExampleCommentServiceClient\Models\Requests\GetComments;
use Psr\Http\Message\RequestInterface;

/**
 * Class GetCommentsRequestTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Requests
 */
class GetCommentsRequestTransformer extends JsonRequestTransformer
{
    /**
     * @var string
     */
    private static string $baseModelClassName = GetComments::class;

    /**
     * @param $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function transform($request): RequestInterface
    {
        return parent::transform($request);
    }
}
