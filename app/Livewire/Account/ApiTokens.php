<?php

namespace App\Livewire\Account;

use Livewire\Component;

class ApiTokens extends Component
{
    public $new_token_name = '';
    public $created_token = null;

    public function createToken()
    {
        $this->validate([
            'new_token_name' => 'required|string|max:255',
        ], [
            'new_token_name.required' => 'Token name is required.',
            'new_token_name.max' => 'Token name must not exceed 255 characters.',
        ]);

        $token = auth()->user()->createToken($this->new_token_name);

        $this->created_token = [
            'name' => $this->new_token_name,
            'token' => $token->plainTextToken,
        ];

        $this->new_token_name = '';

        session()->flash('success', 'API token created successfully!');
    }

    public function deleteToken($tokenId)
    {
        $token = auth()->user()->tokens()->find($tokenId);

        if ($token) {
            $token->delete();
            session()->flash('success', 'API token deleted successfully!');
        }
    }

    public function dismissCreatedToken()
    {
        $this->created_token = null;
    }

    public function getTokensProperty()
    {
        return auth()->user()->tokens()->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.account.api-tokens')->layout('layouts.account');
    }
}