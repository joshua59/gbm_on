<table class="table table-bordered table-striped">
    <thead>
        <th>Pembangkit</th>
        <th>Jenis Transaksi</th>
        <th>Jenis BBM</th>
        <th>Nomor Transaksi</th>
        <th>Tanggal Pengakuan</th>
        <th>Status</th>
        <th>Alasan Rollback</th>
    </thead>
    <tbody>
        <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo $value['LEVEL4']; ?></td>
                <td><?php echo $value['JNS_TRANSAKSI']; ?></td>
                <td><?php echo $value['NAMA_JNS_BHN_BKR']; ?></td>
                <td><?php echo $value['NO_NOMINASI']; ?></td>
                <td><?php echo $value['TGL_MTS_NOMINASI']; ?></td>
                <td><?php echo $value['STATUS']; ?></td>
                <td><?php echo $value['ALASAN']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>