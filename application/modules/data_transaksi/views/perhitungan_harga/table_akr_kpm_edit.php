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
           <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'view'; ?>">
        </div>
        <?php         
        $no=0;       
        
        foreach ($list as $data) {
            $ratalow_hsd = !empty($data['LOW_HSD_RATA2']) ? number_format($data['LOW_HSD_RATA2'],2,',','.') : '';
            $jisdor = !empty($data['RATA2_KURS']) ? number_format($data['RATA2_KURS'],2,',','.') : '';

            $no++;
            echo form_hidden('vidtrans_save_ke'.$no, !empty($data['vidtrans']) ? $data['vidtrans'] : '', 'id="vidtrans_save_ke'.$no.'" readonly');
            // break;
        }
        
        echo form_hidden('vidtrans_total', $no, 'id="vidtrans_total" readonly');
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
                
                foreach ($list as $data) {
                    $tanpa_oat = !empty($data['HARGA_TANPA_HSD']) ? number_format($data['HARGA_TANPA_HSD'],2,',','.') : '';
                    $dgn_oat = !empty($data['HARGA_DENGAN_HSD']) ? number_format($data['HARGA_DENGAN_HSD'],2,',','.') : '';
                    $oat = !empty($data['ONGKOS_ANGKUT']) ? number_format($data['ONGKOS_ANGKUT'],2,',','.') : '';

                    echo "<tr>";
                    echo "<td style='text-align:center'>".$no++."</td>";
                    echo "<td style='text-align:left'>".$data['LEVEL4']."</td>";
                    echo "<td style='text-align:right'>".$tanpa_oat."</td>";
                    echo "<td style='text-align:right'>".$oat."</td>";
                    echo "<td style='text-align:right'>".$dgn_oat."</td>";
                    echo "</tr>";
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
                        <label for="KET_KOREKSI" style="display:block">Keterangan :</label>
                        <?php
                            $data = array(
                              'name'        => 'KET_KOREKSI',
                              'id'          => 'KET_KOREKSI',
                              'value'       => !empty($default->KET_KOREKSI) ? $default->KET_KOREKSI : '',
                              'rows'        => '4',
                              'cols'        => '78',
                              'class'       => '',
                              'style'       => '"none" placeholder="Ketik Keterangan (Max 200)"'
                            );
                          echo form_textarea($data);
                        ?>  
                        <span class="required" id="MaxKet"></span>
                    </span>
                </div>
            </div>
            <br>
        </div>

        <div id="divBtn">
            <?php echo hgenerator::render_button_group($button_group); ?>
        </div>
        
    </div>
    <br><br>
</div>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';

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

    function getIdTrans(vid){
        var IdTrans = vid.split('-');
        return IdTrans[2];
    }

    function approveData(vid) {
        bootbox.confirm('Yakin data ini akan disetujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=2';
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                            close_form(vid);
                        });
                    }
                });
            }
        });
    }

    function tolakData(vid) {
        bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=3&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
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
                                load_table('#content_table', 1, '#ffilter');
                                close_form(vid);
                            }
                        });
                    }
                });
            }
        });
    }

    function koreksiData(vid) {
        bootbox.confirm('Yakin data ini akan disimpan ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=8&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
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
                                load_table('#content_table', 1, '#ffilter');
                                close_form(vid);
                            }
                        });
                    }
                });
            }
        });
    }

    function approveDataKoreksi(vid) {
        bootbox.confirm('Yakin data ini akan disetujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=11&IDKOREKSI='+$('#IDKOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                            close_form(vid);
                        });
                    }
                });
            }
        });
    }

    function tolakDataKoreksi(vid) {
        bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=12&IDKOREKSI='+$('#IDKOREKSI').val()+'&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
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
                                load_table('#content_table', 1, '#ffilter');
                                close_form(vid);
                            }
                        });
                    }
                });
            }
        });
    }

    if (($('#stat').val()=='approve_koreksi') || ($('#stat').val()=='approve')){
        $('#divKetKoreksi').show();
    } else if ($('#stat').val()=='view_koreksi'){
        $('#KET_KOREKSI').attr('disabled', true);
        $('#divKetKoreksi').show();
    } else if ($('#stat').val()=='approve_koreksi_hasil'){
        // $('#KET_KOREKSI').attr('disabled', true);
        $('#divKetKoreksi').show();
    } else if (($('#stat').val()=='tambah_koreksi') || ($('#stat').val()=='edit_koreksi')){
        $('#KET_KOREKSI').attr('readonly','readonly');
        $('#divKetKoreksi').show();
    } else if ($('#KET_KOREKSI').val()!=''){
        $('#KET_KOREKSI').attr('disabled', true);
        $('#divKetKoreksi').show();            
    }

    setformfieldsize($('#KET_KOREKSI'), 200, '');
    $('#KET_KOREKSI').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });      

</script>