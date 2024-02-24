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
        <?php $total = 0; ?>
        <?php if(count($data) > 1) { ?>
             <?php foreach ($data as $value) { ?>
                    <tr>
                        <td><?php echo $value['LEVEL4']; ?></td>
                        <td><?php echo $value['JNS_TRX_BACKDATE']; ?></td>
                        <td><?php echo $value['NAMA_JNS_BHN_BKR']; ?></td>
                        <td><?php echo $value['NO_TRX']; ?><input type="hidden" name="ID_TRX[]" value="<?php echo $value['ID_TRX'] ?>"></td>
                        <td><?php echo $value['TGL']; ?></td>
                        <td align="right"><?php echo number_format($value['JML'],2,",",'.'); ?></td>
                        <td><?php echo $value['STATUS']; ?></td>
                    </tr>
                <?php $total += $value['JML']; } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: center;">TOTAL</th>
                    <th style="text-align: right;"><?php echo number_format($total,2,",",".") ?></th>
                    <th></th>
                </tr>
            </tfoot>
        <?php } else { ?>
            <td colspan="7" style="text-align: center;">
                <input type="hidden" name="ID_TRX" value="NONE">
                Data Tidak Ditemukan
            </td>
        <?php } ?>
       
</table>