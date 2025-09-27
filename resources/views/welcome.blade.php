@extends('layouts.app')

@section('title', 'ホーム - CRM システム')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-primary text-white text-center py-5 mb-4 rounded">
                <h1 class="display-4">CRMシステムへようこそ</h1>
                <p class="lead">顧客、製品、店舗、店員の管理を統合的に行えるWebアプリケーションです。</p>
                @guest
                    <a class="btn btn-light btn-lg" href="{{ route('login') }}" role="button">ログインして開始</a>
                @endguest
            </div>
        </div>
    </div>

    @auth
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">顧客管理</h5>
                        <p class="card-text">顧客情報の登録・編集・削除・検索機能</p>
                        <a href="#" class="btn btn-primary">管理画面へ</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-3x text-success mb-3"></i>
                        <h5 class="card-title">製品管理</h5>
                        <p class="card-text">製品・カテゴリ・在庫の管理機能</p>
                        <a href="#" class="btn btn-success">管理画面へ</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-store fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">店舗管理</h5>
                        <p class="card-text">店舗情報と営業状況の管理機能</p>
                        <a href="#" class="btn btn-warning">管理画面へ</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tie fa-3x text-info mb-3"></i>
                        <h5 class="card-title">店員管理</h5>
                        <p class="card-text">従業員情報と役職・給与の管理機能</p>
                        <a href="#" class="btn btn-info">管理画面へ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">システム情報</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Laravel バージョン:</strong> {{ Illuminate\Foundation\Application::VERSION }}</p>
                                <p><strong>ログインユーザー:</strong> {{ Auth::user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>最終ログイン:</strong> {{ Auth::user()->updated_at->format('Y年m月d日 H:i') }}</p>
                                <p><strong>システム状態:</strong> <span class="badge bg-success">正常稼働中</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">システム機能</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6>✅ 顧客管理</h6>
                                <p class="text-muted small">顧客登録・編集・削除・検索・ページネーション対応</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>✅ 製品管理</h6>
                                <p class="text-muted small">カテゴリ別製品管理・在庫状況管理・価格表示機能</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>✅ 店舗管理</h6>
                                <p class="text-muted small">営業状況管理・店舗詳細情報表示・営業年数自動計算</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h6>✅ 店員管理</h6>
                                <p class="text-muted small">役職・部署管理・勤続年数自動計算・給与情報管理</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
@endsection
