<?php declare(strict_types=1);

use ExampleCommentServiceClient\Models\Responses\BaseResponse;
use ExampleCommentServiceClient\Models\ApiError;
use ExampleCommentServiceClient\Transformers\Responses\JsonResponseTransformer;

class BaseResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideArrayData
     */
    public function testShouldAssignErrors($expected, $input)
    {
        $this->assertEquals($expected, $input);
    }

    public function provideArrayData()
    {
        $data = [
            ['errors' => [['code' => 1, 'message' => 'Test']]],
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
                    fn($error) => new ApiError((int)$error['code'], (string)$error['message']),
                    $data['errors']
                ),
                (new JsonResponseTransformer())->transform($mock)->errors,
            ],
            $data
        );
    }
}
