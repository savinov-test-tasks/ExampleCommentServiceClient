<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models;


/**
 * Class ApiError
 *
 * @package ExampleCommentServiceClient\Models
 */
class ApiError
{
    /**
     * @var int
     */
    public int $code;
    /**
     * @var string
     */
    public string $message;

    /**
     * ApiError constructor.
     *
     * @param int    $code
     * @param string $message
     */
    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}
