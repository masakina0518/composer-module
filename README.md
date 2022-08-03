# composer-module

ParentAPP 関連アプリ共通モジュール

## 利用ターゲット

当モジュールは以下のプロジェクトで利用可能とする。

-   parent-app
-   parent-batch

## インストール

### 1.Github Access Token の取得

当リポジトリは Private のため、composer 実行時に github 認証を必要とする。  
Parsonal access tokens を発行して composer に登録しておく必要する。

#### A.Github Access Token 発行

https://github.com/settings/developers

```
Personal access tokens > Generate new token > Select scopesのrepoにチェック > 生成されたTokenをコピー
```

#### B.Composer に Github Access Token を登録

各プロジェクトルートで以下のコマンドを実行する。  
プロジェクトルートに token が記載された`auth.json`が出力される。

```
composer config github-oauth.github.com <access token>
```

auth.json

```
{
    "github-oauth": {
        "github.com": "<access token>"
    }
}
```

※`composer config -g`でグローバルに鍵を登録することも可能です。

**補足：一覧・削除について**

削除

```
composer config --unset github-oauth.github.com
```

※グローバル登録した場合は`composer config -g`で実行

一覧

```
composer config github-oauth
```

※グローバル登録した場合は`composer config -g`で実行

### 2.各プロジェクトの Composer.json へ依存モジュールとして定義する

composer を利用して install するため依存モジュールとして定義する。

composer.json

```
{
    "require": {
       "＜アカウント＞/composer-module": "1.0.*"
    }

    ...

    "repositories": {
       "＜アカウント＞": {
          "type": "vcs",
          "url": "https://github.com/<アカウント>/composer-module.git"
       }
    }
}
```

### 3.Composer install を実行する

各プロジェクトルートで composer install を実施する。

```
$ composer install
```

## composer による composer-module のバージョン管理について

### 本番環境

本番環境では基本`git tag`のバージョンを設定・リリースされたモジュールをインストール・利用する。

composer は`composer.json`の`version`と`git tag`名に設定するバージョンで管理を行う。  
バージョンのつけ方については`セマンティックバージョニング`の規約を踏襲する。

> 注意：`composer.json`の`version`と`git tag`名に設定するバージョンは一致している必要がある。  
> ※合わせないと制約エラーでインストールが失敗する

```
The requested package ＜アカウント＞/composer-module 1.1.0 exists as ＜アカウント＞/composer-module[1.0.0] but these are rejected by your constraint.
```

`git tag`が`v1.0`の場合

```
{
　...
  "version": "1.0.0",
　...
}
```

`git tag`が`v1.0.1`の場合

```
{
　...
  "version": "1.0.1",
　...
}
```

### ローカル環境

composer では`git tag`の他に`ブランチ名`でのインストールも可能。

composer.json で requre するバージョンを`[ブランチ名]-dev`と記述すると、指定ブランチの最新コミットが取得できる。

```
{
    "require": {
       "＜アカウント＞/composer-module": "feature/***-dev"
    }
```

リリース時は作業ブランチを master へマージ・正式リリースとするために`git tag`を設定する

## Unit test について

Unit test は`PHPunit`を利用する。  
composer から`PHPunit`を実行できるよう`composer.json`に定義しているため以下のように実行する。

```
composer test tests
```
