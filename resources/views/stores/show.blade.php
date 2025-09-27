@extends('layouts.app')

@section('title', '店舗詳細 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-store"></i> 店舗詳細</h2>
                    <p class="text-muted mb-0">店舗ID: {{ $store->id }}</p>
                </div>
                <div>
                    <a href="{{ route('stores.edit', $store) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <form method="POST"
                          action="{{ route('stores.destroy', $store) }}"
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
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> 基本情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>店舗名:</strong></div>
                                <div class="col-sm-8">{{ $store->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>住所:</strong></div>
                                <div class="col-sm-8">{{ $store->address }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>電話番号:</strong></div>
                                <div class="col-sm-8">
                                    @if($store->phone)
                                        <a href="tel:{{ $store->phone }}">{{ $store->phone }}</a>
                                    @else
                                        未設定
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>メール:</strong></div>
                                <div class="col-sm-8">
                                    @if($store->email)
                                        <a href="mailto:{{ $store->email }}">{{ $store->email }}</a>
                                    @else
                                        未設定
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>営業状況:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge {{ $store->status_badge_class }}">
                                        {{ $store->status_display }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 営業情報 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-clock"></i> 営業情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>営業時間:</strong></div>
                                <div class="col-sm-8">
                                    @if($store->opening_hours)
                                        <pre class="mb-0">{{ $store->opening_hours }}</pre>
                                    @else
                                        未設定
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>定休日:</strong></div>
                                <div class="col-sm-8">{{ $store->closed_days ?: '未設定' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>開店日:</strong></div>
                                <div class="col-sm-8">{{ $store->formatted_opening_date ?: '未設定' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>店舗責任者:</strong></div>
                                <div class="col-sm-8">{{ $store->manager_name ?: '未設定' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 営業状況アラート -->
            @if($store->status === 'closed')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            この店舗は現在休業中です。
                        </div>
                    </div>
                </div>
            @elseif($store->status === 'preparing')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-tools"></i>
                            この店舗は現在準備中です。
                        </div>
                    </div>
                </div>
            @endif

            <!-- 備考・説明 -->
            @if($store->description)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-sticky-note"></i> 備考・説明</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $store->description }}</p>
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
                                        <div class="col-sm-8">{{ $store->created_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>更新日:</strong></div>
                                        <div class="col-sm-8">{{ $store->updated_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- マップ表示エリア (将来拡張用) -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> 位置情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4 bg-light">
                                <i class="fas fa-map fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">マップ機能</h6>
                                <p class="text-muted mb-0">将来のアップデートで実装予定</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- アクションボタン -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('stores.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> 店舗一覧に戻る
                        </a>
                        <div>
                            <a href="{{ route('stores.edit', $store) }}" class="btn btn-warning">
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