<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    .author_bio_toggle_wrapper
    {

    }
    th{
      vertical-align: middle !important;
    }
    #author_bio_wrap
    {
        margin-top: 0px;
        margin-bottom: 30px;
        width: auto;
        height: 150px;
    }
    
    #author_bio_wrap_toggle
    {
        display: block;
        width: 100%;
        height: 35px;
        line-height: 35px;
        background: #337ab7;
        text-align: center;
        color: white;
        font-weight: bold;
        box-shadow: 2px 2px 3px #888888;
        text-decoration:none;
    }

    #author_bio_wrap_toggle:hover
    {
        text-decoration:none;
        border-top: 1px groove white;
        border-left: 1px groove white;
        border-bottom: 1px solid #7B7B78;
        border-right: 1px solid #7B7B78;
        color: #663200;
        background: #EBEBB3;
        box-shadow: 1px 1px 2px #888888;
    }

    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        #author_bio_wrap {
            height: 400px;
        }
    }

    th { font-size: 12px; }
    td { font-size: 11px; }
</style>

 <div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div class="well-content no-search">
					<div class="well">
                        <!-- <div class="pull-left"> -->
                        <!-- /.row -->

                        <div class="author_bio_toggle_wrapper">
                        <a href="#0" id="author_bio_wrap_toggle">Fitur Pencarian</a>
                        </div>
                        <div id="author_bio_wrap" style="display: none;">
                                <div class="col-md-12">
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
												<?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
											</div>
										</div>
										<div class="pull-left span4">
											<label for="password" class="control-label">Level 2 : </label>
											<div class="controls">
												<?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
											</div>
										</div>
									</div><br/>
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
											<!-- <label for="password" class="control-label">Bulan <span class="required">*</span> : </label> -->
											<!-- <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label> -->
                                            <label for="password" class="control-label">Tahun <span class="required">*</span> : </label>
											<div class="controls">
												<?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
												<!-- <?php //echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?> -->
												<?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
											</div>
										</div>
									</div>
									<div class="form_row">
										<div class="pull-left span5">
										<br>
											<div class="controls">
												<?php echo anchor(null, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter', 'onclick'=> 'loadDataIdo();loadDataBio();loadDataHsd();loadDataMfo();loadDataHsdBio();hiddenTable();')); ?></td>
											</div>
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
                                        <a onclick="load_grafik('HSD','pnl_hsd');" href="javascript:void(0);">
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
                                         <a onclick="load_grafik('MFO','pnl_mfo');" href="javascript:void(0);">
                                            <div class="panel-footer" style="background-color:#ffc107">
                                                <span class="pull-left" style="color:#fff">View Details</span>
                                                <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                                <div class="clearfix"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6" id="pnl_bio" hidden><br>
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
                                         <a onclick="load_grafik('BIO','pnl_bio');" href="javascript:void(0);">
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
                                       <a onclick="load_grafik('HSD+BIO','pnl_hsdbio');" href="javascript:void(0);">
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
                                          <a onclick="load_grafik('IDO','pnl_ido');" href="javascript:void(0);">
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
                        <!-- </div>  --><!-- end pull left -->
                    </div>

                    <div id="div_grafik">
                       <div id="container_grafik"></div>
                       <hr>
                       <label><i>(* Hari Operasi Pembangkit (Hari) : untuk pembangkit selain PLTU)</i></label></br>
                       <label><i>(* Hari Operasi Pembangkit (kali start) : untuk pembangkit PLTU)</i></label></br>
                    </div>
    
                 </div>
                 <br>
                    <?php
                        $x='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        $namaUnit = $x.'Unit'.$x;
                    ?>
                    <div class="well-content clearfix" id="divTable">
                        <table id="dataTable" class="table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th><?php echo $namaUnit; ?></th>
                                    <!-- <th>Jenis BBM</th>
                                    <th>Tahun</th> -->
                                    <th>BLN 01</th>
                                    <th>BLN 02</th>
                                    <th>BLN 03</th>
                                    <th>BLN 04</th>
                                    <th>BLN 05</th>
                                    <th>BLN 06</th>
                                    <th>BLN 07</th>
                                    <th>BLN 08</th>
                                    <th>BLN 09</th>
                                    <th>BLN 10</th>
                                    <th>BLN 11</th>
                                    <th>BLN 12</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

				 </div>
            </div>
            <div id="form-content" class="modal fade modal-xlarge">

            </div>
        </div>
    </div>

</div>
<br>

<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth();
    var strMonth;
    var vJsonTable;

    month++;

    if (month < 10) {
        strMonth = '0'+month;
    } else {
        strMonth = month;
    }

    $('select[name="TAHUN"]').val(year);
    $('select[name="BULAN"]').val(strMonth);

    getDataTable = function () {
        $('#divTable').show();
        setDataTable(vJsonTable);
        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
    };
 
    var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

    btnGetDataTable.push(
      {
        separator: true
      },{
        text: "Lihat Data Tabel",
        onclick: getDataTable
      }
    );

    $('#divTable').hide();
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);


    function setPilihPanel(vPanel){
        document.getElementById("pnl_hsd").removeAttribute("style");
        document.getElementById("pnl_mfo").removeAttribute("style");
        document.getElementById("pnl_bio").removeAttribute("style");
        document.getElementById("pnl_hsdbio").removeAttribute("style");
        document.getElementById("pnl_ido").removeAttribute("style");

        document.getElementById(vPanel).style.backgroundColor  = "#B0C4DE";
        document.getElementById(vPanel).style.opacity = "0.7";
    }

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

	function loadDataBio(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        // if (lvl0 == '') {
        //     bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        // } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/sho_bbm/getDataBio'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            // $('#divBio').text("0 (L)");
							bootbox.hideAll();
							} else {

                         $('#divBio').text("");

                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;

                            // $('#divBio').text(convertToRupiah(STOK)+' HARI');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        // };
	}

	function loadDataHsd(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        // if (lvl0 == '') {

        // } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/sho_bbm/getDataHsd'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            // $('#divHsd').text("0 (L)");
							bootbox.hideAll();
							} else {

                         $('#divHsd').text("");

                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;

                            // $('#divHsd').text(convertToRupiah(STOK)+' HARI');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        // };
	}

	function loadDataMfo(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        // if (lvl0 == '') {

        // } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/sho_bbm/getDataMfo'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            // $('#divMfo').text("0 (L)");
							bootbox.hideAll();
							} else {

                         $('#divMfo').text("");

                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;

                            // $('#divMfo').text(convertToRupiah(STOK)+' HARI');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        // };
	}

	function loadDataHsdBio(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        // if (lvl0 == '') {

        // } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/sho_bbm/getDataHsdBio'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            // $('#divHsdBio').text("0 (L)");
							bootbox.hideAll();
                             } else {

                         $('#divHsdBio').text("");

                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;

                            // $('#divHsdBio').text(convertToRupiah(STOK)+' HARI');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        // };
	}

	function loadDataIdo(){
		var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        // if (lvl0 == '') {

        // } else {
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('dashboard/sho_bbm/getDataIdo'); ?>",
                    data: {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn},
                    success:function(response) {
                        var obj = JSON.parse(response);
                        if (obj == "" || obj == null) {
                            // $('#divIdo').text("0 (L)");
                              bootbox.hideAll();
                             } else {

                         $('#divIdo').text("");

                         $.each(obj, function (index, value) {
                            var STOK = value.STOK == null ? "" : value.STOK;

                            // $('#divIdo').text(convertToRupiah(STOK)+' HARI');
                            bootbox.hideAll();
                          });
                        };
                    }
                });
        // };
	}

    function hiddenTable(){
        // document.getElementById("divTable").style.visibility = "hidden";
        $('#div_grafik').hide();
        $('#divTable').hide();
    }

    $(function() {
        loadDataIdo();
        loadDataMfo();
        loadDataHsd();
        loadDataHsdBio();
        loadDataBio();
        hiddenTable();
    });

    /** iterasi bulan dari database */
    function iterateBulan(val){
        
        var bln = [
            "01", "02", "03", "04", "05", "06",
            "07", "08", "09", "10", "11", "12"
        ];

        var bulan_obj = [];
        bln.forEach(function(element){
            var parsedTanggal = 'BLN_'+ element; //BLN_01
            if(val[parsedTanggal] == null) //val['BLN_01']
            {
                bulan_obj.push(0);
            }else{
                bulan_obj.push(parseFloat(val[parsedTanggal]));
            }
        });

        return bulan_obj;
    }

    function iterateAverage(val){
        var bln = [
            "01", "02", "03", "04", "05", "06",
            "07", "08", "09", "10", "11", "12"
        ];
        var bulan_obj = [];
            
        bln.forEach(function(element){
            var parsedTanggal = 'BLN_'+ element; //BLN_01
            if(val[parsedTanggal] == null) //val['BLN_01']
            {
                bulan_obj.push(null);
            }else{
                bulan_obj.push(parseFloat(val[parsedTanggal]));
            }
        });
        return bulan_obj;
    }

    function getNamaUnit(vBBM){
        var vUnit = '';

        if ($('#lvl0').val() && $('#lvl0').val()!='00'){
            // vUnit = 'REGIONAL '+ $('#lvl0 option:selected').text()+'<br>';
            vUnit = $('#lvl0 option:selected').text()+'<br>';
        }
        if ($('#lvl1').val() && $('#lvl1').val()!='0'){
            vUnit = vUnit + $('#lvl1 option:selected').text();
        }
        if ($('#lvl2').val() && $('#lvl2').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl2 option:selected').text();
        }
        if ($('#lvl3').val() && $('#lvl3').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl3 option:selected').text();
        }
        if ($('#lvl4').val() && $('#lvl4').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl4 option:selected').text();
        }

        if (vBBM){
            if (vUnit){
                vUnit = vUnit +'<br>Jenis BBM : '+ vBBM;    
            } else {
                vUnit = 'Jenis BBM : '+ vBBM;    
            }
        }
        if ($('#thn').val()){
            if (vUnit){
                vUnit = vUnit +'<br>'+ $('#thn').val();    
            } else {
                vUnit = $('#thn').val();    
            }
        }

        return vUnit;
    }

    function load_grafik(vBBM,vPanel){
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        var vlevelid;

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
        if (lvl3 !== ""){
            lvl0 = 'Level 3';
            vlevelid = $('#lvl3').val();
        }
        if (lvl4 !== "") {
            lvl0 = 'Level 4';
            vlevelid = $('#lvl4').val();
        }
        if(lvl0 == ''){
            lvl0 = 'All';
            vlevelid = '';
        }

        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        setPilihPanel(vPanel);
        $('#divTable').hide();

        // if (lvl0 == '') {
        //  // bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        // } else {
            // $.ajax({
            //     type: "POST",
            //     url: "<?php echo base_url('dashboard/sho_bbm/get_grafik'); ?>",
            //     data: {
            //         "BULAN":bln, 
            //         "TAHUN":thn,
            //         "BBM":vBBM,
            //         "VLEVEL": lvl0,
            //         "VLEVELID": vlevelid
            //     },
            //     success:function(response) {
            //         var obj = JSON.parse(response);
            //         var tanggal_obj = [];
            //         var dataset = [];
            //         var average = [];

            //         if (obj == "" || obj == null) {
            //             $('#div_grafik').hide();
            //             bootbox.hideAll();
            //             bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            //             // removeSeries_chart();
            //         }else{
            //             $('#div_grafik').show();
            //             $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
            //             vJsonTable = response;

            //             $.each(obj, function(index, val){
            //                 if(val.UNIT !== 'Rata-rata SHO'){
            //                     var series_obj = {};
            //                     series_obj.type = 'column';
            //                     series_obj.name = val.UNIT;

            //                     var data_arr = iterateBulan(val);
                                
            //                     series_obj.data = data_arr;
            //                     dataset.push(series_obj);
            //                 }else{
            //                     // jika ada PLN
            //                     average = iterateAverage(val);
            //                 }                              
            //             });
                    
            //             // Untuk Tambah garis average di bar
            //             var spline = {};
            //                 spline.type = 'spline';
            //                 spline.name = 'Rata-rata SHO';
            //                 spline.data = average;
            //                 dataset.push(spline);

            //                 console.log(dataset);

            //             $(function (){
            //                 $('#container_grafik').highcharts({
            //                     title: {
            //                         text: 'Sisa Hari Operasi BBM'
            //                     },
            //                     subtitle: {
            //                         text: getNamaUnit(vBBM)
            //                     },
            //                     yAxis: {
            //                         title: {
            //                             text: 'HARI'
            //                         }
            //                     },
                                 
            //                     xAxis: {
            //                         categories: [
            //                             'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli','Agustus','September',
            //                             'Oktober','November','Desember'
            //                         ]
            //                     },

            //                     series: dataset

            //                 });
            //             });
            //         }
                
            //     bootbox.hideAll();
            //     }
            // });
        // };

        getGraph(1, thn, vBBM, lvl0, vlevelid);
    }

    $(document).ready(function() {
        $('#dataTable').dataTable({
            "scrollY": "370px",
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": true,
            "ordering": false,
            // "fixedColumns": {"leftColumns": 2},
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": [0,2,3]},
                {"className": "dt-left","targets": [1]},
                {"className": "dt-right","targets": '_all'},
            ]
        });
    });

    function setDataTable(vdata){
      var obj = JSON.parse(vdata);
      var t = $('#dataTable').DataTable();
      t.clear().draw();

      var nomer = 1;
      $.each(obj, function (index, value) {

        var UNIT = value.UNIT == null ? "" : value.UNIT;

        t.row.add( [
            nomer, 
            UNIT, 
            // value.NAMA_JNS_BHN_BKR,
            // value.TAHUN,
            convertToRupiah(value.BLN_01),
            convertToRupiah(value.BLN_02),
            convertToRupiah(value.BLN_03),
            convertToRupiah(value.BLN_04),
            convertToRupiah(value.BLN_05),
            convertToRupiah(value.BLN_06),
            convertToRupiah(value.BLN_07),
            convertToRupiah(value.BLN_08),
            convertToRupiah(value.BLN_09),
            convertToRupiah(value.BLN_10),
            convertToRupiah(value.BLN_11),
            convertToRupiah(value.BLN_12)
        ]).draw( false );

        nomer++;
      });
    }
</script>

<script>
    jQuery(document).ready(function($)
    {  
      $("#author_bio_wrap_toggle").click(function()
      {

        $("#author_bio_wrap").slideToggle( "slow");

    	  if ($("#author_bio_wrap_toggle").text() == "Pilih Pencarian")
          {
            $("#author_bio_wrap_toggle").html("Hide Author Details")
            $("#author_bio_wrap_toggle").text("Fitur Pencarian")
          }
    	  else
          {
            $("#author_bio_wrap_toggle").text("Pilih Pencarian")
          }

      });

    });

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

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv4/'+stateID;
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


    //  JAJAL 
const graphObj = {
    "UNIT": null,
    "ID_JNS_BHN_BKR": null,
    "NAMA_JNS_BHN_BKR": null,
    "TAHUN": null,
    "BLN_01": null,
    "BLN_02": null,
    "BLN_03": null,
    "BLN_04": null,
    "BLN_05": null,
    "BLN_06": null,
    "BLN_07": null,
    "BLN_08": null,
    "BLN_09": null,
    "BLN_10": null,
    "BLN_11": null,
    "BLN_12": null
};

var graphMap = new Map();
var graphList = [];
var currentMonth = new Date().getMonth() + 1;

function getGraphPerMonth(month, thn, vBbm, vLevel, vLevelId) {
    var m = month < 10 ? String("0" + month) : String(month);

    return $.ajax({
        type: "POST",
        dataType: "json",
        url: "<?php echo base_url('dashboard/sho_bbm/get_grafik'); ?>",
        data: {
            "BULAN":m, 
            "TAHUN":thn,
            "BBM":vBbm,
            "VLEVEL": vLevel,
            "VLEVELID": vLevelId
        }
    });
    //  $.ajax({
    //     type: "POST",
    //     dataType: "json",
    //     url: "<?php echo base_url('dashboard/sho_bbm/get_grafik'); ?>",
    //     data: {
    //         "BULAN":m, 
    //         "TAHUN":thn,
    //         "BBM":vBbm,
    //         "VLEVEL": vLevel,
    //         "VLEVELID": vLevelId
    //     },
    //     success: function(data) {
    //         console.log("result of query")
    //         console.log(data);
    //     }
    // });
}

function getGraph(month, thn, vBbm, vLevel, vLevelId) {	
    // getGraphPerMonth(1, thn, vBbm, vLevel, vLevelId);
    // for (month = 1; month <= currentMonth; month++) {

        // getGraphPerMonth(month, thn, vBbm, vLevel, vLevelId).done(function (data) {
        //     var graph = graphObj;

        //     for (i = 0; i < data.length; i++) {
        //         // var row = JSON.parse(data[i]);
        //         var row = data[i];
        //         graph.UNIT = row.UNIT;
        //         graph.ID_JNS_BHN_BKR = row.ID_JNS_BHN_BKR;
        //         graph.NAMA_JNS_BHN_BKR = row.NAMA_JNS_BHN_BKR;
        //         switch (month) {
        //             case 1: 
        //                 graph.BLN_01 = row.BLN;
        //                 break;
        //             case 2: 
        //                 graph.BLN_02 = row.BLN;
        //                 break;
        //             case 3: 
        //                 graph.BLN_03 = row.BLN;
        //                 break;
        //             case 4: 
        //                 graph.BLN_04 = row.BLN;
        //                 break;
        //             case 5: 
        //                 graph.BLN_05 = row.BLN;
        //                 break;
        //             case 6: 
        //                 graph.BLN_06 = row.BLN;
        //                 break;
        //             case 7: 
        //                 graph.BLN_07 = row.BLN;
        //                 break;
        //             case 8: 
        //                 graph.BLN_08 = row.BLN;
        //                 break;
        //             case 9: 
        //                 graph.BLN_09 = row.BLN;
        //                 break;
        //             case 10: 
        //                 graph.BLN_10 = row.BLN;
        //                 break;
        //             case 11: 
        //                 graph.BLN_11 = row.BLN;
        //                 break;
        //             case 12: 
        //                 graph.BLN_12 = row.BLN;
        //                 break;
        //             default: 
        //                 break;
        //         }
        //     }

        //     graphList.push(graph);
        // });
    // }


    getGraphPerMonth(month, thn, vBbm, vLevel, vLevelId).done(function (data) {
        var graph;

        for (i = 0; i < data.length; i++) {
            // var row = JSON.parse(data[i]);
            var row = data[i];

            if (graphMap.get(row.UNIT) == null) {
                graphMap.set(row.UNIT, {...graphObj});
            }
            
            graph = graphMap.get(row.UNIT);

            if (graph.UNIT == null) {
                graph.UNIT = row.UNIT;
                graph.ID_JNS_BHN_BKR = row.ID_JNS_BHN_BKR;
                graph.NAMA_JNS_BHN_BKR = row.NAMA_JNS_BHN_BKR;
                graph.TAHUN = row.TAHUN;
            }

            switch (month) {
                case 1: 
                    graph.BLN_01 = row.BLN;
                    break;
                case 2: 
                    graph.BLN_02 = row.BLN;
                    break;
                case 3: 
                    graph.BLN_03 = row.BLN;
                    break;
                case 4: 
                    graph.BLN_04 = row.BLN;
                    break;
                case 5: 
                    graph.BLN_05 = row.BLN;
                    break;
                case 6: 
                    graph.BLN_06 = row.BLN;
                    break;
                case 7: 
                    graph.BLN_07 = row.BLN;
                    break;
                case 8: 
                    graph.BLN_08 = row.BLN;
                    break;
                case 9: 
                    graph.BLN_09 = row.BLN;
                    break;
                case 10: 
                    graph.BLN_10 = row.BLN;
                    break;
                case 11: 
                    graph.BLN_11 = row.BLN;
                    break;
                case 12: 
                    graph.BLN_12 = row.BLN;
                    break;
                default: 
                    break;
            }
        }

        if (month <= currentMonth) {
            month ++ ;
            getGraph(month, thn, vBbm, vLevel, vLevelId) ;
        }

        if (month >= currentMonth) {
            graphList = Array.from(graphMap.values());
            generateGraph(vBbm);
        }   
    });
}

function generateGraph (vBBM) {
    var obj = graphList;
    var tanggal_obj = [];
    var dataset = [];
    var average = [];

    if (obj == "" || obj == null) {
        $('#div_grafik').hide();
        bootbox.hideAll();
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
        // removeSeries_chart();
    }else{
        $('#div_grafik').show();
        $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
        vJsonTable = JSON.stringify(graphList);

        $.each(obj, function(index, val){
            if(val.UNIT !== 'Rata-rata HOP'){
                var series_obj = {};
                series_obj.type = 'column';
                series_obj.name = val.UNIT;

                var data_arr = iterateBulan(val);
                
                series_obj.data = data_arr;
                dataset.push(series_obj);
            }else{
                // jika ada PLN
                average = iterateAverage(val);
            }                              
        });
    
        // Untuk Tambah garis average di bar
        var spline = {};
            spline.type = 'spline';
            spline.name = 'Rata-rata HOP';
            spline.data = average;
            dataset.push(spline);

            console.log(dataset);

        $(function (){
            $('#container_grafik').highcharts({
                title: {
                    text: 'Hari Operasi Pembangkit BBM'
                },
                subtitle: {
                    text: getNamaUnit(vBBM)
                },
                yAxis: {
                    title: {
                        text: 'HARI'
                    }
                },
                
                xAxis: {
                    categories: [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli','Agustus','September',
                        'Oktober','November','Desember'
                    ]
                },

                series: dataset

            });
        });
    }

    bootbox.hideAll();
}
</script>
