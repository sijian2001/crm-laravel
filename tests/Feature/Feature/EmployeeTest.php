<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Store;

class EmployeeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * 店員一覧ページのテスト
     */
    public function test_can_view_employees_index()
    {
        $store = Store::factory()->create();
        Employee::factory()->count(5)->create(['store_id' => $store->id]);

        $response = $this->actingAs($this->user)->get(route('employees.index'));

        $response->assertStatus(200)
                ->assertViewIs('employees.index')
                ->assertViewHas('employees');
    }

    /**
     * 店員検索機能のテスト
     */
    public function test_can_search_employees()
    {
        $store = Store::factory()->create();
        Employee::factory()->create([
            'first_name' => 'テスト',
            'last_name' => '太郎',
            'store_id' => $store->id,
        ]);
        Employee::factory()->create([
            'first_name' => 'サンプル',
            'last_name' => '花子',
            'store_id' => $store->id,
        ]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.index', ['search' => 'テスト']));

        $response->assertStatus(200)
                ->assertSee('太郎 テスト')
                ->assertDontSee('花子 サンプル');
    }

    /**
     * 店舗フィルター機能のテスト
     */
    public function test_can_filter_employees_by_store()
    {
        $store1 = Store::factory()->create(['name' => '店舗A']);
        $store2 = Store::factory()->create(['name' => '店舗B']);

        Employee::factory()->create(['store_id' => $store1->id]);
        Employee::factory()->create(['store_id' => $store2->id]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.index', ['store_id' => $store1->id]));

        $response->assertStatus(200);
    }

    /**
     * 役職フィルター機能のテスト
     */
    public function test_can_filter_employees_by_position()
    {
        $store = Store::factory()->create();
        Employee::factory()->create(['position' => 'manager', 'store_id' => $store->id]);
        Employee::factory()->create(['position' => 'staff', 'store_id' => $store->id]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.index', ['position' => 'manager']));

        $response->assertStatus(200);
    }

    /**
     * 状況フィルター機能のテスト
     */
    public function test_can_filter_employees_by_status()
    {
        $store = Store::factory()->create();
        Employee::factory()->create(['status' => 'active', 'store_id' => $store->id]);
        Employee::factory()->create(['status' => 'terminated', 'store_id' => $store->id]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.index', ['status' => 'active']));

        $response->assertStatus(200);
    }

    /**
     * 店員登録フォーム表示テスト
     */
    public function test_can_view_employee_create_form()
    {
        $response = $this->actingAs($this->user)->get(route('employees.create'));

        $response->assertStatus(200)
                ->assertViewIs('employees.create');
    }

    /**
     * 店員新規登録テスト
     */
    public function test_can_create_employee()
    {
        $store = Store::factory()->create();
        $employeeData = [
            'first_name' => 'テスト',
            'last_name' => '太郎',
            'first_name_kana' => 'テスト',
            'last_name_kana' => 'タロウ',
            'email' => 'test@example.com',
            'phone' => '090-1234-5678',
            'address' => '東京都渋谷区テスト1-1-1',
            'birth_date' => '1990-01-01',
            'hire_date' => '2020-04-01',
            'termination_date' => '',
            'employment_type' => 'full_time',
            'position' => 'staff',
            'salary' => 250000,
            'hourly_wage' => '',
            'department' => '営業部',
            'status' => 'active',
            'store_id' => $store->id,
            'notes' => 'テスト店員',
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('employees.store'), $employeeData);

        $response->assertRedirect(route('employees.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('employees', [
            'first_name' => 'テスト',
            'last_name' => '太郎',
            'email' => 'test@example.com',
        ]);
    }

    /**
     * 店員登録バリデーションテスト
     */
    public function test_employee_create_validation()
    {
        $response = $this->actingAs($this->user)
                         ->post(route('employees.store'), []);

        $response->assertSessionHasErrors([
            'first_name', 'last_name', 'first_name_kana', 'last_name_kana',
            'email', 'hire_date', 'employment_type', 'position', 'status', 'store_id'
        ]);
    }

    /**
     * メール重複バリデーションテスト
     */
    public function test_employee_email_unique_validation()
    {
        $store = Store::factory()->create();
        Employee::factory()->create([
            'email' => 'existing@example.com',
            'store_id' => $store->id,
        ]);

        $employeeData = [
            'first_name' => 'テスト',
            'last_name' => '太郎',
            'first_name_kana' => 'テスト',
            'last_name_kana' => 'タロウ',
            'email' => 'existing@example.com',
            'hire_date' => '2020-04-01',
            'employment_type' => 'full_time',
            'position' => 'staff',
            'status' => 'active',
            'store_id' => $store->id,
        ];

        $response = $this->actingAs($this->user)
                         ->post(route('employees.store'), $employeeData);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * 店員詳細表示テスト
     */
    public function test_can_view_employee_details()
    {
        $store = Store::factory()->create();
        $employee = Employee::factory()->create(['store_id' => $store->id]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.show', $employee));

        $response->assertStatus(200)
                ->assertViewIs('employees.show')
                ->assertViewHas('employee')
                ->assertSee($employee->full_name);
    }

    /**
     * 店員編集フォーム表示テスト
     */
    public function test_can_view_employee_edit_form()
    {
        $store = Store::factory()->create();
        $employee = Employee::factory()->create(['store_id' => $store->id]);

        $response = $this->actingAs($this->user)
                         ->get(route('employees.edit', $employee));

        $response->assertStatus(200)
                ->assertViewIs('employees.edit')
                ->assertViewHas('employee');
    }

    /**
     * 店員更新テスト
     */
    public function test_can_update_employee()
    {
        $store = Store::factory()->create();
        $employee = Employee::factory()->create(['store_id' => $store->id]);
        $updatedData = [
            'first_name' => '更新',
            'last_name' => '太郎',
            'first_name_kana' => 'コウシン',
            'last_name_kana' => 'タロウ',
            'email' => 'updated@example.com',
            'phone' => '090-9999-8888',
            'address' => $employee->address,
            'birth_date' => $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '',
            'hire_date' => $employee->hire_date->format('Y-m-d'),
            'termination_date' => '',
            'employment_type' => 'part_time',
            'position' => 'senior_staff',
            'salary' => '',
            'hourly_wage' => 1200,
            'department' => $employee->department,
            'status' => 'active',
            'store_id' => $store->id,
            'notes' => $employee->notes,
        ];

        $response = $this->actingAs($this->user)
                         ->put(route('employees.update', $employee), $updatedData);

        $response->assertRedirect(route('employees.show', $employee))
                ->assertSessionHas('success');

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => '更新',
            'last_name' => '太郎',
            'email' => 'updated@example.com',
        ]);
    }

    /**
     * 店員削除テスト
     */
    public function test_can_delete_employee()
    {
        $store = Store::factory()->create();
        $employee = Employee::factory()->create(['store_id' => $store->id]);

        $response = $this->actingAs($this->user)
                         ->delete(route('employees.destroy', $employee));

        $response->assertRedirect(route('employees.index'))
                ->assertSessionHas('success');

        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    /**
     * 未認証アクセステスト
     */
    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get(route('employees.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Employee モデルのアクセサテスト
     */
    public function test_employee_model_accessors()
    {
        $store = Store::factory()->create();
        $employee = Employee::factory()->create([
            'first_name' => '太郎',
            'last_name' => '田中',
            'first_name_kana' => 'タロウ',
            'last_name_kana' => 'タナカ',
            'position' => 'manager',
            'employment_type' => 'full_time',
            'status' => 'active',
            'salary' => 300000,
            'store_id' => $store->id,
        ]);

        $this->assertEquals('田中 太郎', $employee->full_name);
        $this->assertEquals('タナカ タロウ', $employee->full_name_kana);
        $this->assertEquals('店長', $employee->position_display);
        $this->assertEquals('正社員', $employee->employment_type_display);
        $this->assertEquals('在職中', $employee->status_display);
        $this->assertEquals('¥300,000', $employee->formatted_salary);
        $this->assertTrue($employee->is_active);
    }
}
