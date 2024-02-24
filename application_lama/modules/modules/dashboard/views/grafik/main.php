
<!-- /**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

 -->

 <style type="text/css">
    .dataTables_scrollHeadInner {
     width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
     width: 100% !important;    
    }      
 </style>

 
 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="well-content no-search">
				<div class="well">
                    <button type="button" id="btn-collapse" class="btn btn-primary col-md-12" style="font-weight: bold;font-size: 16px">
                      Fitur Pencarian
                    </button>
                    <br/>
                    <div id="collapse" class="well-content" style="display: none;">
                        <div class="form_row">
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" '); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="form_row">
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Pembangkit : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                                    <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                                    <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form_row">
                            <div class="pull-left span5">
                            <br>
                                <div class="controls">
                                    <?php echo anchor(null, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter', 'onclick'=> 'loadSumStockALL();hiddenTable();')); ?></td>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well">

                        <div class="row">
                            <div class="col-md-3 col-md-6" id="pnl_hsd"><br>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-tint fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge" style="font-size:12px" id="divHsd">

                                                </div>
                                                <div><h4>HSD</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a onclick="loadTableHsd();showTable('pnl_hsd');" href="javascript:void(0);">
                                        <div class="panel-footer" style="background-color:#337ab7">
                                            <span class="pull-left" style="color:#fff">View Details</span>
                                            <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6" id="pnl_mfo"><br>
                                <div class="panel panel-info">
                                    <div class="panel-heading" style="background-color:#ffc107">
                                        <div class="row" style="color:#fff">
                                            <div class="col-xs-3">
                                                <i class="fa fa-tint fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge" style="font-size:12px" id="divMfo">

                                                </div>
                                                <div><h4>MFO</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                     <a onclick="loadTableMfo();showTable('pnl_mfo');" href="javascript:void(0);">
                                        <div class="panel-footer" style="background-color:#ffc107">
                                            <span class="pull-left" style="color:#fff">View Details</span>
                                            <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6" id="pnl_bio" hidden><br>
                                <div class="panel panel-danger">
                                    <div class="panel-heading" style="background-color:#28a745">
                                        <div class="row" style="color:#fff">
                                            <div class="col-xs-3">
                                                <i class="fa fa-tint fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge" style="font-size:12px" id="divBio">

                                                </div>
                                                <div><h4>BIO</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                     <a onclick="loadTableBio();showTable('pnl_bio');" href="javascript:void(0);">
                                        <div class="panel-footer" style="background-color:#28a745">
                                            <span class="pull-left" style="color:#fff">View Details</span>
                                            <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6" id="pnl_hsdbio"><br>
                                <div class="panel panel-success">
                                    <div class="panel-heading" style="background-color:#dc3545">
                                        <div class="row" style="color:#fff">
                                            <div class="col-xs-3">
                                                <i class="fa fa-tint fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge" style="font-size:12px" id="divHsdBio">
												</div>
                                                <div><h4>HSD+BIO</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                   <a onclick="loadTableHsdBio();showTable('pnl_hsdbio');" href="javascript:void(0);">
                                        <div class="panel-footer" style="background-color:#dc3545">
                                            <span class="pull-left" style="color:#fff">View Details</span>
                                            <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
							 <div class="col-lg-3 col-md-6" id="pnl_ido"><br>
                                <div class="panel panel-primary">
                                    <div class="panel-heading" style="background-color:#04B4AE">
                                        <div class="row" style="color:#fff">
                                            <div class="col-xs-3">
                                                <i class="fa fa-tint fa-3x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge" style="font-size:12px" id="divIdo">

                                               </div>
                                                <div><h4>IDO</h4></div>
                                            </div>
                                        </div>
                                    </div>
                                      <a onclick="loadTableIdo();showTable('pnl_ido');" href="javascript:void(0);">
                                        <div class="panel-footer" style="background-color:#04B4AE">
                                            <span class="pull-left" style="color:#fff">View Details</span>
                                            <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                </div>

                <div class="well-content clearfix" id="divTable">
				    <table id="dataTable" class="table table-striped">
					<thead>
						<tr>
    						<th rowspan="2" style="text-align:center;">NO</th>
                            <th rowspan="2" style="text-align:center;"><?php echo str_repeat("&nbsp;", 15);?>UNIT<?php echo str_repeat("&nbsp;", 15);?></th>
    						<th rowspan="2" style="text-align:center;">JENIS BBM</th>
    						<th rowspan="2" style="text-align:center;">TANGGAL STOK TERAKHIR</th>
    						<th rowspan="2" style="text-align:center;">DEAD STOK (L)</th>
    						<th rowspan="2" style="text-align:center;">VOLUME  EFEKTIF TANGKI (L)</th>
    						<th rowspan="2" style="text-align:center;">VOLUME  TOTAL TANGKI (L)</th>
                            <th rowspan="2" style="text-align:center;">PEMAKAIAN TERTINGGI<br>BULAN LALU (L)</th>
                            <th colspan="2" style="text-align:center;">VOLUME</th>						
                            <th rowspan="2" style="text-align:center;">ULLAGE (%)</th>						
    						<th rowspan="2" style="text-align:center;">SHO (Hari)</td>
						</tr>
                        <tr>
                          <th style="text-align:center;">Stock Akhir (L)</th>
                          <th style="text-align:center;">Stock Akhir Efektif (L)</th>
                        </tr>
					</thead>
					<tbody>
					</tbody>
				   </table>
                   <label for="sho_detail"><i>(* SHO : Sisa Hari Operasi)</i></label></br>
                   <label for="sho_detail"><i>(* Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></label></br>
                   <label for="sho_detail"><i>(* Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></label></br>
                   <label for="sho_detail"><i>(* ~ : Untuk pembangkit idle)</i></label>                            
                </div>
            </div>

            <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter">
    		</div>
            <div>&nbsp;</div>
                
            <div id="form-content" class="modal fade modal-xlarge">

            </div>
        </div>
    </div>

</div>

<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth();
    var strMonth;
    month++;

    if (month < 10) {
        strMonth = '0'+month;
    } else {
        strMonth = month;
    }

    $('select[name="TAHUN"]').val(year);
    $('select[name="BULAN"]').val(strMonth);

    $('#dataTable').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "fixedHeader": true,
        "ordering" :false,
        "bAutoWidth": true,
        "scrollY" : "300px",
        "scrollX" : false
    });


    function setPilihPanel(vPanel){
        document.getElementById("pnl_hsd").removeAttribute("style");
        document.getElementById("pnl_mfo").removeAttribute("style");
        document.getElementById("pnl_bio").removeAttribute("style");
        document.getElementById("pnl_hsdbio").removeAttribute("style");
        document.getElementById("pnl_ido").removeAttribute("style");

        document.getElementById(vPanel).style.backgroundColor  = "#B0C4DE";
        document.getElementById(vPanel).style.opacity = "0.7";
    }

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
        $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="COCODE"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="PLANT"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                }
            });
        }
    });

    function convertToRupiah(angka){
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

    function hiddenTable(){
        document.getElementById("divTable").style.visibility = "hidden";
    }

	function showTable(vPanel){
		document.getElementById("divTable").style.visibility = "visible";
        setPilihPanel(vPanel);
	}

    $(function() {
        loadSumStockALL();
        hiddenTable();
    });

    function loadSumStockALL(){
        $('#divHsd').text('Loading...');
        $('#divMfo').text('Loading...');
        $('#divBio').text('Loading...');
        $('#divHsdBio').text('Loading...');
        $('#divIdo').text('Loading...');
    
        loadSumStock('HSD');
        loadSumStock('MFO');
        loadSumStock('BIO');
        loadSumStock('HSD+BIO');
        loadSumStock('IDO');
    }

    function loadSumStock(vBBM){
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        var vlevelid = '';

        if (lvl0 !== "") {
            lvl0 = '0';
            vlevelid = $('#lvl0').val();
            if (vlevelid == "00") {
                lvl0 = "";
            }
        }
        if (lvl1 !== "") {
            lvl0 = '1';
            vlevelid = $('#lvl1').val();
        }
        if (lvl2 !== "") {
            lvl0 = '2';
            vlevelid = $('#lvl2').val();
        }
        if (lvl3 !== ""){
            lvl0 = '3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = '4';
            vlevelid = $('#lvl4').val();
        }
        if (lvl0 == ''){
            lvl0 = '';
            vlevelid = '';
        }
        if (bln == ''){
            bln = '12';
        }
        
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress"></div>');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('dashboard/grafik/get_sum_stock'); ?>",
            data: {"JENIS_BBM":vBBM, "VLEVEL":lvl0, "VLEVELID":vlevelid, "BULAN":bln, "TAHUN":thn},
            success:function(response) {
                 var obj = JSON.parse(response);

                 $.each(obj, function (index, value) {
                    var STOK = value.STOK == null ? "" : value.STOK;

                    if (vBBM=='HSD'){
                        $('#divHsd').text(convertToRupiah(STOK)+' (L)');
                    } else if (vBBM=='MFO'){
                        $('#divMfo').text(convertToRupiah(STOK)+' (L)');
                    } else if (vBBM=='BIO'){
                        $('#divBio').text(convertToRupiah(STOK)+' (L)');
                    } else if (vBBM=='HSD+BIO'){
                        $('#divHsdBio').text(convertToRupiah(STOK)+' (L)');
                    } else if (vBBM=='IDO'){
                        $('#divIdo').text(convertToRupiah(STOK)+' (L)');
                    }
                    
                  });

                 bootbox.hideAll();
                }
        });
    }

	function loadTableHsdBio(){
			var lvl0 = $('#lvl0').val();
			var lvl1 = $('#lvl1').val();
			var lvl2 = $('#lvl2').val();
			var lvl3 = $('#lvl3').val();
			var lvl4 = $('#lvl4').val();
			var bln = $('#bln').val();
			var thn = $('#thn').val();
			// if (lvl0 == '') {
			// 	// bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
			// } else {
				bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('dashboard/grafik/getTableHsdBio'); ?>",
						data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
								"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
						success:function(response) {
							var obj = JSON.parse(response);
							if (obj == "" || obj == null) {
								$('#dataTable tbody').empty();
                                var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                                $("#dataTable tbody").append(str);
								  bootbox.hideAll();
								 } else {
							$('#dataTable tbody').empty();
                            $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                         var nomer = 1;
                         $.each(obj, function (index, value) {

                            var UNIT = value.UNIT == null ? "" : value.UNIT;
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                            var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;
                            var VOLUME_TANGKI = value.VOLUME_TANGKI == null ? "" : value.VOLUME_TANGKI;
                            var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                            // var ULLAGE = value.ULLAGE == null ? "" : value.ULLAGE;
                            // var SHO = value.SHO == null ? "" : value.SHO;
                            var SHO ='<td align="center"><font size="5">~</font></td>';
                            if (value.SHO != null){
                                SHO = '<td align="right">' + convertToRupiah(value.SHO) + '</td>';
                            }

                            var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                            var strRow =
                                    '<tr>' +
                                    '<td align="center">' + nomer + '</td>' +
                                    '<td>' + UNIT + '</td>' +
                                    '<td align="center">' + NAMA_JNS_BHN_BKR + '</td>' +
                                    '<td align="center">' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                    '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOCKEFEKTIF_TANGKI) + '</td>' +
                                    '<td align="right">' + convertToRupiah(VOLUME_TANGKI) + '</td>' +
                                    '<td align="right">' + convertToRupiah(MAX_PEMAKAIAN) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                    '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                    // '<td align="center">' + Math.round(ULLAGE) + '</td>' +
                                    '<td align="center">' + Math.round((VOLUME_TANGKI-STOK_REAL)/VOLUME_TANGKI*100) + '</td>' +
                                    SHO +
                                    '</tr>';
                            nomer++;

                            $("#dataTable tbody").append(strRow);
                            bootbox.hideAll();
							  });
							};
						}
					});
			// };
	}

	function loadTableHsd(){
		var lvl0 = $('#lvl0').val();
		var lvl1 = $('#lvl1').val();
		var lvl2 = $('#lvl2').val();
		var lvl3 = $('#lvl3').val();
		var lvl4 = $('#lvl4').val();
		var bln = $('#bln').val();
		var thn = $('#thn').val();
		// if (lvl0 == '') {
		// 	bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
		// } else {
			bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/grafik/getTableHsd'); ?>",
					data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
							"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
					success:function(response) {
						var obj = JSON.parse(response);
						if (obj == "" || obj == null) {
							$('#dataTable tbody').empty();
                            var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                            $("#dataTable tbody").append(str);
							  bootbox.hideAll();
							 } else {
						$('#dataTable tbody').empty();
                        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                     var nomer = 1;
                     $.each(obj, function (index, value) {

                        var UNIT = value.UNIT == null ? "" : value.UNIT;
                        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                        var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                        var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                        var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;
                        var VOLUME_TANGKI = value.VOLUME_TANGKI == null ? "" : value.VOLUME_TANGKI;
                        var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                        var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                        // var ULLAGE = value.ULLAGE == null ? "" : value.ULLAGE;
                        // var SHO = value.SHO == null ? "" : value.SHO;
                        var SHO ='<td align="center"><font size="5">~</font></td>';
                        if (value.SHO != null){
                            SHO = '<td align="right">' + convertToRupiah(value.SHO) + '</td>';
                        }

                        var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                        var strRow =
                                '<tr>' +
                                '<td align="center">' + nomer + '</td>' +
                                '<td>' + UNIT + '</td>' +
                                '<td align="center">' + NAMA_JNS_BHN_BKR + '</td>' +
                                '<td align="center">' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOCKEFEKTIF_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(VOLUME_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(MAX_PEMAKAIAN) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                // '<td align="center">' + Math.round(ULLAGE) + '</td>' +
                                '<td align="center">' + Math.round((VOLUME_TANGKI-STOK_REAL)/VOLUME_TANGKI*100) + '</td>' +
                                SHO +
                                '</tr>';
                        nomer++;

                        $("#dataTable tbody").append(strRow);
                        bootbox.hideAll();
						  });
						};
					}
				});
		// };
	}

	function loadTableBio(){
		var lvl0 = $('#lvl0').val();
		var lvl1 = $('#lvl1').val();
		var lvl2 = $('#lvl2').val();
		var lvl3 = $('#lvl3').val();
		var lvl4 = $('#lvl4').val();
		var bln = $('#bln').val();
		var thn = $('#thn').val();
		// if (lvl0 == '') {
		// 	bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
		// } else {
			bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/grafik/getTableBio'); ?>",
					data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
							"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
					success:function(response) {
						var obj = JSON.parse(response);
						if (obj == "" || obj == null) {
							$('#dataTable tbody').empty();
                            var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                            $("#dataTable tbody").append(str);
							  bootbox.hideAll();
							 } else {
						$('#dataTable tbody').empty();
                        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                     var nomer = 1;
                     $.each(obj, function (index, value) {

                        var UNIT = value.UNIT == null ? "" : value.UNIT;
                        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                        var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                        var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                        var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;
                        var VOLUME_TANGKI = value.VOLUME_TANGKI == null ? "" : value.VOLUME_TANGKI;
                        var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                        var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                        // var ULLAGE = value.ULLAGE == null ? "" : value.ULLAGE;
                        // var SHO = value.SHO == null ? "" : value.SHO;
                        var SHO ='<td align="center"><font size="5">~</font></td>';
                        if (value.SHO != null){
                            SHO = '<td align="right">' + convertToRupiah(value.SHO) + '</td>';
                        }

                        var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                        var strRow =
                                '<tr>' +
                                '<td align="center">' + nomer + '</td>' +
                                '<td>' + UNIT + '</td>' +
                                '<td align="center">' + NAMA_JNS_BHN_BKR + '</td>' +
                                '<td align="center">' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOCKEFEKTIF_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(VOLUME_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(MAX_PEMAKAIAN) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                // '<td align="center">' + Math.round(ULLAGE) + '</td>' +
                                '<td align="center">' + Math.round((VOLUME_TANGKI-STOK_REAL)/VOLUME_TANGKI*100) + '</td>' +
                                SHO +
                                '</tr>';
                        nomer++;

                        $("#dataTable tbody").append(strRow);
                        bootbox.hideAll();
						  });
						};
					}
				});
		// };
	}

	function loadTableMfo(){
		var lvl0 = $('#lvl0').val();
		var lvl1 = $('#lvl1').val();
		var lvl2 = $('#lvl2').val();
		var lvl3 = $('#lvl3').val();
		var lvl4 = $('#lvl4').val();
		var bln = $('#bln').val();
		var thn = $('#thn').val();
		// if (lvl0 == '') {
		// 	bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
		// } else {
			bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/grafik/getTableMfo'); ?>",
					data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
							"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
					success:function(response) {
						var obj = JSON.parse(response);
						if (obj == "" || obj == null) {
							$('#dataTable tbody').empty();
                            var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                            $("#dataTable tbody").append(str);
							  bootbox.hideAll();
							 } else {
						$('#dataTable tbody').empty();
                        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                     var nomer = 1;
                     $.each(obj, function (index, value) {

                        var UNIT = value.UNIT == null ? "" : value.UNIT;
                        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                        var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                        var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                        var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;
                        var VOLUME_TANGKI = value.VOLUME_TANGKI == null ? "" : value.VOLUME_TANGKI;
                        var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                        var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                        // var ULLAGE = value.ULLAGE == null ? "" : value.ULLAGE;
                        // var SHO = value.SHO == null ? "" : value.SHO;
                        var SHO ='<td align="center"><font size="5">~</font></td>';
                        if (value.SHO != null){
                            SHO = '<td align="right">' + convertToRupiah(value.SHO) + '</td>';
                        }

                        var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                        var strRow =
                                '<tr>' +
                                '<td align="center">' + nomer + '</td>' +
                                '<td>' + UNIT + '</td>' +
                                '<td align="center">' + NAMA_JNS_BHN_BKR + '</td>' +
                                '<td align="center">' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOCKEFEKTIF_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(VOLUME_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(MAX_PEMAKAIAN) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                // '<td align="center">' + Math.round(ULLAGE) + '</td>' +
                                '<td align="center">' + Math.round((VOLUME_TANGKI-STOK_REAL)/VOLUME_TANGKI*100) + '</td>' +
                                SHO +
                                '</tr>';
                        nomer++;

                        $("#dataTable tbody").append(strRow);
                        bootbox.hideAll();
						  });
						};
					}
				});
		// };
	}

	function loadTableIdo(){
		var lvl0 = $('#lvl0').val();
		var lvl1 = $('#lvl1').val();
		var lvl2 = $('#lvl2').val();
		var lvl3 = $('#lvl3').val();
		var lvl4 = $('#lvl4').val();
		var bln = $('#bln').val();
		var thn = $('#thn').val();
		// if (lvl0 == '') {
		// 	bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
		// } else {
			bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('dashboard/grafik/getTableIdo'); ?>",
					data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
							"SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
					success:function(response) {
						var obj = JSON.parse(response);
						if (obj == "" || obj == null) {
							$('#dataTable tbody').empty();
                            var str = '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
                            $("#dataTable tbody").append(str);
							  bootbox.hideAll();
							 } else {
						$('#dataTable tbody').empty();
                     var nomer = 1;
                     $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                     $.each(obj, function (index, value) {

                        var UNIT = value.UNIT == null ? "" : value.UNIT;
                        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                        var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                        var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                        var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;
                        var VOLUME_TANGKI = value.VOLUME_TANGKI == null ? "" : value.VOLUME_TANGKI;
                        var STOK_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                        var STOK_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                        // var ULLAGE = value.ULLAGE == null ? "" : value.ULLAGE;
                        // var SHO = value.SHO == null ? "" : value.SHO;
                        var SHO ='<td align="center"><font size="5">~</font></td>';
                        if (value.SHO != null){
                            SHO = '<td align="right">' + convertToRupiah(value.SHO) + '</td>';
                        }

                        var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                        var strRow =
                                '<tr>' +
                                '<td align="center">' + nomer + '</td>' +
                                '<td>' + UNIT + '</td>' +
                                '<td align="center">' + NAMA_JNS_BHN_BKR + '</td>' +
                                '<td align="center">' + TGL_MUTASI_PERSEDIAAN + '</td>' +
                                '<td align="right">' + convertToRupiah(DEAD_STOCK) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOCKEFEKTIF_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(VOLUME_TANGKI) + '</td>' +
                                '<td align="right">' + convertToRupiah(MAX_PEMAKAIAN) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_REAL) + '</td>' +
                                '<td align="right">' + convertToRupiah(STOK_EFEKTIF) + '</td>' +
                                '<td align="center">' + Math.round((VOLUME_TANGKI-STOK_REAL)/VOLUME_TANGKI*100) + '</td>' +
                                SHO +
                                '</tr>';
                        nomer++;

                        $("#dataTable tbody").append(strRow);
                        bootbox.hideAll();
						  });
						};
					}
				});
		// };
	}

</script>

<script>
jQuery(document).ready(function($)
{

  $("#btn-collapse").click(function()
  {

    $("#collapse").slideToggle( "slow");

	  if ($("#btn-collapse").text() == "Pilih Pencarian")
      {
        $("#btn-collapse").html("Hide Author Details")
        $("#btn-collapse").text("Fitur Pencarian")
      }
	  else
      {
        $("#btn-collapse").text("Pilih Pencarian")
      }

  });

});
</script>
