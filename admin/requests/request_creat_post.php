<?php
session_start();

include_once ('../../helpers/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST['image'];
    $user_id = $_SESSION['user_id'];


$targetDir = "../../src/img/receitas/";
$randomName = uniqid() . "_" . basename($_FILES['image']['name']);
$targetFile = $targetDir . $randomName;
$uploadOK = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

//VALIDAÇÃO DA IMAGEM 
if(!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile) || $_FILES ['image']['size'] > 500000){
  $_SESSION['form_error'] = "Desculpe,a sua imagem deve ter no maximo 5MB.";
  $uploadOK = 0;
  header("Location: ../create_post.php");
}

if($uploadOK == 1 && move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
    //conecta no banco de dados
    $connection = connectDatabase();

      // Usar prepared statements para proteger contra SQL injection
      $title = mysqli_real_escape_string($connection, $title);
      $content = mysqli_real_escape_string($connection, $content);

    // obtem o id usuario logado
    $user_id = $_SESSION['user_id'];

    $image = "src/img/receitas/"; .$randomName;

    $query= "INSERT INTO posts (user_id, title. content, image, views) VALUE ('$user_id', '$title', '$content', '$image',0)";

    if(mysqli_query($connection, $query)) {
         $_SESSION['message'] = "Sua postagem foi cadastrada com sucesso!";
        header("Location: ../create_post.php");
    }else{
        $_SESSION['message'] = "Ocorreu um erro ao cadastrar sua postagem";
       header("Location: ../create_post.php");
    }
}

    

}