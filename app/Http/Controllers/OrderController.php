<?php

namespace App\Http\Controllers;

use App\Data\Order\CreateOrderData;
use App\Data\Order\OrderData;
use App\Data\Order\OrderItem\CreateOrderItemData;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OAT;

class OrderController extends Controller
{
    /**
     * Return a list of orders with thier order items
     */
    #[OAT\Get(
        path: '/orders',
        tags: ['orders'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Order was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/order'),
            )
        ],
    )]
    public function index()
    {
        $orders = Order::with('orderItems')->get();

        return OrderData::collect($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Create a new Order for the authenticated user
     *
     */
    #[OAT\Post(
        path: '/orders',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/createOrder'),
        ),
        tags: ['orders'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The Order was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/order'),
            )
        ],
    )]
    public function store(CreateOrderData $request)
    {
        $orderItems = $request
            ->items
            ->map(
                fn (CreateOrderItemData $item)
                => new OrderItem(
                    [
                        'price'
                        => (string) Product
                            ::where('id', $item->id)
                            ->value('price'),
                        'quantity' => $item->quantity,
                    ]
                )
            );


        $total = $orderItems
            ->reduce(
                fn ($prev, OrderItem $item) => $prev + $item->price * $item->quantity
            );


        $loggedUserId = Auth::user()->id;

        $order = Order::create(
            [
                'user_id' => $loggedUserId,
                'total' => $total,
            ]
        );

        $order
            ->orderItems()
            ->createMany($orderItems->toArray());

        return OrderData::from([
            'id' => $order->id,
            'total' => $order->total,
            'items' => $order->orderItems,
            'user_id' => $order->user_id
        ]);

        //        return $order->load('orderItems'); // get the model with created items

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
