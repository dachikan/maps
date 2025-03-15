<?php
$userId = 'n0980cd9a449c';
$url = "https://editor.note.com/notes/{$userId}/edit/";

// cURL初期化
$ch = curl_init();
// オプション設定
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 実行して結果を取得
$response = curl_exec($ch);
// エラーチェック
if (curl_errno($ch)) {
  echo 'cURL error: ' . curl_error($ch);
}
curl_close($ch);
// 取得したデータを解析
$articles = json_decode($response, true)['articles'];
if ($articles) {
  foreach ($articles as $article) {
    echo "Title: " . $article['title'] . "\n";
    echo "URL: " . $article['url'] . "\n";
  }
} else {
  echo "Error: Could not retrieve articles.";
}
?>
