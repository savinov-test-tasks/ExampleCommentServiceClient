<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Comment;
use ExampleCommentServiceClient\Transformers\CommentTransformer;

class CommentModelTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider provideArrayData
     */
    public function testShouldCreateFromArray($expected, $input)
    {
        $this->assertEquals($expected, $input);
    }

    public function provideArrayData()
    {
        $data = [
            ['id' => 1, 'name' => 'Test', 'text' => 'Test'],
        ];
        return array_map(
            fn($data) => [
                (new CommentTransformer)->transform($data),
                new Comment($data['id'], $data['name'], $data['text']),
            ],
            $data
        );
    }
}
