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
                   <input type="text" name="email" id="email" autocomplete="off" pattern=".+" required="" onChange="isEmail(this.value)"/>
                   <label for="email">E-Mail</label>
                </div>

                <div class="input-field">
                   <input type="password" name="senha" id="senha" autocomplete="off" pattern=".+" required="" />
                   <label for="senha">Senha</label>
                </div>

                <button>
                    <span>Cadastrar</span>
                    <i class="fa-solid fa-plus"></i>
                </button>

                <a href="<?= base_url('login'); ?>" class="link">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>



<script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
<script>
    function isEmail(p_email){
        $.ajax({
            url: "<?= base_url('cadastrar/isEmail/') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                email: p_email
            },
            success: (data) => {
                if(data[0].valor == 0){              
                    // email não existe     
                    $("#email").removeClass('exist');
                    $("#email").addClass('no-exist');
                }else if(data[0].valor == 1){
                    // email já existe
                    $("#email").addClass('exist');
                    $("#email").removeClass('no-exist');
                   
                }

            }

        });

    }

</script>
