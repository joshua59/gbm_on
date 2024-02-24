
<!-- /**
 * @module PERHITUNGAN HARGA
 * @author  CF
 * @created at 11 JULI 2018
 * @modified at 11 JULI 2018
 */ -->

<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/css/cf/font-awesome.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    #modal_pencarian{
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
    
</style>

 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content no-search">
                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>
                    <div class="well">
                        <!-- <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                <div class="form_row">
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Bulan : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_dropdown('bln', $opsi_bulan, '','style="width: 145px;", id="bln"'); ?>
                                        </div>
                                        </div>
                                    </div>
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Tahun : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_dropdown('thn', $opsi_tahun, '','style="width: 145px;", id="thn"'); ?>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">                                            
                                             <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                        </div>
                                    </div>

                                </div>
                                <br>
                            <?php echo form_close(); ?>
                        </div>  -->


                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Regional : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
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
                                <div class="pull-left span5">
                                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;", id="bln"'); ?>
                                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                    </div> 
                </div>
            </div>
        </div>
        <br><br>

        <div id="divPertamina">  
            <div class="box-title">
                DETAIL HARGA BBM (FOB)
            </div>
            <div style="float: left;width: 48%">      
                <div id="listDataPertamina" class="table-responsive"></div>
            </div> 

            <div style="float: right;width: 48%">      
                <div id="listMopsPertamina" class="table-responsive"></div> 
                <br><br><br>
            </div>    
        </div>

        <div id="divAkrKpm" hidden>  
            <div class="box-title">
                DETAIL HARGA BBM (CIF)
            </div>
            <div style="float: left;width: 65%"> 
                <div id="listDataAkrKpm" class="table-responsive"></div>
            </div>

            <div style="float: right;width: 34%"> 
                <div id="listMopsAkrKpm" class="table-responsive"></div> 
                <br><br><br>
            </div>
        </div>


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
            <div class="well">
                <div class="well-content clearfix">
                    <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
                        <div class="form_row">
                           <div class="pull-left">
                                <label for="password" class="control-label">Kata Kunci : </label>
                                <div class="controls">                                            
                                    <input type="text" name="kata_kunci" class="control-label">
                                </div>
                                
                            </div>
                            <div class="pull-left span2">
                                <label for="password" class="control-label"></label>
                                <div class="controls">
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
        </div>
      </div>
      
    </div>
  </div>


<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';    
    var stat = 'FOB';

    function load_pertamina(){
        // bootbox.alert('Silahkan pilih Periode Perhitungan Harga FOB', function() {
            stat = 'FOB';
            // bootbox.modal('<div class="loading-progress"></div>');
            $('#divAkrKpm').hide();
            $('#divPertamina').show();
            // bootbox.hideAll();
        // });
        get_hitung_harga();
    }

    function load_akr_kpm(){
        // bootbox.alert('Silahkan pilih Periode Perhitungan Harga CIF', function() {
            stat = 'CIF';
            // bootbox.modal('<div class="loading-progress"></div>');
            $('#divPertamina').hide();
            $('#divAkrKpm').show();
            // bootbox.hideAll();
        // });
        // load_table('#content_table2', 1, '#ffilter2');
        get_hitung_harga_akr_kpm();
    }

    function setDefaultTgl(){
        var d = new Date();
        var month = d.getMonth()+1;
        var year = d.getFullYear();

        month = (month<10 ? '0' : '')+month;

        $('#bln').val(month);     
        $('#thn').val(year);
    }

    function pilih_kontrak(vid){
        $('#modal_pencarian').modal('toggle');
    }

    function get_mops_kurs(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_mops_kurs_pertamina_edit/";
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
                    $('#listMopsPertamina').html(data);
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

    function get_mops_kurs_akr_kpm(id,pembangkit,nopjbbbm,jns_kurs,kurs,mops){ 
        var data_kirim = 'vidtrans='+id+'&pembangkit='+pembangkit+'&nopjbbbm='+nopjbbbm;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_mops_kurs_akr_kpm_edit/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    $('#listMopsAkrKpm').empty();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#listMopsAkrKpm').html(data);

                    if (jns_kurs=='1'){
                        $('#lb_kurs').html('KTBI :'); 
                        $('#lb_kurs_det').html('KTBI (Rp)'); 
                    } else {
                        $('#lb_kurs').html('JISDOR :');
                        $('#lb_kurs_det').html('JISDOR (Rp)');
                    }
                    $('#kurs').val(kurs);
                    $('#mops').val(mops);
                    
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

    function get_hitung_harga(){ 
        var vperiode = $('#thn').val()+''+$('#bln').val();
        var data_kirim = {periode: vperiode};
        var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_hitung_harga_pertamina_edit/";

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
                    $('#listDataPertamina').html(data[4]);
                        get_mops_kurs(data[5]);
                } else {
                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                    message += data[2];

                    bootbox.alert(message, function() {
                        $('#listDataPertamina').empty();
                        $('#listMopsPertamina').empty();
                    });


                }
            }    
        })
    }

    function get_hitung_harga_akr_kpm(){ 
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();        
        var thn = $('#thn').val();
        var vperiode = $('#thn').val()+''+$('#bln').val();
        var cari = $('#kata_kunci').val();

        var data_kirim = {"ID_REGIONAL": lvl0,"COCODE":lvl1, "PLANT":lvl2, "STORE_SLOC":lvl3,
                            "SLOC":lvl4, "BULAN":bln, "TAHUN": thn, "periode":vperiode, "cari":cari};

        var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_hitung_harga_edit/";

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
                    $('#listDataAkrKpm').html(data[4]);
                    $('html, body').animate({scrollTop: $("#divAkrKpm").offset().top}, 1000);
                        // get_mops_kurs(data[5]);
                } else {
                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                    message += data[2];

                    bootbox.alert(message, function() {
                        $('#listDataAkrKpm').empty();
                        $('#listMopsAkrKpm').empty();
                    });


                }
            }    
        })
    }


    setDefaultTgl();

    $('#btnCari').click(function () {
        $('#modal_pencarian').modal('show');
    });

    $('#button-filter').click(function() {
        if (stat == 'FOB'){
            get_hitung_harga();
        } else {
            get_hitung_harga_akr_kpm();
        }
    });

    load_table('#content_table2', 1, '#ffilter2');
    $('#button-filter2').click(function() {
        load_table('#content_table2', 1, '#ffilter2');
    });

    $('#modal_pencarian').modal('show');
    $('#modal_pencarian').modal('hide');

</script>

<script type="text/javascript">

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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_bbm/get_options_lv4/'+stateID;
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
