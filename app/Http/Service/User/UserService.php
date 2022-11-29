<?php

namespace App\Http\Service\User;

use App\Models\User;
use App\Notifications\EmailNovoUsuarioNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register(Request $request){
        $attributes = $request->all();

        $senha = $this->generateRandomString(10);
        $attributes['password'] = bcrypt($senha);

        $this->userModel->fill($attributes);
        $this->userModel->save();

        $object = [
            'email' => $this->userModel->email,
            'senha' => $senha,
        ];

        $receiveEmail = User::find($this->userModel->id);
        $receiveEmail->notify(new EmailNovoUsuarioNotify($object));

    }

    public function login(Request $request){
        $attributes = $request->all();

        $user = $this->userModel::where('email', $attributes['email'])->first();

        if (Hash::check($attributes['password'], $user->password)) {
            return response()->json([
                "message" => "Registro feito com sucesso!",
                "status" => TRUE,
            ], 200);
        }

        return response()->json([
            "message" => "Email ou senha inválidos!",
            "status" => FALSE,
        ], 404);
    }

    public function teste(){

        $user = $this->userModel::find(1)->first();

        return $user->notify(new EmailNovoUsuarioNotify());
    }

    /**
     * Método privado para gerar senha aleatorio
     *
     */
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}