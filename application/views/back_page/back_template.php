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

    <title>Admin Presensi QR</title>
    <link rel="stylesheet" type="text/html" href="<?php echo base_url() ?>">

    <?php  

    // echo script_tag( 'assets/swal/dist/sweetalert2.min.js' );
    echo script_tag( 'assets/swal/dist/sweetalert2.all.min.js' );

    $css = array(
        // Vendor->bootstrap
        "assets/vendor/bootstrap/css/bootstrap.min.css",
        "assets/vendor/bootstrap/css/bootstrap.css",
        // Vendor->bootstrap-social
        "assets/vendor/bootstrap-social/bootstrap-social.css",
        // Vendor->datatables
        // "assets/vendor/datatables/css/dataTables.bootstrap.css",
        // "assets/vendor/datatables/css/dataTables.bootstrap.min.css",
        // "assets/vendor/datatables/css/dataTables.bootstrap4.css",
        // "assets/vendor/datatables/css/dataTables.bootstrap4.min.css",
        // "assets/vendor/datatables/css/dataTables.foundation.css",
        // "assets/vendor/datatables/css/dataTables.jqueryui.css",
        // "assets/vendor/datatables/css/dataTables.jqueryui.min.css",
        // "assets/vendor/datatables/css/dataTables.material.css",
        // "assets/vendor/datatables/css/dataTables.material.min.css",
        // "assets/vendor/datatables/css/dataTables.semanticui.css",
        // "assets/vendor/datatables/css/dataTables.semanticui.min.css",
        "assets/vendor/datatables/css/dataTables.uikit.css",
        "assets/vendor/datatables/css/dataTables.uikit.min.css",
        // "assets/vendor/datatables/css/jquery.dataTables.css",

        // "assets/vendor/datatables/css/jquery.dataTables.min.css",

        // "assets/vendor/datatables/css/jquery.dataTables_themeroller.css",
        // Vendor->datatables-plugins
        "assets/vendor/datatables-plugins/dataTables.bootstrap.css",
        // Vendor->datatables-responsive
        "assets/vendor/datatables-responsive/dataTables.responsive.css",
        // "assets/vendor/datatables-responsive/dataTables.responsive.scss",
        // Vendor->font-awesome
        "assets/vendor/font-awesome/css/font-awesome.min.css",
        // Vendor->metisMenu
        "assets/vendor/metisMenu/metisMenu.min.css",
        // Vendor->morrisJS
        "assets/vendor/morrisjs/morris.css",
        // Dist
        "assets/dist/css/sb-admin-2.css",
        "assets/swal/dist/sweetalert2.min.css",
        // "assets/dist/css/sb-admin-2.min.css",
        
    );

    foreach ($css as $css) {
        echo link_tag( $css );
    }

    echo script_tag( 'assets/vendor/jquery/jquery.min.js' );
    echo script_tag( 'assets/tinymce/js/tinymce/tinymce.min.js' );
        

    ?>

    <script>
        tinymce.init({ 
            selector:'textarea',
            theme:'modern',
            paste_data_images: true,
            plugins: [
            "image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            // toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,
            file_picker_callback: function(callback, value, meta) {
              if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                  var file = this.files[0];
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    callback(e.target.result, {
                      alt: ''
                  });
                };
                reader.readAsDataURL(file);
            });
            }
        },
        templates: [{
          title: 'Test template 1',
          content: 'Test 1'
      }, {
          title: 'Test template 2',
          content: 'Test 2'
      }] 
  });
</script>

</head>
<body bgcolor="<?php echo $bg; ?>">

    <?php $this->load->view('back_page/library/lib_top-header',FALSE); ?>

    <?php $this->load->view('back_page/library/lib_sidebar',FALSE); ?>

    <?php echo $this->template->content ?>

    <a href="#" id="back-to-top" title="Back to top"><li class="glyphicon glyphicon-arrow-up"></li></a>

    <script type="text/javascript">
        if ($('#back-to-top').length) {
    var scrollTrigger = 500, // px
    backToTop = function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > scrollTrigger) {
            $('#back-to-top').addClass('show');
        } 
        else {
            $('#back-to-top').removeClass('show');
        }
    };

    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });

    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
</script>

<style type="text/css">
#back-to-top {
    position: fixed;
    bottom: 40px;
    right: 40px;
    z-index: 9999;
    width: 32px;
    height: 32px;
    text-align: center;
    line-height: 30px;
    background: #858585;
    color: #ffffff;
    cursor: pointer;
    border: 0;
    border-radius: 2px;
    text-decoration: none;
    transition: opacity 0.2s ease-out;
    opacity: 0;
}
#back-to-top:hover {
    background: #2D7DAD;
}
#back-to-top.show {
    opacity: 1;
}
#content {
    height: 2000px;
}
</style>

<?php  

$js = array(

        // Vendor->bootstrap
    "assets/vendor/bootstrap/js/bootstrap.min.js",
        // "assets/vendor/bootstrap/js/bootstrap.js",

        // Vendor->datatables
        // "assets/vendor/datatables/js/dataTables.bootstrap.js",
    // "assets/vendor/datatables/js/dataTables.bootstrap.min.js",
        // "assets/vendor/datatables/js/dataTables.bootstrap4.js",
    // "assets/vendor/datatables/js/dataTables.bootstrap4.min.js",
        // "assets/vendor/datatables/js/dataTables.foundation.js",
        // "assets/vendor/datatables/js/dataTables.jqueryui.js",
        // "assets/vendor/datatables/js/dataTables.jqueryui.min.js",
        // "assets/vendor/datatables/js/dataTables.material.js",
        // "assets/vendor/datatables/js/dataTables.material.min.js",
        // "assets/vendor/datatables/js/dataTables.semanticui.js",
        // "assets/vendor/datatables/js/dataTables.semanticui.min.js",
        // "assets/vendor/datatables/js/dataTables.uikit.js",
        // "assets/vendor/datatables/js/dataTables.uikit.min.js",
        // "assets/vendor/datatables/js/jquery.dataTables.js",
    "assets/vendor/datatables/js/jquery.dataTables.min.js",
        // "assets/vendor/datatables/js/jquery.js",

        // Vendor->datatables-plugins
        // "assets/vendor/datatables-plugins/dataTables.bootstrap.js",
    "assets/vendor/datatables-plugins/dataTables.bootstrap.min.js",

        // Vendor->datatables-responsive
    "assets/vendor/datatables-responsive/dataTables.responsive.js",

        // Vendor->metisMenu
    "assets/vendor/metisMenu/metisMenu.min.js",
        // "assets/vendor/metisMenu/metisMenu.js",

        // Vendor->morrisjs
    "assets/vendor/morrisjs/morris.min.js",
        // "assets/vendor/morrisjs/morris.js",

        // Vendor->raphael
    "assets/vendor/raphael/raphael.min.js",
        // "assets/vendor/raphael/raphael.js",

        // Data
    // "assets/data/morris-data.js",
        // "assets/data/flot-data.js",

        // Dist
        // "assets/dist/js/sb-admin-2.min.js",
    "assets/dist/js/sb-admin-2.js",

);

foreach ($js as $js) {
    echo script_tag( $js );
}

?>

</body>
</html>