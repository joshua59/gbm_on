<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
<div class="inner_content">
    <input type="hidden" id="stat" value="<?php echo $notif ?>">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id="content_data">
                </div>
                <div id="con"></div>
            </div>
        </div>
    </div>
</div><br>

<script type="text/javascript">
    jQuery(function($) {

        var stat = $("#stat").val();
        if(stat == 7) {
            load_filter();
            load_table();
            
        } else {
            load_filter();
        }
        
    });

    function load_filter() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/verifikasi_coq/load_filter';
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

    function load_table() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/verifikasi_coq/load_table';
        var bbm = $('#ID_JNS_BHN_BKR').val();
        var cari = $('#kata_kunci').val();
        var id_depo = $('#ID_DEPO').val();
        var tgl = $('#PERIODE').val();
        var tgl_akhir = $('#PERIODE_AKHIR').val();
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                p_jnsbbm : bbm,
                p_cari : cari,
                p_depo : id_depo,
                p_tgl : tgl,
                p_tgl_akhir : tgl_akhir
            },
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
                alert('Data Gagal Proses');
            },
            success:function(data) {
                $('#table_content').html(data);
                bootbox.hideAll();
            }
        });
    }

</script>