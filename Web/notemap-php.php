<?php
// データベース接続パラメータ
$host = "mysql213.phy.lolipop.lan";
$dbname = "LAA1337491-nsk";
$user = "LAA1337491";
$pass = "kami2004";
// データベース接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続エラー: " . $e->getMessage());
}

// レコード削除処理
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
	$stmt = $pdo->prepare("DELETE FROM noteMapData WHERE id = :id");
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	header("Location: " . $_SERVER['PHP_SELF']);
	exit;
    } catch (PDOException $e) {
	echo "削除エラー: " . $e->getMessage();
    }
}

// レコード更新処理
if (isset($_POST['update']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $orgUrl = $_POST['OrgUrl'];
    $newUrl = $_POST['NewUrl'];
    $mapType = $_POST['MapType'];
    $userId = $_POST['UserId'];
    $userName = $_POST['UserName'];
    $mail = $_POST['Mail'];
    $articleId = $_POST['ArticleId'];
    $title = $_POST['Title'];
    $postCode = $_POST['PostCode'];
    $addr = $_POST['Addr'];
    $building = $_POST['Building'];
    $lat = $_POST['Lat'];
    $lng = $_POST['Lng'];
    $pname = $_POST['Pname'];
    $mapData = $_POST['MapData'];

    try {
	$stmt = $pdo->prepare("UPDATE noteMapData SET 
		OrgUrl = :orgUrl, NewUrl = :newUrl, MapType = :mapType, 
		UserId = :userId, UserName = :userName, Mail = :mail, 
		ArticleId = :articleId, Title = :title, PostCode = :postCode, 
		Addr = :addr, Building = :building, Lat = :lat, Lng = :lng, 
		Pname = :pname, MapData = :mapData, updated_at = NOW() 
		WHERE id = :id");

	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':orgUrl', $orgUrl, PDO::PARAM_STR);
	$stmt->bindParam(':newUrl', $newUrl, PDO::PARAM_STR);
	$stmt->bindParam(':mapType', $mapType, PDO::PARAM_INT);
	$stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
	$stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
	$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':articleId', $articleId, PDO::PARAM_STR);
	$stmt->bindParam(':title', $title, PDO::PARAM_STR);
	$stmt->bindParam(':postCode', $postCode, PDO::PARAM_STR);
	$stmt->bindParam(':addr', $addr, PDO::PARAM_STR);
	$stmt->bindParam(':building', $building, PDO::PARAM_STR);
	$stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
	$stmt->bindParam(':lng', $lng, PDO::PARAM_STR);
	$stmt->bindParam(':pname', $pname, PDO::PARAM_STR);
	$stmt->bindParam(':mapData', $mapData, PDO::PARAM_STR);

	$stmt->execute();
	header("Location: " . $_SERVER['PHP_SELF']);
	exit;
    } catch (PDOException $e) {
	echo "更新エラー: " . $e->getMessage();
    }
}

// 編集モード判定
$editMode = false;
$editData = null;
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $editMode = true;
    $id = $_GET['id'];
    try {
		$stmt = $pdo->prepare("SELECT * FROM noteMapData WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$editData = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
		echo "取得エラー: " . $e->getMessage();
		$editMode = false;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>noteMapWeb管理ページ</title>
    <style>
	body {
	    font-family: Arial, sans-serif;
	    margin: 20px;
	}
	table {
	    border-collapse: collapse;
	    width: 100%;
	}
	th, td {
	    border: 1px solid #ddd;
	    padding: 8px;
	    text-align: left;
	}
	th {
	    background-color: #f2f2f2;
	}
	tr:nth-child(even) {
	    background-color: #f9f9f9;
	}
	.action-buttons {
	    display: flex;
	    gap: 5px;
	}
	.form-group {
	    margin-bottom: 15px;
	    display: flex;
	    flex-wrap: wrap;
	    align-items: center;
	    gap: 10px;
	}
	.form-row {
	    display: flex;
	    flex-wrap: wrap;
	    gap: 10px;
	    margin-bottom: 15px;
	    width: 100%;
	}
	.form-field {
	    display: flex;
	    flex-direction: column;
	}
	.form-field label {
	    font-weight: bold;
	    margin-bottom: 5px;
	}
	input, textarea {
	    padding: 8px;
	    border: 1px solid #ddd;
	    border-radius: 4px;
	}
	input[type="text"] {
	    width: 100%;
	}
	input[type="number"] {
	    width: 100%;
	}
	textarea {
	    width: 100%;
	    height: 40px;
	}
	.w-small {
	    width: 150px !important;
	}
	.w-medium {
	    width: 200px !important;
	}
	.w-large {
	    width: 400px !important;
	}
	.w-xl {
	    width: 800px !important;
	}
	.w-full {
	    width: 100% !important;
	}
	button {
	    padding: 8px 16px;
	    background-color: #4CAF50;
	    color: white;
	    border: none;
	    border-radius: 4px;
	    cursor: pointer;
	}
	button:hover {
	    background-color: #45a049;
	}
	button.delete {
	    background-color: #f44336;
	}
	button.delete:hover {
	    background-color: #d32f2f;
	}
	button.edit {
	    background-color: #2196F3;
	}
	button.edit:hover {
	    background-color: #0b7dda;
	}
    </style>
</head>
<body>
    <h1>noteMapWeb管理ページ</h1>

    <?php if ($editMode && $editData): ?>
    <h2>データ編集</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<input type="hidden" name="id" value="<?php echo $editData['id']; ?>">

	<!-- ID と OrgUrl を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="id">ID</label>
			<input type="text" id="id" name="id" value="<?php echo htmlspecialchars($editData['id']); ?>" class="w-medium" readonly>
		</div>
		<div class="form-field" style="flex-grow: 1;">
			<label for="OrgUrl">noteUrl</label>
			<input type="text" id="OrgUrl" name="OrgUrl" value="<?php echo htmlspecialchars($editData['OrgUrl']); ?>" class="w-full">
		</div>
	</div>

	<!-- ArticleId と Title を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="ArticleId">記事ID</label>
			<input type="text" id="ArticleId" name="ArticleId" value="<?php echo htmlspecialchars($editData['ArticleId']); ?>" class="w-medium">
		</div>
		<div class="form-field" style="flex-grow: 1;">
			<label for="Title">タイトル</label>
			<input type="text" id="Title" name="Title" value="<?php echo htmlspecialchars($editData['Title']); ?>" class="w-xl">
		</div>
	</div>

	<!-- UserId、UserName、Mail を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="UserId">ユーザID</label>
			<input type="text" id="UserId" name="UserId" value="<?php echo htmlspecialchars($editData['UserId']); ?>" class="w-medium">
		</div>
		<div class="form-field">
			<label for="UserName">ユーザ名</label>
			<input type="text" id="UserName" name="UserName" value="<?php echo htmlspecialchars($editData['UserName']); ?>" class="w-medium">
		</div>
		<div class="form-field" style="flex-grow: 1;">
			<label for="Mail">メール</label>
			<input type="text" id="Mail" name="Mail" value="<?php echo htmlspecialchars($editData['Mail']); ?>" class="w-large">
		</div>
	</div>

	<!-- PostCode、Addr、Building を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="PostCode">〒</label>
			<input type="text" id="PostCode" name="PostCode" value="<?php echo htmlspecialchars($editData['PostCode']); ?>" class="w-small">
		</div>
		<div class="form-field" style="flex-grow: 1;">
			<label for="Addr">住所</label>
			<input type="text" id="Addr" name="Addr" value="<?php echo htmlspecialchars($editData['Addr']); ?>" class="w-xl">
		</div>
		<div class="form-field">
			<label for="Building">建物名</label>
			<input type="text" id="Building" name="Building" value="<?php echo htmlspecialchars($editData['Building']); ?>" class="w-medium">
		</div>
	</div>

	<!-- Lat と Lng を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="Lat">Lat</label>
			<input type="text" id="Lat" name="Lat" value="<?php echo htmlspecialchars($editData['Lat']); ?>" class="w-medium">
		</div>
		<div class="form-field">
			<label for="Lng">Lng</label>
			<input type="text" id="Lng" name="Lng" value="<?php echo htmlspecialchars($editData['Lng']); ?>" class="w-medium">
		</div>
	</div>

	<!-- MapType と NewUrl を同じ行に配置 -->
	<div class="form-row">
		<div class="form-field">
			<label for="MapType">Type</label>
			<input type="number" id="MapType" name="MapType" value="<?php echo htmlspecialchars($editData['MapType']); ?>" class="w-small">
		</div>
		<div class="form-field" style="flex-grow: 1;">
			<label for="NewUrl">mapUrl</label>
			<textarea id="NewUrl" name="NewUrl"><?php echo htmlspecialchars($editData['NewUrl']); ?></textarea>
		</div>
	</div>

	<!-- MapData -->
	<div class="form-row">
		<div class="form-field" style="width: 100%;">
			<label for="MapData">MapData</label>
			<textarea id="MapData" name="MapData"><?php echo htmlspecialchars($editData['MapData']); ?></textarea>
		</div>
	</div>

	<!-- Pname (コメント) -->
	<div class="form-row">
		<div class="form-field" style="width: 100%;">
			<label for="Pname">コメント</label>
			<textarea id="Pname" name="Pname"><?php echo htmlspecialchars($editData['Pname']); ?></textarea>
		</div>
	</div>
	<div class="form-row">
		<button type="submit" name="update">更新</button>
		<a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"><button type="button">キャンセル</button></a>
	</div>
    </form>
    <?php else: ?>
    <h2>データ一覧</h2>
    <table>
	<thead>
		<tr>
			<th>ID</th>
			<th>タイトル</th>
			<th>ユーザID</th>
			<th>ユーザ名</th>
			<th>メール</th>
			<th>記事ID</th>
			<th>〒</th>
			<th>住所</th>
			<th>Type</th>
			<th>MapData</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	<?php
		try {
		$stmt = $pdo->query("SELECT * FROM noteMapData ORDER BY id DESC");
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo "<tr>";
			echo "<td>" . htmlspecialchars($row['id']) . "</td>";

		    // Titleのリンク生成
			$title = htmlspecialchars($row['Title']);
            $encodedTitle = urlencode($title);
            $encodedUrl = urlencode($row['OrgUrl']);
            $lat = htmlspecialchars($row['Lat']);
            $lng = htmlspecialchars($row['Lng']);
            $articleId = htmlspecialchars($row['ArticleId']);
            $userId = htmlspecialchars($row['UserId']);
            
            switch ($row['MapType']) {
                case 13:
                    echo "<td><a href=\"https://nsk.org/maps/noteMapNew.html?lat={$lat}&lng={$lng}&url={$encodedUrl}&title={$encodedTitle}\">{$title}</a></td>";
                    break;
                case 9:
                    echo "<td><a href=\"" . htmlspecialchars($row['NewUrl']) . "\">" . $title . "</a></td>";
                    break;
                case 1:
                    echo "<td><a href=\"https://nsk.org/maps/noteMapNew.html?lat={$lat}&lng={$lng}&url={$encodedUrl}&title={$encodedTitle}\">{$title}</a></td>";
                    break;
                case 3:
                    // MapDataを適切に処理する - 二重エンコードを避ける
                    // サニタイズ済みの基本URLを作成
                    $baseUrl = "https://nsk.org/maps/noteMapNew.html?lat={$lat}&lng={$lng}";
                    
                    // MapDataが空でない場合のみ追加
                    if (!empty($row['MapData'])) {
                        // MapDataは既に適切なフォーマットでデータベースに保存されていると仮定
                        // raw_encodeでマップデータをエンコード（特殊文字のみエンコードするが二重エンコードを避ける）
                        $mapData = $row['MapData'];
                        $encodedMapData = rawurlencode($mapData);
                        $baseUrl .= "&mapData=" . $encodedMapData;
                    }
                    
                    // その他のパラメータを追加
                    $baseUrl .= "&url={$encodedUrl}";
                    if (!empty($articleId)) {
                        $baseUrl .= "&aId={$articleId}";
                    }
                    if (!empty($userId)) {
                        $baseUrl .= "&uId={$userId}";
                    }
                    $baseUrl .= "&title={$encodedTitle}";
                    echo "<td><a href=\"{$baseUrl}\">{$title}</a></td>";
                    break;
                default:
                    echo "<td><a href=\"https://nsk.org/maps/noteMapNew.html?title={$encodedTitle}\">{$title}</a></td>";
            }
            echo "<td>" . htmlspecialchars($row['UserId']) . "</td>";
            echo "<td>" . htmlspecialchars($row['UserName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Mail']) . "</td>";
			// 記事IDのリンク先修正
			$orgUrl = htmlspecialchars($row['OrgUrl']);
			// 記事IDが空でない場合にのみリンクを生成
			if (!empty($articleId)) {
                echo "<td><a href=\"" . $orgUrl . "\">" . $articleId . "</a></td>";
            } else {
                echo "<td>" . $articleId . "</td>";
            }
			echo "<td>" . htmlspecialchars($row['PostCode']) . "</td>";
			echo "<td>" . htmlspecialchars($row['Addr']) . "</td>";
			echo "<td>" . htmlspecialchars($row['MapType']) . "</td>";
		    // MapDataの表示（長い場合は省略）
			$mapData = htmlspecialchars($row['MapData']);
			if (mb_strlen($mapData) > 50) {
			$mapData = mb_substr($mapData, 0, 50) . "...";
			}
			echo "<td>" . $mapData . "</td>";
		    // 操作ボタン
			echo "<td class='action-buttons'>";
			echo "<a href=\"" . htmlspecialchars($_SERVER['PHP_SELF']) . "?edit=1&id=" . $row['id'] . "\"><button type='button' class='edit'>編集</button></a>";
			echo "<form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return confirm(\"本当に削除しますか？\");'>";
			echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
			echo "<button type='submit' name='delete' class='delete'>削除</button>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
		}
		} catch (PDOException $e) {
		echo "<tr><td colspan='11'>データ取得エラー: " . $e->getMessage() . "</td></tr>";
		}
	?>
	</tbody>
    </table>
    <?php endif; ?>
</body>
</html>