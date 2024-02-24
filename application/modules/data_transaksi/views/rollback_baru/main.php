<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <input type="hidden" id="stat" value="<?php echo $notif ?>">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div class="well">
                    <div class="pull-left">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <div class="box-content">
                   <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                </div>
                <div class="well-content no-search" hidden id="con">
                    <div id="table_content"></div>
                </div>
            </div>
        </div>
    </div>
</div><br>

<script type="text/javascript">
    jQuery(function($) {

      load_table('#content_table', 1, '#ffilter');
    });

    function add() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/add';
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
                $('#content_table').html(data);
                bootbox.hideAll();
            }
        });
    }

</script>