<div class="table_akr">
    <!-- <div class="box-title">
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
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block">Tanggal Akhir :</label>
                    <input type="text" name="" class="form-control span4" placeholder="Sampai" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $tgl_sampai ?>">
                </span>
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block">Pembangkit :</label>
                    <input type="text" name="" class="form-control span4" placeholder="Pembangkit" style="width: 125px;color: black;font-weight: bold;" readonly="" value="<?php echo $pembangkit ?>">
                </span>
            </div>
            <div class="control-group">
                <span style="display:inline-block">
                    <label for="hsd" style="display:block">NO PJBBBM :</label>
                    <input type="text" name="" class="form-control span4" placeholder="NO PJBBBM" style="width: 310px;color: black;font-weight: bold;" readonly="" value="<?php echo $nopjbbbm ?>">
                </span>
            </div>
            <div class="control-group">
                <span style="display:inline-block">
                    <label for="hsd" style="display:block"></label>

                    <?php 
                        $id_dok = $var[0]->PATH_FILE_UPLOAD;
                    ?>                    

                    <!-- dokumen -->
                    <?php  
                        if ($this->laccess->is_prod()){ ?>                            
                            <div id="dokumen">                                
                                <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Download Surat Harga BBM CIF &nbsp;&nbsp;<i class="fa fa-download" style="font-size:15px"></i>'; ?></b></a>
                            </div> 
                    <?php } else { ?>                            
                            <div id="dokumen">                                
                                <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Download Surat Harga BBM CIF &nbsp;&nbsp;<i class="fa fa-download" style="font-size:15px"></i>'; ?></b></a>
                            </div>
                    <?php } ?>
                    <!-- end dokumen -->

            </div>





        </div>

        <table id="dataTableMopsKursAkrKpm" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Low HSD<br>(USD/brl)<br> </th>
                    <th id="lb_kurs_det">KTBI (JISDOR) <br> (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($list as $data) {
                    $lowhsd = !empty($data['LOWHSD_MOPS']) ? number_format($data['LOWHSD_MOPS'],2,',','.') : '';
                    $KTBI = !empty($data['JISDOR']) ? number_format($data['JISDOR'],2,',','.') : '';

                    echo "<tr>";
                    echo "<td style='text-align:center'>".$no++."</td>";
                    echo "<td style='text-align:center'>".$data['DATE']."</td>";
                    echo "<td style='text-align:right'>".$lowhsd."</td>";
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
        $('#dataTableMopsKursAkrKpm').dataTable({
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
                // {"className": "dt-center","targets": '_all'},
            ]
        });
    }); 

    // if ($('#JENIS_KURS').val()==1){
    //     $('#lb_kurs_det').html('KTBI');
    // } else {
    //     $('#lb_kurs_det').html('JISDOR');
    // }
</script>