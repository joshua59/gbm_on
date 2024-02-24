<table class="table table-responsive table-striped table-bordered" id="dataTable" width="100%">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 50%;">Nama Parameter</th>
            <th style="width: 10%;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;foreach($list as $value) : ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td><?php echo $value['PARAMETER_ANALISA'] ?></td>
                <td style="text-align: center;">
                    <?php if ($this->laccess->otoritas('edit')) { ?>
                        <a href="#" class="btn transparant" onclick="edit('<?php echo $value['ID_PARAMETER'] ?>')"><i class="icon-edit"></i></a>
                    <?php } ?>
                    <?php if($value['TIPE'] == 2) { ?>
                        <a href="#" class="btn transparant" onclick="view_detail('<?php echo $value['ID_PARAMETER'] ?>')"><i class="icon-search"></i></a>
                    <?php } ?>
                    <?php if ($this->laccess->otoritas('delete')) { ?>
                         <a href="#" class="btn transparant" onclick="row_delete('<?php echo $value['ID_PARAMETER'] ?>')"><i class="icon-power-off"></i></a>
                    <?php } ?>
                   
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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

    
</script>