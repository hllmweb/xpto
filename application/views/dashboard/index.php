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
                            <input type="text" name="url" id="url" autocomplete="off" pattern=".+" required="" />
                            <label for="url">URL <sub>(http ou https)</sub></label>
                        </div>
                        <div class="input-field-width">
                            <button onclick="add_url();">
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                        </div>

                    </div>

                    <div class="item">
                        <span>
                        <?= $login_name; ?>
                        </span>
                        <a href="<?= base_url('dashboard/logout'); ?>" class="logoff">
                            Sair <i class="fa-solid fa-circle-xmark"></i>
                        </a>
                    </div>
                


                </div>
            </div>




            <div class="section">
                <div class="section-flex" id="load_url">
                    



                </div>
            </div>

        </div>
    </div>
</body>
</html>



<script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
<script>
  

        var refresh = setInterval(function(){ 
            load_dados();
        }, 1500);



        function add_url(){
            let url = $("#url").val();
            var url_validate = /^(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})/;
            if(!url_validate.test(url) || url.length == 0){
               alert("Informe uma url valida");
               return;
            }else{
               //alert('success');
                $.ajax({
                    url: "<?= base_url('url/insert/'); ?>",
                    type: "POST",
                    data:{
                        url: url
                    },
                    success: (data) =>{
                        if(data == "ok"){
                            alert("Inserido com sucesso!");
                            $("#url").val("");
                            $("#url").focus();
                        }
                    }
                });
            }


        }



        function del_url(idurl){
            
            $.ajax({
                url: "<?= base_url('url/delete/'); ?>"+idurl,
                type: "GET",
                success: (data) => {
                    if(data == "ok"){
                        alert("Deletado com sucesso!");
                        load_dados();
                    }
                }
            })
        }


        function load_dados(){
            $.ajax({
                url: "<?= base_url('url/list/'); ?>",
                type: "POST",
                success: (data) =>{
                    $("#load_url").html(data);
                }
            })
        }


</script>