<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        return response($items->jsonSerialize(), Response::HTTP_OK);
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        return response($item->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $item = new Item([
            'name' => $request->get('name'),
            'price' => $request->get('price')
        ]);
        $item->save();

        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->name = $request->get('name');
        $item->price = $request->get('price');
        $item->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Item::destroy($id);

        return response(null, Response::HTTP_OK);
    }

}
