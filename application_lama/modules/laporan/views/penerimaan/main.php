<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<style>
   #exampleModal, #modal_rekap_bio, #modal_detail_bio{
     width: 100%;
     left: 0%;
     margin: 0 auto;
   }
   .detail-kosong{
      display: none;
   }
   .dataTables_filter{
      display: none;
   }
   tr {
      background-color: #B0C4DE;
   }
   table {
     border-collapse: collapse;
     width:100%;
   }
   .auto{
      width: 100%;
   }
   .dataTables_scrollHeadInner {
     width: 100% !important;
   }
   .dataTables_scrollHeadInner table {
     width: 100% !important;    
   }   
</style>


<div class="inner_content" id="divTop">
   <div class="statistic clearfix">
      <div class="current_page pull-left">
         <span><?php echo isset($page_title) ? $page_title : 'Laporan Penerimaan BBM'; ?></span>
      </div>
   </div>
   <div class="widgets_area">
      <div class="well-content no-search">
         <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
         <div class="form_row">
            <!-- Regional -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
               </div>
            </div>
            <!-- Level 1 -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
               </div>
            </div>
            <!-- Level 2 -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
               </div>
            </div>
         </div>
         <br/>
         <div class="form_row">
            <!-- Level 3 -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
               </div>
            </div>
            <div class="pull-left span3">
               <label for="password" class="control-label">Pembangkit<span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
               </div>
            </div>
            <!-- jenis bahan bakar -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
               <div class="controls">
                  <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
               </div>
            </div>
         </div>
         <br/>
         <div class="form_row">
            <!-- Level 3 -->
            <div class="pull-left span3">
               <label for="password" class="control-label">Periode <span class="required">*</span> :  </label>
               <!-- <label for="password" class="control-label" style="margin-left:38px">Tanggal Akhir : </label> -->
               <div class="controls">
                  <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                  <label for="">s/d</label>
                  <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
               </div>
            </div>
            <div class="pull-left span3">
            </div>
            <div class="pull-left span2">
               <label for="password" class="control-label">Cari: </label>
               <div class="controls">
                  <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Unit">
               </div>
            </div>
            <div class="pull-left span1">
               <label></label>
               <div class="controls">
                  <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
               </div>
            </div>
         </div>
         <div class="form_row">
            <div class="pull-left span2">
            </div>
            <div class="pull-left span2">
            </div>
            <div class="pull-left span2">
            </div>
            <div class="pull-left span4">
               <label></label>
               <div class="controls">
                  <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                     'class' => 'btn',
                     'id'    => 'button-excel'
                     )); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                     'class' => 'btn',
                     'id'    => 'button-pdf'
                     )); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download CSV", array(
                     'class' => 'btn', 
                     'id' => 'button-csv'
                     )); ?>
               </div>
            </div>
         </div>
         <div class="form_row">
            <div class="pull-left span2">
               <label></label>
               <div class="controls">
                  <?php echo anchor(null, "<i class='icon'></i> Detail", array(
                     'class'       => 'btn green detail-kosong',
                     'id'          => 'button-detail'
                     )); ?>
               </div>
            </div>
            <!-- Tampilan modal detail -->
            <div class="pull-left span3">
               <label></label>
               <div class="controls">
                  <!-- <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                     'class' => 'btn',
                     'id'    => 'button-excel'
                     )); ?>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                        )); ?> -->
               </div>
            </div>
         </div>
         <?php echo form_close(); ?>
      </div>
      <br>
      <div class="well-content no-search" id="divTable">
         <table id="dataTable" class="display dt-responsive" width="100%" cellspacing="0" style="max-height:1000px;">
            <thead>
               <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">KODE Unit</th>
                  <th rowspan="2">Unit</th>
                  <th rowspan="2">ID BBM</th>
                  <th rowspan="2">Jenis Bahan Bakar</th>
                  <th rowspan="2">Tgl Awal Terima</th>
                  <th rowspan="2">Tgl Akhir Terima</th>
                  <th colspan="4">Jenis Penerimaan</th>
                  <th colspan="2">Total Volume Terima</th>
                  <th rowspan="2">AKSI</th>
               </tr>
               <tr>
                  <th style="text-align:center;">Total</th>
                  <th style="text-align:center;">Unit Lain</th>
                  <th style="text-align:center;">Pemasok</th>
                  <th style="text-align:center;">Pengembalian</th>
                  <th style="text-align:center;">DO (L)</th>
                  <th style="text-align:center;">Real (L)</th>
               </tr>
            </thead>
            <tbody></tbody>
         </table>
         <label for="periodeawal_ket"><i>(*Tanggal Awal Terima : Tanggal pengakuan transaksi penerimaan pertama pada periode tertentu)</i></label><br><br>
         <label for="periodeakhir_ket"><i>(*Tanggal Akhir Terima : Tanggal pengakuan transaksi penerimaan terakhir pada periode tertentu)</i></label>
      </div>

      <div id="form-content" class="modal fade modal-xlarge"></div>

      <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div id="div_load">               
                  <div id="div_progress">
                    <div id="div_bar">0%</div>
                  </div>
               </div>                
               <div class="modal-body">
                  <div class="pull-right">
                     <input type="text" id="cariDetail" name="cariDetail" value="" placeholder="Cari Unit, No Penerimaan" class="input-large">
                     <button type="button" class="btn" name="button" id="btnCariDetail">Cari</button>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel-detail'
                        )); ?>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf-detail'
                        )); ?>
                  </div>
                  <table id="dataTable_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                     <thead>
                        <tr>
                           <th rowspan="2">NO</th>
                           <th colspan="4">Level</th>
                           <th rowspan="2" style="text-align:center;">Unit Pembangkit</th>
                           <th rowspan="2" style="text-align:center;">Bahan Bakar</th>
                           <th rowspan="2">No Penerimaan</th>
                           <th rowspan="2">Asal Pasokan</th>
                           <th rowspan="2" style="text-align:center;">Nama Transportir</th>
                           <th rowspan="2" style="text-align:center;">Tanggal DO</th>
                           <th rowspan="2" style="text-align:center;">Tanggal Terima Fisik</th>
                           <th rowspan="2" style="text-align:center;">Volume Terima DO (L)</th>
                           <th rowspan="2" style="text-align:center;">Volume Terima Real (L)</th>
                           <th rowspan="2" style="text-align:center;">Terima Pengembalian (L)</th>
                           <th rowspan="2" style="text-align:center;">Terima Pengembalian Real (L)</th>
                           <th rowspan="2" style="text-align:center;">Keterangan</th>
                        </tr>
                        <tr>
                           <th>0</th>
                           <th>1</th>
                           <th>2</th>
                           <th>3</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>   

      <div class="modal fade modal-lg" id="modal_rekap_bio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="modal_rekap_bio_judul">Rekap Komponen BIO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  <input type="hidden" name="id_komponen_modal" id="id_komponen_modal">
                  </button>
               </div>
               <div id="div_load2">
                  <div id="div_progress2">
                    <div id="div_bar2">0%</div>
                  </div>
               </div>                
               <div class="modal-body">
                  <div class="pull-right">
                     <input type="text" id="cariRekapBio" name="cariRekapBio" value="" placeholder="Cari Unit, No Penerimaan" class="input-large">
                     <button type="button" class="btn" name="button" id="btnCariRekapBio">Cari</button>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel-bio'
                        )); ?>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf-bio'
                        )); ?>
                  </div>
                  <table id="dataTable_rekap_bio" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                     <thead>
                        <tr>
                           <th rowspan="2">No</th>
                           <th rowspan="2">Kode Unit</th>
                           <th rowspan="2">Unit</th>
                           <th rowspan="2">Id BBM</th>
                           <th rowspan="2">Jenis Bahan Bakar</th>
                           <th rowspan="2">Id Komponen</th>
                           <th rowspan="2">Komponen</th>
                           <th rowspan="2">Tgl Awal Terima</th>
                           <th rowspan="2">Tgl Akhir Terima</th>
                           <th colspan="4">Jenis Penerimaan</th>
                           <th colspan="2">Total Volume Terima</th>
                           <th rowspan="2">AKSI</th>
                        </tr>
                        <tr>
                           <th style="text-align:center;">Total</th>
                           <th style="text-align:center;">Unit Lain</th>
                           <th style="text-align:center;">Pemasok</th>
                           <th style="text-align:center;">Pengembalian</th>
                           <th style="text-align:center;">DO (L)</th>
                           <th style="text-align:center;">Real (L)</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade modal-lg" id="modal_detail_bio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="modal_detail_bio_label">Detail Komponen BIO</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div id="div_load3">
                  <div id="div_progress3">
                    <div id="div_bar3">0%</div>
                  </div>
               </div>                
               <div class="modal-body">
                  <div class="pull-right">
                     <input type="text" id="cariDetailBio" name="cariDetailBio" value="" placeholder="Cari Unit, No Penerimaan" class="input-large">
                     <button type="button" class="btn" name="button" id="btnCariDetailBio">Cari</button>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel-detail-bio'
                        )); ?>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf-detail-bio'
                        )); ?>
                  </div>
                  <table id="dataTable_detail_bio" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                     <thead>
                        <tr>
                           <th rowspan="2">NO</th>
                           <th colspan="4">Level</th>
                           <th rowspan="2" style="text-align:center;">Unit Pembangkit</th>
                           <th rowspan="2" style="text-align:center;">Bahan Bakar</th>
                           <th rowspan="2">No Penerimaan</th>
                           <th rowspan="2">Asal Pasokan</th>
                           <th rowspan="2" style="text-align:center;">Nama Transportir</th>
                           <th rowspan="2" style="text-align:center;">Tanggal DO</th>
                           <th rowspan="2" style="text-align:center;">Tanggal Terima Fisik</th>
                           <th rowspan="2" style="text-align:center;">Volume Terima DO (L)</th>
                           <th rowspan="2" style="text-align:center;">Volume Terima Real (L)</th>
                           <th rowspan="2" style="text-align:center;">Terima Pengembalian (L)</th>
                           <th rowspan="2" style="text-align:center;">Terima Pengembalian Real (L)</th>
                           <th rowspan="2" style="text-align:center;">Keterangan</th>
                        </tr>
                        <tr>
                           <th>0</th>
                           <th>1</th>
                           <th>2</th>
                           <th>3</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>   

   </div>
</div>
<br>

<input type="hidden" name="halaman_detail" value="1">
<input type="hidden" name="menu_detail" value="">

<form id="export_excel" action="<?php echo base_url('laporan/penerimaan/export_excel'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl2">
   <input type="hidden" name="xlvl3">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xlvl2_nama">
   <input type="hidden" name="xlvl3_nama">
   <input type="hidden" name="xlvl4">
   <input type="hidden" name="xbbm">
   <input type="hidden" name="xbln">
   <input type="hidden" name="xthn">
   <input type="hidden" name="xlvlid">
   <input type="hidden" name="xlvl">
   <input type="hidden" name="xtglawal">
   <input type="hidden" name="xtglakhir">
   <input type="hidden" name="xcari">
</form>

<form id="export_excel_bio" action="<?php echo base_url('laporan/penerimaan/export_excel_bio'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl2">
   <input type="hidden" name="xlvl3">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xlvl2_nama">
   <input type="hidden" name="xlvl3_nama">
   <input type="hidden" name="xlvl4">
   <input type="hidden" name="xbbm">
   <input type="hidden" name="xbln">
   <input type="hidden" name="xthn">
   <input type="hidden" name="xlvlid">
   <input type="hidden" name="xlvl">
   <input type="hidden" name="xtglawal">
   <input type="hidden" name="xtglakhir">
   <input type="hidden" name="xcari">
   <input type="hidden" name="xkode_unit">
   <input type="hidden" name="xtglawal_bio">
   <input type="hidden" name="xtglakhir_bio">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/penerimaan/export_pdf'); ?>" method="post"  target="_blank">
   <input type="hidden" name="plvl0">
   <input type="hidden" name="plvl1">
   <input type="hidden" name="plvl2">
   <input type="hidden" name="plvl3">
   <input type="hidden" name="plvl0_nama">
   <input type="hidden" name="plvl1_nama">
   <input type="hidden" name="plvl2_nama">
   <input type="hidden" name="plvl3_nama">
   <input type="hidden" name="plvl4">
   <input type="hidden" name="pbbm">
   <input type="hidden" name="pbln">
   <input type="hidden" name="pthn">
   <input type="hidden" name="plvlid">
   <input type="hidden" name="plvl">
   <input type="hidden" name="ptglawal">
   <input type="hidden" name="ptglakhir">
   <input type="hidden" name="pcari">
</form>

<form id="export_pdf_bio" action="<?php echo base_url('laporan/penerimaan/export_pdf_bio'); ?>" method="post"  target="_blank">
   <input type="hidden" name="plvl0">
   <input type="hidden" name="plvl1">
   <input type="hidden" name="plvl2">
   <input type="hidden" name="plvl3">
   <input type="hidden" name="plvl0_nama">
   <input type="hidden" name="plvl1_nama">
   <input type="hidden" name="plvl2_nama">
   <input type="hidden" name="plvl3_nama">
   <input type="hidden" name="plvl4">
   <input type="hidden" name="pbbm">
   <input type="hidden" name="pbln">
   <input type="hidden" name="pthn">
   <input type="hidden" name="plvlid">
   <input type="hidden" name="plvl">
   <input type="hidden" name="ptglawal">
   <input type="hidden" name="ptglakhir">
   <input type="hidden" name="pcari">
   <input type="hidden" name="pkode_unit">
   <input type="hidden" name="ptglawal_bio">
   <input type="hidden" name="ptglakhir_bio">    
</form>

<!-- Tombol Excel dan PDF - Modal DETAIL -->
<form id="export_excel_detail" action="<?php echo base_url('laporan/penerimaan/export_excel_detail'); ?>" method="post">
   <input type="hidden" name="xlvl0_detail">
   <input type="hidden" name="xlvl1_detail">
   <input type="hidden" name="xlvl2_detail">
   <input type="hidden" name="xlvl3_detail">
   <input type="hidden" name="xlvl0_nama_detail">
   <input type="hidden" name="xlvl1_nama_detail">
   <input type="hidden" name="xlvl2_nama_detail">
   <input type="hidden" name="xlvl3_nama_detail">
   <input type="hidden" name="xlvl4_detail">
   <input type="hidden" name="xbbm_detail">
   <input type="hidden" name="xbln_detail">
   <input type="hidden" name="xthn_detail">
   <input type="hidden" name="xlvlid_detail">
   <input type="hidden" name="xlvl_detail">
   <input type="hidden" name="xtglawal_detail">
   <input type="hidden" name="xtglakhir_detail">
   <input type="hidden" name="xkodeUnit_detail">
   <input type="hidden" name="xidbbm_detail">
</form>

<form id="export_pdf_detail" action="<?php echo base_url('laporan/penerimaan/export_pdf_detail_newVersion'); ?>" method="post" target="_blank">
   <input type="hidden" name="plvl0_detail">
   <input type="hidden" name="plvl1_detail">
   <input type="hidden" name="plvl2_detail">
   <input type="hidden" name="plvl3_detail">
   <input type="hidden" name="plvl0_nama_detail">
   <input type="hidden" name="plvl1_nama_detail">
   <input type="hidden" name="plvl2_nama_detail">
   <input type="hidden" name="plvl3_nama_detail">
   <input type="hidden" name="plvl4_detail">
   <input type="hidden" name="pbbm_detail">
   <input type="hidden" name="pbln_detail">
   <input type="hidden" name="pthn_detail">
   <input type="hidden" name="plvlid_detail">
   <input type="hidden" name="plvl_detail">
   <input type="hidden" name="ptglawal_detail">
   <input type="hidden" name="ptglakhir_detail">
   <input type="hidden" name="ptglawal_detail">
   <input type="hidden" name="ptglakhir_detail">
   <input type="hidden" name="pkodeUnit_detail">
   <input type="hidden" name="pidbbm_detail">
</form>

<form id="export_excel_detail_bio" action="<?php echo base_url('laporan/penerimaan/export_excel_detail_bio'); ?>" method="post">
   <input type="hidden" name="xlvl0_detail">
   <input type="hidden" name="xlvl1_detail">
   <input type="hidden" name="xlvl2_detail">
   <input type="hidden" name="xlvl3_detail">
   <input type="hidden" name="xlvl0_nama_detail">
   <input type="hidden" name="xlvl1_nama_detail">
   <input type="hidden" name="xlvl2_nama_detail">
   <input type="hidden" name="xlvl3_nama_detail">
   <input type="hidden" name="xlvl4_detail">
   <input type="hidden" name="xbbm_detail">
   <input type="hidden" name="xbln_detail">
   <input type="hidden" name="xthn_detail">
   <input type="hidden" name="xlvlid_detail">
   <input type="hidden" name="xlvl_detail">
   <input type="hidden" name="xtglawal_detail">
   <input type="hidden" name="xtglakhir_detail">
   <input type="hidden" name="xkodeUnit_detail">
   <input type="hidden" name="xidbbm_detail">
</form>

<form id="export_pdf_detail_bio" action="<?php echo base_url('laporan/penerimaan/export_pdf_detail_bio'); ?>" method="post" target="_blank">
   <input type="hidden" name="plvl0_detail">
   <input type="hidden" name="plvl1_detail">
   <input type="hidden" name="plvl2_detail">
   <input type="hidden" name="plvl3_detail">
   <input type="hidden" name="plvl0_nama_detail">
   <input type="hidden" name="plvl1_nama_detail">
   <input type="hidden" name="plvl2_nama_detail">
   <input type="hidden" name="plvl3_nama_detail">
   <input type="hidden" name="plvl4_detail">
   <input type="hidden" name="pbbm_detail">
   <input type="hidden" name="pbln_detail">
   <input type="hidden" name="pthn_detail">
   <input type="hidden" name="plvlid_detail">
   <input type="hidden" name="plvl_detail">
   <input type="hidden" name="ptglawal_detail">
   <input type="hidden" name="ptglakhir_detail">
   <input type="hidden" name="ptglawal_detail">
   <input type="hidden" name="ptglakhir_detail">
   <input type="hidden" name="pkodeUnit_detail">
   <input type="hidden" name="pidbbm_detail">
</form>

<form id="export_csv" action="<?php echo base_url('laporan/penerimaan/generateXls'); ?>" method="post" target="_blank">
   <input type="hidden" name="clvl0">
   <input type="hidden" name="clvl1">
   <input type="hidden" name="clvl2">
   <input type="hidden" name="clvl3">
   <input type="hidden" name="clvl0_nama">
   <input type="hidden" name="clvl1_nama">
   <input type="hidden" name="clvl2_nama">
   <input type="hidden" name="clvl3_nama">
   <input type="hidden" name="clvl4">
   <input type="hidden" name="cbbm">
   <input type="hidden" name="cbln">
   <input type="hidden" name="cthn">
   <input type="hidden" name="clvlid">
   <input type="hidden" name="clvl">
   <input type="hidden" name="ctglawal">
   <input type="hidden" name="ctglakhir">
   <input type="hidden" name="ccari">
</form>


<script type = "text/javascript" >
    $('html, body').animate({
        scrollTop: $("#divTop").offset().top
    }, 1000);

var today = new Date();
var year = today.getFullYear();

$('select[name="TAHUN"]').val(year);

$(document).ready(function() {
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function setCekTgl() {
        var dateStart = $('#tglawal').val();
        var dateEnd = $('#tglakhir').val();

        if (dateEnd < dateStart) {
            $('#tglakhir').datepicker('update', dateStart);
        }
    }

    $('#tglawal').on('change', function() {
        var dateStart = $(this).val();
        $('#tglakhir').datepicker('setStartDate', dateStart);
        if ($('#tglakhir').val() == '') {

        } else {
            setCekTgl();
        }
    });

    $('#tglakhir').on('change', function() {
        setCekTgl();
    });

    $('#button-detail').addClass('disabled');
    // $("#button-detail").attr("disabled", true);
});

function convertToRupiah(angka) {
    var bilangan = angka.replace(".", ",");

    var number_string = bilangan.toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    return rupiah;
}

$(document).ready(function() {
    $('#dataTable').dataTable({
        "scrollY": "450px",
        "searching": false,
        "scrollX": true,
        "scrollCollapse": false,
        "bPaginate": true,

        "bLengthChange": true,
        "pageLength": 10,
        "bFilter": false,
        "bInfo": true,
        "bAutoWidth": true,
        "ordering": true,
        "fixedHeader": true,
        "lengthMenu": [10, 25, 50, 100, 200],
        "language": {
            "decimal": ",",
            "thousands": ".",
            "emptyTable": "Tidak ada data untuk ditampilkan",
            "info": "Total Data: _MAX_",
            "infoEmpty": "Total Data: 0",
            "lengthMenu": "Jumlah Data _MENU_"
        },
        "columnDefs": [{
                "orderable": false,
                "targets": [-1]
            },
            {
                "targets": [1],
                "visible": false
            },
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
            },
            {
                "targets": [3],
                "visible": false
            },
            {
                "className": "dt-right",
                "targets": [5, 6, 7, 8, 9, 10, 11, 12]
            },
            {
                "className": "dt-center",
                "targets": [0, 3, 4]
            },
            {
                "className": "dt-left",
                "targets": [2]
            },
        ]
    });
});

function tampilData_default() {
    $('#tampilData').val('-Tampilkan Data-');
    $('#tampilData_detail').val('-Tampilkan Data-');
}

function clearDT_Detail() {
    var t = $('#dataTable_detail').DataTable();
    $('#dataTable_detail').addClass('auto');
    t.clear().draw();
}

function clearDT_Detail_bio() {
    var t = $('#dataTable_detail_bio').DataTable();
    $('#dataTable_detail_bio').addClass('auto');
    t.clear().draw();
}

function clearDT_Rekap_Bio() {
    var t2 = $('#dataTable_rekap_bio').DataTable();
    $('#dataTable_rekap_bio').addClass('auto');
    t2.clear().draw();
}

function clearCari() {

    $('#cariDetail').val('');
}

function clearCariDetailBio() {

    $('#cariDetailBio').val('');
}

function clearCariBio() {
   
    $('#cariRekapBio').val('');
}

$('#dataTable tbody').on('click', 'button', function() {
    tampilData_default();
    clearDT_Detail();
    clearDT_Rekap_Bio();
    clearCari();
    clearCariBio();
    // document.body.style.zoom = "100%"?
    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
    var t = $('#dataTable').DataTable();

    var selected_row = t.row($(this).parents('tr')).data();

    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

    var kode_unit = selected_row[1];
    var jumlah_terima = selected_row[7];
    var id_bbm = selected_row[3];
    var tglAwal = selected_row[5].replace(/-/g, '');
    var tglAwal_tahun = tglAwal.substring(0, 4);
    var tglAwal_bulan = tglAwal.substring(4, 6);
    var tglAwal_hari = tglAwal.substring(6, 8);
    var parsed_tglawal = tglAwal_hari.concat(tglAwal_bulan, tglAwal_tahun);

    var tglAkhir = selected_row[6].replace(/-/g, '');
    var tglAkhir_tahun = tglAkhir.substring(0, 4);
    var tglAkhir_bulan = tglAkhir.substring(4, 6);
    var tglAkhir_hari = tglAkhir.substring(6, 8);
    var parsed_tglakhir = tglAkhir_hari.concat(tglAkhir_bulan, tglAkhir_tahun);

    $('input[name="xbbm"]').val(id_bbm); // 001      
    $('input[name="xkode_unit"]').val(kode_unit);
    $('input[name="xtglawal_bio"]').val(parsed_tglawal);
    $('input[name="xtglakhir_bio"]').val(parsed_tglakhir);
    $('input[name="xidbbm_detail"]').val(id_bbm);

    $('input[name="xkodeUnit_detail"]').val(kode_unit);
    $('input[name="xtglawal_detail"]').val(parsed_tglawal);
    $('input[name="xtglakhir_detail"]').val(parsed_tglakhir);


    $('input[name="pbbm"]').val(id_bbm); // 001      
    $('input[name="pkode_unit"]').val(kode_unit);
    $('input[name="ptglawal_bio"]').val(parsed_tglawal);
    $('input[name="ptglakhir_bio"]').val(parsed_tglakhir);
    $('input[name="pidbbm_detail"]').val(id_bbm);

    $('input[name="pkodeUnit_detail"]').val(kode_unit);
    $('input[name="ptglawal_detail"]').val(parsed_tglawal);
    $('input[name="ptglakhir_detail"]').val(parsed_tglakhir);

    if (id_bbm == '003') {
        var tdetail_bio = $('#dataTable_rekap_bio').DataTable({
            "pageLength": 10,
            destroy: true,
            responsive: true,
            "bLengthChange": true,
            "scrollY": "450px",
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "bFilter": true,
            "searching": true,
            "bInfo": true,
            "autoWidth": true,
            "lengthMenu": [10, 25, 50, 100, 200],
            "ordering": true,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "processing": "Memuat...",
                "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "info": "Total Data: _TOTAL_",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "infoEmpty": "Total Data: 0",
                "lengthMenu": "Jumlah Data _MENU_"
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": [-1]
                },
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
                },
                {
                    "className": "dt-right",
                    "targets": [7, 8, 9, 10, 11, 12, 13, 14, 15]
                },
                {
                    "className": "dt-center",
                    "targets": [0, 2, 3, 4, 5, 6]
                },
                {
                    "targets": [1, 3, 5],
                    "visible": false
                },
            ]
        });

        $.ajax({
                url: "<?php echo base_url('laporan/penerimaan/getDataDetail'); ?>",
                type: 'POST',
                data: {
                    "detail_id_bbm": id_bbm,
                    "detail_tgl_awal": parsed_tglawal,
                    "detail_tgl_akhir": parsed_tglakhir,
                    "detail_kode_unit": kode_unit,
                    "halaman": '1'
                }
            })
            .done(function(data) {
                var detail_parser = JSON.parse(data);
                var nomer = 1;
                var total = detail_parser.length;
                var progres = 0;
                var elem = document.getElementById("div_bar2");

                $.each(detail_parser, function(index, el) {
                    setTimeout(function() {

                        var KODE = el.KODE == null ? "" : el.KODE;
                        var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                        var ID_BBM = el.ID_BBM == null ? "" : el.ID_BBM;
                        var BHN_BAKAR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
                        var JNS_BIO = el.JNS_BIO == null ? "" : el.JNS_BIO;
                        var KOMPONEN_BIO = el.KOMPONEN_BIO == null ? "" : el.KOMPONEN_BIO;
                        var TGL_TERIMA_AWAL = el.TGL_TERIMA_AWAL == null ? "" : el.TGL_TERIMA_AWAL;
                        var TGL_TERIMA_AKHIR = el.TGL_TERIMA_AKHIR == null ? "" : el.TGL_TERIMA_AKHIR;
                        var JML_TERIMA = el.JML_TERIMA == null ? "0" : el.JML_TERIMA;
                        var TERIMA_UNIT_LAIN = el.TERIMA_UNIT_LAIN == null ? "0" : el.TERIMA_UNIT_LAIN;
                        var TERIMA_PEMASOK = el.TERIMA_PEMASOK == null ? "0" : el.TERIMA_PEMASOK;
                        var TERIMA_PENGEMBALIAN = el.TERIMA_PENGEMBALIAN == null ? "0" : el.TERIMA_PENGEMBALIAN;
                        var VOL_TERIMA = el.VOL_TERIMA == null ? "0" : el.VOL_TERIMA;
                        var VOL_TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "0" : el.VOL_TERIMA_REAL;

                        tdetail_bio.row.add([
                            nomer, KODE, UNIT_PEMBANGKIT, ID_BBM, BHN_BAKAR, JNS_BIO, KOMPONEN_BIO, TGL_TERIMA_AWAL, TGL_TERIMA_AKHIR,
                            JML_TERIMA, TERIMA_UNIT_LAIN, TERIMA_PEMASOK, TERIMA_PENGEMBALIAN,
                            convertToRupiah(VOL_TERIMA), convertToRupiah(VOL_TERIMA_REAL)
                        ]).draw(false);

                        if (nomer == 1) {
                            bootbox.hideAll();
                            $('#div_load2').show();
                            bootbox.dialog('<div class="loading-progress"></div>');
                        }

                        progres = Math.ceil((nomer / total) * 100);
                        elem.style.width = progres + '%';
                        elem.innerHTML = progres * 1 + '%   (' + nomer + ' dari ' + total + ')';

                        if (nomer >= total) {
                            bootbox.hideAll();
                            $('#div_load2').hide('slow');
                        }

                        nomer++;

                    }, 0);
                });

            });

        $('#modal_rekap_bio').modal('show');
    } else {
        var tdetail = $('#dataTable_detail').DataTable({
            //Button for NEXT and PREVIOUS event

            "pageLength": 10,
            destroy: true,
            responsive: true,
            "bLengthChange": true,
            "scrollY": "450px",
            "scrollX": true,
            "scrollCollapse": false,
            // "scrollX": true,
            "bPaginate": true,
            "bFilter": true,
            "searching": true,
            "bInfo": true,
            "autoWidth": true,
            "lengthMenu": [10, 25, 50, 100, 200],
            "ordering": true,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "processing": "Memuat...",
                "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "info": "Total Data: _TOTAL_",
                "infoFiltered": "(difilter dari _MAX_ total entri)",
                "infoEmpty": "Total Data: 0",
                "lengthMenu": "Jumlah Data _MENU_"
            },
            "columnDefs": [{
                    "searchable": false,
                    "targets": [0, 8, 9, 10, 11, 12, 13, 14]
                },
                {
                    "className": "dt-left",
                    "targets": [1, 2, 3, 4]
                },
                {
                    "className": "dt-center",
                    "targets": [0, 5, 6]
                },
                {
                    "className": "dt-right",
                    "targets": [-1, -2, -3, -4]
                },
            ]
        });


        $.ajax({
                url: "<?php echo base_url('laporan/penerimaan/getDataDetail'); ?>",
                // url : "<?php echo base_url('laporan/penerimaan/fetchData'); ?>",
                type: 'POST',
                data: {
                    "detail_id_bbm": id_bbm,
                    // "detail_bulan": bln,
                    // "detail_tahun": thn,
                    "detail_tgl_awal": parsed_tglawal,
                    "detail_tgl_akhir": parsed_tglakhir,
                    "detail_kode_unit": kode_unit,
                    "halaman": '1'
                }
            })
            .done(function(data) {
                var detail_parser = JSON.parse(data);
                var nomer = 1;
                var total = detail_parser.length;
                var progres = 0;
                var elem = document.getElementById("div_bar");

                $.each(detail_parser, function(index, el) {
                    setTimeout(function() {
                        var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                        var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                        var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                        var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                        var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                        var BHN_BAKAR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
                        // var JENIS_PENERIMAAN = el.JENIS_PENERIMAAN == null ? "" : el.JENIS_PENERIMAAN;
                        var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
                        var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
                        var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
                        var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
                        var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
                        var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
                        var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
                        var KET = el.KETERANGAN == null ? "" : el.KETERANGAN;

                        var TERIMA_KEMBALI = el.TERIMA_PENGEMBALIAN == null ? "0" : el.TERIMA_PENGEMBALIAN;
                        var TERIMA_KEMBALI_REAL = el.TERIMA_REAL_PENGEMBALIAN == null ? "0" : el.TERIMA_REAL_PENGEMBALIAN;
                        // var DEVIASI = el.DEVIASI == null ? "" : el.DEVIASI;
                        // var DEVIASI_PERCENT = el.DEVIASI_PERCENT == null ? "" : el.DEVIASI_PERCENT;

                        tdetail.row.add([
                            nomer, level0, level1, level2, level3, UNIT_PEMBANGKIT, BHN_BAKAR,
                            NOMER_PENERIMAAN,
                            NAMA_PEMASOK, NAMA_TRANSPORTIR, TGL_DO,
                            TGL_TERIMA_FISIK, convertToRupiah(VOL_DO),
                            convertToRupiah(TERIMA_REAL),
                            convertToRupiah(TERIMA_KEMBALI),
                            convertToRupiah(TERIMA_KEMBALI_REAL),
                            KET
                        ]).draw(false);

                        if (nomer == 1) {
                            bootbox.hideAll();
                            $('#div_load').show();
                            bootbox.dialog('<div class="loading-progress"></div>');
                        }

                        progres = Math.ceil((nomer / total) * 100);
                        elem.style.width = progres + '%';
                        elem.innerHTML = progres * 1 + '%   (' + nomer + ' dari ' + total + ')';

                        if (nomer >= total) {
                            bootbox.hideAll();
                            $('#div_load').hide('slow');
                        }
                        nomer++;

                    }, 0);
                });

            });
        $('#exampleModal').modal('show');
    }

    // bootbox.hideAll();
});

$('#dataTable_rekap_bio tbody').on('click', 'button', function() {
    // tampilData_default();
    clearDT_Detail_bio();
    clearCariDetailBio();
    // document.body.style.zoom = "100%"?
    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
    var t = $('#dataTable_rekap_bio').DataTable();

    var selected_row = t.row($(this).parents('tr')).data();

    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

    var kode_unit = selected_row[1];
    var jumlah_terima = selected_row[7];
    var id_bbm = selected_row[3];
    var id_komponen = selected_row[5];
    var tglAwal = selected_row[7].replace(/-/g, '');
    var tglAwal_tahun = tglAwal.substring(0, 4);
    var tglAwal_bulan = tglAwal.substring(4, 6);
    var tglAwal_hari = tglAwal.substring(6, 8);
    var parsed_tglawal = tglAwal_hari.concat(tglAwal_bulan, tglAwal_tahun);

    var tglAkhir = selected_row[8].replace(/-/g, '');
    var tglAkhir_tahun = tglAkhir.substring(0, 4);
    var tglAkhir_bulan = tglAkhir.substring(4, 6);
    var tglAkhir_hari = tglAkhir.substring(6, 8);
    var parsed_tglakhir = tglAkhir_hari.concat(tglAkhir_bulan, tglAkhir_tahun);

    $('input[name="xkodeUnit_detail"]').val(kode_unit);
    $('input[name="xtglawal_detail"]').val(parsed_tglawal);
    $('input[name="xtglakhir_detail"]').val(parsed_tglakhir);
    $('input[name="xidbbm_detail"]').val(id_komponen);

    $('input[name="pkodeUnit_detail"]').val(kode_unit);
    $('input[name="ptglawal_detail"]').val(parsed_tglawal);
    $('input[name="ptglakhir_detail"]').val(parsed_tglakhir);
    $('input[name="pidbbm_detail"]').val(id_komponen);


    var tdetail = $('#dataTable_detail_bio').DataTable({
        "pageLength": 10,
        destroy: true,
        responsive: true,
        "bLengthChange": true,
        "scrollY": "450px",
        "scrollX": true,
        "scrollCollapse": false,
        // "scrollX": true,
        "bPaginate": true,
        "bFilter": true,
        "searching": true,
        "bInfo": true,
        "autoWidth": true,
        "lengthMenu": [10, 25, 50, 100, 200],
        "ordering": true,
        "language": {
            "decimal": ",",
            "thousands": ".",
            "processing": "Memuat...",
            "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
            "emptyTable": "Tidak ada data untuk ditampilkan",
            "info": "Total Data: _TOTAL_",
            "infoFiltered": "(difilter dari _MAX_ total entri)",
            "infoEmpty": "Total Data: 0",
            "lengthMenu": "Jumlah Data _MENU_"
        },
        "columnDefs": [{
                "searchable": false,
                "targets": [0, 8, 9, 10, 11, 12, 13, 14]
            },
            {
                "className": "dt-left",
                "targets": [1, 2, 3, 4]
            },
            {
                "className": "dt-center",
                "targets": [0, 5, 6]
            },
            {
                "className": "dt-right",
                "targets": [-1, -2, -3, -4]
            },
        ]
    });

    $.ajax({
            url: "<?php echo base_url('laporan/penerimaan/getDataDetailBIO'); ?>",
            type: 'POST',
            data: {
                "detail_id_bbm": id_komponen,
                "detail_tgl_awal": parsed_tglawal,
                "detail_tgl_akhir": parsed_tglakhir,
                "detail_kode_unit": kode_unit,
                "halaman": '1'
            }
        })
        .done(function(data) {
            var detail_parser = JSON.parse(data);
            var nomer = 1;
            var total = detail_parser.length;
            var progres = 0;
            var elem = document.getElementById("div_bar3");

            $.each(detail_parser, function(index, el) {
                setTimeout(function() {
                    var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                    var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                    var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                    var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                    var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                    var BHN_BAKAR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
                    // var JENIS_PENERIMAAN = el.JENIS_PENERIMAAN == null ? "" : el.JENIS_PENERIMAAN;
                    var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
                    var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
                    var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
                    var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
                    var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
                    var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
                    var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
                    var KET = el.KETERANGAN == null ? "" : el.KETERANGAN;

                    var TERIMA_KEMBALI = el.TERIMA_PENGEMBALIAN == null ? "0" : el.TERIMA_PENGEMBALIAN;
                    var TERIMA_KEMBALI_REAL = el.TERIMA_REAL_PENGEMBALIAN == null ? "0" : el.TERIMA_REAL_PENGEMBALIAN;
                    // var DEVIASI = el.DEVIASI == null ? "" : el.DEVIASI;
                    // var DEVIASI_PERCENT = el.DEVIASI_PERCENT == null ? "" : el.DEVIASI_PERCENT;

                    tdetail.row.add([
                        nomer, level0, level1, level2, level3, UNIT_PEMBANGKIT, BHN_BAKAR,
                        NOMER_PENERIMAAN,
                        NAMA_PEMASOK, NAMA_TRANSPORTIR, TGL_DO,
                        TGL_TERIMA_FISIK, convertToRupiah(VOL_DO),
                        convertToRupiah(TERIMA_REAL),
                        convertToRupiah(TERIMA_KEMBALI),
                        convertToRupiah(TERIMA_KEMBALI_REAL),
                        KET
                    ]).draw(false);


                    if (nomer == 1) {
                        bootbox.hideAll();
                        $('#div_load3').show();
                        bootbox.dialog('<div class="loading-progress"></div>');
                    }

                    progres = Math.ceil((nomer / total) * 100);
                    elem.style.width = progres + '%';
                    elem.innerHTML = progres * 1 + '%   (' + nomer + ' dari ' + total + ')';

                    if (nomer >= total) {
                        bootbox.hideAll();
                        $('#div_load3').hide('slow');
                    }
                    nomer++;

                }, 0);
            });

        });
    $('#modal_detail_bio').modal('show');

    // bootbox.hideAll();
});

$('#btnCariDetail').on('click', function() {
    var cariDetail = $('#cariDetail').val();
    var table = $('#dataTable_detail').DataTable();
    table.search(cariDetail, false, true, true).draw();
});

$('#btnCariDetailBio').on('click', function() {
    var cariDetailBio = $('#cariDetailBio').val();
    var table = $('#dataTable_detail_bio').DataTable();
    table.search(cariDetailBio, false, true, true).draw();
});

$('#btnCariRekapBio').on('click', function() {
    var cariDetail = $('#cariRekapBio').val();
    var table = $('#dataTable_rekap_bio').DataTable();
    table.search(cariDetail, false, true, true).draw();
});

$('#cariDetail').keyup(function(e) {
    if (e.keyCode == 13) {
        $('#btnCariDetail').click();
    }
});

$('#cariDetailBio').keyup(function(e) {
    if (e.keyCode == 13) {
        $('#btnCariDetailBio').click();
    }
});

$('#cariRekapBio').keyup(function(e) {
    if (e.keyCode == 13) {
        $('#btnCariRekapBio').click();
    }
});

$('#cariPembangkit').keyup(function(e) {
    if (e.keyCode == 13) {
        $('#button-load').click();
    }
});

$('#button-load').click(function(e) {
    // $(".bdet").attr("disabled", true);
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown
    var tglAwal = $('#tglawal').val().replace(/-/g, ''); //02-11-2018
    var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
    var cari = $('#cariPembangkit').val();

    var awal_tahun = tglAwal.substring(0, 4);
    var awal_bulan = tglAwal.substring(4, 6);
    var awal_hari = tglAwal.substring(6, 8);
    var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

    var akhir_tahun = tglAkhir.substring(0, 4);
    var akhir_bulan = tglAkhir.substring(4, 6);
    var akhir_hari = tglAkhir.substring(6, 8);
    var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else if (tglAwal == '' && tglAkhir != '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
    } else if (tglAkhir == '' && tglAwal != '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        if (tglAwal == '' && tglAkhir == '') {
            awalParsed = "-";
            akhirParsed = '-';
        }

        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('laporan/penerimaan/getData'); ?>",
            data: {
                "JENIS_BBM": bbm,
                // "BULAN":bln,
                // "TAHUN": thn,
                "TGLAWAL": awalParsed,
                "TGLAKHIR": akhirParsed,
                "ID_REGIONAL": lvl0,
                "VLEVELID": vlevelid,
                "cari": cari,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                var t = $('#dataTable').DataTable();
                t.clear().draw();

                if (obj == "" || obj == null) {
                    bootbox.hideAll();
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                } else {

                    var nomer = 1;
                    $.each(obj, function(index, value) {
                        var UNIT = value.UNIT == null ? "" : value.UNIT;
                        var KODE_UNIT = value.KODE == null ? "" : value.KODE;
                        var ID_BBM = value.ID_BBM == null ? "" : value.ID_BBM;
                        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                        var TGL_TERIMA_AWAL = value.TGL_TERIMA_AWAL == null ? "" : value.TGL_TERIMA_AWAL;
                        var TGL_TERIMA_AKHIR = value.TGL_TERIMA_AKHIR == null ? "" : value.TGL_TERIMA_AKHIR;
                        var JML_TERIMA = value.JML_TERIMA == null ? "" : value.JML_TERIMA;

                        var TERIMA_UNIT_LAIN = value.TERIMA_UNIT_LAIN == null ? "" : value.TERIMA_UNIT_LAIN;
                        var TERIMA_PEMASOK = value.TERIMA_PEMASOK == null ? "" : value.TERIMA_PEMASOK;
                        var TERIMA_PENGEMBALIAN = value.TERIMA_PENGEMBALIAN == null ? "" : value.TERIMA_PENGEMBALIAN;

                        var VOL_TOTAL_TERIMA = value.VOL_TERIMA == null ? "" : value.VOL_TERIMA;
                        var VOL_TOTAL_TERIMA_REAL = value.VOL_TERIMA_REAL == null ? "" : value.VOL_TERIMA_REAL;
                        // var DEVIASI = value.DEVIASI == null ? "" : value.DEVIASI;
                        // var DEVIASI_PERCENT = value.DEVIASI_PERCENT == null ? "" : value.DEVIASI_PERCENT;


                        t.row.add([
                            nomer, KODE_UNIT,
                            UNIT, ID_BBM,
                            NAMA_JNS_BHN_BKR, TGL_TERIMA_AWAL,
                            TGL_TERIMA_AKHIR, convertToRupiah(JML_TERIMA),
                            convertToRupiah(TERIMA_UNIT_LAIN), convertToRupiah(TERIMA_PEMASOK), convertToRupiah(TERIMA_PENGEMBALIAN),
                            convertToRupiah(VOL_TOTAL_TERIMA), convertToRupiah(VOL_TOTAL_TERIMA_REAL)
                        ]).draw(false);
                        nomer++;
                    });
                    bootbox.hideAll();
                    $('html, body').animate({
                        scrollTop: $("#divTable").offset().top
                    }, 1000);
                };
            }
        });
    };
});

$('#cariPembangkit').on('keyup', function() {
    var table = $('#dataTable').DataTable();
    table.search(this.value).draw();
});

//Untuk button tampilkan data
$('#tampilData').on('change', function() {
    oTable = $('#dataTable').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = this.value;
    oTable.fnDraw();
});

$('#tampilData_detail').on('change', function() {
    oTable = $('#dataTable_detail').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = this.value;
    oTable.fnDraw();
});

$('#button-excel').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var cari = $('#cariPembangkit').val(); //bahanBakar dropdown
    // var bln = $('#bln').val(); //bulan dropdown
    // var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="xlvl0"]').val($('#lvl0').val());
        $('input[name="xlvl1"]').val($('#lvl1').val());
        $('input[name="xlvl2"]').val($('#lvl2').val());
        $('input[name="xlvl3"]').val($('#lvl3').val());

        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val()); // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xcari"]').val(cari); // 001

        $('input[name="xlvlid"]').val(vlevelid);
        $('input[name="xlvl"]').val(lvl0);
        var tglAwal = $('#tglawal').val().replace(/-/g, '');
        var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
        var awal_tahun = tglAwal.substring(0, 4);
        var awal_bulan = tglAwal.substring(4, 6);
        var awal_hari = tglAwal.substring(6, 8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0, 4);
        var akhir_bulan = tglAkhir.substring(4, 6);
        var akhir_hari = tglAkhir.substring(6, 8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="xtglawal"]').val(tglAwal);
            $('input[name="xtglakhir"]').val(tglAkhir);
        } else {
            $('input[name="xtglawal"]').val(awalParsed);
            $('input[name="xtglakhir"]').val(akhirParsed);
        }

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_excel').submit();
            }
        });
    }
});

$('#button-pdf').click(function(e) {
    var lvl0 = $('#lvl0').val();
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var cari = $('#cariPembangkit').val();

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="plvl0"]').val($('#lvl0').val());
        $('input[name="plvl1"]').val($('#lvl1').val());
        $('input[name="plvl2"]').val($('#lvl2').val());
        $('input[name="plvl3"]').val($('#lvl3').val());

        $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="plvl4"]').val($('#lvl4').val());
        $('input[name="pbbm"]').val(bbm);
        // $('input[name="pbln"]').val($('#bln').val());
        // $('input[name="pthn"]').val($('#thn').val());

        $('input[name="plvlid"]').val(vlevelid);
        $('input[name="plvl"]').val(lvl0);
        $('input[name="pcari"]').val(cari);
        var tglAwal = $('#tglawal').val().replace(/-/g, '');
        var tglAkhir = $('#tglakhir').val().replace(/-/g, '');

        var awal_tahun = tglAwal.substring(0, 4);
        var awal_bulan = tglAwal.substring(4, 6);
        var awal_hari = tglAwal.substring(6, 8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0, 4);
        var akhir_bulan = tglAkhir.substring(4, 6);
        var akhir_hari = tglAkhir.substring(6, 8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        if (tglAwal == '' && tglAkhir == '') {
            awalParsed = "-";
            akhirParsed = '-';
            $('input[name="ptglawal"]').val(awalParsed);
            $('input[name="ptglakhir"]').val(akhirParsed);
        } else {
            $('input[name="ptglawal"]').val(awalParsed);
            $('input[name="ptglakhir"]').val(akhirParsed);
        }

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_pdf').submit();
            }
        });
    }
});

$('#button-excel-bio').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown      
    var cari = $('#cariPembangkit').val(); //bahanBakar dropdown
    // var bln = $('#bln').val(); //bulan dropdown
    // var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }

        $('input[name="xlvl0"]').val($('#lvl0').val());
        $('input[name="xlvl1"]').val($('#lvl1').val());
        $('input[name="xlvl2"]').val($('#lvl2').val());
        $('input[name="xlvl3"]').val($('#lvl3').val());

        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val()); // 183130
        // $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xcari"]').val(cari); // 001

        $('input[name="xlvlid"]').val(vlevelid);
        $('input[name="xlvl"]').val(lvl0);
        var tglAwal = $('#tglawal').val().replace(/-/g, '');
        var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
        var awal_tahun = tglAwal.substring(0, 4);
        var awal_bulan = tglAwal.substring(4, 6);
        var awal_hari = tglAwal.substring(6, 8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0, 4);
        var akhir_bulan = tglAkhir.substring(4, 6);
        var akhir_hari = tglAkhir.substring(6, 8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="xtglawal"]').val(tglAwal);
            $('input[name="xtglakhir"]').val(tglAkhir);
        } else {
            $('input[name="xtglawal"]').val(awalParsed);
            $('input[name="xtglakhir"]').val(akhirParsed);
        }

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_excel_bio').submit();
            }
        });
    }
});

$('#button-pdf-bio').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown      
    var cari = $('#cariPembangkit').val(); //bahanBakar dropdown
    // var bln = $('#bln').val(); //bulan dropdown
    // var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }

        $('input[name="plvl0"]').val($('#lvl0').val());
        $('input[name="plvl1"]').val($('#lvl1').val());
        $('input[name="plvl2"]').val($('#lvl2').val());
        $('input[name="plvl3"]').val($('#lvl3').val());

        $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="plvl4"]').val($('#lvl4').val()); // 183130
        // $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="pcari"]').val(cari); // 001

        $('input[name="plvlid"]').val(vlevelid);
        $('input[name="plvl"]').val(lvl0);
        var tglAwal = $('#tglawal').val().replace(/-/g, '');
        var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
        var awal_tahun = tglAwal.substring(0, 4);
        var awal_bulan = tglAwal.substring(4, 6);
        var awal_hari = tglAwal.substring(6, 8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0, 4);
        var akhir_bulan = tglAkhir.substring(4, 6);
        var akhir_hari = tglAkhir.substring(6, 8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="ptglawal"]').val(tglAwal);
            $('input[name="ptglakhir"]').val(tglAkhir);
        } else {
            $('input[name="ptglawal"]').val(awalParsed);
            $('input[name="ptglakhir"]').val(akhirParsed);
        }

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_pdf_bio').submit();
            }
        });
    }
});

$('#button-excel-detail').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="xlvl0_detail"]').val($('#lvl0').val()); // 01
        $('input[name="xlvl1_detail"]').val($('#lvl1').val()); //COCODE
        $('input[name="xlvl2_detail"]').val($('#lvl2').val());
        $('input[name="xlvl3_detail"]').val($('#lvl3').val());

        $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val()); // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
        $('input[name="xthn"]').val($('#thn').val()); // 2017
        $('input[name="xthn"]').val($('#thn').val());
        $('input[name="xlvl_detail"]').val(vlevelid);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_excel_detail').submit();
            }
        });
    }
});

$('#button-excel-detail-bio').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="xlvl0_detail"]').val($('#lvl0').val()); // 01
        $('input[name="xlvl1_detail"]').val($('#lvl1').val()); //COCODE
        $('input[name="xlvl2_detail"]').val($('#lvl2').val());
        $('input[name="xlvl3_detail"]').val($('#lvl3').val());

        $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val()); // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
        $('input[name="xthn"]').val($('#thn').val()); // 2017
        $('input[name="xthn"]').val($('#thn').val());
        $('input[name="xlvl_detail"]').val(vlevelid);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_excel_detail_bio').submit();
            }
        });
    }
});

$('#button-pdf-detail').click(function(e) {
    var lvl0 = $('#lvl0').val();
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="plvl0_detail"]').val($('#lvl0').val());
        $('input[name="plvl1_detail"]').val($('#lvl1').val());
        $('input[name="plvl2_detail"]').val($('#lvl2').val());
        $('input[name="plvl3_detail"]').val($('#lvl3').val());

        $('input[name="plvl0_nama_detail"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama_detail"]').val($('#lvl3 option:selected').text());
        $('input[name="plvl_detail"]').val(lvl0);

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_pdf_detail').submit();
            }
        });
    }
});

$('#button-pdf-detail-bio').click(function(e) {
    var lvl0 = $('#lvl0').val();
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="plvl0_detail"]').val($('#lvl0').val());
        $('input[name="plvl1_detail"]').val($('#lvl1').val());
        $('input[name="plvl2_detail"]').val($('#lvl2').val());
        $('input[name="plvl3_detail"]').val($('#lvl3').val());

        $('input[name="plvl0_nama_detail"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama_detail"]').val($('#lvl3 option:selected').text());
        $('input[name="plvl_detail"]').val(lvl0);

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_pdf_detail_bio').submit();
            }
        });
    }
});

$('#button-csv').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var cari = $('#cariPembangkit').val(); //bahanBakar dropdown
    // var bln = $('#bln').val(); //bulan dropdown
    // var thn = $('#thn').val(); //tahun dropdown

    if (lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
    } else {
        if (lvl0 !== "") {
            lvl0 = 'Regional';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "Pusat";
            }
        }
        if (lvl1 !== "") {
            lvl0 = 'Level 1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = 'Level 2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== "") {
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if (bbm !== "") {
            bbm = $('#bbm').val();
            if (bbm == '001') {
                bbm = 'MFO';
            } else if (bbm == '002') {
                bbm = 'IDO';
            } else if (bbm == '003') {
                bbm = 'BIO';
            } else if (bbm == '004') {
                bbm = 'HSD+BIO';
            } else if (bbm == '005') {
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '-';
        }

        $('input[name="clvl0"]').val($('#lvl0').val());
        $('input[name="clvl1"]').val($('#lvl1').val());
        $('input[name="clvl2"]').val($('#lvl2').val());
        $('input[name="clvl3"]').val($('#lvl3').val());

        $('input[name="clvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="clvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="clvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="clvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="clvl4"]').val($('#lvl4').val()); // 183130
        $('input[name="cbbm"]').val(bbm); // 001
        $('input[name="ccari"]').val(cari); // 001

        $('input[name="clvlid"]').val(vlevelid);
        $('input[name="clvl"]').val(lvl0);
        var tglAwal = $('#tglawal').val().replace(/-/g, '');
        var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
        var awal_tahun = tglAwal.substring(0, 4);
        var awal_bulan = tglAwal.substring(4, 6);
        var awal_hari = tglAwal.substring(6, 8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0, 4);
        var akhir_bulan = tglAkhir.substring(4, 6);
        var akhir_hari = tglAkhir.substring(6, 8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="ctglawal"]').val(tglAwal);
            $('input[name="ctglakhir"]').val(tglAkhir);
        } else {
            $('input[name="ctglawal"]').val(awalParsed);
            $('input[name="ctglakhir"]').val(akhirParsed);
        }

        bootbox.confirm('Apakah yakin akan export data csv ?', "Tidak", "Ya", function(e) {
            if (e) {
                $('#export_csv').submit();
            }
        });
    }
});

function redraw(data) {
    clearDT_Detail();
    var tdetail = $('#dataTable_detail').DataTable();
    var detail_parser = JSON.parse(data);
    var nomer = 1;

    $.each(detail_parser, function(index, el) {
        var NOMOR = el.NOMOR == null ? "" : el.NOMOR;
        var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
        var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
        var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
        var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
        var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
        var BHN_BAKAR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
        // var JENIS_PENERIMAAN = el.JENIS_PENERIMAAN == null ? "" : el.JENIS_PENERIMAAN;
        var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
        var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
        var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
        var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
        var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
        var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
        var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
        var TERIMA_KEMBALI = el.TERIMA_PENGEMBALIAN == null ? "0" : el.TERIMA_PENGEMBALIAN;
        var TERIMA_KEMBALI_REAL = el.TERIMA_REAL_PENGEMBALIAN == null ? "0" : el.TERIMA_REAL_PENGEMBALIAN;
        // var DEVIASI = el.DEVIASI == null ? "" : el.DEVIASI;
        // var DEVIASI_PERCENT = el.DEVIASI_PERCENT == null ? "" : el.DEVIASI_PERCENT;

        tdetail.row.add([
            NOMOR, level0, level1, level2, level3, UNIT_PEMBANGKIT, BHN_BAKAR,
            NOMER_PENERIMAAN,
            NAMA_PEMASOK, NAMA_TRANSPORTIR, TGL_DO,
            TGL_TERIMA_FISIK, convertToRupiah(VOL_DO),
            convertToRupiah(TERIMA_REAL),
            // convertToRupiah(TERIMA_KEMBALI),
            // convertToRupiah(TERIMA_KEMBALI_REAL),
        ]).draw(false);
        nomer++;
    });
}

function getPageData(halaman, id_bbm, parsed_tglawal, parsed_tglakhir, kode_unit) {

    $.ajax({
            url: 'penerimaan/nextPage',
            type: 'POST',
            data: {
                "detail_id_bbm": id_bbm,
                // "detail_bulan": bln,
                // "detail_tahun": thn,
                "detail_tgl_awal": parsed_tglawal,
                "detail_tgl_akhir": parsed_tglakhir,
                "detail_kode_unit": kode_unit,
                'halaman': halaman,
            }
        })
        .done(function(response) {
            var data = JSON.parse(response);
            redraw(response);
        });
}

function getCurrentPage(dataTable) {
    var oSettings = $('#' + dataTable).dataTable().fnSettings();
    var currentPageIndex = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
    return currentPageIndex;
}

function getValueLengthMenu(dataTable) {
    var table = $('#' + dataTable).DataTable(); //note that you probably already have this call
    var info = table.page.len();
    return info;
}

function getMenuData() {
    var menu = $('select[name="dataTable_detail_length"').val();
    return menu;
}

$('select[name="dataTable_detail_length"]').on('change', function() {
    $('input[name="menu_detail"]').val(this.value);
});
 </script>


<script type="text/javascript">
    jQuery(function($) {
      function setDefaultLv1(){
         $('select[name="COCODE"]').empty();
         $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
      }

      function setDefaultLv2(){
         $('select[name="PLANT"]').empty();
         $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
      }

      function setDefaultLv3(){
         $('select[name="STORE_SLOC"]').empty();
         $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
      }

      function setDefaultLv4(){
         $('select[name="SLOC"]').empty();
         $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
      }

      function disabledDetailButton()
      {
         $('#button-detail').removeClass('disabled');
         $('#button-detail').addClass('disabled');
      }

      $('select[name="ID_REGIONAL"]').on('change', function() {
         var stateID = $(this).val();           
         var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
         disabledDetailButton();

         setDefaultLv1();
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
                       $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                   });
                   bootbox.hideAll();
               }
           });
         }
      });

      $('select[name="COCODE"]').on('change', function() {
         var stateID = $(this).val();
         var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv2/'+stateID;
         disabledDetailButton();

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
                       $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                   });
                   bootbox.hideAll();
               }
           });
         }
      });

      $('select[name="PLANT"]').on('change', function() {
         var stateID = $(this).val();
         var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv3/'+stateID;
         disabledDetailButton();

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
                       $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                   });
                   bootbox.hideAll();
               }
           });
         }
      });

      $('select[name="STORE_SLOC"]').on('change', function() {
         var stateID = $(this).val();
         var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv4/'+stateID;
         disabledDetailButton();

         setDefaultLv4();
         if(stateID) {
           bootbox.modal('<div class="loading-progress"></div>');
           $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $.each(data, function(key, value) {
                       $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                   });
                   bootbox.hideAll();
               }
           });
         }
      });

      $('select[name="SLOC"]').on('change',function() {           
         if ($(this).val() !== '') {
             $('#button-detail').removeClass('disabled');
         }else {
             $('#button-detail').addClass('disabled');
         }                      
      });
    });
</script>
