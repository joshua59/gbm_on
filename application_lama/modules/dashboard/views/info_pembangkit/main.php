
<!-- /**
 * @module PERHITUNGAN HARGA
 * @author  CF
 * @created at 11 JULI 2018
 * @modified at 11 JULI 2018
 */ -->

<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>

<style type="text/css">
    #modal_histo, #modal_peta, #modal_tangki{
      width: 80%;
      left: 10%;
      margin: 0 auto;
    }

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
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Pembangkit : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC_CARI', $lv4_options_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_cari" class="chosen span11"'); ?>
                                    </div>                                    
                                </div>
                                <div class="pull-left span4">
                                    <label></label>                                    
                                    <div class="controls">
                                        <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Quick Search", array('class' => 'btn yellow', 'id' => 'button-filter-cari')); ?>
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
                                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0" class="chosen span11"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 1 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" class="chosen span11"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 2 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2" class="chosen span11"'); ?>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="form_row">
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Level 3 : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3" class="chosen span11"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Pembangkit : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4" class="chosen span11"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span4">
                                    <label></label>                                    
                                    <div class="controls">
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?>&nbsp;
                                        <?php echo anchor(NULL, "<i class='icon-refresh'></i> Reset", array('class' => 'btn red', 'id' => 'button-reset')); ?>
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
            <div class="span6">
                <div id ="index-content" class="well-content no-search">
                    <div class="box-title" id="judul_pembangkit">
                        Data Pembangkit
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">                            
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Pengelolaan : </label>
                                    <div class="controls">
                                        <?php echo form_hidden('SLOC_PETA', !empty($default->SLOC_PETA) ? $default->SLOC_PETA : '', 'class="span11" id="SLOC_PETA"'); ?>
                                        <?php echo form_hidden('SLOC_PETA_NAMA', !empty($default->SLOC_PETA_NAMA) ? $default->SLOC_PETA_NAMA : '', 'class="span11" id="SLOC_PETA_NAMA"'); ?>
                                        <?php echo form_input('PENGELOLA', !empty($default->PENGELOLA) ? $default->PENGELOLA : '', 'class="span11" id="PENGELOLA" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Status : </label>
                                    <div class="controls">
                                        <?php echo form_input('AKTIF', !empty($default->AKTIF) ? $default->AKTIF : '', 'class="span11" id="AKTIF" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span6">
                                    <label for="password" class="control-label">Jenis BBM : </label>
                                    <div class="controls">
                                        <?php echo form_input('JENIS_BBM', !empty($default->JENIS_BBM) ? $default->JENIS_BBM : '', 'class="span11" id="JENIS_BBM" readonly'); ?>
                                    </div>
                                </div>
                            </div><br/>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Latitude : </label>
                                    <div class="controls">
                                        <?php echo form_input('LAT_LVL4', !empty($default->LAT_LVL4) ? $default->LAT_LVL4 : '', 'class="span11" id="LAT_LVL4" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Longtitude : </label>
                                    <div class="controls">
                                        <?php echo form_input('LOT_LVL4', !empty($default->LOT_LVL4) ? $default->LOT_LVL4 : '', 'class="span11" id="LOT_LVL4" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span6">
                                    <label for="password" class="control-label">Pemasok : </label>
                                    <div class="controls">
                                        <?php echo form_input('PEMASOK', !empty($default->PEMASOK) ? $default->PENGELOLA : '', 'class="span11" id="PEMASOK" readonly'); ?>
                                    </div>
                                </div>
                            </div><br>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Depo : </label>
                                    <div class="controls">
                                        <?php echo form_input('DEPO', !empty($default->DEPO) ? $default->DEPO : '', 'class="span11" id="DEPO" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Transportir : </label>
                                    <div class="controls">
                                        <?php echo form_input('TRANSPORTIR', !empty($default->TRANSPORTIR) ? $default->TRANSPORTIR : '', 'class="span11" id="TRANSPORTIR" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span6">
                                    <label for="password" class="control-label">No Kontrak Transportir : </label>
                                    <div class="controls">
                                        <?php echo form_input('NO_KONTRAK', !empty($default->NO_KONTRAK) ? $default->NO_KONTRAK : '', 'class="span11" id="NO_KONTRAK" readonly'); ?>
                                    </div>
                                </div>
                            </div><br>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Ongkos angkut per liter (+PPN 10%) : </label>
                                    <div class="controls">
                                        <?php echo form_input('ONGKOS_KIRIM', !empty($default->ONGKOS_KIRIM) ? $default->ONGKOS_KIRIM : '', 'class="span11 rp" id="ONGKOS_KIRIM" readonly'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label></label>
                                    <div class="controls">                                      
                                        <?php echo anchor(NULL, "<i class='icon-map-marker'></i> Lihat Peta Pembangkit", array('class' => 'btn green btn-hide', 'id' => 'button-peta')); ?>
                                    </div>
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <hr><br>
                    
                    <div class="box-title" id="judul_pembangkit">
                        Data Stok BBM
                        <div class="pull-right">
                            <div class="controls">
                                <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn btn-hide', 'id' => 'button-excel-stok')); ?>
                                <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn btn-hide', 'id' => 'button-pdf-stok')); ?>
                            </div>
                        </div>
                    </div>
                    <table id="table_stok_bbm" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Jenis BBM</th>
                                <th style="text-align:center;">Bulan Tahun</th>
                                <th style="text-align:center;">Tanggal Stock Terakhir</th>
                                <th style="text-align:center;">Stock Akhir (L)</th>
                                <th style="text-align:center;">Stock Efektif (L)</th>
                                <th style="text-align:center;">Pemakaian Tertinggi (L)</th>
                                <th style="text-align:center;">SHO (Hari)</th>
                                <th style="text-align:center;">Histo Stock BBM</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table><br> 
                    <label><i>(*SHO : Sisa Hari Operasi)</i></label><br>
                    <label><i>(*Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></label></br>
                    <label><i>(*Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></label>
                    <hr><br>
                    <div class="box-title" id="judul_pembangkit">
                        Data Tangki Pembangkit
                        <div class="pull-right">
                            <div class="controls">
                                <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn btn-hide', 'id' => 'button-excel-tangki')); ?>
                                <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn btn-hide', 'id' => 'button-pdf-tangki')); ?>
                            </div>
                        </div>                        
                    </div>                    
                    <table id="table_pembangkit" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Jenis BBM</th>
                                <th style="text-align:center;">Jumlah Tangki</th>
                                <th style="text-align:center;">Total Kapasitas Terpasang (L)</th>
                                <th style="text-align:center;">Total Deadstock (L)</th>
                                <th style="text-align:center;">Total Kapasitas Mampu (L)</th>
                                <th style="text-align:center;">Detail Tangki</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>                    
                    <br><br>
                </div>
            </div>
        </div>
        <br><br>        


    </div>
</div><br>

<!-- Modal -->
<div class="modal fade" id="modal_histo" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Histo Stock BBM</h4>          
        </div>
        <div class="modal-body">
            <div class="pull-right">
                <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel-histo')); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf-histo')); ?>
                </div>
            </div>
            <table id="table_histo" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Jenis BBM</th>
                        <th style="text-align:center;">Bulan Tahun</th>
                        <th style="text-align:center;">Tanggal Stock Terakhir</th>
                        <th style="text-align:center;">Stock Akhir (L)</th>
                        <th style="text-align:center;">Stock Efektif (L)</th>
                        <th style="text-align:center;">Pemakaian Tertinggi (L)</th>
                        <th style="text-align:center;">SHO (Hari)</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>   
            <div>&nbsp;</div>
            <label><i>(*SHO : Sisa Hari Operasi)</i></label><br>
            <label><i>(*Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></label></br>
            <label><i>(*Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></label></br><br><br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>                        
        </div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="modal_tangki" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="judul_tangki">Detail Tangki</h4>
        </div>
        <div class="modal-body">
            <div class="pull-right">
                <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel-tangki-detail')); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf-tangki-detail')); ?>
                </div>
            </div>            
            <table id="table_detail_tangki" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
                <thead>
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Nama Tangki</th>
                        <th style="text-align:center;">Kapasitas Terpasang (L)</th>
                        <th style="text-align:center;">Deadstock (L)</th>
                        <th style="text-align:center;">Kapasitas Mampu (L)</th>
                        <th style="text-align:center;"><?php echo str_repeat('&nbsp;', 5);?>Ditera&nbsp;Oleh<?php echo str_repeat('&nbsp;', 5);?></th>
                        <th style="text-align:center;">Tanggal Awal Tera</th>
                        <th style="text-align:center;">Tanggal Akhir Tera</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Dokumen Tera</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>   
            <div>&nbsp;</div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>                        
        </div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="modal_peta" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="judul_peta">Peta Pembangkit</h4>
        </div>
        <div class="modal-body">
            
            <div class="well-content" id="div_peta">
                <div class="well" style="height:550px;">
                    <!-- <div class="pull-left"> -->
                    <div id="map"></div>
                    <!-- </div>  --><!-- end pull left -->
                </div>
                <label><b>Legend :</b></label><br>
                <table>
                    <tr>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/pltd1.png" style="width:15px;height:15px;"> - Depo</i></label></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/pltd2_merah.png" style="width:15px;height:15px;"> - Pembangkit (SHO 0-3 hari)</i></label></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/pltd2_kuning.png" style="width:15px;height:15px;"> - Pembangkit (SHO 4-6 hari)</i></label></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/pltd2.png" style="width:15px;height:15px;"> - Pembangkit (SHO >= 7 hari)</i></label></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/biru.png" style="width:15px;height:7px;"> - Jalur Terima</i></label></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td><label><i><img src="<?php echo base_url();?>assets/img/ungu.png" style="width:15px;height:7px;"> - Jalur Kirim</i></label></td>
                    </tr>
                </table>
                <br>
                <label><i>(* Klik Logo Depo untuk melihat jalur pasokan)</i></label><br>
                <label><i>(* Klik Logo Pembangkit untuk melihat detail stok BBM dan jalur pasokan)</i></label><br>  
                <label><i>(* Klik Jalur Pasokan untuk melihat perolehan BBM)</i></label><br>
                <label><i>(* SHO : Sisa Hari Operasi)</i></label></br>
                <label><i>(* Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></label></br>
                <label><i>(* Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></label></br>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>                        
        </div>
      </div>
      
    </div>
</div>
  
<form id="export_excel" action="<?php echo base_url('dashboard/info_pembangkit/export_excel_stok'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl2">
   <input type="hidden" name="xlvl3">
   <input type="hidden" name="xlvl4">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xlvl2_nama">
   <input type="hidden" name="xlvl3_nama">
   <input type="hidden" name="xlvl4_nama">
   <input type="hidden" name="xbbm">
   <input type="hidden" name="xid_tangki">
</form>

<form id="export_pdf" action="<?php echo base_url('dashboard/info_pembangkit/export_pdf_stok'); ?>" method="post"  target="_blank">   
   <input type="hidden" name="plvl0">
   <input type="hidden" name="plvl1">
   <input type="hidden" name="plvl2">
   <input type="hidden" name="plvl3">
   <input type="hidden" name="plvl4">
   <input type="hidden" name="plvl0_nama">
   <input type="hidden" name="plvl1_nama">
   <input type="hidden" name="plvl2_nama">
   <input type="hidden" name="plvl3_nama">
   <input type="hidden" name="plvl4_nama">
   <input type="hidden" name="pbbm">
   <input type="hidden" name="pid_tangki">
</form>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;'; 

    $('.chosen').chosen();

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }

    });    

    $('#PENGELOLA').val('');
    $('#AKTIF').val('');
    $('#JENIS_BBM').val('');
    $('#LAT_LVL4').val('');
    $('#LOT_LVL4').val('');
    $('#PEMASOK').val('');
    $('#DEPO').val('');
    $('#TRANSPORTIR').val('');
    $('#NO_KONTRAK').val('');    
    $('.btn-hide').hide();

    $(document).ready(function() {
        $('#table_pembangkit').dataTable({
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
                {"className": "dt-center","targets": [0,1,-1]},
                {"className": "dt-right","targets": [2,3,4,5]},
            ]
        });

        $('#table_detail_tangki').dataTable({
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
                {"className": "dt-center","targets": [0,6,7,8,-1]},
                {"className": "dt-right","targets": [2,3,4]},
                {"className": "dt-left","targets": [1,5]},
            ]
        });        

        $('#table_histo').dataTable({
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
                {"className": "dt-center","targets": [0,1,2,3]},
                {"className": "dt-right","targets": [4,5,6,7]},
            ]
        });

        $('#table_stok_bbm').dataTable({
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
                {"className": "dt-center","targets": [0,1,2,3,-1]},
                {"className": "dt-right","targets": [4,5,6,7]},
            ]
        });


        // $('html, body').animate({scrollTop: $("#div_atas").offset().top}, 1000);
    });   
    

    function load_histo(sloc,jenis_bbm){
        get_data_histo(sloc,jenis_bbm);
    }

    function load_tangki(id_tangki){        
        get_data_detail_tangki(id_tangki);
        // get_data_histo(sloc,jenis_bbm);
    }

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

    function set_tgl_indo(vtgl){
        var arr_bln = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];        

        var bln = vtgl.substring(5, 7);
        var thn = vtgl.substring(0, 4);        

        return arr_bln[parseInt(bln)-1]+' '+thn;
    }

    function get_data_stock(sloc){ 
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_stock'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_stock gagal');                
            },            
            success:function(data) { 
                var t = $('#table_stok_bbm').DataTable();
                t.clear().draw();

                var nomer = 1;
                $.each(data, function () {
                    var ID_JNS_BHN_BKR = this.ID_JNS_BHN_BKR;
                    var NAMA_JNS_BHN_BKR = this.NAMA_JNS_BHN_BKR;
                    var TGL_MUTASI_PERSEDIAAN = this.TGL_MUTASI_PERSEDIAAN;
                    var STOCK_AKHIR_REAL = this.STOCK_AKHIR_REAL == null ? "0" : this.STOCK_AKHIR_REAL;
                    var STOCK_AKHIR_EFEKTIF = this.STOCK_AKHIR_EFEKTIF == null ? "0" : this.STOCK_AKHIR_EFEKTIF;
                    var MAX_PEMAKAIAN = this.MAX_PEMAKAIAN == null ? "0" : this.MAX_PEMAKAIAN;
                    var SHO = this.SHO == null ? "0" : this.SHO;  
                    var HISTO = '<a href="javascript:void(0);" data-sloc="'+sloc+'" data-bbm="'+this.ID_JNS_BHN_BKR+'" class="btn transparant" id="button-stock-'+this.ID_JNS_BHN_BKR+'" onclick="load_histo(this.id)"><i class="icon-zoom-in" title="Lihat Histo"></i></a>';                                                      

                    t.row.add( [
                        nomer,                     
                        NAMA_JNS_BHN_BKR, 
                        set_tgl_indo(TGL_MUTASI_PERSEDIAAN),
                        TGL_MUTASI_PERSEDIAAN,
                        convertToRupiah(STOCK_AKHIR_REAL), 
                        convertToRupiah(STOCK_AKHIR_EFEKTIF),
                        convertToRupiah(MAX_PEMAKAIAN),
                        convertToRupiah(SHO),
                        HISTO
                    ] ).draw( false );

                    nomer++;   
                });             
                    
                bootbox.hideAll();
            }
        });    
    }      

    function get_data_detail(sloc){
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_detail'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_detail gagal');                
            },            
            success:function(data) { 
                var t = $('#table_pembangkit').DataTable();
                t.clear().draw();

                var nomer = 1;
                $.each(data, function () {                 
                    var ID_JNS_BHN_BKR = this.ID_JNS_BHN_BKR;
                    var NAMA_JNS_BHN_BKR = this.NAMA_JNS_BHN_BKR;
                    var JML_TANGKI = this.JML_TANGKI;
                    var VOLUME_TANGKI = this.VOLUME_TANGKI;
                    var DEADSTOCK_TANGKI = this.DEADSTOCK_TANGKI;
                    var STOCKEFEKTIF_TANGKI = this.STOCKEFEKTIF_TANGKI;
                    var AKSI = '<a href="javascript:void(0);" class="btn transparant" id="button-tangki-'+this.ID_TANGKI+'" id-tangki="'+this.ID_TANGKI+'" tangki-bbm="'+this.NAMA_JNS_BHN_BKR+'" onclick="load_tangki(this.id)"><i class="icon-zoom-in" title="Lihat Detail Tangki"></i></a>';

                    t.row.add( [
                        nomer,                     
                        NAMA_JNS_BHN_BKR, 
                        JML_TANGKI,
                        convertToRupiah(VOLUME_TANGKI), 
                        convertToRupiah(DEADSTOCK_TANGKI),
                        convertToRupiah(STOCKEFEKTIF_TANGKI),
                        AKSI
                    ] ).draw( false );

                    nomer++;   
                });             
                    
                bootbox.hideAll();
            }
        });    
    }

    function get_data_detail_tangki(id){
        var jenis_bbm = $('#'+id).attr('tangki-bbm');
        var id_tangki = $('#'+id).attr('id-tangki');

        $('input[name="xid_tangki"]').val(id_tangki);
        $('input[name="pid_tangki"]').val(id_tangki);

        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_detail_tangki'); ?>",                
            data: { "ID_TANGKI": id_tangki},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_detail_tangki gagal');                
            },            
            success:function(data) { 
                var t = $('#table_detail_tangki').DataTable();
                t.clear().draw();

                var nomer = 1;
                $.each(data, function () {
                    var ID_DET_TANGKI = this.ID_DET_TANGKI;
                    var NAMA_TANGKI = this.NAMA_TANGKI;
                    var VOLUME_TANGKI = this.VOLUME_TANGKI;                    
                    var DEADSTOCK_TANGKI = this.DEADSTOCK_TANGKI;
                    var STOCKEFEKTIF_TANGKI = this.STOCKEFEKTIF_TANGKI;
                    var DITERA_OLEH = this.DITERA_OLEH;
                    var TGL_AWAL_TERA = this.TGL_AWAL_TERA;
                    var TGL_AKHIR_TERA = this.TGL_AKHIR_TERA;
                    var AKTIF = this.AKTIF;
                    var PATH_DET_TERA = this.PATH_DET_TERA;
                    var link_doc = '-';
                    
                    if (this.PATH_DET_TERA){                                                
                        // <!-- dokumen -->                        
                        <?php  
                            if ($this->laccess->is_prod()){ ?>
                                link_doc = '<a href="javascript:void(0);" id="LINK_FILE'+ ID_DET_TANGKI + '" onclick="lihat_dokumen(this.id)" data-modul="TANGKI" data-url="<?php echo $url_getfile;?>" data-filename="'+this.PATH_DET_TERA+'"><b>Lihat Dokumen</b></a>';
                        <?php } else { ?>
                                var url = "<?php echo base_url() ?>assets/upload/tangki/"+this.PATH_DET_TERA;
                                link_doc = "<a href='"+url+"' id='LINK_FILE"+ ID_DET_TANGKI + "' target='_blank'><b>Lihat Dokumen</b></a>";
                        <?php } ?>
                        // <!-- end dokumen -->                                                 
                    }                                      

                    t.row.add( [
                        nomer,                     
                        NAMA_TANGKI,                         
                        convertToRupiah(VOLUME_TANGKI), 
                        convertToRupiah(DEADSTOCK_TANGKI),
                        convertToRupiah(STOCKEFEKTIF_TANGKI),
                        DITERA_OLEH,
                        TGL_AWAL_TERA,
                        TGL_AKHIR_TERA,
                        AKTIF,
                        link_doc
                    ] ).draw( false );

                    nomer++;   
                });             
                    
                bootbox.hideAll();                
                $('#judul_tangki').html('Detail Tangki - '+jenis_bbm);
                $('#modal_tangki').modal('show');
            }
        });    
    }    

    function get_data_histo(id){
        var sloc = $('#'+id).attr('data-sloc'); 
        var jenis_bbm = $('#'+id).attr('data-bbm'); 

        $('input[name="xbbm"]').val(jenis_bbm);
        $('input[name="pbbm"]').val(jenis_bbm);

        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_histo'); ?>",                
            data: { "SLOC": sloc, "JENIS_BBM": jenis_bbm},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_histo gagal');                
            },            
            success:function(data) { 
                var t = $('#table_histo').DataTable();
                t.clear().draw();

                var nomer = 1;
                $.each(data, function () {
                    var ID_JNS_BHN_BKR = this.ID_JNS_BHN_BKR;
                    var NAMA_JNS_BHN_BKR = this.NAMA_JNS_BHN_BKR;
                    var TGL_MUTASI_PERSEDIAAN = this.TGL_MUTASI_PERSEDIAAN;
                    var STOCK_AKHIR_REAL = this.STOCK_AKHIR_REAL == null ? "0" : this.STOCK_AKHIR_REAL;
                    var STOCK_AKHIR_EFEKTIF = this.STOCK_AKHIR_EFEKTIF == null ? "0" : this.STOCK_AKHIR_EFEKTIF;
                    var MAX_PEMAKAIAN = this.MAX_PEMAKAIAN == null ? "0" : this.MAX_PEMAKAIAN;
                    var SHO = this.SHO == null ? "0" : this.SHO;                                    

                    t.row.add( [
                        nomer,                     
                        NAMA_JNS_BHN_BKR, 
                        set_tgl_indo(TGL_MUTASI_PERSEDIAAN),
                        TGL_MUTASI_PERSEDIAAN,
                        convertToRupiah(STOCK_AKHIR_REAL), 
                        convertToRupiah(STOCK_AKHIR_EFEKTIF),
                        convertToRupiah(MAX_PEMAKAIAN),
                        convertToRupiah(SHO)
                    ] ).draw( false );

                    nomer++;   
                });             
                    
                bootbox.hideAll();
                $('#modal_histo').modal('show');
            }
        });    
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
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_unit'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_unit gagal');                
            },            
            success:function(data) {                 
                $.each(data, function () {
                    // $("#lvl0").val(this.ID_REGIONAL);
                    // $('#lvl0').data("placeholder","Select").trigger('liszt:updated');
                    setComboDefault('#lvl0',this.ID_REGIONAL,this.LEVEL1);
                    setComboDefault('#lvl1',this.COCODE,this.LEVEL1);
                    setComboDefault('#lvl2',this.PLANT,this.LEVEL2);
                    setComboDefault('#lvl3',this.STORE_SLOC,this.LEVEL3);
                    if (sloc_cari){
                        setComboDefault('#lvl4',this.SLOC,this.LEVEL4);    
                    }

                    //set param export excel
                    $('input[name="xlvl0"]').val($('#lvl0').val());
                    $('input[name="xlvl1"]').val($('#lvl1').val());
                    $('input[name="xlvl2"]').val($('#lvl2').val());
                    $('input[name="xlvl3"]').val($('#lvl3').val());
                    $('input[name="xlvl4"]').val($('#lvl4').val());

                    $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
                    $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
                    $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
                    $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());
                    $('input[name="xlvl4_nama"]').val($('#lvl4 option:selected').text());

                    //set param export pdf
                    $('input[name="plvl0"]').val($('#lvl0').val());
                    $('input[name="plvl1"]').val($('#lvl1').val());
                    $('input[name="plvl2"]').val($('#lvl2').val());
                    $('input[name="plvl3"]').val($('#lvl3').val());
                    $('input[name="plvl4"]').val($('#lvl4').val());

                    $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
                    $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
                    $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
                    $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());
                    $('input[name="plvl4_nama"]').val($('#lvl4 option:selected').text());
                });             
                    
                bootbox.hideAll();

                if (sloc_cari){
                    get_data(sloc_cari);
                }
            }
        });    
    }

    $('#button-filter-cari').click(function() {
        var sloc = $('#lvl4_cari').val();
        if (sloc) {            
            setDefaultCombo();
            get_data_unit(sloc,sloc);            
        } else {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});
        }
    });  

    $('#button-filter').click(function() {
        get_data('');
        // var sloc = $('#lvl4').val();
        // if (sloc) {
        //     bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        //     $.ajax({
        //         type: "POST",
        //         url : "<?php echo base_url('dashboard/info_pembangkit/get_data'); ?>",                
        //         data: { "SLOC": sloc},
        //         dataType:'json',
        //         error: function(data) {
        //             bootbox.hideAll();
        //             msgGagal('get_data gagal');
        //         },            
        //         success:function(data) {
        //             $.each(data, function () {
        //                 $('#SLOC_PETA').val(this.SLOC);
        //                 $('#SLOC_PETA_NAMA').val(this.LEVEL4);
        //                 $('#PENGELOLA').val(this.PENGELOLA);
        //                 $('#AKTIF').val(this.AKTIF);
        //                 $('#JENIS_BBM').val(this.JENIS_BBM);
        //                 $('#LAT_LVL4').val(this.LAT_LVL4);
        //                 $('#LOT_LVL4').val(this.LOT_LVL4);
        //                 $('#PEMASOK').val(this.PEMASOK);
        //                 $('#DEPO').val(this.DEPO);
        //                 $('#TRANSPORTIR').val(this.TRANSPORTIR);
        //                 $('#NO_KONTRAK').val(this.NO_KONTRAK);
        //                 $('#ONGKOS_KIRIM').val(this.ONGKOS_KIRIM);
                        
        //                 $('#judul_pembangkit').html('Data Pembangkit - '+this.LEVEL4);
        //             });

        //             get_data_detail(sloc);
        //             get_data_stock(sloc);
        //             get_data_unit(sloc,'');
        //             // if (($('#lvl0').val()=='') || ($('#lvl1').val()=='') || ($('#lvl2').val()=='') || ($('#lvl3').val()=='') || ($('#lvl1 option').size()==1) ){
        //             //     get_data_unit(sloc);    
        //             // }

        //             // alert($('#lvl1 option').size());
                    
                    
        //             $('.btn-hide').show();
                                                
        //             bootbox.hideAll();
        //         }
        //     });

        //     $('html, body').animate({scrollTop: $("#divData").offset().top}, 1000);
        // } else {
        //     bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pembangkit harus dipilih-- </div>', function() {});
        // }
    }); 

    function get_data(get_unit){
        var sloc = $('#lvl4').val();
        if (sloc) {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
            $.ajax({
                type: "POST",
                url : "<?php echo base_url('dashboard/info_pembangkit/get_data'); ?>",                
                data: { "SLOC": sloc},
                dataType:'json',
                error: function(data) {
                    bootbox.hideAll();
                    msgGagal('get_data gagal');
                },            
                success:function(data) {
                    $.each(data, function () {
                        $('#SLOC_PETA').val(this.SLOC);
                        $('#SLOC_PETA_NAMA').val(this.LEVEL4);
                        $('#PENGELOLA').val(this.PENGELOLA);
                        $('#AKTIF').val(this.AKTIF);
                        $('#JENIS_BBM').val(this.JENIS_BBM);
                        $('#LAT_LVL4').val(this.LAT_LVL4);
                        $('#LOT_LVL4').val(this.LOT_LVL4);
                        $('#PEMASOK').val(this.PEMASOK);
                        $('#DEPO').val(this.DEPO);
                        $('#TRANSPORTIR').val(this.TRANSPORTIR);
                        $('#NO_KONTRAK').val(this.NO_KONTRAK);
                        $('#ONGKOS_KIRIM').val(this.ONGKOS_KIRIM);
                        
                        $('#judul_pembangkit').html('Data Pembangkit - '+this.LEVEL4);
                    });

                    get_data_detail(sloc);
                    get_data_stock(sloc);
                    if (get_unit==''){
                        get_data_unit(sloc,'');
                    }
                    // if (($('#lvl0').val()=='') || ($('#lvl1').val()=='') || ($('#lvl2').val()=='') || ($('#lvl3').val()=='') || ($('#lvl1 option').size()==1) ){
                    //     get_data_unit(sloc);    
                    // }

                    // alert($('#lvl1 option').size());
                    
                    
                    $('.btn-hide').show();
                                                
                    bootbox.hideAll();
                }
            });

            $('html, body').animate({scrollTop: $("#divData").offset().top}, 1000);
        } else {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pembangkit harus dipilih-- </div>', function() {});
        }
    };      

    $('#button-reset').click(function(){
        bootbox.confirm('Anda yakin akan Reset Pencarian ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#ffilter-cari')[0].reset();                
                setDefaultCombo();
            }
        });
    }); 

    $('#button-excel-stok').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_excel').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_excel_stok'); ?>");
             $('#export_excel').submit();
         }
       });
    });

    $('#button-pdf-stok').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_pdf_stok'); ?>");
             $('#export_pdf').submit();
         }
       });
    });

    $('#button-excel-histo').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_excel').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_excel_histo'); ?>");
             $('#export_excel').submit();
         }
       });
    });

    $('#button-pdf-histo').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_pdf_histo'); ?>");
             $('#export_pdf').submit();
         }
       });
    });    

    $('#button-excel-tangki').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_excel').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_excel_tangki'); ?>");
             $('#export_excel').submit();
         }
       });
    });

    $('#button-pdf-tangki').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_pdf_tangki'); ?>");
             $('#export_pdf').submit();
         }
       });
    });

    $('#button-excel-tangki-detail').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_excel').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_excel_tangki_detail'); ?>");
             $('#export_excel').submit();
         }
       });
    });

    $('#button-pdf-tangki-detail').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').attr('action', "<?php echo base_url('dashboard/info_pembangkit/export_pdf_tangki_detail'); ?>");
             $('#export_pdf').submit();
         }
       });
    });

    setDefaultCombo();
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
              


    // filter combo
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
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();

        if (stateID==''){
            vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv4/all';    
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
                  $('#lvl1').data("placeholder","Select").trigger('liszt:updated');                    
                  get_options_lv4_all(stateID);
                }

                bootbox.hideAll();
              }
          });
        // }                
    });

    $('#lvl1').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv2/'+stateID;
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
                  $('#lvl2').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl2').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv3/'+stateID;
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
                  $('#lvl3').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl3').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv4/'+stateID;
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
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    }); 

    function get_options_lv4_all(unit) {        
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/options_lv4_all/'+unit;
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
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/options_lv4_all/'+unit;
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
</script>

<script type="text/javascript">
    var pltd1 = L.icon({
        iconUrl: '<?php echo base_url()?>assets/img/pltd1.png',
        // shadowUrl: 'leaf-shadow.png',
        iconSize:     [17, 17], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
        // shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
    });

    var pltd2 = L.icon({
        iconUrl: '<?php echo base_url()?>assets/img/pltd2.png',
        // shadowUrl: 'leaf-shadow.png',
        iconSize:     [17, 17], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
        // shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
    });

    var pltd2_kuning = L.icon({
        iconUrl: '<?php echo base_url()?>assets/img/pltd2_kuning.png',
        // shadowUrl: 'leaf-shadow.png',
        iconSize:     [17, 17], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
        // shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
    });

    var pltd2_merah = L.icon({
        iconUrl: '<?php echo base_url()?>assets/img/pltd2_merah.png',
        // shadowUrl: 'leaf-shadow.png',
        iconSize:     [17, 17], // size of the icon
        // shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [10, 10], // point of the icon which will correspond to marker's location
        // shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -13] // point from which the popup should open relative to the iconAnchor
    });

    var map = L.map('map', {
        zoomDelta: 0.25,
        zoomSnap: 0
    }).setView( [-1.9205768,118.5820232], 4.75  );
    // }).setView( [-2.5,117.9], 4.75  );

    // var layer = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    //              maxZoom: 27,
    //              id: 'mapbox.streets',
    //              accessToken: 'pk.eyJ1IjoiZmFqYXJ5dWR5IiwiYSI6ImNqbDZrZGMxNDBzb2UzeG50bXF3MnVzc3EifQ.IE6n-TkthG16ipaiYza4eQ'
    //          }).addTo(map);

    var layer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var _polylineArray = [];
    var _polylines = '';
    var _markerArray = [];
    var _markers = '';

    // getPeta();
    function getPeta(){
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        /*
            Loooping disini untuk draw Polyline dan Juga Membuat Marker Pembangkit dan Depo
        */
        setGarisHapusSemua();
        seMarkerHapus();
        $('html, body').animate({scrollTop: $("#div_peta").offset().top}, 1000);

        var lvl0 = '';
        var lvl1 = '';
        var lvl2 = '';
        var lvl3 = '';
        var lvl4 = $('#SLOC_PETA').val(); 

        var vlink_url = '<?php echo base_url()?>dashboard/peta_jalur/get_peta/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            dataType: "json",
            data: {"ID_REGIONAL": lvl0,
                   "COCODE": lvl1,
                   "PLANT": lvl2,
                   "STORE_SLOC": lvl3,
                   "SLOC": lvl4,
            },
            success:function(data) {
                bootbox.hideAll();

                if (data == "" || data == null) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Peta Tidak ditemukan-- </div>', function() {});
                    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
                }

                $.each(data, function(key, value) {

                    //depo
                    if ((value.LAT_DEPO)&&(value.LOT_DEPO)){
                        var lbl_depo = 'DEPO';
                        var lbl_stok = '';
                        var icon_depo = pltd1;
                        var jenis_depo = "depo";
                        var id_depo = value.ID_DEPO; 
                        var btn_garis_terima = '';
                        var btn_hapus_terima = '';                          
                        // if (value.ID_DEPO=='000'){
                        if (value.NAMA_PEMASOK=='PT PLN (PERSERO)'){
                            lbl_depo = 'PEMBANGKIT';
                            icon_depo = pltd2;
                            jenis_depo = "unit_pln";
                            // id_depo = value.SLOC_UNIT_PLN;

                            // btn_garis_terima = '<button id="T_'+id_depo+'" id_val="'+id_depo+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Terima</button>';
                            // btn_hapus_terima = '<button id="HT_'+id_depo+'" jenis="sloc" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';                           
                        }

                        var btn_garis = '<button id="K_'+id_depo+'" id_val="'+id_depo+'" jenis="'+jenis_depo+'" warna="purple" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Kirim</button>';                     
                        var btn_hapus = '<button id="HK_'+id_depo+'" jenis="'+jenis_depo+'" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';

                        var det_depo = '<strong>'+lbl_depo+'</strong><br>'+value.NAMA_DEPO+'<br><br><br>'+btn_garis+' '+btn_hapus+'<br>'+btn_garis_terima+' '+btn_hapus_terima;

                        try {
                            var a = L.marker([parseFloat(value.LAT_DEPO), parseFloat(value.LOT_DEPO)], {icon: icon_depo}).bindPopup(det_depo).openPopup();

                            if (value.NAMA_PEMASOK=='PT PLN (PERSERO)'){
                                var btn_garis_terima_d = '<button id="T_'+id_depo+'" id_val="'+id_depo+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Terima</button>';
                                var btn_hapus_terima_d = '<button id="HT_'+id_depo+'" jenis="sloc" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';    

                                var btn_garis_d = '<button id="K_'+id_depo+'" id_val="'+id_depo+'" jenis="'+jenis_depo+'" warna="purple" onclick="setMultigaris(this.id)" style="width: 99px;">Jalur Kirim</button>';                       
                                var btn_hapus_d = '<button id="HK_'+id_depo+'" jenis="'+jenis_depo+'" id_depo="'+id_depo+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';                             

                                a.on('click',function(){
                                    obj = this;
                                    // function getStok(id){ 
                                        var det_stok = '';

                                        var _id = value.ID_DEPO;
                                        var _jenis = 'sloc';
                                        
                                        var lvl0 = $('#lvl0').val(); 
                                        var lvl1 = $('#lvl1').val(); 
                                        var lvl2 = $('#lvl2').val(); 
                                        var lvl3 = $('#lvl3').val(); 
                                        var lvl4 = $('#lvl4').val(); 

                                        // var data_kirim = "id="+_id+'&jenis='+_jenis;

                                        var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

                                        // bootbox.modal('<div class="loading-progress"></div>');
                                        $.ajax({
                                        type: 'POST',
                                        url: url,
                                        // data: data_kirim,
                                        data: {"id": _id,
                                               "jenis": _jenis,
                                               "ID_REGIONAL": lvl0,
                                               "COCODE": lvl1,
                                               "PLANT": lvl2,
                                               "STORE_SLOC": lvl3,
                                               "SLOC": lvl4
                                        },
                                        dataType:'json',
                                            error: function(data) {
                                                // bootbox.hideAll();          
                                                pesanGagal('Proses data gagal hapus jalur');
                                            },
                                            success: function(data) {
                                                // bootbox.hideAll();
                                                // map.closePopup();
                                                $.each(data, function(key, value) {

                                                    var _SA_HSD='' , _SA_MFO='' , _SA_HSDBIO='' , _SA_BIO='' , _SA_IDO= '';
                                                    var _SHO_HSD=0, _SHO_MFO=0 , _SHO_HSDBIO=0 , _SHO_BIO=0, _SHO_IDO=0, _SHO_MIN = 999999;

                                                    if (value.SA_HSD!=null){
                                                        _SA_HSD = '<br>HSD: '+toRp(value.SA_HSD)+' L '+
                                                                        '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSD)+' Hari)';

                                                        if (value.SHO_HSD!=null){
                                                            _SHO_HSD = value.SHO_HSD;   
                                                        }                           
                                                        _SHO_MIN = _SHO_HSD;
                                                    }

                                                    if (value.SA_MFO!=null){
                                                        _SA_MFO = '<br>MFO: '+toRp(value.SA_MFO)+' L '+
                                                                        '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_MFO)+' Hari)';
                                                        
                                                        if (value.SHO_MFO!=null){
                                                            _SHO_MFO = value.SHO_MFO;   
                                                        }
                                                        if (_SHO_MFO < _SHO_MIN) { _SHO_MIN = _SHO_MFO;}
                                                    }

                                                    if (value.SA_HSDBIO!=null){
                                                        _SA_HSDBIO = '<br>HSD+BIO: '+toRp(value.SA_HSDBIO)+' L '+
                                                                        '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSDBIO)+' Hari)';
                                                        
                                                        if (value.SHO_HSDBIO!=null){
                                                            _SHO_HSDBIO = value.SHO_HSDBIO; 
                                                        }
                                                        if (_SHO_HSDBIO < _SHO_MIN) { _SHO_MIN = _SHO_HSDBIO;}
                                                    }

                                                    if (value.SA_BIO!=null){
                                                        _SA_BIO = '<br>BIO: '+toRp(value.SA_BIO)+' L '+
                                                                        '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_BIO)+' Hari)';
                                                        
                                                        if (value.SHO_BIO!=null){
                                                            _SHO_BIO = value.SHO_BIO;   
                                                        }
                                                        if (_SHO_BIO < _SHO_MIN) { _SHO_MIN = _SHO_BIO;}
                                                    }

                                                    if (value.SA_IDO!=null){
                                                        _SA_IDO = '<br>IDO: '+toRp(value.SA_IDO)+' L '+
                                                                        '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_IDO)+' Hari)';
                                                        
                                                        if (value.SHO_IDO!=null){
                                                            _SHO_IDO = value.SHO_IDO;   
                                                        }
                                                        if (_SHO_IDO < _SHO_MIN) { _SHO_MIN = _SHO_IDO;}
                                                    }

                                                    // Ini data untuk yg peta jalur pasokan
                                                    // 0 - 3 MERAH
                                                    // 4 - 6 KUNING
                                                    // > 7 Hijau                            

                                                    if (_SHO_MIN <=3){
                                                        icon_depo = pltd2_merah;
                                                    } else if (_SHO_MIN <=6){
                                                        icon_depo = pltd2_kuning;
                                                    } else {
                                                        icon_depo = pltd2;
                                                    }

                                                    var lbl_stok_d = _SA_HSD+_SA_MFO+_SA_HSDBIO+_SA_BIO+_SA_IDO;
                                                
                                                    var det_depo_d = '<strong>'+lbl_depo+'</strong><br>'+value.UNIT+'<br>'+lbl_stok_d+'<br><br>'+btn_garis_d+' '+btn_hapus_d+'<br>'+btn_garis_terima_d+' '+btn_hapus_terima_d;                                                              
                                                    obj.bindPopup(det_depo_d);
                                                });
                                            }    
                                        })
                                    // } 
                                });                                                         
                            }
                            

                            _markerArray.push(a);
                            _markers = L.layerGroup(_markerArray);
                            _markers.addTo(map);    
                        } catch (err) {
                            pesanGagal('<strong>'+lbl_depo+'</strong><br>'+value.NAMA_DEPO+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
                        }               
                    }

                    //pltd
                    if ((value.LAT_LVL4)&&(value.LOT_LVL4)){                        
                        var btn_garis = '<button id="'+value.SLOC+'" id_val="'+value.SLOC+'" jenis="sloc" warna="blue" onclick="setMultigaris(this.id)">Jalur Terima</button>';
                        // var btn_hapus = '<button onclick="setGarisHapus()">Hapus Jalur</button>';
                        var btn_hapus = '<button id="HP_'+value.SLOC+'" jenis="sloc" id_depo="'+value.SLOC+'" onclick="setGarisHapus(this.id)">Hapus Jalur</button>';

                        var _SA_HSD='' , _SA_MFO='' , _SA_HSDBIO='' , _SA_BIO='' , _SA_IDO= '';
                        var _SHO_HSD=0, _SHO_MFO=0 , _SHO_HSDBIO=0 , _SHO_BIO=0, _SHO_IDO=0, _SHO_MIN = 999999;

                        
                        if (value.SA_HSD!=null){
                            _SA_HSD = '<br>HSD: '+toRp(value.SA_HSD)+' L '+
                                            '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSD)+' Hari)';

                            if (value.SHO_HSD!=null){
                                _SHO_HSD = value.SHO_HSD;   
                            }                           
                            _SHO_MIN = _SHO_HSD;
                        }

                        if (value.SA_MFO!=null){
                            _SA_MFO = '<br>MFO: '+toRp(value.SA_MFO)+' L '+
                                            '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_MFO)+' Hari)';
                            
                            if (value.SHO_MFO!=null){
                                _SHO_MFO = value.SHO_MFO;   
                            }
                            if (_SHO_MFO < _SHO_MIN) { _SHO_MIN = _SHO_MFO;}
                        }

                        if (value.SA_HSDBIO!=null){
                            _SA_HSDBIO = '<br>HSD+BIO: '+toRp(value.SA_HSDBIO)+' L '+
                                            '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_HSDBIO)+' Hari)';
                            
                            if (value.SHO_HSDBIO!=null){
                                _SHO_HSDBIO = value.SHO_HSDBIO; 
                            }
                            if (_SHO_HSDBIO < _SHO_MIN) { _SHO_MIN = _SHO_HSDBIO;}
                        }

                        if (value.SA_BIO!=null){
                            _SA_BIO = '<br>BIO: '+toRp(value.SA_BIO)+' L '+
                                            '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_BIO)+' Hari)';
                            
                            if (value.SHO_BIO!=null){
                                _SHO_BIO = value.SHO_BIO;   
                            }
                            if (_SHO_BIO < _SHO_MIN) { _SHO_MIN = _SHO_BIO;}
                        }

                        if (value.SA_IDO!=null){
                            _SA_IDO = '<br>IDO: '+toRp(value.SA_IDO)+' L '+
                                            '&nbsp;&nbsp;&nbsp;(SHO: '+toRp(value.SHO_IDO)+' Hari)';
                            
                            if (value.SHO_IDO!=null){
                                _SHO_IDO = value.SHO_IDO;   
                            }
                            if (_SHO_IDO < _SHO_MIN) { _SHO_MIN = _SHO_IDO;}
                        }

                        // Ini data untuk yg peta jalur pasokan
                        // 0 - 3 MERAH
                        // 4 - 6 KUNING
                        // > 7 Hijau

                        var pltd_SHO = '';

                        if (_SHO_MIN <=3){
                            pltd_SHO = pltd2_merah;
                        } else if (_SHO_MIN <=6){
                            pltd_SHO = pltd2_kuning;
                        } else {
                            pltd_SHO = pltd2;
                        }

                        var det_pemasok = '<strong>PEMBANGKIT</strong><br>'+value.UNIT+'<br>'+
                                            _SA_HSD+
                                            _SA_MFO+
                                            _SA_HSDBIO+
                                            _SA_BIO+
                                            _SA_IDO+
                                            '<br><br><br>'+btn_garis+' '+btn_hapus;

                        try {
                           var a = L.marker([parseFloat(value.LAT_LVL4), parseFloat(value.LOT_LVL4)], {icon: pltd_SHO}).bindPopup(det_pemasok).openPopup();
                                    
                            _markerArray.push(a);
                            _markers = L.layerGroup(_markerArray);
                            _markers.addTo(map);
                        } catch (err) {
                            pesanGagal('<strong>PEMBANGKIT</strong><br>'+value.UNIT+'<br>'+
                                            _SA_HSD+
                                            _SA_MFO+
                                            _SA_HSDBIO+
                                            _SA_BIO+
                                            _SA_IDO+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
                        }                                               
                    }


                    if ((value.LAT_DEPO==0)||(value.LOT_DEPO==0)){                        
                        pesanGagal('<strong>DEPO</strong><br>'+lbl_depo+'<br>'+
                        '<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Depo tidak tersedia');
                        $('#modal_peta').modal('hide');
                    }

                    if ((value.LAT_LVL4==0)||(value.LOT_LVL4==0)){                        
                        pesanGagal('<strong>PEMBANGKIT</strong><br>'+value.UNIT+'<br>'+
                        '<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Pembangkit tidak tersedia');
                        $('#modal_peta').modal('hide');
                    }

                });
            }
        });

        map.panTo(new L.LatLng(-1.9205768,114.5820232));
    }
    
    /*
        End Looping Draw Polyline
    */

    function setMultigaris(id){ 
        var _id = $('#'+id).attr('id_val');
        var _jenis = $('#'+id).attr('jenis');
        var _warna = $('#'+id).attr('warna');

        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val(); 
        // var data_kirim = "id="+_id+'&jenis='+_jenis;

        var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'POST',
        url: url,
        // data: data_kirim,
        data: {"id": _id,
               "jenis": _jenis,
               "ID_REGIONAL": lvl0,
               "COCODE": lvl1,
               "PLANT": lvl2,
               "STORE_SLOC": lvl3,
               "SLOC": lvl4
        },      
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();         
                pesanGagal('Proses data gagal setMultigaris');
            },
            success: function(data) {
                bootbox.hideAll();
                map.closePopup();
                var ket = '';
                
                $.each(data, function () {
                    ket = '<strong>PEMBANGKIT</strong><br>'+this.UNIT+'<br>'+
                        'Pemasok : '+this.NAMA_PEMASOK+'<br>'+
                        'Depo : '+this.NAMA_DEPO+'<br>'+
                        'Transportir : '+this.NAMA_TRANSPORTIR+'<br><br>'+
                        'Moda Transportasi : '+this.JENIS_PASOKAN+'<br>'+
                        'Jarak tempuh : '+toRp(this.JARAK_TEMPUH)+' (KM atau ML)<br>'+
                        'Ongkos angkut per liter : Rp '+toRp(this.ONGKOS_ANGKUT)+'<br>'+
                        // 'Nilai kontrak : Rp '+toRp(this.NILAI_KONTRAK)+'<br>'+
                        'Nomor Kontrak : '+this.NOMOR_KONTRAK;

                    try {
                        if ((this.NOMOR_KONTRAK=='') || (this.NOMOR_KONTRAK==null)){                            
                            pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> JALUR TIDAK TERSEDIA KARENA KONTRAK TRANSPORTIR SUDAH TIDAK BERLAKU/EXPIRED');
                        } else                                  
                        if ((this.LAT_LVL4=='') || (this.LOT_LVL4=='') || (this.LAT_LVL4==null) || (this.LOT_LVL4==null)){
                            pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Pembangkit tidak tersedia');
                            // pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Tidak Ada Jalur Pasokan Pada Kontrak Transportir Yang Berlaku');
                        } else 
                        if ((this.LAT_DEPO=='') || (this.LOT_DEPO=='') || (this.LAT_DEPO==null) || (this.LOT_DEPO==null)){
                            pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Koordinat Depo tidak tersedia');
                            // pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br> Tidak Ada Jalur Pasokan Pada Kontrak Transportir Yang Berlaku');
                        } else {
                            setGaris(this.LAT_LVL4,this.LOT_LVL4,this.LAT_DEPO,this.LOT_DEPO,ket,_warna);   
                        }
                    } catch (err) {
                        pesanGagal(ket+'<br><br> <strong>PESAN GAGAL :</strong><br>'+err.message);
                    }
                });    

                if (data.length==0){
                    pesanGagal('Tidak ada jalur pasokan');
                }
            }    
        })
    } 

    function setGaris(a_lat, a_lot, b_lat, b_lot, ket, warna){
        if ((a_lat !== null) && (a_lot !== null) && (b_lat !== null) && (b_lot !== null)){
            var toUnion = [[a_lat, a_lot],[b_lat, b_lot]];          
            var a = L.polyline(toUnion,{color:warna,opacity:1});

            // polyline.bindTooltip('stuff')
            a.bindTooltip("Klik untuk melihat Detil Kontrak");

            // a.bindTooltip("Klik untuk melihat Detil Kontrak").openTooltip();

            a.on('click',function(){
              this.bindPopup(ket);
            });         

            _polylineArray = [];
            _polylineArray.push(a);
            _polylines = L.layerGroup(_polylineArray);
            _polylines.addTo(map);          
        }
    }

    function setGarisHapus(id){ 
        var _id = $('#'+id).attr('id_depo');
        var _jenis = $('#'+id).attr('jenis');

        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val();

        // var data_kirim = "id="+_id+'&jenis='+_jenis;

        var url = "<?php echo base_url()?>dashboard/peta_jalur/get_jalur/";

        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'POST',
        url: url,
        // data: data_kirim,
        data: {"id": _id,
               "jenis": _jenis,
               "ID_REGIONAL": lvl0,
               "COCODE": lvl1,
               "PLANT": lvl2,
               "STORE_SLOC": lvl3,
               "SLOC": lvl4
        },          
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();         
                // pesanGagal('Proses data gagal setGarisHapus');
            },
            success: function(data) {
                bootbox.hideAll();
                map.closePopup();
                var ket = '';
                
                $.each(data, function () {
                    try {
                        setHapusGarisByLatLng(this.LAT_LVL4,this.LOT_LVL4,this.LAT_DEPO,this.LOT_DEPO);
                    } catch (err) {
                        pesanGagal('<strong>PESAN GAGAL :</strong><br>'+err.message);
                    }
                });    

                if (data.length==0){
                    pesanGagal('Tidak ada jalur pasokan');
                }
            }    
        })
    } 

    function setGarisHapusX(){
        clearMap();
        // console.log(_polylines);
        // map.removeLayer(_polylines);
        // _polylines = '';
        // _polylineArray = [];
        // map.closePopup();
    }

    function setGarisHapusSemua() {
        for(i in map._layers) {
            if(map._layers[i]._path != undefined) {
                try {
                    map.removeLayer(map._layers[i]);
                }
                catch(e) {
                    console.log("problem with " + e + map._layers[i]);
                }
            }
        }
    }

    function setHapusGarisByLatLng(a_lat, a_lng, b_lat, b_lng) {
        for(i in map._layers) {
            if(map._layers[i]._path != undefined) {
                try {
                    if ((a_lat==map._layers[i]._latlngs[0].lat) && (a_lng==map._layers[i]._latlngs[0].lng) &&
                        (b_lat==map._layers[i]._latlngs[1].lat) && (b_lng==map._layers[i]._latlngs[1].lng)){
                        map.removeLayer(map._layers[i]);    
                    }                
                }
                catch(e) {
                    console.log("problem with " + e + map._layers[i]);
                }
            }
        }
    }

    function seMarkerHapus(){
        try {
            map.removeLayer(_markers);
            _markers = '';
            _markerArray = [];              
        }
        catch(e) {
            console.log("problem with seMarkerHapus " + e );
        }
        
    }

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


    $('#button-peta').click(function() {
        // getPeta();
        if (($('#LAT_LVL4').val()) && $('#LOT_LVL4').val()){
            $('#judul_peta').html('Peta Pembangkit - '+$('#SLOC_PETA_NAMA').val());
            $('#modal_peta').modal('show');
        } else {
            pesanGagal('<strong>PESAN GAGAL :</strong><br> Koordinat Pembangkit tidak tersedia');
        }

    });      

    $('#modal_peta').on('shown', function(){  
        getPeta();
    });     
</script>
