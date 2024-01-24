<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\DeliverQuantity;
use App\Models\OrderDetails;
use App\Models\DeliveryuserQuantity;
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
            return Product::with('image')->where('id', $productId)->first();
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
            $getProductStockOnCart = getProductStockOnCart($productId);
            return ($FinalQuantity > $getProductStockOnCart) ? $FinalQuantity : 0;
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

    if (!function_exists('getProductStockOnCart')) {
        function getProductStockOnCart($productId = null)
        {
            $totalQuantity = 0;
            if (session()->has('cart')) {
                $cart = session()->get('cart');
                if (!empty($cart[$productId]['variant_data']))
                    foreach ($cart[$productId]['variant_data'] as $key => $variant) {
                        $totalQuantity += $variant['quantity'];
                    }
            }
            //  else {
            //     $totalQuantity = getProductAvailabityStock($productId);
            // }
            return $totalQuantity;
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

            $deliveryorder = DeliverQuantity::where('item_id', $itemId)->where('order_id', $orderId)->get();

            $total = 0;
            if (!empty($deliveryorder))
                foreach ($deliveryorder as $deliver) {
                    $total += $deliver->deliver_quantity;
                }
            $FinalQuantity = $total;
            return $FinalQuantity;
        }
    }

    if (!function_exists('getlatestDeliverdQuantity')) {
        function getlatestDeliverdQuantity($orderId = null)
        {
            $order = DeliverQuantity::where('order_id', $orderId)->latest()->first();
            if (!empty($order)) {
                $FinalTotal = $order->deliver_quantity;
            } else {
                $FinalTotal = 0;
            }


            return $FinalTotal;
        }
    }

    if (!function_exists('getTotalQuantity')) {
        function getTotalQuantity($orderId = null)
        {

            $order = OrderDetails::where('order_id', $orderId)->get();

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

            $order = OrderDetails::where('order_id', $orderId)->get();

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

    if (!function_exists('getOrderDeliveryQuantity')) {
        function getOrderDeliveryQuantity($orderId = null)
        {
            $order = Order::with(['details', 'deliverorder'])->where('id', $orderId)->first();

            $orderQuantity = 0;
            $deliver_quantity = 0;

            foreach ($order->details as $key => $items) {

                $orderQuantity += $items->quantity;
            }
            foreach ($order->deliverorder as $key => $items) {
                $deliver_quantity += $items->deliver_quantity;
            }


            $missing_quantiy = $orderQuantity - $deliver_quantity;

            $order = DeliveryuserQuantity::where('order_id', $orderId)->get();

            $delivery_order = 0;
            $delivery_quantity = 0;
            $missingqty = 0;
            if (!empty($order))
                foreach ($order as $deliver) {

                    $delivery_quantity += $deliver->delivery_quantity;
                    $missingqty += $deliver->missingqty;

                }

            //dd($deliver_quantity, $delivery_quantity);
            $pendingQuantity = abs($deliver_quantity - $delivery_quantity + $missing_quantiy);

            $data = array(
                'order_quantity' => $orderQuantity,
                'delivery_order' => $delivery_order,
                'missingqty' => $missingqty,
                'delivery_quantity' => $delivery_quantity,
                'pendingQuantity' => $pendingQuantity,
            );
            return $data;
        }
    }
}

if (!function_exists('getInvoiceDeliveryQuantity')) {
    function getInvoiceDeliveryQuantity($orderId = null)
    {
        $order = Order::with(['details', 'deliverorder'])->where('id', $orderId)->first();
        $orderQuantity = 0;
        $deliverQuantity = 0;

        foreach ($order->details as $items) {
            $orderQuantity += $items->quantity;
        }

        foreach ($order->deliverorder as $items) {
            $deliverQuantity += $items->deliver_quantity;
        }
        $missingQuantity = $orderQuantity - $deliverQuantity;

        $deliveryUserQuantities = DeliveryUserQuantity::where('order_id', $orderId)->get();

        $totalDeliveryOrder = 0;
        $totalDeliveryQuantity = 0;
        $totalMissingQuantity = 0;

        if (!empty($deliveryUserQuantities)) {
            foreach ($deliveryUserQuantities as $deliveryUserQuantity) {
                $totalDeliveryOrder += $deliveryUserQuantity->delivery_order;
                $totalDeliveryQuantity += $deliveryUserQuantity->delivery_quantity;
                $totalMissingQuantity += $deliveryUserQuantity->missingqty;
            }
        }

        // Calculate pending quantity
        $pendingQuantity = abs($deliverQuantity - $totalDeliveryQuantity + $missingQuantity);

        $data = array(
            'order_quantity' => $orderQuantity,
            'total_delivery_order' => $totalDeliveryOrder,
            'total_missing_quantity' => $totalMissingQuantity,
            'total_delivery_quantity' => $totalDeliveryQuantity,
            'pending_quantity' => $pendingQuantity,
        );

        return $data;
    }
}