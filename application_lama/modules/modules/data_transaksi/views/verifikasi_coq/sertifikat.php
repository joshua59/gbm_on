<table class="display" cellpadding="2">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Parameter</th>
            <th rowspan="2">Satuan</th>
            <th colspan="2">Batasan SNI Minyak Solar</th>
            <th rowspan="2">Metode Uji (ASTM)</th>
            <th rowspan="2">Result</th>
            <th rowspan="2">Condition</th>
            <th rowspan="2">Resume</th>
        </tr>
        <tr>
            <th>Min</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $sec = 1; foreach ($list as $value) { ?>
             <tr>
                <td style="text-align: center"><?php echo $no ; ?></td>
                <td style="text-align: left"><?php echo $value['PRMETER_MCOQ'] ?></td>
                <td style="text-align: center"><?php echo $value['SATUAN'] ?></td>
                <?php if ($value['BATAS_MIN'] == null) {
                    $min = "-";
                } else {
                    $min = number_format($value['BATAS_MIN'],2,',','.');
                } 

                if ($value['BATAS_MAX'] == null) {
                    $max = "-";
                } else {
                    $max = number_format($value['BATAS_MAX'],2,',','.');
                } ?>
                <td style="text-align: center">
                    <input type="hidden" id="min_<?php echo $sec ?>" value="<?php echo $min ?>"><?php echo $min; ?></td>
                <td style="text-align: center">
                    <input 
                        type="hidden" 
                        id="max_<?php echo $sec ?>" 
                        value="<?php echo $max ?>"
                    ><?php echo $max; ?>
                </td>
                <td style="text-align: center"><?php echo $value['METODE'] ?></td>
                <td style="text-align: center">
                    <input 
                        type="hidden" 
                        name="id_mcoq[]" 
                        value="<?php echo $value['ID_MCOQ'] ?>"
                    >
                    <?php if($value['PRMETER_MCOQ'] == 'Penampilan Visual') { ?>
                        <?php echo form_dropdown('JENIS', $options_visual, !empty($default->JENIS) ? $default->JENIS : '', 'class="form-control select2" style="width: 150px"'); ?>
                    <?php } else if($value['PRMETER_MCOQ'] == 'Korosi Bilah Tembaga') { ?>
                        <?php echo form_dropdown('JENIS', $options_tembaga, !empty($default->JENIS) ? $default->JENIS : '', 'class="form-control select2" style="width: 150px"'); ?>
                    <?php } else { ?>
                        <input 
                            type="text" 
                            name="result<?php echo $sec ?>" 
                            id="result_<?php echo $sec ?>" 
                            onkeyup="calculate('<?php echo $sec ?>')" 
                            style="text-align: right;width: 150px" 
                            placeholder="Isi Data Result"
                            maxlength="20"
                        >
                    <?php } ?>
                    
                    <input 
                        type="hidden" 
                        name="condition[]" 
                        id="condition<?php echo $sec ?>"
                    >
                    <input 
                        type="hidden" 
                        name="resume[]" 
                        id="resume<?php echo $sec ?>"
                    >
                </td>
                <td style="text-align: center" id="condition_<?php echo $sec ?>"></td>
                <td style="text-align: center" id="return_<?php echo $sec ?>">
                    
                </td>
            </tr>
        <?php $no++; $sec++; } ?>
           
        <input type="hidden" name="total" id="total" value="<?php echo count($list); ?>">
    </tbody>
</table>

<script type="text/javascript">
    

    $(document).ready(function(){
        var total = $('#total').val();
        for (var i = 1; i <= total; i++) {
            $('input[name=result'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
            });
        }
    })
    function calculate(id) {
        
        var n1 = $('#min_'+id).val();
        var n2 = $('#max_'+id).val();
        var n3 = $('#result_'+id).val();
        var min = n1.replace(/,/g, '.');
        var max = n2.replace(/,/g, '.');
        var result = n3.replace(/,/g, '.');
        var warna = '';
        var condition = '';
        var resume = '';
        var hasil = '';
        var value = '';
        var n = '';

        var fmin = parseFloat(min);
        var fmax = parseFloat(max);
        var fresult = parseFloat(result);
        
        if(isNaN(min) || min == '-' || min == undefined) {
            min = '';
        }
        if(isNaN(max) || max == '-' || max == undefined) {
            max = '';
        }
        if(isNaN(fmin) || fmin == '-' || fmin == undefined) {
            fmin = '';
        }
        if(isNaN(fmax) || fmax == '-' || fmax == undefined) {
            fmax = '';
        }
        if(isNaN(fresult) || fresult == '-' || fresult == undefined) {
            fresult = '';
        }
        if(isNaN(fresult) || fresult == '') {
            $('#condition_'+id).html('');
            $('#return_'+id).html("");
        } else {
            if(fmin == '' && fmax != '') {
                if(fresult <= fmax) {
                    warna  = 'green';
                    hasil  = 'PASSED';
                    value  = (fresult - fmax);
                    resume = 0;
                } else {
                    warna  = 'red';
                    hasil  = 'NOT PASSED';
                    value  = fmax - fresult;
                    resume = 1;
                }
        } else if(fmin != '' && fmax == '') {
            if(fresult >= fmin) {
                warna  = 'green';
                hasil  = 'PASSED';
                value  = fresult - fmin;
                resume = 0;
            } else {
                warna  = 'red';
                hasil  = 'NOT PASSED';
                value  = fresult - fmin;
                resume = 1;
            }
        } else if(fmin != '' && fmax != '') {
            if (parseFloat(fresult) < parseFloat(fmin)) {
                warna  = 'red';
                hasil  = 'NOT PASSED';
                value  = fresult - fmin;
                resume = 1;
            } else if(fresult >= fmax){
                warna  = 'red';
                hasil  = 'NOT PASSED';
                value  = fmax - fresult;
                resume = 1;
            }else {
                warna  = 'green';
                hasil  = 'PASSED';
                value  = fresult;
                resume = 0;
            }
        }

        if(isNaN(value)) {
            n = '';
        } else {
            n = parseFloat(value).toFixed(2);
        }

        condition = n.replace(/,/g, '.');
        
        $('#condition_'+id).html(n);
        $('#return_'+id).html("<button type='button' class='btn' style='background-color: "+warna+";color:white'>"+hasil+"</button>");
        }

        $('#condition'+id).val(condition);
        $('#resume'+id).val(resume);        
            
    }
        
</script>