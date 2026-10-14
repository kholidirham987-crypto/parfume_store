<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->latest()
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        return redirect()
            ->route('customers.index')
            ->with('success', 'Akun customer berhasil dibuat.');
    }

    public function show(User $customer)
    {
        abort_if($customer->role !== 'customer', 404);

        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        abort_if($customer->role !== 'customer', 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        abort_if($customer->role !== 'customer', 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $customer->name = $data['name'];
        $customer->email = $data['email'];

        if (!empty($data['password'])) {
            $customer->password = Hash::make($data['password']);
        }

        $customer->save();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(User $customer)
    {
        abort_if($customer->role !== 'customer', 404);

        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Akun customer berhasil dihapus.');
    }
}