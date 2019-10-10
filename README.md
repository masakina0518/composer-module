# tomopay-common

TOMOPAY関連アプリ共通モジュール

## 利用ターゲット

当モジュールは以下のプロジェクトで利用可能とする。

- tomopay-admin
- tomopay-authorization
- tomopay-batch


## インストール

### 1.Github Access Tokenの取得

当リポジトリはPrivateのため、composer実行時にgithub認証を必要とする。  
Parsonal access tokensを発行してcomposerに登録しておく必要する。

#### A.Github Access Token発行

https://github.com/settings/developers

```
Personal access tokens > Generate new token > Select scopesのrepoにチェック > 生成されたTokenをコピー
```

#### B.ComposerにGithub Access Tokenを登録

各プロジェクトルートで以下のコマンドを実行する。  
プロジェクトルートにtokenが記載された`auth.json`が出力される。

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


### 2.各プロジェクトのComposer.jsonへ依存モジュールとして定義する

composerを利用してinstallするため依存モジュールとして定義する。

composer.json
```
{
    "require": {
       "datasection/tomopay-common": "1.0.*"
    }
    
    ...
    
    "repositories": {
       "datasection": {
          "type": "vcs",
          "url": "https://github.com/datasection/tomopay-common.git"
       }
    }   
}
```

### 3.Composer installを実行する

各プロジェクトルートでcomposer installを実施する。

```
$ composer install
```

## composerによるtomopay-commonのバージョン管理について

### 本番環境

本番環境では基本`git tag`のバージョンを設定・リリースされたモジュールをインストール・利用する。  

composerは`composer.json`の`version`と`git tag`名に設定するバージョンで管理を行う。  
バージョンのつけ方については`セマンティックバージョニング`の規約を踏襲する。

> 注意：`composer.json`の`version`と`git tag`名に設定するバージョンは一致している必要がある。  
> ※合わせないと制約エラーでインストールが失敗する
```
The requested package datasection/tomopay-common 1.1.0 exists as datasection/tomopay-common[1.0.0] but these are rejected by your constraint.
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

composerでは`git tag`の他に`ブランチ名`でのインストールも可能。

composer.jsonでrequreするバージョンを`[ブランチ名]-dev`と記述すると、指定ブランチの最新コミットが取得できる。

```
{
    "require": {
       "datasection/tomopay-common": "feature/***-dev"
    }
```

リリース時は作業ブランチをmasterへマージ・正式リリースとするために`git tag`を設定する


## Unit testについて

Unit testは`PHPunit`を利用する。  
composerから`PHPunit`を実行できるよう`composer.json`に定義しているため以下のように実行する。

```
composer test tests
```
