<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Register - CosmoShop')]
class RegisterPage extends Component
{
    public $name;
    public $email;
    public $password;

    public function save(){
        $this->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:6|max:255'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        auth()->login($user);

        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
