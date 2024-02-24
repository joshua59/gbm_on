<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    tr {background-color: #CED8F6;}
    table {
        border-collapse: collapse;
        width:100%;
    }
    td.tengah {text-align: center;}
    td.kanan {text-align: right;}

    .label_ket {
    font-size: 10px;
    }

    .cls_modal{
      width: 90%;
      height: 700px;
      left: 5%;
      margin: auto;
      /*left: 0%;
      margin: 0 auto;*/
    }   

    .dataTables_scrollHeadInner {
     width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
     width: 100% !important;    
    }  
      
    ul.dashed{
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }

    ul.dashed > li {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }
   
    ul.dashed > li:before {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }   
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan'; ?></span>
        </div>
    </div>
    <div id="div_load">               
        <div id="div_progress">
            <div id="div_bar">0%</div>
        </div>
    </div> 
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                        <input type="hidden" name="di_cari" id="di_cari">
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Pembangkit : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Jenis Bahan Bakar :</label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Data s/d Tanggal : </label>
                    <div class="controls">
                        <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" placeholder="Tanggal awal" id="tglawal" autocomplete="off"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Unit">
                        <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>  
                </div>
                
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                    </div>                   
                </div>
                <div class="pull-left span3">
                 
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
                  
              </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <br>
        <div class="well-content no-search" id="divTable">
            <table id="dataTable" class="display" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="text-align: center" rowspan="2">NO</th>
                        <th style="text-align: center" colspan="4">LEVEL</th>
                        <th style="text-align: center" rowspan="2">PEMBANGKIT</th>
                        <th style="text-align: center" rowspan="2">JENIS BAHAN BAKAR</th>
                        <th style="text-align: center" rowspan="2">TGL STOCK TERAKHIR</th>
                        <th style="text-align: center" rowspan="2">DEAD STOCK<br>(L)</th>
                        <th style="text-align: center" rowspan="2">PEMAKAIAN TERTINGGI<br>(L)</th>
                        <th style="text-align: center" colspan="2">STOCK</th>
                        <th style="text-align: center" rowspan="2">HOP<br>(Hari)</th>
                    </tr>
                    <tr>
                        <th style="text-align: center">0</th>
                        <th style="text-align: center">1</th>
                        <th style="text-align: center">2</th>
                        <th style="text-align: center">3</th>
                        <th style="text-align: center">AKHIR<br>(L)</th>
                        <th style="text-align: center">AKHIR<br>EFEKTIF<br>(L)</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id ="index-content">
              <ul class="dashed">
                <li>(* HOP : Hari Operasi Pembangkit)</li>
                <li>(* Hari Operasi Pembangkit (Hari) : untuk pembangkit selain PLTU)</li>
                <li>(* Hari Operasi Pembangkit (kali start) : untuk pembangkit PLTU) </li>                
              </ul>                 
            </div>
        </div>
    </div>
</div>
<br>


<form id="export_excel" action="<?php echo base_url('laporan/stockakhir_bbm/export_excel'); ?>" method="post">
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
    <input type="hidden" name="xbbm_nama">
    <input type="hidden" name="xtgl">
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xCARI">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/stockakhir_bbm/export_pdf'); ?>" method="post" target="_blank">
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
    <input type="hidden" name="pbbm_nama">
    <input type="hidden" name="ptgl">
    <input type="hidden" name="pbln_nama">
    <input type="hidden" name="pthn">   
    <input type="hidden" name="plvlid">
    <input type="hidden" name="pCARI">
</form>

<script type="text/javascript">
    var today = new Date();
    var year = today.getFullYear();
    var table, table_adendum;

    $('#tglawal').val(getDateStart());
    $('#div_load').hide();

    var t = $('#dataTable').DataTable({
        "scrollY": "450px",
        "searching": false,
        "scrollX": false,
        "scrollCollapse": false,
        "bPaginate": true,
        fixedHeader: {
          header: true,
          footer: true
        },
        "ordering" : true,
        "bLengthChange": true,
        "bSearch" :true,
        "bFilter": false,
        "bInfo": true,
        "ordering" :false,
        "bAutoWidth": true,
        "fixedHeader": true,
        "language": {
          "decimal": ",",
          "thousands": ".",
          "emptyTable": "Tidak ada data untuk ditampilkan",
          "info": "Total Data: _MAX_",
          "infoEmpty": "Total Data: 0",
          "lengthMenu": "Jumlah Data _MENU_"
        },
        "columnDefs": [
            {
                "className": "dt-left",
                "targets": [1,2,3,4,5]
            },
            {
              "className" : "dt-center",
              "targets" : [6,7]
            },
            {
              "className" : "dt-right",
              "targets" : [8,9,10,11,12]
            }
          ]
    });

    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    $('select[name="TAHUN"]').val(year);

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
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

        var day= d.getDate();
        if(day <= 9)
            day = '0'+day;

        var date = year +'-'+ month +'-'+ day;
        return date;
    }

    function getDateEnd() {
        var d = new Date(),
        month = '12';
        day = '31';
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month , day].join('-');
    }

    function setDateEnd(date) {
        var d = new Date(date),
        month = '12';
        day = '31';
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month , day].join('-');
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

    function get_data() {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var ID_JNS_BHN_BKR = $('#bbm').val();
        var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var awal_tahun  = tglAwal.substring(0,4); 
        var awal_bulan  = tglAwal.substring(4,6);
        var awal_hari   = tglAwal.substring(6,8); 
        var awalParsed  = awal_hari.concat(awal_bulan, awal_tahun);        
        var bbm = $('#bbm').val();
        var CARI = $('#CARI').val();


        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl3 !== ""){
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        
        if (bbm !== "") {
            if (bbm =='001') {
                bbm = 'MFO';
            }else if(bbm == '002'){
                bbm = 'IDO';
            }else if(bbm == '004'){
                bbm = 'HSD+BIO';
            }else if(bbm == '005'){
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '';
        }
        var vlink_url = "<?php echo base_url('laporan/stockakhir_bbm/get_stockakhir'); ?>";
        $.ajax({
            url: vlink_url,
            type: "POST",
            data: {
                vjns_bbm : bbm,
                vtgl : tglAwal,
                vlevel : lvl0,
                vlevelid : vlevelid,
                CARI : CARI,
            },
            beforeSend:function(data) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
            },
            success:function(data) {
                var obj = JSON.parse(data);
                if(obj == "") {
                    bootbox.hideAll();
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {
                        $('#dataTable tbody').html("");
                        $('#dataTable tbody').append('<tr><td colspan="13" style="text-align:center">Tidak ada data untuk ditampilkan</td></tr>');
                    });
                } else {
                    setTable(data);
                }
            }
        });         
    }

    function setTable(data) {
        var t = $('#dataTable').DataTable();
        var nomer = 1;
        var data_detail = JSON.parse(data);
        var total = data_detail.length;
        var progres = 0;            
        var elem = document.getElementById("div_bar");

        t.clear().draw();
        
        $.each(data_detail, function(key, value) {
            setTimeout( function(){
                var NAMA_REGIONAL = value.NAMA_REGIONAL == null ? "" : value.NAMA_REGIONAL;
                var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                var STOCK_AKHIR_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                var STOCK_AKHIR_EFEKTIF = value.STOCK_AKHIR_EFEKTIF == null ? "" : value.STOCK_AKHIR_EFEKTIF;
                var SHO = value.SHO == null ? "" : value.SHO;
                var DEAD_STOCK = value.DEAD_STOCK == null ? "" : value.DEAD_STOCK;
                var MAX_PEMAKAIAN = value.MAX_PEMAKAIAN == null ? "" : value.MAX_PEMAKAIAN;

                t.row.add([
                    nomer,NAMA_REGIONAL,LEVEL1,LEVEL2,LEVEL3,LEVEL4,
                    NAMA_JNS_BHN_BKR,TGL_MUTASI_PERSEDIAAN,convertToRupiah(DEAD_STOCK),convertToRupiah(MAX_PEMAKAIAN),
                    convertToRupiah(STOCK_AKHIR_REAL),convertToRupiah(STOCK_AKHIR_EFEKTIF),convertToRupiah(SHO)
                ]).draw(false);

                if (nomer==1){
                      bootbox.hideAll();
                      $('#div_load').show();
                      bootbox.dialog('<div class="loading-progress"></div>');                    
                }

                progres = Math.ceil((nomer/total)*100);
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';

                if (nomer>=total){
                    bootbox.hideAll();
                    $('#div_load').hide('slow');                                       
                }
                  nomer++;
                  
            }, 0 );
        });
    }

    $('#button-load').click(function(e) {
        get_data();
    });

    $('#button-excel').click(function(e) {
        var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var ID_JNS_BHN_BKR = $('#bbm').val();
        var tgl = tglAwal;
        var bbm = $('#bbm').val();
        var CARI = $('#CARI').val();
        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl3 !== ""){
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        
        if (bbm !== "") {
            if (bbm =='001') {
                bbm = 'MFO';
            }else if(bbm == '002'){
                bbm = 'IDO';
            }else if(bbm == '004'){
                bbm = 'HSD+BIO';
            }else if(bbm == '005'){
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '';
        }

        $('input[name="xlvl0"]').val(lvl0);
        $('input[name="xlvl1"]').val(lvl1);
        $('input[name="xlvl2"]').val(lvl2);
        $('input[name="xlvl3"]').val(lvl3);
        $('input[name="xlvl4"]').val(lvl4);
        $('input[name="xlvlid"]').val(vlevelid);
        
        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());
        $('input[name="xlvl4_nama"]').val($('#lvl4 option:selected').text());

        $('input[name="xbbm"]').val(bbm);
        $('input[name="xbbm_nama"]').val($('#bbm option:selected').text());

        $('input[name="xtgl"]').val(tglAwal);
        $('input[name="xCARI"]').val(CARI);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_excel').submit();
            }
        });
    });

    $('#button-pdf').click(function(e) {

        var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var ID_JNS_BHN_BKR = $('#bbm').val();
        var bln = tglAwal;
        var bbm = $('#bbm').val();
        var CARI = $('#CARI').val();


        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl3 !== ""){
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        
        if (bbm !== "") {
            if (bbm =='001') {
                bbm = 'MFO';
            }else if(bbm == '002'){
                bbm = 'IDO';
            }else if(bbm == '004'){
                bbm = 'HSD+BIO';
            }else if(bbm == '005'){
                bbm = 'HSD';
            }
        }
        if (bbm == '') {
            bbm = '';
        }

        $('input[name="plvl0"]').val(lvl0);
        $('input[name="plvl1"]').val(lvl1);
        $('input[name="plvl2"]').val(lvl2);
        $('input[name="plvl3"]').val(lvl3);
        $('input[name="plvl4"]').val(lvl4);
        $('input[name="plvlid"]').val(vlevelid);

        $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());
        $('input[name="plvl4_nama"]').val($('#lvl4 option:selected').text());

        $('input[name="pbbm"]').val(bbm);
        $('input[name="pbbm_nama"]').val($('#bbm option:selected').text());

        $('input[name="ptgl"]').val(tglAwal);
        $('input[name="pCARI"]').val(CARI);

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_pdf').submit();
            }
        });
    });

    $('#button-pdf-adendum').click(function(e) {
        $('input[name="pID"]').val($('#di_cari').val());
        $('input[name="pNO_KONTRAK"]').val($('#p_no_kontrak').html());  

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_pdf_adendum').submit();
            }
        });        
    });     

</script>

<script type="text/javascript">
    jQuery(function($) {

        get_jenisbbm();

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
            var vlink_url = '<?php echo base_url()?>laporan/stockakhir_bbm/get_options_lv1/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/stockakhir_bbm/get_options_lv2/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/stockakhir_bbm/get_options_lv3/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>laporan/stockakhir_bbm/get_options_lv4/'+stateID;
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

        function get_jenisbbm() {
            var vlink_url = '<?php echo base_url()?>laporan/stockakhir_bbm/option_jenisbbm/';
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                beforeSend:function(data) {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                success:function(data) {
                $('select[name="BBM"]').append('<option value="">-- Pilih Jenis Bahan Bakar --</option>');
                $.each(data, function(key, value) {
                    $('select[name="BBM"]').append('<option value="'+ value.ID_JNS_BHN_BKR +'">'+ value.NAMA_JNS_BHN_BKR +'</option>');
                });
                bootbox.hideAll();
                }
            });
        }
    });


</script>