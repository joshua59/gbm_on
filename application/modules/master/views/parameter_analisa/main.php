<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
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
                    <div id="filter"></div> 
                    <div>&nbsp;</div>

                    <div id="content_table" hidden>
                        <div class="well-content no-search">
                            <div id="table_content">
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>

        <div>&nbsp;</div>
    </div>

</div>

<div id="form-content" class="modal fade modal-xlarge"></div>

<script type="text/javascript">
    var table;

    jQuery(function($) {

        filter();
    });

    function add() {
        $('#content_form').show();
        $.ajax({
            url : "<?php echo base_url('master/parameter_analisa/add'); ?>",
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
                $('#content_table').hide();
                $('#filter').html(response);
                
            }
        });
    }
    function filter() {
        $.ajax({
            url : "<?php echo base_url('master/parameter_analisa/filter'); ?>",
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
                $('#filter').html(response);
            }
        });
    }
</script>