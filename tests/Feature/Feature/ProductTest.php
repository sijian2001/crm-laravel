<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * 製品一覧ページのテスト
     */
    public function test_can_view_products_index()
    {
        Product::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('products.index'));

        $response->assertStatus(200)
                ->assertViewIs('products.index')
                ->assertViewHas('products');
    }

    /**
     * 製品検索機能のテスト
     */
    public function test_can_search_products()
    {
        Product::factory()->create(['name' => 'テストプロダクト']);
        Product::factory()->create(['name' => 'サンプル商品']);

        $response = $this->actingAs($this->user)
                         ->get(route('products.index', ['search' => 'テスト']));

        $response->assertStatus(200)
                ->assertSee('テストプロダクト')
                ->assertDontSee('サンプル商品');
    }

    /**
     * カテゴリフィルター機能のテスト
     */
    public function test_can_filter_products_by_category()
    {
        Product::factory()->create(['category' => '電子機器']);
        Product::factory()->create(['category' => '食品']);

        $response = $this->actingAs($this->user)
                         ->get(route('products.index', ['category' => '電子機器']));

        $response->assertStatus(200)
                ->assertSee('電子機器');
    }

    /**
     * 製品登録フォーム表示テスト
     */
    public function test_can_view_product_create_form()
    {
        $response = $this->actingAs($this->user)->get(route('products.create'));

        $response->assertStatus(200)
                ->assertViewIs('products.create');
    }

    /**
     * 製品新規登録テスト
     */
    public function test_can_create_product()
    {
        $productData = [
            'name' => 'テスト製品',
            'description' => 'テスト用の製品です',
            'price' => 1000.00,
            'sku' => 'TEST-001',
            'category' => 'テストカテゴリ',
            'stock_quantity' => 10,
            'status' => true,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'テスト製品',
            'sku' => 'TEST-001',
        ]);
    }

    /**
     * 製品登録バリデーションテスト
     */
    public function test_product_create_validation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('products.store'), []);

        $response->assertSessionHasErrors(['name', 'price', 'sku', 'category', 'stock_quantity']);
    }

    /**
     * SKU重複チェックテスト
     */
    public function test_sku_must_be_unique()
    {
        Product::factory()->create(['sku' => 'DUPLICATE-001']);

        $productData = [
            'name' => 'テスト製品',
            'price' => 1000.00,
            'sku' => 'DUPLICATE-001',
            'category' => 'テストカテゴリ',
            'stock_quantity' => 10,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('products.store'), $productData);

        $response->assertSessionHasErrors(['sku']);
    }

    /**
     * 製品詳細表示テスト
     */
    public function test_can_view_product_details()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('products.show', $product));

        $response->assertStatus(200)
                ->assertViewIs('products.show')
                ->assertViewHas('product')
                ->assertSee($product->name);
    }

    /**
     * 製品編集フォーム表示テスト
     */
    public function test_can_view_product_edit_form()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('products.edit', $product));

        $response->assertStatus(200)
                ->assertViewIs('products.edit')
                ->assertViewHas('product');
    }

    /**
     * 製品更新テスト
     */
    public function test_can_update_product()
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => '更新されたプロダクト',
            'description' => '更新された説明',
            'price' => 2000.00,
            'sku' => $product->sku,
            'category' => '更新されたカテゴリ',
            'stock_quantity' => 20,
            'status' => true,
        ];

        $response = $this->actingAs($this->user)
                         ->put(route('products.update', $product), $updatedData);

        $response->assertRedirect(route('products.show', $product))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => '更新されたプロダクト',
            'price' => 2000.00,
        ]);
    }

    /**
     * 製品削除テスト
     */
    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)
                         ->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    /**
     * 未認証アクセステスト
     */
    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect(route('login'));
    }
}
