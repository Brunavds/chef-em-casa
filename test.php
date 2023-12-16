<?php 

//Fazer a  conexção com o banco 
include_once ('../../helpers/database.php');

$namenew = $_POST['nome_completo'];
$emailnew = $_POST['email'];
$aboutnew = $_POST['about'];
$passwordnew_confirm = $_POST['password_confirm'];
$passwordnew = $_POST['password'];


// se o usuario enviar a imagem entao iremos tratar. 
// Se o usuário enviar a imagem, então iremos tratar.
if ($_FILES['image']['name'] !== "") {
    
    // Configuração para o upload da imagem
    $targetDir = "../../src/img_perfil/";
    $randomName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $randomName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validação da imagem
    if (!getimagesize($_FILES['image']['tmp_name']) || file_exists($targetFile) || $_FILES['image']['size'] > 500000) {
        $_SESSION['message'] = "Desculpe, a sua imagem deve ter no máximo 5MB.";
        $_SESSION['message_type'] = "danger";
        $uploadOk = 0;
        header("Location: ../../src/img_perfil/");
        exit(); // Certifique-se de sair após o redirecionamento.
    }

    if ($uploadOk == 1 && move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Conecta no banco de dados
        $connection = connectDatabase();
    }

 }

function alterarnome($name, $namenew) {
    if ($name !== $namenew) {
        // Se a senha antiga não for idêntica à nova, você pode realizar a alteração aqui
        $name = $namenew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Nome alterada com sucesso!";
    } else {
        // Se as senhas forem idênticas, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "O nome nova não pode ser idêntica ao antiga.";
    }
}

$resultado = alterarnome($nome, $nomenew);
echo $resultado;


function alterarsenha($password, $passwordnew) {
    if ($password !== $passwordnew && $passwordnew_confirm == $passwordnew) {
        // Se a senha antiga não for idêntica à nova, você pode realizar a alteração aqui
        $password = $passwordnew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Senha alterada com sucesso!";
    } else {
        // Se as senhas forem idênticas, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "A senha nova não pode ser idêntica à antiga.";
    }
}

$resultado = alterarsenha($password, $passwordnew);
echo $resultado;



function alteraremail($email, $emailnew) {
    if ($email !== $emailnew) {
        // Se a senha antiga não for idêntica à nova, você pode realizar a alteração aqui
        $email = $emailnew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Email alterada com sucesso!";
    } else {
        // Se as senhas forem idênticas, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "O Email nova não pode ser idêntica ao antiga.";
    }
}

$resultado = alteraremail($email, $emailnew);
echo $resultado;

function alterarabout (){
    if($about !== $aboutnew) {
        $about = $aboutnew;
        return "Sua descrição foi alterada!"
    }else{
        return"Sua descrição não poder ser idêntico a antiga.";
    }
}

$resultado = alterarabout($about, $aboutnew);
echo $resultado;


 // Obtém o id do usuário logado
 $user_id = $_SESSION['user_id'];

 // Exemplo de consulta SQL para inserir dados
 $query = "INSERT INTO users (user_id, name, email, about, password, image) VALUES ('$user_id', '$namenew', '$emailnew', '$aboutnew', '$passwordnew', '$image')";

 // Execute a consulta SQL usando a função apropriada (por exemplo, mysqli_query)
 // Certifique-se de tratar os erros de consulta
 $result = mysqli_query($connection, $query);
 

if ($result) {
    $_SESSION['message'] = "Dados atualizados com sucesso!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Erro ao atualizar dados: " . mysqli_error($connection);
    $_SESSION['message_type'] = "danger";
}

?>