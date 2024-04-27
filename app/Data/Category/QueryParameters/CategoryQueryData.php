<?php

namespace App\Data\Category\QueryParameters;

use App\Data\Shared\PaginatedDataQuery;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAT;

#[Oat\Schema(schema: 'categoryQueryData')]
class CategoryQueryData extends PaginatedDataQuery
{
    public function __construct(
        public ?int $perPage,
        public ?int $page,
        #[OAT\QueryParameter(
            parameter: 'categorySearch', //the name used in ref
            name: 'search', // the name used in swagger, becomes the ref in case the parameter is missing
            required: false,
            schema: new OAT\Schema(
                type: 'string'
            )
        )]
        public ?string $search,
        #[OAT\QueryParameter(
            parameter: 'categoryOrderBy', //the name used in ref
            name: 'orderBy', // the name used in swagger, becomes the ref in case the parameter is missing
            required: false,
            schema: new OAT\Schema(
                required: [],
                type: 'string',
                enum: ['', 'id', 'name'],
                nullable: true,
            )
        )]
        public ?string $orderBy = 'id',

        #[OAT\QueryParameter(
            parameter: 'categoryDirection',
            name: 'direction',
            required: false,
            schema: new OAT\Schema(
                required: [],
                type: 'string',
                enum: ['', 'asc', 'desc'],
                nullable: true,

            )
        )]
        public ?string $direction = 'asc',
    ) {
        parent::__construct($this->perPage, $this->page);
    }

//    public static function fromRequest(Request $request): static
//    {
//        return new self(
//            sort: 'test',
//            order_by: 'test',
//        );
//    }

    public static function rules(): array
    {
        return [
            'orderBy' => ['in:id,name'],
            'direction' => [Rule::In(['asc', 'desc'])],
            ...parent::rules(),
        ];
    }

}

