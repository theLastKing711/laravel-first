<?php
namespace App\Data\Order\OrderItem;

use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'createOrderItem')]
class CreateOrderItemData extends Data
{
    public function __construct(
        #[OAT\Property(type: 'integer')]
        public int $id,
        #[OAT\Property(type: 'integer')]
        public int $quantity,
    ) {
    }

    public static function rules(): array
    {
        return [
            'id' => 'exists:products,id',
            'quantity' => 'required|integer|gte:0',
        ];
    }

//    public static function fromArray(array $data): CreateOrderItemData
//    {
//        return new self(
//            data_get($data, 'id'),
//            data_get($data, 'quantity'),
//        );
//    }

}

