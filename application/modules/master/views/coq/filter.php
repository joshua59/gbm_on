<div class="well">
    <div class="pull-left">
        <?php echo hgenerator::render_button_group($button_group); ?>
    </div>
</div>

<div class="well-content clearfix">
    <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
    <div class="form_row">
        <div class="pull-left span3">
            <label for="password" class="control-label">Jenis Bahan Bakar : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $options_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="bbm"'); ?>
            </div>
        </div>
        <div class="pull-left span3">
            <label for="password" class="control-label">Referensi : </label>
            <div class="controls">
                <?php echo form_dropdown('DITETAPKAN', $options_ref_lv1, !empty($default->DITETAPKAN) ? $default->DITETAPKAN : '', 'id="DITETAPKAN"'); ?>
            </div>
        </div>
        <div class="pull-left span3">
            <label for="password" class="control-label">Nomor Referensi : </label>
            <div class="controls">
                <?php echo form_dropdown('NO_VERSION', $options_ref_lv2, !empty($default->NO_VERSION) ? $default->NO_VERSION : '', 'id="NO_VERSION"'); ?>
            </div>
        </div>
    </div>
    <div class="form_row">
        <div class="pull-left span3">
            <label for="password" class="control-label">Tanggal Versioning : </label>
            <div class="controls">
                <?php echo form_input('PERIODE', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Awal" id="PERIODE" autocomplete="off"'); ?>
                 s/d
                <?php echo form_input('PERIODE_AKHIR', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Akhir" id="PERIODE_AKHIR" autocomplete="off"'); ?>
            </div>
        </div>
        <div class="pull-left span3">
            <label for="password" class="control-label">Cari : </label>
            <div class="controls">
                <?php echo form_input('kata_kunci', '', 'class="input" autocomplete="off" id="kata_kunci"'); ?>
                <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
            </div>
           
        </div>

        <div class="pull-left span5">
            <label for="password" class="control-label"></label>
            <div class="controls">
                <?php echo anchor(NULL, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                <?php echo anchor(NULL, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
            </div>
           
        </div>
    </div><br/>
    
<?php echo form_close(); ?>
</div>

<script type="text/javascript">

    function edit(id) {
        var datana = 'id='+id;
            $.ajax({
                
                url: "<?php echo base_url() ?>master/coq/edit",
                type: "POST",
                data: datana,
                beforeSend: function() {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    bootbox.hideAll();
                   alert('Proses pengambilan data gagal !')
                },
                success: function (res) {
                    bootbox.hideAll();
                    $('#content_table').hide();
                    $('#filter').html(res);
                },
            });
    }

    function row_delete(id) {

        var message = '';

        bootbox.setBtnClasses({
            CANCEL: '',
            CONFIRM: 'red'
        });
        var conf_message = 'Anda yakin akan menghapus data?';
        bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
            if(e) {
                var datana = 'id='+id;
                $.ajax({
                    
                    url: "<?php echo base_url() ?>master/coq/delete",
                    type: "POST",
                    data: datana,
                    beforeSend: function() {
                        bootbox.modal('<div class="loading-progress"></div>');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var icon = 'icon-remove-sign';
                        var color = '#ac193d;';
                        bootbox.alert('<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + 'Proses hapus data gagal !.' + '</div>', function() {
                            bootbox.hideAll();
                            table_load();
                        })
                    },
                    success: function (res) {
                        bootbox.alert('<div class="box-title" style="color:#0072c6"><i class="icon-ok-sign"></i> ' + 'Proses hapus data berhasil !.' + '</div>', function() {
                            bootbox.hideAll();
                            table_load();
                            
                        })
                    },
                });
            }
            

           
        })
    }
    
    function table_load(){
        
        $('#content_table').show();
        var jnsbbm = $('#bbm').val();
        var ref1 = $('#DITETAPKAN').val();
        var ref2 = $('#NO_VERSION').val();
        var tgl = $('#PERIODE').val();
        var tglakhir = $('#PERIODE_AKHIR').val();
        var cari = $('#kata_kunci').val();
        var vlink_url = '<?php echo base_url()?>master/coq/load/';
        if (table != null){
            table.destroy();
        }
        table = $('#dataTable').DataTable({
            "order": [],
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "ordering": false,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
                'loadingRecords': '&nbsp;',
                "processing": "<div class='loading-progress' style='color:#ac193d;'></div>",
            },
            "columnDefs": [
                {
                   "className": "dt-center",
                   "targets": [0,2,3,4,5,6,7,8,9]
                },
                {
                   "className": "dt-left",
                   "targets": [1]
                }
            ],
            "ajax": {
                "url": vlink_url,
                "type": "POST",
                "data": {
                    p_jnsbbm : jnsbbm,
                    p_ref_lv1 : ref1,
                    p_ref_lv2 : ref2,
                    p_tgl : tgl,
                    p_tglakhir : tglakhir,
                    p_cari : cari
                }
            }
        });
    }

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left",
        beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
    });

    function setCekTgl(){
        var dateStart = $('#PERIODE').val(); 
        var dateEnd   = $('#PERIODE_AKHIR').val(); 

        if (dateEnd < dateStart){
            $('#PERIODE_AKHIR').datepicker('update', dateStart);
        }       
    }

    $('#PERIODE').on('change', function() {
        var dateStart = $(this).val(); 
        var dateEnd = setDateEnd(dateStart);
        $('#PERIODE_AKHIR').datepicker('setEndDate', dateEnd);
    });

    $('#button-filter').click(function(){
        table_load();
    })

    $('#button-excel').click(function(){
        var jnsbbm   = $('#bbm').val();
        var ref1     = $('#DITETAPKAN').val();
        var ref2     = $('#NO_VERSION').val();
        var tgl      = $('#PERIODE').val();
        var tglakhir = $('#PERIODE_AKHIR').val();
        var cari     = $('#kata_kunci').val();
        var nama_bbm = $('#bbm option:selected').text();

        $('input[name="x_jnsbbm"]').val(jnsbbm);
        $('input[name="x_ref_lv1"]').val(ref1);
        $('input[name="x_ref_lv2"]').val(ref2);
        $('input[name="x_tgl"]').val(tgl);
        $('input[name="x_tglakhir"]').val(tglakhir);
        $('input[name="x_cari"]').val(cari);
        $('input[name="x_namabbm"]').val(nama_bbm);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_excel').submit();
            }
        });
    })

    $('#button-pdf').click(function(){
        var jnsbbm   = $('#bbm').val();
        var ref1     = $('#DITETAPKAN').val();
        var ref2     = $('#NO_VERSION').val();
        var tgl      = $('#PERIODE').val();
        var tglakhir = $('#PERIODE_AKHIR').val();
        var cari     = $('#kata_kunci').val();
        var nama_bbm = $('#bbm option:selected').text();

        $('input[name="pdf_jnsbbm"]').val(jnsbbm);
        $('input[name="pdf_ref_lv1"]').val(ref1);
        $('input[name="pdf_ref_lv2"]').val(ref2);
        $('input[name="pdf_tgl"]').val(tgl);
        $('input[name="pdf_tglakhir"]').val(tglakhir);
        $('input[name="pdf_cari"]').val(cari);
        $('input[name="pdf_namabbm"]').val(nama_bbm);

        bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_pdf').submit();
            }
        });
    })
</script>