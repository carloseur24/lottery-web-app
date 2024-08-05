<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class paymentController extends Controller
{
    public function pago_movil()
    {
        try {
            $data = request()->validate([
                'banco' => ['required', 'string'],
                'telefono' => ['required', 'string'],
                'fecha' => ['required', 'string'],
                'referencia' => ['required', 'string'],
                'saldo' => ['required', 'string'],
                'id' => ['required', 'integer'],
            ]);
            // dd($data);
            // $data['saldo'] = 0.00;
            $sql = 'UPDATE users SET saldo = ? WHERE id = ?';
            \DB::update($sql, [$data['saldo'], $data['id']]);
            // $data['amount'];
            return response()->json(['message' => 'Payment validated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error validating payment', 'message' => $e->getMessage()]);
        }
    }
}
