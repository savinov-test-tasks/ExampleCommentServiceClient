<?php


namespace ExampleCommentServiceClient\Transformers;

use ExampleCommentServiceClient\Models\Comment;

class CommentTransformer implements TransformerInterface
{
    public function transform(array $data)
    {
        return new Comment($data['id'], $data['name'], $data['text']);
    }
}
