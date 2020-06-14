<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Requests\UpdateComment;

class UpdateCommentRequestTest extends \PHPUnit\Framework\TestCase
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
            ['id' => 1, 'updatedFields' => [ 'text' => 'Test' ]],
        ];

        $updateCommentBuilder = function ($id, $updatedFields) {
            $object = new UpdateComment();
            $object->id = $id;
            $object->updatedFields = $updatedFields;
            return $object;
        };

        return array_map(
            fn($data) => [
                $data,
                (array) $updateCommentBuilder($data['id'], $data['updatedFields'])
            ],
            $data
        );
    }
}
