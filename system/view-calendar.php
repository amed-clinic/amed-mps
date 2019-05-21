<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/fullcalendar/dist/fullcalendar.min.css">
<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/fullcalendar/dist/fullcalendar.print.min.css" media='print'>

<?
  $Color[0] = array("warning",",backgroundColor: '#f39c12',borderColor : '#f39c12'",'orange'); //ornage
  $Color[1] = array("danger",",backgroundColor: '#f56954',borderColor : '#f56954'",'red'); /// red
  $Color[2] = array("success",",backgroundColor: '#00a65a',borderColor : '#f00a65a'",'green');
  $Color[3] = array("info",",backgroundColor: '#00c0ef',borderColor : '#00c0ef'",'aqua');
  $Color[4] = array("primary",",backgroundColor: '#3c8dbc',borderColor : '#3c8dbc'",'blue');
  $App = array();
?>

<div class="row">
  <div class="col-lg-8 col-md-12 col-xs-12">
    <div class="nav-tabs-custom">
      <div class="tab-content">
        <div class="active tab-pane" id="view_calendar">

          <div class="">
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
              //print_r($App);
            ?>
          </div>

          <div id="calendar_view"></div>
          <script>
            $(document).ready(function() {

              $('#calendar_view').fullCalendar({
                header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek'//,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: '<?=date("Y-m-d");?>',
                navLinks: false, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: [

                        <?
                          $SqlCalendar = "SELECT ma.*,
                                                 mc.cus_id,mc.cus_name
                                          FROM mps_appointment ma
                                          INNER JOIN mps_order mo ON (ma.order_id = mo.order_id)
                                          INNER JOIN mps_customer mc ON (mo.cus_id = mc.cus_id)
                                          WHERE ( ma.app_status = '1' )
                                          ORDER BY ma.app_date ASC,ma.app_time ASC";
                          if (select_num($SqlCalendar)>0) { $i =0;
                            foreach (select_tb($SqlCalendar) as $value) {
                              if ($i==0) {
                                $Events = " {
                                              order_id       : '".$value['order_id']."',
                                              title          : '".$value['cus_name']."',
                                              start          : '".$value['app_date']."T".$value['app_time']."'";


                                foreach ($App as $key => $array) {
                                  if ($App[$key][3]==$value['branch_id']) {
                                      $Events .= $App[$key][1];
                                  }
                                }
                                $Events .= " }";
                              }else {
                                $Events .= " ,{
                                              order_id       : '".$value['order_id']."',
                                              title          : '".$value['cus_name']."',
                                              start          : '".$value['app_date']."T".$value['app_time']."'";
                                foreach ($App as $key => $array) {
                                  if ($App[$key][3]==$value['branch_id']) {
                                      $Events .= $App[$key][1];
                                  }
                                }
                                $Events .= " }";
                              }
                              $i++;
                            }
                            echo $Events;
                          }
                        ?>
                        ],
                eventClick: function(calEvent, jsEvent, view) {
                  /*
                  if (calEvent.type == 'Job') {
                    $.post("../../query/checkdata.php",
                    {
                      _job_id : calEvent.jobid,
                      post  : "job_view"
                    },
                    function(d) {
                      var i = d.split("|||");
                      $("#oj_CompanyName").val(i[0]);
                      $("#oj_Address").val(i[1]);
                      $("#oj_Province").val(i[2]);
                      $("#oj_AmphurProvince").html(i[3]);
                      $("#oj_DistrictProvince").html(i[4]);
                      $("#oj_CodeProvince").val(i[5]);
                      $("#oj_Telephone").val(i[6]);
                      $("#oj_LINEID").val(i[7]);
                      $("#oj_Fax").val(i[8]);
                      $("#oj_CID").val(i[9]);
                      $("#oj_SaleJob").html(i[10]);
                      $("#oj_remark").val(i[11]);
                      $("#oj_detail").html(i[12]);
                      $("#oj_strdate").html(i[13]);
                      $("#oj_technical").html(i[14]);
                      $("#oj_add").html(i[15]);
                      $("#accordion_V").html(i[16]);
                      $("#oj_InstallAddress").val(i[17]);
                      $("#oj_jobrunid").html(i[20]);
                    });
                    $('#click_view_job').modal();
                  }else {
                    $(".chkCall_dataCompany").html(calEvent.title);
                    $(".SubmitSaveforCheckCall").attr("id",calEvent.jobid);
                    $('#click_update_check_call').modal();
                  }*/
                  $('#click_view_booking').modal();
                }
              });

            });
          </script>
          <style>
            .fc-title{ cursor: pointer;}
          </style>




        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12 col-xs-12">
    <div class="col-lg-12 col-md-6 col-sm-12">
      <!--- Not Appointment -->
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
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">No Appointments ( <?=select_num($SqlCalendarList);?> )</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="active tab-pane">
                <div class="row">
                  <div class="col-xs-12">
                    <ul class="timeline timeline-inverse">
                      <?
                        if (select_num($SqlCalendarList)>0) { $i=1;  $sum=0;   $old = '';
                          foreach (select_tb($SqlCalendarList) as $row) {
                            $new = substr($row['order_date'],0,10);
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
                                <h3 class="timeline-header"><a class="click_view_booking" style="cursor:pointer;" id="<?=$row['order_id'];?>" data-toggle="modal" data-target="#click_view_booking"><?=$row['cus_name'];?></a></h3>
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
        <div class="box-footer text-center">
          <a href="<?=$LinkWeb;?>que-job" >View all</a>
        </div>
      </div>
      <!--- Not Appointment -->
    </div>
    <div class="col-lg-12 col-md-6 col-sm-12">
      <!-- QueJob -->
      <?
        $SqlCalendarList = "SELECT ma.*,
                                   mc.cus_id,mc.cus_name,mc.cus_mobile,
                                   mb.branch_name
                            FROM mps_appointment ma
                            INNER JOIN mps_order mo ON (ma.order_id = mo.order_id)
                            INNER JOIN mps_customer mc ON (mo.cus_id = mc.cus_id)
                            INNER JOIN mps_branch mb ON (ma.branch_id = mb.branch_id)
                            WHERE (
                                    ma.app_date = '".date("Y-m-d")."'AND
                                    ma.app_status = '1'
                                  )
                            ORDER BY ma.app_date ASC";
      ?>
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Que Today ( <?=select_num($SqlCalendarList);?> )</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
          </div>
        </div>
        <div class="box-body">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="active tab-pane" id="view_timeline">
                <div class="row">
                  <div class="col-xs-12">
                    <ul class="timeline timeline-inverse">
                      <?
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
                                <h3 class="timeline-header"><a class="click_view_booking" style="cursor:pointer;" id="<?=$row['order_id'];?>" data-toggle="modal" data-target="#click_view_booking"><?=$row['cus_name'];?></a></h3>
                                <div class="timeline-body"  style="word-break: break-all;"><?=$row['app_detail'];?><br><br>
                                  Mobile : <?=$row['cus_mobile'];?>
                                  <!--<span class="label label-<? foreach ($App as $key => $array) { if ($App[$key][3]==$row['branch_id']) { echo $App[$key][0];   } } ?>" style="font-weight:bold;">Branch : <?=$row['branch_name'];?></span>-->
                                  <div class="btn-group" style="float:right;">
                                    <!--<button id="<?=$row['app_id'];?>" data-toggle="modal" class="btn btn-default btn-xs click_view_booking" data-target="#click_view_booking"><i class="fa fa-search"></i></button>-->
                                    <button id="<?=$row['app_id'];?>" data-toggle="modal" class="btn btn-warning btn-xs click_change_appointment" data-target="#click_change_appointment"><i class="fa fa-pencil-square-o"></i></button>
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
        <div class="box-footer text-center">
          <a href="<?=$LinkWeb;?>que-job" >View all</a>
        </div>
      </div>
      <!-- QueJob -->
    </div>
  </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.js"></script>
