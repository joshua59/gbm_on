<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>

<style type="text/css">
#modal_pencarian{
  width: 80%;
  left: 10%;
  margin: 0 auto;
}

select{
    background: #dddddd;
}
</style>

<style type="text/css">
    .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    }     
</style>

<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">

        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
            ?>
            <div class="control-group">
                <label class="control-label">Periode Perhitungan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('periode', !empty($default->PERIODE) ? $default->PERIODE : '', 'class="span4" placeholder="Pilih Periode Perhitungan" id="periode" readonly'); ?>
                    <?php echo form_hidden('periode_edit', !empty($default->PERIODE) ? $default->PERIODE : '', 'id="periode_edit"'); ?>
                    <?php echo form_hidden('IDGROUP', !empty($default->IDGROUP) ? $default->IDGROUP : '', 'id="IDGROUP"'); ?>
                    <input type="hidden" name="tgl" id="tgl" class="form_datetime">
                    <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'view' ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Periode (Kurs & MOPS)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('tglawal', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'class="form_datetime" placeholder="Dari Tanggal" id="tglawal" style="width: 120px" readonly'); ?>
                            <label for="">s/d</label>
                    <?php echo form_input('tglakhir', !empty($default->TGLAKHIR) ? $default->TGLAKHIR : '', 'class="form_datetime" placeholder="Sampai Tanggal" id="tglakhir" style="width: 120px" readonly'); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Referensi Kurs<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('JENIS_KURS', $opsi_jns_kurs, !empty($default->JNS_KURS) ? $default->JNS_KURS : '', 'class="form-control span4" id="JENIS_KURS" disabled'); ?>
                </div>
            </div>            

            <div class="control-group" hidden>
                <label for="control-label" class="control-label" id="up_nama">Upload File (Max 5 MB) : </label> 
                <div class="controls" id="up_file">
                        <?php echo form_upload('PATH_FILE', 'class="span6"'); ?>
                </div>
                <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : ''?>">
            </div>
            
            <div class="control-group">
                <label for="control-label" class="control-label"> </label> 
                <!-- dokumen -->
                <?php  
                    if ($this->laccess->is_prod()){ ?>
                        <div class="controls" id="dokumen">
                            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : '';?>"><b><?php echo (empty($default->PATH_FILE)) ? $default->PATH_FILE : 'Lihat Dokumen'; ?></b></a>
                        </div> 
                <?php } else { ?>
                        <div class="controls" id="dokumen">
                            <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$default->PATH_FILE;?>" target="_blank"><b><?php echo (empty($default->PATH_FILE)) ? $default->PATH_FILE : 'Lihat Dokumen'; ?></b></a>
                        </div>
                <?php } ?>
                <!-- end dokumen -->
            </div>            

            <div class="control-group" hidden>
                <label class="control-label">HSD (default) : </label>
                <div class="controls">
                    <span style="display:inline-block">
                        <label for="ak_alpha" style="display:block">Alpha</label>
                        <input type="text" name="" class="form-control rp" style="width: 75px" placeholder="Alpha" id="ak_alpha" value="<?php echo !empty($default->ALPHAHSD) ? $default->ALPHAHSD : ''?>"> <bil id="bil" hidden>%</bil>
                    </span>
                    <span style="display:inline-block">
                        <label for="ak_sulfur" style="display:block">Sulfur</label>
                        <input type="text" name="" class="form-control rp" placeholder="Sulfur" style="width: 75px" id="ak_sulfur" value="<?php echo !empty($default->SULFURHSD) ? $default->SULFURHSD : ''?>">%
                    </span>
                    <span style="display:inline-block">
                        <label for="ak_konversi" style="display:block">Konversi (L)</label>
                        <input type="text" name="" class="form-control rp" placeholder="Konversi" style="width: 80px" id="ak_konversi" value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>">
                    </span>
                    <span style="display:inline-block">
                        <label for="ak_oa" style="display:block">OAT</label>
                        <input type="text" name="" class="form-control rp" placeholder="OAT" style="width: 70px" id="ak_oa" value="<?php echo !empty($default->OAT) ? $default->OAT : ''?>">
                    </span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">No PJBBBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NOPJBBM_KONTRAK_PEMASOK', !empty($default->NOPJBBM) ? $default->NOPJBBM : '', 'class="span3" placeholder="No PJBBBM" id="NOPJBBM_KONTRAK_PEMASOK" readonly'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $pemasok, !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="form-control span4" id="ID_PEMASOK" onchange="ganti_form(this.value);" disabled'); ?>
                    <?php echo form_hidden('pemasok', !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'id="pemasok" readonly'); ?>
                </div>
            </div>

            <div class="control-group" hidden>
                <label class="control-label">Jumlah Pengiriman<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_KIRIM', !empty($default->JML_KIRIM) ? $default->JML_KIRIM : '', 'class="span2" placeholder="Ketik Jumlah" id="JML_KIRIM" '); ?>
                     <!-- <?php //echo anchor(null, 'Generate', array('id' => 'button-jml-kirim', 'class' => 'green btn')); ?> -->
                </div>
            </div>
            <br>     

            <div class="content_table">
                <div class="well-content clearfix">
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv0">
                                <!-- <div class="form_row">
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Tgl Kirim ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Volume (L) ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                </div><br>  -->   
                            </div>
                        </div>
                        
                        <input type='button' value='Add Button' id='addButton' style='display: none;'>
                        <input type='button' value='Remove Button' id='removeButton' style='display: none;'>
                        <input type='button' value='Get TextBox Value' id='getButtonValue' style='display: none;'>
                </div>
            </div><br>
            <hr>
            <?php
        echo form_close(); ?>
    </div>

    <div id="divLast">  
        <div style="float: left;width: 47%">      
            <div id="listdata" class="table-responsive"></div> 
        </div> 
        <div style="width: 6%">
            
        </div>
        <div style="float: right;width: 47%">      
            <div id="tabeldata" class="table-responsive"></div> 
        </div>    
    </div>

  <!-- Modal -->
  <div class="modal fade" id="modal_pencarian" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pencarian Kontrak Pemasok</h4>
        </div>
        <div class="modal-body">
          <!-- <p>Some text in the modal.</p> -->
                <!-- <div id ="index-content" class="well-content no-search"> -->
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
                                <div class="form_row">
                                   <div class="pull-left">
                                        <label for="password" class="control-label">Kata Kunci : </label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <input type="text" name="kata_kunci" class="control-label">
                                        </div>
                                        
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <!-- <button type="button" class="btn"><i class='icon-search'></i>Filter</button> -->
                                            <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter2')); ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php echo form_close(); ?>
                         </div>    
                    </div> 
                    <div id="content_table2" data-source="<?php echo $data_sources_pencarian; ?>" data-filter="#ffilter2"></div>
                    <div>&nbsp;</div>
                <!-- </div> -->
                <!-- <div id="form-content2" class="well-content"></div> -->
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>
    
</div>


<script type="text/javascript">
    var counter = 1;

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('.des4').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $("#addButton").click(function () {
        if(counter>20){
                alert("Max 20 data yang diperbolehkan");
                return false;
        }

        var newTextBoxDiv = $(document.createElement('div'))
             .attr("id", 'TextBoxDiv' + counter);

        var cmb_regional ="<select class='form-control cls_reg' id='reg_ke"+ counter + "' name='reg_ke"+ counter + "'>"+
        "<option value='' disabled selected>--Pilih Regional--</option>"+
        <?php if ($options_reg != '')
            { foreach ($options_reg as $row)
                 { ?>
                 "<option value='<?php echo $row['ID_REGIONAL']?>'> <?php echo $row['NAMA_REGIONAL'] ?></option>"+
                 <?php
                  }
            }?>
           "</select>";

        var cmb_level1 = "<select class='form-control cls_lv1' id='cmblv1_ke"+ counter + "' name='cmblv1_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 1--</option></select>";
        var cmb_level2 = "<select class='form-control cls_lv2' id='cmblv2_ke"+ counter + "' name='cmblv2_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 2--</option></select>";
        var cmb_level3 = "<select class='form-control cls_lv3' id='cmblv3_ke"+ counter + "' name='cmblv3_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 3--</option></select>";
        var cmb_level4 = "<select class='form-control' id='cmblv4_ke"+ counter + "' name='cmblv4_ke"+ counter + "' ><option value='' disabled selected>--Pilih Pembangkit--</option></select>";

        var spasi = '&nbsp;&nbsp;&nbsp;';

        var text_alpha = '<span style="display:inline-block">'+
                         '<label for="ak_alpha_ke'+counter+'" style="display:block">Alpha</label>'+
                         '<input type="text" name="ak_alpha_ke'+counter+'" class="form-control rp" style="width: 75px" placeholder="Alpha" id="ak_alpha_ke'+counter+'" value="<?php echo !empty($default->ALPHAHSD) ? $default->ALPHAHSD : ''?>" readonly>'+ '<bil id="bil_ke'+counter+'" hidden>%</bil>'+
                         '</span>';

        var text_persen = '<span style="display:inline-block">'+
                          '<label for="bilangan_ke'+counter+'" style="display:block"></label>'+
                          '<select class="form-control" style="width: 50px" id="bilangan_ke'+counter+'" style="display: none">'+
                                '<option value="1">$</option>'+
                                '<option value="2">%</option>'+
                          '</select>'+
                          '</span>';

        var text_sulfur = '<span style="display:inline-block">'+
                          '<label for="ak_sulfur_ke'+counter+'" style="display:block">Sulfur</label>'+
                          '<input type="text" name="ak_sulfur_ke'+counter+'" class="form-control rp" placeholder="Sulfur" style="width: 75px" id="ak_sulfur_ke'+counter+'" value="<?php echo !empty($default->SULFURHSD) ? $default->SULFURHSD : ''?>" readonly>%'+
                          '</span>';

        var text_konversi = '<span style="display:inline-block">'+
                            '<label for="ak_konversi_ke'+counter+'" style="display:block">Konversi (L)</label>'+
                            '<input type="text" name="ak_konversi_ke'+counter+'" class="form-control rp" placeholder="Konversi" style="width: 80px" id="ak_konversi_ke'+counter+'" value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>" readonly>'+
                            '</span>';
       
        var text_oat = '<span style="display:inline-block">'+
                       '<label for="ak_oa_ke'+counter+'" style="display:block">OAT</label>'+
                       '<input type="text" name="ak_oa_ke'+counter+'" class="form-control rp" placeholder="OAT" style="width: 70px" id="ak_oa_ke'+counter+'" value="<?php echo !empty($default->OAT) ? $default->OAT : ''?>" readonly>'+
                       '</span>';

        var visi = '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Regional ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_regional+'</div></div>'+
        '</div><br>'+
        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Level 1 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level1+'</div></div>'+
        '<div class="pull-left span1"><label for="password" class="control-label">Level 3 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level3+'</div></div>'+
        '</div><br>'+
        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Level 2 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level2+'</div></div>'+
        '<div class="pull-left span1"><label for="password" class="control-label">Pembangkit ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level4+'</div></div>'+
        '</div><br><br>'+

        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">HSD ke : '+ counter + '</label>'+
        '<div class="controls">'+text_alpha+text_persen+spasi+text_sulfur+spasi+text_konversi+spasi+text_oat+'</div></div>'+

        '</div><br><hr>';

        newTextBoxDiv.after().html(visi);
        newTextBoxDiv.appendTo("#TextBoxesGroup");
        $('#JML_KIRIM').val(counter);
        // $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
        counter++;
    });

    $("#removeButton").click(function () {
        if(counter==1){
            //alert("No more textbox to remove");
            return false;
        }

        counter--;
        $('#JML_KIRIM').val(counter-1);
        $("#TextBoxDiv" + counter).remove();
    });

    $("#getButtonValue").click(function () {
        var msg = '';
        for(i=1; i<counter; i++){
            msg += "\n Textbox #" + i + " : " + $('#tgl_ke' + i).val();
        }
        alert(msg);
    });

    $("#button-jml-kirim").click(function () {
        var x = $('#JML_KIRIM').val(); 

        if(x>31){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 31 data jumlah pengiriman yang diperbolehkan</div>';
            bootbox.alert(message, function() {});
            $('#JML_KIRIM').val('31');
        }

        for (i = 1; i <= 31; i++) {
            $("#TextBoxDiv"+i).hide();
        }

        for (i = 1; i <= x; i++) {
            $("#TextBoxDiv"+i).show();

        }
        setHitungKirim();
    });

    for (i = 0; i < 20; i++) {
        $("#addButton").click();
    }

    for (i = 1; i <= 20; i++) {

        $('input[name=ak_alpha_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 5,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_sulfur_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_konversi_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_oa_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $("#TextBoxDiv"+i).hide();
    }

    counter = 1;
    $('#JML_KIRIM').val(0);

    $("#button-save").click(function () {
        $("#button-jml-kirim").click();
    });

    $('input[name=JML_KIRIM]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 0,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });


    function get_mops_kurs_edit(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/get_mops_kurs_akr_kpm_edit/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
    }

    function get_hitung_harga_edit(){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                var data_kirim = $("#finput").serialize();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga/get_hitung_harga_edit/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                        var icon = 'icon-remove-sign'; var color = '#ac193d;';
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        // bootbox.alert(message, function() {
                            if (content_id){
                                $('#listdata').html(data[4]);
                                get_mops_kurs_edit(data[5]);
                                $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
                                // $('#btn_simpan').show();
                                // alert('ok');
                                // console.log(data[4]);    
                                // alert(data);
                            }
                        // });
                    }    
                })
        //     }
        // });
    }  

    get_detail($('#IDGROUP').val()); 
    function get_detail(vid){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                var data_kirim = "vid="+vid;

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga/get_detail_edit/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();
                        var x = 0;
                        var JNS_KURS=0;
                        $.each(data, function () {
                            $("#NOPJBBM_KONTRAK_PEMASOK").val(this.NOPJBBM);
                            $('#ID_PEMASOK').val(this.KODE_PEMASOK);
                            $('#pemasok').val(this.KODE_PEMASOK);
                            JNS_KURS = this.JNS_KURS;

                            //detail
                            x++;
                            $("#reg_ke"+x).empty();
                            $("#reg_ke"+x).append('<option value="'+ this.ID_REGIONAL +'">'+ this.NAMA_REGIONAL +'</option>');
                            $("#cmblv1_ke"+x).empty();
                            $("#cmblv1_ke"+x).append('<option value="'+ this.COCODE +'">'+ this.LEVEL1 +'</option>'); 
                            $("#cmblv2_ke"+x).empty();
                            $("#cmblv2_ke"+x).append('<option value="'+ this.PLANT +'">'+ this.LEVEL2 +'</option>'); 
                            $("#cmblv3_ke"+x).empty();
                            $("#cmblv3_ke"+x).append('<option value="'+ this.STORE_SLOC +'">'+ this.LEVEL3 +'</option>'); 
                            $("#cmblv4_ke"+x).empty();
                            $("#cmblv4_ke"+x).append('<option value="'+ this.SLOC +'">'+ this.LEVEL4 +'</option>'); 

                            $("#bilangan_ke"+x).empty();
                            $("#bilangan_ke"+x).append('<option value="'+ this.TIPE_ALPHA +'">'+ this.TIPE_ALPHA +'</option>');

                            $("#ak_alpha_ke"+x).val(this.ALPHA_HSD);
                            $("#ak_sulfur_ke"+x).val(this.SULFUR_HSD);
                            $("#ak_konversi_ke"+x).val(this.KONVERSI_HSD);
                            $("#ak_oa_ke"+x).val(this.ONGKOS_ANGKUT);


                            if (this.KODE_PEMASOK=='002'){
                                $('#bilangan_ke'+x).show();
                            } else {
                                $('#bilangan_ke'+x).hide();
                            }

                            $("#TextBoxDiv"+x).show();                                                        
                        });    
                        if (JNS_KURS==1){
                            $('#JENIS_KURS').val(1);
                        } else {
                            $('#JENIS_KURS').val(0);    
                        }
                        $('#JML_KIRIM').val(x);
                        $("#btn_hitung").show();  
                        $('html, body').animate({scrollTop: $("#up_file").offset().top}, 1000);    

                        get_hitung_harga_edit();              
                    }    
                })
        //     }
        // });
    } 

    // jQuery(function($) {
        load_table('#content_table2', 1, '#ffilter2');

        $('#button-filter2').click(function() {
            load_table('#content_table2', 1, '#ffilter2');
        });
    // });
    $('#modal_pencarian').show();
    $('#modal_pencarian').hide();
</script>