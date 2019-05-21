<?
$Color[0] = array("warning",",backgroundColor: '#f39c12',borderColor : '#f39c12'",'orange'); //ornage
$Color[1] = array("danger",",backgroundColor: '#f56954',borderColor : '#f56954'",'red'); /// red
$Color[2] = array("success",",backgroundColor: '#00a65a',borderColor : '#f00a65a'",'green');
$Color[3] = array("info",",backgroundColor: '#00c0ef',borderColor : '#00c0ef'",'aqua');
$Color[4] = array("primary",",backgroundColor: '#3c8dbc',borderColor : '#3c8dbc'",'blue');
$App = array();


?>

<div class="row">
  <div class="col-lg-4 col-md-6 col-xs-12">
    <?
      $SqlCalendarList = "SELECT ma.*,ma.sale_id as appsale_id,
                                 mc.cus_id,mc.cus_name,mc.cus_mobile,
                                 mo.branch_id,mo.order_detail,mo.sale_id as addorder_id,
                                 mb.branch_name
                          FROM mps_appointment ma
                          INNER JOIN mps_order mo ON (ma.order_id = mo.order_id)
                          INNER JOIN mps_customer mc ON (mo.cus_id = mc.cus_id)
                          INNER JOIN mps_branch mb ON (ma.branch_id = mb.branch_id)
                          WHERE (
                                  ma.app_date >= '".date("Y-m-d")."' AND
                                  ma.app_status = '1'
                                )
                          ORDER BY ma.app_date ASC";
    ?>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#view_timeline" data-toggle="tab">Que Job ( <?=select_num($SqlCalendarList);?> )</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="view_timeline">
          <div class="row">
            <div class="col-xs-12" style="padding:15px;">
              <?
              $SqlBranch = "SELECT *
                            FROM mps_branch
                            WHERE ( branch_status  = '1')
                            ORDER BY branch_name ASC;";
              if (select_num($SqlBranch)>0) { $i=0;
                foreach (select_tb($SqlBranch) as $value) {
                  $App[$i] = $Color[$i];
                  $App[$i][] = $value['branch_id'];
                  ?><span class="label label-<?=$App[$i][0];?>"><?=$value['branch_name'];?></span> <?
                  $i++;
                }
              }
              ?>
            </div>
            <div class="col-xs-12">
              <ul class="timeline timeline-inverse">
                <?
                  //echo $SqlCalendarList;
                  if (select_num($SqlCalendarList)>0) { $i=1;  $sum=0;   $old = '';
                    foreach (select_tb($SqlCalendarList) as $row) {
                      $new = $row['app_date'];
                      if($old==''){
                        ?><li class="time-label"> <span style="background:#ddd;color:#000;"> <?=date_engshot($row['app_date']);?> </span> </li><?
                        $old = $new;
                        $i=1;
                      }else{
                        if($old==$new){

                        }else{
                          ?><li class="time-label"> <span style="background:#ddd;color:#000;"> <?=date_engshot($row['app_date']);?> </span> </li><?
                          $i=1;
                        }
                        $old = $new;
                      }
                      ?>
                      <li><i class="fa fa-clock-o bg-<? foreach ($App as $key => $array) { if ($App[$key][3]==$row['branch_id']) { echo $App[$key][2];   } } ?>"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?=substr($row['app_time'],0,5);?></span>
                          <h3 class="timeline-header"><a class="click_view_booking" data-target="#click_view_booking" style="cursor:pointer;" id="<?=$row['order_id'];?>" data-toggle="modal" data-target="#"><?=$row['cus_name'];?></a></h3>
                          <div class="timeline-body">
                            <dt>Detail Appointment : </dt>
                            <dd  style="word-break: break-all;"><?=$row['app_detail'];?><br><span class="label label-default">By : <?=check_salename($row['appsale_id'])?></span></dd>
                            <br>
                            <dt>Detail Order : </dt>
                            <dd  style="word-break: break-all;"><?=$row['order_detail'];?><br><span class="label label-default">By : <?=check_salename($row['addorder_id'])?></span></dd>
                            <br>
                            <dt>Mobile</dt>
                            <dd  style="word-break: break-all;"><?=$row['cus_mobile'];?>
                              <div class="btn-group" style="float:right;">
                                <!--<button id="<?=$row['app_id'];?>" data-toggle="modal" class="btn btn-default btn-xs click_view_booking" data-target="#click_view_booking"><i class="fa fa-search"></i></button>-->
                                <button id="<?=$row['app_id'];?>" branch-id="<?=$row['branch_id'];?>" data-toggle="modal" class="btn btn-warning btn-xs click_change_appointment" data-target="#click_change_appointment"><i class="fa fa-pencil-square-o"></i></button>
                              </div>
                            </dd>
                          </div>
                        </div>
                      </li>
                      <?
                    }
                  }else {
                    ?>
                    <li><i class="fa fa-clock-o bg-default"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=date("H:i");?></span>
                        <h3 class="timeline-header"><a class="" style="cursor:pointer;" id="" data-toggle="modal" data-target="#">Empty</a></h3>
                        <div class="timeline-body">NO Job<br><br></div>
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

  <div class="col-lg-4 col-md-6 col-xs-12">
    <?
      $SqlCalendarList = "SELECT mc.cus_id,mc.cus_name,mc.cus_mobile,
                                 mo.*,
                                 mb.branch_name
                          FROM mps_order mo
                          INNER JOIN mps_customer mc ON (mo.cus_id = mc.cus_id)
                          INNER JOIN mps_branch mb ON (mo.branch_id = mb.branch_id)
                          WHERE (
                                  mo.order_status != '2' AND
                                  mo.order_id NOT IN ( SELECT order_id FROM mps_appointment )
                                )
                          ORDER BY mo.order_date ASC";
    ?>
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#view_timeline" data-toggle="tab">No Appointments ( <?=select_num($SqlCalendarList);?> )</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="view_timeline">
          <div class="row">
            <div class="col-xs-12" style="padding:15px;">
              <?

              $SqlBranch = "SELECT *
                            FROM mps_branch
                            WHERE ( branch_status  = '1')
                            ORDER BY branch_name ASC;";
              if (select_num($SqlBranch)>0) { $i=0;
                foreach (select_tb($SqlBranch) as $value) {
                  ?><span class="label label-<? foreach ($App as $key => $array) { if ($App[$key][3]==$value['branch_id']) { echo $App[$key][0];   } } ?>"><?=$value['branch_name'];?></span> <?
                }
              }
              ?>
            </div>
            <div class="col-xs-12">
              <ul class="timeline timeline-inverse">
                <?
                  if (select_num($SqlCalendarList)>0) { $i=1;  $sum=0;   $old = '';
                    foreach (select_tb($SqlCalendarList) as $row) {
                      $new = substr($row['order_date'],0,5);
                      if($old==''){
                        ?><li class="time-label"> <span style="background:#ddd;color:#000;"> <?=date_engshot($row['order_date']);?> </span> </li><?
                        $old = $new;
                        $i=1;
                      }else{
                        if($old==$new){

                        }else{
                          ?><li class="time-label"> <span style="background:#ddd;color:#000;"> <?=date_engshot($row['order_date']);?> </span> </li><?
                          $i=1;
                        }
                        $old = $new;
                      }
                      ?>
                      <li><i class="fa fa-clock-o bg-<? foreach ($App as $key => $array) { if ($App[$key][3]==$row['branch_id']) { echo $App[$key][2];   } } ?>"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> <?=substr($row['order_date'],11,5);?></span>
                          <h3 class="timeline-header"><a class="" style="cursor:pointer;" id="" data-toggle="modal" data-target="#"><?=$row['cus_name'];?></a></h3>
                          <div class="timeline-body" style="word-break: break-all;"><?=$row['order_detail'];?><br><br>
                            Mobile : <?=$row['cus_mobile'];?>
                            <!--<span class="label label-<? foreach ($App as $key => $array) { if ($App[$key][3]==$row['branch_id']) { echo $App[$key][0];   } } ?>" style="font-weight:bold;">Branch : <?=$row['branch_name'];?></span>-->
                            <div class="btn-group" style="float:right;">
                              <!--<button id="<?=$row['app_id'];?>" data-toggle="modal" class="btn btn-default btn-xs click_view_booking" data-target="#click_view_booking"><i class="fa fa-search"></i></button>-->
                              <button id="<?=$row['order_id'];?>" data-toggle="modal" class="btn btn-info btn-xs click_new_appointment" data-target="#click_new_appointment"><i class="fa fa-plus"></i></button>
                            </div>
                          </div>
                        </div>
                      </li>
                      <?
                    }
                  }else {
                    ?>
                    <li><i class="fa fa-clock-o bg-default"></i>
                      <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> <?=date("H:i");?></span>
                        <h3 class="timeline-header"><a class="" style="cursor:pointer;" id="" data-toggle="modal" data-target="#">Empty</a></h3>
                        <div class="timeline-body">NO Job<br><br></div>
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
