<?php

namespace App\Http\Requests\SearchObjects;

class BaseSearchObject
{
    public ?int $page;
    public ?int $size;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        $this->page = $attributes['page'] ?? 1;
        $this->size = $attributes['size'] ?? 12;
    }

    public function toArray()
    {
        return [
            'page' => $this->page ?? null,
            'size' => $this->size ?? null
        ];
    }
}