<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Responses\AddComment;
use ExampleCommentServiceClient\Models\Comment;
use ExampleCommentServiceClient\Transformers\CommentTransformer;
use ExampleCommentServiceClient\Transformers\Responses\AddCommentResponseTransformer;

class AddCommentResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideArrayData
     */
    public function testShouldReturnArray($expected, $input)
    {
        $this->assertEquals($expected, $input);
    }

    public function provideArrayData()
    {
        $data = [
            ['data' => ['id' => 1, 'name' => 'Test', 'text' => 'Test']],
        ];

        $mock = $this->getMockBuilder(\Psr\Http\Message\ResponseInterface::class)->getMock();

        $mock->method('getBody')->willReturnOnConsecutiveCalls(
            ...array_map(
                fn ($data) => json_encode($data),
                $data
            )
        );

        return array_map(
            fn($data) => [
                (new CommentTransformer)->transform($data['data']),
                (new AddCommentResponseTransformer)->transform($mock)->data
            ],
            $data
        );
    }
}
