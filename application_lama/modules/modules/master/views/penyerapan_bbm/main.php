<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.inputmask.bundle.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="well">
                    <div class="well-content clearfix">
                        <div id="filter_data">
                        </div>
                        <div id="content_data">
                        </div>
                    </div>
                </div>    
                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){

        clear_add();
        $('#button-add').click(function(){
            add();
        })
    })

    function loadFilter() {
        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/loadFilter'); ?>",
            type: 'POST',
            data: '',
            beforeSend:function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#filter_data').html(response);
            }
        });
    }


    function loadTable() {
        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/loadTable'); ?>",
            type: 'POST',
            data: '',
            beforeSend:function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#content_data').html(response);
            }
        });
    }

    function add() {
        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/add'); ?>",
            type: 'POST',
            data: '',
            beforeSend:function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#filter_data').html('');
                $('#content_data').html(response);
            }
        });
    }

    function edit(id) {
        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/edit'); ?>",
            type: 'POST',
            data: 'id='+id ,
            beforeSend:function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#filter_data').html('');
                $('#content_data').html(response);
            }
        });
    }

    function edit_add(id) {
        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/edit_add'); ?>",
            type: 'POST',
            data: 'id='+id ,
            beforeSend:function(response) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            success:function(response){
                bootbox.hideAll();
                $('#content_data').html(response);
            }
        });
    }

    function save_all() {
        var total = $('#total').val();
        if(total >= 1) {
            var vlink_url = '<?php echo base_url() ?>master/penyerapan_bbm/save_all/';
            $.ajax({
                url: vlink_url,
                type: "POST",
                beforeSend:function(data){
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                success:function(data) {
                    bootbox.hideAll();
                    var obj = JSON.parse(data);
                    if(obj[0] == true) {
                        bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>&nbsp'+obj[2]+'</div>', function() {
                                 loadTable();
                                 loadFilter();   
                        });

                    } else {
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div>', function() {});
                    }
                    
                }
            });
        } else {
            loadFilter();
            loadTable();
        }
    }

    function clear_add() {
        var vlink_url = '<?php echo base_url() ?>master/penyerapan_bbm/save_all/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            success:function(data) {
                loadTable();
                loadFilter();   
            }
        });
    }
    
</script>