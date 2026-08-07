<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Pastikan order milik user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan order berstatus selesai
        if ($order->status !== 'completed') {
            return back()->with('error', 'Hanya pesanan yang sudah selesai yang bisa diberi ulasan.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Pastikan produk ada di order ini
        if (!$order->items()->where('product_id', $request->product_id)->exists()) {
            return back()->with('error', 'Produk tidak ditemukan dalam pesanan ini.');
        }

        // Pastikan belum pernah review produk ini di order ini
        if (Review::where('user_id', auth()->id())
                  ->where('order_id', $order->id)
                  ->where('product_id', $request->product_id)
                  ->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
