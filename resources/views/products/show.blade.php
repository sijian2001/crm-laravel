@extends('layouts.app')

@section('title', '製品詳細 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-box"></i> 製品詳細</h2>
                    <p class="text-muted mb-0">製品ID: {{ $product->id }}</p>
                </div>
                <div>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> 編集
                    </a>
                    <form method="POST"
                          action="{{ route('products.destroy', $product) }}"
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
                                <div class="col-sm-4"><strong>製品名:</strong></div>
                                <div class="col-sm-8">{{ $product->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>SKU:</strong></div>
                                <div class="col-sm-8"><code>{{ $product->sku }}</code></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>価格:</strong></div>
                                <div class="col-sm-8">
                                    <span class="h5 text-primary">{{ $product->formatted_price }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>カテゴリ:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-secondary">{{ $product->category }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>ステータス:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->status_display }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 在庫情報 -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-warehouse"></i> 在庫情報</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>在庫数量:</strong></div>
                                <div class="col-sm-8">
                                    <span class="h4">{{ $product->stock_quantity }}個</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>在庫状況:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge
                                        @if($product->stock_quantity <= 0)
                                            bg-danger
                                        @elseif($product->stock_quantity <= 10)
                                            bg-warning
                                        @else
                                            bg-success
                                        @endif">
                                        {{ $product->stock_status }}
                                    </span>
                                </div>
                            </div>
                            @if($product->stock_quantity <= 10)
                                <div class="alert alert-{{ $product->stock_quantity <= 0 ? 'danger' : 'warning' }} mb-0">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    @if($product->stock_quantity <= 0)
                                        在庫切れです。入荷の手配が必要です。
                                    @else
                                        在庫が少なくなっています。補充を検討してください。
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 製品画像 -->
            @if($product->image_url)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-image"></i> 製品画像</h5>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid"
                                     style="max-height: 400px; object-fit: contain;">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 製品説明 -->
            @if($product->description)
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-file-text"></i> 製品説明</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $product->description }}</p>
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
                                        <div class="col-sm-8">{{ $product->created_at->format('Y年m月d日 H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>更新日:</strong></div>
                                        <div class="col-sm-8">{{ $product->updated_at->format('Y年m月d日 H:i') }}</div>
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
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> 製品一覧に戻る
                        </a>
                        <div>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
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