 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="well-content no-search">

                <div style="padding: 3px 3px 3px 3px;background-color: #FFC000;border-collapse: collapse; border-style: 4px solid black;width: 24%">
                    <h3 style="color: white;font-size: 1.5rem">Schedule Date : <?php echo date('d M Y'); ?></h3>
                </div>
                   
                <div class="row">
                    <div class="col-md-3 col-md-6" id="pnl_hsd"><br>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="text-center">
                                            <?php echo "Kurs KTBI"; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-9 text-center text-white">
                                        <div style="padding: 10px 10px 10px 10px;">
                                            <h2><?php echo ($kurs_ktbi['STATUS'] == 1) ? "Sukses" : "Gagal"; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer" style="background-color:#337ab7">
                                <span class="pull-right" style="color:#fff"><?php echo $kurs_ktbi['CD_DATE'] ?></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-6" id="pnl_hsd"><br>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="text-center">
                                            <?php echo "Kurs JISDOR"; ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-9 text-center text-white">
                                        <div style="padding: 10px 10px 10px 10px;">
                                            <h2><?php echo ($kurs_jisdor['STATUS'] == 1) ? "Sukses" : "Gagal"; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer" style="background-color:#337ab7">
                                <span class="pull-right" style="color:#fff"><?php echo $kurs_jisdor['CD_DATE'] ?></span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php foreach($data as $value) : ?>
                        <?php $status = ($value['STATUS'] == 1) ? 'Sukses' : 'Gagal'; ?>
                        <?php $tipe_job = ($value['TIPE_JOB'] == 'KOMP_ALPHA') ? 'Komponen Alpha' : 'Max Pemakaian'; ?>
                        <?php $date = date_create($value['CD_DATE']);
                              $date1 = date_format($date,"Y-m-d");
                              $last_update = ($date1 == date('Y-m-d')) ? '' : 'Last Update : '; 
                        ?>
                        <div class="col-md-3 col-md-6" id="pnl_hsd"><br>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="text-center">
                                                <?php echo $tipe_job; ?>
                                            </div>
                                        </div>
                                        <div class="col-xs-9 text-center text-white">
                                            <div style="padding: 10px 10px 10px 10px;">
                                                <h2><?php echo $status; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer" style="background-color:#337ab7">
                                    <span class="pull-right" style="color:#fff"><?php echo $last_update.$value['CD_DATE'] ?></span>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- /.row -->

              
            </div>

            <table class="table table-striped table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe Email</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Sukses</th>
                        <th>Gagal</th>
                        <th>Waktu Eksekusi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach($email as $data) : ?>
                    <?php 
                            $status = ($data['STATUS'] == 1) ? "Berhasil" : 'Gagal';
                            $str = $data['PESAN'];
                            preg_match_all('!\d+!', $str, $arr);
                            $total = $arr[0][0] + $arr[0][1];
                            $sukses = $arr[0][0];
                            $gagal = $arr[0][1];

                            $date = date('Y-m-d');
                            $date1 = date_create($data['CD_DATE']);
                            $format = date_format($date1,'Y-m-d');
                            if($date == $format) {
                                $cd_date = $data['CD_DATE'];
                            } else {
                                $cd_date = "<b>Last Update : </b>". $data['CD_DATE'];
                            }
                    ?>
                        <tr>
                            <td><?php echo $no++ ;?></td>
                            <td><?php echo $data['TIPE_JOB'] ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $sukses; ?></td>
                            <td><?php echo $gagal; ?></td>
                            <td><?php echo $cd_date ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div>&nbsp;</div>
                
            <div id="form-content" class="modal fade modal-xlarge">

            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    jQuery(function($) {

        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
        });

    });
</script>