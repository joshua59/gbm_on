<style type="text/css">
    table.dataTable tr.odd { background-color:  #f2f4f4  ; }
    table.dataTable tr.even { background-color: white; } 

    table.dataTable tbody tr.selected {    
        background-color: #A9A9A9;
    }          
</style>

<?php
echo form_open_multipart($form_action, array('id' => 'fhasil_harga', 'class' => 'form-horizontal'), $hidden_form);
?>
<div class="table_akr">
    <!-- <div class="box-title">
        HASIL PERHITUNGAN CIF
    </div> -->
    <div class="well-content no-search">
        <div class="box-title">
           Rata-rata MOPS dan Kurs
           <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'view'; ?>">
        </div>
        <?php         
        $no=0;       
        $jns_kurs = 'KTBI :';

        foreach ($list as $data) {
            $ratalow_hsd = !empty($data['LOW_HSD_RATA2']) ? number_format($data['LOW_HSD_RATA2'],2,',','.') : '';
            $jisdor = !empty($data['RATA2_KURS']) ? number_format($data['RATA2_KURS'],2,',','.') : '';

            $no++;
            echo form_hidden('vidtrans_save_ke'.$no, !empty($data['vidtrans']) ? $data['vidtrans'] : '', 'id="vidtrans_save_ke'.$no.'" readonly');
            // break;

            if ($no==1){
                $cek = $data['JNS_KURS'];
                if ($cek==1){
                    $jns_kurs = 'KTBI :';
                } else {
                    $jns_kurs = 'JISDOR :';
                }

                $tgl_suply = $data['TGLAWAL'];
                $skema = $data['SKEMA_NAMA'];


            }
        }
        
        echo form_hidden('vidtrans_total', $no, 'id="vidtrans_total" readonly');
        ?>
        <div class="well-content no-search">
            <div class="control-group">
                <span style="display:inline-block">
                    <label for="hsd" style="display:block">HSD :</label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $ratalow_hsd ?>" id="mops">
                </span>
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block" id="lb_kurs"><?php echo $jns_kurs ?></label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $jisdor ?>" id="kurs">
                </span>
                <span style="display:inline-block">
                    <label for="tgl_suply" style="display:block" id="lb_tgl_suply">Tanggal B/L :</label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $tgl_suply ?>" id="tgl_suply">
                </span>
                <span style="display:inline-block">
                    <label for="skema" style="display:block" id="lb_skema">Skema Insidentil :</label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $skema ?>" id="skema">
                </span>
            </div>
        </div>

        <table id="dataTableKursMops" class="table table-responsive table-hover table-bordered " style="width: 100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Level&nbsp;1</th>
                <th>Level&nbsp;2</th>
                <th>Level&nbsp;3</th>
                <th>Pembangkit</th>
                <th>Harga Tanpa OAT <br/> (Rp/Liter)</th>
                <th>OAT (Rp/Liter)</th>
                <th>Harga Dengan OAT <br/>  (Rp/Liter)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                // var_dump($list);
                
                foreach ($list as $data) {
                    $tanpa_oat = !empty($data['HARGA_TANPA_HSD']) ? number_format($data['HARGA_TANPA_HSD'],2,',','.') : '';
                    $dgn_oat = !empty($data['HARGA_DENGAN_HSD']) ? number_format($data['HARGA_DENGAN_HSD'],2,',','.') : '';
                    $oat = !empty($data['ONGKOS_ANGKUT']) ? number_format($data['ONGKOS_ANGKUT'],2,',','.') : '';
                    $kurs = !empty($data['RATA2_KURS']) ? number_format($data['RATA2_KURS'],2,',','.') : '';
                    $mops = !empty($data['LOW_HSD_RATA2']) ? number_format($data['LOW_HSD_RATA2'],2,',','.') : '';
                    $TGLAWAL = $data['TGLAWAL'];
                    $SKEMA = $data['SKEMA_NAMA'];
                    

                    echo "<tr>";
                    echo "<td style='text-align:center'>".$no++."</td>";
                    echo "<td style='text-align:left'>".$data['LEVEL1']."</td>";
                    echo "<td style='text-align:left'>".$data['LEVEL2']."</td>";
                    echo "<td style='text-align:left'>".$data['LEVEL3']."</td>";
                    echo "<td style='text-align:left'>".$data['LEVEL4']."</td>";
                    echo "<td style='text-align:right'>".$tanpa_oat."</td>";
                    echo "<td style='text-align:right'>".$oat."</td>";
                    echo "<td style='text-align:right'>".$dgn_oat."</td>";
                    echo "<td align='center'>
                            <a href='javascript:void(0);' class='btn transparant' id='".$data['IDTRANS']."' onclick='open_mops(this.id)' vnp_pjbbbm='".$data['NOPJBBM']."' pembangkit='".$data['LEVEL4']."' jns_kurs='".$data['JNS_KURS']."' kurs='".$kurs."' mops='".$mops."' TGLAWAL='".$TGLAWAL."' SKEMA='".$SKEMA."' ><i class='icon-zoom-in' title='Lihat Mops dan Kurs'></i></a> 
                    </td>";
                    echo "</tr>";
                }
                
                ?>
            </tbody>
        </table>
        <?php echo form_close(); ?>        
    </div><br>
    <label><i>(*Harga termasuk PPN 10%)</i></label><br>
    <label><i>(*OAT = Ongkos Angkut Transportasi)</i></label><br>
    <label><i>(*B/L = Bill of Lading)</i></label>
    <br><br><br><br>
</div>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';
    var cek_open = 0;

    $(document).ready(function() {
        $('#dataTableKursMops').dataTable({
            "scrollY": "385px",
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

    function open_mops(vid) {
        cek_open = 1;
        $('#dataTableKursMops tbody').on( 'click', 'tr', function () {
            if (cek_open){
                $('#dataTableKursMops').DataTable().$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                cek_open = 0;
            }
        } );

        var nopjbbbm = $('#'+vid).attr('vnp_pjbbbm');
        var pembangkit = $('#'+vid).attr('pembangkit');
        var jns_kurs = $('#'+vid).attr('jns_kurs');
        var kurs = $('#'+vid).attr('kurs');
        var mops = $('#'+vid).attr('mops');
        var TGLAWAL = $('#'+vid).attr('TGLAWAL');
        var SKEMA = $('#'+vid).attr('SKEMA');
        
        // $('#NOPJBBM').val(nopjbbbm);
        get_mops_kurs_akr_kpm(vid,pembangkit,nopjbbbm,jns_kurs,kurs,mops,TGLAWAL,SKEMA);
    }
    

    // if ($('#JENIS_KURS').val()==1){
    //     $('#lb_kurs').html('KTBI :');
    // } else {
    //     $('#lb_kurs').html('JISDOR :');
    // }
</script>