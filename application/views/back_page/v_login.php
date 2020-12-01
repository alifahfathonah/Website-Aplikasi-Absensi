<?php 

if( $this->session->userdata('user_login') ) {
    redirect('kehadiranmhs','refresh');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Absensi QR</title>
    <link rel="stylesheet" type="text/html" href="<?php echo base_url() ?>">

    <?php  
    $css = array(
        "assets/vendor/bootstrap/css/bootstrap.min.css",
        "assets/vendor/bootstrap/css/bootstrap.css",
        "assets/vendor/metisMenu/metisMenu.min.css",
        "assets/dist/css/sb-admin-2.css",
    );

    foreach ($css as $css) {
        echo link_tag( $css );
    }

    echo script_tag( 'assets/vendor/jquery/jquery.min.js' );
    ?>

</head>

<style>
    body {
        background-image: url("http://localhost/absensiqr/kodeqr/gradient.jpg");
        background-attachment: fixed;
    }
</style>    

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="login-panel panel panel-default" style="border-bottom-right-radius: 15px; border-bottom-left-radius: 15px;" >
                    <div class="panel-heading">
                        <h3 class="panel-title" style="font-size: 20px; margin-top: 10px; 
                        margin-bottom: 10px; text-align: center;"><strong>- LOGIN ADMIN -</strong></h4>
                    </div>
                    

                    <div class="panel-body" style="margin-top: 10px; padding: 30px; margin-bottom: 40px;">
                        <?php echo form_open('login/doLogin'); ?>
                        <form role="form">
                            <fieldset>                                  
                                <?php if ($disp = $this->session->flashdata('logout_admin')) { ?>  
                                    <?php echo $disp; } ?>
                                    <?php if ($disp = $this->session->flashdata('login_admin')) { ?>  
                                        <?php echo $disp; } ?>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input class="form-control" placeholder="username" required="" name="username" type="text" autofocus required="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input class="form-control" placeholder="password" required="" name="password" type="password" value="" required="">
                                            </div>
                                        </div>
                                        <div class="checkbox" style="margin-top: 30px;">
                                            <label>
                                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                            </label>
                                        </div>
                                        <!-- Change this to a button or input when using this as a form -->
                                        <button class="btn btn-primary btn-block" type="submit" value="true">Login</button> 
                                    </fieldset>
                                </form>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
            <script type="text/javascript">
                $(".closealert").fadeTo(2000, 500).slideUp(500, function(){
                    $(".closealert").slideUp(500);
                });
            </script>

            <?php  

            $js = array(

                "assets/vendor/bootstrap/js/bootstrap.min.js",
                "assets/dist/js/sb-admin-2.js",
                "assets/vendor/metisMenu/metisMenu.min.js",

            );

            foreach ($js as $js) {
                echo script_tag( $js );
            }
            ?>

        </body>
        </html>