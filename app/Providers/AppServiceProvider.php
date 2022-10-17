<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // One macro to rule them all 😜
        Builder::macro(
            'whereLike',
            function ($attributes, string $searchTerm) {
                $this->where(
                    function (Builder $query) use ($attributes, $searchTerm) {
                        foreach (Arr::wrap($attributes) as $attribute) {
                            $query->when(
                                str_contains($attribute, '.'),
                                function (Builder $query) use ($attribute, $searchTerm) {
                                    $buffer = explode('.', $attribute);
                                    $attributeField = array_pop($buffer);
                                    $relationPath = implode('.', $buffer);
                                    $query->orWhereHas(
                                        $relationPath,
                                        function (Builder $query) use ($attributeField, $searchTerm) {
                                            $query->where($attributeField, 'LIKE', "%{$searchTerm}%");
                                        }
                                    );
                                },
                                function (Builder $query) use ($attribute, $searchTerm) {
                                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                                }
                            );
                        }
                    }
                );

                return $this;
            }
        );
    }
}
