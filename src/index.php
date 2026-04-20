<?php
// 初期化（空配列）
$todos = [];

$filePath = 'todos.json';

// todoの読み込み
function loadTodos($filePath) {
    if (!file_exists($filePath)){
        return [];
    }

    $json = file_get_contents($filePath);
    return json_decode($json, true) ?? [];
}

$todos = loadTodos($filePath);
    
function saveTodos($filePath, $todos) {

    // jsonファイルを作成・更新
    file_put_contents($filePath, json_encode($todos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
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

        saveTodos($filePath, $todos);
    }

}

if (isset ($_GET['deleted_id'])) {
    $deletedId = (int)$_GET['deleted_id']; //文字列を整数に変換している

    foreach ($todos as $index => $todo) {
        if ($todo['id'] == $deletedId){
            unset($todos[$index]);
            break;
        }
    }

    $todos = array_values($todos);
    saveTodos($filePath, $todos);

    header('Location: index.php');
    exit;
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
                <a href="?deleted_id=<?php echo $todo['id']; ?>">削除</a>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>