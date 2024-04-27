<?php

namespace App\Data\Shared;

use Illuminate\Contracts\Support\Responsable;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Concerns\AppendableData;
use Spatie\LaravelData\Concerns\BaseData;
use Spatie\LaravelData\Concerns\ContextableData;
use Spatie\LaravelData\Concerns\EmptyData;
use Spatie\LaravelData\Concerns\IncludeableData;
use Spatie\LaravelData\Concerns\ResponsableData;
use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Concerns\ValidateableData;
use Spatie\LaravelData\Concerns\WrappableData;
use Spatie\LaravelData\Contracts\AppendableData as AppendableDataContract;
use Spatie\LaravelData\Contracts\BaseData as BaseDataContract;
use Spatie\LaravelData\Contracts\EmptyData as EmptyDataContract;
use Spatie\LaravelData\Contracts\IncludeableData as IncludeableDataContract;
use Spatie\LaravelData\Contracts\ResponsableData as ResponsableDataContract;
use Spatie\LaravelData\Contracts\TransformableData as TransformableDataContract;
use Spatie\LaravelData\Contracts\ValidateableData as ValidateableDataContract;
use Spatie\LaravelData\Contracts\WrappableData as WrappableDataContract;

abstract class PaginatedDataQuery implements Responsable, AppendableDataContract, BaseDataContract, TransformableDataContract, IncludeableDataContract, ResponsableDataContract, ValidateableDataContract, WrappableDataContract, EmptyDataContract
{
    use ResponsableData;
    use IncludeableData;
    use AppendableData;
    use ValidateableData;
    use WrappableData;
    use TransformableData;
    use BaseData;
    use EmptyData;
    use ContextableData;

    public function __construct(
        #[OAT\QueryParameter(
            parameter: 'categoryPerPage',
            name: 'perPage',
            required: false,
            schema: new OAT\Schema(
                type: 'int',
            )
        )]
        public ?int $perPage,
        #[OAT\QueryParameter(
            parameter: 'categoryPage',
            name: 'page',
            required: false,
            schema: new OAT\Schema(
                type: 'int',
            )
        )]
        public ?int $page,
    ) {
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
            'perPage' => ['int', 'gt:0'],
            'page' => ['int', 'gt:0']
        ];
    }
}
