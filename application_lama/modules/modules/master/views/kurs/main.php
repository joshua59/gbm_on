
<!-- /**
 * @module KURS
 * @author  RAKHMAT WIJAYANTO
 * @created at 07 NOVEMBER 2017
 * @modified at 07 OKTOBER 2017
 */ -->
 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div class="well-content no-search">
                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                            <table>
								<tr>
									<td colspan=2><label>Cari :</label>
									</td>
								</tr>
								<tr>
									<td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
									<td> &nbsp </td>
									<td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
								</tr>
							</table>
						<?php echo form_close(); ?>
                        </div>
                    </div> 
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                    <label for="lb_sho" id="ref" title="Klik untuk membuka link Referensi data"><i>(*Referensi data : www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx)</i></label>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="modal fade modal-xlarge"></div>
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

        $('#ref').click(function() {
            bootbox.confirm('Apakah yakin akan membuka link Referensi data ?', "Tidak", "Ya", function(e) {
              if(e){
                window.open('https://www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx', '_blank');
              }
            });
        });

        $('#button-get-kurs').click(function() {
            bootbox.confirm('Apakah yakin akan get kurs terbaru dari link Referensi data ?', "Tidak", "Ya", function(e) {
              if(e){
                get_kurs();
           
              }
            });
        });

        function get_kurs(){
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            $.ajax({
                type: "POST",
                url : "<?php echo base_url('master/kurs/get_jisdor'); ?>",
                success:function(response) {
                    var data = JSON.parse(response);

                    bootbox.hideAll();


                    var message = '';
                    
                    if (data[0]) {
                        icon = 'icon-ok-sign';
                        color = '#0072c6;';
                    } else {
                        icon = 'icon-remove-sign';
                        color = '#ac193d;';    
                    }

                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                    message += data[2];

                    bootbox.alert(message, function() {
                        load_table('#content_table', 1, '#ffilter');
                    });                      

                  // if (obj == "" || obj == null) {
                  //       bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                  // }
                      
                }        
            });
        }

    });
</script>