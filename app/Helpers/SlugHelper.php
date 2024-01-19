<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\DeliverQuantity;
use App\Models\OrderDetails;
use App\Models\Note;
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
            return !empty($user->address) ? getFullAddress($user->address) : '';
        }
    }

    if (!function_exists('getUserInfo')) {
        function getUserInfo($userID = null)
        {
            if (!$userID)
                return null;
            $user = User::findOrFail($userID);
            return $user;
        }
    }

    if (!function_exists('productsInfo')) {
        function productsInfo($productId)
        {
            return Product::where('id', $productId)->first();
        }
    }


    if (!function_exists('getOrderNotes')) {
        function getOrderNotes($orderId)
        {
            return Note::where('order_id', $orderId)->latest()->first();
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

    if (!function_exists('convertToReadableStatus')) {
        function convertToReadableStatus($status)
        {
            $formattedStatus = ucwords(strtolower(str_replace('_', ' ', $status)));
            return $formattedStatus;
        }
    }

    if (!function_exists('getProductAvailabityStock')) {
        function getProductAvailabityStock($productId = null)
        {
            $products = Product::with(['inventories', 'orderdetails'])->where('id', $productId)->first();
            $totalrecived = 0;
            $total = 0;
            if (!empty($products->orderdetails))
                foreach ($products->orderdetails as $order) {
                    $totalrecived += $order->quantity;
                }
            if (!empty($products->inventories))
                foreach ($products->inventories as $product) {
                    $total += $product->quantity;
                }
            $FinalQuantity = $total - $totalrecived;
            return $FinalQuantity;
        }
    }

    if (!function_exists('getProductOnhandAvailabityStock')) {
        function getProductOnhandAvailabityStock($productId = null)
        {
            $products = Product::with(['inventories', 'orderdetails'])->where('id', $productId)->first();
            $total = 0;
            if (!empty($products->inventories))
                foreach ($products->inventories as $product) {
                    $total += $product->quantity;
                }
            $FinalQuantity = $total;
            return $FinalQuantity;
        }
    }



    if (!function_exists('getProductOnorderAvailabityStock')) {
        function getProductOnorderAvailabityStock($productId = null)
        {
            $products = Product::with(['inventories', 'orderdetails'])->where('id', $productId)->first();
            $totalrecived = 0;
            if (!empty($products->orderdetails))
                foreach ($products->orderdetails as $order) {
                    $totalrecived += $order->quantity;
                }
            $FinalQuantity = $totalrecived;
            return $FinalQuantity;
        }
    }

    if (!function_exists('getDeliverQuantity')) {
        function getDeliverQuantity($orderId = null, $itemId = null)
        {

            $deliveryorder =  DeliverQuantity::where('item_id', $itemId)->where('order_id', $orderId)->get();

            $total = 0;
            if (!empty($deliveryorder))
                foreach ($deliveryorder as $deliver) {
                    $total += $deliver->deliver_quantity;
                }
            $FinalQuantity = $total;
            return $FinalQuantity;
        }
    }

    if (!function_exists('getTotalQuantity')) {
        function getTotalQuantity($orderId = null)
        {

            $order =  OrderDetails::where('order_id', $orderId)->get();

            $total = 0;
            if (!empty($order))
                foreach ($order as $deliver) {
                    $total += $deliver->quantity;
                }
            $FinalQuantity = $total;
            return $FinalQuantity;
        }
    }

    if (!function_exists('getOrderTotalprice')) {
        function getOrderTotalprice($orderId = null)
        {

            $order =  OrderDetails::where('order_id', $orderId)->get();

            $total = 0;
            $discount = 0;
            if (!empty($order))
                foreach ($order as $deliver) {
                    $total += $deliver->total;
                    $discount += $deliver->discount;
                }
            $FinalTotal = abs($total - $discount);
            return $FinalTotal;
        }
    }
}
