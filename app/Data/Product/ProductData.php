<?php

namespace App\Data\Product;

use App\Models\Product;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'product')]
class ProductData extends Data
{
    public function __construct(
        #[OAT\Property(type: 'string')]
        public string $id,
        #[OAT\Property(type: 'string')]
        public string $name,
        #[OAT\Property(type: 'int')]
        public int $category_id,
        #[OAT\Property(type: 'bool')]
        public bool $isActive,
        #[OAT\Property(type: 'string')]
        public string $price,
        #[OAT\Property(type: 'int')]
        public int $quantity,
    ) {
    }

    public function fromModel(Product $product): self
    {
        return new self(
            id: $product->id,
            name: $product->name,
            category_id: $product->category_id,
            isActive: $product->isActive,
            price: $product->price,
            quantity: $product->quantity,
        );
    }

}

