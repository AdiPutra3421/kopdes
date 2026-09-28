<?php

namespace App\Http\Controllers\Praktikum;

use App\Http\Controllers\Controller;
use App\Models\Praktikum\PraktikumUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EloquentAdvancedController extends Controller
{
    public function where(): JsonResponse
    {
        return response()->json(PraktikumUser::where('is_active', true)->get());
    }

    public function orWhere(): JsonResponse
    {
        return response()->json(PraktikumUser::where('is_active', true)->orWhere('visits', '>', 10)->get());
    }

    public function whereBetween(Request $request): JsonResponse
    {
        $minimum = $request->integer('min', 0);
        $maximum = max($request->integer('max', 10), $minimum);

        return response()->json(PraktikumUser::whereBetween('visits', [$minimum, $maximum])->get());
    }

    public function whereIn(): JsonResponse
    {
        return response()->json(PraktikumUser::whereIn('visits', [0, 1, 2])->get());
    }

    public function whereNull(): JsonResponse
    {
        return response()->json(PraktikumUser::whereNull('last_name')->get());
    }

    public function whereNotNull(): JsonResponse
    {
        return response()->json(PraktikumUser::whereNotNull('first_name')->get());
    }

    public function when(Request $request): JsonResponse
    {
        $users = PraktikumUser::query()
            ->when($request->has('is_active'), fn ($query) => $query->where('is_active', $request->boolean('is_active')))
            ->get();

        return response()->json($users);
    }

    public function relation(string $relation): JsonResponse
    {
        abort_unless(in_array($relation, ['profile', 'posts', 'roles'], true), 404);

        return response()->json(PraktikumUser::with($relation)->get());
    }

    public function withTrashed(): JsonResponse
    {
        return response()->json(PraktikumUser::withTrashed()->get());
    }

    public function onlyTrashed(): JsonResponse
    {
        return response()->json(PraktikumUser::onlyTrashed()->get());
    }

    public function restore(int $id): JsonResponse
    {
        $user = PraktikumUser::onlyTrashed()->findOrFail($id);
        $user->restore();

        return response()->json($user->refresh());
    }

    public function active(): JsonResponse
    {
        return response()->json(PraktikumUser::active()->get());
    }
}
