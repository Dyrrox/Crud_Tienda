<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        if (session('cargo') != 1) {
            return redirect('/welcome');
        }

        $products = DB::table('product')->get();

        return view('products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'inventario' => 'required',
        ]);

        DB::insert(
            'INSERT INTO product (nombre, categoria, precio, inventario, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)',
            [
                $request->nombre,
                $request->categoria,
                $request->precio,
                $request->inventario,
                now(),
                now()
            ]
        );

        return redirect()->back()->with('success', 'Producto agregado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'inventario' => 'required',
        ]);

        DB::update(
            'UPDATE product SET nombre = ?, categoria = ?, precio = ?, inventario = ?, updated_at = ? WHERE id = ?',
            [
                $request->nombre,
                $request->categoria,
                $request->precio,
                $request->inventario,
                now(),
                $id
            ]
        );

        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM product WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
    }
}
