<?php

namespace App\Livewire\Account\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsContent extends Component
{
    public $data = [];

    // Profile fields
    public $name = '';
    public $email = '';

    // Password fields
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';
    public $passwordStrength = 0;

    public function mount()
    {
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }
    }


    public function updatedNewPassword($value)
    {
        $this->calculatePasswordStrength($value);
    }

    private function calculatePasswordStrength($password)
    {
        $strength = 0;

        if (strlen($password) >= 8) {
            $strength += 25;
        }
        if (strlen($password) >= 12) {
            $strength += 25;
        }
        if (preg_match('/[a-z]/', $password)) {
            $strength += 12.5;
        }
        if (preg_match('/[A-Z]/', $password)) {
            $strength += 12.5;
        }
        if (preg_match('/[0-9]/', $password)) {
            $strength += 12.5;
        }
        if (preg_match('/[^a-zA-Z0-9]/', $password)) {
            $strength += 12.5;
        }

        $this->passwordStrength = min(100, $strength);
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'Name is required.',
        ]);

        auth()->user()->update([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Name updated successfully!');
        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'Current password is incorrect.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($this->passwordStrength < 75) {
            $this->addError('new_password', 'Password must be stronger. Include uppercase, lowercase, numbers, and special characters.');
            return;
        }

        auth()->user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->resetPasswordFields();
        session()->flash('success', 'Password updated successfully!');
    }

    private function resetPasswordFields()
    {
        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->passwordStrength = 0;
    }

    public function render()
    {
        return view('livewire.account.components.settings-content');
    }
}