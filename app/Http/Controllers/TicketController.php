<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show($order_id)
    {
        $transaction = \App\Models\Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        return view('ticket', compact('transaction'));
    }
}