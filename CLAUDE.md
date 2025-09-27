# CLAUDE.md

このファイルは、このリポジトリで作業する際にClaude Code (claude.ai/code) にガイダンスを提供します。

## プロジェクト概要

PHP 7.3.11で書かれたLaravel 8.0ベースの顧客関係管理（CRM）システムです。Bootstrap 5フロントエンドを使用して、顧客、製品、店舗、店員の管理を行います。

## 主要機能

- **顧客管理**: 登録、編集、削除、検索、ページネーション機能
- **製品管理**: カテゴリ別管理と在庫管理を含む製品CRUD操作
- **店舗管理**: 営業状況追跡を含む店舗運営管理
- **店員管理**: 役職と給与管理を含む従業員管理
- **認証機能**: セッション管理を含むログイン/ログアウト機能

## 開発コマンド

### バックエンド（Laravel）
```bash
# PHP依存関係のインストール
composer install

# 開発サーバーの起動
php artisan serve

# データベースマイグレーションの実行
php artisan migrate

# アプリケーションキーの生成
php artisan key:generate

# アプリケーションキャッシュのクリア
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 新しいマイグレーションの作成
php artisan make:migration create_table_name

# 新しいコントローラーの作成
php artisan make:controller ControllerName

# 新しいモデルの作成
php artisan make:model ModelName
```

### フロントエンド（Laravel Mix）
```bash
# Node.js依存関係のインストール
npm install

# 開発用アセットのビルド
npm run dev

# 変更監視付きビルド
npm run watch

# 本番用ビルド
npm run prod
```

### テスト
```bash
# 全テストの実行
php artisan test
# または
./vendor/bin/phpunit

# 特定のテストスイートの実行
./vendor/bin/phpunit tests/Unit
./vendor/bin/phpunit tests/Feature
```

## データベース設定

アプリケーションは以下のデフォルト設定でMySQLを使用します：
- ホスト: localhost
- ポート: 3306
- データベース: crm4
- ユーザー名: crm4user
- パスワード: 1234

データベース設定は`.env`ファイルと`config/database.php`にあります。

## アーキテクチャ

### ディレクトリ構造
- `app/` - アプリケーションロジック（Models、Controllers、Middleware）
- `database/migrations/` - データベーススキーマ定義
- `resources/views/` - Bladeテンプレート
- `routes/web.php` - Webルート定義
- `public/` - Webサーバードキュメントルート
- `config/` - 設定ファイル

### 主要コンポーネント
- **Models**: `app/Models/`に配置（現在はUserモデルのみ存在）
- **Controllers**: `app/Http/Controllers/`内（現在はベースControllerのみ）
- **Middleware**: `app/Http/Middleware/`内の認証とリクエスト処理
- **Views**: `resources/views/`内のBladeテンプレート（現在はwelcomeページのみ）

アプリケーションは、データベース操作にEloquent ORMを使用した標準的なLaravel MVCアーキテクチャに従っています。