<?php

namespace App\Http\Controllers;

use App\Actions\SellProductAction;
use App\Http\Requests\StoreShopRequest;
use App\Http\Resources\ShopResource;
use App\Http\Resources\ShopWithProductsResource;
use App\Jobs\StoreShopJob;
use App\Models\Product;
use App\Models\Shop;
use App\Queries\ShopsQuery;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function __construct(
        private readonly SellProductAction $sellProductAction,
    ) {}

    public function index(ShopsQuery $shopsQuery)
    {
        $shops = $shopsQuery->getRecords();

        return ShopResource::collection($shops);
    }

    public function show(Shop $shop)
    {
        $shop->load('products');

        return new ShopWithProductsResource($shop);
    }

    public function store(StoreShopRequest $request): JsonResponse
    {
        StoreShopJob::dispatch($request->validated());

        return response()->json([
            'message' => 'Shop created successfully',
        ], Response::HTTP_CREATED);
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return response()->json([
            'message' => 'Shop deleted successfully',
        ], Response::HTTP_OK);
    }

    public function sell(Shop $shop, Product $product)
    {
        $result = $this->sellProductAction->handle($shop, $product);

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
            ], 400);
        }

        return response()->json([
            'message' => $result['message'],
            'remaining' => $result['remaining'],
        ]);
    }
}
