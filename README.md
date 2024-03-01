# タスク管理アプリ

## 環境構築手順

1. リポジトリをクローン
任意のディレクトリで以下コマンドを実行
```
$ git clone git@github.com:yu7a21/todo-app.git
```
2. コンテナビルド&起動
```
$ cd todo-app
$ docker-compose up
```
3. マイグレーション実行
```
$ docker-compose exec app bash
$ php artisan migrate
```
4. ページにアクセス
http://localhost:20080 でアプリを利用できる
