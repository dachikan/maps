<?php
header("Content-Type: text/html; charset=utf-8");
header("Content-Security-Policy: script-src 'self' 'unsafe-eval'; frame-ancestors 'self';");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header_remove("X-Powered-By");
header_remove("X-XSS-Protection");

$url = $_GET['url'];
$uId = $_GET['uId'];
$aId = $_GET['aId'];
$title = $_GET['title'];
$param = "url=".$url."&aId=".$aId."&uId=".$uId."&title=".$title;

$host = "mysql213.phy.lolipop.lan";
$dbname = "LAA1337491-nsk";
$user = "LAA1337491";
$pass = "kami2004";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $SQL = "SELECT * FROM areas WHERE ArticleId = :articleId";
    $stmt = $pdo->prepare($SQL);
    $stmt->execute(['articleId' => $aId]);
    $area = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($area) {
        $mapType = $area['MapType'];
        $lat = $area['Lat'];
        $lng = $area['Lng'];
        $newUrl = $area['NewUrl'];
        $oldUrl = $area['OldUrl'];
        $articleId = $area['ArticleId'];
        $userId = $area['UserId'];

        if ($mapType == 1) {
            header("Location: noteMapType1.html?"."lat=".$lat."&lng=".$lng."&".$param);
            exit();
        } elseif ($mapType == 2) {
            header("Location: noteMapType2.html?".$param);
            exit();
        } elseif ($mapType == 3) {
            header("Location: noteMapType3.html?".$param);
            exit();
        } elseif ($mapType == 9) {
            header("Location: $newUrl");
            exit();
        } else {
            echo "URL: " . htmlspecialchars($mapType) . "<br>";
            echo "SQL:".htmlspecialchars($SQL). "<br>";
            echo "Invalid MapType.";
        }
    } else {
        header("Location: noteMapType0.html?".$param);
        echo "URL: " . htmlspecialchars($url) . "<br>";
        //$sql = "SELECT * FROM areas WHERE ArticleId = '$aId'";
        echo "SQL:".htmlspecialchars($SQL). "<br>";
        echo "No record found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
