
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="google-site-verification" content="YhiSkFpqiRG1bg47XUim75_Xv2lbPt59fw2rYD8zhfA" />
  <title>MPS Service</title>
  <meta name="default" content="<?=$LinkHostWeb;?>" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <!--<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/bootstrap/dist/css/bootstrap.min.css">-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!--<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/font-awesome/css/font-awesome.min.css">-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/adminLTE/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/adminLTE/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/datatables.net-bs/css/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?=$LinkHostWeb;?>css/mps-style.css">

  <script src="<?=$LinkHostWeb;?>plugins/jquery/dist/jquery.min.js"></script>
  <!--<script src="<?=$LinkHostWeb;?>plugins/bootstrap/dist/js/bootstrap.min.js"></script>-->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="<?=$LinkHostWeb;?>plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?=$LinkHostWeb;?>plugins/fastclick/lib/fastclick.js"></script>
  <script src="<?=$LinkHostWeb;?>plugins/iCheck/icheck.min.js"></script>
  <script src="<?=$LinkHostWeb;?>plugins/select2/dist/js/select2.full.min.js"></script>
  <script src="<?=$LinkHostWeb;?>plugins/adminLTE/js/adminlte.min.js"></script>
  <script src="<?=$LinkHostWeb;?>plugins/adminLTE/js/demo.js"></script>



</head>
<body class=" <? if( $_COOKIE[$CookieID]=="" && $_SESSION[$SessionID]=="" ) { echo "hold-transition login-page"; }elseif( $_COOKIE[$CookieID]!="" && $_SESSION[$SessionID]=="" ) {   echo "hold-transition lockscreen";   }elseif( $_COOKIE[$CookieID]!="" && $_SESSION[$SessionID]!="" ){ echo "hold-transition skin-blue sidebar-mini"; } ?>">
<? if( $_COOKIE[$CookieID]=="" && $_SESSION[$SessionID]=="" ){ ?>
      <div class="login-box">
        <div class="login-logo">
          <img src="<?=$LinkHostWeb;?>images/Amed-home-logo.png" style="width:60px;height:auto;" alt="">
          <a href="#"><b>Sale</b> Report</a>
        </div>
        <div class="login-box-body">
          <p class="login-box-msg"><b>Sign in to your account</b></p>

            <form class="form-horizontal" style="padding:15px;" autocomplete="off">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Username" id="log_username" autocomplete="off">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" id="log_password" autocomplete="off">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <select class="form-control select2" id="log_branch" name="log_branch">
                  <?
                    $SqlBranch = "SELECT *
                                  FROM mps_branch
                                  ORDER BY branch_name ASC";
                    if (select_num($SqlBranch)>0) {
                      ?><option value="">Select Branch</option><?
                      foreach (select_tb($SqlBranch) as $row ) {
                        ?><option value="<?=$row['branch_id'];?>"><?=$row['branch_name'];?></option><?
                      }
                    }else {
                      ?><option value="">Not founds</option><?
                    }
                  ?>
                </select>
              </div>
              <div class="row">
                <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8" style="padding: 0px;">
                  <button type="button" class="btn btn-primary btn-block" id="login_submit">Sign In</button>
                </div>
                <div class="col-xs-12 show_popup"></div>
              </div>
            </form>


          <script>
            $(document).ready(function(e) {
                $("#log_username").focus();
                $("#log_username").keypress(function(e) {
                    if(e.which==13){
                        $("#log_password").focus();
                    }
                });
                $("#log_password").keypress(function(e) {
                    if(e.which==13){
                      if ($("#log_username").val() !="" && $("#log_password").val() !="" && $("#log_branch").val() !="") {
                        $.post("../../query/check-data.php",
                        {
                            _username :$("#log_username").val(),
                            _password :$("#log_password").val(),
                            _branch   :$("#log_branch").val(),
                            post :"login"
                        },
                        function(data){
                          var b = data.split('|||');
                          if (b[0]==1) {
                            $(".show_popup").html(b[1]);
                            setTimeout(function(data){
                              location.reload(true);
                            },2000);

                          }else {
                            $(".show_popup").html(b[1]);
                          }
                        });
                      }else {
                        $(".show_popup").html("<p class='text-center'><i class='fa fa-shield'></i> Please check data.</p>");
                      }
                    }
                });
                $("#login_submit").click(function(e) {
                  if ($("#log_username").val() !="" && $("#log_password").val() !="" && $("#log_branch").val() !="") {
                    $.post("../../query/check-data.php",
                    {
                        _username :$("#log_username").val(),
                        _password :$("#log_password").val(),
                        _branch   :$("#log_branch").val(),
                        post :"login"
                    },
                    function(data){
                      var b = data.split('|||');
                      if (b[0]==1) {
                        $(".show_popup").html(b[1]);
                        setTimeout(function(data){
                          location.reload(true);
                        },2000);
                        return true;

                      }else {
                        $(".show_popup").html(b[1]);
                      }
                    });
                  }else {
                    $(".show_popup").html("<p class='text-center'><i class='fa fa-shield'></i> Please check data.</p>");
                  }
                });
            });
          </script>




        </div>
      </div>
<? }elseif( $_COOKIE[$CookieID]!="" && $_SESSION[$SessionID]=="" ){ ?>
      <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
          <a><b>Sale</b> Report</a>
        </div>
        <!-- User name -->
        <div class="lockscreen-name"><?=base64url_decode($_COOKIE[$CookieName]);?></div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
          <!-- lockscreen image -->
          <div class="lockscreen-image">
            <img src="<?=$LinkHostWeb;?>images/avatar.png" alt="User Image">
          </div>
          <!-- /.lockscreen-image -->

          <!-- lockscreen credentials (contains the form) -->
          <form class="lockscreen-credentials" name="pForm">
            <div class="input-group">
              <input type="password" class="form-control" id="log_password" placeholder="password">
              <div class="input-group-btn">
                <button type="button" class="btn click_check"><i class="fa fa-arrow-right text-muted"></i></button>
              </div>
            </div>
          </form>
          <script>
            $(document).ready(function(e) {
                $('form[name=pForm]').submit(function(){
                  return false;
                });
                $("#log_password").focus();
                $(".click_check").click(function(e) {
                  if ( $("#log_password").val() !="") {
                    $.post("../../query/check-data.php",
                    {
                        _password :$("#log_password").val(),
                        post :"check_login"
                    },
                    function(data){
                      var b = data.split("|||");
                      if (b[0]==1) {
                        $(".show_popup").html(b[1]);
                        setTimeout(function(data){
                          location.reload(true);
                        },2000);
                        return true;

                      }else {
                        $(".show_popup").html(b[1]);
                        return false;
                      }
                    });
                  }
                });
                $("#log_password").keypress(function(e) {
                    if(e.which==13){
                      if ( $("#log_password").val() !="") {
                        $.post("../../query/check-data.php",
                        {
                            _password :$("#log_password").val(),
                            post :"check_login"
                        },
                        function(data){
                          var b = data.split("|||");
                          if (b[0]==1) {
                            $(".show_popup").html(b[1]);
                            setTimeout(function(data){
                              location.reload(true);
                            },2000);

                          }else {
                            $(".show_popup").html(b[1]);
                            return false;
                          }
                        });
                      }
                    }
                });
            });
          </script>
          <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
          Please insert Password.
        </div>
        <div class="text-center">
          <a style="cursor:pointer;" class="logout_system">Or New Login</a>
          <script>
            $(document).ready(function() {
              $(".logout_system").click(function(e) {
                $.post("../../query/check-data.php", { post :"clear_system" }, function(d){  location.reload(true); });
              });
            });
          </script>
        </div>
        <div class="show_popup" style="margin:10px 0;"> </div>
      </div>
<? }elseif( $_COOKIE[$CookieID]!="" && $_SESSION[$SessionID]!="" ){ ?>
      <div class="wrapper">

        <header class="main-header">
          <a href="<?=$LinkHostWeb;?>dashboard" class="logo">
            <span class="logo-mini"><b>M</b>PS</span>
            <span class="logo-lg"><b>MPS</b> Report</span>
          </a>
          <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?=$LinkHostWeb;?>images/avatar.png" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?=base64url_decode($_COOKIE[$CookieName]);?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="<?=$LinkHostWeb;?>images/avatar.png" class="img-circle" alt="User Image">
                      <p> <?=base64url_decode($_COOKIE[$CookieName]);?>
                        <small><?=base64url_decode($_COOKIE[$CookieGroup]);?></small>
                      </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="<?=SITE_URL;?>profile" class="btn btn-default btn-flat">Profile</a>
                      </div>
                      <div class="pull-right">
                        <button data-toggle="modal" data-target="#modal-signout"  class="btn btn-warning btn-flat">SignOut</button>
                      </div>
                    </li>
                  </ul>
                </li>

              </ul>
            </div>
          </nav>
        </header>
        <aside class="main-sidebar">
          <section class="sidebar">
            <div class="user-panel">
              <div class="pull-left image">
                <img src="<?=$LinkHostWeb;?>images/avatar.png" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                <p style="white-space: initial; text-overflow: ellipsis; max-width: 140px;"><?=base64url_decode($_COOKIE[$CookieName]);?></p>
                <a href="<?=$LinkHostWeb;?>#"><i class="fa fa-circle text-success"></i> <?=base64url_decode($_COOKIE[$CookieGroup]);?></a>
              </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">Main Menu</li>
              <li class="<?=$UrlPage=="dashboard"?"active":"";?>"><a href="<?=$LinkHostWeb;?>dashboard"><i class="fa fa-home"></i> <span> Dashboard</span></a></li>
              <li class="<?=$UrlPage=="profile"?"active":"";?>"><a href="<?=$LinkHostWeb;?>profile"><i class="fa fa-vcard-o"></i> <span> Profile</span></a></li>

              <li class="header">Menu list</li>
              <li class="<?=$UrlPage=="new-booking"?"active":"";?>"><a href="<?=$LinkHostWeb;?>new-booking"><i class="fa fa-plus-circle"></i> <span><span class="text-red"><b>New</b></span> Booking</span></a></li>

              <!--<li class="<?=$UrlPage=="view-booking"?"active":"";?>"><a href="<?=$LinkHostWeb;?>view-booking"><i class="fa fa-search"></i> <span> View Booking</span></a></li>-->
              <li class="treeview  <?=$UrlPage=="view-booking"||$UrlPage=="booking-complete"||$UrlPage=="booking-cancel"?"active":"";?>">
                <a href="#">
                  <i class="fa fa-search"></i>
                  <span>View Booking</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <?
                  $SqlBooking = "SELECT order_id FROM mps_order WHERE ( order_status = '0' )";
                  $SqlBookingChCalendar = "SELECT order_id FROM mps_order WHERE ( order_status = '0' AND order_id  NOT IN ( SELECT order_id FROM mps_appointment ))";
                  $SqlBookingComplete = "SELECT order_id FROM mps_order WHERE ( order_status = '1' )";
                  $SqlBookingCompleteCalendar = "SELECT order_id FROM mps_order WHERE ( order_status = '1' AND order_id  NOT IN ( SELECT order_id FROM mps_appointment ) )";
                  $SqlBookingCancel = "SELECT order_id FROM mps_order WHERE ( order_status = '2' )";
                ?>

                <ul class="treeview-menu">
                  <li class="<?=$UrlPage=="view-booking"?"active":"";?>">
                    <a href="<?=$LinkHostWeb;?>view-booking"><i class="fa fa-caret-right"></i> <span> View Booking</span>
                    <span class="pull-right-container">
                      <?
                        if (select_num($SqlBookingChCalendar)>0) {
                          ?><small class="label pull-right bg-red"><?=select_num($SqlBookingChCalendar);?></small><?
                        }
                        if (select_num($SqlBooking)>0) {
                          ?><small class="label pull-right bg-blue"><?=select_num($SqlBooking);?></small><?
                        }
                      ?>
                    </span>
                    </a>
                  </li>
                  <li class="<?=$UrlPage=="booking-complete"?"active":"";?>">
                    <a href="<?=$LinkHostWeb;?>booking-complete"><i class="fa fa-caret-right"></i> <span> Booking Complete</span>
                    <span class="pull-right-container">
                      <?
                        if (select_num($SqlBookingCompleteCalendar)>0) {
                          ?><small class="label pull-right bg-red"><?=select_num($SqlBookingCompleteCalendar);?></small><?
                        }
                        if (select_num($SqlBookingComplete)>0) {
                          ?><small class="label pull-right bg-green"><?=select_num($SqlBookingComplete);?></small><?
                        }
                      ?>
                    </span>
                    </a>
                  </li>
                  <li class="<?=$UrlPage=="booking-cancel"?"active":"";?>">
                    <a href="<?=$LinkHostWeb;?>booking-cancel"><i class="fa fa-caret-right"></i> <span> Booking Cancel</span>
                    <span class="pull-right-container">
                      <?
                        if (select_num($SqlBookingCancel)>0) {
                          ?><small class="label pull-right bg-red"><?=select_num($SqlBookingCancel);?></small><?
                        }
                      ?>
                    </span>
                    </a>
                  </li>
                </ul>
              </li>


              <li class="<?=$UrlPage=="calendar"?"active":"";?>">
                <a href="<?=$LinkHostWeb;?>calendar"><i class="fa fa-calendar"></i> <span> Calendar</span>
                  <span class="pull-right-container">
                  <?
                    $SqlCalendarListT = "SELECT ma.*,
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
                    if (select_num($SqlCalendarListT)>0) {
                      ?><small class="label pull-right bg-orange"><?=select_num($SqlCalendarListT);?></small><?
                    }
                  ?>
                  </span>
                </a>
              </li>
              <li class="<?=$UrlPage=="que-job"?"active":"";?>"><a href="<?=$LinkHostWeb;?>que-job"><i class="fa fa-list"></i> <span> QueJob</span></a></li>
              <li class="<?=$UrlPage=="plan-doctor"?"active":"";?>"><a href="<?=$LinkHostWeb;?>plan-doctor"><i class="fa fa-calendar-o"></i> <span> Doctor</span></a></li>

              <li class="treeview  <?=$UrlPage=="manage-doctor"||$UrlPage=="manage-user"||$UrlPage=="manage-promotion"||$UrlPage=="manage-branch"||$UrlPage=="manage-customer"||$UrlPage=="manage-type"||$UrlPage=="manage-course"?"active":"";?>">
                <a href="#">
                  <i class="fa fa-cogs"></i>
                  <span>Management</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?=$UrlPage=="manage-doctor"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-doctor"><i class="fa fa-caret-right"></i> <span> Doctor Plan</span></a></li>
                  <li class="<?=$UrlPage=="manage-user"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-user"><i class="fa fa-caret-right"></i> <span> User</span></a></li>
                  <li class="<?=$UrlPage=="manage-type"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-type"><i class="fa fa-caret-right"></i> <span> Type User</span></a></li>
                  <li class="<?=$UrlPage=="manage-course"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-course"><i class="fa fa-caret-right"></i> <span> Course</span></a></li>
                  <li class="<?=$UrlPage=="manage-promotion"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-promotion"><i class="fa fa-caret-right"></i> <span> Promotion</span></a></li>
                  <li class="<?=$UrlPage=="manage-branch"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-branch"><i class="fa fa-caret-right"></i> <span> Branch</span></a></li>
                  <li class="<?=$UrlPage=="manage-customer"?"active":"";?>"><a href="<?=$LinkHostWeb;?>manage-customer"><i class="fa fa-caret-right"></i> <span> Customer</span></a></li>
                </ul>
              </li>

              <li class="treeview  <?=$UrlPage=="report-total"||$UrlPage=="report-sale"?"active":"";?>">
                <a href="#">
                  <i class="fa fa-area-chart"></i>
                  <span>Report</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="<?=$UrlPage=="report-total"?"active":"";?>"><a href="<?=$LinkHostWeb;?>report-total"><i class="fa fa-caret-right"></i> <span> Report All</span></a></li>
                  <li class="<?=$UrlPage=="report-sale"?"active":"";?>"><a href="<?=$LinkHostWeb;?>report-sale"><i class="fa fa-caret-right"></i> <span> Report Sale</span></a></li>
                </ul>
              </li>

              <li style="border-top: solid 2px #212121;"><a style="cursor:pointer;" data-toggle="modal" data-target="#modal-signout"> <i class="fa fa-power-off"></i><span> SignOut</span></a></li>
            </ul>
          </section>
        </aside>
        <div class="content-wrapper">
          <section class="content-header">
            <h1><small><?=ucwords(str_replace("-"," ",$UrlPage));?></small></h1>
            <ol class="breadcrumb">
              <li>
                <a href="<?=SITE_URL;?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a>
                <?=$UrlPage!=""?" > <a href='".$LinkHostWeb."$UrlPage'> ".ucwords(str_replace("-"," ",$UrlPage))."</a>":"";?>
                <?=$UrlId!=""?" > <a href='".$LinkHostWeb."$UrlPage/$UrlId'> ".ucwords(str_replace("-"," ",$UrlId))."</a>":"";?>
                <?=$UrlIdSub!=""?" > <a href='".$LinkHostWeb."$UrlPage/$UrlId/$UrlIdSub'> ".ucwords(str_replace("-"," ",$UrlIdSub))."</a>":"";?>
              </li>
            </ol>
          </section>
          <section class="content">
            <?
              switch (trim($UrlPage)) {

                /// All
                case 'profile'            	:   include("view-profile.php");  			break;
                case 'dashboard'          	:   include("view-dashboard.php"); 	 		break;
                case 'calendar'             :   include("view-calendar.php"); 	 		break;

                /// Manange
                case 'manage-doctor'        :   include("manage-doctor.php"); 	 		break;
                case 'manage-user'          :   include("manage-user.php"); 	 		  break;
                case 'manage-course'        :   include("manage-course.php"); 	 		break;
                case 'manage-promotion'     :   include("manage-promotion.php"); 	 	break;
                case 'manage-branch'        :   include("manage-branch.php"); 	 		break;
                case 'manage-customer'      :   include("manage-customer.php"); 	 	break;
                case 'manage-type'          :   include("manage-type.php"); 	 		  break;


                /// order
                case 'new-booking'          :   include("view-new-order.php"); 	 		break;
                case 'view-booking'         :   include("view-booking.php"); 	 		  break;
                case 'booking-complete'     :   include("view-booking-complete.php");break;
                case 'booking-cancel'       :   include("view-booking-cancel.php"); break;

                case 'report-total'         :   include("view-report.php"); 	 		  break;
                case 'report-sale'          :   include("view-report-sale.php"); 	 	break;
                case 'que-job'              :   include("view-que-job.php"); 	 	    break;
                case 'plan-doctor'          :   include("view-doctor.php"); 	 	    break;



                default                    	:  include("view-dashboard.php"); 			break;
              }
            ?>
          </section>
        </div>

        <footer class="main-footer">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong><a href="#"></a> Sale Report</strong>
        </footer>




        <footer class="footer-mb visible-xs">
          <div class="container">
            <div class="row">
              <div class="col-xs-3">
                <a href="<?=$LinkHostWeb;?>dashboard">
                    <span class="fa fa-home <?=$UrlPage=="dashboard"?"text-blue":"";?>"></span>
                    <p class=" visible-xs ft-mb <?=$UrlPage=="dashboard"?"text-blue":"";?>">Dashboard</p>
                </a>
              </div>
              <div class="col-xs-3">
                <a href="<?=$LinkHostWeb;?>new-booking">
                    <span class="fa fa-plus-circle <?=$UrlPage=="new-booking"?"text-blue":"";?>"></span>
                    <p class=" visible-xs ft-mb <?=$UrlPage=="new-booking"?"text-blue":"";?>">New Booking</p>
                </a>
              </div>
              <div class="col-xs-3">
                <a href="<?=$LinkHostWeb;?>view-booking">
                    <span class="fa fa-list-alt <?=$UrlPage=="view-booking"?"text-blue":"";?>"></span>
                    <p class=" visible-xs ft-mb <?=$UrlPage=="view-booking"?"text-blue":"";?>">View</p>
                </a>
              </div>
              <div class="col-xs-3">
                <a href="<?=$LinkHostWeb;?>report-total">
                    <span class="fa fa-bar-chart-o <?=$UrlPage=="report-total"?"text-blue":"";?>"></span>
                    <p class=" visible-xs ft-mb <?=$UrlPage=="report-total"?"text-blue":"";?>">Report</p>
                </a>
              </div>
            </div>
          </div>
        </footer>


        <div class="control-sidebar-bg"></div>
      </div>








      <!-- View Booking -->
      <script>
          $(document).ready(function() {
            /// view and edit Customer
            $(".click_view_booking").click(function(event) {

              $.post("../../query/check-data.php",
              {
                _orderid : $(this).attr('id'),
                post : "View-Booking"
              },
              function(d){
                var i = d.split("|||");

                ///// Customer
                $("#VBRefCode").val(i[0]);
                $("#VBCusName").val(i[1]);
                $("#VBMobile").val(i[2]);
                $("#VBLINEID").val(i[3]);
                if (i[4]=='0') {
                  $("#VBGenderM").prop("checked",true);
                }else {
                  $("#VBGenderF").prop("checked",true);
                }
                $("#VBAge").val(i[5]);


                ///// Booking
                $("#VBOrderRef").val(i[6]);
                $("#VBJobID").val(i[7]);
                $("#VBBranch").val(i[8]);
                $("#VBPromotion").val(i[9]);
                $("#VBSaleref").val(i[10]);
                $("#VBTotal").val(i[11]);
                $("#VBOrderDetail").val(i[12]);

                ///// Appointment
                $("#VBAppointment").html(i[13]);

                ///// Payment
                $("#VBPayment").html(i[14]);

              });
            });
          });
      </script>
      <div id="click_view_booking" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">View Booking  #<label id="VBJobID"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <!-- Detail Customer --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Customer info</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Code Ref *</label>
                          <div class="col-sm-9">
                            <input type="hidden" id="ACCusId" name="ACCusId" value=""  />
                            <input type="text" class="form-control" placeholder="CustomerID Reference" id="VBRefCode" name="VBRefCode" readonly  />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Customer Name *</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Customer Name" id="VBCusName" name="VBCusName" readonly  />
                          </div>
                        </div>
                        <div class="form-group">
                           <label for="" class="col-sm-3 control-label">Mobile *</label>
                           <div class="col-sm-9">
                             <input type="text" class="form-control"  placeholder="Mobile Phone" id="VBMobile" name="VBMobile" readonly  />
                           </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">LINE ID *</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="LINE ID" id="VBLINEID" name="VBLINEID" readonly  />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Gender</label>
                          <div class="col-sm-9">
                            <div class="radio">
                              <label>
                                <input type="radio" name="VBGender" id="VBGenderM" value="0" checked=""> Male
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="VBGender" id="VBGenderF" value="1"> Female
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Age</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Age ex. 20" id="VBAge" name="VBAge" readonly />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Detail Customer -->

                  <!-- Appointment -->
                  <div class="col-md-12" style="padding-bottom:20px;" >
                    <h4 class="text-center">Appointment</h4><hr>
                    <div class="col-xs-12" id="VBAppointment"></div>
                  </div>
                  <!-- Appointment -->

                </div>
                <div class="col-md-6 col-sm-12">

                  <!-- Detail Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Customer Booking</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Order Ref.</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Order ID Reference" id="VBOrderRef" name="VBOrderRef" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Branch </label>
                          <div class="col-sm-9">
                            <select class="form-control" data-placeholder="Select Branch" id="VBBranch" name="VBBranch" style="width: 100%;" readonly>
                              <?
                                $SqlBranch = " SELECT branch_id,branch_name
                                               FROM mps_branch
                                               WHERE ( branch_status = '1' )
                                               ORDER BY branch_name ASC";
                                if (select_num($SqlBranch)>0) {
                                  ?><option>Select Branch</option><?
                                  foreach (select_tb($SqlBranch) as $row) {
                                    ?><option value="<?=$row['branch_id'];?>"><?=$row['branch_name'];?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Promotion</label>
                          <div class="col-sm-9">
                            <select class="form-control" data-placeholder="Select Promotion" id="VBPromotion" name="VBPromotion" style="width: 100%;" readonly>
                              <?
                                $SqlPromotion = "SELECT pro_id,pro_name
                                                 FROM mps_promotion
                                                 ORDER BY pro_name ASC";
                                if (select_num($SqlPromotion)>0) {
                                  ?><option>Select Promotion</option><?
                                  foreach (select_tb($SqlPromotion) as $row) {
                                    ?><option value="<?=$row['pro_id'];?>"><?=$row['pro_name'];?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Sale</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Sale" id="VBSaleref" name="VBSaleref" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Total Amount</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="ex. 20000" id="VBTotal" name="VBTotal" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">OrderDetail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Detail" rows="4" id="VBOrderDetail" name="VBOrderDetail" readonly></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Detail Booking -->

                  <!-- Payment -->
                  <div class="col-md-12" style="padding-bottom:20px;" >
                    <h4 class="text-center">Step Payment</h4><hr>
                    <div class="col-xs-12" id="VBPayment"></div>
                    <!--<ul class="timeline timeline-inverse" id="TimeLinePayment" >

                      <li><i class="fa fa-check  bg-green" aria-hidden="true"></i>
                       <div class="timeline-item">
                         <div class="panel box box-primary" style="margin-bottom:0px;">
                           <div class="box-header with-border">
                             <h4 class="box-title">
                               <a data-toggle="collapse" data-parent="#TimeLinePayment" href="#collOne1-a" aria-expanded="false" class="collapsed">05-May-2019</a>
                             </h4>
                           </div>
                           <div id="collOne1-a" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                             <div class="box-body" style="background: #f0f0f0;">
                                 <div class="timeline-body">
                                   <dl class="dl">
                                     <dt>Pay Amount</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">2,000</dd>
                                     <dt>Receipt By</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">admin</dd>
                                     <dt>Pay Date<dd style="margin-bottom:20px;">05-May-2019 16:19:34</dd>
                                 </div>
                             </div>
                           </div>
                         </div>
                       </div>
                      </li>
                      <li><i class="fa fa-check  bg-green" aria-hidden="true"></i>
                       <div class="timeline-item">
                         <div class="panel box box-primary" style="margin-bottom:0px;">
                           <div class="box-header with-border">
                             <h4 class="box-title">
                               <a data-toggle="collapse" data-parent="#TimeLinePayment" href="#collOne2-a" aria-expanded="false" class="collapsed">20-May-2019</a>
                             </h4>
                           </div>
                           <div id="collOne2-a" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                             <div class="box-body" style="background: #f0f0f0;">
                                 <div class="timeline-body">
                                   <dl class="dl">
                                     <dt>Pay Amount</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">4,400</dd>
                                     <dt>Receipt By</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">admin</dd>
                                     <dt>Pay Date<dd style="margin-bottom:20px;">20-May-2019 16:19:34</dd>
                                 </div>
                             </div>
                           </div>
                         </div>
                       </div>
                      </li>


                    </ul>-->
                  </div>
                  <!-- Payment -->

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!-- View Booking -->

      <!--- payment -->
      <div id="click_payment" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Payment  #<label id="VBjobrunid"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-sm-12">

                  <!-- Detail Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Customer Booking</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Order Ref.</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Order ID Reference" id="ACOrderRef" name="ACOrderRef" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Promotion</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Promotion" id="ACPromotion" name="ACPromotion" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Sale</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Sale" id="ACSaleref" name="ACSaleref" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Total Amount</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="ex. 20000" id="ACTotal" name="ACTotal" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">OrderDetail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Detail" rows="4" id="ACOrderDetail" name="ACOrderDetail" readonly></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Detail Booking -->

                  <!-- Payment -->
                  <div class="col-md-12" style="padding-bottom:20px;" >
                    <h4 class="text-center">Step Payment</h4><hr>
                    <ul class="timeline timeline-inverse" id="TimeLinePaymentPay" >

                      <li><i class="fa fa-check  bg-green" aria-hidden="true"></i>
                       <div class="timeline-item">
                         <div class="panel box box-primary" style="margin-bottom:0px;">
                           <div class="box-header with-border">
                             <h4 class="box-title">
                               <a data-toggle="collapse" data-parent="#TimeLinePaymentPay" href="#collPay1-a" aria-expanded="false" class="collapsed">05-May-2019</a>
                             </h4>
                           </div>
                           <div id="collPay1-a" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                             <div class="box-body" style="background: #f0f0f0;">
                                 <div class="timeline-body">
                                   <dl class="dl">
                                     <dt>Pay Amount</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">2,000</dd>
                                     <dt>Receipt By</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">admin</dd>
                                     <dt>Pay Date<dd style="margin-bottom:20px;">05-May-2019 16:19:34</dd>
                                 </div>
                             </div>
                           </div>
                         </div>
                       </div>
                      </li>
                      <li><i class="fa fa-check  bg-green" aria-hidden="true"></i>
                       <div class="timeline-item">
                         <div class="panel box box-primary" style="margin-bottom:0px;">
                           <div class="box-header with-border">
                             <h4 class="box-title">
                               <a data-toggle="collapse" data-parent="#TimeLinePaymentPay" href="#collPay2-a" aria-expanded="false" class="collapsed">20-May-2019</a>
                             </h4>
                           </div>
                           <div id="collPay2-a" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                             <div class="box-body" style="background: #f0f0f0;">
                                 <div class="timeline-body">
                                   <dl class="dl">
                                     <dt>Pay Amount</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">4,400</dd>
                                     <dt>Receipt By</dt>
                                     <dd style="word-break: break-all;margin-bottom:20px;">admin</dd>
                                     <dt>Pay Date<dd style="margin-bottom:20px;">20-May-2019 16:19:34</dd>
                                 </div>
                             </div>
                           </div>
                         </div>
                       </div>
                      </li>


                    </ul>
                  </div>
                  <!-- Payment -->

                </div>
                <div class="col-md-6 col-sm-12">

                  <!-- Payment income  --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Payment Income</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Total Amount</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Total Amount" id="ACOrderRef" name="ACOrderRef" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Overdue</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Overdue" id="ACPromotion" name="ACPromotion" readonly />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Payment<span style='color:red'>*</span></label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Payment" id="ACSaleref" name="ACSaleref" required />
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Payment income  -->


                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Confirm</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!--- payment -->

      <!--- Edit Booking -->
      <div id="click_edit_booking" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update Booking  #<label id="VBjobrunid"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">

                  <!-- Detail Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Customer Booking</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Order Ref.</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Order ID Reference" id="ACOrderRef" name="ACOrderRef" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Promotion</label>
                          <div class="col-sm-9">
                            <select class="form-control select2" data-placeholder="Select Promotion" id="ACPromotion" name="ACPromotion" style="width: 100%;">
                              <?
                                $SqlPromotion = "SELECT pro_id,pro_name
                                                 FROM mps_promotion
                                                 ORDER BY pro_name ASC";
                                if (select_num($SqlPromotion)>0) {
                                  ?><option>Select Promotion</option><?
                                  foreach (select_tb($SqlPromotion) as $row) {
                                    ?><option value="<?=$row['pro_id'];?>"><?=$row['pro_name'];?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Sale</label>
                          <div class="col-sm-9">
                            <select class="form-control selectmultiple" multiple="multiple" id="ACSaleref" name="ACSaleref[]" data-placeholder="Select Sale" style="width: 100%;" required>
                              <?
                                $SqlSale =  "SELECT ms.sale_id,ms.sale_name,mt.type_name
                                             FROM mps_sale ms
                                             INNER JOIN mps_type mt ON ( ms.type_id = mt.type_id )
                                             WHERE (
                                                      ms.sale_status = '1' AND
                                                      ms.type_id != '3'
                                                    )
                                             ORDER BY ms.sale_name ASC";
                                if (select_num($SqlSale)>0) {
                                  ?><option value="">Select Sale</option><?
                                  foreach (select_tb($SqlSale) as $row) {
                                    ?><option value="<?=$row['sale_id'];?>"><?=$row['sale_name']." (".$row[type_name].")";?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Total Amount</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="ex. 20000" id="ACTotal" name="ACTotal" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">OrderDetail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Detail" rows="4" id="ACOrderDetail" name="ACOrderDetail"></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Detail Booking -->

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!--- Edit Booking -->

      <!--- Change Booking -->
      <div id="click_change_booking" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Change Order  #<label id="VBjobrunid"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">
                <div class="col-md-12 col-sm-12">

                  <!-- Change Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <h4 class="text-center">Confirm Booking</h4><hr>
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Confirm Order</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="">
                              <option value="">Select Confirm Order</option>
                              <option value="1">Complete Order</option>
                              <option value="2">Cancel Order</option>
                              <!--<option value="0">In Booking</option>-->
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Remark Order</label>
                          <div class="col-sm-9">
                            <textarea name="name" class="form-control" placeholder="Remark"></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Change Booking -->

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Confirm</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!--- Change Booking -->

      <!-- JOb Delete -->
      <script>
        $(document).ready(function(e) {
            $(".click_delete_job").click(function(e) {
                $(".btn_delete_job_submit").attr('id',$(this).attr('id'));
            });
            $(".btn_delete_job_submit").click(function(event) {
              $.post("../../../query/checkdata.php",
              {
                _job_id : $(this).attr("id"),
                post      : "delete_order"
              },function(d){
                var i = d.split("|||");
                if (i[0]=='C') {
                  $("#show_log_approve").html(i[1]);
                  setTimeout(function(){
                    window.location.href = "<?=$LinkPath;?>";
                  },2000);
                }else {
                  $("#show_log_approve").html(d);
                }
              });
            });
        });
      </script>
      <div id="click_delete_booking" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header" style="color: white;background-color: #f00;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash" aria-hidden="true" style="color:#fff;"></i> Delete</h4>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group" style="text-align: center; margin: 0;">
                  <div class="control-label" id="show_log_approve" style="padding:25px 0;">Are you Sure?</div>
                </div>
              </form>
            </div>
            <div class="modal-footer" style="background-color: white; text-align: center;">
              <button type="button" style="width: 48%;" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" style="width: 48%;" class="btn btn-cancel btn_delete_job_submit" id="">Confirm</button>
            </div>
          </div>
        </div>
      </div>
      <!-- JOb Delete -->





      <!--- New Appointment -->
      <script>
        $(document).ready(function() {

          $(".click_new_appointment").click(function(event) {
            $(".click_confirm_appointment").attr("id",$(this).attr("id"));
          });

          $(".click_confirm_appointment").click(function(event) {
            if ( $("#NABranch").val() != "" && $("#NADate").val() != "" && $("#NBTime").val() != "" && $("#NBDetail").val() != "" ) {
              $.post("../../query/check-data.php",
              {
                _orderid : $(this).attr("id"),
                _date : $("#NADate").val(),
                _time : $("#NBTime").val(),
                _branch : $("#NABranch").val(),
                _detail : $("#NBDetail").val(),
                post : "New-Appointment"
              },
              function(d){
                var i = d.split("|||");
                if (i[0]=="C") {
                  $(".NAShowPop").html(i[1]);
                  setTimeout(function(){
                    window.location.href = "<?=$LinkPath;?>";
                  },2000);
                }else {
                  $(".NAShowPop").html(d);
                }
              });
            }else {
              $(".NAShowPop").html("<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-warning'></i> Alert!</h4> Please insert value.</div>");
            }
          });

        });
      </script>
      <div id="click_new_appointment" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> New Appointment  #<label id="VBjobrunid"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">

                  <!-- Detail Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Branch</label>
                          <div class="col-sm-9">
                            <select class="form-control select2" data-placeholder="Select Branch" id="NABranch" name="NABranch" style="width: 100%;">
                              <?
                                $SqlBranch = " SELECT branch_id,branch_name
                                               FROM mps_branch
                                               WHERE ( branch_status = '1' )
                                               ORDER BY branch_name ASC";
                                if (select_num($SqlBranch)>0) {
                                  ?><option>Select Branch</option><?
                                  foreach (select_tb($SqlBranch) as $row) {
                                    ?><option value="<?=$row['branch_id'];?>"><?=$row['branch_name'];?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Date</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  minDate="<?=date("Y-m-d");?>" placeholder="Date" id="NBDate" name="NBDate" data-date-format="yyyy-mm-dd"  />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Time</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="NBTime" name="NBTime" data-inputmask="'alias': 'time'" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Detail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control"  placeholder="Detail...." id="NBDetail" name="NBDetail"  ></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-xs-12 NAShowPop"></div>
                  <!-- Detail Booking -->

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary click_confirm_appointment" id="">Confirm</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!--- New Appointment -->


      <!--- Change Appointment -->
      <div id="click_change_appointment" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Change Appointment  #<label id="VBjobrunid"></label></h4>
            </div>

            <div class="modal-body">
              <div class="row">

                  <!-- Detail Booking --->
                  <div class="col-md-12" style="padding-bottom:20px;">
                    <form class="form-horizontal">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Branch</label>
                          <div class="col-sm-9">
                            <select class="form-control select2" data-placeholder="Select Branch" id="" name="" style="width: 100%;">
                              <?
                                $SqlBranch = " SELECT branch_id,branch_name
                                               FROM mps_branch
                                               WHERE ( branch_status = '1' )
                                               ORDER BY branch_name ASC";
                                if (select_num($SqlBranch)>0) {
                                  ?><option>Select Branch</option><?
                                  foreach (select_tb($SqlBranch) as $row) {
                                    ?><option value="<?=$row['branch_id'];?>"><?=$row['branch_name'];?></option><?
                                  }
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Date</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Date" id="" name="" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Time</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="Time" id="" name="" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Detail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control"  placeholder="Detail...." id="" name="" required ></textarea>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Detail Booking -->

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <!--- Change Appointment -->





      <!-- SignOut   -->
      <script>
        $(document).ready(function() {
          $(".logout_system").click(function(e) {
            $.post("../../query/check-data.php", { post :"clear_system" }, function(d){  location.reload(true); });
          });
        });
      </script>
      <div class="modal fade" id="modal-signout" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-body confirm-popup">
              <form>
                <div class="form-group">
                  <div class="text-center" id="show_log_approve" style="padding:25px 0;">Are you Logout ?</div>
                </div>
              </form>
            </div>
            <div class="modal-footer" style="background-color: white; text-align: center;">
              <button type="button" style="width: 48%;float:left;" class="btn btn-default" data-dismiss="modal" id="">Cancel</button>
              <button type="button" style="width: 48%;float:right;" class="btn btn-danger logout_system" id="">Confirm</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end  SignOut  -->


      <!-- bootstrap datepicker -->
      <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
      <script src="<?=$LinkHostWeb;?>plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
      <link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/timepicker/bootstrap-timepicker.min.css">
      <script src="<?=$LinkHostWeb;?>plugins/timepicker/bootstrap-timepicker.min.js"></script>

      <!-- InputMask -->
      <script src="<?=$LinkHostWeb;?>plugins/input-mask/jquery.inputmask.js"></script>
      <script src="<?=$LinkHostWeb;?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
      <script src="<?=$LinkHostWeb;?>plugins/input-mask/jquery.inputmask.extensions.js"></script>

      <script>
        $(function () {

          //Date picker
          $('#NBDate').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            startDate: '1'
          });

          // Initialize InputMask
          $("#NBTime").inputmask({inputFormat : 'HH:mm'});

        });
      </script>



<? } ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>
