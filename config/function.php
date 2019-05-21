<?


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


function date_th($value){
	$year = substr($value,2,2);
	$month = substr($value,5,2);
	$date = substr($value,8,2);
  $time = substr($value,11,8);
  $array_month = array("ม.ค.","ก.พ.","มี.ค.","ม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	///$array_month = array("+","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	return $date." ".$array_month[$month-1]." ".$year." ".$time;
}
function date_thshot($value){
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
	return $date."-".$array_month[$month-1]."-".$year;
}
function date_eng($value){
	$year = substr($value,2,2);
	$month = substr($value,5,2);
	$date = substr($value,8,2);
  $time = substr($value,11,8);
  $array_month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	return $date."-".$array_month[$month-1]."-".$year." ".$time;
}
function DateDiff($strDate1,$strDate2){
		$i = (((strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 )) + 1);  // 1 day = 60*60*24
    if ($i>=0) {
      return $i;
    }else {
      return '0';
    }
}

/////
function check_in_login($sale_id){
  $sql = "SELECT *
          FROM mps_login
          WHERE ( sale_id = '$sale_id' )";
  if (select_num($sql)>0) {
    return false;
  }else {
    return true;
  }
}


///// check appointment  on booking
function ch_appointment($orderid){
	$SqlApp = "SELECT *
						 FROM mps_appointment
						 WHERE ( order_id = '$orderid' );";
  if (select_num($SqlApp)>0) {
  	return false;
  }else {
  	return true;
  }
}

///////
function check_salename($saleid){
	$sql = "SELECT sale_name
					FROM mps_sale
					WHERE (sale_id = '$saleid')";
	if (select_num($sql)>0) {
		foreach (select_tb($sql) as $row) {
			return $row['sale_name'];
		}
	}
}













?>
