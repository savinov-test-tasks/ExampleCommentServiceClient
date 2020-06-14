<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Requests\AddComment;
use ExampleCommentServiceClient\Models\Comment;

class AddCommentRequestTest extends \PHPUnit\Framework\TestCase
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
            ['name' => 'Test', 'text' => 'Test'],
        ];

        $addCommentBuilder = function ($name, $text) {
            $object = new AddComment();
            $object->name = $name;
            $object->text = $text;
            return $object;
        };

        return array_map(
            fn($data) => [
                $data,
                (array) $addCommentBuilder($data['name'], $data['text']),
            ],
            $data
        );
    }
}
