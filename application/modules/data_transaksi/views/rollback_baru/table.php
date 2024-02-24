<table class="table table-bordered table-striped">
    <thead>
        <th>Pembangkit</th>
        <th>Jenis Transaksi</th>
        <th>Jenis BBM</th>
        <th>Nomor Transaksi</th>
        <th>Tanggal Pengakuan</th>
        <th>Status</th>
    </thead>
    <tbody>
        <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo $value['LEVEL4']; ?></td>
                <td><?php echo $value['JENIS_TRX']; ?></td>
                <td><?php echo $value['NAMA_JNS_BHN_BKR']; ?></td>
                <td><?php echo $value['ID_TRX']; ?></td>
                <td><?php echo $value['TGL_PENGAKUAN']; ?></td>
                <td><?php echo $value['STATUS']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>