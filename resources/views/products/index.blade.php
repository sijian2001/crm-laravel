@extends('layouts.app')

@section('title', '製品一覧 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-box"></i> 製品一覧</h2>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規製品登録
                </a>
            </div>

            <!-- 検索フォーム -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">検索</label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ $search }}"
                                   placeholder="製品名、SKU、カテゴリで検索">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">カテゴリ</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">全てのカテゴリ</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> 検索
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> クリア
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 製品一覧テーブル -->
            <div class="card">
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>製品名</th>
                                        <th>SKU</th>
                                        <th>カテゴリ</th>
                                        <th>価格</th>
                                        <th>在庫</th>
                                        <th>ステータス</th>
                                        <th>登録日</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                <strong>{{ $product->name }}</strong>
                                                @if($product->description)
                                                    <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td><code>{{ $product->sku }}</code></td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $product->category }}</span>
                                            </td>
                                            <td>{{ $product->formatted_price }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($product->stock_quantity <= 0)
                                                        bg-danger
                                                    @elseif($product->stock_quantity <= 10)
                                                        bg-warning
                                                    @else
                                                        bg-success
                                                    @endif">
                                                    {{ $product->stock_quantity }}個 ({{ $product->stock_status }})
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product->status_display }}
                                                </span>
                                            </td>
                                            <td>{{ $product->created_at->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('products.show', $product) }}"
                                                       class="btn btn-outline-info"
                                                       title="詳細表示">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product) }}"
                                                       class="btn btn-outline-warning"
                                                       title="編集">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('products.destroy', $product) }}"
                                                          class="d-inline"
                                                          onsubmit="return confirm('本当に削除しますか？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-outline-danger"
                                                                title="削除">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- ページネーション -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="text-muted">
                                    {{ $products->firstItem() }} - {{ $products->lastItem() }} 件 / 全 {{ $products->total() }} 件
                                </small>
                            </div>
                            <div>
                                {{ $products->withQueryString()->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">製品が見つかりません</h5>
                            <p class="text-muted">
                                @if($search || $category)
                                    検索条件を変更してください。
                                @else
                                    新しい製品を登録してください。
                                @endif
                            </p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> 新規製品登録
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection