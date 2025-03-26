
noteMapWebページと呼ぶphpで書かれたWebページを作成しています。
このページはNoteMapDataテーブルの表示や修正を行います。
既存のプログラムを仕様書に基づいて修正して下さい。
多くの修正で動かなくなることがないよう、簡単な修正を少しずつお願いします。
第1ステップは記事Idのリンク先の修正です。
修正行がわかるようにお願いします。

# noteMap Webページ仕様書

## データベース接続パラメタ
* $host = "mysql213.phy.lolipop.lan";
* $dbname = "LAA1337491-nsk";
* $user = "LAA1337491";
* $pass = "kami2004";

## テーブル作成時のCreate文
CREATE TABLE `noteMapData` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `OrgUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `NewUrl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MapType` int(10) UNSIGNED DEFAULT NULL,
  `UserId` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserName` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ArticleId` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `PostCode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Addr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Building` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lat` double(15,8) DEFAULT NULL,
  `Lng` double(15,8) DEFAULT NULL,
  `Pname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MapData` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

## noteMapWebページを開いた場合の動作
* noteMapDataテーブルの内容を一覧形式で{id}の逆順で表示する
* "編集"ボタンをクリックすると各項目の編集画面を表示する
* "削除"ボタンをクリックすると該当レコードを削除する
* セキュリティ対策として、[データ削除]、[データ編集]は他人が押せないようにする

| 表示名  |項目名  |		表示内容         |
|--------|--------|--------------------|
|id 		 |id		  |{id}                |
|Title   |Title   |Titleリンク先詳細参照 |
|ユーザId |UserId  |{UserId}           |
|ユーザ名 |UserName |{UserName}        |
|メール	  |Mail	   |{Mail}              |
|記事Id	 |ArticleId|記事リンク先詳細参照  |
|〒		   |PostCode |{PostCode}          |
|住所		 |Addr     |{Addr}              |
|Type		 |MapType	|{Maptype}            |
|MapData |MapData	|{MapData}の先頭30文字||
|操作    |        |"編集"と"削除"ボタン   |

### Titleリンク先詳細
* 地図表示ページはhttps://nsk.org/maps/noteMapNew.html とする
* 標準パラメタは?lat={lat}&lng={lng}&title={title}とする
* Typeによって地図の意味や表示方法は以下のように異なる
* Type=1：地点を表示する
*  ```<a href="地図表示ページ?標準パラメタ">{Title}</a> ```
* Type=3：地点と追加情報を提供する
*  ```<a href="地図表示ページ?標準パラメタ&mapdata={MapData}">{Title}</a>```
* Type=9：記事所有者が独自の地図を提供する場合
*  ```<a href="{NewUrl}">{Title}</a>```
* Type=?：これから地図を作る場合
*  ```<a href="地図表示ページ?title={title}">{title}</a> ```
* Type=13：noteMapと無関係の場所を表示する
*  ```<a href="地図表示ページ?標準パラメタ">{Title}</a>```

### 記事リンク先詳細
* {ArticleId}が有効な場合：
* ```<a href="{OrgUrl}">{ArticleId}</a> ```

## noteMapDataテーブデータの修正
*  修正可能項目は表示項目と同じとする。
*  カーソルは先頭項目に位置付ける
*  "更新"ボタンをクリックすると、データを保存する
*  "キャンセル"ボタンをクリックすると、データを無視して一覧画面に戻る

| 表示名 |入力項目名|		横幅    |表示方法 |
|--------|---------|-----------|-------|
|id 		 |id		   |150px      |noteUrlの左に配置|
|noteUrl |OrgUrl    |max        |idの右に配置|
|記事Id	  |ArticleId|150px     |タイトルの左に配置|
|タイトル |Title    |max       |記事Idの右に配置|
|ユーザId |UserId   |150px     |ユーザ名の左に配置|
|ユーザ名 |UserName |300px     |ユーザIdの右に配置|
|メール	  |Mail     |400px     |ユーザ名の右に配置|
|〒		    |PostCode |150px     |住所の左に配置|
|住所		  |Addr     |500px      |Addrの右に配置  |
|建物名	  |Buileding |200px      |〒の右に配置  |
|Lat     |Lat       |150px      |Lngの左に配置|
|Lng     |Lng       |150px      |Latの右に配置|
|Type		 |MapType	  |40px       |Lngの左に配置|
|mapUrl  |NewUrl    |max,複数行 |       |
|MapData |MapData	  |max,複数行 |       |
|コメント |Pname     |max,複数行 |       |

# Markdown sample
https://marketplace.visualstudio.com/items?itemName=bierner.markdown-mermaid
```mermaid
graph TD;
    A-->B;
    A-->C;
    B-->D;
    C-->D;
```
```mermaid
graph LR
    fa:fa-check-->fa:fa-coffee
```