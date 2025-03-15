
noteMapと呼ぶChrome拡張アプリを作成しています。
このアプリは地図の表示またはnote記事一覧の表示を行います。
呼び出し元によって処理を変える以下の仕様を実現して下さい。
仕様書の間違いを訂正しています。
プログラムを修正し、修正行を教えてください。


**noteMap拡張アプリ仕様書**

## 呼び出し元に無関係な仕様
* 画面上の背景として表示：![alt text](mapIllust.png)
* 必要なファイル:manifest.json
*              :noteConnect.html
*              :js/popup.js
*              :js/background.js

## noteの記事画面から呼ばれた場合の仕様
* 呼び出し元    :https://note.com/{UserId}/n/{ArticleId}
* 画面上に表示  :"このnote記事と地図を連携します"
*              :記事タイトル
*              :記事Id：ArticleId
*              :ボタン("note地図連携")
* 呼び出し先    :https://nsk.org/maps/noteMap.php
* 呼び出し先へのパラメタ:
*              :ユーザId：UserId
*              :記事Id：ArticleId
*              :題名：Title(querySelectorで取得)
*              :ユーザ名：UserName(Title"|"以降の文字列)
*              :url     :呼び出し元のurl

## noteのフォロー画面などから呼ばれた場合の仕様
* 呼び出し元
*   :フォロー   :https://note.com/{UserId}/followings
*   :フォロワー :https://note.com/{UserId}/followers
* 画面上に表示  :"ユーザの記事一覧を表示します"
*              :ユーザId：UserId
*              :ボタン("記事一覧表示")
* 呼び出し先    :https://nsk.org/maps/noteArticleList.php
* 呼び出し先へのパラメタ:
*              :ユーザId：UserId
*              :url     :呼び出し元のurl

