<?php
$todos = [];
    if(file_exists("todo.txt")){
    $file = file_get_contents("todo.txt");
    $todos = unserialize($file);
    }
    if(isset($_POST['todo']) && !empty ($_POST['todo'])){
            $data = $_POST['todo'];
        $todos [] = [
            'todo' => $data,
            'status' => 0
            ];
            file_put_contents('todo.txt',serialize($todos));
            header('Location:index.php');
        }
    if(isset($_GET['hapus'])){
        unset($todos[$_GET['key']]);
        file_put_contents('todo.txt',serialize($todos));
        header('Location:index.php');
    }
    if(isset($_GET['hapusalldata'])){
        $todos =[];
        file_put_contents('todo.txt',serialize($todos));
        header('Location:index.php');
    }
    
    if(isset($_GET['status'])){
        $todos[$_GET['key']]['status'] = $_GET['status'];
        file_put_contents('todo.txt',serialize($todos));
        header('Location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aplikasi Todo</title>
        <style>
            body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

h1 {
    color: #333;
    text-align: center;
}

form {
    margin-bottom: 20px;
}

form label {
    display: block;
    margin-bottom: 8px;
}

form input[type="text"] {
    width: calc(100% - 16px);
    padding: 8px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

form button {
    background-color: #4caf50;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form a {
    color: #e74c3c;
    margin-left: 10px;
    text-decoration: none;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
    padding: 8px 0;
}

li label {
    flex: 1;
    margin-left: 10px;
}

input[type="checkbox"] {
    margin-right: 10px;
    cursor: pointer;
}

a {
    text-decoration: none;
}

@media only screen and (max-width: 768px) {
    .container {
        max-width: 100%;
        border-radius: 0;
    }
}

        </style>
    </head>
    <body>
        <div class="container">
            <h1>Aplikasi Todo</h1>
            <form method="post">
                <label>Hari ini ada kegiatan apa?</label>
                <input type="text" name="todo">
                <button type="submit">Simpan Data</button>
                <a href="index.php?hapusalldata=1&key=<?php echo $key;?>">Hapus Semua Data</a>
            </form>

            <ul>
                <?php foreach($todos as $key => $value): ?>
                <li>
                    <input
                        type="checkbox"
                        name="todo"
                        onclick="window.location.
                href='index.php?status=<?php echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $key;?>'"
                        <?php if($value['status'] == 1) echo 'checked'; ?>>
                    <label>
                        <?php 
                        if($value['status'] == 1){
                            echo '<del>'.htmlspecialchars($value['todo']) .'</del>' ;
                        }else{
                            echo htmlspecialchars($value['todo']);
                        }
                        ?>
                    </label>
                    <a href="index.php?hapus=1&key=<?php echo $key; ?>">Hapus</a>
                </li>
                <?php endforeach ?>
            </ul>
        </body>
    </html>