<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Responses\GetComments;
use ExampleCommentServiceClient\Models\Comment;
use ExampleCommentServiceClient\Transformers\Responses\GetCommentsResponseTransformer;
use ExampleCommentServiceClient\Transformers\CommentTransformer;

class GetCommentsResponseTest extends \PHPUnit\Framework\TestCase
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
            ['data' => [['id' => 1, 'name' => 'Test', 'text' => 'Test']]],
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
                array_map(
                    fn($comment) => (new CommentTransformer)->transform($comment),
                    $data['data']
                ),
                (new GetCommentsResponseTransformer)->transform($mock)->data
            ],
            $data
        );
    }
}
