<?php
header("Content-Type: text/html; charset=utf-8");
header("Content-Security-Policy: script-src 'self'; frame-ancestors 'self';"); // 修正: 'unsafe-eval' 削除
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header_remove("X-Powered-By");
header_remove("X-XSS-Protection");

$host = "mysql213.phy.lolipop.lan";
$dbname = "LAA1337491-nsk";
$user = "LAA1337491";
$pass = "kami2004";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // レコード削除処理
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $deleteSQL = "DELETE FROM areas WHERE id = :id";
        $stmt = $pdo->prepare($deleteSQL);
        $stmt->execute(['id' => $delete_id]);
    }

    $SQL = "SELECT * FROM areas";
    $stmt = $pdo->prepare($SQL);
    $stmt->execute();
    $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>地図一覧</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
    <script src="script.js"></script> <!-- 修正: 外部JavaScriptファイルを読み込む -->
</head>
<body>
    <h1>地図一覧</h1>
    <form id="delete_form" method="post">
        <input type="hidden" name="delete_id" id="delete_id">
    </form>
    <table>
        <tr>
            <th>id</th>
            <th>Title</th>
            <th>ユーザId</th>
            <th>ユーザ名</th>
            <th>メール</th>
            <th>記事Id</th>
            <th>〒</th>
            <th>住所</th>
            <th>Type</th>
            <th>MapData</th>
        </tr>
        <?php foreach ($areas as $area): 
            $titleLink = '';
            if ($area['MapType'] == 13) {
                $titleLink = '<a href="noteMapNew.html?lat=' . htmlspecialchars($area['Lat']) . '&lng=' . htmlspecialchars($area['Lng']) . '">' . htmlspecialchars($area['Title']) . '</a>';
            } elseif ($area['MapType'] == 9) {
                $titleLink = '<a href="' . htmlspecialchars($area['NewUrl']) . '">' . htmlspecialchars($area['Title']) . '</a>';
            } elseif ($area['MapType'] == 1) {
                $titleLink = '<a href="noteMapNew.html?lat=' . htmlspecialchars($area['Lat']) . '&lng=' . htmlspecialchars($area['Lng']) . '">' . htmlspecialchars($area['Title']) . '</a>';
            } elseif ($area['MapType'] == 3) {
                $titleLink = '<a href="noteMapNew.html?lat=' . htmlspecialchars($area['Lat']) . '&lng=' . htmlspecialchars($area['Lng']) . '&mapData=' . htmlspecialchars($area['MapData']) . '">' . htmlspecialchars($area['Title']) . '</a>';
            } else {
                $titleLink = htmlspecialchars($area['Title']);
            }
        ?>
            <tr>
                <td><?php echo htmlspecialchars($area['id']); ?> <button type="button" onclick="deleteRecord(<?php echo $area['id']; ?>)">🗑</button></td>
                <td><?php echo $titleLink; ?></td>
                <td><?php echo htmlspecialchars($area['UserId']); ?></td>
                <td><?php echo htmlspecialchars($area['UserName']); ?></td>
                <td><?php echo htmlspecialchars($area['Mail']); ?></td>
                <td><?php echo htmlspecialchars($area['ArticleId']); ?></td>
                <td><?php echo htmlspecialchars($area['Postcode']); ?></td>
                <td><?php echo htmlspecialchars($area['Address']); ?></td>
                <td><?php echo htmlspecialchars($area['MapType']); ?></td>
                <td><?php echo htmlspecialchars(mb_substr($area['MapData'], 0, 20)); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
