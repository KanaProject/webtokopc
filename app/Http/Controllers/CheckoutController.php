<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $shipping = 25000; // flat rate
        $total    = $subtotal + $shipping;

        return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $request->validate([
            'shipping_name'        => 'required|string|max:100',
            'shipping_phone'       => 'required|string|max:20',
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string|max:100',
            'shipping_province'    => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:10',
            'payment_method'       => 'required|in:transfer,cod,ewallet',
            'notes'                => 'nullable|string|max:500',
        ]);

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $shipping = 25000;
        $total    = $subtotal + $shipping;

        $order = Order::create([
            'order_number'         => Order::generateOrderNumber(),
            'user_id'              => auth()->id(),
            'status'               => 'pending',
            'subtotal'             => $subtotal,
            'shipping_cost'        => $shipping,
            'total'                => $total,
            'payment_method'       => $request->payment_method,
            'payment_status'       => 'pending',
            'shipping_name'        => $request->shipping_name,
            'shipping_phone'       => $request->shipping_phone,
            'shipping_address'     => $request->shipping_address,
            'shipping_city'        => $request->shipping_city,
            'shipping_province'    => $request->shipping_province,
            'shipping_postal_code' => $request->shipping_postal_code,
            'notes'                => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $item['id'],
                'product_name'  => $item['name'],
                'product_image' => $item['image'],
                'quantity'      => $item['quantity'],
                'price'         => $item['price'],
                'subtotal'      => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('checkout.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }
}
