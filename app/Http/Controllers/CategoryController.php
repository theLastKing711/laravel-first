<?php

namespace App\Http\Controllers;

use App\Data\Category\CategoryData;
use App\Data\Category\CreateCategoryData;
use App\Data\Category\PathParameters\CategoryIdData;
use App\Data\Category\QueryParameters\CategoryQueryData;
use App\Data\Category\UpdateCategoryData;
use App\Data\Product\ProductData;
use App\Models\Category;
use App\Models\Product;
use OpenApi\Attributes as OAT;

//apply this parameters to all descendents routes with the specified path here
// here it's get, update and delete routes
#[OAT\PathItem(
    path: "/categories/{id}",
    parameters: [
        new OAT\PathParameter(
            ref: '#/components/parameters/categoryIdPathParameter',
        )
    ]
)]
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OAT\Get(
        path: '/categories',
        tags: ['categories'],
        parameters: [
            new OAT\QueryParameter(
                required: false,
                ref: "#/components/parameters/categorySearch",
            ),
            new OAT\QueryParameter(
                required: false,
                ref: "#/components/parameters/categoryOrderBy",
            ),
            new OAT\QueryParameter(
                required: false,
                ref: "#/components/parameters/categoryDirection"
            ),
            new OAT\QueryParameter(
                required: false,
                ref: "#/components/parameters/categoryPerPage"
            ),
            new OAT\QueryParameter(
                required: false,
                ref: "#/components/parameters/categoryPage"
            ),
        ],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Category was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/paginatedCategory'),
            )
        ],
    )]
    public function index(CategoryQueryData $request)
    {
        $orderByFilter = $request->orderBy;
        $directionFilter = $request->direction;

        $categories =
            Category
                ::where('name', 'LIKE', "%$request->search%")
                ->conditionalOrderBy($orderByFilter, $directionFilter)
                ->simplePaginate(perPage: $request->perPage, page: $request->page);

        return CategoryData::collect($categories);

    }

    /**
     * Store a newly created resource in storage.
     */
    #[OAT\Post(
        path: '/categories',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/createCategory'),
        ),
        tags: ['categories'],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The Category was successfully created',
                content: new OAT\JsonContent(ref: '#/components/schemas/category'),
            )
        ],
    )]
    public function store(CreateCategoryData $request)
    {
        $category = Category::create($request->all());

        return CategoryData::from($category);
    }

    /**
     * Display the specified resource.
     */
    #[OAT\Get(
        path: '/categories/{id}',
        tags: ['categories'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Category was successfully updated',
                content: new OAT\JsonContent(ref: '#/components/schemas/category'),
            )
        ],
    )]
    public function show(CategoryIdData $request)
    {
        $category = Category::findOrFail($request->id);

        return CategoryData::from($category);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OAT\Patch(
        path: '/categories/{id}',
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/updateCategory'),
        ),
        tags: ['categories'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Category was successfully updated',
                content: new OAT\JsonContent(ref: '#/components/schemas/category'),
            )
        ],
    )]
    public function update(UpdateCategoryData $updatedCategory, CategoryIdData $data)
    {
        Category
            ::findOrFail($data->id)
            ->update($updatedCategory->all());

        $category = Category::find($data->id);

        return CategoryData::from($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OAT\Delete(
        path: '/categories/{id}',
        tags: ['categories'],
        responses: [
            new OAT\Response(
                response: 204,
                description: 'The Category was successfully deleted',
                content: new OAT\JsonContent()
            )
        ],
    )]
    public function destroy(CategoryIdData $request)
    {
        Category
            ::find($request->id)
            ->delete();

    }

    /**
     * Display a listing of products for the specified category id.
     */
    #[OAT\Get(
        path: '/categories/{id}/products',
        tags: ['categories'],
        parameters: [
            new OAT\PathParameter(
                ref: '#/components/parameters/categoryIdPathParameter',
            )
        ],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'The Categories were fetched successfully',
                content: new OAT\JsonContent(
                    type: 'array',
                    items: new OAT\Items(
                        oneOf: [
                            new OAT\Schema(ref: '#/components/schemas/product'),
                        ]
                    )),
            )
        ],
    )]
    public function showProducts(CategoryIdData $request)
    {
        $products =
            Product
                ::where('category_id', '=', $request->id)
                ->get();
        return ProductData::collect($products);
    }
}
