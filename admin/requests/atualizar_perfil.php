<?php

//Fazer a  conexção com o banco 
include_once ('../../helpers/database.php');


$name = $_post['nome_completo'];
$email= $_POST["email"];
$about = $_POST['about'];
$password_confirm = $_POST['password_confirm'];
$password= $_POST['password'];

// se o usuario enviar a imagem entao iremos tratar. 
if($image !== null){

        //  Configuração para o upload da imagem
    $targetDir = "../../src/img_perfil/";
    $randomName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $randomName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validação da imagem

    if(!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile) || $_FILES['image']['size'] > 500000){
        $_SESSION['message'] = "Desculpe, a sua imagem deve ter no máximo 5MB.";
        $_SESSION['message_type'] = "danger";
        $uploadOk = 0;
        header("Location: ../../src/img_perfil/");
    }

    if($uploadOk == 1 && move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)){
        // Conecta no banco de dados
        $connection = connectDatabase();
        
        $title = mysqli_real_escape_string($connection, $title);
        $content = mysqli_real_escape_string($connection, $content);

        // Obtém o id usuário logado
        $user_id = $_SESSION['user_id'];

        $image = "../../src/img_perfil/" . $randomName;

        $query = "INSERT INTO posts (user_id, title, content, image, views) VALUES ('$user_id', '$title', '$content', '$image', 0)";

    }

}

// Fazer um if para cada alteração concatenando os resultados. o clinte pode mudar uma coisa apenas  

$result =mysqli_query($conexao, $query);

?>