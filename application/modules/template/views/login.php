<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $app_parameter['nama_aplikasi'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        echo $css_header;
        echo $js_header;
        echo $favicon;
        ?>
		<script type="text/javascript">
            var $ = jQuery;
        </script>
    </head>

<style type="text/css">
body {
    background-image:url("<?php echo base_url();?>assets/img/login_bg.png");
    background-repeat: no-repeat;
    /*background-size: 100% 100%;*/
    background-size: 100%;
}

.footerlogin {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 20px;
    padding: 0 0 0 20px;
}

</style>
    <body> 
        <!-- <img src="<?php echo base_url();?>assets/img/login_bg.png"> -->
        <?php isset($page_content) ? $this->load->view($page_content) : 'Silahkan set $data["page_content"] = ""; '; ?>

        <div class="footerlogin">
            <!-- <span class="hidden-480">&copy; ICON+</span> -->
            <span>&copy; 2017 | Supported By <a href="http://www.iconpln.co.id" target="_blank">PT INDONESIA COMNETS PLUS</a> - All Rights Reserved</span>                    
        </div>        
    </body>
</html>
