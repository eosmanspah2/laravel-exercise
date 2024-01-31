<?php

namespace App\Http\Requests\SearchObjects;

class ProductSearchObject extends BaseSearchObject
{

    public ?string $name = null;
    public ?bool $includeProductType = null;
    public ?int $greatestPrice = null;
    public ?int $lowestPrice = null;

    public ?string $validFrom = null;
    public ?string $validTo = null;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        parent::fill($attributes);
        $this->name = $attributes['name'] ?? null;
        $this->greatestPrice = $attributes['greatestPrice'] ?? null;
        $this->lowestPrice = $attributes['lowestPrice'] ?? null;
        $this->validFrom = $attributes['validFrom'] ?? null;
        $this->validTo = $attributes['validTo'] ?? null;
        $this->includeProductType = $attributes['includeProductType'] ?? null;
    }
}
