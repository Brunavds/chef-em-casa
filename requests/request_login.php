<?php

 // Iniciar a sessão
 session_start();

function connectDatabase(){
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'banco_de_dados';

    $connection = mysqli_connect($server, $user, $password, $database);

    if(!$connection){
        die('Conexão falhou:' . mysqli_connect_error());
    }

    return $connection;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $connection = connectDatabase();

    // Usar prepared statements para proteger contra SQL injection
    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    $password= mysqli_real_escape_string($connection, $password);


    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $query = " SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc();
        
        if(password_verify($password, $row['password'])){

            // Armazenar o ID do usuário e o nome
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            //Redirecionar para dashboard
            header("Location: ../admin/index.php");
        }else{
            $_SESSION['login_error'] = 'Senha está incorreta';
        }
    }else{
        $_SESSION['login_error'] = 'E-mail incorreto ou não existe';
    }

    mysqli_close($connection);
}
?>