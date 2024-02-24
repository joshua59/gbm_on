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
                            <table class="table table-responsive table-striped" id="dataTable" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2">NO</th>
                                        <th rowspan="2">Parameter</th>
                                        <th rowspan="2">Satuan</th>
                                        <th rowspan="2">Metode Uji</th>
                                        <th colspan="2">Batasan SNI</th>
                                        <th rowspan="2">Jenis Bahan Bakar</th>
                                        <th rowspan="2">Referensi</th>
                                        <th rowspan="2">Nomor Referensi</th>
                                        <th rowspan="2">Tanggal Referensi</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>    
                </div>
            </div>
        </div>

        <div>&nbsp;</div>
    </div>

</div>

<div id="form-content" class="modal fade modal-xlarge"></div>
<form action="<?=base_url()?>master/coq/export_excel" id="export_excel" method="POST">
    <input type="hidden" name="x_jnsbbm">
    <input type="hidden" name="x_ref_lv1">
    <input type="hidden" name="x_ref_lv2">
    <input type="hidden" name="x_tgl">
    <input type="hidden" name="x_tglakhir">
    <input type="hidden" name="x_cari">
    <input type="hidden" name="x_namabbm">

</form>

<form action="<?=base_url()?>master/coq/export_pdf" id="export_pdf" method="POST">
    <input type="hidden" name="pdf_jnsbbm">
    <input type="hidden" name="pdf_ref_lv1">
    <input type="hidden" name="pdf_ref_lv2">
    <input type="hidden" name="pdf_tgl">
    <input type="hidden" name="pdf_tglakhir">
    <input type="hidden" name="pdf_cari">
    <input type="hidden" name="pdf_namabbm">
</form>
<script type="text/javascript">
    var table;
    var today = new Date();
    var date = new Date();
    // $('#PERIODE').val(getDateStart());
    // $('#PERIODE_AKHIR').val(getDateEnd());
    jQuery(function($) {

        filter();
    });

    function dateFormat(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month , year].join('-');
    }
    function getDateStart() {
        var d = new Date();

        var year = d.getFullYear();

        var month = d.getMonth() + 1;
        if(month <= 9)
            month = '0'+month;

        var day = 1;
        if(day <= 9)
            day = '0'+day;

        var date = year +'-'+ month +'-'+ day;
        return date;
    }
    function getDateEnd() {
        var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var month = date.getMonth() + 1;
        if(month <= 9)
            month = '0'+ month;
        var lastDayWithSlashes = (lastDay.getFullYear() + '-' + month + '-' + lastDay.getDate());

        return lastDayWithSlashes;
    }
    function setDateEnd(d) {
        if(d == '') {
            $('#PERIODE_AKHIR').val('');
        } else {
            var date = new Date(d);
            var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

            var month = date.getMonth() + 1;
            if(month <= 9)
                month = '0'+ month;
            var lastDayWithSlashes = (lastDay.getFullYear() + '-' + month + '-' + lastDay.getDate());

            $('#PERIODE_AKHIR').val(lastDayWithSlashes);
        } 
    }
    function add() {
        $('#content_form').show();
        $.ajax({
            url : "<?php echo base_url('master/coq/add'); ?>",
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
            url : "<?php echo base_url('master/coq/filter'); ?>",
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