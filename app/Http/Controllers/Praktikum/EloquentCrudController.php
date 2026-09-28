<?php

namespace App\Http\Controllers\Praktikum;

use App\Http\Controllers\Controller;
use App\Models\Praktikum\PraktikumUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EloquentCrudController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $user = PraktikumUser::create($this->validatedUser($request));

        return response()->json($user, 201);
    }

    public function save(Request $request): JsonResponse
    {
        $user = new PraktikumUser($this->validatedUser($request));
        $user->save();

        return response()->json($user, 201);
    }

    public function all(): JsonResponse
    {
        return response()->json(PraktikumUser::all());
    }

    public function find(int $id): JsonResponse
    {
        return response()->json(PraktikumUser::findOrFail($id));
    }

    public function where(): JsonResponse
    {
        return response()->json(PraktikumUser::where('is_active', true)->get());
    }

    public function firstOrFail(): JsonResponse
    {
        return response()->json(PraktikumUser::where('is_active', true)->firstOrFail());
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = PraktikumUser::findOrFail($id);
        $user->update($request->validate(['name' => ['required', 'string', 'max:255']]));

        return response()->json($user->refresh());
    }

    public function saveUpdate(Request $request, int $id): JsonResponse
    {
        $user = PraktikumUser::findOrFail($id);
        $user->name = $request->validate(['name' => ['required', 'string', 'max:255']])['name'];
        $user->save();

        return response()->json($user->refresh());
    }

    public function delete(int $id): JsonResponse
    {
        $user = PraktikumUser::findOrFail($id);
        $deleted = $user->delete();

        return response()->json(['deleted' => $deleted]);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => PraktikumUser::destroy($id) > 0]);
    }

    private function validatedUser(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:praktikum_users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }
}
