<div class="well">
    <div class="pull-left">
        <?php echo hgenerator::render_button_group($button_group); ?>
    </div>
</div>

<div class="well-content clearfix">
    <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
    <div class="form_row">
        <div class="pull-left span3">
            <label for="password" class="control-label">Nama Parameter : </label>
            <div class="controls">
                <?php echo form_dropdown('parameter', $options_parameter, !empty($default->ID_PARAMETER) ? $default->ID_PARAMETER : '', 'id="parameter"'); ?>
            </div>
        </div>
        <div class="pull-left span3">
            <label for="password" class="control-label">Cari : </label>
            <div class="controls">
                <?php echo form_input('kata_kunci', '', 'class="input" autocomplete="off" id="kata_kunci"'); ?>
                <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
            </div>
        </div>
        <div class="pull-left span3">
            
           
        </div>
    </div>
    <br/>
    
<?php echo form_close(); ?>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#button-filter').click(function(){
            table_load();
        })
    })

    function edit(id) {
        var datana = 'id='+id;
            $.ajax({
                
                url: "<?php echo base_url() ?>master/parameter_analisa/edit",
                type: "POST",
                data: datana,
                beforeSend: function() {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    bootbox.hideAll();
                   alert('Proses pengambilan data gagal !')
                },
                success: function (res) {
                    bootbox.hideAll();
                    $('#content_table').hide();
                    $('#filter').html(res);
                },
            });
    }

    function view_detail(id) {
        var datana = 'id='+id;
            $.ajax({
                
                url: "<?php echo base_url() ?>master/parameter_analisa/view_detail",
                type: "POST",
                data: datana,
                beforeSend: function() {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    bootbox.hideAll();
                   alert('Proses pengambilan data gagal !')
                },
                success: function (res) {
                    bootbox.hideAll();
                    $('#content_table').hide();
                    $('#filter').html(res);
                },
            });
    }

    function row_delete(id) {

        var message = '';

        bootbox.setBtnClasses({
            CANCEL: '',
            CONFIRM: 'red'
        });
        var conf_message = 'Anda yakin akan menonaktifkan data?';
        bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
            if(e) {
                var datana = 'id='+id;
                $.ajax({
                    
                    url: "<?php echo base_url() ?>master/parameter_analisa/delete",
                    type: "POST",
                    data: datana,
                    beforeSend: function() {
                        bootbox.modal('<div class="loading-progress"></div>');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var icon = 'icon-remove-sign';
                        var color = '#ac193d;';
                        bootbox.alert('<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + 'Proses hapus data gagal !.' + '</div>', function() {
                            bootbox.hideAll();
                        })
                    },
                    success: function (res) {
                        var obj = JSON.parse(res);
                        bootbox.alert('<div class="box-title" style="color:#0072c6"><i class="icon-ok-sign"></i> ' + obj[2] + '</div>', function() {
                            bootbox.hideAll();
                            table_load();
                            
                        })
                    },
                });
            }
            

           
        })
    }
    
    function table_load(){
        
        $('#content_table').show();
        var parameter = $('#parameter').val();
        var cari      = $('#kata_kunci').val();
        var vlink_url = '<?php echo base_url()?>master/parameter_analisa/load/';
        $.ajax({
            url : vlink_url,
            type: 'POST',
            data: {
                p_idparam : parameter,
                p_cari : cari
            },
            beforeSend:function(response) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#table_content').html(response);
            }
        });
    }

    $('#button-excel').click(function(){
        // var jnsbbm   = $('#bbm').val();
        // var ref1     = $('#DITETAPKAN').val();
        // var ref2     = $('#NO_VERSION').val();
        // var tgl      = $('#PERIODE').val();
        // var tglakhir = $('#PERIODE_AKHIR').val();
        // var cari     = $('#kata_kunci').val();
        // var nama_bbm = $('#bbm option:selected').text();

        // $('input[name="x_jnsbbm"]').val(jnsbbm);
        // $('input[name="x_ref_lv1"]').val(ref1);
        // $('input[name="x_ref_lv2"]').val(ref2);
        // $('input[name="x_tgl"]').val(tgl);
        // $('input[name="x_tglakhir"]').val(tglakhir);
        // $('input[name="x_cari"]').val(cari);
        // $('input[name="x_namabbm"]').val(nama_bbm);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_excel').submit();
            }
        });
    })

    $('#button-pdf').click(function(){
        // var jnsbbm   = $('#bbm').val();
        // var ref1     = $('#DITETAPKAN').val();
        // var ref2     = $('#NO_VERSION').val();
        // var tgl      = $('#PERIODE').val();
        // var tglakhir = $('#PERIODE_AKHIR').val();
        // var cari     = $('#kata_kunci').val();
        // var nama_bbm = $('#bbm option:selected').text();

        // $('input[name="pdf_jnsbbm"]').val(jnsbbm);
        // $('input[name="pdf_ref_lv1"]').val(ref1);
        // $('input[name="pdf_ref_lv2"]').val(ref2);
        // $('input[name="pdf_tgl"]').val(tgl);
        // $('input[name="pdf_tglakhir"]').val(tglakhir);
        // $('input[name="pdf_cari"]').val(cari);
        // $('input[name="pdf_namabbm"]').val(nama_bbm);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e) {
                $('#export_pdf').submit();
            }
        });
    })
</script>