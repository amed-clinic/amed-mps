<div class="row">
  <div class="col-lg-4 col-md-6 col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#view_timeline" data-toggle="tab">Schedule Plan Doctor</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="view_timeline">
          <div class="row">
            <div class="col-xs-12">
              <ul class="timeline timeline-inverse">
                <?

                  $sql = "SELECT *
                          FROM mps_plan_doctor
                          ORDER BY doc_upload_date DESC;";
                  if (select_num($sql)>0) { $new="";$old=""; $i=1;
                    foreach (select_tb($sql) as $row) {
                      $new = substr($row['doc_upload_date'],0,10);
                      if($old==''){
                        ?><li class="time-label"> <span class="bg-blue"> <?=date_engshot($row['doc_upload_date']);?> </span> </li><?
                        $old = $new;
                        $i=1;
                      }else{
                        if($old==$new){

                        }else{
                          ?><li class="time-label"> <span class="bg-blue"> <?=date_engshot($row['doc_upload_date']);?> </span> </li><?
                          $i=1;
                        }
                        $old = $new;
                      }
                      ?>
                      <li><i class="fa fa-newspaper-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?=substr($row['doc_upload_date'],11);?></span>
                          <h3 class="timeline-header"><?=$row['doc_name'];?></h3>
                          <div class="timeline-body">
                            <?=$row['doc_detail'];?>
                          </div>
                          <div class="timeline-footer">
                            <a href="<?=$LinkWeb;?>query/download-file.php?file=<?=$row['doc_file'];?>" target="_blank" class=" btn btn-success btn-sm" id="<?=$row['doc_id'];?>" >
                                <i class="fa fa-download" aria-hidden="true"></i> Download
                            </a>
                          </div>
                        </div>
                      </li>
                      <?
                    }
                  }else {
                    ?>
                    <li class="time-label"> <span class="bg-blue"> <?=date_engshot(date("Y-m-d"));?> </span> </li>
                    <li><i class="fa fa-newspaper-o bg-blue"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=substr(date("Y-m-d H:i:s"),11);?></span>
                        <h3 class="timeline-header">No Data</h3>
                        <div class="timeline-body">
                          There is no data.
                        </div>
                      </div>
                    </li>
                    <?
                  }
                ?>

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.js"></script>
