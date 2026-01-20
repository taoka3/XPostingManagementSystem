# X（旧Twitter）投稿ダッシュボード 仕様書

## 1. 概要

本システムは **Laravel 12** を用いて構築された、X（旧Twitter）への投稿を管理・実行するためのWebアプリケーションである。認証されたユーザーはダッシュボード画面から、テキスト投稿および画像付き投稿（最大4ファイル）を即時または予約して行うことができる。

X APIとの連携には **twitteroauth ライブラリ** を使用し、あらかじめ設定されたアクセストークンを用いて固定のアカウントへ投稿を行う。

---

## 2. 目的

- 管理画面からXへの投稿を簡単に行えるようにする
- 画像付き投稿（最大4枚）に対応する
- Laravel標準のユーザー認証により管理機能を保護する
- 予約投稿機能により、将来の特定の日時に自動投稿される仕組みを提供する

---

## 3. 使用技術

| 項目            | 内容                                   |
| :-------------- | :------------------------------------- |
| フレームワーク  | Laravel 12.0                           |
| 言語            | PHP 8.2以上                            |
| フロントエンド  | Blade + CSS (Tailwind CSS 等)          |
| 外部API         | X API v2 (メディアアップロードは v1.1) |
| APIクライアント | abraham/twitteroauth                   |
| 認証            | Laravel標準認証 (Email/Password)       |
| ストレージ      | Local Storage (publicディスク)         |
| データベース    | SQLite / MySQL 等                      |

---

## 4. 機能一覧

### 4.1 認証

- **ログイン/ログアウト**: 標準的なメールアドレスとパスワードによる認証。
- **アクセス制御**: `auth` ミドルウェアにより、未認証ユーザーのダッシュボードアクセスを制限。

### 4.2 投稿機能

- **テキスト投稿**: 最大280文字（Xの制限に準拠）。
- **画像投稿**: 最大4枚までの複数画像アップロードに対応。
  - 対応形式: jpg, jpeg, png, webp
  - サイズ制限: 1ファイル最大5MB
- **即時投稿**: 保存後、直ちにキュー（Job）に投入され投稿される。

### 4.3 予約投稿

- **日時指定**: `datetime-local` による詳細な時間指定が可能。
- **スケジュール実行**: Laravel Scheduler が毎分起動し、指定時刻を過ぎた投稿を順次実行。
- **予約管理**: 予約中の投稿一覧表示およびキャンセルの削除機能。

---

## 5. 画面仕様

### 5.1 ログイン画面 (`/login`)

- 管理者ログインフォーム。

### 5.2 投稿作成画面 (`/dashboard/x-post`)

- 投稿テキスト入力エリア。
- 画像ドラッグ＆ドロップ/ファイル選択（最大4枚）。
- 予約日時指定フィールド。
- 投稿ボタン。

### 5.3 予約投稿一覧 (`/dashboard/x-post/scheduled`)

- 予約中（ステータスが `scheduled`）の投稿を一覧表示。
- 投稿内容、画像プレビュー、予定日時の確認。
- 削除ボタンによる予約の取り消し。

---

## 6. API・認証仕様

### 6.1 X API 設定 (`.env`)

事前に X Developer Portal で取得した固定トークンを使用する。

```env
X_API_KEY=your_api_key
X_API_SECRET=your_api_secret
X_ACCESS_TOKEN=your_access_token
X_ACCESS_TOKEN_SECRET=your_access_token_secret
```

### 6.2 認証方式

- **OAuth認可フローは使用しない**: ユーザーごとの連携画面は実装せず、環境変数に設定された単一アカウントにのみ投稿する方式。

---

## 7. システム構成と処理フロー

### 7.1 即時投稿フロー

1. ユーザーがダッシュボードから投稿内容を送信。
2. コントローラーでバリデーションおよび画像の永続化 (Storage保存)。
3. `PostToXJob` をディスパッチ。
4. Queue Worker が Job を取得し、X APIへリクエストを送信。
5. 成功時に DB のステータスを `posted` に更新。

### 7.2 予約投稿フロー

1. ユーザーが予約日時を指定して投稿内容を送信。
2. DB に `status = 'scheduled'` で保存。
3. `x:dispatch-scheduled-posts` コマンドが 1分ごとに実行される。
4. 現在時刻を過ぎた `scheduled` 投稿を抽出し、`PostToXJob` をそれぞれディスパッチ。
5. 以降は即時投稿と同様の Job 処理。

---

## 8. データベース設計

### `x_posts` テーブル

| カラム          | 説明                                    |
| :-------------- | :-------------------------------------- |
| `content`       | 投稿テキスト                            |
| `images`        | 画像パスのJSON形式リスト                |
| `scheduled_at`  | 投稿予定日時 (即時投稿は null)          |
| `status`        | `scheduled`, `posted`, `failed`         |
| `error_message` | 投稿失敗時のAPIエラーメッセージ等を記録 |

---

## 9. セットアップコマンド

```bash
# インストール
composer install
npm install && npm run build

# 環境構築
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link

```

---

## 10. スケジューラの設定 (cron等)

予約投稿を機能させるため、サーバーの cron に以下を追加する必要がある。

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

---
