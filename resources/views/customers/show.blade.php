@extends('layouts.app')

@section('title', '顧客詳細 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-user"></i> 顧客詳細</h2>
                    <p class="text-muted mb-0">顧客ID: {{ $customer->id }}</p>
                </div>
                <div>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <form method="POST"
                          action="{{ route('customers.destroy', $customer) }}"
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
                            <h5 class="mb-0"><i class="fas fa-id-card"></i> 基本情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>名前:</strong></div>
                                <div class="col-sm-8">{{ $customer->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>メール:</strong></div>
                                <div class="col-sm-8">
                                    <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>電話番号:</strong></div>
                                <div class="col-sm-8">
                                    @if($customer->phone)
                                        <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                                    @else
                                        <span class="text-muted">未設定</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>性別:</strong></div>
                                <div class="col-sm-8">
                                    @if($customer->gender)
                                        <span class="badge bg-secondary">{{ $customer->gender_display }}</span>
                                    @else
                                        <span class="text-muted">未設定</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>生年月日:</strong></div>
                                <div class="col-sm-8">
                                    @if($customer->birth_date)
                                        {{ $customer->birth_date->format('Y年m月d日') }}
                                        <small class="text-muted">
                                            ({{ $customer->birth_date->age }}歳)
                                        </small>
                                    @else
                                        <span class="text-muted">未設定</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 会社情報 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-building"></i> 会社情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>会社名:</strong></div>
                                <div class="col-sm-8">
                                    {{ $customer->company ?? '未設定' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>部署:</strong></div>
                                <div class="col-sm-8">
                                    {{ $customer->department ?? '未設定' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>役職:</strong></div>
                                <div class="col-sm-8">
                                    {{ $customer->position ?? '未設定' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 住所情報 -->
            @if($customer->address)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> 住所</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $customer->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 備考 -->
            @if($customer->notes)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-sticky-note"></i> 備考</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $customer->notes }}</p>
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
                                        <div class="col-sm-8">{{ $customer->created_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>更新日:</strong></div>
                                        <div class="col-sm-8">{{ $customer->updated_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
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
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> 顧客一覧に戻る
                        </a>
                        <div>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">
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