<div id="index-content" class="well-content no-search">
    <div class="content_table">
        <div class="well-content clearfix">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Jenis Bahan Bakar : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_JNS_BHN_BKR', $options_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="ID_JNS_BHN_BKR"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Status Review : </label>
                    <div class="controls">
                        <?php echo form_dropdown('VALUE_SETTING', $options_review, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : '', 'id="STATUS_REVIEW"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Depo : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_DEPO', $options_depo, !empty($default->ID_DEPO) ? $default->ID_DEPO : '', 'id="ID_DEPO"'); ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Tanggal Versioning : </label>
                    <div class="controls">
                        <?php echo form_input('PERIODE', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Awal COQ" id="PERIODE" autocomplete="off"'); ?>
                         s/d
                        <?php echo form_input('PERIODE_AKHIR', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Akhir COQ" id="PERIODE_AKHIR" autocomplete="off"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Cari : </label>
                    <div class="controls">
                        <?php echo form_input('kata_kunci', '', 'class="input-large" autocomplete="off" id="kata_kunci" placeholder="Cari Data..."'); ?>
                    </div>
                </div>
                <div class="pull-left span5">
                    <br>
                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<form action="<?=base_url()?>laporan/verifikasi_coq/export_excel" id="export_excel" method="POST">
    <input type="hidden" name="x_jnsbbm">
    <input type="hidden" name="x_status">
    <input type="hidden" name="x_cari">
    <input type="hidden" name="x_depo">
    <input type="hidden" name="x_tgl">
    <input type="hidden" name="x_tgl_akhir">
</form>

<form action="<?=base_url()?>laporan/verifikasi_coq/export_pdf" id="export_pdf" method="POST">
    <input type="hidden" name="p_jnsbbm">
    <input type="hidden" name="p_status">
    <input type="hidden" name="p_cari">
    <input type="hidden" name="p_depo">
    <input type="hidden" name="p_tgl">
    <input type="hidden" name="p_tgl_akhir">
</form>


<script type="text/javascript">

    $(document).ready(function(){
        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
        });

        $('#button-filter').click(function() {

            load_table();
        });

        $('#PERIODE').on('change', function() {


            var dateStart = $(this).val(); 
            var date = getDateEnd(dateStart);
            $('#PERIODE_AKHIR').val(date);
            setCekTgl();
        });

         $('#PERIODE_AKHIR').on('change', function() {
            setCekTgl();
        });

        $('#button-excel').click(function(){
            
            var bbm       = $('#ID_JNS_BHN_BKR').val();
            var review    = $('#STATUS_REVIEW').val();
            var cari      = $('#kata_kunci').val();
            var id_depo   = $('#ID_DEPO').val();
            var tgl       = $('#PERIODE').val();
            var tgl_akhir = $('#PERIODE_AKHIR').val();

            $('input[name="x_jnsbbm"]').val(bbm);
            $('input[name="x_status"]').val(review);
            $('input[name="x_cari"]').val(cari);
            $('input[name="x_depo"]').val(id_depo);
            $('input[name="x_tgl"]').val(tgl);
            $('input[name="x_tgl_akhir"]').val(tgl_akhir);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#export_excel').submit();
                }
            });
        })

        $('#button-pdf').click(function(){
            
            var bbm       = $('#ID_JNS_BHN_BKR').val();
            var review    = $('#STATUS_REVIEW').val();
            var cari      = $('#kata_kunci').val();
            var id_depo   = $('#ID_DEPO').val();
            var tgl       = $('#PERIODE').val();
            var tgl_akhir = $('#PERIODE_AKHIR').val();

            $('input[name="p_jnsbbm"]').val(bbm);
            $('input[name="p_status"]').val(review);
            $('input[name="p_cari"]').val(cari);
            $('input[name="p_depo"]').val(id_depo);
            $('input[name="p_tgl"]').val(tgl);
            $('input[name="p_tgl_akhir"]').val(tgl_akhir);

            bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#export_pdf').submit();
                }
            });
        })
    })

    function getDateEnd(value) {

        var d    = new Date(value),
        month    = ("0" + (d.getMonth() + 1)).slice(-2);
        day      = new Date(d.getFullYear(), d.getMonth() + 1, 0); 
        year     = d.getFullYear();
        var last = day.getDate();
        if (last.length < 2) last = '0' + last;

        return [year, month , last].join('-');

    }
    
    function setCekTgl(){
        var dateStart = $('#PERIODE').val(); 
        var dateEnd   = $('#PERIODE_AKHIR').val(); 

        if (dateEnd < dateStart){
            $('#PERIODE_AKHIR').datepicker('update', dateStart);
        }       
    }

    function load_table() {
        var vlink_url = '<?php echo base_url()?>laporan/verifikasi_coq/load_table';
        var bbm       = $('#ID_JNS_BHN_BKR').val();
        var review    = $('#STATUS_REVIEW').val();
        var id_depo   = $('#ID_DEPO').val();
        var cari      = $('#kata_kunci').val();
        var tgl       = $('#PERIODE').val();
        var tgl_akhir = $('#PERIODE_AKHIR').val();
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                p_jnsbbm    : bbm,
                p_status    : review,
                p_cari      : cari,
                p_depo      : id_depo,
                p_tgl       : tgl,
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
                $('#content_table').show();
                $('#table_content').html(data);
                bootbox.hideAll();
            }
        });
    }
    

</script>