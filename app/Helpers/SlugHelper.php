<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('generateProductSlug')) {
    /**
     * Generate a random and unique product slug.
     *
     * @param string $productName
     * @return string
     */
    function generateProductSlug($productName)
    {
        $baseSlug = Str::slug($productName);

        // Check if the slug already exists in the database
        $existingSlugs = Product::where('slug', 'like', $baseSlug . '%')->pluck('slug');

        $counter = 1;
        $newSlug = $baseSlug;

        // Increment the counter until we find a unique slug
        while ($existingSlugs->contains($newSlug)) {
            $counter++;
            $newSlug = $baseSlug . '-' . $counter;
        }

        return $newSlug;
    }


    if (!function_exists('getRandomProductSlug')) {
        /**
         * Get a random product slug from the database.
         *
         * @return \App\Models\Product|null
         */
        function getRandomProductSlug()
        {
            return Product::inRandomOrder()->first()->slug;
        }
    }

    if (!function_exists('productsTotal')) {
        function productsTotal()
        {
            return Product::count();
        }
    }

    if (!function_exists('ordersTotal')) {
        function ordersTotal()
        {
            return Order::count();
        }
    }
    if (!function_exists('getUserAddress')) {
        function getUserAddress($userID = null)
        {
            if (!$userID)
                return null;
            $user = User::with('address')->findOrFail($userID);
            return getFullAddress($user->address);
        }
    }

    if (!function_exists('getFullAddress')) {
        function getFullAddress($jsonAddress)
        {
            $address = json_decode($jsonAddress, true);

            if ($address) {
                $fullAddress = $address['street'] . ', ' . $address['city'] . ', ' . $address['state'] . ' ' . $address['zip_code'];
                return $fullAddress;
            }

            return null;
        }
    }
}
