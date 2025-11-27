<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    //
        public function store(Request $request)
{
    $validated = $request->validate([
        'user_id'           => 'required|exists:users,id',
        'product'           => 'required|array',
        'product.*'         => 'required|exists:products,id',
        'quantity'          => 'array',
        // 'quantity.*'        => 'required|integer|min:1',
        'cash_transfer'     => 'array',
        // 'cash_transfer.*'   => 'required|numeric|min:0',
        'bank_transfer'     => 'array',
        // 'bank_transfer.*'   => 'required|numeric|min:0',
        'payment_method'    => 'nullable|string',
    ]);

    $sales = [];

    try {
        DB::transaction(function () use ($request, &$sales) {
            foreach ($request->product as $index => $productId) {
                $quantity = (int) $request->quantity[$index];
                $cash     = (float) $request->cash_transfer[$index];
                $bank     = (float) $request->bank_transfer[$index];

                $product = Product::lockForUpdate()->findOrFail($productId);

                // if ($product->quantity < $quantity) {
                //     throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->quantity}");
                // }

                // $product->decrement('quantity', $quantity);

                $sales[] = [
                    'user_id'        => $request->user_id,
                    'product_id'     => $productId,
                    'quantity'       => $quantity ?? 0,
                    'bank_transfer'  => $bank ?? 0,
                    'cash_transfer'  => $cash ?? 0,
                    'total_price'    => ($cash ?? 0) + ($bank ?? 0),
                    'sale_date'      => now(),
                    // 'payment_method' => $request->payment_method ?? 'cash',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            Sales::insert($sales);
        });
    } catch (\Throwable $e) {
        Log::error('Error saving sales: ' . $e->getMessage());
        return back()->with('error', $e->getMessage())->withInput();
    }

    return redirect()->back()->with('success', 'Sales saved successfully!');
}
}
