<?php

namespace App\Http\Controllers\Praktikum;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QueryBuilderController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Acara 17: Query Builder demonstrations.',
            'read' => ['get', 'first', 'where', 'select', 'pluck', 'aggregates', 'join', 'left-join', 'order-limit-offset', 'subquery', 'raw'],
            'write' => ['insert', 'insert-get-id', 'update/{id}', 'increment/{id}', 'decrement/{id}', 'delete/{id}', 'truncate-orders'],
        ]);
    }

    public function insert(): JsonResponse
    {
        $inserted = DB::table('praktikum_users')->insert($this->userData());

        return response()->json(['inserted' => $inserted], 201);
    }

    public function insertGetId(): JsonResponse
    {
        $id = DB::table('praktikum_users')->insertGetId($this->userData());

        return response()->json(['id' => $id], 201);
    }

    public function get(): JsonResponse
    {
        return response()->json(DB::table('praktikum_users')->get());
    }

    public function first(): JsonResponse
    {
        return response()->json(DB::table('praktikum_users')->first());
    }

    public function where(): JsonResponse
    {
        $users = DB::table('praktikum_users')
            ->where('is_active', true)
            ->where('visits', '>=', 0)
            ->get();

        return response()->json($users);
    }

    public function select(): JsonResponse
    {
        return response()->json(DB::table('praktikum_users')->select('id', 'name', 'email')->get());
    }

    public function update(int $id): JsonResponse
    {
        $updated = DB::table('praktikum_users')->where('id', $id)->update([
            'name' => 'Query Builder Updated',
            'updated_at' => now(),
        ]);

        return response()->json(['updated' => $updated]);
    }

    public function increment(int $id): JsonResponse
    {
        return response()->json(['updated' => DB::table('praktikum_users')->where('id', $id)->increment('visits')]);
    }

    public function decrement(int $id): JsonResponse
    {
        $updated = DB::table('praktikum_users')
            ->where('id', $id)
            ->where('visits', '>', 0)
            ->decrement('visits');

        return response()->json(['updated' => $updated]);
    }

    public function delete(int $id): JsonResponse
    {
        return response()->json(['deleted' => DB::table('praktikum_users')->where('id', $id)->delete()]);
    }

    public function truncateOrders(): JsonResponse
    {
        DB::table('praktikum_orders')->truncate();

        return response()->json(['truncated' => true]);
    }

    public function pluck(): JsonResponse
    {
        return response()->json([
            'emails' => DB::table('praktikum_users')->pluck('email'),
            'users_by_id' => DB::table('praktikum_users')->pluck('name', 'id'),
        ]);
    }

    public function aggregates(): JsonResponse
    {
        $orders = DB::table('praktikum_orders');

        return response()->json([
            'count' => (clone $orders)->count(),
            'sum' => (clone $orders)->sum('amount'),
            'avg' => (clone $orders)->avg('amount'),
            'max' => (clone $orders)->max('amount'),
            'min' => (clone $orders)->min('amount'),
        ]);
    }

    public function join(): JsonResponse
    {
        $orders = DB::table('praktikum_orders')
            ->join('praktikum_users', 'praktikum_users.id', '=', 'praktikum_orders.praktikum_user_id')
            ->select('praktikum_orders.*', 'praktikum_users.name as user_name')
            ->get();

        return response()->json($orders);
    }

    public function leftJoin(): JsonResponse
    {
        $users = DB::table('praktikum_users')
            ->leftJoin('praktikum_orders', 'praktikum_users.id', '=', 'praktikum_orders.praktikum_user_id')
            ->select('praktikum_users.id', 'praktikum_users.name', 'praktikum_orders.amount')
            ->get();

        return response()->json($users);
    }

    public function orderLimitOffset(Request $request): JsonResponse
    {
        $limit = min(max($request->integer('limit', 10), 1), 100);
        $offset = max($request->integer('offset', 0), 0);
        $users = DB::table('praktikum_users')->orderBy('id')->limit($limit)->offset($offset)->get();

        return response()->json($users);
    }

    public function subquery(): JsonResponse
    {
        $users = DB::table('praktikum_users')->select('id', 'name')->selectSub(
            DB::table('praktikum_orders')
                ->selectRaw('count(*)')
                ->whereColumn('praktikum_orders.praktikum_user_id', 'praktikum_users.id'),
            'orders_count',
        )->get();

        return response()->json($users);
    }

    public function raw(): JsonResponse
    {
        $orders = DB::table('praktikum_orders')
            ->selectRaw('status, SUM(amount) as total_amount')
            ->whereRaw('amount > ?', [0])
            ->groupBy('status')
            ->get();

        return response()->json($orders);
    }

    private function userData(): array
    {
        $now = now();

        return [
            'name' => 'Praktikum User',
            'email' => 'praktikum+'.Str::uuid().'@example.test',
            'password' => bcrypt(Str::random(24)),
            'is_active' => true,
            'visits' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
