<div class="login-container">
    <div class="login-header bordered">
        <h4>SIGN IN GBM ONLINE Versi <?php echo $this->laccess->version(); ?></h4>
    </div>
    <div class="alert alert-error" id="notif">Mohon Maaf, Silahkan Login Kembali</div>
    <?php
    $login_message = $this->session->flashdata('login_message');
    echo!empty($login_message) ? '<div class="alert alert-error">' . $login_message . '</div>' : '';
    echo form_open_multipart($form_action, array('id' => 'flogin'));
    ?>
    <div class="login-field">
        <label for="username">Username</label>
        <?php echo form_input('username', '', 'placeholder="Username"'); ?>
        <i class="icon-user"></i>
    </div>
    <div class="login-field">
        <label for="password">Password</label>
        <?php echo form_password('password', '', 'placeholder="Password"'); ?>
        <i class="icon-lock"></i>
    </div>
    <div class="login-button clearfix">
        <!--<label class="checkbox pull-left">
            <input type="checkbox" class="uniform" name="checkbox1"> Remember me
        </label>-->
        <button type="submit" class="pull-right btn btn-large blue">SIGN IN <i class="icon-arrow-right"></i></button>
    </div>
    <div class="forgot-password">
        <a href="#forgot-pw" role="button" data-toggle="modal">Reset Session</a>
    </div>
    <?php echo form_close(); ?>
</div>

<div id="forgot-pw" class="modal hide fade" tabindex="-1" data-width="760">
    <div class="modal-header">
        <button type="button" id="closeforgot" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
        <h3>Reset Session</h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span12">
                <div class="form_row">
                    <label class="field_name">Email address</label>
                    <div class="field">
						<?php echo form_open_multipart($form_reset, array('id' => 'login', 'class' => 'form-horizontal'), '');?> 
							<div class="row-fluid">
								<div class="span8">
									<input type="text" class="span12" name="email" id="email" placeholder="example@pln.co.id" onkeypress="return event.keyCode != 13;">
								</div>
								<div class="span4">
									<?php echo anchor(null, '<i class="icon-send"></i> Kirim', array('id' => 'button-kirim', 'class' => 'blue btn', 'onclick' => "reset_session(this.id, '#login', '')")); ?>
								</div>
							</div>
						<?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#email').bind("enterKey",function(e){
        $('#button-kirim').click();
    });
    $('#email').keyup(function(e){
        if(e.keyCode == 13){
            $(this).trigger("enterKey");
        }
    });
</script>