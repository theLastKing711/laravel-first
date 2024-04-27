<?php

namespace App\Data\Category;

use App\Models\Category;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'createCategory')]
class CreateCategoryData extends Data
{
    public function __construct(
        #[OAT\Property(type: 'string')]
        public string $name,
    ) {
    }

    public function fromModel(Category $category): self
    {
        return new self(
            name: $category->name,
        );
    }

}

