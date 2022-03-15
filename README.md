# Othello on Laravel with DDD

[![LaravelTest](https://github.com/ebinase/othello/actions/workflows/laravel.yml/badge.svg)](https://github.com/ebinase/othello/actions/workflows/laravel.yml)
![Issues](https://img.shields.io/github/issues/ebinase/othello)


<img src="https://3.bp.blogspot.com/-hRiScUsWZHk/VA7mVasETMI/AAAAAAAAmOg/OHTyO2Zjxck/s800/othello_game.png" width="20%">

## :bookmark: 概要
オセロゲームをドメイン駆動設計を中心に作成してみる。

## :rocket: ステータス

| タイプ     | ステータス     |
| ---      | ---       |
| ページ公開 | :new: IP制限状態で公開中 |
| 開発 | バックエンドの主要機能は開発済み。今後はReactによるフロント開発 + バックエンドAPI開発へ |


## :wrench: 技術要件
* php8.0以上
* composer
* doocker

## :computer: インストール
### 開発環境
Composerインストール

```composer install --dev```

.env作成

```cp .env.example .env```

Laravel sail実行(コンテナ起動)

```./vendor/bin/sail up -d```


アプリケーションキー発行

```./vendor/bin/sail artisan key:generate```

## :books: 技術等(予定)
### バックエンド
* php + Laravel

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
