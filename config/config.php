<?
ob_start() ;
session_start();

header("content-type: text/html; charset=utf-8");
//header('Access-Control-Allow-Origin: *');
date_default_timezone_set("utc");


global $Link, $Host, $User, $Pass, $DBname;
global $CookieID,$CookieName,$CookieType,$CookieBranch;
global $SessionID,$SessionName,$SessionType,$SessionBranch;



$LinkWeb 		= "https://mps.amedclinic.com/";
$LinkPath 		  = $LinkWeb.$_SERVER['REQUEST_URI'];
$LinkHostWeb 		= "https://amedclinic.com/mps/";
$LinkHostLocal 	= $LinkWeb;
$LinkHostAdmin  = "";

define(SITE_URL,$LinkWeb);

$Path         = $LinkWeb.$_SERVER['REQUEST_URI'];
$PathExplode  = explode("/",$Path);
$Url          = $PathExplode[0];
$UrlPage      = $PathExplode[1];
$UrlId        = $PathExplode[2];
$UrlIdSub     = $PathExplode[3];
$UrlOther     = $PathExplode[4];
$UrlOther2    = $PathExplode[5];








/// Session and Cookie Admin
$CookieID = 'C_UID'; //ID_admin
$CookieName = 'C_UNAME'; //name_admin
$CookieType = 'C_UTYPEID'; //mem_group_name
$CookieBranch = 'C_UBRANCH'; //mem_group_name

$SessionID = 'S_UID'; // Member_id
$SessionName = 'S_UNAME'; //Company
$SessionType = 'S_UTYPEID'; //member_group
$SessionBranch = 'S_UBRANCH'; //member_group


if (!empty($_SESSION[$SessionID]) ||
    !empty($_SESSION[$SessionName])||
    !empty($_SESSION[$SessionType])||
    !empty($_SESSION[$SessionBranch]) ) {
  if ( empty($_COOKIE[$CookieID]) ) {

    unset($_SESSION[$SessionID]);
    unset($_SESSION[$SessionName]);
    unset($_SESSION[$CookieType]);
    unset($_SESSION[$CookieBranch]);

    session_unset();
    session_destroy();
    header("Refresh:0; url=$LinkPath");
  }
}





function ConnectToDB() {
	global $Link, $Host, $User, $Pass, $DBname;


  /*
  //server test.startconcept
  $Host = "localhost";
  $User = "startcon_test";
  $Pass = "startcon_test";
  $DBname = "startcon_test";
  */
  //server mps.amedclinic
	$Host = "localhost";
	$User = "admin_mps";
	$Pass = "admin_mps";
	$DBname = "admin_mps";


	$Link = mysql_connect($Host,$User,$Pass) or die(mysql_error());
	mysql_select_db($DBname,$Link) or die(mysql_error());
	mysql_query("SET NAMES UTF8");
}

function insert_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysql_query($query,$Link)or die(mysql_error());
	if($objQuery){
		return true;
	}else{
		return false;
	}
}

function delete_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysql_query($query,$Link)or die(mysql_error());
	if($objQuery){
		return true;
	}else{
		return false;
	}
}

function select_tb($query){
	ConnectToDB();
	global $Link;
	$obj = mysql_query($query,$Link)or die(mysql_error());
	while($ro = mysql_fetch_array($obj)){
		$rows[] = $ro;
	}
	return $rows;
}

function select_num($query){
	ConnectToDB();
	global $Link;
	$obj = mysql_query($query,$Link)or die(mysql_error());
	$numrow = mysql_num_rows($obj);
	return $numrow;
}

function update_tb($query){
	ConnectToDB();
	global $Link;
	$objQuery = mysql_query($query,$Link);
	if($objQuery){
		return true;
	}else{
		return false;
	}
}

function base64url_encode($data) { return base64_encode($data); }

function base64url_decode($data) { return base64_decode($data); }



//// check data on cookie
function check_user($id,$colum){
	$sql = "SELECT *
					FROM mps_login
					WHERE ( login_id = '".base64url_decode($id)."' ) ;";
	if (select_num($sql)>0) {
		foreach (select_tb($sql) as $row) {
			return $row[$colum];
		}
	}else {
		return "-";
	}
}

function date_time($value){
	$year = substr($value,2,2);
	$month = substr($value,5,2);
	$date = substr($value,8,2);
  $time = substr($value,11,8);
  $array_month = array("ม.ค.","ก.พ.","มี.ค.","ม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	///$array_month = array("+","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	return $date." ".$array_month[$month-1]." ".$year." ".$time;
}
function date_thaishot($value){
	$year = substr($value,2,2);
	$month = substr($value,5,2);
	$date = substr($value,8,2);
  $array_month = array("ม.ค.","ก.พ.","มี.ค.","ม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	///$array_month = array("+","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	return $date." ".$array_month[$month-1]." ".$year;
}
function date_engshot($value){
	$year = substr($value,2,2);
	$month = substr($value,5,2);
	$date = substr($value,8,2);
  $array_month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	return $date." ".$array_month[$month-1]." ".$year;
}
function DateDiff($strDate1,$strDate2){
		$i = (((strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 )) + 1);  // 1 day = 60*60*24
    if ($i>=0) {
      return $i;
    }else {
      return '0';
    }
}



?>
