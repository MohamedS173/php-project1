<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Requests;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // Manager requests page
    public function showRequests()
    {
        $requests = Requests::where('status', 'pending')->with('goods', 'user')->get(); // Fetch pending requests
        return view('manager', compact('requests'));
    }

    // Approve request via AJAX
    public function approveRequest($id)
    {
        $request = Requests::findOrFail($id);
        $goods = Goods::findOrFail($request->goods_id);

        if ($goods->quantity >= $request->quantity) {
            $goods->quantity -= $request->quantity;
            $goods->save();

            Transaction::create([
                
                'goods_id' => $goods->id,
                'quantity_change' => $request->quantity,
                'status' => 'take'
            ]);

            $request->status = 'accepted';
            $request->save();

            return response()->json(['success' => 'Request approved']);
        }

        return response()->json(['error' => 'Not enough stock'], 400);
    }

    // Reject request via AJAX
    public function rejectRequest($id)
    {
        $request = Requests::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return response()->json(['success' => 'Request rejected']);
    }
}
