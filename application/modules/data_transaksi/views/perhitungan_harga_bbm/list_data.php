<div class="table_pertamina">
<!--     <div class="box-title">
        Data MOPS dan Kurs
    </div> -->
    <div class="well-content no-search">
        <div class="box-title">
           Periode MOPS dan Kurs
        </div>

        <?php 
            $no = 1;
            $tgl_dari = '';
            $tgl_sampai = '';
            foreach ($list as $data) {
                if ($no==1){
                    $tgl_dari = $data['DATE'];    
                }
                $tgl_sampai = $data['DATE'];
                $no++;
            }
        ?>

        <div class="well-content no-search">
            <div class="control-group">
                <span style="display:inline-block">
                    <label for="hsd" style="display:block">Tanggal Awal :</label>
                    <input type="text" name="" class="form-control span4" placeholder="Dari" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $tgl_dari ?>">
                </span>
                <span sty
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block">Tanggal Akhir :</label>
                    <input type="text" name="" class="form-control span4" placeholder="Sampai" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $tgl_sampai ?>">
                </span>
            </div>
        </div>

		<table id="dataTableMopsKursPertamina" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>MID HSD <br/> (USD/brl) </th>
					<th>MID MFO HSFO<br/> (USD/MT) </th>
					<th>MID MFO LSFO <br/> (USD/MT) </th>
					<th>KTBI (JISDOR) <br/> (Rp) </th>
				</tr>
			</thead>
			<tbody>
				<?php $no = 1;
				foreach ($list as $data) {
					$midhsd = !empty($data['MIDHSD_MOPS']) ? number_format($data['MIDHSD_MOPS'],2,',','.') : '';
					$midmfo = !empty($data['MIDMFO_MOPS']) ? number_format($data['MIDMFO_MOPS'],2,',','.') : '';
					$midmfolsfo = !empty($data['MIDMFOLSFO_MOPS']) ? number_format($data['MIDMFOLSFO_MOPS'],2,',','.') : '';
					$KTBI = !empty($data['JISDOR']) ? number_format($data['JISDOR'],2,',','.') : '';

					echo "<tr>";
					echo "<td style='text-align:center'>".$no++."</td>";
					echo "<td style='text-align:center'>".$data['DATE']."</td>";
					echo "<td style='text-align:right'>".$midhsd."</td>";
					echo "<td style='text-align:right'>".$midmfo."</td>";
					echo "<td style='text-align:right'>".$midmfolsfo."</td>";
					echo "<td style='text-align:right'>".$KTBI."</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>  
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTableMopsKursPertamina').dataTable({
            "scrollY": "425px",
            "scrollX": true,
            "scrollCollapse": true,
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
                // {"className": "dt-center","targets": '_all'},
            ]
        });            
    });	
</script>