@extends('layouts.app')

@section('title', '店員詳細 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-user"></i> 店員詳細</h2>
                    <p class="text-muted mb-0">店員ID: {{ $employee->id }}</p>
                </div>
                <div>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <form method="POST"
                          action="{{ route('employees.destroy', $employee) }}"
                          class="d-inline"
                          onsubmit="return confirm('本当に削除しますか？この操作は取り消せません。')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> 削除
                        </button>
                    </form>
                </div>
            </div>

            <div class="row">
                <!-- 基本情報 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user"></i> 基本情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>氏名:</strong></div>
                                <div class="col-sm-8">{{ $employee->full_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>氏名（カナ）:</strong></div>
                                <div class="col-sm-8">{{ $employee->full_name_kana }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>メール:</strong></div>
                                <div class="col-sm-8">
                                    @if($employee->email)
                                        <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                    @else
                                        未設定
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>電話番号:</strong></div>
                                <div class="col-sm-8">
                                    @if($employee->phone)
                                        <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                    @else
                                        未設定
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>住所:</strong></div>
                                <div class="col-sm-8">{{ $employee->address ?: '未設定' }}</div>
                            </div>
                            @if($employee->birth_date)
                                <div class="row mb-3">
                                    <div class="col-sm-4"><strong>生年月日:</strong></div>
                                    <div class="col-sm-8">
                                        {{ $employee->formatted_birth_date }}
                                        @if($employee->age)
                                            ({{ $employee->age }}歳)
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 雇用情報 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-briefcase"></i> 雇用情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>配属店舗:</strong></div>
                                <div class="col-sm-8">
                                    <a href="{{ route('stores.show', $employee->store) }}" class="text-decoration-none">
                                        {{ $employee->store->name }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>役職:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-info">
                                        {{ $employee->position_display }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>雇用形態:</strong></div>
                                <div class="col-sm-8">{{ $employee->employment_type_display }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>部署:</strong></div>
                                <div class="col-sm-8">{{ $employee->department ?: '未設定' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>状況:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge {{ $employee->status_badge_class }}">
                                        {{ $employee->status_display }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>入社日:</strong></div>
                                <div class="col-sm-8">
                                    {{ $employee->formatted_hire_date }}
                                    @if($employee->years_of_service !== null)
                                        (勤続{{ $employee->years_of_service }}年)
                                    @endif
                                </div>
                            </div>
                            @if($employee->termination_date)
                                <div class="row mb-3">
                                    <div class="col-sm-4"><strong>退職日:</strong></div>
                                    <div class="col-sm-8">{{ $employee->termination_date->format('Y年m月d日') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 状況アラート -->
            @if($employee->status === 'terminated')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            この店員は退職済みです。
                            @if($employee->termination_date)
                                (退職日: {{ $employee->termination_date->format('Y年m月d日') }})
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($employee->status === 'inactive')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            この店員は現在休職中です。
                        </div>
                    </div>
                </div>
            @elseif($employee->status === 'on_leave')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            この店員は現在休暇中です。
                        </div>
                    </div>
                </div>
            @endif

            <!-- 給与情報 -->
            @if($employee->salary || $employee->hourly_wage)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-yen-sign"></i> 給与情報</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($employee->salary)
                                        <div class="col-md-6">
                                            <div class="row mb-2">
                                                <div class="col-sm-4"><strong>月給:</strong></div>
                                                <div class="col-sm-8">{{ $employee->formatted_salary }}</div>
                                            </div>
                                        </div>
                                    @endif
                                    @if($employee->hourly_wage)
                                        <div class="col-md-6">
                                            <div class="row mb-2">
                                                <div class="col-sm-4"><strong>時給:</strong></div>
                                                <div class="col-sm-8">{{ $employee->formatted_hourly_wage }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 備考・メモ -->
            @if($employee->notes)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-sticky-note"></i> 備考・メモ</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $employee->notes }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- システム情報 -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> システム情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>登録日:</strong></div>
                                        <div class="col-sm-8">{{ $employee->created_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>更新日:</strong></div>
                                        <div class="col-sm-8">{{ $employee->updated_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 関連店舗情報 -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-store"></i> 配属店舗詳細</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>店舗名:</strong></div>
                                        <div class="col-sm-8">
                                            <a href="{{ route('stores.show', $employee->store) }}" class="text-decoration-none">
                                                {{ $employee->store->name }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>住所:</strong></div>
                                        <div class="col-sm-8">{{ $employee->store->address }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>営業状況:</strong></div>
                                        <div class="col-sm-8">
                                            <span class="badge {{ $employee->store->status_badge_class }}">
                                                {{ $employee->store->status_display }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($employee->store->manager_name)
                                        <div class="row mb-2">
                                            <div class="col-sm-4"><strong>店舗責任者:</strong></div>
                                            <div class="col-sm-8">{{ $employee->store->manager_name }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- アクションボタン -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> 店員一覧に戻る
                        </a>
                        <div>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection