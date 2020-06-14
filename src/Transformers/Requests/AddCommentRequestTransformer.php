<?php declare(strict_types=1);


namespace ExampleCommentServiceClient\Transformers\Requests;

use ExampleCommentServiceClient\Models\Requests\AddComment;
use ExampleCommentServiceClient\Models\Requests\BaseRequest;
use Psr\Http\Message\RequestInterface;

/**
 * Class AddCommentRequestTransformer
 *
 * @package ExampleCommentServiceClient\Transformers\Requests
 */
class AddCommentRequestTransformer extends JsonRequestTransformer
{
    /**
     * @var string
     */
    private static string $baseModelClassName = AddComment::class;

    /**
     * @param $request
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function transform($request): RequestInterface
    {
        $this->checkType($request, self::$baseModelClassName);

        /** @var AddComment $request */
        $data = [
            'comment' => [
                'name' => $request->name,
                'text' => $request->text,
            ]
        ];

        $this->returnRequestWithAppendedData($data, $request);
    }
}
