<?

  $SqlViewBooking = "SELECT mo.*,
                            mc.cus_name,mc.cus_mobile,ms.sale_name,
                            mp.pro_name,
                            ma.app_id
                     FROM mps_order mo
                     INNER JOIN mps_customer mc ON ( mo.cus_id = mc.cus_id )
                     INNER JOIN mps_sale ms ON ( mo.sale_id = ms.sale_id )
                     LEFT OUTER JOIN mps_promotion mp ON ( mo.pro_id = mp.pro_id )
                     LEFT OUTER JOIN mps_appointment ma ON ( mo.order_id = ma.order_id )
                     WHERE ( mo.order_status = '2' )
                     ORDER BY mo.order_date  DESC ";
?>

<div class="row">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#view_booking" data-toggle="tab">Booking Cancel <?=select_num($SqlViewBooking)>0?"( ".select_num($SqlViewBooking)." )":"";?></a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="view_booking">
          <div class="row">
            <div class="col-xs-12">
              <div class="component col-xs-12" style="padding:15px;">
                <table>
                  <thead>
                    <tr>
                      <th class="text-center">No.</th>
                      <th>Ref No.</th>
                      <th>Customer</th>
                      <th>Mobile</th>
                      <th>Promotion</th>
                      <th class="text-right">Total</th>
                      <th class="text-right">Overdue</th>
                      <th class="text-center">Booking Create</th>
                      <th class="text-center">Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?
                      $Per_Page = 80;   // Per Page
                      $Page = $UrlId;
                      if(!$UrlId){
                       $Page=1;
                      }

                      $Prev_Page = $Page-1;
                      $Next_Page = $Page+1;

                      $Page_Start = (($Per_Page*$Page)-$Per_Page);
                      if(select_num($SqlViewBooking)<=$Per_Page){
                       $Num_Pages =1;
                      }
                      else if((select_num($SqlViewBooking) % $Per_Page)==0){
                       $Num_Pages =(select_num($SqlViewBooking)/$Per_Page) ;
                      }else{
                       $Num_Pages =(select_num($SqlViewBooking)/$Per_Page)+1;
                       $Num_Pages = (int)$Num_Pages;
                      }
                      $id_run = $Page_Start+1;

                      $SqlViewBooking .= " LIMIT $Page_Start , $Per_Page; ";
                      if (select_num($SqlViewBooking)>0) {
                        foreach (select_tb($SqlViewBooking) as $row) {
                          ?>
                          <tr>
                            <th class="text-center"><?=($id_run++);?></th>
                            <td><?=$row['ref_id'];?></td>
                            <td><?=$row['cus_name'];?></td>
                            <td><?=$row['cus_mobile'];?></td>
                            <td><?=$row['pro_name'];?></td>
                            <td class="text-right"><?=number_format($row['amount_total']);?></td>
                            <td class="text-right">
                              <?
                                $Price = 0;
                                $SqlPay = "SELECT *
                                           FROM mps_payment
                                           WHERE ( order_id = '".$row['order_id']."' )";
                                if (select_num($SqlPay)>0) {
                                  foreach (select_tb($SqlPay) as $value) {
                                    $Price = $Price+$value['pay_amount'];
                                  }
                                  $Price = ($row['amount_total']-$Price);
                                }
                                if ($Price>0) {
                                  echo "<font color='#f00'>".number_format($Price)."</font>";
                                }else {
                                  echo $Price;
                                }

                              ?>
                            </td>
                            <td class="text-center" style="width: 150px;"><?=$row['sale_name'];?><br><?=date_eng($row['order_date']);?></td>
                            <td class="text-center">
                              <div class="btn-group" style="min-width:117px;">
                                <button id="<?=$row['order_id'];?>" data-toggle="modal" class="btn btn-default click_view_booking" data-target="#click_view_booking"><i class="fa fa-search"></i></button>
                                <button id="<?=$row['order_id'];?>" data-toggle="modal" class="btn btn-warning click_change_booking" data-target="#click_change_booking"><i class="fa fa-cog"></i></button>
                                <button id="<?=$row['order_id'];?>" data-toggle="modal" class="btn btn-default click_delete_booking" data-target="#click_delete_booking"><i class="fa fa-trash"></i></button>
                              </div>
                            </td>
                          </tr>
                          <?
                        }
                      }else {
                        ?>
                        <tr>
                          <td colspan="9" class="text-center">No Data.</td>
                        </tr>
                        <?
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="col-xs-12">
                <nav>
                  <ul class="pagination" style="margin:0px;">
                   <?
                      if($Prev_Page){
                        ?><li><a href="<?=SITE_URL;?>view-booking/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                      }
                      for($i=1; $i<=$Num_Pages; $i++){
                        $Page1 = $Page-2;
                        $Page2 = $Page+2;
                        if($i != $Page && $i >= $Page1 && $i <= $Page2){
                          ?><li><a href="<?=SITE_URL;?>view-booking/<?=$i;?>"><?=$i;?></a></li><?
                        }else if($i==$Page){
                          ?><li class="active"><a href="#"><?=$i;?></a></li><?
                        }
                      }
                      if($Page!=$Num_Pages){
                        ?><li><a href="<?=SITE_URL;?>view-booking/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                      }
                  ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/StickyTableHeaders/css/component.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="<?=$LinkHostWeb;?>plugins/StickyTableHeaders/js/jquery.stickyheader.js"></script>
