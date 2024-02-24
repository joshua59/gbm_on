<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>  

<div class="modal-body">
    <div class="pull-right">
        <form action="<?=base_url()?>laporan/verifikasi_coq/export_excelpembangkit" method="POST" id="form-excelpembangkit">
            <input type="hidden" name="x_id" value="<?php echo $id ?>">
        </form>
        <form action="<?=base_url()?>laporan/verifikasi_coq/export_pdfpembangkit" method="POST" id="form-pdfpembangkit">
            <input type="hidden" name="p_id" value="<?php echo $id ?>">
        </form> 
        <button type="button" class="btn" id="btn-excelpembangkit"><i class="icon-download"></i>Download Excel</button>
        <button type="button" class="btn" id="btn-pdfpembangkit"><i class="icon-download"></i>Download PDF</button>
    </div>    
    <div class="box-content" id="divAtas">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'input', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        <div class="well-content">
            <div class="row">
                <div class="span6 offset4">
                    <div class="well-content no-search">
                        <div class="control-group">
                            <label for="password" class="control-label">User Input : </label>
                            <div class="controls">
                                <?php echo $NAMA_SURVEYOR; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label  class="control-label">Pemasok : </label>
                            <div class="controls">
                                <?php echo $form_data->NAMA_PEMASOK; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Depo : </label>
                            <div class="controls">
                                <?php echo $form_data->NAMA_DEPO; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Product : </label>
                            <div class="controls">
                                <?php echo $form_data->NAMA_BBM; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Report Number : </label>
                            <div class="controls">
                               <?php echo $form_data->NO_REPORT; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Tanggal Sampling : </label>
                            <div class="controls">
                               <?php echo $form_data->TGL_SAMPLING; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Tanggal COQ : </label>
                            <div class="controls">
                                <?php echo $form_data->TGL_COQ; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Shore Tank : </label>
                            <div class="controls">
                               <?php echo $form_data->SHORE_TANK; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Destinasi Pembangkit : </label>
                            <div class="controls">
                                <?php 
                                    $array = array();
                                    foreach ($pembangkit as $value) {
                                        array_push($array,$value['LEVEL4']);
                                    }
                                    echo implode(",",$array);
                                ?>
                            </div> 
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Keterangan : </label>
                            <div class="controls">
                                <?php echo $form_data->KET; ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Referensi Standar Mutu : </label>
                            <div class="controls">
                                <?php echo $ref->DITETAPKAN ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Nomor Referensi : </label>
                            <div class="controls">
                                <?php echo $ref->NO_VERSION ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Tanggal Referensi : </label>
                            <div class="controls">
                                <?php $tgl = date('d-m-Y', strtotime($ref->TGL_VERSION));
                                    echo $tgl; 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">Keterangan : </label>
                            <div class="controls">
                                <?php if($tipe == 1) { ?>
                                    <textarea class="form-control" style="width: 100%" name="USER_KET" id="USER_KET"></textarea>
                                <?php } else { ?>
                                    <?php echo $form_data->USER_KET ?>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        
        <?php echo form_close(); ?>
        <br>
        <h3 style="text-align: center;">Result COQ</h3>
            <div id="result-detail">
                <table class="display" id="tbl_result" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2" style="border : 1px solid #696969">No</th>
                            <th rowspan="2" style="border : 1px solid #696969">Parameter</th>
                            <th rowspan="2" style="border : 1px solid #696969">Satuan</th>
                            <th colspan="2" style="border : 1px solid #696969">Batasan SNI Minyak Solar</th>
                            <th rowspan="2" style="border : 1px solid #696969">Metode Uji (ASTM)</th>
                            <th rowspan="2" style="border : 1px solid #696969">Result</th>
                            <th rowspan="2" style="border : 1px solid #696969">Resume</th>
                        </tr>
                        <tr>
                            <th>Min</th>
                            <th>Max</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; $sec = 1; foreach ($list as $value) { ?>
                             <tr>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $no ; ?></td>
                                <td style="text-align: left;border : 1px solid #696969"><?php echo $value['PARAMETER_ANALISA'] ?></td>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $value['SATUAN'] ?></td>
                                <?php if ($value['BATAS_MIN'] == null) {
                                    $min = "-";
                                } else {
                                    $min = number_format($value['BATAS_MIN'],2,',','.');
                                } 

                                if ($value['BATAS_MAX'] == null) {
                                    $max = "-";
                                } else {
                                    $max = number_format($value['BATAS_MAX'],2,',','.');
                                } ?>

                                <?php $result = ($value['RESULT'] == '') ? '-' : $value['RESULT']; ?>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $min; ?></td>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $max; ?></td>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $value['METODE'] ?></td>
                                <td style="text-align: center;border : 1px solid #696969"><?php echo $result ?></td>
                                <td style="text-align: center;border : 1px solid #696969">
                                    <?php 
                                        if($value['RESUME'] == 0)
                                        {
                                            $warna = 'green';
                                            $status = 'PASSED';
                                        } else if($value['RESUME'] == 1){
                                            $warna = 'red';
                                            $status = 'NOT PASSED';
                                        } else {
                                            $warna = '';
                                            $status = '-';
                                        } ?>
                                        <?php if($warna == '') {
                                            $button = '-';
                                        } else { 
                                            $button = "<button type='button' class='btn' style='background-color: ".$warna.";color:white'>".$status."</button>";
                                        } 
                                        echo $button; 
                                    ?>
                                </td>
                            </tr>
                        <?php $no++; $sec++; } ?>
                    </tbody>
                </table>
            </div>
            <hr style="border-width: 3px;">
            <h3 style="text-align: center;">Pembangkit COQ</h3>
            <br>
            <div id="pembangkit-detail">
                <table class="display" id="tbl_pembangkit" style="width: 100%;border: 1px solid #696969;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2" style="border : 1px solid #696969">No</th>
                            <th colspan="4" style="border : 1px solid #696969">LEVEL</th>
                            <th rowspan="2" style="border : 1px solid #696969">Pembangkit</th>  
                        </tr>
                        <tr>
                            <th style="border : 1px solid #696969">Regional</th>
                            <th style="border : 1px solid #696969">1</th>   
                            <th style="border : 1px solid #696969">2</th>
                            <th style="border : 1px solid #696969">3</th>   
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;foreach($list2 as $data) : ?>
                            <tr>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $no++ ?></td>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['NAMA_REGIONAL'] ?></td>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL1'] ?></td>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL2'] ?></td>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL3'] ?></td>
                                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL4'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>  

    
    
<div class="modal-footer">
    <?php if($tipe == 1) { ?>
        <button class="blue btn" type="submit" id="btn-submit"><i class="icon-save"></i> Simpan</button>
    <?php } ?>
    <?php echo anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'green btn' ,'data-dismiss' => 'modal')); ?>
</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('#tbl_result').DataTable({
            bSort:false,
            searching:false
        })

        $('#tbl_pembangkit').DataTable({
            bSort:false,
            searching:false
        })

        $('#btn-excelpembangkit').click(function(){
            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#form-excelpembangkit').submit();
                }
            });
        })

        $('#btn-pdfpembangkit').click(function(){
            bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
                if(e) {
                    $('#form-pdfpembangkit').submit();
                }
            });
        })

    });

</script>