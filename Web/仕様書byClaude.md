﻿# NoteMap Web Application

## 概要
このWebアプリケーションは、NoteMapDataテーブルのデータを管理するためのシステムです。主な機能は以下の通りです：

- データの一覧表示
- データの編集
- データの削除
- ユーザ認証

## ファイル構成
- `db_connection.php`: データベース接続設定
- `noteMapWeb_Claude.php`: データ一覧ページ
- `edit.php`: データ編集ページ
- `delete.php`: データ削除ページ
- `login.php`: ログインページ
- `styles.css`: アプリケーションのスタイルシート

## セキュリティ要件
- ユーザは自分のデータのみ編集・削除可能
- ログインには既存のNoteMapDataのユーザIDとメールアドレスを使用

## データベース接続
データベース接続は`db_connection.php`で管理されています。以下の定数を環境に合わせて調整してください：
- `DB_HOST`: データベースホスト
- `DB_NAME`: データベース名
- `DB_USER`: データベースユーザ
- `DB_PASS`: データベースパスワード

## 認証方法
現在の実装では、NoteMapDataテーブルのユーザIDとメールアドレスを使用してログインします。本番環境では、別途ユーザ管理テーブルの導入を推奨します。

## 注意点
- このアプリケーションは最小限の認証を実装しています
- 本番環境では、より強力な認証メカニズムが必要です
- パスワードのハッシュ化、CSRF対策、入力検証などを追加してください

## 必要な環境
- PHP 7.4以上
- MySQL 5.7以上
- PDOエクステンション

## セットアップ手順
1. データベース接続情報を確認・更新
2. PHPサーバにファイルをア