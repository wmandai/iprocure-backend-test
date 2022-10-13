<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Products\ProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAdderRequest;
use App\Http\Requests\ProductUpdaterRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;
use Log;

class ProductsApiController extends Controller
{
    use InteractsWithAPI;

    /**
     * Display product listings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ProductCollection(
            Product::orderByDesc('id')->paginate(25)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $product = Product::findOrFail($id);
        if (auth()->user()->can('view', $product)) {
            return new ProductResource($product);
        }
        return $this->unauthorized();
    }

    /**
     * Display customer own products
     *
     * @return \Illuminate\Http\Response
     */
    public function mine()
    {
        return new ProductCollection(
            Product::where('user_id', auth()->id())->orderByDesc('id')->paginate(25)
        );
    }

    /**
     * Display products matching search term
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate(['search' => 'required']);
        if ($request->user()->can('search', Product::class)) {
            return new ProductCollection(
                Product::whereLike(['name', 'type', 'category', 'manufacturer', 'distributor'], $request->search)
                    ->orderByDesc('id')
                    ->paginate(25)
            );
        }
        return $this->unauthorized();
    }

    public function create(ProductAdderRequest $request)
    {
        if ($request->user()->can('create', Product::class)) {
            $validatedData = $request->validated();
            try {
                $product = (new ProductAction())->save($validatedData);
                return $this->success([
                    'message' => 'Product ' . $request->name . ' created successfully',
                    'id' => $product->id
                ], 201);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Failed, contact sys admin']);
            }
        }
        return $this->unauthorized();
    }

    /**
     * Update specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdaterRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->user()->can('update', $product)) {
            try {
                (new ProductAction())->update($product, $request->validated());
                return $this->success([
                    'message' => 'Product ' . $product->name . ' updated successfully',
                    'id' => $product->id
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Failed to update product']);
            }
        }
        return $this->unauthorized();
    }

    /**
     * Remove the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($request->user()->can('delete', $product)) {
            try {
                (new ProductAction())->delete($product);
                return $this->success(['message' => 'Product ' . $product->name . ' deleted successfully']);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Could not delete product.']);
            }
        }
        return $this->unauthorized();
    }
}
