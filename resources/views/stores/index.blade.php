@extends('layouts.app')

@section('title', '店舗一覧 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-store"></i> 店舗一覧</h2>
                <a href="{{ route('stores.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規店舗登録
                </a>
            </div>

            <!-- 検索フォーム -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('stores.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">検索</label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ $search }}"
                                   placeholder="店舗名、住所、責任者名で検索">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">営業状況</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">全ての状況</option>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> 検索
                            </button>
                            <a href="{{ route('stores.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> クリア
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 店舗一覧テーブル -->
            <div class="card">
                <div class="card-body">
                    @if($stores->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>店舗名</th>
                                        <th>住所</th>
                                        <th>責任者</th>
                                        <th>営業状況</th>
                                        <th>開店日</th>
                                        <th>登録日</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stores as $store)
                                        <tr>
                                            <td>{{ $store->id }}</td>
                                            <td>
                                                <strong>{{ $store->name }}</strong>
                                                @if($store->phone)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-phone"></i> {{ $store->phone }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($store->address, 50) }}</small>
                                                @if($store->email)
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-envelope"></i> {{ $store->email }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $store->manager_name ?: '未設定' }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $store->status_badge_class }}">
                                                    {{ $store->status_display }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $store->formatted_opening_date ?: '未設定' }}
                                            </td>
                                            <td>{{ $store->created_at->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('stores.show', $store) }}"
                                                       class="btn btn-outline-info"
                                                       title="詳細表示">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('stores.edit', $store) }}"
                                                       class="btn btn-outline-warning"
                                                       title="編集">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('stores.destroy', $store) }}"
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
                                    {{ $stores->firstItem() }} - {{ $stores->lastItem() }} 件 / 全 {{ $stores->total() }} 件
                                </small>
                            </div>
                            <div>
                                {{ $stores->withQueryString()->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-store fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">店舗が見つかりません</h5>
                            <p class="text-muted">
                                @if($search || $status)
                                    検索条件を変更してください。
                                @else
                                    新しい店舗を登録してください。
                                @endif
                            </p>
                            <a href="{{ route('stores.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> 新規店舗登録
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection