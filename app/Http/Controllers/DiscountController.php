<?php

namespace App\Http\Controllers;
use App\Models\Discountcode;
use App\Models\Order;
use Illuminate\Http\Request;


class DiscountController
{
    public function applyDiscount(Request $request)
    {
        $validated = $request->validate([
            'discountCode' => 'required|string',
        ]);

        $discountCode = $validated['discountCode'];

        // Check if the discount code exists
        $discount = Discountcode::where('code', $discountCode)->first();

        if ($discount) {
            // Retrieve the total price from the session
            $totalPrice = session('totalPrice', 0);

            // Calculate discount amount
            $discountAmount = ($discount->discount_percent / 100) * $totalPrice;

            // Delete the discount code from the table
            $discount->delete();

            return response()->json([
                'success' => true,
                'discountAmount' => $discountAmount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid discount code.'
            ]);
        }
    }

}
