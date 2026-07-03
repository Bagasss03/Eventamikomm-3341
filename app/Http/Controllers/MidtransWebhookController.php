<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    /**
     * Menangani data notifikasi (Webhook) otomatis dari server Midtrans
     */
    public function handle(Request $request)
    {
        $payload           = $request->all();
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;

        // Validasi ketersediaan Order ID di dalam payload json
        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Mencari ID transaksi tersebut di database lokal kita
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses berulang jika status di database sudah lunas/sukses
        if ($transaction->status === 'settlement' || $transaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        // Logika Penerjemahan Status Midtrans API ke Status Database Lokal
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } elseif ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        // Simpan perubahan status ke database
        $transaction->save();
        
        return response()->json(['message' => 'OK']);
    }

    /**
     * Memproses aksi lanjutan ketika pembayaran terkonfirmasi lunas
     * (Misalnya nanti dipakai untuk potong stok tiket atau kirim email tiket)
     */
    private function processSuccess(Transaction $transaction)
    {
        // Tempat meletakkan logika potong stok / kirim email tiket di modul berikutnya.
    }
}