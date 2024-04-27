<?php

namespace App\Http\Controllers;

use App\Data\Category\CreateProductData;
use App\Data\Product\ProductData;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use OpenApi\Attributes as OAT;
use Request;

#[OAT\Info(version: '1', title: 'Products Controller')]
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OAT\Get(
        path: '/products',
        tags: ['products'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Product was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/product'),
            )
        ],
    )]
    public function index()
    {

        $products = Product::select([
            'id',
            'category_id',
            'isActive',
            'name',
            'price',
            'quantity',
        ])
            ->get();

        $productsDto = ProductData::collect($products);

        return $productsDto;

    }

    /**
     * Store a newly created resource in storage.
     */
    #[OAT\Post(
        path: '/products',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/createProduct'),
        ),
        tags: ['products'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Product was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/product'),
            )
        ],
    )]
    public function store(CreateProductData $request)
    {
        $product = Product::create($request->all());

        $createdProductDto = ProductData::from($product);

        return $request;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $product)
    {
        $products = Product::select('name', 'id')->get();

        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
