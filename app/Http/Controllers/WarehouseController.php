<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\WarehouseReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'ship', 'items.product.vendor', 'items.warehouseReceipts'])
            ->latest()
            ->get();

        return view('warehouse.index', compact('orders'));
    }

    public function storeReceipt(Request $request, Order $order)
    {
        $request->validate([
            'receipts'                  => ['required', 'array'],
            'receipts.*.order_item_id'  => ['required', 'exists:order_items,id'],
            'receipts.*.quantity'       => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->receipts as $receipt) {
            if ($receipt['quantity'] > 0) {
                WarehouseReceipt::create([
                    'order_id'          => $order->id,
                    'order_item_id'     => $receipt['order_item_id'],
                    'recorded_by'       => Auth::id(),
                    'quantity_received' => $receipt['quantity'],
                ]);
            }
        }

        return redirect()->route('warehouse.index')->with('success', 'Warehouse receipt recorded successfully.');
    }
}
