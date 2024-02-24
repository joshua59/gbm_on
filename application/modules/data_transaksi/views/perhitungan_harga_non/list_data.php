<div class="box-title">
    Data MOPS dan Kurs
</div>
<table id="dataTable" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>MID HSD <br/> (USD/brl) </th>
			<th>MID MFO<br/> (USD/MT) </th>
			<th>KTBI (JISDOR) <br/> (Rp) </th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;
		foreach ($list as $data) {
			$midhsd = !empty($data['MIDHSD_MOPS']) ? number_format($data['MIDHSD_MOPS'],2,',','.') : '';
			$midmfo = !empty($data['MIDMFO_MOPS']) ? number_format($data['MIDMFO_MOPS'],2,',','.') : '';
			$KTBI = !empty($data['JISDOR']) ? number_format($data['JISDOR'],2,',','.') : '';

			echo "<tr>";
			echo "<td style='text-align:center'>".$no++."</td>";
			echo "<td style='text-align:center'>".$data['DATE']."</td>";
			echo "<td style='text-align:right'>".$midhsd."</td>";
			echo "<td style='text-align:right'>".$midmfo."</td>";
			echo "<td style='text-align:right'>".$KTBI."</td>";
			echo "</tr>";
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "scrollY": "425px",
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": false,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            "ordering": false,
            "lengthMenu": [[10, 20, -1], [10, 20, "All"]],
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": '_all'},
            ]
        });
    });	
</script>