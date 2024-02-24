<table class="table table-bordered">
    <thead>
        <th>Pembangkit</th>
        <th>Jenis <br>Transaksi</th>
        <th>Jenis <br>BBM</th>
        <th>Nomor <br>Transaksi</th>
        <th>Tanggal <br>Pengakuan</th>
        <th>Volume</th>
        <th>Status</th>
    </thead>
    <tbody>
        <?php if(count($data) > 0) { ?>
            <?php foreach ($data as $value) : ?>
                <?php if($value['LEVEL4'] == "") { ?>
                    <tr style="background-color: #B0C4DE;">
                        <td colspan="5" align="right"><b>TOTAL <?php echo $value['JNS_TRX_BACKDATE'] ?></b></td>
                        <td align="right"><b><?php echo number_format($value['JML'],2,",",'.'); ?></b></td>
                        <td></td>
                    </tr>
                <?php } else { ?>
                <tr>
                    <td><?php echo $value['LEVEL4']; ?></td>
                    <td><?php echo $value['JNS_TRX_BACKDATE']; ?></td>
                    <td><?php echo $value['NAMA_JNS_BHN_BKR']; ?></td>
                    <td><?php echo $value['NO_TRX']; ?><input type="hidden" name="TGL_BACKDATE[]" value="<?php echo str_replace("-",'', $value['TGL']); ?>"></td>
                    <td><?php echo $value['TGL']; ?></td>
                    <td align="right"><?php echo number_format($value['JML'],2,",",'.'); ?></td>
                    <td><?php echo $value['STATUS']; ?></td>
                </tr>
                <?php } ?>
            <?php endforeach; ?>
        <?php } else { ?>
            <tr>
                <td colspan="7" style="text-align: center;">Data Tidak Ditemukan</td>
            </tr>
        <?php } ?>
        
    </tbody>
</table>