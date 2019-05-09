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
          INNER JOIN mps_sale ms ON ( ml.sale_id = ms.sale_id )
          WHERE  (
                   ml.login_username  = '".$_POST['_username']."' AND
                   ml.login_password_encode = '".base64url_encode($_POST['_password'])."' AND
                   ms.branch_id = '".$_POST['_branch']."' AND
                   ml.login_status = '1'
                 ) ;";
  if (select_num($sql)>0) {
    foreach (select_tb($sql) as $row) {
      $_SESSION[$SessionID] = base64url_encode($row['login_id']);
      $_SESSION[$SessionName] = base64url_encode($row['sale_name']);
      $_SESSION[$SessionType] = base64url_encode($row['type_id']);
      $_SESSION[$SessionBranch] = base64url_encode($row['branch_id']);


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
           INNER JOIN mps_sale ms ON ( ml.sale_id = ms.sale_id )
           WHERE  (
                    ml.login_id    = '".base64url_decode($_COOKIE[$CookieID])."' AND
                    ml.login_password_encode = '".base64url_encode($_POST['_password'])."' AND
                    ml.login_status = '1'
                  ) ;";
  if (select_num($sql_)>0) {
    foreach (select_tb($sql_) as $row) {
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






?>
