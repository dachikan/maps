// 呼び出し元のUserIdと記事Idと記事タイトルを取得する。

document.addEventListener('DOMContentLoaded', function() {
  chrome.runtime.sendMessage({ action: 'getTabInfo' }, (response) => {
    let url = new URL(response.url);
    let hostname = url.hostname;
    let pathSegments = url.pathname.split('/');
    let userId = '';
    let articleId = '';
    let siteName = "";

    // DOM要素の取得
    const mapLink = document.getElementById('MapLink');
    const articleListLink = document.getElementById('ArticleListLink');
    const legendText = document.getElementById('legendText');

    document.getElementById('sns').innerText = "SNS: " + hostname;

    if (hostname.includes('note.com')) { // note.comドメイン
      // ユーザID取得
      userId = pathSegments[1];
      
      // フォロー・フォロワーページの確認
      if (pathSegments.length >= 3 && (pathSegments[2] === 'followings' || pathSegments[2] === 'followers')) {
        document.getElementById('articleId').innerText = "ユーザID: " + userId;
        // ユーザページの場合は記事一覧表示ボタンを表示
        mapLink.style.display = 'none';
        articleListLink.style.display = 'inline-block';
        legendText.innerText = "ユーザの記事一覧を表示します";
        // 記事一覧表示へのリンクを設定
        articleListLink.href = `https://nsk.org/maps/noteArticleList.php?uId=${userId}&url=${encodeURIComponent(response.url)}`;
        document.getElementById('pageTitle').innerText = "note " + (pathSegments[2] === 'followings' ? "フォロー" : "フォロワー") + "ページ";
      } else if (pathSegments.length >= 4 && pathSegments[2] === 'n') { // 通常の記事ページ
        // 通常のnote記事モード
        // URLパターン: https://note.com/{UserId}/n/{ArticleId}
        articleId = pathSegments[3];
        document.getElementById('articleId').innerText = "記事ID: " + articleId;
        // マップリンクを表示、記事一覧は非表示
        mapLink.style.display = 'inline-block';
        articleListLink.style.display = 'none';
        legendText.innerText = "このnote記事と地図を連携します";
        
        // 仕様書に従って全パラメータを明示的に設定
        // 1. ユーザID
        // 2. 記事ID
        // 3. URL 
        // 4. タイトルとユーザ名はfetchで取得して後で追加
        let noteMapUrl = `https://nsk.org/maps/noteMap.php?uId=${userId}&aId=${articleId}&url=${encodeURIComponent(response.url)}`;
        mapLink.href = noteMapUrl;
        // 呼び出し元のページタイトルを取得
        fetch(response.url)
          .then(response => response.text())
          .then(html => {
            let doc = new DOMParser().parseFromString(html, 'text/html');
            let pageTitle = doc.querySelector('title').innerText;
            let titleParts = pageTitle.split('｜');
            let title = titleParts[0];
            let userName = titleParts.length > 1 ? titleParts[1] : '';

            document.getElementById('pageTitle').innerText = title;
            mapLink.href += "&title=" + encodeURIComponent(title);

            if (userName) {
              mapLink.href += "&userName=" + encodeURIComponent(userName);
            }
          })
          .catch(error => {
            console.error("Error fetching page title:", error);
            document.getElementById('pageTitle').innerText = "note記事";
          });
      } else {
        // その他のnoteページ（プロフィールページなど）
        document.getElementById('articleId').innerText = "ユーザID: " + userId;
        // ユーザページとして扱う
        mapLink.style.display = 'none';
        articleListLink.style.display = 'inline-block';
        legendText.innerText = "ユーザの記事一覧を表示します";
        // 記事一覧表示へのリンクを設定
        articleListLink.href = `https://nsk.org/maps/noteArticleList.php?userId=${userId}&url=${encodeURIComponent(response.url)}`;
        document.getElementById('pageTitle').innerText = "noteユーザページ";
      }

      siteName = "note";
    } else {
      // note.com以外の場合は機能を無効化
      mapLink.style.display = 'none';
      articleListLink.style.display = 'none';
      legendText.innerText = "非対応のサイトです";
      document.getElementById('pageTitle').innerText = "非対応";
      siteName = "不明サイト";
    }
  });
});