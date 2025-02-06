<?php

session_start();

$pdo = new PDO('pgsql:host=db; port=5432;dbname=mydb', 'user', 'pwd');
$stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
$users = $stmt->fetchAll();

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/js/bootstrap.min.js"></script>

<div class="container">
    <div id="main">
        <div class="row" id="real-estates-detail">
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <header class="panel-title">
                            <div class="text-center">
                                <strong>Профиль пользователя</strong>
                            </div>
                        </header>
                    </div>
                    <div class="panel-body">
                        <?php foreach ($users as $user): ?>
                        <div class="text-center" id="author">
                            <img src="<?php echo $user['image_url']; ?>">
                            <h3></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12">
                <div class="panel">
                    <div class="panel-body">

                        <ul id="myTab" class="nav nav-pills">
                            <li class="active"><a href="#detail" data-toggle="tab">О пользователе</a></li>

                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <hr>
                            <div class="tab-pane fade active in" id="detail">

                                <table class="table table-th-block">
                                    <tbody>
                                    <tr><td class="active">Имя: </td><td> <?php echo $user['name']; ?> </td></tr>
                                    <tr><td class="active">Email:</td><td> <?php echo $user['email']; ?> </td></tr>
                                    <tr><td class="active">Страна:</td><td>Россия</td></tr>
                                   </tbody>
                                </table>

                                <a href="/catalog.php">Назад в каталог</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><? endforeach; ?>

    </div><!-- /.main -->
</div><!-- /.container -->

<style>
    body{background:url(https://bootstraptema.ru/images/bg/bg-1.png)}

    #main {
        background-color: #f2f2f2;
        padding: 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        border-bottom: 4px solid #ddd;
    }
    #real-estates-detail #author img {
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        -ms-border-radius: 100%;
        -o-border-radius: 100%;
        border-radius: 100%;
        border: 5px solid #ecf0f1;
        margin-bottom: 10px;
    }
    #real-estates-detail .sosmed-author i.fa {
        width: 30px;
        height: 30px;
        border: 2px solid #bdc3c7;
        color: #bdc3c7;
        padding-top: 6px;
        margin-top: 10px;
    }
    .panel-default .panel-heading {
        background-color: #fff;
    }
    #real-estates-detail .slides li img {
        height: 450px;
    }
</style>