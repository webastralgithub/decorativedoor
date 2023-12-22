<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required',
            'payment_type' => 'required',
            'pay' => 'required|numeric'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'order_date' => Carbon::now()->format('Y-m-d'),
            'order_status' => 0,
            // 'total_products' => Cart::count(),
            // 'sub_total' => Cart::subtotal(),
            // 'vat' => Cart::tax(),
            // 'total' => Cart::total(),
            // 'invoice_no' => IdGenerator::generate([
            //     'table' => 'orders',
            //     'field' => 'invoice_no',
            //     'length' => 10,
            //     'prefix' => 'INV-'
            // ]),
            //'due' => ((int)Cart::total()) - ((int)$this->pay)
            // 'due' => (Cart::total() - $this->pay)
        ]);
    }
}
