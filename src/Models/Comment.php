<?php declare(strict_types=1);

namespace ExampleCommentServiceClient\Models;

/**
 * Class Comment
 *
 * @package ExampleCommentServiceClient\Models
 */
class Comment
{
    /**
     * @var int
     */
    public int $id;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $text;

    /**
     * Comment constructor.
     *
     * @param $id
     * @param $name
     * @param $text
     */
    public function __construct($id, $name, $text)
    {
        $this->id = $id;
        $this->name = $name;
        $this->text = $text;
    }
}
