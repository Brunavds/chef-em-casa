<?php
session_start();

include_once ('../../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST["title"];
    $content = $_POST["content"];
   
    //Configuração para o upload de imagem
    $targetDir = "../../src/img/receitas/";
    $randowName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $randowName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    //Validação da imagem
    if(!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile) || $_FILES['image']['size'] > 500000){
        $_SESSION['form_error'] = "Desculpe, a sua imagem deve ter no máximo 5MB.";
        $uploadOk = 0;
        header("Location: ../create_post.php");
    }

    if($uploadOk == 1 && move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        // Conecta no banco de dados
        $connection = connectDatabase();

        // Usar prepared statements para proteger contra SQL injection
         $title = mysqli_real_escape_string($connection, $title);
        $content = mysqli_real_escape_string($connection, $content);

        // Obtém o id usuário logado
        $user_id = $_SESSION['user_id'];

        $image = "../../src/img/receitas/" .$randowName;

        $query = "INSERT INTO posts (user_id, title, content, image, views) VALUES ('$user_id', '$title', '$content', '$image', 0)";

            if(mysqli_query($connection, $query))
            $_SESSION['message'] = "Sua postagem foi publicada com sucesso.";
            header("Location: ../create_post.php");
    }else{
        $_SESSION ['message'] = "Ocorreu um erro ao cadastrar sua postagem.";
        header("Location: ../create_post.php");
    }
}