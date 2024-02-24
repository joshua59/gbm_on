
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
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Transportir<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" id="pembangkit"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('VALUE_SETTING', $option_jenis_penerimaan, !empty($default->JNS_PENERIMAAN) ? $default->JNS_PENERIMAAN : '', 'class="span3"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_PENERIMAAN', !empty($default->NO_MUTASI_TERIMA) ? $default->NO_MUTASI_TERIMA : '', 'class="span6" placeholder="Ketik Nomor Penerimaan"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm"'); ?>
                </div>
            </div>
            
            <div class="control-group" id="komponen" style="<?php echo !empty($default->IS_MIX_BBM) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('KOMPONEN', $option_komponen, !empty($default->ID_KOMPONEN_BBM) ? $default->ID_KOMPONEN_BBM : '', 'class="span3" id="cbokomponen" '); ?>
                    <input type="hidden" id="ismix" name="ismix" value="<?php echo !empty($default->IS_MIX_BBM) ? $default->IS_MIX_BBM : '' ;?>" />
                </div>
            </div>

            <div class="control-group" id="komponen_bio" style="<?php echo !empty($default->JNS_BIO) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BIO <span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('JNS_BIO', $option_komponen_bio, !empty($default->JNS_BIO) ? $default->JNS_BIO : '', 'class="span3" id="JNS_BIO" '); ?>
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
                          'style'       => '"none" placeholder="Ketik Keterangan Penerimaan"'
                        );
                      echo form_textarea($data);
                    ?>
                </div>
            </div>
            <div class="form-actions">
                <?php 
                if ($this->laccess->otoritas('edit')) {
                    echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_file(this.id, '#finput', '#button-back');"));
                }
                    echo anchor(null, '<i class="icon-refresh"></i> Reset', array('id' => 'button-reset', 'class' => 'green btn', 'onclick' => "set_reset(this.id);"));
                ?>
            </div>
            <?php
        echo form_close(); ?>
    </div>