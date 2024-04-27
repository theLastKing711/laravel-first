<?php

namespace App\Data\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'createProduct')]
class CreateProductData extends Data
{
    public function __construct(
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

    public static function rules(): array
    {
        return [
            'name' => 'required',
            'category_id' => [
                'required',
                Rule::exists(Category::class, 'id')
            ],
            'isActive' => 'required',
            'price' => 'required|decimal:2',
            'quantity' => 'required'
        ];
    }

    public function fromModel(Product $product): self
    {
        return new self(
            name: $product->name,
            category_id: $product->category_id,
            isActive: $product->isActive,
            price: $product->price,
            quantity: $product->quantity,
        );
    }
}

