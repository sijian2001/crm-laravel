@extends('layouts.app')

@section('title', '店舗編集 - CRM システム')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> 店舗編集: {{ $store->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('stores.update', $store) }}">
                        @csrf
                        @method('PUT')

                        <!-- 店舗名 -->
                        <div class="mb-3">
                            <label for="name" class="form-label">店舗名 <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $store->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 住所 -->
                        <div class="mb-3">
                            <label for="address" class="form-label">住所 <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="3"
                                      required>{{ old('address', $store->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- 電話番号 -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">電話番号</label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $store->phone) }}"
                                       placeholder="03-1234-5678">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- メールアドレス -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">メールアドレス</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $store->email) }}"
                                       placeholder="store@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- 営業時間 -->
                            <div class="col-md-6 mb-3">
                                <label for="opening_hours" class="form-label">営業時間</label>
                                <textarea class="form-control @error('opening_hours') is-invalid @enderror"
                                          id="opening_hours"
                                          name="opening_hours"
                                          rows="3"
                                          placeholder="平日: 9:00-18:00&#10;土日: 10:00-17:00">{{ old('opening_hours', $store->opening_hours) }}</textarea>
                                @error('opening_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 定休日 -->
                            <div class="col-md-6 mb-3">
                                <label for="closed_days" class="form-label">定休日</label>
                                <input type="text"
                                       class="form-control @error('closed_days') is-invalid @enderror"
                                       id="closed_days"
                                       name="closed_days"
                                       value="{{ old('closed_days', $store->closed_days) }}"
                                       placeholder="毎週水曜日、第3日曜日">
                                @error('closed_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- 営業状況 -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">営業状況 <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="">選択してください</option>
                                    <option value="preparing" {{ old('status', $store->status) == 'preparing' ? 'selected' : '' }}>準備中</option>
                                    <option value="open" {{ old('status', $store->status) == 'open' ? 'selected' : '' }}>営業中</option>
                                    <option value="closed" {{ old('status', $store->status) == 'closed' ? 'selected' : '' }}>休業中</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 店舗責任者 -->
                            <div class="col-md-6 mb-3">
                                <label for="manager_name" class="form-label">店舗責任者</label>
                                <input type="text"
                                       class="form-control @error('manager_name') is-invalid @enderror"
                                       id="manager_name"
                                       name="manager_name"
                                       value="{{ old('manager_name', $store->manager_name) }}"
                                       placeholder="田中 太郎">
                                @error('manager_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- 開店日 -->
                        <div class="mb-3">
                            <label for="opening_date" class="form-label">開店日</label>
                            <input type="date"
                                   class="form-control @error('opening_date') is-invalid @enderror"
                                   id="opening_date"
                                   name="opening_date"
                                   value="{{ old('opening_date', $store->opening_date ? $store->opening_date->format('Y-m-d') : '') }}">
                            @error('opening_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 備考 -->
                        <div class="mb-3">
                            <label for="description" class="form-label">備考・説明</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="店舗の特徴や備考事項を入力してください">{{ old('description', $store->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('stores.show', $store) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection