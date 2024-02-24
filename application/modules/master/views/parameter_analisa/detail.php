<div class="well">
    <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'filter();')); ?>
    <?php echo anchor(null, '<i class="icon-plus"></i> Tambah', array('id' => '', 'class' => 'btn', 'onclick' => 'tambah_detail('.$id.');')); ?>
</div>
<div class="form_row">
    <div class="span6">
        <div class="well-content clearfix">
            <table class="table table-responsive table-striped table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%;">Nama Nilai</th>
                        <th style="width: 30%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach($list as $value) : ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $no++; ?></td>
                            <td><?php echo $value['NAMA_NILAI'] ?></td>

                            <td>
                                <?php $STATUS = ($value['STATUS'] == 1) ? 'PASSED' : 'NOT PASSED'; ?>
                                <?php echo $STATUS; ?>
                            </td>
                            <td style="text-align: center;">
                                <!-- <?php if ($this->laccess->otoritas('edit')) { ?>
                                <?php } ?> -->
                                <a href="#" class="btn transparant" onclick="edit_detail('<?php echo $value['ID_NILAI'] ?>')"><i class="icon-edit"></i></a>
                                <a href="#" class="btn transparant" onclick="row_delete_detail('<?php echo $value['ID_NILAI'] ?>','<?php echo $value['ID_PARAMETER'] ?>')"><i class="icon-power-off"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="span6">
        <div class="well-content clearfix" hidden id="content_edit">
            <div id="form_edit">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTable').DataTable({
            "order": [],
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "ordering": false,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
                'loadingRecords': '&nbsp;',
                "processing": "<div class='loading-progress' style='color:#ac193d;'></div>",
            },
        });
    })

    function edit_detail(id) {
        var datana = 'id='+id;
        $.ajax({
            url: "<?php echo base_url() ?>master/parameter_analisa/edit_detail",
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
                $('#content_edit').show();
                $('#form_edit').html(res);
            },
        });
    }

    function tambah_detail(id) {
        var datana = 'id='+id;
        $.ajax({
            url: "<?php echo base_url() ?>master/parameter_analisa/add_detail",
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
                $('#content_edit').show();
                $('#form_edit').html(res);
            },
        });
    }

    function row_delete_detail(id,id_param) {

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
                    
                    url: "<?php echo base_url() ?>master/parameter_analisa/delete_detail",
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
                            view_detail(id_param)
                            
                        })
                    },
                });
            }
            

           
        })
    }
    
</script>