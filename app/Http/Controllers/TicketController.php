<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TicketController extends Controller
{
    public function show(Request $request)
{
    $orderId = $request->query('order_id');
    $transaction = Transaction::where('order_id', $orderId)->firstOrFail();
    
    // Mengubah status seakan-akan sudah dibayar
    $transaction->update(['status' => 'Success']); 

    return view('ticket', compact('transaction'));
}
}
