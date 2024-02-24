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
                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>
                    <div class="well">
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
                                    <label for="password" class="control-label">Tanggal Versioning : </label>
                                    <div class="controls">
                                        <?php echo form_input('PERIODE', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Awal" id="PERIODE"'); ?>
                                         s/d
                                        <?php echo form_input('PERIODE_AKHIR', '', 'class="span5 input-append date form_datetime" placeholder="Tanggal Akhir" id="PERIODE_AKHIR"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Cari : </label>
                                    <div class="controls">
                                        <?php echo form_input('kata_kunci', '', 'class="input" autocomplete="off" id="kata_kunci"'); ?>
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form_row">
                                <div class="pull-left span3">
                                   
                                </div>
                                <div class="pull-left span3">
                                  
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
                    </div> 
                    <div id="content_table">
                        <table class="table table-responsive table-striped" id="dataTable" width="100%" style="display: none">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Jenis BBM</th>
                                    <th>No Versioning</th>
                                    <th>Tanggal Versioning</th>
                                    <th>Ditetapkan oleh</th>
                                    <th>Pejabat Terkait</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="modal fade modal-xlarge"></div>
            </div>
        </div>
    </div>
</div>
<form action="<?php echo base_url()?>master/coq_versioning/export_excel" method="POST" id="export_excel">
    <input type="hidden" name="x_jnsbbm">
    <input type="hidden" name="x_tglawal">
    <input type="hidden" name="x_tglakhir">
    <input type="hidden" name="x_cari">
</form>

<form action="<?php echo base_url()?>master/coq_versioning/export_pdf" method="POST" id="export_pdf">
    <input type="hidden" name="pdf_jnsbbm">
    <input type="hidden" name="pdf_tglawal">
    <input type="hidden" name="pdf_tglakhir">
    <input type="hidden" name="pdf_cari">
</form>
<script type="text/javascript">
    var table;
    var today = new Date();
    jQuery(function($) {

        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
        });
 
        function setCekTgl(){
            var dateStart = $('#PERIODE').val(); 
            var dateEnd = $('#PERIODE_AKHIR').val(); 

            if (dateEnd < dateStart){
                $('#PERIODE_AKHIR').datepicker('update', dateStart);
            }       
        }

        $('#PERIODE').on('change', function() {
            var dateStart = $(this).val(); 
            var dateEnd = setDateEnd(dateStart);
            $('#PERIODE_AKHIR').datepicker('setStartDate', dateEnd);
        });

        $('#PERIODE_AKHIR').on('change', function() {
            if($('#PERIODE').val() == '' || $('#PERIODE') == null) {
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Tanggal Awal tidak boleh kosong !</div>';
                bootbox.alert(message, function() {});
                $('#PERIODE_AKHIR').val('');
            } else {
                setCekTgl();
            }
            
        });

        $('#button-excel').click(function(){

            var jnsbbm = $('#bbm').val();
            var tglawal = $('#PERIODE').val();
            var tglakhir = $('#PERIODE_AKHIR').val();
            var cari = $('#kata_kunci').val();

            $('input[name="x_jnsbbm"]').val(jnsbbm);
            $('input[name="x_tglawal"]').val(tglawal);
            $('input[name="x_tglakhir"]').val(tglakhir);
            $('input[name="x_cari"]').val(cari);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#export_excel').submit();
                }
            });
        })

        $('#button-pdf').click(function(){

            var jnsbbm = $('#bbm').val();
            var tglawal = $('#PERIODE').val();
            var tglakhir = $('#PERIODE_AKHIR').val();
            var cari = $('#kata_kunci').val();

            $('input[name="pdf_jnsbbm"]').val(jnsbbm);
            $('input[name="pdf_tglawal"]').val(tglawal);
            $('input[name="pdf_tglakhir"]').val(tglakhir);
            $('input[name="pdf_cari"]').val(cari);

            bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#export_pdf').submit();
                }
            });
        })

        $('#button-filter').click(function(){
            table_load();
        })

        
    });

    function table_load(){
        
        $('#dataTable').show();
        var jnsbbm = $('#bbm').val();
        var tglawal = $('#PERIODE').val();
        var tglakhir = $('#PERIODE_AKHIR').val();
        var cari = $('#kata_kunci').val();
        var vlink_url = '<?php echo base_url()?>master/coq_versioning/load/';
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
                   "targets": [0,1,2,3,4,5,6,7]
                }
            ],
            "ajax": {
                "url": vlink_url,
                "type": "POST",
                "data": {
                    p_jnsbbm : jnsbbm,
                    p_tglawal : tglawal,
                    p_tglakhir : tglakhir,
                    p_cari : cari
                }
            }
        });
    }
    
    function close_modal() {
        $('.modal').modal('hide');
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

    function row_delete(id) {

        var message = '';

        bootbox.setBtnClasses({
            CANCEL: '',
            CONFIRM: 'red'
        });
        var conf_message = 'Anda yakin akan menyimpan data?';
        bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
            if(e) {
                var datana = 'id='+id;
                $.ajax({
                    
                    url: "<?php echo base_url() ?>master/coq_versioning/delete",
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
</script>