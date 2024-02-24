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
        <?php foreach ($data as $value) : ?>
            <?php $total = 0; ?>
            <tr>
                <td><?php echo $value['LEVEL4']; ?></td>
                <td><?php echo $value['JNS_TRX_BACKDATE']; ?></td>
                <td><?php echo $value['NAMA_JNS_BHN_BKR']; ?></td>
                <td><?php echo $value['NO_TRX']; ?><input type="hidden" name="TGL_BACKDATE[]" value="<?php echo str_replace("-",'', $value['TGL']); ?>"></td>
                <td><?php echo $value['TGL']; ?></td>
                <td align="right"><?php echo number_format($value['JML'],2,",",'.'); ?></td>
                <td><?php echo $value['STATUS']; ?></td>
            </tr>
            <?php $total += $value['JML']; ?>
            <?php } ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5">TOTAL</th>
            <th colspan="2"><?php echo $total ?></th>
        </tr>
    </tfoot>
</table>