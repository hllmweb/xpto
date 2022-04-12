<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo; ?></title>
    <link href="<?= base_url('assets/css/style.css?v=').time(); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/all.min.css'); ?>" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="login-container">
            <form method="POST" action="#">
                <div class="input-field">
                    <input type="text" name="login" id="login" autocomplete="off" pattern=".+" required="" />
                    <label for="login">Login</label>
                </div>

                <div class="input-field">
                   <input type="password" name="senha" id="senha" autocomplete="off" pattern=".+" required="" />
                   <label for="senha">Senha</label>
                </div>

                <button>
                    <span>Entrar</span> 
                    <i class="fa-solid fa-angle-right"></i>
                </button>

                <a href="<?= base_url('cadastrar'); ?>" class="link">Cadastre-se</a>
            </form>
        </div>
    </div>
</body>
</html>



<script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
<script>
   $(function(){

    // let cont = 0;
    // setInterval(function () {

    //     $("#load").html("texte"+cont);

    //     cont++;
    // }, 1000);


});
</script>