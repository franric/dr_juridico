<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('logar.index');
    }

    public function logar(Request $request)
    {

        $this->validationLogin($request);

        $data = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        $lembrar = (!empty($request->remember) ? $request->remember : false);

        try
        {
            if(Auth::attempt($data, $lembrar))
            {
                return redirect()->intended('home');
            }
            else{
                $this->messagesAlert('Email ou Senha Inválidos');
                return redirect()->back();
            }
        }
        catch (\Exception $e)
        {
            $this->messagesAlert('Error ao fazer Login');
            return redirect()->back();
        }
    }

    protected function validationLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ],
        [
            'email.required' => 'O nome de Usuário é Obrigatório.',
            'password.required' => 'A senha do Usuário é Obrigatória',
        ]);
    }

    public function messagesAlert($msg)
    {
        session()->flash('success', [
            'success'   => false,
            'messages'  => $msg
        ]);
    }
}
