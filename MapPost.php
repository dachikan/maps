﻿<?php
$servername = "mysql213.phy.lolipop.lan";
$username = "LAA1337491";
$password = "kami2004";
$dbname = "LAA1337491-nsk";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "接続失敗✖";
    die("Connection failed: " . $conn->connect_error);
//}else {
    //echo "接続成功🔴";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo "parameter設定";
    // お名前.com せきゅりて診断
    // 攻撃者が作成した任意のSQL 文をデータベース上で実行させられる可能性があります
    $mapType = $_POST['mapType'];
    $orgUrl = $_POST['orgUrl'];
    $uId = $_POST['uId'];
    $aId = $_POST['aId'];
    $title = $_POST['title'];
    $postcode = $_POST['postcode'];
    $address = $_POST['address'];
    $building = $_POST['building'];
    $lat0 = $_POST['lat_1'];
    $lng0 = $_POST['lng_1'];
    $pname = $_POST['pname'];
    if ($mapType == 3) {
        $routeData = [];
        for ($i = 1; $i <= 10; $i++) {
            $lat = $_POST["lat_$i"];
            $lng = $_POST["lng_$i"];
            if (is_null($lat)) break; // $latがnullだったらループを抜ける
            $comment = $_POST["comment_$i"];
            $routeData[] = ["lat" => $lat, "lng" => $lng, "comment" => $comment];
        }
        $mapdata = json_encode($routeData, JSON_UNESCAPED_UNICODE);
    } else {
        $mapdata = $_POST['mapdata'];
    }
    if ($_POST['new'] == 0)
    { // 更新のSQL文
        $sql = "UPDATE noteMapData
            SET MapData='$mapdata' WHERE ArticleId='$aId'";
    } else {
        $sql = "INSERT INTO noteMapData (MapType, OrgUrl, UserId, ArticleId, Title, PostCode, Addr, Building, Lat, Lng, Pname, MapData )
            VALUES ('$mapType','$orgUrl','$uId', '$aId', '$title', '$postcode', '$address', '$building', '$lat0', '$lng0', '$pname', '$mapdata')";
    }
    echo $sql;
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
        echo "<!DOCTYPE html>
        <html lang='ja'>
            <head>
                <meta charset='UTF-8'>
                <title>ウィンドウ表示</title>
                <style>
                body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f0f0; }
                .container { width: 350px; height: 450px; text-align: center; background-color: white; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
                .container img { max-width: 100%; max-height: 100%; }
                .container button { margin-top: 10px; padding: 5px 10px; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h3>地図情報を保存しました</h3>
                    <img src='img/mapIllust.png' alt='Illustration'> <br>
                    <p>今後は<img src='img/icon16.png' alt='Illustration'>クリックして地図を起動します。</p>
                    <button onclick='closeWindow()'>終了</button>
                </div>
                <script> function closeWindow() { window.close(); } </script>
            </body>
        </html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>