<div class="well-content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span>Data Rollback</span>
        </div>
    </div>
    <br>
    <div id="table" class="display">
        <table id="dataTable" class="display" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center" rowspan="2">NO</th>
                    <th style="text-align: center" colspan="4">LEVEL</th>
                    <th style="text-align: center" rowspan="2">PEMBANGKIT</th>
                    <th style="text-align: center" rowspan="2">JENIS TRANSAKSI</th>
                    <th style="text-align: center" rowspan="2">NOMOR TRANSAKSI</th>
                    <th style="text-align: center" rowspan="2">TANGGAL PENGAKUAN</th>
                    <th style="text-align: center" rowspan="2">JENIS BBM</th>
                    <th style="text-align: center" rowspan="2">ALASAN</th>
                    <th style="text-align: center" rowspan="2">CREATE MUTASI</th>
                    <th style="text-align: center" rowspan="2">TIME MUTASI</th>
                    <th style="text-align: center" rowspan="2">CREATE ROLLBACK</th>
                    <th style="text-align: center" rowspan="2">TIME ROLLBACK</th>
                </tr>
                <tr>
                    <th style="text-align: center">0</th>
                    <th style="text-align: center">1</th>
                    <th style="text-align: center">2</th>
                    <th style="text-align: center">3</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            // "scrollY": "450px",
            "searching": false,
            "scrollX": false,
            "scrollCollapse": false,
            "bPaginate": true,
            "ordering" : true,
            "bLengthChange": true,
            "bSearch" :true,
            "bFilter": false,
            "bInfo": true,
            "ordering" :false,
            "bAutoWidth": true,
            "fixedHeader": true,
            "language": {
              "decimal": ",",
              "thousands": ".",
              "emptyTable": "Tidak ada data untuk ditampilkan",
              "info": "Total Data: _MAX_",
              "infoEmpty": "Total Data: 0",
              "lengthMenu": "Jumlah Data _MENU_"
            },
            "columnDefs": [
                {
                    "className": "dt-left",
                    "targets": [1,2,3,4,5]
                },
                {
                  "className" : "dt-center",
                  "targets" : [6,7]
                },
                {
                  "className" : "dt-right",
                  "targets" : [8,9,10,11,12]
                }
              ]
        });
    })
</script>