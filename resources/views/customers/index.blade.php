@extends('layouts.app')

@section('title', '顧客一覧 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-users"></i> 顧客一覧</h2>
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規顧客登録
                </a>
            </div>

            <!-- 検索フォーム -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('customers.index') }}">
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="名前、メールアドレス、電話番号、会社名で検索..."
                                       value="{{ $search }}">
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i> 検索
                                    </button>
                                    @if($search)
                                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> クリア
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 顧客一覧テーブル -->
            <div class="card">
                <div class="card-body">
                    @if($customers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>名前</th>
                                        <th>メールアドレス</th>
                                        <th>電話番号</th>
                                        <th>会社名</th>
                                        <th>登録日</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <a href="{{ route('customers.show', $customer) }}" class="text-decoration-none">
                                                    {{ $customer->name }}
                                                </a>
                                            </td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone ?? '-' }}</td>
                                            <td>{{ $customer->company ?? '-' }}</td>
                                            <td>{{ $customer->created_at->format('Y/m/d') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('customers.show', $customer) }}"
                                                       class="btn btn-sm btn-outline-info" title="詳細">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('customers.edit', $customer) }}"
                                                       class="btn btn-sm btn-outline-warning" title="編集">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('customers.destroy', $customer) }}"
                                                          class="d-inline"
                                                          onsubmit="return confirm('本当に削除しますか？')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger"
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
                            <div class="text-muted">
                                {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} / {{ $customers->total() }}件
                            </div>
                            <div>
                                {{ $customers->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">顧客が見つかりません</h5>
                            @if($search)
                                <p class="text-muted">検索条件: {{ $search }}</p>
                                <a href="{{ route('customers.index') }}" class="btn btn-outline-primary">
                                    全ての顧客を表示
                                </a>
                            @else
                                <p class="text-muted">まだ顧客が登録されていません。</p>
                                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> 最初の顧客を登録
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection