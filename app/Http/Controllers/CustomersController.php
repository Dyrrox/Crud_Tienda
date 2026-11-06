<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class customersController extends Controller
{
    public function index()
    {
        if (session('cargo') != 1) {
            return redirect('/welcome');
        }

        $customers = DB::table('customers')->get();

        return view('clientes', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'genero' => 'required',
            'telefono' => 'required|numeric|digits:9',
            'dni' => 'required|numeric|digits:8',
        ]);

        DB::insert(
            'INSERT INTO customers (nombre, genero, telefono, dni, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)',
            [
                $request->nombre,
                $request->genero,
                $request->telefono,
                $request->dni,
                now(),
                now()
            ]
        );

        return redirect()->back()->with('success', 'Cliente agregado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'genero' => 'required',
            'telefono' => 'required|numeric|digits:9',
            'dni' => 'required|numeric|digits:8',
        ]);

        DB::update(
            'UPDATE customers SET nombre = ?, genero = ?, telefono = ?, dni = ?, updated_at = ? WHERE id = ?',
            [
                $request->nombre,
                $request->genero,
                $request->telefono,
                $request->dni,
                now(),
                $id
            ]
        );

        return redirect()->back()->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM customers WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Cliente eliminado exitosamente.');
    }
}
