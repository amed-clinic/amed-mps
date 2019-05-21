<?
require_once("../config/config.php");
if ( $_COOKIE[$CookieID]!="" && $_SESSION[$SessionID]!="" ) {

  $file = $LinkWeb."file/doctor/".$_GET['file'];
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="'.basename($file).'"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file));
  readfile($file);
  exit();
}else {
  echo "Can not Download file.";
}


?>
