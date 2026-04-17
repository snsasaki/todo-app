<?php
// 初期化（空配列）
$todos = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    if ($title !== '') {
        // 空文字じゃなかった場合の処理
        $title = trim($_POST('title') ?? '');
    }
}

// タスク一覧取得
$filePath = 'todos.json';
if (file_exists($filePath)){
    $json = file_get_contents($filePath);
    $todos = json_decode($json, true) ?? []; // trueの場合連想配列を返す
}

// 中身を確認
var_dump($todos);





?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todoアプリ</title>
</head>
<body>
    <h1>Todoアプリ</h1>

    <form method="POST" action="">
        <input type="text" name="title" placeholder="Todoを入力">
        <button type="submit">追加</button>
    </form>

</body>
</html>