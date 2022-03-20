# Othello on Laravel with DDD

[![LaravelTest](https://github.com/ebinase/othello/actions/workflows/laravel.yml/badge.svg)](https://github.com/ebinase/othello/actions/workflows/laravel.yml)
![Issues](https://img.shields.io/github/issues/ebinase/othello)


<img src="https://3.bp.blogspot.com/-hRiScUsWZHk/VA7mVasETMI/AAAAAAAAmOg/OHTyO2Zjxck/s800/othello_game.png" width="20%">

## :bookmark: 概要
オセロゲームをドメイン駆動設計を中心に作成してみる。

## :rocket: ステータス

| タイプ     | ステータス     |
| ---      | ---       |
| ページ公開 | 公開中 |
| 開発 | バックエンドの主要機能は開発済み。今後はReactによるフロント開発 + バックエンドAPI開発へ |


## :wrench: 技術要件
### 本番
* PHP 8.1
* Laravel 9

### 開発環境
* doocker

## :computer: インストール
### 開発環境
Laravel公式の開発ツール、[Laravel Sail](https://readouble.com/laravel/8.x/ja/sail.html)を使用します。

#### クローン

```shell
# HTTPの場合
$ git clone https://github.com/ebinase/othello.git
```

#### パッケージインストール
コンテナを使用するため、ローカル環境のPHPやインストールツールは不要です。

```shell
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

#### コンテナの起動
sailコマンドで起動

```shell
$ ./vendor/bin/sail up
$ ./vendor/bin/sail up -d # バックグラウンド実行する場合
```

#### .envファイルセットアップ

```shell
# 本番用ファイル作成
$ cp .env.example .env

# アプリケーションキー発行
$ ./vendor/bin/sail artisan key:generate
```

#### 開発サーバへのアクセス
http://0.0.0.0:80 にアクセスすることで動作確認できます。

アクセスできない場合はコンテナ起動時のメッセージを参照してください！

> Starting Laravel development server: http://0.0.0.0:80

#### コンテナの終了

`ctrl` + `c`

```
# バックグラウンド実行をしていた場合
$ ./vendor/bin/sail stop
```


## :books: 技術等(予定)
### バックエンド
* PHP + Laravel

### フロントエンド
* TypeScript
* React.js or Vue.js

### インフラ
* AWS
* Docker

### 設計・プロジェクト管理
* ドメイン駆動設計
* issues, projects(GitHub)

### その他トピック
* TDD
* CI/CD(Github Actions)
