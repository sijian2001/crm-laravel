<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * 顧客一覧ページのテスト
     */
    public function test_can_view_customers_index()
    {
        Customer::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get(route('customers.index'));

        $response->assertStatus(200)
                ->assertViewIs('customers.index')
                ->assertViewHas('customers');
    }

    /**
     * 顧客検索機能のテスト
     */
    public function test_can_search_customers()
    {
        Customer::factory()->create(['name' => '田中太郎']);
        Customer::factory()->create(['name' => '佐藤花子']);

        $response = $this->actingAs($this->user)
                         ->get(route('customers.index', ['search' => '田中']));

        $response->assertStatus(200)
                ->assertSee('田中太郎')
                ->assertDontSee('佐藤花子');
    }

    /**
     * 顧客登録フォーム表示テスト
     */
    public function test_can_view_customer_create_form()
    {
        $response = $this->actingAs($this->user)->get(route('customers.create'));

        $response->assertStatus(200)
                ->assertViewIs('customers.create');
    }

    /**
     * 顧客新規登録テスト
     */
    public function test_can_create_customer()
    {
        $customerData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'company' => $this->faker->company,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('customers.store'), $customerData);

        $response->assertRedirect(route('customers.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('customers', [
            'name' => $customerData['name'],
            'email' => $customerData['email'],
        ]);
    }

    /**
     * 顧客登録バリデーションテスト
     */
    public function test_customer_create_validation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('customers.store'), []);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    /**
     * 顧客詳細表示テスト
     */
    public function test_can_view_customer_details()
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('customers.show', $customer));

        $response->assertStatus(200)
                ->assertViewIs('customers.show')
                ->assertViewHas('customer')
                ->assertSee($customer->name);
    }

    /**
     * 顧客編集フォーム表示テスト
     */
    public function test_can_view_customer_edit_form()
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($this->user)
                         ->get(route('customers.edit', $customer));

        $response->assertStatus(200)
                ->assertViewIs('customers.edit')
                ->assertViewHas('customer');
    }

    /**
     * 顧客更新テスト
     */
    public function test_can_update_customer()
    {
        $customer = Customer::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '090-1234-5678',
        ];

        $response = $this->actingAs($this->user)
                         ->put(route('customers.update', $customer), $updatedData);

        $response->assertRedirect(route('customers.show', $customer))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * 顧客削除テスト
     */
    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->actingAs($this->user)
                         ->delete(route('customers.destroy', $customer));

        $response->assertRedirect(route('customers.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    /**
     * 未認証アクセステスト
     */
    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get(route('customers.index'));

        $response->assertRedirect(route('login'));
    }
}
