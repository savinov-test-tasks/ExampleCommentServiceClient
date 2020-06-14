<?php declare(strict_types=1);


namespace ExampleCommentServiceClient;


use ExampleCommentServiceClient\Models\Responses\UpdateComment;
use ExampleCommentServiceClient\Models\Responses\AddComment;
use ExampleCommentServiceClient\Models\Responses\GetComments;
use ExampleCommentServiceClient\Providers\CommentApiProviderInterface;
use ExampleCommentServiceClient\Transformers\Requests\GetCommentsRequestTransformer;
use ExampleCommentServiceClient\Transformers\Responses\GetCommentsResponseTransformer;
use Psr\Http\Message\StreamInterface;

/**
 * Class CommentApi
 *
 * @package ExampleCommentServiceClient
 */
class CommentApi
{
    /**
     * @var \ExampleCommentServiceClient\Providers\CommentApiProviderInterface
     */
    private CommentApiProviderInterface $restApiCommentProvider;
    /**
     * @var StreamInterface
     */
    private StreamInterface $streamInterface;

    /**
     * CommentApi constructor.
     *
     * @param CommentApiProviderInterface $restApiCommentProvider
     */
    public function __construct(CommentApiProviderInterface $restApiCommentProvider)
    {
        $this->restApiCommentProvider = $restApiCommentProvider;
        $this->streamInterface = \GuzzleHttp\Psr7\stream_for('');
    }

    /**
     * @return \ExampleCommentServiceClient\Models\Responses\GetComments
     */
    public function getComments(): GetComments
    {
        $request = new \ExampleCommentServiceClient\Models\Requests\GetComments();

        return $this->restApiCommentProvider->getComments(
            $request,
            new GetCommentsRequestTransformer($this->streamInterface),
            new GetCommentsResponseTransformer(),
        );
    }

    /**
     * @param string $name
     * @param string $text
     *
     * @return \ExampleCommentServiceClient\Models\Responses\AddComment
     */
    public function addComment(string $name, string $text): AddComment
    {
        $request = new \ExampleCommentServiceClient\Models\Requests\AddComment();

        $request->name = $name;
        $request->text = $text;

        return $this->restApiCommentProvider->addComment(
            $request,
            new GetCommentsRequestTransformer($this->streamInterface),
            new GetCommentsResponseTransformer(),
        );
    }

    /**
     * @param int   $id
     * @param array $updatedFields
     *
     * @return \ExampleCommentServiceClient\Models\Responses\UpdateComment
     */
    public function updateComment(int $id, array $updatedFields): UpdateComment
    {
        $request = new \ExampleCommentServiceClient\Models\Requests\UpdateComment();

        $request->id = $id;
        $request->updatedFields = $updatedFields;

        return $this->restApiCommentProvider->updateComment(
            $request,
            new GetCommentsRequestTransformer($this->streamInterface),
            new GetCommentsResponseTransformer(),
        );
    }
}
