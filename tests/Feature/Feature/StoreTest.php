<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Store;

class StoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * 店舗一覧ページのテスト
     */
    public function test_can_view_stores_index()
    {
        Store::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('stores.index'));

        $response->assertStatus(200)
                ->assertViewIs('stores.index')
                ->assertViewHas('stores');
    }

    /**
     * 店舗検索機能のテスト
     */
    public function test_can_search_stores()
    {
        Store::factory()->create(['name' => 'テスト店舗']);
        Store::factory()->create(['name' => 'サンプル店舗']);

        $response = $this->actingAs($this->user)
                         ->get(route('stores.index', ['search' => 'テスト']));

        $response->assertStatus(200)
                ->assertSee('テスト店舗')
                ->assertDontSee('サンプル店舗');
    }

    /**
     * 営業状況フィルター機能のテスト
     */
    public function test_can_filter_stores_by_status()
    {
        Store::factory()->create(['status' => 'open']);
        Store::factory()->create(['status' => 'closed']);

        $response = $this->actingAs($this->user)
                         ->get(route('stores.index', ['status' => 'open']));

        $response->assertStatus(200);
    }

    /**
     * 店舗登録フォーム表示テスト
     */
    public function test_can_view_store_create_form()
    {
        $response = $this->actingAs($this->user)->get(route('stores.create'));

        $response->assertStatus(200)
                ->assertViewIs('stores.create');
    }

    /**
     * 店舗新規登録テスト
     */
    public function test_can_create_store()
    {
        $storeData = [
            'name' => 'テスト店舗',
            'address' => '東京都渋谷区テスト1-1-1',
            'phone' => '03-1234-5678',
            'email' => 'test@example.com',
            'status' => 'open',
            'manager_name' => 'テスト太郎',
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('stores.store'), $storeData);

        $response->assertRedirect(route('stores.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('stores', [
            'name' => 'テスト店舗',
            'address' => '東京都渋谷区テスト1-1-1',
        ]);
    }

    /**
     * 店舗登録バリデーションテスト
     */
    public function test_store_create_validation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('stores.store'), []);

        $response->assertSessionHasErrors(['name', 'address', 'status']);
    }

    /**
     * 店舗詳細表示テスト
     */
    public function test_can_view_store_details()
    {
        $store = Store::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('stores.show', $store));

        $response->assertStatus(200)
                ->assertViewIs('stores.show')
                ->assertViewHas('store')
                ->assertSee($store->name);
    }

    /**
     * 店舗編集フォーム表示テスト
     */
    public function test_can_view_store_edit_form()
    {
        $store = Store::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('stores.edit', $store));

        $response->assertStatus(200)
                ->assertViewIs('stores.edit')
                ->assertViewHas('store');
    }

    /**
     * 店舗更新テスト
     */
    public function test_can_update_store()
    {
        $store = Store::factory()->create();
        $updatedData = [
            'name' => '更新された店舗',
            'address' => '更新された住所',
            'phone' => '03-9999-8888',
            'email' => 'updated@example.com',
            'status' => 'closed',
            'manager_name' => '更新太郎',
        ];

        $response = $this->actingAs($this->user)
                         ->put(route('stores.update', $store), $updatedData);

        $response->assertRedirect(route('stores.show', $store))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => '更新された店舗',
            'address' => '更新された住所',
        ]);
    }

    /**
     * 店舗削除テスト
     */
    public function test_can_delete_store()
    {
        $store = Store::factory()->create();

        $response = $this->actingAs($this->user)
                         ->delete(route('stores.destroy', $store));

        $response->assertRedirect(route('stores.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseMissing('stores', [
            'id' => $store->id,
        ]);
    }

    /**
     * 未認証アクセステスト
     */
    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get(route('stores.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * 営業状況表示テスト
     */
    public function test_store_status_display()
    {
        $openStore = Store::factory()->create(['status' => 'open']);
        $closedStore = Store::factory()->create(['status' => 'closed']);
        $preparingStore = Store::factory()->create(['status' => 'preparing']);

        $this->assertEquals('営業中', $openStore->status_display);
        $this->assertEquals('休業中', $closedStore->status_display);
        $this->assertEquals('準備中', $preparingStore->status_display);
    }
}
