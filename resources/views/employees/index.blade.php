@extends('layouts.app')

@section('title', '店員一覧 - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- ヘッダー -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-users"></i> 店員一覧</h2>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> 新規店員登録
                </a>
            </div>

            <!-- 検索フォーム -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('employees.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">検索</label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ $search }}"
                                   placeholder="名前・かな・メール・部署">
                        </div>
                        <div class="col-md-3">
                            <label for="store_id" class="form-label">店舗</label>
                            <select class="form-select" id="store_id" name="store_id">
                                <option value="">全店舗</option>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}" {{ $store_id == $store->id ? 'selected' : '' }}>
                                        {{ $store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="position" class="form-label">役職</label>
                            <select class="form-select" id="position" name="position">
                                <option value="">全役職</option>
                                @foreach($positions as $key => $value)
                                    <option value="{{ $key }}" {{ $position == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">状況</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">全状況</option>
                                @foreach($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search"></i> 検索
                            </button>
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> リセット
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 店員一覧 -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">店員一覧 ({{ $employees->total() }}件)</h5>
                </div>
                <div class="card-body p-0">
                    @if($employees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>氏名</th>
                                        <th>役職</th>
                                        <th>店舗</th>
                                        <th>雇用形態</th>
                                        <th>状況</th>
                                        <th>入社日</th>
                                        <th>メール</th>
                                        <th class="text-center">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $employee->full_name }}</strong>
                                                </div>
                                                <small class="text-muted">{{ $employee->full_name_kana }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $employee->position_display }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('stores.show', $employee->store) }}" class="text-decoration-none">
                                                    {{ $employee->store->name }}
                                                </a>
                                            </td>
                                            <td>{{ $employee->employment_type_display }}</td>
                                            <td>
                                                <span class="badge {{ $employee->status_badge_class }}">
                                                    {{ $employee->status_display }}
                                                </span>
                                            </td>
                                            <td>{{ $employee->formatted_hire_date }}</td>
                                            <td>
                                                @if($employee->email)
                                                    <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                                @else
                                                    <span class="text-muted">未設定</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('employees.show', $employee) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="詳細">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('employees.edit', $employee) }}"
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="編集">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('employees.destroy', $employee) }}"
                                                          class="d-inline"
                                                          onsubmit="return confirm('本当に削除しますか？この操作は取り消せません。')">
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
                        @if($employees->hasPages())
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        {{ $employees->firstItem() }}件目から{{ $employees->lastItem() }}件目まで表示
                                        (全{{ $employees->total() }}件中)
                                    </div>
                                    {{ $employees->withQueryString()->links() }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">店員が見つかりません</h5>
                            <p class="text-muted">
                                @if($search || $store_id || $position || $status)
                                    検索条件を変更して再度お試しください。
                                @else
                                    新規店員を登録してください。
                                @endif
                            </p>
                            @if(!$search && !$store_id && !$position && !$status)
                                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> 新規店員登録
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