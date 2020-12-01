<?php  
$bg = "white";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Web Title</title>
    
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>">

    <?php  

    $css = array(
        "assets/vendor/bootstrap/css/bootstrap.min.css",
        "assets/vendor/metisMenu/metisMenu.min.css",
        "assets/dist/css/sb-admin-2.css",
        "assets/vendor/font-awesome/css/font-awesome.min.css",
        "assets/vendor/morrisjs/morris.css",
    );

    foreach ($css as $css) {
        echo link_tag( $css );
    }

    echo script_tag( 'assets/vendor/jquery/jquery.min,js' );

    ?>
</head>
<body bgcolor="<?php echo $bg; ?>">

    <?php $this->load->view('front_page', $data, FALSE); ?>

</body>
</html>