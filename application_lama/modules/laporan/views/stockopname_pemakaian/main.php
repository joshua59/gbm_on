
<!-- /**
 * @module PERHITUNGAN HARGA
 * @author  CF
 * @created at 11 JULI 2018
 * @modified at 11 JULI 2018
 */ -->

<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>

<style type="text/css">

    .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    }     

    input[type=text]:-moz-read-only { /* For Firefox */
        background: white;
        color: #5F5F5F;
    }
    input[type=text]:read-only {
        background: white;
        color: #5F5F5F;
    }    
</style>


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/library/leaflet.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/library/maps/leaflet.js"></script>

<style>
   #map{
       width:100%;
       height:100%;
       position:absolute;
   }
</style>

 <div class="inner_content" id="div_atas">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content">
                    <div class="box-title">
                        Pencarian
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter-cari')); ?>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Pembangkit : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC_CARI', $lv4_options_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_cari" class="chosen span11"'); ?>
                                    </div>                                    
                                </div>
                                <div class="pull-left span2">
                                    <label for="password" class="control-label">Jenis Bahan Bakar :</label>
                                    <div class="controls">
                                        <?php echo form_dropdown('JNS_BBM', $options_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="bbm" class="chosen span11"'); ?>                                     
                                    </div>
                                </div>
                                <div class="pull-left span5">
                                    <label for="password" class="control-label">Periode <span class="required">*</span> : </label>
                                    <label for="password" class="control-label" style="margin-left:38px"></label>
                                    <div class="controls">
                                        <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 210px;" placeholder="Tanggal awal" id="tglawal" autocomplete="off"'); ?>
                                        <label for="">s/d</label>
                                        <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 210px;" placeholder="Tanggal akhir" id="tglakhir" autocomplete="off"'); ?>                                        
                                    </div>

                                    <br>
                                    <div class="controls">
                                        <label for="password" class="control-label">Tanggal Stock Opname Akhir <span class="required">*</span> : </label>
                                        <?php echo form_dropdown('PERIODE', $options_periode, !empty($default->ID_STOCKOPNAME) ? $default->ID_STOCKOPNAME : '', 'id="periode" style="width: 440px;" class="span6"'); ?>
                                        <!-- <label for="">s/d</label> -->
                                        <input type="hidden" name="" id="periode_akhir">
                                        <input type="hidden" name="" id="periode_akhir_nama" style="width: 440px;">
                                        <!-- <?php echo form_dropdown('PERIODE', $options_periode, !empty($default->ID_STOCKOPNAME) ? $default->ID_STOCKOPNAME : '', 'id="periode_akhir" style="width: 210px;" class="span6"'); ?> -->
                                    </div>
                                </div>
                                <div class="pull-left span2">
                                    <label></label>
                                    
                                    <br>
                                    <div class="controls">
                                        <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Cari Periode", array('class' => 'btn green', 'id' => 'button-cari-periode')); ?>&nbsp;
                                        <br>
                                        <br>
                                        <br>
                                        <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Cari Data", array('class' => 'btn yellow', 'id' => 'button-filter-cari')); ?>&nbsp;<br>
                                    </div>                                
                                </div> 
                               
                            </div>
                            <div id="divData"></div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>                    
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                            <div class="form_row">
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Regional : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0" class="span11" disabled style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 1 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" class="span11" disabled style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 2 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2" class="span11" disabled style="color:black;"'); ?>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="form_row">
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 3 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3" class="span11" disabled style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Pembangkit : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4" class="span11" disabled style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label></label>                                    
                                    <div class="controls">
                                        <?php echo anchor(NULL, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'btn-excel')); ?>&nbsp;
                                        <?php echo anchor(NULL, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'btn-pdf')); ?>

                                    </div>
                                </div>                                
                            </div>
                            <div id="divData"></div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>

                </div>
            </div>            
        </div>    
        <!-- <div id="divData"></div>     -->
        <br>        
        <div class="row-fluid">
            <div class="span12">
                <div id ="content_table" class="well-content no-search" hidden>
                    <div class="box-title">
                        Data Stok Pembangkit
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">                            
                            <div class="form-row">
                                <div class="span6">
                                    <table class="table table-striped">
                                        <tr>
                                            <td width="65%" id="volume_awal_text"></td>
                                            <td>:</td>
                                            <td id="volume_awal" style="text-align: right;"></td>
                                        </tr>
                                        <tr>
                                            <td width="65%">Total Volume Penerimaan (Pemasok + Unit Lain)</td>
                                            <td>:</td>
                                            <td id="volume_terima" style="text-align: right;"></td>
                                        </tr>
                                        <tr>
                                            <td width="65%">Total Volume Pemakaian (Sendiri)</td>
                                            <td>:</td>
                                            <td id="total_pemakaian" style="text-align: right;"></td>
                                        </tr>
                                        <tr>
                                            <td width="65%">Stock Akhir</td>
                                            <td>:</td>
                                            <td id="stok_akhir" style="text-align: right;"></td>
                                        </tr>
                                        <tr>
                                            <td width="65%" id="volume_akhir_text"></td>
                                            <td>:</td>
                                            <td id="stok_akhir_ba" style="text-align: right;"></td>
                                        </tr>
                                        <tr>
                                            <td width="65%">Pemakaian Total Berdasarkan Stock Opname</td>
                                            <td>:</td>
                                            <td id="pemakaian_total_ba" style="text-align: right;"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="span6">
                                    <table class="display" id="table_pemakaian">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">Tanggal Pengakuan</th>
                                                <th style="text-align: center;">Volume Pemakaian (L)</th>
                                                <th style="text-align: center;">Volume Pemakaian Harian <br>Berdasarkan Stock Opname (BA) (L)</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            
                        </div>
                    </div>           
                    <br><br>
                </div>
            </div>
        </div>
        <br><br>        

        

    </div>
</div><br>


<form action="<?php echo base_url()?>laporan/stockopname_pemakaian/export_excel" method="POST" id="form-excel">
    <input type="hidden" name="x_lvl4">
    <input type="hidden" name="x_tglawal">
    <input type="hidden" name="x_tglakhir">
    <input type="hidden" name="x_lvl4_nama">
    <input type="hidden" name="x_volume_awal">
    <input type="hidden" name="x_volume_terima">
    <input type="hidden" name="x_total_pemakaian">
    <input type="hidden" name="x_stok_akhir">
    <input type="hidden" name="x_stok_akhir_ba">
    <input type="hidden" name="x_pemakaian_total_ba">
    <input type="hidden" name="x_ba_awal">
    <input type="hidden" name="x_ba_akhir">
    <input type="hidden" name="x_bbm">
    <input type="hidden" name="x_bbm_nama">
</form>

<form action="<?php echo base_url()?>laporan/stockopname_pemakaian/export_pdf" method="POST" id="form-pdf">
    <input type="hidden" name="p_lvl4">
    <input type="hidden" name="p_tglawal">
    <input type="hidden" name="p_tglakhir">
    <input type="hidden" name="p_lvl4_nama">
    <input type="hidden" name="p_volume_awal">
    <input type="hidden" name="p_volume_terima">
    <input type="hidden" name="p_total_pemakaian">
    <input type="hidden" name="p_stok_akhir">
    <input type="hidden" name="p_stok_akhir_ba">
    <input type="hidden" name="p_pemakaian_total_ba">
    <input type="hidden" name="p_ba_awal">
    <input type="hidden" name="p_ba_akhir">
    <input type="hidden" name="p_bbm">
    <input type="hidden" name="p_bbm_nama">
</form>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;'; 

    $('.chosen').chosen(); 
    setDefaultPeriode();
    setDefaultPeriodeAkhir();
    $('#SLOC_CARI').val("");
    $(document).ready(function() {
        var t = $('#table_pemakaian').dataTable({
            "scrollY": "285px",
            "scrollX": true,            
            "scrollCollapse": true,
            "bPaginate": false,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": false,
            "ordering": false,
            "lengthMenu": [[10, 20, -1], [10, 20, "All"]],
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": [0,1]},
                {"className": "dt-right","targets": [2,3]},
            ]
        });

        $(".form_datetime").datepicker({
            format: 'yyyy-mm-dd', 
            autoclose:true,
            todayBtn: true,
            endDate : new Date(),
            pickerPosition: "bottom-left"
        });

        $('#btn-excel').click(function(){
            $('input[name="x_lvl4"]').val($('#lvl4_cari').val());
            $('input[name="x_lvl4_nama"]').val($('#lvl4_cari option:selected').text());
            $('input[name="x_bbm_nama"]').val($('#bbm option:selected').text());
            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#form-excel').submit();
                }
            });
        })

        $('#btn-pdf').click(function(){
            $('input[name="p_lvl4"]').val($('#lvl4_cari').val());
            $('input[name="p_lvl4_nama"]').val($('#lvl4_cari option:selected').text());
            $('input[name="p_bbm_nama"]').val($('#bbm option:selected').text());
            bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#form-pdf').submit();
                }
            });
        })

    });   
    

    function convertToRupiah(angka){
        var bilangan = angka.replace(".", ",");

        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        return rupiah;
    }    

   
    function setComboDefault(_id,_unit,_nama){
        if ($(_id+' option').size() <= 1){
            $(_id).empty();
            $(_id).append('<option value='+_unit+'>'+_nama+'</option>');
        } else {
            $(_id).val(_unit);
        }                   
        $(_id).data("placeholder","Select").trigger('liszt:updated');
    }

    function get_data_unit(sloc,sloc_cari){
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('laporan/stockopname_pemakaian/get_data_unit'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_unit gagal');                
            },            
            success:function(data) {      
                $.each(data, function () {
                    setComboDefault('#lvl0',this.ID_REGIONAL,this.LEVEL1);
                    setComboDefault('#lvl1',this.COCODE,this.LEVEL1);
                    setComboDefault('#lvl2',this.PLANT,this.LEVEL2);
                    setComboDefault('#lvl3',this.STORE_SLOC,this.LEVEL3);
                    if (sloc_cari){
                        setComboDefault('#lvl4',this.SLOC,this.LEVEL4);    
                    }
                    bootbox.hideAll();
                });             
                
            }
        });    
    }

    $('#button-filter-cari').click(function() {
        var sloc          = $('#lvl4_cari').val();
        var dateStart     = $('#tglawal').val();
        var dateEnd       = $('#tglakhir').val();
        var periode       = $('#periode').val();
        var periode_akhir = $('#periode_akhir').val();
        var bbm           = $('#bbm').val();
        if (sloc == '') {            
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});     
        } else if(dateStart == ''){
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal Awal harus di isi-- </div>', function() {});
        } else if(dateEnd == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal Akhir harus di isi-- </div>', function() {});
        } else if(periode == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --BA Stock Opname harus di pilih-- </div>', function() {});
        } else if(periode_akhir == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --BA Stock Opname akhir harus di pilih-- </div>', function() {});
        } else if(bbm == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Jenis Bahan Bakar harus di pilih-- </div>', function() {});
        } else {
            get_data(sloc,periode,periode_akhir,bbm);
        }
    }); 

    $('#button-cari-periode').click(function() {
        var sloc = $('#lvl4_cari').val();
        var dateStart = $('#tglawal').val();
        var dateEnd   = $('#tglakhir').val();
        var bbm   = $('#bbm').val();
        if(sloc == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});    
        } else if(dateStart == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal Awal harus di isi-- </div>', function() {});
        } else if(dateEnd == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal Akhir harus di isi-- </div>', function() {});
        } else if(bbm == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Jenis Bahan Bakar harus di isi-- </div>', function() {});
        } else {
           get_periode(sloc,dateStart,dateEnd,bbm); 
        }
    });  

    function get_data(sloc,periode_awal,periode_akhir,bbm){
        
        var vol_awal = $('#periode_akhir_nama').val();
        // var vol_awal = $('#periode option:selected').text();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('laporan/stockopname_pemakaian/get_data'); ?>",                
            data: { 

                "periode_awal": periode_awal,
                "periode_akhir": periode_akhir,
                "BBM": bbm
            },
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data gagal');
            },            
            success:function(data) {
                var obj = data.VOLUME;
                if(obj.length == 2) {
                    var volume_awal = obj[0].VOLUME_STOCKOPNAME;
                    var volume_akhir = obj[1].VOLUME_STOCKOPNAME;

                    var tgl_awal = obj[0].TGL_PENGAKUAN;
                    var tgl_akhir = obj[1].TGL_PENGAKUAN;

                    $('input[name="x_tglawal"]').val(tgl_awal);
                    $('input[name="p_tglawal"]').val(tgl_awal);

                    $('input[name="x_bbm"]').val(bbm);
                    $('input[name="p_bbm"]').val(bbm);

                    $('input[name="x_tglakhir"]').val(tgl_akhir);
                    $('input[name="p_tglakhir"]').val(tgl_akhir);
                    $('#volume_awal_text').text('Volume Stock Awal ('+vol_awal+')');
                    $('input[name="x_ba_awal"]').val(vol_awal);
                    $('input[name="p_ba_awal"]').val(vol_awal);

                    $('#volume_awal').text(convertToRupiah(volume_awal)+' L');
                    $('input[name="x_volume_awal"]').val(volume_awal);
                    $('input[name="p_volume_awal"]').val(volume_awal);
                    
                    get_volume_terima(sloc,tgl_awal,tgl_akhir,volume_awal,volume_akhir,bbm);
                    $('html, body').animate({scrollTop: $("#divData").offset().top}, 1000);
                    bootbox.hideAll();
                } else {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data stock opname awal tidak ditemukan-- </div>', function() {
                        bootbox.hideAll();
                    });  
                }                                                           
            }
        });
    }; 

    function get_volume_terima(sloc,tgl_awal,tgl_akhir,volume_awal,volume_akhir,bbm){
        
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('laporan/stockopname_pemakaian/get_volume_terima'); ?>",                
            data: { 

                "SLOC": sloc,
                "TGL_AWAL": tgl_awal,
                "TGL_AKHIR": tgl_akhir,
                "BBM": bbm
            },
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data gagal');
            },            
            success:function(data) {

                if(data[0].VOLUME_TERIMA == null) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Penerimaan tidak ditemukan-- </div>', function() {
                        bootbox.hideAll();
                    }); 
                } else {
                    $('#volume_terima').text(convertToRupiah(data[0].VOLUME_TERIMA)+' L');

                    $('input[name="x_volume_terima"]').val(data[0].VOLUME_TERIMA);
                    $('input[name="p_volume_terima"]').val(data[0].VOLUME_TERIMA);
                    var volume_terima = data[0].VOLUME_TERIMA;
                    get_pemakaian_total(sloc,tgl_awal,tgl_akhir,volume_awal,volume_terima,volume_akhir,bbm);
                    bootbox.hideAll();
                }
                
            }
        });
    };

    function get_pemakaian_total(sloc,tgl_awal,tgl_akhir,volume_awal,volume_terima,volume_akhir,bbm){
        
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('laporan/stockopname_pemakaian/get_pemakaian_total'); ?>",                
            data: { 

                "SLOC": sloc,
                "TGL_AWAL": tgl_awal,
                "TGL_AKHIR": tgl_akhir,
                "BBM": bbm
            },
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data gagal');
            },            
            success:function(data) {

                if(data[0].TOTAL_PEMAKAIAN == null) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Penerimaan tidak ditemukan-- </div>', function() {
                        bootbox.hideAll();
                    }); 
                } else {
                    $('#total_pemakaian').text(convertToRupiah(data[0].TOTAL_PEMAKAIAN)+' L');
                    $('input[name="x_total_pemakaian"]').val(data[0].TOTAL_PEMAKAIAN);
                    $('input[name="p_total_pemakaian"]').val(data[0].TOTAL_PEMAKAIAN);
                    var total_pemakaian = data[0].TOTAL_PEMAKAIAN;
                    jumlah(sloc,tgl_awal,tgl_akhir,volume_awal,volume_terima,total_pemakaian,volume_akhir,bbm);
                }
               
                
            }
        });
    };

    function jumlah(sloc,tgl_awal,tgl_akhir,volume_awal,volume_terima,total_pemakaian,volume_akhir,bbm){
        // var vol_akhir = $('#periode_akhir option:selected').text();
        var vol_akhir = $('#periode option:selected').text();
        // Nilai Stok
        var stok_akhir = parseFloat(volume_awal) + parseFloat(volume_terima) - parseFloat(total_pemakaian);
        var nilai_stok = stok_akhir.toFixed(2).toString();
        $('#stok_akhir').text(convertToRupiah(nilai_stok)+' L');
        $('input[name="x_stok_akhir"]').val(nilai_stok);
        $('input[name="p_stok_akhir"]').val(nilai_stok);

        // Nilai Stok (BA)
        var nilai_stok_ba = convertToRupiah(volume_akhir);
        $('#stok_akhir_ba').text(nilai_stok_ba+' L');
        $('input[name="x_stok_akhir_ba"]').val(volume_akhir);
        $('input[name="p_stok_akhir_ba"]').val(volume_akhir);
        $('#volume_akhir_text').text('Volume Stock Akhir Berdasarkan BA ('+vol_akhir+')');

        //Nilai Pemakaian (BA)
        var pemakaian_ba = parseFloat(volume_awal) + parseFloat(volume_terima) - parseFloat(volume_akhir);
        var nilai_pemakaian_ba = pemakaian_ba.toFixed(2).toString();
        $('#pemakaian_total_ba').text(convertToRupiah(nilai_pemakaian_ba)+' L');
        $('input[name="x_pemakaian_total_ba"]').val(nilai_pemakaian_ba);
        $('input[name="p_pemakaian_total_ba"]').val(nilai_pemakaian_ba);

        $('input[name="x_ba_akhir"]').val(vol_akhir);
        $('input[name="p_ba_akhir"]').val(vol_akhir);
        get_pemakaian(sloc,tgl_awal,tgl_akhir,total_pemakaian,nilai_pemakaian_ba,bbm);
    }

    function get_pemakaian(sloc,tgl_awal,tgl_akhir,total_pemakaian,nilai_pemakaian_ba,bbm){
        var t = $('#table_pemakaian').DataTable();
        t.clear().draw();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('laporan/stockopname_pemakaian/get_pemakaian'); ?>",                
            data: { 
                "SLOC": sloc,
                "TGL_AWAL": tgl_awal,
                "TGL_AKHIR": tgl_akhir,
                "TOTAL_PEMAKAIAN": total_pemakaian,
                "NILAI_STOK_BA": nilai_pemakaian_ba,
                "BBM": bbm
            },
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data gagal');
            },            
            success:function(data) {
                $.each(data,function(x,y){
                    var no = x+1;
                    var tanggal_pengakuan = y.TGL_MUTASI_PENGAKUAN;
                    var volume_pemakaian = y.VOLUME_PEMAKAIAN;
                    var volume_penyesuaian = y.VOLUME_PENYESUAIAN;
                    var fixed = parseFloat(volume_penyesuaian).toFixed(2);

                    t.row.add([no,tanggal_pengakuan,convertToRupiah(volume_pemakaian),convertToRupiah(fixed)]).draw( false );
                })

                bootbox.hideAll();
                $('#content_table').show();
            }
        });
    };

    $('#button-reset').click(function(){
        bootbox.confirm('Anda yakin akan Reset Pencarian ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#ffilter-cari')[0].reset();                
                setDefaultCombo();
            }
        });
    }); 


    // filter combo
    function setDefaultPeriode() {
        $('#periode').empty();
        $('#periode').append('<option value="">--Pilih Tanggal Opname--</option>');
    }

    function setDefaultPeriodeAkhir() {
        $('#periode_akhir').empty();
        $('#periode_akhir').append('<option value="">--Pilih Tanggal Opname--</option>');
    }
    function setDefaultCombo(){
        var _level = "<?php echo $this->session->userdata('level_user');?>";    
        var _kode_level = "<?php echo $this->session->userdata('kode_level');?>";

        $("select").trigger("liszt:updated");

        if (_level==1){
            $('#lvl3').empty();
            $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
            $('#lvl3').data("placeholder","Select").trigger('liszt:updated');                                    
        }

        if (_level==0){            
            if ((_kode_level=='')||(_kode_level==0)){
                $('#lvl0').val('');
                $('#lvl0').data("placeholder","Select").trigger('liszt:updated');
                $('#lvl0').change(); 
            }           
        } else {
            get_options_lv4_all($('#lvl'+_level).val());  
            get_options_lv4_all_Q($('#lvl'+_level).val());  
        }     
    }

    function setDefaultLv1(){
        $('#lvl1').empty();
        $('#lvl1').append('<option value="">--Pilih Level 1--</option>');
        $('#lvl1').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv2(){
        $('#lvl2').empty();
        $('#lvl2').append('<option value="">--Pilih Level 2--</option>');
        $('#lvl2').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv3(){
        $('#lvl3').empty();
        $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
        $('#lvl3').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv4(){
        $('#lvl4').empty();
        $('#lvl4').append('<option value="">--Pilih Pembangkit--</option>');
        $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
    }

    $('#lvl0').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();

        if (stateID==''){
            vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_options_lv4/all';    
        }
        // if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                if (stateID==''){
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                } else {
                  $.each(data, function(key, value) {
                      $('#lvl1').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                  });
                  get_options_lv4_all(stateID);
                }

                // bootbox.hideAll();
              }
          });
        // }                
    });

    $('#lvl1').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl2').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                  });
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl2').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl3').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                  });
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl3').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    }); 

    function get_options_lv4_all(unit) {        
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/options_lv4_all/'+unit;
        setDefaultLv4();
        if(unit) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    };    

    function get_options_lv4_all_Q(unit) {        
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/options_lv4_all/'+unit;
        $('#lvl4_cari').empty();
        $('#lvl4_cari').append('<option value="">--Pilih Pembangkit--</option>');
        $('#lvl4_cari').data("placeholder","Select").trigger('liszt:updated');
        if(unit) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4_cari').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4_cari').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    }; 

    function get_periode(sloc,tgl_awal,tgl_akhir,bbm) {
      
        var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_periode/';
        setDefaultPeriode();
        
        $.ajax({
            url: vlink_url,
            type: "POST",
            dataType: "json",
            data : {
                "sloc" : sloc,
                "tgl_awal" : tgl_awal,
                "tgl_akhir" : tgl_akhir,
                "bbm" : bbm
            },
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -Proses Gagal-- </div>', function() {
                    bootbox.hideAll();
                }); 
            },
            success:function(data) {

                $.each(data, function(key, value) {
                $('#periode').append('<option value="'+ value.ID_STOCKOPNAME +'">'+ value.NO_STOCKOPNAME +' - '+value.TGL_PENGAKUAN+'</option>');
                });
                $('#periode').data("placeholder","Select").trigger('liszt:updated');
                bootbox.hideAll();
                
            }
        });
    }  

    $('#lvl4_cari').on('change', function() {
        var stateID = $(this).val();
        setDefaultPeriode();
        setDefaultPeriodeAkhir();
        $('#tglawal').val('');
        $('#tglakhir').val('');
        $('#content_table').hide();
        get_data_unit(stateID,stateID); 
    });

    $('#periode').on('change', function() {
        var sloc = $('#lvl4_cari').val();
        var tgl_awal = $('#tglawal').val();
        var tgl_akhir = $('#tglakhir').val();
        var stateID = $(this).val();
        var bbm = $('#bbm').val();
        get_periode_akhir(stateID,sloc,tgl_awal,tgl_akhir,bbm); 
    });   

    function get_periode_akhir(periode_awal,sloc,tgl_awal,tgl_akhir,bbm) {
        setDefaultPeriodeAkhir();
        if(periode_awal != '') {
            var vlink_url = '<?php echo base_url()?>laporan/stockopname_pemakaian/get_periode_akhir/';
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "POST",
                dataType: "json",
                data : {
                    "sloc" : sloc,
                    "tgl_awal" : tgl_awal,
                    "tgl_akhir" : tgl_akhir,
                    "id" : periode_awal,
                    "bbm":bbm
                },
                success:function(data) {                
                    if(data.length < 1) {
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data tidak ditemukan untuk tanggal awal-- </div>', function() {
                            bootbox.hideAll();
                            $('#periode_akhir').empty();
                            // $('#periode_akhir').append('<option value="">--Pilih Periode--</option>');
                            // $('#periode_akhir').data("placeholder","Select").trigger('liszt:updated');
                        });
                    } else {
                        $('#periode_akhir').empty();
                        $('#periode_akhir').val(data[0].ID_STOCKOPNAME);
                        $('#periode_akhir_nama').val(data[0].NO_STOCKOPNAME+" - "+data[0].TGL_PENGAKUAN);
                        // $.each(data, function(key, value) {
                        // $('#periode_akhir').append('<option value="'+ value.ID_STOCKOPNAME +'">'+ value.NO_STOCKOPNAME +' - '+value.TGL_BA_STOCKOPNAME+'</option>');
                        // });
                        // $('#periode_akhir').data("placeholder","Select").trigger('liszt:updated');
                        bootbox.hideAll();
                    }    
                }
            });
        } else {
            $('#periode_akhir').empty();
            // $('#periode_akhir').append('<option value="">--Pilih Periode--</option>');
            // $('#periode_akhir').data("placeholder","Select").trigger('liszt:updated');
        }
        
    }    
</script>


<script>
    function toRp(angka){
        var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
        bilangan = bilangan.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            bilangan = bilangan.replace("-", "");
            isMinus = '-';
        }
        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        if ((rupiah=='') || (rupiah==0)) {rupiah='0,00'}
        rupiah = isMinus+''+rupiah;

        return rupiah;
    }

    function pesanGagal(vPesan){
        var icon = 'icon-remove-sign'; 
        var color = '#ac193d;';
        var message = '';

        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> Proses Gagal</div>';
        message += vPesan;

        bootbox.alert(message, function() {});
    }
    
</script>
