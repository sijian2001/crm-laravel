@extends('layouts.app')

@section('title', '製品登録 - CRM システム')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-plus"></i> 新規製品登録
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="row">
                            <!-- 製品名 -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">製品名 <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU/製品コード <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('sku') is-invalid @enderror"
                                       id="sku"
                                       name="sku"
                                       value="{{ old('sku') }}"
                                       required>
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- 価格 -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">価格（円） <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('price') is-invalid @enderror"
                                       id="price"
                                       name="price"
                                       value="{{ old('price') }}"
                                       min="0"
                                       step="0.01"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- カテゴリ -->
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">カテゴリ <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('category') is-invalid @enderror"
                                       id="category"
                                       name="category"
                                       value="{{ old('category') }}"
                                       placeholder="例: 電子機器、食品、衣類"
                                       required>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- 在庫数量 -->
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">在庫数量 <span class="text-danger">*</span></label>
                                <input type="number"
                                       class="form-control @error('stock_quantity') is-invalid @enderror"
                                       id="stock_quantity"
                                       name="stock_quantity"
                                       value="{{ old('stock_quantity', 0) }}"
                                       min="0"
                                       required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 画像URL -->
                            <div class="col-md-6 mb-3">
                                <label for="image_url" class="form-label">画像URL</label>
                                <input type="url"
                                       class="form-control @error('image_url') is-invalid @enderror"
                                       id="image_url"
                                       name="image_url"
                                       value="{{ old('image_url') }}"
                                       placeholder="https://example.com/image.jpg">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- 製品説明 -->
                        <div class="mb-3">
                            <label for="description" class="form-label">製品説明</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="製品の詳細説明を入力してください">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ステータス -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="status"
                                       name="status"
                                       value="1"
                                       {{ old('status', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">
                                    製品を有効にする
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                無効にすると、この製品は顧客に表示されません。
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 登録
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection