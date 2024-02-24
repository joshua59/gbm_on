<style type="text/css">
    ul.dashed{
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }

    ul.dashed > li {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }
   
    ul.dashed > li:before {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    } 
</style>
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
              
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="modal fade modal-xlarge"></div>
            </div>
            <div id ="index-content">
              <ul class="dashed">
                <li>(* Data yang tampil adalah data mops yang belum termasuk dalam Perhitungan Harga</li>
              </ul>                 
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