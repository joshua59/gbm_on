<table class="table table-responsive" style="max-height:1000px;width:100%" id="dataTable">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th colspan="4">Level</th>
            <th rowspan="2">Unit Pembangkit</th>
            <th colspan="4">Kontrak Transportir</th>
            <th colspan="5">Kapasitas Tangki Per Jenis Bahan Bakar (L)</th>
            <th rowspan="2">Total Kapasitas (L)</th>
            <th rowspan="2">Latitude</th>
            <th rowspan="2">Longtitude</th>
            <th rowspan="2">Status</th>
        </tr>
        <tr>
            <th style="width: 200px;">Regional</th>
            <th style="width: 200px;">Level 1</th>
            <th style="width: 200px;">Level 2</th>
            <th style="width: 200px;">Level 3</th>
            <th>Transportir</th>
            <th>Depo</th>
            <th>Jalur</th>
            <th>Ongkos Angkut (Rp)</th>
            <th>HSD</th>
            <th>MFO</th>
            <th>BIO</th>
            <th>HSD+BIO</th>
            <th>IDO</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data as $key => $value) : ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $value['NAMA_REGIONAL'] ?></td>
                <td><?php echo $value['LEVEL1'] ?></td>
                <td><?php echo $value['LEVEL2'] ?></td>
                <td><?php echo $value['LEVEL3'] ?></td>
                <td><?php echo $value['LEVEL4'] ?></td>
                <td><?php echo $value['NAMA_TRANSPORTIR'] ?></td>
                <td><?php echo $value['NAMA_DEPO'] ?></td>
                <td><?php echo $value['JALUR'] ?></td>
                <td style="text-align: right;"><?php echo $value['HARGA_KONTRAK_TRANS'] ?></td>
                <td style="text-align: right;"><?php echo number_format($value['HSD'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo number_format($value['MFO'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo number_format($value['BIO'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo number_format($value['HSDBIO'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo number_format($value['IDO'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo number_format($value['TOTAL_KAPASITAS'], 0, ",", ".") ?></td>
                <td style="text-align: right;"><?php echo $value['LAT'] ?></td>
                <td style="text-align: right;"><?php echo $value['LOT'] ?></td>
                <td style="text-align: center;"><?php echo ($value['STATUS'] == '0') ? 'Tidak Aktif' : 'Aktif'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $('#dataTable').DataTable({
        "order": [],
        "scrollY": "450px",
        "scrollX": true,
        "scrollCollapse": false,
        "bPaginate": true,
        "searching":false,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "fixedColumns": {"leftColumns": 6},
        "bAutoWidth": true,
        "ordering": false,
        "language": {
            "decimal": ",",
            "thousands": ".",
            "emptyTable": "Tidak ada data untuk ditampilkan",
            "lengthMenu": "Jumlah Data _MENU_",
            "processing": "<div class='loading-progress' style='color:#ac193d;'></div>"
        }
    });


    // function MergeGridCells() {
    //     var dimension_cells = new Array();
    //     var dimension_col = null;
    //     var columnCount = $("#dataTable tr:first th").length;
    //     for (dimension_col = 0; dimension_col < columnCount; dimension_col++) {
    //         // first_instance holds the first instance of identical td
    //         var first_instance = null;
    //         var rowspan = 1;
    //         // iterate through rows
    //         $("#dataTable").find('tr').each(function() {

    //             // find the td of the correct column (determined by the dimension_col set above)
    //             var dimension_td = $(this).find('td:nth-child(' + dimension_col + ')');

    //             if (first_instance == null) {
    //                 // must be the first row
    //                 first_instance = dimension_td;
    //             } else if (dimension_td.text() == first_instance.text()) {
    //                 // the current td is identical to the previous
    //                 // remove the current td
    //                 dimension_td.remove();
    //                 ++rowspan;
    //                 // increment the rowspan attribute of the first instance
    //                 first_instance.attr('rowspan', rowspan);
    //             } else {
    //                 // this cell is different from the last
    //                 first_instance = dimension_td;
    //                 rowspan = 1;
    //             }
    //         });
    //     }
    // }
</script>