<?
ob_start() ;
session_start();

header("content-type: text/html; charset=utf-8");
//header('Access-Control-Allow-Origin: *');
date_default_timezone_set("utc");


global $Link, $Host, $User, $Pass, $DBname;
global $CookieID,$CookieName,$CookieType,$CookieBranch,$CookieGroup;
global $SessionID,$SessionName,$SessionType,$SessionBranch,$SessionGroup;



$LinkWeb 		= "http://mps.startconcept.com/";
$LinkPath 		  = "http://mps.startconcept.com".$_SERVER['REQUEST_URI'];
$LinkHostWeb 		= "http://mps.startconcept.com/";
$LinkHostLocal 	= $LinkWeb;
$LinkHostAdmin  = "";

define(SITE_URL,$LinkWeb);

$Path         = $LinkPath;
$PathExplode  = explode("/",$_SERVER['REQUEST_URI']);
$Url          = "http://mps.startconcept.com";
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
$CookieGroup = 'C_UGROUP'; //mem_group

$SessionID = 'S_UID'; // Member_id
$SessionName = 'S_UNAME'; //Company
$SessionType = 'S_UTYPEID'; //member_group
$SessionBranch = 'S_UBRANCH'; //member_branch
$SessionGroup = 'S_UGROUP'; //member_group


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


  //server test.startconcept
  $Host = "localhost";
  $User = "startcon_test";
  $Pass = "startcon_test";
  $DBname = "startcon_test";
  /*
  //server mps.amedgroup.co.th
  $Host = "localhost";
  $User = "amedgroup_mps";
  $Pass = "amedgroup_mps";
  $DBname = "amedgroup_mps";

  //server mps.amedclinic
	$Host = "localhost";
	$User = "admin_mps";
	$Pass = "admin_mps";
	$DBname = "admin_mps";
  */

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

require('function.php');

?>
