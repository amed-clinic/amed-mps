
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
          <a href="#"><b>Sale</b> Report</a>
        </div>
        <div class="login-box-body">
          <p class="login-box-msg"><b>Sign in to your account</b></p>

            <form class="form-horizontal">
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
                <div class="col-md-4 col-md-offset-8 col-sm-4 col-sm-offset-8">
                  <button type="button" class="btn btn-default btn-block" id="login_submit">Sign In</button>
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
                <a href="<?=$LinkWeb;?>#"><i class="fa fa-circle text-success"></i> <?=base64url_decode($_COOKIE[$CookieGroup]);?></a>
              </div>
            </div>

            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">Main Menu</li>
              <li class="<?=$UrlPage=="dashboard"?"active":"";?>"><a href="<?=$LinkWeb;?>dashboard"><i class="fa fa-home"></i> <span> Dashboard</span></a></li>
              <li class="<?=$UrlPage=="profile"?"active":"";?>"><a href="<?=$LinkWeb;?>profile"><i class="fa fa-vcard-o"></i> <span> Profile</span></a></li>

              <li class="header">Menu list</li>
              <li class="<?=$UrlPage=="new-order"?"active":"";?>"><a href="<?=$LinkWeb;?>new-order"><i class="fa fa-plus"></i> <span><span class="text-red"><b>New</b></span> Order</span></a></li>
              <li class="<?=$UrlPage=="view-order"?"active":"";?>"><a href="<?=$LinkWeb;?>view-order"><i class="fa fa-search"></i> <span> View Order</span></a></li>
              <li class="<?=$UrlPage=="calendar"?"active":"";?>"><a href="<?=$LinkWeb;?>calendar"><i class="fa fa-calendar"></i> <span> Calendar</span></a></li>

              <li style="border-top: solid 2px #212121;"><a style="cursor:pointer;" data-toggle="modal" data-target="#modal-signout"> <i class="fa fa-power-off"></i><span> SignOut</span></a></li>
            </ul>
          </section>
        </aside>
        <div class="content-wrapper">

            <?
              switch (trim($UrlPage)) {

                /// All
                case 'profile'            	:   include("view-profile.php");  			break;
                case 'dashboard'          	:   include("view-dashboard.php"); 	 		break;

                /// order
                case 'new-order'          	:   include("view-new-order.php"); 	 		break;
                case 'view-order'          	:   include("view-order.php"); 	 		    break;



                default                    	:  include("view-dashboard.php"); 			break;
              }
            ?>

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
              <div class="col-xs-4">
                <a href="<?=$LinkWeb;?>dashboard">
                    <span class="fa fa-home text-red"></span>
                    <p class=" visible-xs ft-mb">Dashboard</p>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="<?=$LinkWeb;?>new-order">
                    <span class="fa fa-check-square-o"></span>
                    <p class=" visible-xs ft-mb">New Order</p>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="<?=$LinkWeb;?>report">
                    <span class="fa fa-list-alt"></span>
                    <p class=" visible-xs ft-mb">History</p>
                </a>
              </div>
            </div>
          </div>
        </footer>


        <div class="control-sidebar-bg"></div>
      </div>


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
                  <div class="text-center" id="show_log_approve" style="padding:25px 0;">คุณต้องการออกจากระบบ ?</div>
                </div>
              </form>
            </div>
            <div class="modal-footer" style="background-color: white; text-align: center;">
              <button type="button" style="width: 48%;float:left;" class="btn btn-default" data-dismiss="modal" id="">ยกเลิก</button>
              <button type="button" style="width: 48%;float:right;" class="btn btn-default logout_system" id="">ตกลง</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end  SignOut  -->
<? } ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>
