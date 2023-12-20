<?php
$pageInfo = array(
    'title' => 'Listagem de Usuários',
    'description' => 'Visualize e gerencie os usuários cadastrados.',
    'pageName' => 'users',
);

include_once('../components/admin/header.php');

//Seleciona todos os usuarios cadastrados e mostra na tela
$query= "SELECT id, name, email, about, created_at FROM users;";


$result = mysqli_query($connection, $query);

$user = array();

if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!-- Conteúdo do dashboard -->
<main class="container py-5">
    <div class="row">
        <!-- Sidebar do dashboard -->
        <div class="col-md-3">
            <?php
                include_once('../components/admin/menu_sidebar.php');
            ?>
        </div>
        <!-- Main do dashboard -->
        <section class="col-md-9">
            <h2><?= $pageInfo['title'] ?></h2>
            <p><?= $pageInfo['description'] ?></p>
            <a href="create_user.php" class="btn btn-success my-2 my-sm-0 text-light">
                Adicionar novo usuário
            </a>
            <hr>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Sobre</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($users as $user){ ?>
                            <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['about']; ?></td>
                            <?php echo date('d/m/Y', strtotime($user['created_at']) ); ?></td>
                               
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </a>
                                            <a class="dropdown-item text-danger" href="#">
                                                <i class="fas fa-trash"></i>
                                                Excluir
                                            </a>
                                            <a class="dropdown-item" href="#" target="_blank">
                                                <i class="fas fa-eye"></i>
                                                Detalhes
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Adicione mais linhas conforme necessário -->
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>

<?php
$currentPage = 'users';
include_once('../components/admin/footer.php');
?>
