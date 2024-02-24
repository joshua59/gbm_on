<div class="table_pertamina">
    <div class="box-title">
        HASIL PERHITUNGAN FOB
    </div>
    <div class="well-content no-search">
        <div class="box-title">
           Rata-rata MOPS dan Kurs
        </div>
        <div class="well-content no-search">
            <div class="control-group">
                <input type="hidden" name="vidtrans" class="form-control span4" readonly="" value="<?php echo $vidtrans ?>" id="vidtrans">
                <input type="hidden" name="vidtrans_edit" class="form-control span4" readonly="" value="<?php echo $vidtrans_edit ?>" id="vidtrans_edit">

                <span style="display:inline-block">
                    <label for="hsd" style="display:block">HSD :</label>
                    <input type="text" name="avgmidhsd" class="form-control span4" placeholder="avg mid HSD" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo number_format($avg_mid_hsd,2,',','.') ?>" id="AVGMIDHSD">
                </span>
                <span style="display:inline-block">
                    <label for="mfo" style="display:block">MFO :</label>
                    <input type="text" name="avgmidmfo" class="form-control span4" placeholder="avg mid MFO" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo number_format($avg_mid_mfo,2,',','.') ?>" id="AVGMIDMFO">
                </span>
                <span style="display:inline-block">
                    <label for="ktbi" style="display:block">JISDOR:</label>
                    <input type="text" name="avgkurs" class="form-control span4" placeholder="avg kurs" style="width: 90px;color: black;font-weight: bold;" readonly="" value="<?php echo number_format($avg_ktbi,2,',','.') ?>" id="AVGKURS">
                </span>
            </div>
        </div>

        <table class="table table-responsive table-hover table-striped table-border">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Alpha</th>
                    <th>Harga Tanpa PPN (Rp/Liter)</th>
                    <th>PPN (10%)</th>
                    <th>Harga Dengan PPN (Rp/Liter)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">HSD</td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$alfamid_hsd,2,',','.') ; ?>
                        <input type="hidden" name="alfamid_hsd" id="alfamid_hsd" value="<?php echo number_format((float)$alfamid_hsd,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right;">
                        <?php echo number_format((float)$HargaTanpaPPN_hsd,2,',','.') ; ?>
                        <input type="hidden" name="HSDNOPPN" id="HSDNOPPN" value="<?php echo number_format((float)$HargaTanpaPPN_hsd,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$PPN_hsd,2,',','.') ; ?>
                        <input type="hidden" name="HSDPPN" id="HSDPPN" value="<?php echo number_format((float)$PPN_hsd,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$HargaDenganPPN_hsd,2,',','.') ; ?>
                        <input type="hidden" name="HSDTOTAL" id="HSDTOTAL" value="<?php echo number_format((float)$HargaDenganPPN_hsd,2,',','.') ; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">MFO</td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$alfamid_mfo,2,',','.') ; ?>
                        <input type="hidden" name="alfamid_mfo" id="alfamid_mfo" value="<?php echo number_format((float)$alfamid_mfo,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$HargaTanpaPPN_mfo,2,',','.') ; ?>
                        <input type="hidden" name="MFONOPPN" id="MFONOPPN" value="<?php echo number_format((float)$HargaTanpaPPN_mfo,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$PPN_mfo,2,',','.') ; ?>
                        <input type="hidden" name="MFOPPN" id="MFOPPN" value="<?php echo number_format((float)$PPN_mfo,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$HargaDenganPPN_mfo,2,',','.') ; ?>
                        <input type="hidden" name="MFOTOTAL" id="MFOTOTAL" value="<?php echo number_format((float)$HargaDenganPPN_mfo,2,',','.') ; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">IDO</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$HargaTanpaPPN_ido,2,',','.') ; ?>
                        <input type="hidden" name="IDONOPPN" id="IDONOPPN" value="<?php echo number_format((float)$HargaTanpaPPN_ido,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$PPN_ido,2,',','.') ; ?>
                        <input type="hidden" name="IDOPPN" id="IDOPPN" value="<?php echo number_format((float)$PPN_ido,2,',','.') ; ?>">
                    </td>
                    <td style="text-align: right">
                        <?php echo number_format((float)$HargaDenganPPN_ido,2,',','.') ; ?>
                        <input type="hidden" name="IDOTOTAL" id="IDOTOTAL" value="<?php echo number_format((float)$HargaDenganPPN_ido,2,',','.') ; ?>">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>