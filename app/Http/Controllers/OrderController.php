<?php

// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\GDLibRenderer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Discountcode;
use App\Models\Order;
use App\Models\MenuitemOrderCount;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('served', false)->latest()->get();

        return view('orders',['orders'=>$orders]);
    }

    public function markAsServed($orderId)
    {
        $order = Order::findOrFail($orderId);
        $details = json_decode($order->details, true);

        foreach ($details as $item) {
            $menuitemOrderCount = MenuitemOrderCount::where('menuitem_id', $item['id'])->first();
            if ($menuitemOrderCount) {
                // Increment the existing count
                $menuitemOrderCount->increment('times_ordered');
            } else {
                // Create a new record with count of 1
                MenuitemOrderCount::create([
                    'menuitem_id' => $item['id'],
                    'times_ordered' => 1
                ]);
            }
        }

        $order->update(['served' => true]);

        return redirect()->route('orders')->with('status', 'Order marked as served!');
    }

    public function history()
    {
        $orders = Order::where('served', true)->latest()->get();
        return view('history', ['orders' => $orders]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'cartItems' => 'required|json',
            'totalPrice' => 'required|numeric',
            'discountCode' => 'nullable|string',
            'table' => 'required|integer'
        ]);

        // Calculate discount percentage based on total price
        $totalPrice = $validated['totalPrice'];
        session(['totalPrice' => $totalPrice]);

        $discountPercent = 0;

        if ($totalPrice < 100) {
            $discountPercent = 5;
        } elseif ($totalPrice < 200) {
            $discountPercent = 10;
        } elseif ($totalPrice < 300) {
            $discountPercent = 20;
        } else {
            $discountPercent = 30;
        }

        // Generate and save discount code
        $discountCode = Str::upper(Str::random(10));
        Discountcode::create([
            'code' => $discountCode,
            'discount_percent' => $discountPercent,
        ]);

        // Generate QR code using GDLibRenderer
        $renderer = new GDLibRenderer(200); // Set the size of the QR code
        $writer = new Writer($renderer);

        $qrCodePath = 'qrcodes/' . $discountCode . '.png';
        $qrCodeDir = public_path(dirname($qrCodePath));

        // Ensure the directory exists
        if (!is_dir($qrCodeDir)) {
            mkdir($qrCodeDir, 0755, true);
        }

        // Write QR code to file
        $writer->writeFile($discountCode, public_path($qrCodePath));

        // Save the order
        $order = new Order();
        $order->table = $request->table;
        $order->details = $request->cartItems;
        $order->discount = $request->discountCode ?? ''; // Default to empty string if null
        $order->served = false;
        $order->save();

        // Pass the QR code path and discount code to the view
        return view('checkout', [
            'qrCodePath' => $qrCodePath,
            'discountCode' => $discountCode
        ]);
    }








    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
