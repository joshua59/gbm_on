
<!-- /**
	* @module STOCK OPNAME
	* @author  RAKHMAT WIJAYANTO
	* @created at 17 OKTOBER 2017
	* @modified at 17 OKTOBER 2017
*/ -->

<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
	</div>
    <div class="box-content">
        <?php
			$hidden_form = array('id' => !empty($id) ? $id : '');
			echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
		?>
		<!--perhitungan Start -->
		<div class="control-group">
			<br>
			<label for="password" class="control-label">No Stok Opname <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('NO_STOCKOPNAME', !empty($default->NO_STOCKOPNAME) ? $default->NO_STOCKOPNAME : '', 'class="span6", disabled="true"'); ?>
			</div>
			<br>
			<label for="password" class="control-label">Tanggal BA Stock Opname <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('TGL_BA_STOCKOPNAME', !empty($default->TGL_BA_STOCKOPNAME) ? $default->TGL_BA_STOCKOPNAME : '', 'class="span2 input-append date form_datetime", id="datepicker", disabled="true"'); ?>
			</div>
			<br>
			<label for="password" class="control-label">Tanggal Pengakuan <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span2 input-append date form_datetime", disabled="true"'); ?>
			</div>
			<br>
			<label  class="control-label">Regional <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '','disabled="true", class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 1<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '','disabled="true", class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 2<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '','disabled="true", class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Level 3<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '','disabled="true", class="span6"'); ?>
			</div>
			<br>
			<label  class="control-label">Pembangkit<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '','disabled="true", class="span6"'); ?>
			</div>
		</div>                          
		<div class="control-group">
			<br>
			<label for="password" class="control-label">Pilih Jenis Bahan Bakar <span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $parent_options_jns, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3", disabled="true"'); ?> 
			</div>
			<br>
			<label for="password" class="control-label">Volume Stock Opname (L)<span class="required">*</span> : </label>
			<div class="controls">
                <?php echo form_input('VOLUME_STOCKOPNAME', !empty($default->VOLUME_STOCKOPNAME) ? $default->VOLUME_STOCKOPNAME : '', 'class="span3", disabled="true"'); ?>
			</div>
			
		</div>
		<div style="display:none">
			<input type="text" id="setuju" name="setuju">
			<?php echo anchor(null, '<i class="icon-check"></i> ok', array('id' => 'button-ok', 'class' => 'red btn', 
			'value' => 'tolak','onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
		</div> 
		<div class="md-card-content">
        <!-- dokumen -->
        <?php  
            if ($this->laccess->is_prod()){ ?>
                <div class="controls" id="dokumen">
                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="SO" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                </div> 
        <?php } else { ?>
                <div class="controls" id="dokumen">
                    <a href="<?php echo base_url().'assets/upload/stockopname/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                </div>
        <?php } ?>
        <!-- end dokumen -->

             <div id="divTolak" hidden>
                <hr>
                <div class="control-group">
                    <label class="control-label">Keterangan Tolak<span class="required">*</span> : </label>
                    <div class="controls">
                        <!-- <?php //echo form_input('KET_BATAL', !empty($default->KET_BATAL) ? $default->KET_BATAL : '', 'class="span6" placeholder="Keterangan Tolak Permintaan" '); ?> -->
                        <?php
                            $data = array(
                              'name'        => 'KET_BATAL',
                              'id'          => 'KET_BATAL',
                              'value'       => !empty($default->KET_BATAL) ? $default->KET_BATAL : '',
                              'rows'        => '4',
                              'cols'        => '10',
                              'class'       => 'span6',
                              'style'       => '"none" placeholder="Ketik Keterangan Tolak Stock Opname"'
                            );
                          echo form_textarea($data);
                        ?>
                        <?php echo form_hidden('STATUS_TOLAK', !empty($default->STATUS_TOLAK) ? $default->STATUS_TOLAK : '', 'class="span1" placeholder="Status Tolak Permintaan" '); ?>
                    </div>
                </div>
            </div>  

			<div class="form-actions">
			<br>
			<?php
                $status= $default->STATUS_APPROVE_STOCKOPNAME;
                $level=$this->session->userdata('level_user');
                // if(($status==1)&&($level==2)){
                if((($status==1)||($status==5))&&($level==2)){
					if($this->laccess->otoritas('approve')){
				?>
				<?php echo anchor(null, '<i class="icon-check"></i> Setujui', array('id' => 'button-approve', 'class' => 'blue btn',
				'value' => 'setuju', 'onclick' => "simpan_datax(this.id, '#finput', '#button-back')")); ?>
				
				<button type="button" class="btn red" data-toggle="modal" data-target="#ModalTolak"><i class="icon-check"></i> Tolak</button>
                
				<?php }}?>
				
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
			</div>
            <!-- perhitungan End -->
			<?php echo form_close(); ?>
		</div>
	</div>

<!-- <?php //echo anchor(null, '<i class="icon-check"></i> Tolak', array('id' => 'button-tolak', 'class' => 'red btn','value' => 'tolak','onclick' => "simpan_datax(this.id, '#finput', '#button-back')")); ?> -->

	

	<!-- Modal -->
	<div class="modal fade" id="ModalTolak" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">

		  <!-- Modal content-->
		  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Keterangan Tolak Stock Opname</h4>
		    </div>
		    <div class="modal-body">
		      
                <div class="control-group">
                    <!-- <label class="control-label">Keterangan Tolak<span class="required">*</span> : </label> -->
                    <div class="controls">
                        <?php
                            $data = array(
                              'name'        => 'KET_BATAL_MODAL',
                              'id'          => 'KET_BATAL_MODAL',
                              'value'       => '',
                              'rows'        => '4',
                              'cols'        => '10',
                              'class'       => 'span6',
                              'style'       => '"none" placeholder="Ketik Keterangan Tolak Stock Opname"'
                            );
                          echo form_textarea($data);
                        ?>
                    </div>
                </div>

		    </div>
		    <div class="modal-footer">
		      <button type="button" class="btn blue" id="btn_save_tolak"><i class="icon-save"></i> Simpan</button>	
		      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-circle-arrow-left"></i> Tutup</button>
		    </div>
		  </div>
		  
		</div>
	</div><br><br>
	
	<script type="text/javascript">
		$(".form_datetime").datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayBtn: true,
			pickerPosition: "bottom-left"
		});
		
		$('input[name=VOLUME_STOCKOPNAME]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
		});
		
		$("#button-approve").click(function() {
			$('#setuju').val('2');
			$( "#button-ok" ).click();
		});
		
		$("#button-tolak").click(function() {
			$('#setuju').val('3');
			$( "#button-ok" ).click();
		});

		$("#btn_save_tolak").click(function() {
			$('#KET_BATAL').val($('#KET_BATAL_MODAL').val());
			if ($('#KET_BATAL').val()!='') {
				$('#ModalTolak').modal('toggle');
			}
			$('#setuju').val('3');
			$( "#button-ok" ).click();
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
				$('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
			}
			
			$('select[name="ID_REGIONAL"]').on('change', function() {
				var stateID = $(this).val();
				var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv1/'+stateID;
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
				var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv2/'+stateID;
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
				var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv3/'+stateID;
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
				var vlink_url = '<?php echo base_url()?>data_transaksi/stock_opname/get_options_lv4/'+stateID;
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
		});
	</script>           	