<?
if (isset($_POST['SubmitAdd'])) {
  $ACAge = "";
  $LINE = "";
  if (!empty($_POST['ACLINEID'])) {
    $LINE = "'".$_POST['ACLINEID']."'";
  }
  if (!empty($_POST['ACAge'])) {
    $ACAge = "'".$_POST['ACAge']."'";
  }
  $SqlCusNew = "INSERT INTO mps_customer
                  VALUES(0,
                    '".$_POST['ACRefCode']."',
                    '".$_POST['ACCusName']."',
                    '".$_POST['ACMobile']."',
                    $LINE,
                    '".$_POST['ACGender']."',
                    $ACAge,
                    now()
                  );";
  if (insert_tb($SqlCusNew)==true) {
    ?>
    <div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      Save Customer Complete.
    </div>
    <meta http-equiv="refresh" content="2;url=<?=$HostLinkAndPath;?>"/>
    <?
  }else {
    ?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      Can not insert Customer.
    </div>
    <?
  }
}

?>

<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#customer_show" data-toggle="tab">View Customer</a></li>
          <li><a href="#customer_new" data-toggle="tab">New Customer</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="customer_show">
            <?
              $sql = "SELECT *
                      FROM mps_customer
                      ORDER BY cus_createdate DESC ";

              $Per_Page = 100;   // Per Page
              $Page = $UrlIdSub;
              if(!$UrlIdSub){
                $Page=1;
              }

              $Prev_Page = $Page-1;
              $Next_Page = $Page+1;

              $Page_Start = (($Per_Page*$Page)-$Per_Page);
              if(select_num($sql)<=$Per_Page){
                $Num_Pages =1;
              }
              else if((select_num($sql) % $Per_Page)==0){
                $Num_Pages =(select_num($sql)/$Per_Page) ;
              }else{
                $Num_Pages =(select_num($sql)/$Per_Page)+1;
                $Num_Pages = (int)$Num_Pages;
              }
              $id_run = $Page_Start+1;

              $sql .= " LIMIT $Page_Start , $Per_Page; ";
            ?>
            <div class="row">
              <div class="colxs-12">
                <div class="col-xs-12">
                  <nav>
                    <ul class="pagination">
                     <?
                        if($Prev_Page){
                          ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                        }
                    ?>
                    </ul>
                  </nav>
                </div>
                <div class="col-xs-12 component" style="padding:15px;">

                  <table>
                    <thead>
                      <tr>
                        <th class="text-left">refCode</th>
                        <th class="text-center">No.</th>
                        <th class="text-left">Customer Name</th>
                        <th class="text-left">Mobile</th>
                        <th class="text-left">LINE ID</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Age</th>
                        <th class="text-center">Create Date</th>
                        <th class="text-center">Manage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                      if (select_num($sql)>0) {
                        foreach (select_tb($sql) as $row) {
                          ?>
                          <tr>
                            <th class="text-left"><?=$row['cus_ref'];?></th>
                            <td class="text-center"><?=($id_run++);?></td>
                            <td class="text-left"><?=$row['cus_name'];?></td>
                            <td class="text-left"><?=$row['cus_mobile'];?></td>
                            <td class="text-left"><?=$row['cus_LINEID'];?></td>
                            <td class="text-center"><?=$row['cus_gender']==0?"<i class='fa fa-2x fa-male' aria-hidden='true' style='color:#0b4db7;'></i>":"<i class='fa fa-2x fa-female' aria-hidden='true' style='color: #f732ae;'></i>";?></td>
                            <td class="text-center"><?=$row['cus_age'];?></td>
                            <td class="text-center"><?=date_eng($row['cus_createdate']);?></td>
                            <td class="text-center">
                              <div class="btn-group" style="width: 117px;">
                                <button id="<?=$row['branch_id'];?>" data-toggle="modal" data-target="#modal-set"   class="btn btn-default "><i class="fa fa-search"></i></button>
                                <button id="<?=$row['branch_id'];?>" data-toggle="modal" data-target="#modal-edit" class="btn btn-default "><i class="fa fa-pencil"></i></button>
                                <button id="<?=$row['branch_id'];?>" data-toggle="modal" data-target="#modal-delete" class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                              </div>

                            </td>
                          </tr>
                          <?
                        }
                      }else {
                        ?>
                        <tr>
                          <td class="text-center" colspan="10">No Data.</td>
                        </tr>
                        <?
                      }
                      ?>
                    </tbody>
                  </table>

                </div>
                <div class="col-xs-12">
                  <nav>
                    <ul class="pagination">
                     <?
                        if($Prev_Page){
                          ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-customer/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                        }
                    ?>
                    </ul>
                  </nav>
                </div>

              </div>
            </div>

          </div>
          <div class="tab-pane" id="customer_new">
            <div class="row">
              <div class="col-xs-12">
                <form class="form-horizontal" action="<?=$HostLinkAndPath;?>" method="post">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">refCode :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="reference code" id="" name="ACRefCode"  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Name Customer :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Name Customer" id="" name="ACCusName"  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Mobile :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Mobile" id="" name="ACMobile"  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">LINE ID :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="LINE ID" id="" name="ACLINEID"   />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Gender :</label>
                      <div class="col-md-9">
                        <div class="col-sm-9">
                          <div class="radio">
                            <label>
                              <input type="radio" name="ACGender" id="ACGenderM" value="0" checked=""> Male
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="ACGender" id="ACGenderF" value="1"> Female
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Age :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control"  placeholder="Age ex. 20" id="ACAge" name="ACAge" />
                      </div>
                    </div>

                  </div>
                  <div class="col-xs-12">
                      <button type="submit" class="btn btn-info " id="SubmitAdd" name="SubmitAdd">Submit</button>
                      <button type="button" class="btn btn-default">Reset</button>
                    </div>
                </form>
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
