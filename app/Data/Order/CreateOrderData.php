<?php

namespace App\Data\Order;

use App\Data\Order\OrderItem\CreateOrderItemData;
use Illuminate\Support\Collection;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;


// hacky way to type collection
/**
 * @property Collection<int, CreateOrderItemData> $items
 */
#[Oat\Schema(schema: 'createOrder')]
class CreateOrderData extends Data
{

    public function __construct(
        #[OAT\Property(
            type: 'array',
            items: new OAT\Items(
                ref: "#/components/schemas/createOrderItem"
            )
        )]
        public Collection $items,
    ) {
    }

}

