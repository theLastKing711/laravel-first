<?php

namespace App\Data\Category;

use App\Models\Category;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'category')]
class CategoryData extends Data
{
    public function __construct(
        #[OAT\Property(type: 'string')]
        public string $id,
        #[OAT\Property(type: 'string')]
        public string $name,
        #[OAT\Property(type: 'string', format: 'datetime', default: "2017-02-02 18:31:45", pattern: "YYYY-MM-DD")]
        public string $created_at,
    ) {
    }

    public function fromModel(Category $category): self
    {
        return new self(
            id: $category->id,
            name: $category->name,
            created_at: $category->created_at
        );
    }

}

