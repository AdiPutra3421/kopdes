<?php

namespace App\Http\Controllers\Praktikum;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Rules\Uppercase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormValidationController extends Controller
{
    public function showForm(): View
    {
        return view('praktikum.form');
    }

    public function submitForm(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        return back()->with('success', 'Validasi dasar berhasil.')->withInput($validated);
    }

    public function submitRequest(UserRequest $request): RedirectResponse
    {
        return back()->with('success', 'Validasi UserRequest berhasil.')->withInput($request->validated());
    }

    public function submitUppercase(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', new Uppercase],
        ]);

        return back()->with('success', 'Custom uppercase rule berhasil.')->withInput();
    }
}
