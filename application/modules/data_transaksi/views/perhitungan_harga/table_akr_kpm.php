<?php
echo form_open_multipart($form_action, array('id' => 'fhasil_harga', 'class' => 'form-horizontal'), $hidden_form);
?>
<div class="table_akr">
    <div class="box-title">
        HASIL PERHITUNGAN CIF
    </div>
    <div class="well-content no-search">
        <div class="box-title">
           Rata-rata MOPS dan Kurs
        </div>
            <input type="hidden" name="IDGROUP" id="IDGROUP" value="<?php echo !empty($IDGROUP) ? $IDGROUP : ''; ?>">
            <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'add'; ?>">
            <!-- <?php //echo form_upload('PATH_FILE', 'class="span6"'); ?> -->
            <span id="PATH_FILE_AREA" hidden><input type="file" id="PATH_FILE" name="PATH_FILE"/></span>
            <input type="hidden" id="PATH_FILE_EDIT" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : ''?>">
        <?php         
        $no=0;       
        foreach ($list as $list2) {
            foreach ($list2 as $data) {
                $ratalow_hsd = !empty($data['ratalow_hsd']) ? number_format($data['ratalow_hsd'],2,',','.') : '';
                $jisdor = !empty($data['jisdor']) ? number_format($data['jisdor'],2,',','.') : '';

                $no++;
                echo form_hidden('vidtrans_save_ke'.$no, !empty($data['vidtrans']) ? $data['vidtrans'] : '', 'id="vidtrans_save_ke'.$no.'" readonly');
                echo form_hidden('vidtrans_edit_save_ke'.$no, !empty($data['vidtrans_edit']) ? $data['vidtrans_edit'] : '', 'id="vidtrans_edit_save_ke'.$no.'" readonly');
                // break;
            }
        }

        echo form_hidden('vidtrans_total', $no, 'id="vidtrans_total" readonly');

        $no=0;
        foreach ($list_idkoreksi as $data) {
            $no++;
            echo form_hidden('vidkoreksi_ke'.$no, !empty($data) ? $data : '', 'id="vidkoreksi_ke'.$no.'" readonly');    
        }
        
        if ($stat=='tambah_koreksi'){
            $i=0;
            foreach ($list_idtrans as $data) {
                $i++;
                echo form_hidden('vidtrans_koreksi_ke'.$i, !empty($data['IDTRANS']) ? $data['IDTRANS'] : '', 'id="vidtrans_koreksi_ke'.$i.'" readonly');
            }
        }

        ?>
        <div class="well-content no-search">
            <div class="control-group">
                <span style="display:inline-block">
                    <label for="hsd" style="display:block">HSD :</label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $ratalow_hsd ?>">
                </span>
                <span sty
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block" id="lb_kurs">KTBI (JISDOR):</label>
                    <input type="text" name="" class="form-control span4" placeholder="-" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo $jisdor ?>">
                </span>
            </div>
        </div>

        <table id="dataTableKursMops" class="table table-responsive table-hover table-bordered table-striped" style="width: 100%">
            <thead>
              <tr>
                    <th>No</th>
                    <th>Pembangkit</th>
                    <th>Harga Tanpa OAT <br/> (Rp/Liter)</th>
                    <th>OAT (Rp/Liter)</th>
                    <th>Harga Dengan OAT <br/>  (Rp/Liter)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                // var_dump($list);
                foreach ($list as $list2) {
                    foreach ($list2 as $data) {
                        $tanpa_oat = !empty($data['HargaTanpaPPN_hsd']) ? number_format($data['HargaTanpaPPN_hsd'],2,',','.') : '';
                        $dgn_oat = !empty($data['HargaDenganPPN_hsd']) ? number_format($data['HargaDenganPPN_hsd'],2,',','.') : '';
                        $oat = !empty($data['oat']) ? number_format($data['oat'],2,',','.') : '';

                        echo "<tr>";
                        echo "<td style='text-align:center'>".$no++."</td>";
                        echo "<td style='text-align:left'>".$data['vsloc']."</td>";
                        echo "<td style='text-align:right'>".$tanpa_oat."</td>";
                        echo "<td style='text-align:right'>".$oat."</td>";
                        echo "<td style='text-align:right'>".$dgn_oat."</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <?php echo form_close(); ?>
        <label><i>(*Harga termasuk PPN 10%)</i></label><br>
        <label><i>(*OAT = Ongkos Angkut Transportasi)</i></label>
        <hr>

        <div id="divKetKoreksi" hidden>
            <div class="well-content no-search">
                <div class="control-group">
                    <span style="display:inline-block">
                        <label for="KET_KOREKSI" style="display:block">Keterangan Koreksi :</label>
                        <?php
                            $data = array(
                              'name'        => 'KET_KOREKSI',
                              'id'          => 'KET_KOREKSI',
                              'value'       => !empty($ket) ? $ket : '',
                              'rows'        => '4',
                              'cols'        => '78',
                              'class'       => '',
                              'style'       => '"none" placeholder="Ketik Keterangan Koreksi"'
                            );
                          echo form_textarea($data);
                        ?>  
                    </span>
                </div>
            </div>
            <br>
        </div>

        <div id="divBtn">
            <?php 
                echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)'));
            
                if ($this->laccess->otoritas('edit')) {

                    if ($stat=='tambah_koreksi'){
                        echo anchor(null, '<i class="icon-save"></i> Simpan Koreksi', array('id' => 'button-save-hitung', 'class' => 'blue btn', 'onclick' => "simpan_data_hitung()"));
                    } else {
                        echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save-hitung', 'class' => 'blue btn', 'onclick' => "simpan_data_hitung()"));
                    }
                    
                }
            ?>
        </div>
        
    </div>
    <br><br>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTableKursMops').dataTable({
            "scrollY": "170px",
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

    if ($('#JENIS_KURS').val()==1){
        $('#lb_kurs').html('KTBI :');
    } else {
        $('#lb_kurs').html('JISDOR :');
    }

    function simpan_data_hitung() {
        if ($('#stat').val()=='add'){
            var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all/";
        } else if ($('#stat').val()=='tambah_koreksi'){
            var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all_koreksi/";
        } else {
            var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all_edit/";
        }

      bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');
            $('#PATH_FILE_EDIT').val($('#PATH_FILE_EDIT_IN').val());

            $('#fhasil_harga').ajaxSubmit({
                url: urlna,
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                success: function(data) {
                    bootbox.hideAll();

                    var icon = 'icon-remove-sign'; var color = '#ac193d;';
                    var message = '';
                    var content_id = data[3];
                    if (data[0]) {
                        icon = 'icon-ok-sign';
                        color = '#0072c6;';
                    }

                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                    message += data[2];

                    bootbox.alert(message, function() {
                        if (data[0]) {
                            $('#button-back').click();
                            load_table('#content_table', 1, '#ffilter');
                        }
                    });
                }    
            });
        }
      });
    }

    function simpan_data_hitungX(){ 
        bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
            if(e){
                // var data_kirim = 'vidtrans='+$('#vidtrans').val();
                // $('#PATH_FILE').val($('#PATH_FILE_IN').val());
                
                // $('#field1').change(function(){
                    // console.log($('#PATH_FILE'));

                    var x = $('#PATH_FILE_IN');
                    var clone = x.clone();

                    // console.log(clone);

                    clone.attr('id', 'field2');
                    console.log(clone);                    
                    $('#field2_area').html(clone);
                // });


                  // var x = $("#PATH_FILE"),
                  //     y = x.clone();
                  // x.attr("id", "field3");
                  // y.insertAfter("#field2_area");                

                var data_kirim = $("#fhasil_harga").serialize();


                if ($('#stat').val()=='add'){
                    var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all/";
                } else if ($('#stat').val()=='tambah_koreksi'){
                    var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all_koreksi/";
                } else {
                    var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all_edit/";
                }

                // if ($('#vidtrans_edit_save_ke1').val()){//edit
                //     var urlna ="<?php //echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all_edit/";

                //     // alert('PROSES SIMPAN HASIL EDIT MASIH DIKERJAKAN');
                //     // return;
                // } else {//add
                //     var urlna ="<?php //echo base_url()?>data_transaksi/perhitungan_harga/simpan_data_all/";
                // }
                
                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: urlna,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses simpan data gagal ');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                        var icon = 'icon-remove-sign'; var color = '#ac193d;';
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            if (data[0]) {
                                $('#button-back').click();
                                load_table('#content_table', 1, '#ffilter');
                            }
                        });
                    }    
                })
            }
        });        
    }

    if ($('#stat').val()=='tambah_koreksi'){
        // $('#KET_KOREKSI').attr('disabled', true);
        $('#KET_KOREKSI').attr('readonly','readonly');
        $('#divKetKoreksi').show();
    } else if ($('#stat').val()=='edit_koreksi'){
        $('#KET_KOREKSI').attr('disabled', true);
        $('#divKetKoreksi').show();
    }

    // $("#button-save-hitung").click(function () {
    //     bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
    //         if(e){
    //             simpan_data_hitung();
    //         }
    //     });
    // });
</script>