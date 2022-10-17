<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all products.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_access');
    }

    /**
     * Determine whether the user can view product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Product $product)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_access');
    }

    /**
     * Determine whether the user can search products
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function search(User $user)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_search');
    }

    /**
     * Determine whether the user can create new product.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_create');
    }

    /**
     * Determine whether the user can update product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Product $product)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_update');
    }

    /**
     * Determine whether the user can delete product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Product $product)
    {
        return $user->hasRole('Admin') || $user->hasPermissionTo('products_delete');
    }

    /**
     * Determine whether the user can restore product
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
}
