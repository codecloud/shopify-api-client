<?php
namespace Codecloud\ShopifyApiClient\Endpoint;

class Article extends Endpoint
{
    public function search($blogId, array $params = [])
    {
        return $this->call(self::GET, 'blogs/' . $blogId . '/articles', [
            'limit'            => 'int',
            'page'             => 'int',
            'since_id'         => 'int',
            'created_at_min'   => 'datetime',
            'created_at_max'   => 'datetime',
            'updated_at_min'   => 'datetime',
            'updated_at_max'   => 'datetime',
            'published_at_min' => 'datetime',
            'published_at_max' => 'datetime',
            'published_status' => 'enum:published,unpublished,any',
            'fields'           => 'string'
        ], $params);
    }

    public function count($blogId, array $params = [])
    {
        return $this->callCount('blogs/' . $blogId . '/articles/count', [
            'created_at_min'   => 'datetime',
            'created_at_max'   => 'datetime',
            'updated_at_min'   => 'datetime',
            'updated_at_max'   => 'datetime',
            'published_at_min' => 'datetime',
            'published_at_max' => 'datetime',
            'published_status' => 'enum:published,unpublished,any'
        ], $params);
    }


    public function get($blogId, $articleId, array $params = [])
    {
        return $this->callSingle(self::GET, 'blogs/' . $blogId . '/articles/' . $articleId, 'article', [
            'fields' => 'string'
        ], $params);
    }

    public function create($blogId, array $articleData)
    {
        return $this->callSingle(self::POST, 'blogs/' . $blogId . '/articles', 'article', [
            'title'        => 'required|string',
            'author'       => 'string',
            'tags'         => 'string',
            'body'         => 'string',
            'body_html'    => 'string',
            'published_at' => 'datetime',
            'published'    => 'bool',
            'image'        => [
                'src'        => 'url',
                'attachment' => 'string'
            ],
            'metafields'   => 'metafield_array'
        ], $articleData);
    }

    public function modify($blogId, $articleId, array $articleData)
    {
        return $this->callSingle(self::POST, 'blogs/' . $blogId . '/articles/' . $articleId, 'article', [
            'title'        => 'required|string',
            'author'       => 'string',
            'tags'         => 'string',
            'body'         => 'string',
            'body_html'    => 'string',
            'published_at' => 'datetime',
            'published'    => 'bool',
            'image'        => [
                'src'        => 'url',
                'attachment' => 'string'
            ],
            'metafields'   => 'metafield_array'
        ], $articleData);
    }

    public function getAuthors()
    {

    }

    public function getTags($blogId)
    {

    }

    public function remove($blogId, $articleId)
    {

    }
}