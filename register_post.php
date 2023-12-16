<?php
//Conectar ao banco de dados

function connectDatabase(){
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'banco_de_dados_loja'; //aqui deve ficar o nome do banco que foi criado

    $connection = mysqli_connect('$server', '$user', '$password', '$database');

    if(!$connection){
        die('Conexão falhou:'.mysqli_connect_error());
    }
    return $connection;
}

//connectDatabase(); 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name= $_POST["name"];
    $email= $_POST["email"];
    $password= $_POST["password"];

    $connection = connectDatabase ();

    //Proteger contra sql injection

    $name = mysqli_real_escape_string($connection, $name);
    $email = mysqli_real_escape_string($connection, $email);
    $password= mysqli_real_escape_string($connection, $password);


    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', $password)";

    if(mysqli_query($connection, $query)){
        echo "Usuário cadastrado com sucesso";
    }else{
        echo "Erro ao cadastrar o usuário: ".mysqli_error($connection);
    }
}
?>