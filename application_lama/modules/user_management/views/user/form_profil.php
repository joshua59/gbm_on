<style type="text/css">
    .bold{
        font-weight: bold;
        width: 20%;
    }
    hr { margin-top: 10px; margin-bottom: 10px }
</style>
<!--  -->
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div class="well-content no-search">
                    <h3><i class="icon-users"></i> User Profile</h3>
                    <br>
                    <div class="form_row">
                        <div class="pull-left span6">
                            <h5><b>NIP</b></h5>
                            <hr>
                            <?php echo $default->KD_USER; ?>
                            <br>
                            <br>

                            <h5><b>Nama</b></h5>
                            <hr>
                            <?php echo $default->NAMA_USER; ?>
                            <br>
                            <br>

                            <h5><b>Username</b></h5>
                            <hr>
                            <?php echo $default->USERNAME; ?>
                            <br>
                            <br>  
                            <h5><b>E-mail</b></h5>
                            <hr>
                            <?php echo $default->EMAIL_USER; ?>
                            <br>
                            <br>
                        </div>
                        <div class="pull-left span6">
                            <h5><b>Level User</b></h5>
                            <hr>
                            <?php echo $level; ?>
                            <br>
                            <br>
                            <h5><b>Role User</b></h5>
                            <hr>
                            <?php echo $default->ROLES_NAMA; ?>
                            <br>
                            <br>
                            <h5><b>Unit</b></h5>
                            <hr>
                            <?php echo $nama_unit; ?>
                            <br>
                            <br>
                        </div>
                    </div>
                    <br/>
                </div>
            </div> 
        </div>
    </div>
</div>

<script type="text/javascript">
$(function(){
    $('.chosen').chosen();
})
</script>