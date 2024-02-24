
 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span8">
                <div id ="index-content" class="well-content no-search">
                    <div class="well">
                        <!-- <div class="pull-left span2">
                            <?php echo hgenerator::render_button_group($button_add); ?>
                        </div>
                        <div class="pull-left span1">
                            <?php echo hgenerator::render_button_group($button_upload); ?>
                        </div> -->
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                        <br>
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                <div class="form_row">
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Tanggal Awal : </label>
                                        <div class="controls">
                                            <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                                        </div>

                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Tanggal Akhir : </label>
                                        <div class="controls">
                                            <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                                        </div>
                                    </div>
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Status Hitung : </label>
                                        <div class="controls">
                                            <select style="width: 130px;" id="STATUS" name="STATUS">
                                                <option value="">--Pilih Status--</option>
                                                <option value="0">Belum Hitung</option>
                                                <option value="1">Sudah Hitung</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <div class="controls">
                                                <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <div class="controls">
                                                <?php echo anchor(NULL, "<i class='icon-download'></i> Export Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <div class="controls">
                                                <?php echo anchor(NULL, "<i class='icon-download'></i> Export PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                                <br>
                            <?php echo form_close(); ?>
                         </div>    
                    <!-- </div>  -->

                    <hr>
                    <!-- <div id="content_table" data-source="<?php echo $data_sources ?>"> -->
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                        
                    </div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="modal fade modal-small"></div>
            </div>
        </div>
    </div>

</div>
<form action="<?=base_url()?>data_transaksi/mops/export_pdf" method="POST" id="form-pdf">
    <input type="hidden" name="STATUS" id="value1">
    <input type="hidden" name="TGL_DARI" id="value2">
    <input type="hidden" name="TGL_SAMPAI" id="value3">
</form>

<form action="<?=base_url()?>data_transaksi/mops/export_excel" method="POST" id="form-excel">
    <input type="hidden" name="STATUS" id="value4">
    <input type="hidden" name="TGL_DARI" id="value5">
    <input type="hidden" name="TGL_SAMPAI" id="value6">
</form>
<script type="text/javascript">

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    load_table('#content_table', 1, '#ffilter');

    $('#button-filter').click(function() {
        load_table('#content_table', 1, '#ffilter');
    });

    $('#button-excel').click(function() {
        export_excel();
    });

    $('#button-pdf').click(function() {
        export_pdf();
    });


    function load_add(){
        $('#content_table').load('<?php echo base_url()?>data_transaksi/mops/add/');
    }

    function load_upload(){
        $('#content_table').load('<?=base_url()?>data_transaksi/mops/upload/');
    }

    function export_excel() {
        var tglawal = $('#tglawal').val()
        var tglakhir = $('#tglakhir').val()
        var STATUS = $('#STATUS').val()
        $('#value4').val(STATUS);
        $('#value5').val(tglawal);
        $('#value6').val(tglakhir);
        $('#form-excel').submit();

    }

    function export_pdf() {
    
        var tglawal = $('#tglawal').val()
        var tglakhir = $('#tglakhir').val()
        var STATUS = $('#STATUS').val()
        $('#value1').val(STATUS);
        $('#value2').val(tglawal);
        $('#value3').val(tglakhir);

        $('#form-pdf').submit();
    }

    function proses(){ 
        var tgl = $('#tgl').val()
        var bln = $('#bln').val()
        var thn = $('#thn').val()
        var datana = 'tgl='+tgl+'&bln='+bln+'&thn='+thn;
        var urlna="<?=base_url()?>data_transaksi/mops/proses_data";
        $.ajax({
            type: 'POST',
            url: urlna,
            data: datana,
            
            error: function(data) {
                alert('Proses data gagal');
            },
            success: function(data) {
                $('#content_table').html(data);
            }    
        })
        return false;
    }

    function hapus(){ 
        document.getElementById("ID_MOPS").deleteTHead();
    }       

</script>
