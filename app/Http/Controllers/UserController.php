<?php

namespace App\Http\Controllers;
use App\Models\Goods;
use App\Models\Requests;
use App\Models\Transaction;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showRequests(Request $request)
    {
        $goods = Goods::all(); // Fetch all goods
        $userRequests = Requests::all(); // Fetch all goods
        // $userRequests = Requests::where('id', $request-> goods_id)->get(); // Fetch user's requests
        return view('users', compact('goods', 'userRequests'));
    }

    public function getrequest(Request $request)
    {
        $goods = Goods::where('id', $request-> goods_id)->first();
        // $userRequests = Requests::where('id', $request-> goods_id)->get();
        $arr = [
            'goods_id' => $goods->id,
            'item' => $goods->name
        ];
        return ($arr);
    }

    // Submit user request via AJAX
    public function submitRequest(Request $request)
    {
        // $request->validate([
        //     'goods_id' => 'required|exists:goods,id',
        //     'quantity' => 'required|integer|min:1'
        // ]);
        // $goods = Goods::where('id', $request-> goods_id)->first();
        $goodsid=$request-> goods_id; 
        // dd($goodsid);
        Requests::create([
            // dd($request),
            
            'goods_id' => ($goodsid),
            'quantity' => ($request->quantity),
            'status' => 'pending'
        ]);
        // dd(Requests::all());
        // $userRequests = Requests::where('id', $request-> goods_id)->get();
        
        return response()->json(['success' => 'Request submitted successfully']);
    }
}

