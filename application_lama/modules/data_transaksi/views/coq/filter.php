<div id="index-content" class="well-content no-search">
    <div class="well">
        <div class="pull-left">
            <?php echo hgenerator::render_button_group($button_group); ?>
        </div>
    </div>
    <div class="content_table">
        <div class="well-content clearfix">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <br>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Pemasok : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_PEMASOK', $options_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'id="ID_PEMASOK"'); ?>
                    </div>
                </div>

                <div class="pull-left span3">
                    <label for="password" class="control-label">Depo : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_DEPO', $options_depo, !empty($default->ID_DEPO) ? $default->ID_DEPO : '', 'id="ID_DEPO"'); ?>
                    </div>
                </div>

                <div class="pull-left span3">
                    
                </div>
                
            </div>
            <div class="form_row">
                <div class="span3">
                    <label for="password" class="control-label">Status : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_DEPO', $options_status, !empty($default->VALUE_SETTING) ? $default->VALUE_SETTING : '', 'id="VALUE_SETTING"'); ?>
                    </div>
                </div>

                <div class="span3">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Cari : </label>
                        <div class="controls">
                            <?php echo form_input('kata_kunci', '', 'class="input-large" autocomplete="off" id="kata_kunci" placeholder="Cari Data..."'); ?>
                        </div>
                    </div>
                </div>
               
                <div class="pull-left span5">
                    <br>
                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                    <?php echo anchor(NULL, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <br>
    
    
    <div>&nbsp;</div>
</div>
<br/>

<form action="<?php echo base_url()?>data_transaksi/coq/export_excel" id="export_excel" method="POST">
    <input type="hidden" name="xpemasok">
    <input type="hidden" name="xdepo">
    <input type="hidden" name="xstatus">
    <input type="hidden" name="xcari">
</form>

<form action="<?php echo base_url()?>data_transaksi/coq/export_pdf" id="export_pdf" method="POST">
    <input type="hidden" name="ppemasok">
    <input type="hidden" name="pdepo">
    <input type="hidden" name="pstatus">
    <input type="hidden" name="pcari">
</form>
<script type="text/javascript">

    setDefaultDepo();

    $('#button-add').click(function() {
        $('#con').hide();
        add();
    });

    $('#button-filter').click(function() {
        $('#stat').val('');

	load_table();
    });

    $('#ID_PEMASOK').on('change', function() {
        setDefaultDepo();
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/get_options_depo/'+stateID;
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#ID_DEPO').append('<option value="'+ value.ID_DEPO +'">'+ value.NAMA_DEPO +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });


    $('#button-excel').click(function(){
        var id_pemasok = $('#ID_PEMASOK').val();
        var id_depo    = $('#ID_DEPO').val();
        var cari       = $('#kata_kunci').val();
        var status     = $('#VALUE_SETTING').val();

        $('input[name="xpemasok"]').val(id_pemasok);
        $('input[name="xdepo"]').val(id_depo);
        $('input[name="xstatus"]').val(status);
        $('input[name="xcari"]').val(cari);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_excel').submit();
            }
        });
         
    })

    $('#button-pdf').click(function(){
        
        var id_pemasok = $('#ID_PEMASOK').val();
        var id_depo    = $('#ID_DEPO').val();
        var cari       = $('#kata_kunci').val();
        var status     = $('#VALUE_SETTING').val();
       
        $('input[name="ppemasok"]').val(id_pemasok);
        $('input[name="pdepo"]').val(id_depo);
        $('input[name="pstatus"]').val(status);
        $('input[name="pcari"]').val(cari);

        bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_pdf').submit();
            }
        });
         
    })

    function setDefaultDepo(){
        $('#ID_DEPO').empty();
        $('#ID_DEPO').append('<option value="">--Pilih Depo--</option>');
    }

    function add() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/add';
        $.ajax({
            url: vlink_url,
            type: "POST",
            beforeSend:function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
                alert('Data Gagal Proses');
            },
            success:function(data) {
                $('#content_data').html(data);
                bootbox.hideAll();
            }
        });
    }

   


</script>