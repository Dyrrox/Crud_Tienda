<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function verLogin()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'clave' => 'required',
        ]);([
            'usuario.required' => 'El campo usuario es obligatorio.',
            'clave.required' => 'El campo clave es obligatorio.',
        ]);

        $usuario = $request->input('usuario');
        $clave = $request->input('clave');

        try {
            $data = DB::selectOne(
            'SELECT id, nombre, usuario, email, clave, cargo FROM usuarios WHERE usuario = ?', [$usuario]
        );

            if (!$data) {
                return back()->withErrors(['usuario' => "Usuario $usuario no encontrado."])->withInput();
            }

            if ($clave === $data->clave) {
                
                Session::put([
                    'id' => $data->id,
                    'nombre' => $data->nombre,
                    'usuario' => $data->usuario,
                    'email' => $data->email,
                    'cargo' => $data->cargo
                ]);

                if ($data->cargo == 1) {
                    return redirect('/products');
                } elseif ($data->cargo == 2) {
                    return redirect()->to('view/user/user.php');
                }
            } else {
                return back()->withErrors(['usuario' => 'Contraseña incorrecta.'])->withInput();
            }

        } catch (\Exception $e) {
            return back()->withErrors(['usuario' => $e->getMessage()])->withInput();
        }
    }
}
