<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

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
                <label class="control-label">Tanggal Penerimaan (DO/TUG/BA)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_PENERIMAAN', !empty($default->TGL_PENERIMAAN) ? $default->TGL_PENERIMAAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_PENERIMAAN"'); ?>
                    <input type="hidden" id="IDGROUP" name="IDGROUP" value="<?php echo !empty($default->IDGROUP) ? $default->IDGROUP : $IDGROUP ;?>" />                    
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Pengakuan Fisik<span class="required">*</span> : </label>
                <div class="controls">
                     <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_PENGAKUAN"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Transportir<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6 chosen" id="pembangkit"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6 chosen" id="ID_PEMASOK" '); ?>
                </div>
            </div>         

            <div id="div_unit_kirim" hidden>
                <div class="control-group">
                    <label  class="control-label">Level 1 Pengirim<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE_KIRIM', $lv1_options_all, !empty($lv1_options_all_def) ? $lv1_options_all_def : '', 'class="span6 chosen" id="COCODE_KIRIM"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Level 2 Pengirim<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT_KIRIM', $lv2_options_all, !empty($default->PLANT_KIRIM) ? $default->PLANT_KIRIM : '', 'class="span6 chosen" id="PLANT_KIRIM"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Level 3 Pengirim<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC_KIRIM', $lv3_options_all, !empty($default->STORE_SLOC_KIRIM) ? $default->STORE_SLOC_KIRIM : '', 'class="span6 chosen" id="STORE_SLOC_KIRIM"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Pembangkit Pengirim<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC_KIRIM', $lv4_options_all, !empty($default->SLOC_KIRIM) ? $default->SLOC_KIRIM : '', 'class="span6 chosen" id="SLOC_KIRIM"'); ?>
                    </div>
                </div>                    
            </div>

            <div class="control-group">
                <label class="control-label">Jenis Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('VALUE_SETTING', $option_jenis_penerimaan, !empty($default->JNS_PENERIMAAN) ? $default->JNS_PENERIMAAN : '', 'class="span3 chosen"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_PENERIMAAN', !empty($default->NO_MUTASI_TERIMA) ? $default->NO_MUTASI_TERIMA : '', 'class="span6" placeholder="Ketik Nomor Penerimaan (Max 60)"'); ?>
                    <span class="required" id="MaxId"></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3 chosen" id="jnsbbm"'); ?>
                </div>
            </div>
            
            <div class="control-group" id="komponen" style="<?php echo !empty($default->IS_MIX_BBM) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('KOMPONEN', $option_komponen, !empty($default->ID_KOMPONEN_BBM) ? $default->ID_KOMPONEN_BBM : '', 'class="span3 chosen" id="cbokomponen" '); ?>
                    <input type="hidden" id="ismix" name="ismix" value="<?php echo !empty($default->IS_MIX_BBM) ? $default->IS_MIX_BBM : '' ;?>" />
                </div>
            </div>

            <div class="control-group" id="komponen_bio" style="<?php echo !empty($default->JNS_BIO) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BIO <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('JNS_BIO', $option_komponen_bio, !empty($default->JNS_BIO) ? $default->JNS_BIO : '', 'class="span3 chosen" id="JNS_BIO" '); ?>
                    <input type="hidden" id="JNS_BIO_EDIT" name="JNS_BIO_EDIT" value="<?php echo !empty($default->JNS_BIO) ? $default->JNS_BIO : '' ;?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Volume DO/TUG/BA (L)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN', !empty($default->VOL_TERIMA) ? $default->VOL_TERIMA : '', 'class="span3" placeholder="Ketik Volume DO / BA"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Volume Penerimaan (L)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN_REAL', !empty($default->VOL_TERIMA_REAL) ? $default->VOL_TERIMA_REAL : '', 'class="span3" placeholder="Ketik Volume Penerimaan"'); ?>
                </div>
                <div style="display:none">
                    <?php echo form_input('STATUS_MUTASI_TERIMA', !empty($default->STATUS_MUTASI_TERIMA) ? $default->STATUS_MUTASI_TERIMA : '0'); ?>
                </div> 
            </div>

            <div class="control-group">
                <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : ''?>">
                <label for="password" class="control-label">Upload File (Max 10 MB) : </label>
                <div class="controls">
                    <?php echo form_upload('PATH_FILE', !empty($default->PATH_FILE) ? $default->PATH_FILE : '', 'class="span6"'); ?>
                </div>

            <!-- dokumen -->
            <?php  
                if ($this->laccess->is_prod()){ ?>
                    <div class="controls" id="dokumen">
                        <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKTRANSPORTIR" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div>
            <?php } else { ?>
                    <div class="controls" id="dokumen">
                        <a href="<?php echo base_url().'assets/upload/kontrak_transportir/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div>
            <?php } ?>
            <!-- end dokumen -->

            </div>

            <div class="control-group">
                <label class="control-label">Keterangan : </label>
                <div class="controls">
                    <!-- <?php //echo form_input('KET_MUTASI_TERIMA', !empty($default->KET_MUTASI_TERIMA) ? $default->KET_MUTASI_TERIMA : '', 'class="span4" placeholder="Keterangan Penerimaan"'); ?> -->
                    <?php
                        $data = array(
                          'name'        => 'KET_MUTASI_TERIMA',
                          'id'          => 'KET_MUTASI_TERIMA',
                          'value'       => !empty($default->KET_MUTASI_TERIMA) ? $default->KET_MUTASI_TERIMA : '',
                          'rows'        => '4',
                          'cols'        => '10',
                          'class'       => 'span6',
                          'style'       => '"none" placeholder="Ketik Keterangan Penerimaan (Max 200)"'
                        );
                      echo form_textarea($data);
                    ?>
                    <span class="required" id="MaxKet"></span>
                </div>
            </div>
            <div class="form-actions">
                <?php 
                if ($this->laccess->otoritas('edit')) {
                    echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back');"));
                }?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?> 
            </div>
            <?php
        echo form_close(); ?>
    </div>
    <br><br>
</div>

<script type="text/javascript">

//    load_table('#content_table_detail', 1, '#ffilter_detail');
//    $('#button-filter-detail').click(function() {
//        load_table('#content_table_detail', 1, '#ffilter_detail');
//    });

    var _rk='' , _lv1k='', _lv2k='', _lv3k='', _lv4k='';
    var vLevelUser = "<?php echo $set_lv; ?>";

    $('.chosen').chosen();   

    $( "#pembangkit" ).change(function() {
        var sloc = $(this).val();
        if (sloc == ''){
            sloc = '-';    
        }        
        load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");

        $('#cbokomponen').empty();
        $('#cbokomponen').append('<option value="">--Pilih Komponen BBM--</option>'); 
        $('#cbokomponen').data("placeholder","Select").trigger('liszt:updated');          

        $('select[name="JNS_BIO"]').empty();
        $('select[name="JNS_BIO"]').append('<option value="">--Pilih Komponen BIO--</option>');     
        $('select[name="JNS_BIO"]').data("placeholder","Select").trigger('liszt:updated');   

        $('select[name="VALUE_SETTING"]').empty();
        $('select[name="VALUE_SETTING"]').append('<option value="">--Pilih Jenis Penerimaan--</option>');
        $('select[name="VALUE_SETTING"]').data("placeholder","Select").trigger('liszt:updated');            

        $('#komponen').hide();
        $('#komponen_bio').hide();

        get_pemasok(sloc);
    });
    
    $("#jnsbbm").change(function(){
        var id  = $(this).val();

        $('#cbokomponen').empty();
        $('#cbokomponen').append('<option value="">--Pilih Komponen BBM--</option>');           

        $('select[name="JNS_BIO"]').empty();
        $('select[name="JNS_BIO"]').append('<option value="">--Pilih Komponen BIO--</option>');        

        $('#komponen').hide();
        $('#komponen_bio').hide();

        check_jenis_bbm('<?php echo $urlcheckjnsbbm;?>/' + id, "#komponen", "#cbokomponen");

        setKomponenBIO(id);
    });

    $("#cbokomponen").change(function(){
        var id  = $(this).val(); 
        setKomponenBIO(id);   
    });
    
    function get_pemasok(id){
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_pemasok_by_sloc/'+id;
        if(id!='-') {
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $('#ID_PEMASOK').empty();                    
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(result) {                    
                    html = '';
                    for (val in result){
                        html += "<option value='"+val+"'>" + result[val] + "</option>";
                    }
                    $('#ID_PEMASOK').html(html);
                    $('#ID_PEMASOK').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        } else {
            $('#ID_PEMASOK').empty();
            $('#ID_PEMASOK').append('<option value="">--Pilih Pemasok--</option>');
            $('#ID_PEMASOK').data("placeholder","Select").trigger('liszt:updated');
        }
    };    
    
    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    // start
    function formatDateDepan(date) {
      var tanggal =date.getDate();
      var bulan = date.getMonth()+1;
      var tahun = date.getFullYear();

      if(tanggal<10){
         tanggal='0'+tanggal;
        } 

      if(bulan<10){
         bulan='0'+bulan;
        } 

      return tanggal + "-" + bulan + "-" + tahun;
    }

    function formatDateBelakang(date) {
      var tanggal =date.getDate();
      var bulan = date.getMonth()+1;
      var tahun = date.getFullYear();

      if(tanggal<10){
         tanggal='0'+tanggal;
        } 

      if(bulan<10){
         bulan='0'+bulan;
        } 

      return tahun + "" + bulan + "" + tanggal;
    }

    function setDefaulthTglPenerimaan(){
        var date = new Date();
        var tanggal = formatDateDepan(date);

        $('input[name=TGL_PENERIMAAN]').datepicker('setStartDate', '01-01-2017');
        $('input[name=TGL_PENERIMAAN]').datepicker('setEndDate', tanggal);
    }

    function setDefaulthTglPengakuan(){
        var date = new Date();
        var tanggal = formatDateDepan(date);

        $('input[name=TGL_PENGAKUAN]').datepicker('setStartDate', '01-01-2017');
        $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', tanggal);
    }

    function checkDefaulthTglPenerimaan(){
        var date = new Date();

        var datePengakuan = $("input[name=TGL_PENGAKUAN]").val();
        var dateBatasan =formatDateBelakang(date);
        var datePenerimaan = $("input[name=TGL_PENERIMAAN]").val();

        var dateStart = datePenerimaan.substring(0, 2);
        var monthStart = datePenerimaan.substring(3, 5);
        var yearStart = datePenerimaan.substring(6, 10);

        var dateEnd = datePengakuan.substring(0, 2);
        var monthEnd = datePengakuan.substring(3, 5);
        var yearEnd = datePengakuan.substring(6, 10);

        var vDateStart = yearStart + "" + monthStart + "" + dateStart;
        var vDateEnd = yearEnd + "" + monthEnd + "" + dateEnd;

        if (vDateStart > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Penerimaan (DO/TUG) tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENERIMAAN').datepicker('update', date);
         
        }
        else if(vDateEnd > dateBatasan){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan Fisik tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_PENGAKUAN').datepicker('update', date);
        }
        else if(vDateStart > vDateEnd){
            if(datePenerimaan!=""&&datePengakuan!=""){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Penerimaan (DO/TUG) tidak boleh melebihi Tanggal Pengakuan Fisik</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_PENERIMAAN').datepicker('update', datePengakuan);
            }
        }

        cekMinTgl();
    }

    function cekMinTgl(){        
        var datePengakuan = $("input[name=TGL_PENGAKUAN]").val();
        var dateBatasan =formatDateBelakang(date);
        var datePenerimaan = $("input[name=TGL_PENERIMAAN]").val();

        var dateStart = datePenerimaan.substring(0, 2);
        var monthStart = datePenerimaan.substring(3, 5);
        var yearStart = datePenerimaan.substring(6, 10);

        var dateEnd = datePengakuan.substring(0, 2);
        var monthEnd = datePengakuan.substring(3, 5);
        var yearEnd = datePengakuan.substring(6, 10);

        var vDateStart = yearStart + "" + monthStart + "" + dateStart;
        var vDateEnd = yearEnd + "" + monthEnd + "" + dateEnd;       

       if (vDateStart){
            if (vDateStart < '20170101') {
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Penerimaan (DO/TUG) tidak boleh kurang dari tahun 2017</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_PENERIMAAN').datepicker('update', '01-01-2017');
                
            }             
        }

        if (vDateEnd){
            if (vDateEnd < '20170101') {
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan Fisik tidak boleh kurang dari tahun 2017</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_PENGAKUAN').datepicker('update', '01-01-2017');          
            }
        }                    
    }      

    $("input[name=TGL_PENERIMAAN]").change(checkDefaulthTglPenerimaan);
    $("input[name=TGL_PENGAKUAN]").change(checkDefaulthTglPenerimaan);
    $("input[name=button-save]").click(checkDefaulthTglPenerimaan);

    // set tanggal penerimaan fisik
    $(function() {
        setDefaulthTglPenerimaan();
        setDefaulthTglPengakuan();
    });
    // end

    $('input[name=VOL_PENERIMAAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=VOL_PENERIMAAN_REAL]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    function simpan_file() {
      var url = "<?php echo base_url() ?>data_transaksi/penerimaan/proses";
      bootbox.confirm('Anda yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');

            $('#finput').ajaxSubmit({
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                success: function (data) {
                  $(".bootbox").modal("hide");
                  var message = '';
                  var content_id = data[3];

                  if (data[0]) {
                    var icon = 'icon-ok-sign';
                    var color = '#0072c6;';
                  } else {
                    var icon = 'icon-remove-sign'; 
                    var color = '#ac193d;';
                  }

                  message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                  message += data[2];

                  bootbox.alert(message, function() {
                    if (data[0]) {
                        load_table('#content_table_detail', 1, '#ffilter_detail');
                    }                        
                  });
                }
            });
        }
      });
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
        $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    function setDefaultLv1Kirim(){
        $('select[name="COCODE_KIRIM"]').empty();
        $('select[name="COCODE_KIRIM"]').append('<option value="">--Pilih Level 1--</option>');
        $('#COCODE_KIRIM').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv2Kirim(){
        $('select[name="PLANT_KIRIM"]').empty();
        $('select[name="PLANT_KIRIM"]').append('<option value="">--Pilih Level 2--</option>');
        $('#PLANT_KIRIM').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv3Kirim(){
        $('select[name="STORE_SLOC_KIRIM"]').empty();
        $('select[name="STORE_SLOC_KIRIM"]').append('<option value="">--Pilih Level 3--</option>');
        $('#STORE_SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv4Kirim(){
        $('select[name="SLOC_KIRIM"]').empty();
        $('select[name="SLOC_KIRIM"]').append('<option value="">--Pilih Pembangkit--</option>');
        $('#SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
    }     

    function setKomponenBIO(id, id_set){
        var v_url = '<?php echo base_url()?>data_transaksi/penerimaan/option_komponen_bio/'+id;
        $('select[name="JNS_BIO"]').empty();
        $('select[name="JNS_BIO"]').append('<option value="">--Pilih Komponen BIO--</option>');

        if (id=='003'){         
            $.ajax({
                url: v_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="JNS_BIO"]').append('<option value="'+ value.KODE_JNS_BHN_BKR +'">'+ value.NAMA_JNS_BHN_BKR +'</option>');
                    });

                    if (id_set){
                        $('#JNS_BIO').val(id_set);    
                    }
                    
                    $('select[name="JNS_BIO"]').data("placeholder","Select").trigger('liszt:updated');
                }
            });
        }

        if (id=='003'){
            $('#komponen_bio').show();    
        } else {
            $('#komponen_bio').hide();
        }     
    };   

    edit_data($("input[name=id]").val());
    function edit_data(id){                       
        var _url = '<?php echo base_url()?>data_transaksi/penerimaan/get_data_edit/'+id; 

        bootbox.hideAll();
        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'GET',
        url: _url,
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('Gagal proses get edit data');
            },
            success: function(data) {
                bootbox.hideAll();
                $('select[name="ID_PEMASOK"]').change();
                
                $.each(data, function () {                             
                    // $('#div_unit_kirim').hide('slow');
                    if (this.SLOC_KIRIM){
                        _rk = this.ID_REGIONAL_KIRIM;
                        _lv1k = this.COCODE_KIRIM;
                        _lv2k = this.PLANT_KIRIM;
                        _lv3k = this.STORE_SLOC_KIRIM;
                        _lv4k = this.SLOC_KIRIM;

                        // setLv1Kirim(_rk,_lv1k);
                        $('#COCODE_KIRIM').val(_lv1k);
                        setLv2Kirim(_lv1k,_lv2k);
                        setLv3Kirim(_lv2k,_lv3k);
                        setLv4Kirim(_lv3k,_lv4k);
                        $('#div_unit_kirim').show('slow');
                    }                    
                });      

                $("select").trigger("liszt:updated");
            }    
        })            
    }      

    function setLv1Kirim(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv1/'+stateID;        
        setDefaultLv1Kirim();
        setDefaultLv2Kirim();
        setDefaultLv3Kirim();
        setDefaultLv4Kirim();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 1) {
                            if (id_set==value.COCODE){
                                $('#COCODE_KIRIM').empty();
                                $('#COCODE_KIRIM').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');                                
                            }
                        } else {
                            $('#COCODE_KIRIM').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');    
                        }                        
                    });
                    $('#COCODE_KIRIM').val(id_set);
                    $('#COCODE_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };

    function setLv2Kirim(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv2/'+stateID;
        setDefaultLv2Kirim();
        setDefaultLv3Kirim();
        setDefaultLv4Kirim();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 2) {
                            if (id_set==value.PLANT){
                                $('#PLANT_KIRIM').empty();
                                $('#PLANT_KIRIM').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');                                
                            }
                        } else {
                            $('#PLANT_KIRIM').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');    
                        }
                    });
                    $('#PLANT_KIRIM').val(id_set);
                    $('#PLANT_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };    

    function setLv3Kirim(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv3/'+stateID;        
        setDefaultLv3Kirim();
        setDefaultLv4Kirim();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 3) {
                            if (id_set==value.STORE_SLOC){
                                $('#STORE_SLOC_KIRIM').empty();
                                $('#STORE_SLOC_KIRIM').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                            }
                        } else {
                            $('#STORE_SLOC_KIRIM').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');    
                        }
                    });
                    $('#STORE_SLOC_KIRIM').val(id_set);
                    $('#STORE_SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };  

    function setLv4Kirim(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv4/'+stateID;                
        setDefaultLv4Kirim();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 4) {
                            if (id_set==value.SLOC){
                                $('#SLOC_KIRIM').empty();
                                $('#SLOC_KIRIM').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                            }
                        } else {
                            $('#SLOC_KIRIM').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');    
                        } 
                    });   
                    $('#SLOC_KIRIM').val(id_set);
                    $('#SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                            
                    bootbox.hideAll();
                }
            });
        }
    };      

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv1/'+stateID;
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
                    $('select[name="COCODE"]').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="COCODE"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv2/'+stateID;
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
                    $('select[name="PLANT"]').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="PLANT"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv3/'+stateID;
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
                    $('select[name="STORE_SLOC"]').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv4/'+stateID;
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
                    $('select[name="SLOC"]').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    //kirim unit lain
    $('select[name="COCODE_KIRIM"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv2/'+stateID;
        setDefaultLv2Kirim();
        setDefaultLv3Kirim();
        setDefaultLv4Kirim();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT_KIRIM"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                    $('#PLANT_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="PLANT_KIRIM"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv3/'+stateID;
        setDefaultLv3Kirim();
        setDefaultLv4Kirim();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC_KIRIM"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');                        
                    });
                    $('#STORE_SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();                    
                }
            });
        }
    });

    $('select[name="STORE_SLOC_KIRIM"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv4/'+stateID;
        setDefaultLv4Kirim();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC_KIRIM"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                    $('#SLOC_KIRIM').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });     

    $('select[name="ID_PEMASOK"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_jns_penerimaan_byid/'+stateID;
        $('select[name="VALUE_SETTING"]').empty();
        $('select[name="VALUE_SETTING"]').append('<option value="">--Pilih Jenis Penerimaan--</option>');
        $('select[name="VALUE_SETTING"]').data("placeholder","Select").trigger('liszt:updated');
        $('#div_unit_kirim').hide('slow');
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $('select[name="VALUE_SETTING"]').empty();
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="VALUE_SETTING"]').append('<option value="'+ value.VALUE_SETTING +'">'+ value.NAME_SETTING +'</option>');
                    });
                    $('select[name="VALUE_SETTING"]').data("placeholder","Select").trigger('liszt:updated');

                    if (stateID=='00000000000000000010'){
                        $('#div_unit_kirim').show('slow');
                    }                    
                    bootbox.hideAll();
                }
            });
        }
    });

    if ($('input[name="id"]').val()){
        var sloc = $('#pembangkit').val();
        var jnsbbm = $('#jnsbbm').val();

        load_jenis_bbm_def('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm", jnsbbm);
        // $("#cbokomponen").change();

        // if ($('#JNS_BIO_EDIT').val()){
        //     $('#JNS_BIO').val($('#JNS_BIO_EDIT').val());
        // }

        if (jnsbbm=='003'){
            //val komponen bio dari jenis bbm bio
            setKomponenBIO(jnsbbm, $('#JNS_BIO_EDIT').val());
        }        
    } 

    setformfieldsize($('#NO_PENERIMAAN'), 60, '');
    $('#NO_PENERIMAAN').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 60){
            $('#MaxId').text('*Max 60');            
        } else {
            $('#MaxId').text('');
        }        
    });   

    setformfieldsize($('#KET_MUTASI_TERIMA'), 200, '');
    $('#KET_MUTASI_TERIMA').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });      

</script>



