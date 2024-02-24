<div class="col-md-12">
    <div class="well-content no-search">
        <div class="well">
            <div class="pull-left">
                <?php echo hgenerator::render_button_group($button_group); ?>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="well-content no-search">
        <?php echo form_open_multipart($form_action, array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lvl1options, !empty($default->COCODE) ? $default->COCODE : '', ' id="lvl1" class="chosen"'); ?>
                    </div>
                </div>

                <div class="pull-left span5">
                    <label for="password" class="control-label">Tahun RKAP <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SKEMA_PENYERAPAN', $skema_options, !empty($default->SKEMA_PENYERAPAN) ? $default->SKEMA_PENYERAPAN : '', 'class="span5 chosen" id="SKEMA_PENYERAPAN"'); ?>
                        <button class="btn" type="submit"><i class="icon-search"></i> Filter</button>
                        <button class="btn" type="button" onclick="loadTable();loadFilter()"><i class="icon-refresh"></i> Reload</button>
                    </div>
                </div>

                <div class="pull-left span4">
                    <label for="password" class="control-label"> <span class="required"></span> </label>
                    <div class="controls">
                        <button class="btn" type="button" onclick="download_excel()"><i class="icon-download"></i> Download Excel</button>
                        <button class="btn" type="button" onclick="download_pdf()"><i class="icon-download"></i> Download PDF</button>
                    </div>
                </div>
                    
            </div>
           <br/>
        <?php echo form_close(); ?>
    </div>
</div>
<form method="POST" action="<?php echo base_url() ?>master/penyerapan_bbm/export_excel" id="form-excel">
    <input type="hidden" name="ID_REGIONAL" id="lvl0excel">
    <input type="hidden" name="COCODE" id="lvl1excel">
    <input type="hidden" name="SKEMA_PENYERAPAN" id="skemaexcel">
</form>

<form method="POST" target="_blank" action="<?php echo base_url() ?>master/penyerapan_bbm/export_pdf" id="form-pdf">
    <input type="hidden" name="ID_REGIONAL" id="lvl0pdf">
    <input type="hidden" name="COCODE" id="lvl1pdf">
    <input type="hidden" name="SKEMA_PENYERAPAN" id="skemapdf">
</form>
<script type="text/javascript">

    $(document).ready(function(){
        
        $('#lvl0').change(function(){
            $('#lvl0excel').val($('#lvl0').val());
            $('#lvl0pdf').val($('#lvl0').val());
        });
        $('#lvl1').change(function(){
            $('#lvl1excel').val($('#lvl1').val());
            $('#lvl1pdf').val($('#lvl1').val());
        });
        $('#SKEMA_PENYERAPAN').change(function(){
            $('#skemaexcel').val($('#SKEMA_PENYERAPAN').val());
            $('#skemapdf').val($('#SKEMA_PENYERAPAN').val());
        })
        var d = new Date();
        var year = d.getFullYear();
        $('#skemaexcel').val(year);
        $('#skemapdf').val(year);
        $('#SKEMA_PENYERAPAN').val(year);
    })

    function download_excel() {

        $('#form-excel').submit();
    }

    function download_pdf() {
        $('#form-pdf').submit();
    }

    $("#ffilter").validate({
        ignore: ':hidden:not(select)',
        errorPlacement: function (error, element) {
            if (element.is(":hidden")) {
                element.next().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $.ajax({
              type: 'POST',
              url: $("#ffilter").attr('action'),
              data: $("#ffilter").serialize(),

              beforeSend:function(data){

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
              },
              error: function(data) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>-- Data Tidak Ditemukan --</div>', function() {});
              },

              success: function(data) { 
                bootbox.hideAll();
                $('#content_data').html(data)
              }
            })
        return false;
        }
    });       
    
</script>