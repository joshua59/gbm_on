<div class="login-container">
    <div class="login-header bordered">
        <h4>UBAH PASSWORD</h4>
    </div>
    <?php
    $login_message = $this->session->flashdata('login_message');
    echo!empty($login_message) ? '<div class="alert alert-error">' . $login_message . '</div>' : '';
    echo form_open_multipart($form_action, array('id' => 'flogin'));
    ?>
    <div class="login-field">
        <label for="username">Username</label>
        <?php echo form_input('username', !empty($user_name_reset) ? $user_name_reset : '', 'placeholder="Username" readonly style="background-color:#d6dbdf"'); ?>
        <i class="icon-user"></i>
    </div>
    <div class="login-field">
        <label for="password">Password Lama</label>
        <?php echo form_password('password_old', !empty($password_reset) ? $password_reset : '', 'placeholder="Password Lama"'); ?>
        <i class="icon-lock"></i>
    </div>
    <div class="login-field">
        <label for="password">Password Baru  <span style="color:red" id='result'></span></label>
        <?php echo form_password('password_new1', '', 'placeholder="Password Baru" id="password_new1"'); ?>
        <i class="icon-lock"></i>
    </div>
    <div class="login-field">
        <label for="password">Password Baru (Konfirm)  <span style="color:red" id='result2'></span></label>
        <?php echo form_password('password_new2', '', 'placeholder="Password Baru" id="password_new2"'); ?>
        <i class="icon-lock"></i>
    </div>
    <div class="login-button clearfix">
        <!--<label class="checkbox pull-left">
            <input type="checkbox" class="uniform" name="checkbox1"> Remember me
        </label>-->
        <button type="submit" class="pull-right btn btn-large blue">Proses <i class="icon-arrow-right"></i></button>
        <button type="button" class="pull-right btn btn-large" onclick="kembali()">Kembali <i class="icon-circle-arrow-left"></i></button>
        
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.js" ></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/password_strength_metter.js" ></script>

<script type="text/javascript">
    jQuery(function($) {
        $('#password_new1').keyup(function(){
            $('#result').html(' *'+passwordStrength($('#password_new1').val(),''));
        });
        $('#password_new2').keyup(function(){
            $('#result2').html(' *'+checkMatchPass($('#password_new1').val(), $('#password_new2').val()));
        });
    });

    $('#email').bind("enterKey",function(e){
        $('#button-kirim').click();
    });

    $('#email').keyup(function(e){
        if(e.keyCode == 13){
            $(this).trigger("enterKey");
        }
    });

    function kembali(){
        window.location.href = "<?php echo base_url('login'); ?>";
    }

    function checkMatchPass(pass, konfPass){
        if(pass != konfPass){
            return "Password tidak sama";
        } else {
            return "Sesuai";
            // return '<i style="color:green" class="icon-ok"></i>';
        }
    }
</script>