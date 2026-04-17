<?php
// 初期化（空配列）
$todos = [];

// タスク一覧取得
$filePath = 'todos.json';
if (file_exists($filePath)){
    $json = file_get_contents($filePath);
    $todos = json_decode($json, true) ?? []; // trueの場合連想配列を返す
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');

    if ($title !== '') {
        $newTodo = [
            'id' => count($todos)+1,
            'title' => $title,
            'created_at' => date('c'),
        ];
        $todos []= $newTodo;
    }

    // jsonファイルを作成・更新
    file_put_contents($filePath, json_encode($todos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
}

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

    <form method="post" action="">
        <input type="text" name="title" placeholder="Todoを入力">
        <button type="submit">追加</button>
    </form>

    <h2>一覧</h2>

    <ul>
        <?php foreach ($todos as $todo): ?>
            <li>
                <?php 
                echo htmlspecialchars($todo['title'], ENT_QUOTES, 'UTF-8');
                ?>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>