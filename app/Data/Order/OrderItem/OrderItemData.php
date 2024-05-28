<?php

namespace App\Data\Order\OrderItem;

use App\Models\OrderItem;
use OpenApi\Attributes as OAT;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'orderItem')]
class OrderItemData extends Data
{

    public function __construct(
        #[OAT\Property(type: 'integer')]
        public int $id,
        #[OAT\Property(type: 'string')]
        public string $price,
        #[OAT\Property(type: 'integer')]
        public int $quantity,
        #[OAT\Property(type: 'string', format: 'datetime', default: "2017-02-02 18:31:45", pattern: "YYYY-MM-DD")]
        public string $created_at,
    ) {
    }

    public function fromModel(OrderItem $orderItem): self
    {
        return new self(
            id: $orderItem->id,
            price: $orderItem->price,
            quantity: $orderItem->quantity,
            created_at: $orderItem->created_at,
        );
    }
}

