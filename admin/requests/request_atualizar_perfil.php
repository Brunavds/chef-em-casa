<?php

// Fazer a conexão com o banco
include_once('../../helpers/database.php');

// Conexão com o banco de dados
$connection = connectDatabase();

$namenew = mysqli_real_escape_string($connection, $_POST['nome_completo']);
$emailnew = mysqli_real_escape_string($connection, $_POST['email']);
$aboutnew = mysqli_real_escape_string($connection, $_POST['about']);
$passwordnew_confirm = mysqli_real_escape_string($connection, $_POST['password_confirm']);
$passwordnew = mysqli_real_escape_string($connection, $_POST['password']);

// se o usuário enviar a imagem, então iremos tratar.
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
        // Obtém o id do usuário logado
        $user_id = $_SESSION['user_id'];

        // Exemplo de consulta SQL para atualizar dados com imagem
        $query = "UPDATE users SET 
                    name = '$namenew', 
                    email = '$emailnew', 
                    about = '$aboutnew', 
                    password = '$passwordnew', 
                    image = '$targetFile' 
                  WHERE user_id = '$user_id'";

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
    }
}

function alterarnome($name, $namenew) {
    if ($name !== $namenew) {
        // Se o nome antigo não for idêntico ao novo, você pode realizar a alteração aqui
        $name = $namenew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Nome alterado com sucesso!";
    } else {
        // Se os nomes forem idênticos, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "O nome novo não pode ser idêntico ao antigo.";
    }
}

// Obtém o valor de $name de alguma forma antes de chamar a função
$resultadoNome = alterarnome($name, $namenew);
echo $resultadoNome;

function alterarsenha($password, $passwordnew, $passwordnew_confirm) {
    if ($password !== $passwordnew && $passwordnew_confirm == $passwordnew) {
        // Se a senha antiga não for idêntica à nova, você pode realizar a alteração aqui
        $password = $passwordnew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Senha alterada com sucesso!";
    } else {
        // Se as senhas forem idênticas, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "A senha nova não pode ser idêntica à antiga ou a confirmação da senha está incorreta.";
    }
}

// Obtém o valor de $password de alguma forma antes de chamar a função
$resultadoSenha = alterarsenha($password, $passwordnew, $passwordnew_confirm);
echo $resultadoSenha;

function alteraremail($email, $emailnew) {
    if ($email !== $emailnew) {
        // Se o email antigo não for idêntico ao novo, você pode realizar a alteração aqui
        $email = $emailnew;
        // Além disso, é uma boa prática retornar algum indicativo de sucesso ou uma mensagem apropriada.
        return "Email alterado com sucesso!";
    } else {
        // Se os emails forem idênticos, em vez de usar 'echo', você pode retornar uma mensagem para ser tratada onde a função é chamada.
        return "O Email novo não pode ser idêntico ao antigo.";
    }
}

// Obtém o valor de $email de alguma forma antes de chamar a função
$resultadoEmail = alteraremail($email, $emailnew);
echo $resultadoEmail;

function alterarabout($about, $aboutnew) {
    if ($about !== $aboutnew) {
        $about = $aboutnew;
        return "Sua descrição foi alterada!";
    } else {
        return "Sua descrição não pode ser idêntica à antiga.";
    }
}

// Obtém o valor de $about de alguma forma antes de chamar a função
$resultadoAbout = alterarabout($about, $aboutnew);
echo $resultadoAbout;

// Feche a conexão com o banco de dados
mysqli_close($connection);

// Redirecione para a página adequada
header("Location: ../profile.php");
exit();

?>
