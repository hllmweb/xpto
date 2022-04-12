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
        <div class="main">
            <div class="header">
                <div class="container-flex flex">
                    <div class="item flex">

                         <div class="input-field-width">
                            <input type="text" name="login" id="login" autocomplete="off" pattern=".+" required="" />
                            <label for="login">URL <sub>(http ou https)</sub></label>
                        </div>
                        <div class="input-field-width">
                            <button>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </div>
                    

                    </div>

                    <div class="item">
                        <span>Login da Pessoa</span>
                        <a href="" class="logoff">Sair <i class="fa-solid fa-circle-xmark"></i></a>
                    </div>
                


                </div>
            </div>




            <div class="section">
                <div class="section-flex">
                    
                    <div class="item-box">
                        <div class="title">Titulo do Site  
                            <a href="#" class="del"><i class="fa-solid fa-circle-xmark"></i></a> 
                        </div>
                        <div class="description">
                            <span>
                                <strong><i class="fa-solid fa-globe"></i> Url</strong>
                                <a href="http://www.hugomesquita.com.br" target="_blank">http://www.hugomesquita.com.br</a> 
                            </span>

                            <span>
                                <strong><i class="fa-solid fa-calendar-days"></i> Última Atualização</strong>
                                11/04/2022 12:03:00

                                <div class="status">
                                    <span class="s-200 blink">  <i class="fa-solid fa-check"></i> 200</span>
                                </div>
                            </span>
                        </div>
                    </div>


                    <div class="item-box">
                        <div class="title">Titulo do Site  
                            <a href="#" class="del"><i class="fa-solid fa-circle-xmark"></i></a> 
                        </div>
                        <div class="description">
                            <span>
                                <strong><i class="fa-solid fa-globe"></i> Url</strong>
                                <a href="http://www.google.com" target="_blank">http://www.google.com</a> 
                            </span>

                            <span>
                                <strong><i class="fa-solid fa-calendar-days"></i> Última Atualização</strong>
                                11/04/2022 12:03:00

                                <div class="status">
                                    <span class="s-300 blink">  <i class="fa-solid fa-check"></i> 300</span>
                                </div>
                            </span>
                        </div>
                    </div>


                    <div class="item-box">
                        <div class="title">teste</div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</body>
</html>



<script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>