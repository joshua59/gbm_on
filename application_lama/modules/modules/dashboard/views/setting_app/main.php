<div class="inner_content">
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
                        <div class="well-content clearfix">
                            <span><i class="icon-laptop"></i> Upload File</span>
                            <hr>
                            <div class="box-content">
                                <?php
                                $hidden_form = array('id' => !empty($id) ? $id : '');
                                echo form_open_multipart($form_action, array('id' => 'fupload', 'class' => 'form-horizontal'), $hidden_form);
                                    ?>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Kickoff Aplikasi : </label> 
                                        <div class="controls" id="up_file">
                                                <?php echo form_upload('PATH_KICKOFF', 'class="span6"'); ?>
                                                <?php echo form_hidden('PATH_KICKOFF_EDIT', !empty($default->PATH_KICKOFF) ? $default->PATH_KICKOFF : ''); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Pelatihan Aplikasi : </label> 
                                        <div class="controls" id="up_file">
                                                <?php echo form_upload('PATH_PELATIHAN', 'class="span6"'); ?>
                                                <?php echo form_hidden('PATH_PELATIHAN_EDIT', !empty($default->PATH_PELATIHAN) ? $default->PATH_PELATIHAN : ''); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Manual Book Aplikasi : </label> 
                                        <div class="controls" id="up_file">
                                                <?php echo form_upload('PATH_MANUAL_BOOK', 'class="span6"'); ?>
                                                <?php echo form_hidden('PATH_MANUAL_BOOK_EDIT', !empty($default->PATH_MANUAL_BOOK) ? $default->PATH_MANUAL_BOOK : ''); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">SOP Aplikasi : </label> 
                                        <div class="controls" id="up_file">
                                                <?php echo form_upload('PATH_SOP', 'class="span6"'); ?>
                                                <?php echo form_hidden('PATH_SOP_EDIT', !empty($default->PATH_SOP) ? $default->PATH_SOP : ''); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Template Data Cutoff : </label> 
                                        <div class="controls" id="up_file">
                                                <?php echo form_upload('PATH_CUTOFF', 'class="span6"'); ?>
                                                <?php echo form_hidden('PATH_CUTOFF_EDIT', !empty($default->PATH_CUTOFF) ? $default->PATH_CUTOFF : ''); ?>
                                        </div>
                                    </div>
                                    <br>           
                                    <div class="form-actions">
                                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_file(this.id, '#fupload', '#button-back')")); ?>
                                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Reset', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'reset(this.id)')); ?>

                                    </div>
                                    <?php
                                echo form_close(); ?>
                            </div>
                        </div>
                    </div> 

                    <div class="well">
                        <div class="well-content clearfix">
                            <span><i class="icon-laptop"></i> Download File</span>
                            <hr>
                            <div class="box-content">
                                <?php
                                echo form_open_multipart($form_action, array('id' => 'finput_download', 'class' => 'form-horizontal'), $hidden_form);
                                    ?>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label">Kickoff Aplikasi : </label> 
                                        <!-- dokumen -->
                                        <?php  
                                            if ($this->laccess->is_prod()){ ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_KICKOFF) ? $default->PATH_KICKOFF : '';?>"><b><?php echo (!empty($default->PATH_KICKOFF)) ? $default->PATH_KICKOFF : ''; ?></b></a>
                                                </div> 
                                        <?php } else { ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_KICKOFF;?>" target="_blank"><b><?php echo (!empty($default->PATH_KICKOFF)) ? $default->PATH_KICKOFF : ''; ?></b></a>
                                                </div>
                                        <?php } ?>
                                        <!-- end dokumen -->
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Pelatihan Aplikasi : </label> 
                                        <!-- dokumen -->
                                        <?php  
                                            if ($this->laccess->is_prod()){ ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_PELATIHAN) ? $default->PATH_PELATIHAN : '';?>"><b><?php echo (!empty($default->PATH_PELATIHAN)) ? $default->PATH_PELATIHAN : ''; ?></b></a>
                                                </div> 
                                        <?php } else { ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_PELATIHAN;?>" target="_blank"><b><?php echo (!empty($default->PATH_PELATIHAN)) ? $default->PATH_PELATIHAN : 'Lihat Dokumen'; ?></b></a>
                                                </div>
                                        <?php } ?>
                                        <!-- end dokumen -->
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Manual Book Aplikasi : </label> 
                                        <!-- dokumen -->
                                        <?php  
                                            if ($this->laccess->is_prod()){ ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_MANUAL_BOOK) ? $default->PATH_MANUAL_BOOK : '';?>"><b><?php echo (!empty($default->PATH_MANUAL_BOOK)) ? $default->PATH_MANUAL_BOOK : 'Lihat Dokumen'; ?></b></a>
                                                </div> 
                                        <?php } else { ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_MANUAL_BOOK;?>" target="_blank"><b><?php echo (!empty($default->PATH_MANUAL_BOOK)) ? $default->PATH_MANUAL_BOOK : 'Lihat Dokumen'; ?></b></a>
                                                </div>
                                        <?php } ?>
                                        <!-- end dokumen -->
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">SOP Aplikasi : </label> 
                                        <!-- dokumen -->
                                        <?php  
                                            if ($this->laccess->is_prod()){ ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_SOP) ? $default->PATH_SOP : '';?>"><b><?php echo (!empty($default->PATH_SOP)) ? $default->PATH_SOP : 'Lihat Dokumen'; ?></b></a>
                                                </div> 
                                        <?php } else { ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_SOP;?>" target="_blank"><b><?php echo (!empty($default->PATH_SOP)) ? $default->PATH_SOP : ''; ?></b></a>
                                                </div>
                                        <?php } ?>
                                        <!-- end dokumen -->
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label" class="control-label" id="up_nama">Template Data Cutoff : </label> 
                                        <!-- dokumen -->
                                        <?php  
                                            if ($this->laccess->is_prod()){ ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_CUTOFF) ? $default->PATH_CUTOFF : '';?>"><b><?php echo (!empty($default->PATH_CUTOFF)) ? $default->PATH_CUTOFF : 'Lihat Dokumen'; ?></b></a>
                                                </div> 
                                        <?php } else { ?>
                                                <div class="controls" id="dokumen">
                                                    <a href="<?php echo base_url().'assets/upload/permintaan/'.$default->PATH_CUTOFF;?>" target="_blank"><b><?php echo (!empty($default->PATH_CUTOFF)) ? $default->PATH_CUTOFF : ''; ?></b></a>
                                                </div>
                                        <?php } ?>
                                        <!-- end dokumen -->
                                    </div>
                                    <br>      
                                    <div class="form-actions">
                            
                                    </div>     
                                    <?php
                                echo form_close(); ?>
                            </div>
                        </div>
                    </div> 

                    <div class="well">
                        <div class="well-content clearfix">
                            <span><i class="icon-laptop"></i> FAQ</span>
                            <hr>

                            <div class="well">
                                <div class="pull-left">
                                    <?php echo hgenerator::render_button_group($button_group); ?>
                                </div>
                            </div>
                            <div class="well">
                                <div class="well-content clearfix">
                                    <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                    <table>
        								<tr>
        									<td colspan=2><label>Cari :</label>
        									</td>
        								</tr>
        								<tr>
        									<td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
        									<td> &nbsp </td>
        									<td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
        								</tr>
        							</table>
        						<?php echo form_close(); ?>
                                </div>
                            </div> 
                            <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                            <div>&nbsp;</div>

                        </div>
                    </div> 


                </div>
                <div id="form-content" class="modal fade modal-xlarge"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';

    jQuery(function($) {

        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
        });

    });

    function simpan_file() {
      var url = "<?php echo base_url() ?>dashboard/setting_app/proses";
      bootbox.confirm('Anda yakin akan upload file ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');

            $('#fupload').ajaxSubmit({
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
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
                    if (data[0]) {
                        // location.reload();
                        bootbox.modal('<div class="loading-progress"></div>');
                        window.location = window.location;
                    }                        
                  });
                }
            });
        }
      });
    }

    function reset(){
        bootbox.modal('<div class="loading-progress"></div>');
        window.location = window.location;
    }
</script>