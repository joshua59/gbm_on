<?php
/**
 * Created by PhpStorm.
 * User: cf
 * Date: 10/20/17
 * Time: 12:59 AM
 */
?>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
</div>
<div class="widgets_area" id="index-content">
    <div class="row-fluid" <?php if($page_notif) echo 'hidden'; ?>>
        <div class="span12">
            <div id="index-content1" class="well-content no-search">
                <div class="well">
                    <div class="pull-left">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <div class="content_table">
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
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;", id="bln"'); ?>
                                    <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Order by :</label>
                                <label for="password" class="control-label" style="margin-left:95px"></label>
                                <div class="controls">
                                    <?php echo form_dropdown('ORDER_BY', $options_order, '','style="width: 137px;", id="order"'); ?>
                                    <?php echo form_dropdown('ORDER_ASC', $options_asc, 'DESC','style="width: 80px;", id="asc"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label"><span class="required"></span></label>
                                <div class="controls">
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                </div>
                            </div>
                            <!-- <div class="pull-left span5">
                                <div class="controls">
                                    <table>
                                        <tr>
                                            <td colspan=2><label>Kata Kunci</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php echo form_input('kata_kunci', '', 'class="input-large"'); ?></td> 
                                            <td> &nbsp </td> 
                                            <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                        <br>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <br>

                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                <div id="divTable"></div>
                <hr>
                
                <div id="table_detail" hidden>
                    <form method="POST" id="formKirimDetail">
                        <div class="well-content clearfix">

                            <div class="form_row">
                                <div class="pull-left span8">
                                    <div class="controls">
                                        <table>
                                           <tr>
                                              <td><label>Total data</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="TOTAL"></info>
                                                 </label>
                                              </td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                           </tr>
                                           <tr>
                                              <td><label>Belum Kirim</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="BELUM_KIRIM"></info>
                                                 </label>
                                              </td>
                                              <td></td>
                                              <td><label>Disetujui</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="DISETUJUI"></info>
                                                 </label>
                                              </td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td><label>Closing</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="CLOSING"></info>
                                                 </label>
                                              </td>
                                              <td></td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td><label>Closing Disetujui</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="CLOSING_DISETUJUI"></info>
                                                 </label>
                                              </td>
                                           </tr>
                                           <tr>
                                              <td><label>Belum Disetujui</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="BELUM_DISETUJUI"></info>
                                                 </label>
                                              </td>
                                              <td></td>
                                              <td><label>Ditolak</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="DITOLAK"></info>
                                                 </label>
                                              </td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td><label>Closing blm Disetujui</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="CLOSING_BELUM_DISETUJUI"></info>
                                                 </label>
                                              </td>
                                              <td></td>
                                              <td><?php echo str_repeat("&nbsp;", 10); ?></td>
                                              <td><label>Closing Ditolak</label></td>
                                              <td><label>:</label></td>
                                              <td>
                                                 <label>
                                                    <info id="CLOSING_DITOLAK"></info>
                                                 </label>
                                              </td>
                                           </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form_row">
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Order by :</label>
                                    <label for="password" class="control-label" style="margin-left:95px"></label>
                                    <div class="controls">
                                        <?php echo form_dropdown('ORDER_BY_D', $options_order_d, '','style="width: 137px;", id="order_d"'); ?>
                                        <?php echo form_dropdown('ORDER_ASC_D', $options_asc_d, '','style="width: 80px;", id="asc_d"'); ?>
                                    </div>
                                </div>
                                <div class="pull-left span3">
                                    <label for="password" class="control-label">Filter Status : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('CMB_STATUS', $status_options, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : '', 'class="span15"'); ?>
                                    </div>
                                    <input type="hidden" name="vBLTH">
                                    <input type="hidden" name="vSLOC">
                                    <input type="hidden" name="vAKTIF">
                                </div>

                                <!-- <div class="pull-left span3">
                                    <label for="password" class="control-label"><span class="required"></span></label>
                                    <div class="controls">
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                    </div>
                                </div> -->

                                <div class="pull-left span4">
                                    <label for="password" class="control-label">Cari :</label>
                                    <div class="controls">
                                        <?php echo form_input('kata_kunci_detail', '', 'class="input-large"'); ?>
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter-detail')); ?>
                                    </div>
                                </div>

                                <div class="pull-right">
                                    <div class="controls">
                                        <table>
                                            <tr><td>&nbsp</td></tr>
                                            <tr>
                                                <td>
                                                    <?php if (($this->laccess->otoritas('add') == true) && ($this->session->userdata('level_user') >= "2")) {?>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailKirim(this)" id="btn_kirim">Kirim</button>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailKirimClossing(this)" id="btn_kirim_cls">Kirim Closing</button>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php if (($this->laccess->otoritas('approve') == true) && ($this->session->userdata('level_user') == "2")) {?>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailApprove(this)" id="btn_approve">Approve</button>
                                                            <button class="btn btn-primary" type="button" onclick="saveDetailApproveClossing(this)" id="btn_approve_cls">Approve Closing</button>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="content">
                            <table class="table table-bordered table-striped table-hover " id="detailPenerimaan">
                                <thead>
                                <tr>
                                    <th>NO PENERIMAAN</th>
                                    <th>TGL PENGAKUAN</th>
                                    <th>NAMA PEMASOK</th>
                                    <th>NAMA TRANSPORTIR</th>
                                    <th>NAMA JNS BHN BKR</th>
                                    <th>VOLUME DO/TUG/BA (L)</th>
                                    <th>VOLUME PENERIMAAN (L)</th>
                                    <th>CREATED BY</th>
                                    <th>CREATED TIME</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                    <th>CHECK</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </form>
                </div>
                
            </div>
            <!-- <div id="form-content" class="well-content"></div> -->
        </div>
    </div>
    
    <div class="row-fluid" <?php if(!$page_notif) echo 'hidden'; ?>>
        <div class="span12">
            <div id="index-content2" class="well-content no-search">
                <div class="content_table">
                    <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
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
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 137px;", id="bln"'); ?>
                                    <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 80px;", id="thn"'); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form_row">
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Cari :</label>
                                <div class="controls">
                                    <?php echo form_hidden('NF_STATUS', !empty($page_notif_status) ? $page_notif_status : ''); ?>

                                    <?php echo form_input('kata_kunci_rekap', '', 'class="input-large"'); ?>
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter2')); ?>
                                </div>
                            </div>
                            <div class="pull-left span3" style="display: none;">
                                <label for="password" class="control-label">Order by :</label>
                                <label for="password" class="control-label" style="margin-left:95px"></label>
                                <div class="controls">
                                    <?php echo form_dropdown('ORDER_BY_REKAP', $options_order_d, '','style="width: 137px;", id="order"'); ?>
                                    <?php echo form_dropdown('ORDER_ASC_REKAP', $options_asc, '','style="width: 80px;", id="asc"'); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <br>
                <form method="POST" id="formKirimRekap">
                  <div class="well-content clearfix">
                    <div class="pull-right">
                        <div class="controls">
                            <table>
                                <tr>
                                    <td>
                                        <?php if (($this->laccess->otoritas('add') == true) && ($this->session->userdata('level_user') >= "2")) {

                                              if ($page_notif_status==0){
                                                echo '<button class="btn btn-primary" type="button" onclick="saveDetailKirimRekap(this)" id="btn_kirim_rkp">Kirim</button>';
                                                echo '<input type="checkbox" id="checkAll"> Check All';
                                              }
                                              if ($page_notif_status==4){
                                                echo '<button class="btn btn-primary" type="button" onclick="saveDetailKirimClossingRekap(this)" id="btn_kirim_rkp_cls">Kirim Closing</button>';
                                                echo '<input type="checkbox" id="checkAll"> Check All';
                                              }
                                          ?>
                                                
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if (($this->laccess->otoritas('approve') == true) && ($this->session->userdata('level_user') == "2")) {

                                              if ($page_notif_status==1){
                                                echo '<button class="btn btn-primary" type="button" onclick="saveDetailApproveRekap(this)" id="btn_approve_rkp">Approve</button>';
                                                echo '<input type="checkbox" id="checkAll"> Check All';
                                              }
                                              if ($page_notif_status==5){
                                                echo '<button class="btn btn-primary" type="button" onclick="saveDetailApproveClossingRekap(this)" id="btn_approve_rkp_cls">Approve Closing</button>';
                                                echo '<input type="checkbox" id="checkAll"> Check All';
                                              }
                                          ?>                                              
                                        <?php }?>
                                    </td>
                                    <td>
                                      
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> 
                  </div>

                  <div id="content_table2" data-source="<?php echo $data_sources_rekap; ?>" data-filter="#ffilter2"></div>
                </form>
            </div>
        </div>
    </div>
</div><br><br>

<div id="form-content" class="well-content"></div>


<script type="text/javascript">
    var icon = 'icon-remove-sign';
	  var color = '#ac193d;';
    var offset = -100;
    var today = new Date();
    var year = today.getFullYear();  
    var vnotif = '<?php echo $page_notif; ?>';

    if (vnotif){
      $('select[name="TAHUN"]').prepend('<option value="">--Pilih--</option>');
      $('select[name="TAHUN"]').val(''); 
    } else {
      $('select[name="TAHUN"]').val(year); 
    }

    jQuery(function ($) {
        if (!vnotif){
          load_table('#content_table', 1, '#ffilter');
        }
        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');
            $('#detailPenerimaan tbody tr').detach();
            $('#table_detail').hide();
        });

        if (vnotif){
          load_table('#content_table2', 1, '#ffilter2');
        }
        $('#button-filter2').click(function () {
            load_table('#content_table2', 1, '#ffilter2');
        });
        // ('#checkAll').prop('checked', false);
        $('#checkAll').attr('checked', false);
        // $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
    }); 

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    
    function toRupiah(angka){
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

    function pageScroll() {
        window.scrollBy(0,100); 
        if(window.pageYOffset == offset) return;
        offset = window.pageYOffset;
        scrolldelay = setTimeout('pageScroll()',100); 
    }

    function show_detail(tanggal) {
        if (!$('#table_detail').is(":visible")) {
            bootbox.modal('<div class="loading-progress"></div>');

            var vId = tanggal;
            var strArray = vId.split("|");
            var tr = document.getElementById(strArray[2]);
            var tds = tr.getElementsByTagName("td");

            for(var i = 0; i < tds.length; i++) {
              tds[i].style.backgroundColor ="#E0E6F8";
            }

            $('input[name="vBLTH"]').val(strArray[0]);
            $('input[name="vSLOC"]').val(strArray[1]);
            $('input[name="vAKTIF"]').val(strArray[2]);

            if (strArray.length ==3){
                var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";
                var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";

                if (vLevelUser==2){
                    if (vIsAdd){
                        $('select[name="CMB_STATUS"]').val('0');
                    } else {
                        $('select[name="CMB_STATUS"]').val('1');    
                    }
                    
                } else if (vLevelUser>2){
                    $('select[name="CMB_STATUS"]').val('0');
                } else {
                    $('select[name="CMB_STATUS"]').val(''); 
                }

                $('input[name="kata_kunci_detail"]').val('');
                $('select[name="ORDER_BY_D"]').val('TGL_PENGAKUAN');
                 
                get_sum_detail(tanggal); 
                setTombolClossing(0); 
            }

            var data_kirim = {ID_REGIONAL: $('select[name="ID_REGIONAL"]').val(),
                COCODE: $('select[name="COCODE"]').val(),
                PLANT: $('select[name="PLANT"]').val(),
                STORE_SLOC: $('select[name="STORE_SLOC"]').val(),
                SLOC: strArray[1],
                TGL_PENGAKUAN:strArray[0],
                BULAN: $('select[name="BULAN"]').val(),
                TAHUN: $('select[name="TAHUN"]').val(),
                STATUS: $('select[name="CMB_STATUS"]').val(),
                KATA_KUNCI_DETAIL: $('input[name="kata_kunci_detail"]').val(),
                ORDER_BY_D: $('select[name="ORDER_BY_D"]').val(),
                ORDER_ASC_D: $('select[name="ORDER_ASC_D"]').val(),
            };

            $.post("<?php echo base_url()?>data_transaksi/penerimaan/getDataDetail/", data_kirim, function (data){
                var data_detail = (JSON.parse(data));
                var cekbox = '';
                var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";
                var vUserName = "<?php echo $this->session->userdata('user_name'); ?>";
                var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";
                var vIsApprove = "<?php echo $this->laccess->otoritas('approve'); ?>";
                var vSetEdit='';
                var vEdit='';
                var vEditView='';
                var vlink_url = '';
                var vCmbStatus = $('select[name="CMB_STATUS"]').val();

                for (i = 0; i < data_detail.length; i++) {

                    cekbox = '<input type="checkbox" name="pilihan[' + i + ']" id="pilihan" value="'+data_detail[i].ID_PENERIMAAN+'">';
                    vlink_url = "<?php echo base_url()?>data_transaksi/penerimaan/edit_view/"+data_detail[i].ID_PENERIMAAN;
                    vEditView = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PENERIMAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-file-alt" title="Lihat Data"></i></a>'; 

                    vlink_url = "<?php echo base_url()?>data_transaksi/penerimaan/tolak_view/"+data_detail[i].ID_PENERIMAAN;
                    vTolakView = '<a href="javascript:void(0);" class="btn transparant" id="button-tolak-'+data_detail[i].ID_PENERIMAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-remove" title="Tolak Data"></i></a>';

                    vlink_url = "<?php echo base_url()?>data_transaksi/penerimaan/tolak_view_closing/"+data_detail[i].ID_PENERIMAAN;
                    vTolakViewClosing = '<a href="javascript:void(0);" class="btn transparant" id="button-tolakcls-'+data_detail[i].ID_PENERIMAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-remove" title="Tolak Data Closing"></i></a>';                    

                    // if (data_detail[i].SLOC_KIRIM){
                    //   vlink_url = "<?php echo base_url()?>data_transaksi/penerimaan/edit_unitlain/"+data_detail[i].ID_PENERIMAAN;
                    //   vEdit = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PENERIMAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-edit" title="Edit Data (Unit Lain)"></i></a>'; 
                    // } else {
                      vlink_url = "<?php echo base_url()?>data_transaksi/penerimaan/edit/"+data_detail[i].ID_PENERIMAAN;
                      vEdit = '<a href="javascript:void(0);" class="btn transparant" id="button-edit-'+data_detail[i].ID_PENERIMAAN+'" onclick="load_form(this.id)" data-source="'+vlink_url+'"> <i class="icon-edit" title="Edit Data"></i></a>';                       
                    // }
                    

                    vSetEdit = vEditView;

                    if (vLevelUser>=2){
                        if (vLevelUser==2){
                            if (vIsAdd){
                                if((data_detail[i].KODE_STATUS == "1") || (data_detail[i].KODE_STATUS == "2") || (data_detail[i].KODE_STATUS == "3")){
                                    cekbox = '';  
                                } else {
                                    if(data_detail[i].CREATED_BY==vUserName){
                                        vSetEdit = vEdit;     
                                    } else if(data_detail[i].SLOC_KIRIM){
                                        vSetEdit = vEdit;     
                                    }    
                                }  
                                if(data_detail[i].SLOC_KIRIM==''){
                                    if(data_detail[i].CREATED_BY!=vUserName){
                                             cekbox = '';   
                                    }
                                }

                            }

                            if (vIsApprove){
                                if (data_detail[i].KODE_STATUS == "1"){
                                    vSetEdit = vSetEdit+vTolakView;
                                }
                                if (data_detail[i].KODE_STATUS == "5"){
                                    vSetEdit = vSetEdit+vTolakViewClosing;
                                }
                                if ((data_detail[i].KODE_STATUS !== "1") && (data_detail[i].KODE_STATUS !== "5")){
                                    cekbox = '';
                                }  
                                if (data_detail[i].KODE_STATUS == "0"){
                                    vSetEdit = '';
                                }    
                                if (data_detail[i].KODE_STATUS == "5"){
                                    if (vCmbStatus != "5"){
                                        cekbox = '';
                                    }
                                }                              
                            }
                        }

                        if ((vLevelUser==3) || (vLevelUser==4)){
                            if ((data_detail[i].KODE_STATUS !== "0") && (data_detail[i].KODE_STATUS !== "4")){
                                cekbox = '';
                            } 
                            if ((data_detail[i].KODE_STATUS == "0") || (data_detail[i].KODE_STATUS == "4")){
                                if(data_detail[i].CREATED_BY==vUserName){
                                        vSetEdit = vEdit;     
                                    }
                            }
                            if (data_detail[i].KODE_STATUS == "4"){
                                if (vCmbStatus != "4"){
                                    cekbox = '';
                                }
                            } 
                            if(data_detail[i].CREATED_BY!=vUserName){
                                     cekbox = '';   
                            } 
                        }
                    } else {
                       cekbox = ''; 
                    }

                    $('#detailPenerimaan tbody').append(
                        '<tr>' +
                        '<td align="center">' + data_detail[i].NO_PENERIMAAN + '</td>' +
                        '<td align="center">' + data_detail[i].TGL_PENGAKUAN + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_PEMASOK + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_TRANSPORTIR + '</td>' +
                        '<td align="center">' + data_detail[i].NAMA_JNS_BHN_BKR + '</td>' +
                        '<td align="right">' + toRupiah(data_detail[i].VOL_TERIMA) + '</td>' +
                        '<td align="right">' + toRupiah(data_detail[i].VOL_TERIMA_REAL) + '</td>' +
                        '<td align="center">' + data_detail[i].CREATED_BY + '</td>' +
                        '<td align="center">' + data_detail[i].CREATED_DATE + '</td>' +
                        '<td align="center">' + data_detail[i].STATUS + '</td>' +
                        '<td align="center">' + vSetEdit +' </td>' +
                        '<td align="center">' +
                        cekbox+
                        '<input type="hidden" id="idPenerimaan" name="idPenerimaan[' + i + ']" value="' + data_detail[i].ID_PENERIMAAN + '">' +
                        '<input type="hidden" id="status" name="status[' + i + ']" value="' + data_detail[i].STATUS + '">' +
                        '<input type="hidden" id="idSLOC" name="idSLOC[' + i + ']" value="' + data_detail[i].SLOC + '">' +
                        '</td>' +
                        '</tr>'
                    );
                }
                
                bootbox.hideAll();
                $('#table_detail').show();
                // pageScroll();
                $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);                
            });

        } else {
            $('#detailPenerimaan tbody tr').detach();
            $('#table_detail').hide();
            $('td').removeAttr('style');
        }
    }

    function cekChekBoxPilih(vJenis){
        var data = $('#formKirimDetail').serializeArray();
        var arrNames = [];
        Object.keys(data).forEach(function(key) {
          var val = data[key]["name"];
          arrNames.push(val);
        }); 

        var vAda=1;
        for (var i=0; i < arrNames.length ; ++i) {
            var str = arrNames[i];
            var res =  str.substr(0, 7);

            if (res=='pilihan'){
                vAda = 0;
            }
        }

        if (vAda){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Silahkan pilih data yang akan di '+vJenis+'</div>';
            bootbox.alert(message, function() {});
        }

        return vAda;
    }

    function cekChekBoxPilihRekap(vJenis){
        var data = $('#formKirimRekap').serializeArray();
        var arrNames = [];
        Object.keys(data).forEach(function(key) {
          var val = data[key]["name"];
          arrNames.push(val);
        }); 

        var vAda=1;
        for (var i=0; i < arrNames.length ; ++i) {
            var str = arrNames[i];
            var res =  str.substr(0, 7);

            if (res=='pilihan'){
                vAda = 0;
            }
        }

        if (vAda){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Silahkan pilih data yang akan di '+vJenis+'</div>';
            bootbox.alert(message, function() {});
        }

        return vAda;
    }

    function saveDetailKirim(obj) {
      if (cekChekBoxPilih('kirim')){return;}
  		bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
  			if(e){
  				bootbox.modal('<div class="loading-progress"></div>');
  				var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/kirim";
  				$.ajax({
  					type: "POST",
  					url: url,
  					data: $('#formKirimDetail').serializeArray(),
  					dataType:"json",
  					success: function (data) {
  						$(".bootbox").modal("hide");
  						var message = '';
  						var content_id = data[3];
  						if (data[0]) {
  							icon = 'icon-ok-sign';
  							color = '#0072c6;';
  						}
  						message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
  						message += data[2];
  						bootbox.alert(message, function() {
                location.reload();
  							// load_table("#content_table", 1);
  							// $('#detailPenerimaan tbody tr').detach();
  							// $('#table_detail').hide();
  						});
  					}
  				});
  			}
  		});
    }

    function saveDetailKirimRekap(obj) {
      if (cekChekBoxPilihRekap('kirim')){return;}
      bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');
          var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/kirim";
          $.ajax({
            type: "POST",
            url: url,
            data: $('#formKirimRekap').serializeArray(),
            dataType:"json",
            success: function (data) {
              $(".bootbox").modal("hide");
              var message = '';
              var content_id = data[3];
              if (data[0]) {
                icon = 'icon-ok-sign';
                color = '#0072c6;';
              }
              message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
              message += data[2];
              bootbox.alert(message, function() {
                // load_table("#content_table2", 1);
                location.reload(); 
              });
            }
          });
        }
      });
    }

    function saveDetailKirimClossing(obj) {
      if (cekChekBoxPilih('kirim')){return;}
      bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
          if(e){
              bootbox.modal('<div class="loading-progress"></div>');
              var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/kirim";
              $.ajax({
                  type: "POST",
                  url: url,
                  data: $('#formKirimDetail').serializeArray(),
                  dataType:"json",
                  success: function (data) {
                      $(".bootbox").modal("hide");
                      var message = '';
                      var content_id = data[3];
                      if (data[0]) {
                          icon = 'icon-ok-sign';
                          color = '#0072c6;';
                      }
                      message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                      message += data[2];
                      bootbox.alert(message, function() {
                        location.reload();
                        // load_table("#content_table", 1);
                        // $('#detailPenerimaan tbody tr').detach();
                        // $('#table_detail').hide();
                      });
                  }
              });
          }
      });  
    }

    function saveDetailKirimClossingRekap(obj) {
      if (cekChekBoxPilihRekap('kirim')){return;}
      bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
          if(e){
              bootbox.modal('<div class="loading-progress"></div>');
              var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/kirim";
              $.ajax({
                  type: "POST",
                  url: url,
                  data: $('#formKirimRekap').serializeArray(),
                  dataType:"json",
                  success: function (data) {
                      $(".bootbox").modal("hide");
                      var message = '';
                      var content_id = data[3];
                      if (data[0]) {
                          icon = 'icon-ok-sign';
                          color = '#0072c6;';
                      }
                      message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                      message += data[2];
                      bootbox.alert(message, function() {
                          // load_table("#content_table2", 1);
                          location.reload();
                      });
                  }
              });
          }
      });  
    }

    function saveDetailApprove(obj) {
      if (cekChekBoxPilih('approve')){return;}
  		bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
  			if(e){
  				bootbox.modal('<div class="loading-progress"></div>');
  				var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/approve";
  				$.ajax({
  					type: "POST",
  					url: url,
  					data: $('#formKirimDetail').serializeArray(),
  					dataType:"json",
  					success: function (data) {
  						$(".bootbox").modal("hide");
  						var message = '';
  						var content_id = data[3];
  						if (data[0]) {
  							icon = 'icon-ok-sign';
  							color = '#0072c6;';
  						}
  						message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
  						message += data[2];
  						bootbox.alert(message, function() {
                location.reload();
  							// load_table("#content_table", 1);
  							// $('#detailPenerimaan tbody tr').detach();
  							// $('#table_detail').hide();
  						});
  					}
  				});
  			}
  		});
    }

    function saveDetailApproveRekap(obj) {
      if (cekChekBoxPilihRekap('approve')){return;}
      bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');
          var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/approve";
          $.ajax({
            type: "POST",
            url: url,
            data: $('#formKirimRekap').serializeArray(),
            dataType:"json",
            success: function (data) {
              $(".bootbox").modal("hide");
              var message = '';
              var content_id = data[3];
              if (data[0]) {
                icon = 'icon-ok-sign';
                color = '#0072c6;';
              }
              message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
              message += data[2];
              bootbox.alert(message, function() {
                location.reload();
              });
            }
          });
        }
      });
    }

    function saveDetailApproveClossing(obj) {
        if (cekChekBoxPilih('approve')){return;}
        bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('#formKirimDetail').serializeArray(),
                    dataType:"json",
                    success: function (data) {
                        $(".bootbox").modal("hide");
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];
                        bootbox.alert(message, function() {
                          location.reload();
                          // load_table("#content_table", 1);
                          // $('#detailPenerimaan tbody tr').detach();
                          // $('#table_detail').hide();
                        });
                    }
                });
            }
        });
    }

    function saveDetailApproveClossingRekap(obj) {
        if (cekChekBoxPilihRekap('approve')){return;}
        bootbox.confirm('Yakin data ini akan di Setujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('#formKirimRekap').serializeArray(),
                    dataType:"json",
                    success: function (data) {
                        $(".bootbox").modal("hide");
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];
                        bootbox.alert(message, function() {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
    
    function saveDetailTolak(obj) {
      if (cekChekBoxPilih('tolak')){return;}
		  bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
			 if(e){
				var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/tolak";
				bootbox.modal('<div class="loading-progress"></div>');
				$.ajax({
					type: "POST",
					url: url,
					data: $('#formKirimDetail').serializeArray(),
					dataType:"json",
					success: function (data) {
						$(".bootbox").modal("hide");
						var message = '';
						var content_id = data[3];
						if (data[0]) {
							icon = 'icon-ok-sign';
							color = '#0072c6;';
						}
						message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
						message += data[2];
						bootbox.alert(message, function() {
              location.reload();
							// load_table("#content_table", 1);
							// $('#detailPenerimaan tbody tr').detach();
							// $('#table_detail').hide();
						});
					}
				});
			 }
		  });
    }

    function saveDetailTolakRekap(obj) {
      if (cekChekBoxPilihRekap('tolak')){return;}
      bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
       if(e){
        var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKiriman/tolak";
        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
          type: "POST",
          url: url,
          data: $('#formKirimRekap').serializeArray(),
          dataType:"json",
          success: function (data) {
            $(".bootbox").modal("hide");
            var message = '';
            var content_id = data[3];
            if (data[0]) {
              icon = 'icon-ok-sign';
              color = '#0072c6;';
            }
            message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
            message += data[2];
            bootbox.alert(message, function() {
              location.reload();
              // load_table("#content_table", 1);
              // $('#detailPenerimaan tbody tr').detach();
              // $('#table_detail').hide();
            });
          }
        });
       }
      });
    }

    function saveDetailTolakClossing(obj) {
      if (cekChekBoxPilih('tolak')){return;}
      bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
        if(e){
          var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/tolak";
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
            type: "POST",
            url: url,
            data: $('#formKirimDetail').serializeArray(),
            dataType:"json",
            success: function (data) {
              $(".bootbox").modal("hide");
              var message = '';
              var content_id = data[3];
              if (data[0]) {
                icon = 'icon-ok-sign';
                color = '#0072c6;';
              }
              message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
              message += data[2];
              bootbox.alert(message, function() {
                location.reload();
                // load_table("#content_table", 1);
                // $('#detailPenerimaan tbody tr').detach();
                // $('#table_detail').hide();
              });
            }
          });
        }
      });
    }

    function saveDetailTolakClossingRekap(obj) {
      if (cekChekBoxPilihRekap('tolak')){return;}
      bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
        if(e){
          var url = "<?php echo base_url() ?>data_transaksi/penerimaan/saveKirimanClossing/tolak";
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
            type: "POST",
            url: url,
            data: $('#formKirimRekap').serializeArray(),
            dataType:"json",
            success: function (data) {
              $(".bootbox").modal("hide");
              var message = '';
              var content_id = data[3];
              if (data[0]) {
                icon = 'icon-ok-sign';
                color = '#0072c6;';
              }
              message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
              message += data[2];
              bootbox.alert(message, function() {
                location.reload();
              });
            }
          });
        }
      });
    }

    $('#button-add').click(function(e) {
        $('#detailPenerimaan tbody tr').detach();
        $('#table_detail').hide();
    });

    $('#button-filter-detail').click(function(e) {
        $('select[name="CMB_STATUS"]').change();
    });

    function setDefaultLv1(){
        $('#lvl1').empty();
        $('#lvl1').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('#lvl2').empty();
        $('#lvl2').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3(){
        $('#lvl3').empty();
        $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4(){
        $('#lvl4').empty();
        $('#lvl4').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('#lvl0').on('change', function() {
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
                      $('#lvl1').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#lvl1').on('change', function() {
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
                      $('#lvl2').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#lvl2').on('change', function() {
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
                      $('#lvl3').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#lvl3').on('change', function() {
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
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    function get_sum_detail(tanggal) {
        var vId = tanggal;
        var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";
        var vRoles = "<?php echo $this->session->userdata('roles_id'); ?>";
        var strArray = vId.split("|");
        var data = {SLOC: strArray[1],TGL_PENGAKUAN:strArray[0]};

        $.post("<?php echo base_url()?>data_transaksi/penerimaan/get_sum_detail/", data, function (data) {
            var data_detail = (JSON.parse(data));

            for (i = 0; i < data_detail.length; i++) {
                $('#TOTAL').html(formatNumber(data_detail[i].TOTAL));
                $('#BELUM_KIRIM').html(formatNumber(data_detail[i].BELUM_KIRIM));
                $('#CLOSING').html(formatNumber(data_detail[i].CLOSING));

                if (!vIsAdd){
                    if ((vRoles!='001') && (vRoles!='20') && (vRoles!='34') && (vRoles!='26')){
                        $('#TOTAL').html(formatNumber(data_detail[i].TOTAL - data_detail[i].BELUM_KIRIM - data_detail[i].CLOSING));
                        $('#BELUM_KIRIM').html(formatNumber(0));  
                        $('#CLOSING').html(formatNumber(0));  
                    }                                          
                } 
                
                $('#BELUM_DISETUJUI').html(formatNumber(data_detail[i].BELUM_DISETUJUI));
                $('#DISETUJUI').html(formatNumber(data_detail[i].DISETUJUI));
                $('#DITOLAK').html(formatNumber(data_detail[i].DITOLAK));

                $('#CLOSING_BELUM_DISETUJUI').html(formatNumber(data_detail[i].CLOSING_BELUM_DISETUJUI));
                $('#CLOSING_DISETUJUI').html(formatNumber(data_detail[i].CLOSING_DISETUJUI));
                $('#CLOSING_DITOLAK').html(formatNumber(data_detail[i].CLOSING_DITOLAK));
            }
        });
    }

    $('select[name="CMB_STATUS"]').on('change', function() {
        var vBLTH = $('input[name="vBLTH"]').val();
        var vSLOC = $('input[name="vSLOC"]').val();
        var vAKTIF = $('input[name="vAKTIF"]').val();
        var vSTATUS = $(this).val();
        var vParam = vBLTH+'|'+vSLOC+'|'+vAKTIF+'|'+vSTATUS;

        setTombolClossing(vSTATUS);   

        show_detail(vParam);
        show_detail(vParam);
    });  

    function setTombolClossing(stat){
        var vIsApprove = "<?php echo $this->laccess->otoritas('approve'); ?>";
        var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";

        $("#formKirimRekap").hide(); 

        if (vIsApprove){
            $("#btn_approve").show(); 
            $("#btn_approve_cls").hide(); 
            $("#btn_tolak").show(); 
            $("#btn_tolak_cls").hide(); 
        } 
        if (vIsAdd){
            $("#btn_kirim").show(); 
            $("#btn_kirim_cls").hide();  
        }    

        if (stat==4){
            if (vIsAdd){
                $("#btn_kirim").hide(); 
                $("#btn_kirim_cls").show();  
            }            
        } else if (stat==5){
             if (vIsApprove){
                $("#btn_approve").hide(); 
                $("#btn_approve_cls").show(); 
                $("#btn_tolak").hide(); 
                $("#btn_tolak_cls").show();  
            }            
        }

        $("#formKirimRekap").show();
    }

</script>