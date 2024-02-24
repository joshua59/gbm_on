<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<div class="inner_content" id="divTop">

    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>

    <div class="widgets_area">
        <div class="row-fluid">
            <div class="well-content no-search">

                <!-- Filter -->
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
                <!-- Filter -->

                <!-- Card -->
                <div class="well">
                    <div class="row">
                        <div class="col-md-3" id="pnl_hsd"><br>
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
                                <a onclick="loadGrafik('HSD','getGrafikHSD','pnl_hsd',1);triggerSelect();" href="javascript:void(0);">
                                    <div class="panel-footer" style="background-color:#337ab7">
                                        <span class="pull-left" style="color:#fff">View Details</span>
                                        <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3" id="pnl_mfo"><br>
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
                                 <a onclick="loadGrafik('MFO','getGrafikMfo','pnl_mfo',1);triggerSelect();" href="javascript:void(0);">
                                    <div class="panel-footer" style="background-color:#ffc107">
                                        <span class="pull-left" style="color:#fff">View Details</span>
                                        <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3" id="pnl_bio" hidden><br>
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
                                 <a onclick="loadGrafik('BIO','getGrafikBIO','pnl_bio',1);triggerSelect();" href="javascript:void(0);">
                                    <div class="panel-footer" style="background-color:#28a745">
                                        <span class="pull-left" style="color:#fff">View Details</span>
                                        <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3" id="pnl_hsdbio"><br>
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
                               <a onclick="loadGrafik('HSD+BIO','getGrafikHSDBIO','pnl_hsdbio',1);triggerSelect();" href="javascript:void(0);">
                                    <div class="panel-footer" style="background-color:#dc3545">
                                        <span class="pull-left" style="color:#fff">View Details</span>
                                        <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                         <div class="col-md-3" id="pnl_ido"><br>
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
                                  <a onclick="loadGrafik('IDO','getGrafikIDO','pnl_ido',1);triggerSelect();" href="javascript:void(0);">
                                    <div class="panel-footer" style="background-color:#04B4AE">
                                        <span class="pull-left" style="color:#fff">View Details</span>
                                        <span class="pull-right" style="color:#fff"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>  
                </div>
                <!-- Card -->

                <!-- Graph -->
                <div id="div_grafik">
                    <div style="float: right;width: 15%;margin-right: 10px">
                        <div class="form-group">
                            <label>Filter</label>
                            <select class="form-control" id="periode" onchange="changePeriode(this.value)">
                                <option value="1">Per Hari</option>
                                <option value="2">Per Bulan</option>
                            </select>
                        </div>
                    </div>
                    <div id="container_grafik" style="height: 800px;width: 100%"></div>
                </div>
                <!-- Graph -->
            </div>
        </div>
    </div>

</div>    
<div class="well-content clearfix" id="divTable" style="display: none">
    <?php
        $x='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $namaUnit = $x.'Unit'.$x;
    ?>
    <table id="dataTable" class="table-striped" style="font-size: 12px">
        <thead>
            <tr>
                <th>No</th>
                <th><?php echo $namaUnit; ?></th>
                 <?php 
                    for($i = 1;$i <= 31; $i++) {
                        $value = $i;
                        if ($i < 10) {
                            $value = str_pad($i, 2, "0", STR_PAD_LEFT);
                        }

                        echo "<th>TGL ".$value."</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot id="tfoot"></tfoot>
    </table>
</div>

<div class="well-content clearfix" id="divTableTahun" style="display: none">
    <?php
        $x='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $namaUnit = $x.'Unit'.$x;
    ?>
    <table id="dataTableTahun" class="table-striped" style="font-size: 12px">
        <thead>
            <?php 
            $bulan = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
            ?>
            <tr>
                <th>No</th>
                <th><?php echo $namaUnit; ?></th>
                <?php foreach($bulan as $key) {
                    echo "<th>".$key."</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot id="tfoot"></tfoot>
    </table>
</div>
<br/>
<div id="form-content" class="modal fade modal-xlarge">
</div>

<input type="hidden" id="tipe">
<input type="hidden" id="fungsi">
<input type="hidden" id="panel_name">

<script>    
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth();
    var strMonth;
    var vJsonTable;
    var vJsonTableTahun;
    month++;
    var maxTgl = 0;
    var maxBln = 0;

    if (month < 10) {
        strMonth = '0'+month;
    } else {
        strMonth = month;
    }

    $('select[name="TAHUN"]').val(year);
    $('select[name="BULAN"]').val(strMonth);

    getDataTable = function () {

        if($('#periode').val() == 1){
            $('#divTable').show();
            $('#divTableTahun').hide();
            $('html, body').animate({scrollTop: $('#divTable').offset().top}, 1000);
            setDataTable(vJsonTable);
        } else {
            $('#divTable').hide();
            $('#divTableTahun').show();
            $('html, body').animate({scrollTop: $('#divTableTahun').offset().top}, 1000);
            setDataTableTahun(vJsonTableTahun);
        } 
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

    $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);

    function triggerSelect() {
        $('#periode').val("1");
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

        if ($('#bln').val()){
            if (vUnit){
                vUnit = vUnit +'<br>'+ $('#bln option:selected').text();
            } else {
                vUnit = $('#bln').val();    
            }
        }

        if ($('#thn').val()){
            if ($('#bln').val()){
                vUnit = vUnit +' '+ $('#thn').val();    
            } else {
                if (vUnit){
                    vUnit = vUnit +'<br>'+ $('#thn').val();    
                } else {
                    vUnit = $('#thn').val();    
                }   
            }
        }

        return vUnit;
    }

    function getNamaUnitTahun(vBBM){
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

        if ($('#bln').val()){
                vUnit = vUnit+'<br>Januari - Desember';    
        }

        if ($('#thn').val()){
            if ($('#bln').val()){
                vUnit = vUnit +' '+ $('#thn').val();    
            } else {
                if (vUnit){
                    vUnit = vUnit +'<br>'+ $('#thn').val();    
                } else {
                    vUnit = $('#thn').val();    
                }   
            }
        }

        return vUnit;
    }

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

    function hiddenTable(){
        $('#divTable').hide();
        $('#divTableTahun').hide();

        $('#div_grafik').hide();
    }

    function removeSeries_chart(){
        var chart = $('#container_grafik').highcharts();
        var seriesLength = chart.series.length;
        for(var i = seriesLength -1; i > -1; i--) {
            chart.series[i].remove();
        }
    }

    function removeCategories_chart(){
        var chart = $('#container_grafik').highcharts();
        var categoriesLength = chart.userOptions.xAxis.categories.length; 
        for(var i = categoriesLength -1; i > -1; i--) {
            chart.userOptions.xAxis.categories = [];
        }
    }

    $(function() {
        loadSumStockALL();
        hiddenTable();  
    });

    function changePeriode(periode){
        removeCategories_chart();
        var vBBM = $('#tipe').val();
        var vLink = $('#fungsi').val();
        var vPanel = $('#panel_name').val();
        loadGrafik(vBBM, vLink, vPanel,periode);
    }
    
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

    function set_rp_grafik(bilangan){    
        var number_string = bilangan.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? ' ' : '';
            rupiah += separator + ribuan.join(' ');
        }

        return rupiah;
    }
    //untuk cari max tgl
    function tanggal(val){
        var tgl = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
            "31"
        ];
        var tanggal_obj = [];
        
        var i = 1;
        tgl.forEach(function(element){
            var parsedTanggal = 'TGL'+ element; //TGL01
            if(val[parsedTanggal] == null) //val['TGL01']
            {
                tanggal_obj.push(null);
            }else{
                if (maxTgl < i) {
                    maxTgl = i;
                }
                tanggal_obj.push(Math.round(val[parsedTanggal]));
            }
            i++;
        });
        return tanggal_obj;
    }

    function tanggalVar(val, vTgl){
        var tgl = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12", "13", "14", "15", "16", "17", "18", "19", "20",
            "21", "22", "23", "24", "25", "26", "27", "28", "29", "30",
            "31"
        ];
        var tanggal_obj = [];
        
        var i=1;
        tgl.forEach(function(element){
            var parsedTanggal = 'TGL'+ element; //TGL01

            if (i<=maxTgl){
                if(val[parsedTanggal] == null) 
                {
                    tanggal_obj.push(null);
                }else{
                    tanggal_obj.push(Math.round(val[parsedTanggal]));
                }    
            }
            i++;
                
        });
        return tanggal_obj;
    }

    function bulan(val){
        var bulan = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12"
        ];
        var bulan_obj = [];
        
        var i = 1;
        bulan.forEach(function(element){
            var parsedBulan = 'BLN'+ element; 
            if(val[parsedBulan] == null) 
            {
                bulan_obj.push(null);
            }else{
                if (maxBln < i) {
                    maxBln = i;
                }
                bulan_obj.push(val[parsedBulan]);
            }
            i++;
        });
        return bulan_obj;
    }

    function bulanVar(val, vBulan){
        var bulan = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12"
        ];
        var bulan_obj = [];
        
        var i=1;
        bulan.forEach(function(element){
            var parsedBulan = 'BLN'+ element; //TGL01

            if (i <= maxBln){
                if(val[parsedBulan] == null) 
                {
                    bulan_obj.push(null);
                }else{
                    bulan_obj.push(Math.round(val[parsedBulan]));
                }    
            }
            i++;
                
        });
        return bulan_obj;
    }

    function loadGrafik(vBBM, vLink, vPanel,periode){
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var thn = $('#thn').val();
        var vlevelid;
        if(periode == 1) {
            var bln = $('#bln').val();
        } else {
            var bln = '';
        }
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

        $('#divTable').hide();
        $('#divTableTahun').hide();

        $('#tipe').val(vBBM);
        $('#fungsi').val(vLink);
        $('#panel_name').val(vPanel);
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('dashboard/stock_bbm/'); ?>/"+vLink,
            data: {"BULAN":bln,"TAHUN": thn,"VLEVEL": lvl0,"VLEVELID": vlevelid,"PERIODE": periode
            },
            beforeSend:function(response){
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {
                bootbox.hideAll();
                
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response) {
                bootbox.hideAll();
                setPilihPanel(vPanel);
                if(periode == 1) {
                    grafikBulan(response,vBBM)
                } else if(periode == 2){
                    grafikTahun(response,vBBM)
                }
            }
        });
    }

    function grafikBulan(response,vBBM) {
        
        var obj = JSON.parse(response);
        var tanggal_obj = [];
        var dataset = [];
        var kategori = [];
        var sum_tgl = [];

        if (obj == "" || obj == null) {
            $('#div_grafik').hide();
            bootbox.hideAll();
                
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Data masih kosong -- </div>', function() {});
            removeSeries_chart();
        }else{
            $('#div_grafik').show();
            $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
            vJsonTable = response;

            //untuk cari max tgl
            $.each(obj, function(index, val){
                tanggal(val);
            });

            for (i = 0; i <= 31; i++) {
                    sum_tgl[i]= 0;
            }

            $.each(obj, function(index, val){
                var series_data = {};
                
                series_data.name = val.UNIT;                   
                series_data.data = tanggalVar(val,maxTgl);

                for (i = 0; i <= series_data.data.length; i++) {
                    if (!isNaN(series_data.data[i])){
                        sum_tgl[i]= series_data.data[i] + sum_tgl[i];
                    }
                }

                dataset.push(series_data);
            });

            for (i = 0; i <= sum_tgl.length; i++) {
                if (!isNaN(sum_tgl[i])){
                    sum_tgl[i]= set_rp_grafik(sum_tgl[i]);
                }
            }

            $(function (){
                
                $('#container_grafik').highcharts({
                    chart : {
                        type: 'area'
                    },
                    title: {
                        text: 'Persediaan BBM PT PLN (Persero)'
                    },
                    subtitle: {
                        text: getNamaUnit(vBBM)
                    },
                    yAxis: {
                        title: {
                            text: 'Volume  X  1.000.000 (L)'
                        },
                        labels: {
                            formatter: function () {
                                return  this.value / 1000000;
                            }   
                        }
                    },
                    xAxis: {
                        title: {
                            text: 'Tanggal'
                        },
                        categories: [
                            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12',
                            '13','14','15','16','17','18','19','20','21','22','23','24','25',
                            '26','27','28','29','30','31'
                        ]
                    },
                    tooltip: {
                        headerFormat: 'Tanggal {point.x}<br/>',
                        pointFormat: '{series.name}: {point.y}<br/>Total Volume: {point.total}',
                            pointFormatter: function () {
                                return '<span style="color:'+this.color+'">\u25CF</span> '+ this.series.name + ': ' + set_rp_grafik(this.y) + '<br/><b>Total Volume: ' + sum_tgl[this.x]+'</b>';
                        }
                    },
                    plotOptions: {
                        area: {
                            stacking: 'normal',
                            marker: {
                                enabled: false,
                            },
                        },
                    },
                    exporting: {
                        buttons: {
                            contextButton: {
                                menuItems: btnGetDataTable
                            }
                        }
                    },

                    series: dataset,

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            });
        } 
    }

    function grafikTahun(response,vBBM) {

        removeSeries_chart();
        var obj = JSON.parse(response);
        var bulan_obj = [];
        var dataset = [];
        var kategori = [];
        var sum_bulan = [];

        if (obj == "" || obj == null) {
            $('#div_grafik').hide();
            removeSeries_chart();
        }else {
            $('#div_grafik').show();
            $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
            vJsonTableTahun = response;

            $.each(obj, function(index, val){
                bulan(val);
            });

            for (i = 0; i <= 12; i++) {
                    sum_bulan[i]= 0;
            }

            $.each(obj, function(index, val){
                var series_data = {};
                
                series_data.name = val.UNIT;                   
                series_data.data = bulanVar(val,maxBln);


                for (i = 0; i <= series_data.data.length; i++) {
                    if (!isNaN(series_data.data[i])){
                        sum_bulan[i]= series_data.data[i] + sum_bulan[i];
                    }
                }

                dataset.push(series_data);
            });

            for (i = 0; i <= sum_bulan.length; i++) {
                if (!isNaN(sum_bulan[i])){
                    sum_bulan[i]= set_rp_grafik(sum_bulan[i]);
                }
            }

            $(function (){
                $('#container_grafik').highcharts({
                    chart : {
                        type: 'area'
                    },
                    title: {
                        text: 'Persediaan BBM PT PLN (Persero)'
                    },
                    subtitle: {
                        text: getNamaUnitTahun(vBBM)
                    },
                    yAxis: {
                        title: {
                            text: 'Volume  X  1.000.000 (L)'
                        },
                        labels: {
                            formatter: function () {
                                return  this.value / 1000000;
                            }   
                        }
                    },
                    xAxis: {
                        title: {
                            text: 'Bulan'
                        },
                        categories: [
                            'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
                        ]
                    },
                    tooltip: {
                        headerFormat: 'Bulan {point.x}<br/>',
                        pointFormat: '{series.name}: {point.y}<br/>Total Volume: {point.total}',
                            pointFormatter: function () {
                                return '<span style="color:'+this.color+'">\u25CF</span> '+ this.series.name + ': ' + set_rp_grafik(this.y)+'</b><br/><b>Total Volume: ' + sum_bulan[this.x]+'</b>';
                        }
                    },
                    plotOptions: {
                        area: {
                            stacking: 'normal',
                            marker: {
                                enabled: false,
                            },
                        },
                    },
                    exporting: {
                        buttons: {
                            contextButton: {
                                menuItems: btnGetDataTable
                            }
                        }
                    },
                    
                    series: dataset,

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                });
            });
        } 
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
            url: "<?php echo base_url('dashboard/stock_bbm/get_sum_stock'); ?>",
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
            "fixedColumns": {"leftColumns": 2},
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": [0]},
                {"className": "dt-left","targets": [1]},
                {"className": "dt-right","targets": '_all'},
            ]
        });

        $('#dataTableTahun').dataTable({
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
            "fixedColumns": {"leftColumns": 2},
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": [0]},
                {"className": "dt-left","targets": [1]},
                {"className": "dt-right","targets": '_all'},
            ]
        });
    });

    function isNumeric(n) {
        var val = n == null ? "0" : n;

        return parseFloat(val);
    }

    function setDataTable(vdata){
      $('#tfoot').html('');
      var obj = JSON.parse(vdata);
      var t = $('#dataTable').DataTable();
      var vtotal = [];

      for (i = 0; i <= 31; i++) {
        vtotal[i]= 0;
      }

      t.clear().draw();

      var nomer = 1;
      $.each(obj, function (index, value) {

        var UNIT = value.UNIT == null ? "" : value.UNIT;

        vtotal[1] = isNumeric(vtotal[1]) + isNumeric(value.TGL01);
        vtotal[2] = isNumeric(vtotal[2]) + isNumeric(value.TGL02);
        vtotal[3] = isNumeric(vtotal[3]) + isNumeric(value.TGL03);
        vtotal[4] = isNumeric(vtotal[4]) + isNumeric(value.TGL04);
        vtotal[5] = isNumeric(vtotal[5]) + isNumeric(value.TGL05);
        vtotal[6] = isNumeric(vtotal[6]) + isNumeric(value.TGL06);
        vtotal[7] = isNumeric(vtotal[7]) + isNumeric(value.TGL07);
        vtotal[8] = isNumeric(vtotal[8]) + isNumeric(value.TGL08);
        vtotal[9] = isNumeric(vtotal[9]) + isNumeric(value.TGL09);
        vtotal[10] = isNumeric(vtotal[10]) + isNumeric(value.TGL10);
        vtotal[11] = isNumeric(vtotal[11]) + isNumeric(value.TGL11);
        vtotal[12] = isNumeric(vtotal[12]) + isNumeric(value.TGL12);
        vtotal[13] = isNumeric(vtotal[13]) + isNumeric(value.TGL13);
        vtotal[14] = isNumeric(vtotal[14]) + isNumeric(value.TGL14);
        vtotal[15] = isNumeric(vtotal[15]) + isNumeric(value.TGL15);
        vtotal[16] = isNumeric(vtotal[16]) + isNumeric(value.TGL16);
        vtotal[17] = isNumeric(vtotal[17]) + isNumeric(value.TGL17);
        vtotal[18] = isNumeric(vtotal[18]) + isNumeric(value.TGL18);
        vtotal[19] = isNumeric(vtotal[19]) + isNumeric(value.TGL19);
        vtotal[20] = isNumeric(vtotal[20]) + isNumeric(value.TGL20);
        vtotal[21] = isNumeric(vtotal[21]) + isNumeric(value.TGL21);
        vtotal[22] = isNumeric(vtotal[22]) + isNumeric(value.TGL22);
        vtotal[23] = isNumeric(vtotal[23]) + isNumeric(value.TGL23);
        vtotal[24] = isNumeric(vtotal[24]) + isNumeric(value.TGL24);
        vtotal[25] = isNumeric(vtotal[25]) + isNumeric(value.TGL25);
        vtotal[26] = isNumeric(vtotal[26]) + isNumeric(value.TGL26);
        vtotal[27] = isNumeric(vtotal[27]) + isNumeric(value.TGL27);
        vtotal[28] = isNumeric(vtotal[28]) + isNumeric(value.TGL28);
        vtotal[29] = isNumeric(vtotal[29]) + isNumeric(value.TGL29);
        vtotal[30] = isNumeric(vtotal[30]) + isNumeric(value.TGL30);
        vtotal[31] = isNumeric(vtotal[31]) + isNumeric(value.TGL31);


        t.row.add( [
            nomer, 
            UNIT, 
            convertToRupiah(value.TGL01),
            convertToRupiah(value.TGL02),
            convertToRupiah(value.TGL03),
            convertToRupiah(value.TGL04),
            convertToRupiah(value.TGL05),
            convertToRupiah(value.TGL06),
            convertToRupiah(value.TGL07),
            convertToRupiah(value.TGL08),
            convertToRupiah(value.TGL09),
            convertToRupiah(value.TGL10),
            convertToRupiah(value.TGL11),
            convertToRupiah(value.TGL12),
            convertToRupiah(value.TGL13),
            convertToRupiah(value.TGL14),
            convertToRupiah(value.TGL15),
            convertToRupiah(value.TGL16),
            convertToRupiah(value.TGL17),
            convertToRupiah(value.TGL18),
            convertToRupiah(value.TGL19),
            convertToRupiah(value.TGL20),
            convertToRupiah(value.TGL21),
            convertToRupiah(value.TGL22),
            convertToRupiah(value.TGL23),
            convertToRupiah(value.TGL24),
            convertToRupiah(value.TGL25),
            convertToRupiah(value.TGL26),
            convertToRupiah(value.TGL27),
            convertToRupiah(value.TGL28),
            convertToRupiah(value.TGL29),
            convertToRupiah(value.TGL30),
            convertToRupiah(value.TGL31)
        ]).draw( false );

        nomer++;
      });
      if (nomer > 1){  
          t.row.add( [
                '', 
                '<b>TOTAL</b>', 
                '<b>'+convertToRupiah(vtotal[1])+'</b>',
                '<b>'+convertToRupiah(vtotal[2])+'</b>',
                '<b>'+convertToRupiah(vtotal[3])+'</b>',
                '<b>'+convertToRupiah(vtotal[4])+'</b>',
                '<b>'+convertToRupiah(vtotal[5])+'</b>',
                '<b>'+convertToRupiah(vtotal[6])+'</b>',
                '<b>'+convertToRupiah(vtotal[7])+'</b>',
                '<b>'+convertToRupiah(vtotal[8])+'</b>',
                '<b>'+convertToRupiah(vtotal[9])+'</b>',
                '<b>'+convertToRupiah(vtotal[10])+'</b>',
                '<b>'+convertToRupiah(vtotal[11])+'</b>',
                '<b>'+convertToRupiah(vtotal[12])+'</b>',
                '<b>'+convertToRupiah(vtotal[13])+'</b>',
                '<b>'+convertToRupiah(vtotal[14])+'</b>',
                '<b>'+convertToRupiah(vtotal[15])+'</b>',
                '<b>'+convertToRupiah(vtotal[16])+'</b>',
                '<b>'+convertToRupiah(vtotal[17])+'</b>',
                '<b>'+convertToRupiah(vtotal[18])+'</b>',
                '<b>'+convertToRupiah(vtotal[19])+'</b>',
                '<b>'+convertToRupiah(vtotal[20])+'</b>',
                '<b>'+convertToRupiah(vtotal[21])+'</b>',
                '<b>'+convertToRupiah(vtotal[22])+'</b>',
                '<b>'+convertToRupiah(vtotal[23])+'</b>',
                '<b>'+convertToRupiah(vtotal[24])+'</b>',
                '<b>'+convertToRupiah(vtotal[25])+'</b>',
                '<b>'+convertToRupiah(vtotal[26])+'</b>',
                '<b>'+convertToRupiah(vtotal[27])+'</b>',
                '<b>'+convertToRupiah(vtotal[28])+'</b>',
                '<b>'+convertToRupiah(vtotal[29])+'</b>',
                '<b>'+convertToRupiah(vtotal[30])+'</b>',
                '<b>'+convertToRupiah(vtotal[31])+'</b>'

           ]).draw( false );
      }

    }

    function setDataTableTahun(vdata){
      $('#tfoot').html('');
      var obj = JSON.parse(vdata);
      var t = $('#dataTableTahun').DataTable();
      var vtotal = [];

      for (i = 0; i <= 12; i++) {
        vtotal[i]= 0;
      }

      t.clear().draw();

      var nomer = 1;
      $.each(obj, function (index, value) {

        var UNIT = value.UNIT == null ? "" : value.UNIT;

        vtotal[1] = isNumeric(vtotal[1]) + isNumeric(value.BLN01);
        vtotal[2] = isNumeric(vtotal[2]) + isNumeric(value.BLN02);
        vtotal[3] = isNumeric(vtotal[3]) + isNumeric(value.BLN03);
        vtotal[4] = isNumeric(vtotal[4]) + isNumeric(value.BLN04);
        vtotal[5] = isNumeric(vtotal[5]) + isNumeric(value.BLN05);
        vtotal[6] = isNumeric(vtotal[6]) + isNumeric(value.BLN06);
        vtotal[7] = isNumeric(vtotal[7]) + isNumeric(value.BLN07);
        vtotal[8] = isNumeric(vtotal[8]) + isNumeric(value.BLN08);
        vtotal[9] = isNumeric(vtotal[9]) + isNumeric(value.BLN09);
        vtotal[10] = isNumeric(vtotal[10]) + isNumeric(value.BLN10);
        vtotal[11] = isNumeric(vtotal[11]) + isNumeric(value.BLN11);
        vtotal[12] = isNumeric(vtotal[12]) + isNumeric(value.BLN12);

        t.row.add( [
            nomer, 
            UNIT, 
            convertToRupiah(value.BLN01),
            convertToRupiah(value.BLN02),
            convertToRupiah(value.BLN03),
            convertToRupiah(value.BLN04),
            convertToRupiah(value.BLN05),
            convertToRupiah(value.BLN06),
            convertToRupiah(value.BLN07),
            convertToRupiah(value.BLN08),
            convertToRupiah(value.BLN09),
            convertToRupiah(value.BLN10),
            convertToRupiah(value.BLN11),
            convertToRupiah(value.BLN12)

        ]).draw( false );

        nomer++;
      });
      if (nomer > 1){  
          t.row.add( [
                '', 
                '<b>TOTAL</b>', 
                '<b>'+convertToRupiah(vtotal[1])+'</b>',
                '<b>'+convertToRupiah(vtotal[2])+'</b>',
                '<b>'+convertToRupiah(vtotal[3])+'</b>',
                '<b>'+convertToRupiah(vtotal[4])+'</b>',
                '<b>'+convertToRupiah(vtotal[5])+'</b>',
                '<b>'+convertToRupiah(vtotal[6])+'</b>',
                '<b>'+convertToRupiah(vtotal[7])+'</b>',
                '<b>'+convertToRupiah(vtotal[8])+'</b>',
                '<b>'+convertToRupiah(vtotal[9])+'</b>',
                '<b>'+convertToRupiah(vtotal[10])+'</b>',
                '<b>'+convertToRupiah(vtotal[11])+'</b>',
                '<b>'+convertToRupiah(vtotal[12])+'</b>'

           ]).draw( false );
      }

    }

</script>

<script>
    jQuery(document).ready(function($)
    {  
      $("#btn-collapse").click(function()
      {

        $("#collapse").slideToggle( "slow");

          if ($("#btn-collapse").text() == "Pilih Pencarian") {
            $("#btn-collapse").text("Fitur Pencarian")
          }
          else {
            $("#btn-collapse").text("Pilih Pencarian")
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
</script>