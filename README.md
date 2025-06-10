# Working Management System

勤怠管理システム

## 環境構築

### 必要なソフトウェア
- Docker Desktop
- Git

### 使用技術
- PHP 8.3
- Laravel 11.x
- MySQL 8.3
- Nginx 1.25
- Redis 7.2
- Node.js 20.x

### セットアップ手順

1. **リポジトリのクローン**
```bash
git clone [リポジトリURL]
cd working-management
```

2. **Dockerコンテナの起動**
```bash
docker-compose up -d --build
```

3. **Laravelプロジェクトの作成**
```bash
docker-compose exec php bash

composer create-project laravel/laravel . "11.*"

cp .env.example .env
```

4. **.envファイルの設定**
```env
APP_NAME="Working Management"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

5. **アプリケーションキーの生成**
```bash
php artisan key:generate
```

6. **データベースマイグレーション**
```bash
php artisan migrate
```

7. **ストレージリンクの作成**
```bash
php artisan storage:link
```

8. **パーミッションの設定**
```bash
chmod -R 777 storage bootstrap/cache
```

### 開発環境URL
- アプリケーション: http://localhost
- phpMyAdmin: http://localhost:8080

### Dockerコマンド
```bash
docker-compose up -d

docker-compose down

docker-compose restart

docker-compose logs -f [サービス名]

docker-compose exec php bash

docker-compose exec mysql bash
```

### 開発時の注意事項
- Composerコマンドは必ずPHPコンテナ内で実行してください
- Artisanコマンドも同様にPHPコンテナ内で実行してください
- ファイルの権限に注意してください（特にstorage, bootstrap/cache）

### トラブルシューティング
1. **Permission denied エラー**
   - `docker-compose exec php chmod -R 777 storage bootstrap/cache`

2. **MySQL接続エラー**
   - .envファイルのDB_HOST=mysqlになっているか確認
   - コンテナが正常に起動しているか確認

3. **Composer installエラー**
   - PHPコンテナ内でrootユーザーとして実行: `docker-compose exec -u root php bash`
```

## 環境構築手順

### 1. プロジェクトディレクトリの作成
```bash
mkdir working-management
cd working-management
```

### 2. ディレクトリ構造の作成
```bash
mkdir -p docker/{nginx,php,mysql/data}
mkdir src
touch docker/mysql/data/.gitkeep
```

### 3. 各設定ファイルを作成
上記の内容を各ファイルにコピーしてください。

### 4. Dockerコンテナの起動
```bash
docker-compose up -d --build
```

### 5. Laravelのインストール
```bash
docker-compose exec php bash
composer create-project laravel/laravel . "11.*"
```

### 6. 環境設定
.envファイルを編集し、データベース接続情報を設定してください。

### 7. 初期設定
```bash
php artisan key:generate
php artisan migrate
php artisan storage:link