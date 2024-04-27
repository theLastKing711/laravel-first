<?php

namespace App\Data\Category\PathParameters;

use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[OAT\Schema('test')]
class CategoryIdData extends Data
{
    public function __construct(
        #[OAT\PathParameter(
            parameter: 'categoryIdPathParameter', //the name used in ref
            name: 'id',
            in: 'path',
            schema: new OAT\Schema(
                type: 'integer',
            ),
        ), FromRouteParameter('id')]
        public int $id,
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => 'required|int|exists:categories'
        ];
    }

}

