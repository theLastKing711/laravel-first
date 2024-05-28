<?php

namespace App\Data\Order;

use App\Data\Order\OrderItem\OrderItemData;
use App\Models\Order;
use OpenApi\Attributes as OAT;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

#[Oat\Schema(schema: 'order')]
class OrderData extends Data
{
    /**
     * @param Collection<int, OrderItemData> $items
     */
    public function __construct(
        #[OAT\Property(type: 'integer')]
        public int $id,
        #[OAT\Property(type: 'integer')]
        public int $user_id,
        #[OAT\Property(type: 'string')]
        public string $total,
        #[OAT\Property(
            type: 'array',
            items: new OAT\Items(
                ref: "#/components/schemas/orderItem"
            )
        )]
        public Collection $items,
    ) {
    }

    public function fromModel(Order $order): self
    {
        return new self(
            id: $order->id,
            user_id: $order->user_id,
            total: $order->total,
            items: OrderItemData::collect($order->orderItems),
        );
    }

}

