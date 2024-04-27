<?php

namespace App\Data\Category;

use App\Data\Shared\PaginatedData;
use OpenApi\Attributes as OAT;

#[Oat\Schema(schema: 'paginatedCategory')]
class PaginatedCategoryData extends PaginatedData
{
    public function __construct(
        public int $current_page,
        #[OAT\Property(
            type: 'array',
            items: new OAT\Items(
                ref: "#/components/schemas/category"
            )
        )]
        public array $data,

    ) {
        parent::__construct($this->current_page);
    }

}

