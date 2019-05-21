<?
require_once ("../config/config.php");

/// clear session and cookie for system
if ($_POST['post']=="clear_system") {
  setcookie($CookieID, null, -1,'/');
  setcookie($CookieName, null, -1,'/');
  setcookie($CookieType, null, -1,'/');
  setcookie($CookieBranch, null, -1,'/');

  unset($_COOKIE[$CookieID]);
  unset($_COOKIE[$CookieName]);
  unset($_COOKIE[$CookieType]);
  unset($_COOKIE[$CookieBranch]);

  session_unset();
  session_destroy();
}
/// Login for system
if ($_POST['post']=="login") {
  $sql = "SELECT ml.*,ms.*
          FROM mps_login ml
          LEFT OUTER JOIN mps_sale ms ON ( ml.sale_id = ms.sale_id )
          WHERE  (
                   ml.login_username  = '".$_POST['_username']."' AND
                   ml.login_password_encode = '".base64url_encode($_POST['_password'])."' AND
                   ms.branch_id = '".$_POST['_branch']."' AND
                   ml.login_status = '1'
                 ) ;";
  if (select_num($sql)>0) {
    foreach (select_tb($sql) as $row) {
      if ($row['type_login']=='1') {
        $_SESSION[$SessinGroup] = base64url_encode("Admin");
      }else {
        $_SESSION[$SessinGroup] = base64url_encode("Sale");
      }

      $_SESSION[$SessionID] = base64url_encode($row['login_id']);
      $_SESSION[$SessionName] = base64url_encode($row['sale_name']);
      $_SESSION[$SessionType] = base64url_encode($row['type_id']);
      $_SESSION[$SessionBranch] = base64url_encode($row['branch_id']);

      if ($row['type_login']=='1') {
        setcookie($CookieGroup, base64url_encode("Admin"), time() + (86400 * 30), "/"); // 86400 = 1 day
      }else {
        setcookie($CookieGroup, base64url_encode("Sale"), time() + (86400 * 30), "/"); // 86400 = 1 day
      }
      setcookie($CookieID, base64url_encode($row['login_id']), time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie($CookieName, base64url_encode($row['sale_name']), time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie($CookieType, base64url_encode($row['type_id']), time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie($CookieBranch, base64url_encode($row['branch_id']), time() + (86400 * 30), "/"); // 86400 = 1 day
      ?>
      1|||<p class='text-center'><i class="fa fa-spinner fa-spin animated"></i></p>
      <?
    }
  }else{
    ?>
      0|||<p class='text-center'><i class="fa fa-shield"></i> Incorrect </p>
    <?
  }
}
/// check login for have cookie
if ($_POST['post']=="check_login") {
   $sql = "SELECT ml.*,ms.*
           FROM mps_login ml
           LEFT OUTER  JOIN mps_sale ms ON ( ml.sale_id = ms.sale_id )
           WHERE  (
                    ml.login_id    = '".base64url_decode($_COOKIE[$CookieID])."' AND
                    ml.login_password_encode = '".base64url_encode($_POST['_password'])."' AND
                    ml.login_status = '1'
                  ) ;";
  if (select_num($sql)>0) {
    foreach (select_tb($sql) as $row) {
      $_SESSION[$SessionID] = base64url_encode($row['login_id']);
      $_SESSION[$SessionName] = base64url_encode($row['sale_name']);
      $_SESSION[$SessionType] = base64url_encode($row['type_id']);
      $_SESSION[$SessionBranch] = base64url_encode($row['branch_id']);

      ?>
      1|||<p class='text-center'><i class="fa fa-spinner fa-spin animated"></i></p>
      <?
    }
  }else{
      ?>
      0|||<p class='text-center'><i class="fa fa-shield"></i> Incorrect </p>
      <?
  }
}

///// Cusrtomer search
if ($_POST['post']=="Search-Customer") {
  $WHERE = "";
  if ($_POST['_name']!= "") {
    $WHERE = " WHERE ( cus_name LIKE '%".$_POST['_name']."%' )  ";
  }
  if ($_POST['_mobile']!= "") {
    $WHERE = " WHERE ( cus_mobile LIKE '%".$_POST['_mobile']."%' )  ";
  }
  $SqlSearch = "SELECT *
                FROM mps_customer
                $WHERE
                LIMIT 1;";
  if (select_num($SqlSearch)>0) {
    foreach (select_tb($SqlSearch) as $row) {
      echo $row['cus_ref']."|||".
           $row['cus_name']."|||".
           $row['cus_mobile']."|||".
           $row['cus_LINEID']."|||".
           $row['cus_gender']."|||".
           $row['cus_age']."|||".
           $row['cus_id'];
    }
  }
}

//// View Customer -- all
if ($_POST['post']=="View-Booking") {
  /*
    1. customer
    2. booking
    3. appointment
    4. payment
  */
  $CusBooking="SELECT mc.*,
                      mo.*
               FROM mps_order mo
               INNER JOIN mps_customer mc ON ( mo.cus_id = mc.cus_id )
               WHERE ( mo.order_id = '".$_POST['_orderid']."') ";
  foreach (select_tb($CusBooking) as $row) {

    ///// Customer
    echo $row['cus_ref']."|||".
         $row['cus_name']."|||".
         $row['cus_mobile']."|||".
         $row['cus_LINEID']."|||".
         $row['cus_gender']."|||".
         $row['cus_age']."|||";
    ///// Customer

    ////  Booking
    echo $row['ref_id']."|||".
         $row['job_booking']."|||".
         $row['branch_id']."|||".
         $row['pro_id']."|||";
          $SqlSale = "SELECT ms.sale_id,ms.sale_name
                    FROM mps_order_sale mos
                    INNER JOIN mps_sale ms ON ( mos.sale_id = ms.sale_id )
                    WHERE ( mos.order_id = '".$row['order_id']."' )";
          if (select_num($SqlSale)>0) { $ss=0;
            foreach (select_tb($SqlSale) as $sale) {
              if ($ss==0) {
                echo $sale['sale_name'];
              }else {
                echo ", ".$sale['sale_name'];
              }$ss++;
            }
          }
    echo "|||";
    echo $row['amount_total']."|||".
         $row['order_detail']."|||";
    ///// Booking

    ////// Appointment
    $SqlAppointment = "SELECT ma.*,
                              ms.sale_name,
                              mc.cus_name
                       FROM mps_appointment ma
                       INNER JOIN mps_order mo ON ( ma.order_id = mo.order_id )
                       INNER JOIN mps_customer mc ON ( mc.cus_id = mo.cus_id )
                       INNER JOIN mps_sale ms ON ( mo.sale_id = ms.sale_id )
                       WHERE ( ma.order_id = '".$row['order_id']."' )
                       ORDER BY ma.app_date ASC, ma.app_time ASC";
    $Show = "";$ap =0;
    if (select_num($SqlAppointment)>0) {
      $Show .= "<ul class='timeline timeline-inverse' id='BAppointment'>";
      foreach (select_tb($SqlAppointment) as $appoint) {
        $Show .= "<li><i class='fa fa-calendar bg-green' aria-hidden='true'></i>
                    <div class='timeline-item'>
                      <div class='panel box box-primary' style='margin-bottom:0px;'>
                        <div class='box-header with-border'>
                          <h4 class='box-title'>
                            <a data-toggle='collapse' data-parent='#BAppointment' href='#AppointBox".$ap."' aria-expanded='false' class='collapsed'>".date_eng($appoint['app_date'])."</a>
                          </h4>
                        </div>
                        <div id='AppointBox".$ap."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
                          <div class='box-body' style='background: #f0f0f0;'>

                              <div class='timeline-body'>
                                <dl class='dl'>
                                  <dt>Date Time</dt>
                                  <dd style='margin-bottom:20px;'>".date_eng($appoint['app_date'])." ".substr($appoint['app_time'],0,5)."</dd>
                                  <dt>Detail</dt>
                                  <dd style='word-break: break-all;margin-bottom:20px;'>".$appoint['app_detail']."</dd>
                                  <dt>Create By</dt>
                                  <dd style='margin-bottom:20px;'>
                                    ".$appoint['sale_name']."
                                  </dd>
                                </dl>
                              </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </li>";
        $ap++;
      }
      $Show .= "</ul>";
    }
    echo $Show;
    ////// Appointment

    echo "|||";
    ////// Payment
    $SqlPayment = "SELECT mp.*,
                          ms.sale_name
                   FROM mps_payment mp
                   INNER JOIN mps_sale ms ON ( mp.sale_id = ms.sale_id )
                   WHERE ( mp.order_id = '".$row['order_id']."' )
                   ORDER BY mp.pay_date ASC";
    $Show = "";$ap =0;
    if (select_num($SqlPayment)>0) {
      $Show .= "<ul class='timeline timeline-inverse' id='BPayment'>";
      foreach (select_tb($SqlPayment) as $bookpay) {
        $Show .= "<li><i class='fa fa-calendar bg-green' aria-hidden='true'></i></i>
                    <div class='timeline-item'>


                      <div class='panel box box-primary' style='margin-bottom:0px;'>
                        <div class='box-header with-border'>
                          <h4 class='box-title'>
                            <a data-toggle='collapse' data-parent='#BPayment' href='#BPaymentBox".$ap."' aria-expanded='false' class='collapsed'>".date_eng($bookpay['pay_date'])."</a>
                          </h4>
                        </div>
                        <div id='BPaymentBox".$ap."' class='panel-collapse collapse' aria-expanded='false' style='height: 0px;'>
                          <div class='box-body' style='background: #f0f0f0;'>
                              <div class='timeline-body'>
                                <dl class='dl'>
                                  <dt>Date Amount</dt>
                                  <dd style='margin-bottom:20px;'>".number_format($bookpay['pay_amount'])."</dd>
                                  <dt>Receipt By</dt>
                                  <dd style='margin-bottom:20px;'>".$bookpay['sale_name']."</dd>
                                  <dt>Pay Date By</dt>
                                  <dd style='margin-bottom:20px;'>".date_eng($bookpay['pay_date'])."</dd>
                                </dl>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>";
        $ap++;
      }
      $Show .= "</ul>";
    }
    echo $Show;
    ////// Payment


  }
}

if ($_POST['post']=="New-Appointment") {
  $SqlApp = "INSERT INTO mps_appointment
              VALUES(0,
                '".$_POST['_orderid']."',
                '".$_POST['_date']."',
                '".$_POST['_time']."',
                '".htmlspecialchars($_POST['_detail'], ENT_QUOTES)."',
                '".$_POST['_branch']."',
                '".base64url_decode($_COOKIE[$CookieID])."',
                1
              );";
  if (insert_tb($SqlApp)==true) {
    ?>C|||
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-success"></i> Alert!</h4>
        Appointment Complete.
      </div>
    <?
  }else {
    ?>
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        Appointment error, Please Check value.
      </div>
    <?
  }
}




?>
