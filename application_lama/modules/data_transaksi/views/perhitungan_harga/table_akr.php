<div class="table_akr">
            <div class="box-title">
                 HASIL PERHITUNGAN CIF AKR
            </div>
            <div class="well-content no-search">
                <div class="box-title">
                   Rata-rata MOPS dan Kurs
                </div>
                <div class="well-content no-search">
                    <div class="control-group">
                        <span style="display:inline-block">
                            <label for="hsd" style="display:block">HSD :</label>
                            <input type="text" name="" class="form-control span4" placeholder="avg low HSD" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo number_format($low_hsd->LOWHSD_MOPS,2,',','.') ?>">
                        </span>
                        <span sty
                        <span style="display:inline-block">
                            <label for="ktbi" style="display:block">KTBI (JISDOR):</label>
                            <input type="text" name="" class="form-control span4" placeholder="avg kurs" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo number_format($avg_ktbi->KTBI,2,',','.') ?>">
                        </span>
                    </div>
                </div>
                <?php 

                $PPN = 1.1;
                $ALPHA = ($ak_alpha / 100);
                $SULFUR = ($ak_sulfur/100);
                $LOWHSD = $low_hsd->LOWHSD_MOPS;
                $KTBI = $avg_ktbi->KTBI;
                $KONVERSI = $ak_konversi;

                $HARGATANPAOAT = ( $ALPHA * $SULFUR * $LOWHSD * $KTBI * $PPN ) / $KONVERSI;

                ?>
                <table class="table table-responsive table-hover table-striped table-border">
                    <thead>
                        <tr>
                            <th>HARGA TANPA OAT</th>
                            <th>OAT</th>
                            <th>HARGA DENGAN OAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center"><?php echo number_format($HARGATANPAOAT,2,',','.') ;?></td>
                            <td style="text-align: center"><?php echo number_format($ak_oa,2,',','.') ;?></td>
                            <td style="text-align: center"><?php echo number_format($HARGATANPAOAT + $ak_oa,2,',','.') ;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
</div>  

<input type="hidden" id="AVGLOWHSD" value="<?php echo $low_hsd->LOWHSD_MOPS ?>">
<input type="hidden" id="AVGKURS" value="<?php echo $avg_ktbi->KTBI ?>">
<input type="hidden" id="HARGATANPAOAT" value="<?php echo number_format((float)$HARGATANPAOAT, 2, '.', ''); ?>">
<input type="hidden" id="HARGADGNOAT" value="<?php echo number_format((float)$HARGATANPAOAT + $ak_oa, 2, '.', ''); ?>">