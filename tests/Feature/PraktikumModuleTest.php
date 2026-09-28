<?php

namespace Tests\Feature;

use App\Models\Praktikum\Post;
use App\Models\Praktikum\PraktikumUser;
use App\Models\Praktikum\Profile;
use App\Models\Praktikum\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PraktikumModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_query_builder_insert_and_read_routes_use_the_praktikum_table(): void
    {
        $this->postJson('/praktikum/query-builder/insert')
            ->assertCreated()
            ->assertJsonPath('inserted', true);

        $this->postJson('/praktikum/query-builder/insert-get-id')
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->getJson('/praktikum/query-builder/get')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonPath('0.name', 'Praktikum User');

        $this->assertDatabaseCount('praktikum_users', 2);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_query_builder_read_write_aggregate_and_raw_routes_execute(): void
    {
        $user = PraktikumUser::create([
            'name' => 'Query Demo',
            'email' => 'query@example.test',
            'password' => 'secret-pass',
            'first_name' => 'Query',
            'last_name' => 'Demo',
        ]);
        DB::table('praktikum_orders')->insert([
            'praktikum_user_id' => $user->id,
            'amount' => 250,
            'status' => 'paid',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ([
            'get', 'first', 'where', 'select', 'pluck', 'aggregates', 'join', 'left-join',
            'order-limit-offset?limit=1&offset=0', 'subquery', 'raw',
        ] as $path) {
            $this->getJson('/praktikum/query-builder/'.$path)->assertOk();
        }

        $this->getJson('/praktikum/query-builder/aggregates')
            ->assertJsonPath('count', 1)
            ->assertJsonPath('sum', 250)
            ->assertJsonPath('avg', 250)
            ->assertJsonPath('max', 250)
            ->assertJsonPath('min', 250);

        $this->patchJson('/praktikum/query-builder/update/'.$user->id)->assertOk();
        $this->patchJson('/praktikum/query-builder/increment/'.$user->id)->assertJsonPath('updated', 1);
        $this->patchJson('/praktikum/query-builder/decrement/'.$user->id)->assertJsonPath('updated', 1);
        $this->deleteJson('/praktikum/query-builder/delete/'.$user->id)->assertJsonPath('deleted', 1);
        $this->postJson('/praktikum/query-builder/truncate-orders')->assertOk();
        $this->assertDatabaseCount('praktikum_orders', 0);
    }

    public function test_eloquent_crud_create_and_update_routes_persist_changes(): void
    {
        $this->postJson('/praktikum/eloquent-crud/create', [
            'name' => 'Dewi Praktikum',
            'email' => 'dewi@example.test',
            'password' => 'secret-pass',
        ])->assertCreated();

        $user = PraktikumUser::firstOrFail();

        $this->patchJson('/praktikum/eloquent-crud/update/'.$user->id, ['name' => 'Dewi Updated'])
            ->assertOk()
            ->assertJsonPath('name', 'Dewi Updated');

        $savedUser = $this->postJson('/praktikum/eloquent-crud/save', [
            'name' => 'Bima Praktikum',
            'email' => 'bima@example.test',
            'password' => 'secret-pass',
        ])->assertCreated();
        $savedId = $savedUser->json('id');

        $this->getJson('/praktikum/eloquent-crud/all')->assertOk()->assertJsonCount(2);
        $this->getJson('/praktikum/eloquent-crud/find/'.$savedId)->assertOk();
        $this->getJson('/praktikum/eloquent-crud/where')->assertOk();
        $this->getJson('/praktikum/eloquent-crud/first-or-fail')->assertOk();
        $this->patchJson('/praktikum/eloquent-crud/save-update/'.$savedId, ['name' => 'Bima Saved'])
            ->assertOk()
            ->assertJsonPath('name', 'Bima Saved');
        $this->deleteJson('/praktikum/eloquent-crud/delete/'.$user->id)->assertJsonPath('deleted', true);
        $this->deleteJson('/praktikum/eloquent-crud/destroy/'.$savedId)->assertJsonPath('deleted', true);

        $this->assertDatabaseHas('praktikum_users', ['id' => $user->id, 'name' => 'Dewi Updated']);
    }

    public function test_form_validation_and_uppercase_rule_report_errors(): void
    {
        $this->get('/praktikum/form')->assertOk()->assertSee('name="_token"', false);

        $this->from('/praktikum/form')
            ->post('/praktikum/form', ['name' => '', 'email' => 'not-an-email'])
            ->assertRedirect('/praktikum/form')
            ->assertSessionHasErrors([
                'name' => 'Nama wajib diisi.',
                'email' => 'Format email tidak valid.',
            ]);

        $this->from('/praktikum/form')
            ->post('/praktikum/form', ['name' => 'Ayu', 'email' => 'ayu@example.test'])
            ->assertRedirect('/praktikum/form')
            ->assertSessionHas('success', 'Validasi dasar berhasil.');

        $this->from('/praktikum/form')
            ->post('/praktikum/form/request', ['name' => 'Ayu', 'email' => 'ayu@example.test'])
            ->assertRedirect('/praktikum/form')
            ->assertSessionHas('success', 'Validasi UserRequest berhasil.');

        $this->from('/praktikum/form')
            ->post('/praktikum/form/uppercase', ['first_name' => 'Dewi'])
            ->assertRedirect('/praktikum/form')
            ->assertSessionHasErrors('first_name');

        $this->from('/praktikum/form')
            ->post('/praktikum/form/uppercase', ['first_name' => 'DEWI'])
            ->assertRedirect('/praktikum/form')
            ->assertSessionHasNoErrors();
    }

    public function test_soft_deleted_praktikum_user_can_be_restored(): void
    {
        $user = PraktikumUser::create([
            'name' => 'Raka Praktikum',
            'email' => 'raka@example.test',
            'password' => 'secret-pass',
            'first_name' => 'Raka',
            'last_name' => 'Praktikum',
        ]);
        $user->delete();

        $this->getJson('/praktikum/eloquent-advanced/only-trashed')
            ->assertOk()
            ->assertJsonCount(1);

        $this->postJson('/praktikum/eloquent-advanced/restore/'.$user->id)
            ->assertOk()
            ->assertJsonPath('full_name', 'Raka Praktikum');

        $this->assertDatabaseHas('praktikum_users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function test_advanced_relationship_routes_load_praktikum_only_relations(): void
    {
        $user = PraktikumUser::create([
            'name' => 'Nia Praktikum',
            'email' => 'nia@example.test',
            'password' => 'secret-pass',
        ]);
        Profile::create(['praktikum_user_id' => $user->id, 'phone' => '0812345678']);
        Post::create(['praktikum_user_id' => $user->id, 'title' => 'Demo', 'body' => 'Isi']);
        $role = Role::create(['name' => 'editor']);
        $user->roles()->attach($role);

        $this->getJson('/praktikum/eloquent-advanced/relation/profile')
            ->assertOk()
            ->assertJsonPath('0.profile.phone', '0812345678');
        $this->getJson('/praktikum/eloquent-advanced/relation/posts')
            ->assertOk()
            ->assertJsonPath('0.posts.0.title', 'Demo');
        $this->getJson('/praktikum/eloquent-advanced/relation/roles')
            ->assertOk()
            ->assertJsonPath('0.roles.0.name', 'editor');

        foreach ([
            'where', 'or-where', 'where-between', 'where-in', 'where-null',
            'where-not-null', 'when?is_active=1', 'with-trashed', 'active',
        ] as $path) {
            $this->getJson('/praktikum/eloquent-advanced/'.$path)->assertOk();
        }
    }
}
