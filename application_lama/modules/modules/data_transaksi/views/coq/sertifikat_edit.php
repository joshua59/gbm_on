<table class="display" cellpadding="2">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Parameter</th>
            <th rowspan="2">Satuan</th>
            <th colspan="2">Batasan SNI Minyak Solar</th>
            <th rowspan="2">Metode Uji (ASTM)</th>
            <th rowspan="2">Result</th>
            <th rowspan="2">Resume</th>
        </tr>
        <tr>
            <th>Min</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>

        <?php $no = 1; $sec = 1; foreach ($list as $value) : ?>
            <?php 
                $min       = ($value['BATAS_MIN'] == null) ? '-' : number_format($value['BATAS_MIN'],3,',','.');
                $max       = ($value['BATAS_MAX'] == null) ? '-' : number_format($value['BATAS_MAX'],3,',','.');
                $id_mcoq   = (!empty($value['ID_MCOQ'])) ? $value['ID_MCOQ'] : '';
                $result_id = (!empty($value['RESULT']) || $value['RESULT'] == 0) ? $value['RESULT_ID'] : '';
                $resume    = $value['RESUME'];
                $data = array(
                    'name'          => 'result'.$sec,
                    'id'            => 'result_'.$sec,
                    'value'         => (!empty($value['RESULT']) || $value['RESULT'] == 0) ? $value['RESULT'] : '',
                    'maxlength'     => '20',
                    'style'         => 'width:150px',
                    'placeholder'   => 'Isi Data Result...',
                    'onchange'      => "calculate('".$sec."')",
                    'required'      => 'required',
                    'class'         => 'form-control'
                ); 
            ?>
            
            <input type="hidden" value="<?php echo $min ?>">
            <input type="hidden" value="<?php echo $max ?>">
            <input type="hidden" name="id_mcoq[]" value="<?php echo $id_mcoq ?>">
            <input type="hidden" name="result_save[]" id="result_save<?php echo $sec ?>" value="<?php echo $result_id ?>">
            <input type="hidden" name="resume[]" id="resume<?php echo $sec ?>" value="<?php echo $resume ?>">

            <tr>
                <td style="text-align: center"><?php echo $no; ?></td>
                <td style="text-align: left"><?php echo $value['PARAMETER_ANALISA'] ?></td>
                <td style="text-align: left"><?php echo $value['SATUAN'] ?></td>
                <td style="text-align: left" id="min_<?php echo $sec ?>"><?php echo $min; ?></td>
                <td style="text-align: left" id="max_<?php echo $sec ?>"><?php echo $max; ?></td>
                <td style="text-align: left"><?php echo $value['METODE'] ?></td>

                <td style="text-align: left">
                    <?php if($value['TIPE'] == 1) { ?>
                        <?php echo form_input($data); ?> 
                    <?php } else { ?>
                        <?php $array = $this->db->query("SELECT * FROM MASTER_PARAMETER_NILAI WHERE ID_PARAMETER = '".$value['ID_PARAMETER']."' AND IS_AKTIF = 1 ORDER BY NAMA_NILAI ASC")->result_array(); ?>
                        <select class="form-control" name="result<?php echo $sec?>" id="nilai_param<?php echo $sec ?>" onchange="get_result(<?php echo $sec ?>)">
                            <option value="">-- Pilih Nilai Parameter --</option>
                            <?php if($value['RESULT_ID'] == '-') { ?>
                                <option value="-" selected>-</option>
                                <?php foreach($array as $k) : ?>
                                    <option value="<?php echo $k['ID_NILAI']?>"><?php echo $k['NAMA_NILAI']; ?></option>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <option value="-">-</option>
                                <?php 
                                foreach($array as $k) {
                                    
                                    if ($value['RESULT_ID'] == $k['ID_NILAI']) {
                                        echo "<option value='". $k['ID_NILAI']."' selected='selected'>". $k['NAMA_NILAI']."</option>";
                                    }else{
                                        echo "<option value='". $k['ID_NILAI']."'>". $k['NAMA_NILAI']."</option>";
                                    }  
                                }
                                ?>
                            <?php } ?>
                        </select>
                        
                    <?php } ?>
                </td>
                <td style="text-align: center" id="return_<?php echo $sec ?>">
                    <?php if($value['RESUME'] == 1) { ?>
                        <button type='button' class='btn' style='background-color: red;color:white'>NOT PASSED</button>
                    <?php } else if($value['RESUME'] == 0) { ?>
                        <button type='button' class='btn' style='background-color: green;color:white'>PASSED</button>
                    <?php } else { ?>
                        <?php echo "-"; ?>
                    <?php } ?>
                    
                </td>
            </tr>
            <?php $no++;$sec++ ;endforeach; ?>
                
    </tbody>
</table>
<input type="hidden" id="total" value="<?php echo count($list) ?>">
<script type="text/javascript">
    

    $(document).ready(function(){
        var total = $("#total").val();
        for (var i = 1; i <= total; i++) {
            $('input[name=result'+i+']').inputmask("numeric", {integerDigits:9,radixPoint: ",",groupSeparator: ".",digits: 3,autoGroup: true,prefix: '',rightAlign: false, allowMinus: true, oncleared: function () { 
                    self.Value(''); 
                }
            });
        }
    })

    function calculate(id) {
        let warna,condition,resume,hasil,value,n,tipe;

        var n1 = $('#min_'+id).text();
        var n2 = $('#max_'+id).text();
        var n3 = $('#result_'+id).val();
        
        var n_1 = (n1 !== '-') ? ganti(n1) : '';
        var n_2 = (n2 !== '-') ? ganti(n2) : '';
        var n_3 = (n3 !== '') ?  ganti(n3) : '';

        if(n_1 !== '' && n_2 == '') {
            if(to_number(n_3) >= to_number(n_1)) {
                warna = 'green'; resume = 0; hasil = 'PASSED'; value = (to_number(n_3) - to_number(n_1));
            } else if(n_3 == '-' || n_3 == "" || n_3 == null) {
                warna = ''; resume = 2; hasil = ''; value = '-';
            } else {
                warna = 'red'; resume = 1; hasil = 'NOT PASSED'; value = (to_number(n_1) - to_number(n_3));
            }
        }

        if(n_1 == '' && n_2 !== '') {
            if(to_number(n_3) > to_number(n_2)) {
                warna = 'red'; resume = 1; hasil = 'NOT PASSED'; value = (to_number(n_1) - to_number(n_2));
            } else if(n_3 == '-' || n_3 == "" || n_3 == null) {
                warna = ''; resume = 2; hasil = ''; value = '-';
            } else {
                warna = 'green'; resume = 0; hasil = 'PASSED'; value = (to_number(n_3) - to_number(n_2));
            }
        }

        if(n_1 !== '' && n_2 !== '') {
            if(n_3 == '-' || n_3 == "" || n_3 == null) {
                warna = ''; resume = 2; hasil = ''; value = '-';
            } else if(to_number(n_3) > to_number(n_2)) {
                warna = 'red'; resume = 1; hasil = 'NOT PASSED'; value = (to_number(n_1) - to_number(n_2));
            } else if(to_number(n_3) < to_number(n_1)) {
                warna = 'red'; resume = 1; hasil = 'NOT PASSED'; value = (to_number(n_1) - to_number(n_2));
            } else {
                warna = 'green'; resume = 0; hasil = 'PASSED'; value = (to_number(n_3) - to_number(n_2));
            }
        }

        n = (isNaN(value)) ? '' : convertToRupiah(value);

        condition = n.replace(/,/g, '.');

        if(warna == '') {
            $('#return_'+id).html("-");
        } else {
            $('#return_'+id).html("<button type='button' class='btn' style='background-color: "+warna+";color:white'>"+hasil+"</button>");
        }
        $("#result_save"+id).val(ganti(n3))
        // $('#condition'+id).val(condition);
        $('#resume'+id).val(resume);        
            
    }

    function get_result(id) {
        var value = $("#nilai_param"+id).val();
        if(value != '-' || value !='') {
            $.ajax({
                url : "<?php echo base_url('data_transaksi/coq/get_status'); ?>",
                type: 'POST',
                data: {
                    p_id : value
                },
                beforeSend:function(response) {
                    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                },
                error:function(response) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                },
                success:function(response){
                    bootbox.hideAll();
                    $('#result_save'+id).val(value);
                    get_nilai_result(id,response,value)
                }
            });
        } else if(value == '-') {
            $('#result_save'+id).val(value);
            get_nilai_result(id,'-',value);
        }
        
    }

    function get_nilai_result(id,status,value) {
        let warna,condition,resume,hasil,n;
        if(status == 1) {
            hasil = 'PASSED';
            warna = 'green';
            condition = $('#nilai_param'+id+' option:selected').text();
            n = 0;
        } else if(status == 2) {
            hasil = 'NOT PASSED';
            warna = 'red';
            condition = $('#nilai_param'+id+' option:selected').text();
            n = 1;
        } else if(status == '-'){
            hasil = '-';
            warna = 'transparent';
            condition = $('#nilai_param'+id+' option:selected').text();
            n = 2;
        }

        if(warna == 'transparent') {
            $('#return_'+id).html("");
            $('#return_'+id).html("-");
        } else {
            $('#return_'+id).html("<button type='button' class='btn' style='background-color: "+warna+";color:white'>"+hasil+"</button>");
        }
        
        $('#resume'+id).val(n);
    }

    function ganti(value) {
        var n = value.replace(/\./g,'');
        var v = n.replace(/,/g,'.');
        if(isNaN(v)) {
            return '';
        } else {
            return v; 
        }
    }

    function convertToRupiah(angka){
        var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
        bilangan = bilangan.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            bilangan = bilangan.replace("-", "");
            isMinus = '-';
        }
        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        if ((rupiah=='') || (rupiah==0)) {rupiah='0,00'}
        rupiah = isMinus+''+rupiah;

        return rupiah;
    }

    function to_number(value) {

        var a;
        if(value !== '') {
            a = Number(value);
        } else {
            a = '';
        }
        return a;
    }

        
</script>