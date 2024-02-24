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
                <div id="content_data"></div>
                <div class="well-content clearfix" id="content_table" hidden>
                    <div id="table_content"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        load_filter();
    });

    function load_filter() {
        var vlink_url = '<?php echo base_url()?>laporan/verifikasi_coq/load_filter';
        $.ajax({
            url: vlink_url,
            type: "POST",
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
                alert('Data Gagal Proses');
            },
            success:function(data) {
                $('#content_data').html(data);
                bootbox.hideAll();
            }
        });
    }

</script>