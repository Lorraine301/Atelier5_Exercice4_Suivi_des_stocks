<?php

namespace App\Http\Controllers;

use App\Events\StockUpdated;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        return  response()->json($stocks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0'
        ]);

        $stock = Stock::create($validatedData);

        broadcast(new StockUpdated($stock))->toOthers();

        return response()->json($stock, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $stock = Stock::findOrFail($id);
        $stock->update($validatedData);

        broadcast(new StockUpdated($stock))->toOthers();

        return response()->json($stock);
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        broadcast(new StockUpdated($stock))->toOthers();

        return response()->json(null, 204);
    }
}
