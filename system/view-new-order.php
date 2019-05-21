<?
if (isset($_POST['SubmitNewData'])) {


  $StatusPay = '0'; /// Status Payment 0=overdue,1=complete
  $OrderStatus = '0'; /// Status Order 1=complete,2=cancel
  $ACAge = "";
  $LINE = "";
  $Promo = "";

  if ( $_POST['ACPayment'] != $_POST['ACTotal'] ) {
    $StatusPay = '0';
    $OrderStatus = '0';
  }else{
    $StatusPay = '1';
    $OrderStatus = '1';
  }
  if (!empty($_POST['ACPromotion'])) {
    $Promo = "'".$_POST['ACPromotion']."'";
  }
  if (!empty($_POST['ACLINEID'])) {
    $LINE = "'".$_POST['ACLINEID']."'";
  }
  if (!empty($_POST['ACAge'])) {
    $ACAge = "'".$_POST['ACAge']."'";
  }


  if ($_POST['SHTypeCustomer']=="old") {
    $SqlOrderIN = "INSERT INTO mps_order
                    VALUES(0,
                      '".$_POST['ACOrderRef']."',
                      $Promo,
                      '".$_POST['ACCusId']."',
                      now(),
                      '".base64url_decode($_COOKIE[$CookieID])."',
                      '".$_POST['ACBranch']."',
                      '".$_POST['ACTotal']."',
                      $StatusPay,
                      '".$_POST['ACOrderDetail']."',
                      $OrderStatus,
                      null,
                      null,
                      null,
                      null
                    );";
    if (insert_tb($SqlOrderIN)==true) {
      $SqlOrderSelect = "SELECT MAX(order_id) as orderid
                         FROM mps_order
                         ORDER BY order_id DESC
                         LIMIT 1;";
      foreach (select_tb($SqlOrderSelect) as $roworder) {
        ///// Sale ref order
        foreach ($_POST['ACSaleref'] as $saleinref) {
          $SqlRefsale = "INSERT INTO mps_order_sale
                            VALUES(0,
                              $saleinref,
                              $roworder[orderid],
                              now()
                            );";
          insert_tb($SqlRefsale);
        }

        ///// Payment
        $SqlPayment = "INSERT INTO mps_payment VALUES(0,$roworder[orderid],'".$_POST['ACPayment']."',now(),'".base64url_decode($_COOKIE[$CookieID])."')";
        insert_tb($SqlPayment);


      }
      ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        Complete.
      </div>
      <meta http-equiv="refresh" content="2;url=<?=$LinkWeb;?>view-booking"/>
      <?
    }else {
      ?>
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        Can not insert Order.
      </div>
      <?
    }
  }else {
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
      $SqlCusSelect = "SELECT MAX(cus_id) as cus_id FROM mps_customer ORDER BY cus_id DESC;";
      foreach (select_tb($SqlCusSelect) as $cus) {
        $SqlOrderIN = "INSERT INTO mps_order
                        VALUES(0,
                          '".$_POST['ACOrderRef']."',
                          $Promo,
                          $cus[cus_id],
                          now(),
                          '".base64url_decode($_COOKIE[$CookieID])."',
                          '".$_POST['ACBranch']."',
                          '".$_POST['ACTotal']."',
                          $StatusPay,
                          '".$_POST['ACOrderDetail']."',
                          $OrderStatus,
                          null,
                          null,
                          null,
                          null
                        );";
        if (insert_tb($SqlOrderIN)==true) {
          $SqlOrderSelect = "SELECT MAX(order_id) as order_id
                             FROM mps_order
                             ORDER BY order_id DESC
                             LIMIT 1;";
          foreach (select_tb($SqlOrderSelect) as $roworder) {

            ///// Sale ref order
            foreach ($_POST['ACSaleref'] as $saleinref) {
              $SqlRefsale = "INSERT INTO mps_order_sale VALUES(0,$saleinref,$roworder[orderid],now());";
              insert_tb($SqlRefsale);
            }

            ///// Payment
            $SqlPayment = "INSERT INTO mps_payment VALUES(0,$roworder[order_id],'".$_POST['ACPayment']."',now(),'".base64url_decode($_COOKIE[$CookieID])."');";
            insert_tb($SqlPayment);

          }
          ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Complete.
          </div>
          <meta http-equiv="refresh" content="2;url=<?=$LinkWeb;?>view-booking"/>
          <?
        }else {
          ?>
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Can not insert Order.
          </div>
          <?
        }
      }
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
}
?>

<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#news_jobs" data-toggle="tab">New Order</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="news_jobs">


            <div class="row">
              <div class="col-xs-12">
                <form class="form-horizontal" action="<?=$LinkPath;?>" method="post">
                  <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Type Customer *</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="SHTypeCustomer" name="SHTypeCustomer" required>
                          <option value="">Select type Customer</option>
                          <option value="old">Old</option>
                          <option value="new">New</option>
                        </select>
                      </div>
                    </div>
                    <div class="panel"  id="old_customer" style="display:none;">
                      <div class="panel-body" style="border: 1px solid #e1e1e1;">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Search Cus.</label>
                          <div class="col-sm-9">
                            <div class="input-group input-group-md">
                              <input type="search" class="form-control" placeholder="Search from Name ....." id="SHName" name="SHName"  >
                              <span class="input-group-btn" >
                                <button type="button" class="btn btn-info btn-flat SHName"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Search Mobile.</label>
                          <div class="col-sm-9">
                            <div class="input-group input-group-md">
                              <input type="search" class="form-control" placeholder="Search form Mobile ....." id="SHMobile" name="SHMobile"  >
                              <span class="input-group-btn" >
                                <button type="button" class="btn btn-info btn-flat SHMobile"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Code Ref *</label>
                      <div class="col-sm-9">
                        <input type="hidden" id="ACCusId" name="ACCusId" value=""  />
                        <input type="text" class="form-control" placeholder="CustomerID Reference" id="ACRefCode" name="ACRefCode" required  />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Customer Name *</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="Customer Name" id="ACCusName" name="ACCusName" required  />
                      </div>
                    </div>
                    <div class="form-group">
                       <label for="" class="col-sm-3 control-label">Mobile *</label>
                       <div class="col-sm-9">
                         <input type="text" class="form-control"  placeholder="Mobile Phone" id="ACMobile" name="ACMobile" required  />
                       </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">LINE ID *</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  placeholder="LINE ID" id="ACLINEID" name="ACLINEID" required  />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Gender</label>
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
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Age</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  placeholder="Age ex. 20" id="ACAge" name="ACAge" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Order Ref.</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control"  placeholder="Order ID Reference" id="ACOrderRef" name="ACOrderRef" required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-sm-3 control-label">Branch</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" data-placeholder="Select Branch" id="ACBranch" name="ACBranch" style="width: 100%;">
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
                        <select class="form-control select2" multiple="multiple" id="ACSaleref" name="ACSaleref[]" data-placeholder="Select Sale" style="width: 100%;" required>
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
                    <div class="panel">
                      <div class="panel-body" style="border: 1px solid #e1e1e1;">
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Total Amount</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="ex. 20000" id="ACTotal" name="ACTotal" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">Payment</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control"  placeholder="ex. 10000" id="ACPayment" name="ACPayment" required />
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="" class="col-sm-3 control-label">OrderDetail</label>
                          <div class="col-sm-9">
                            <textarea class="form-control" placeholder="Detail" rows="5" id="ACOrderDetail" name="ACOrderDetail"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-xs-12">
                      <button type="submit" class="btn btn-info " id="SubmitNewData" name="SubmitNewData">Submit</button>
                      <button type="reset" class="btn btn-default" id="ResetData" name="ResetData">Reset</button>
                  </div>
                </form>
              </div>
            </div>




          </div>
       </div>
     </div>
  </div>
</div>









<script>
 $(function () {
   //Initialize Select2 Elements
  $(".select2").select2();
 })
</script>

<script>
  $(document).ready(function() {


    ////  Select Change type customer
    $("#SHTypeCustomer").change(function(event) {
      if ($(this).val()=='old') {
        $("#old_customer").attr("style","display:block;");
      }else {
        $("#old_customer").attr("style","display:none;");
      }
    });

    $("#SHName").keypress(function(e) {
      if (e.which==13 && $(this).val()!="") {
        $.post("../../query/check-data.php",
        {
          _name   : $("#SHName").val(),
          post : "Search-Customer"
        },
        function(d){
          var i = d.split("|||");
          $("#ACRefCode").val(i[0]);
          $("#ACCusName").val(i[1]);
          $("#ACMobile").val(i[2]);
          $("#ACLINEID").val(i[3]);
          if (i[4]=='1') {
            $("#ACGenderF").prop("checked",true);
          }else {
            $("#ACGenderM").prop("checked",true);
          }
          $("#ACAge").val(i[5]);
          $("#ACCusId").val(i[6]);
        });
        return false;
      }
    });
    $(".SHName").click(function(e) {
      if ($(this).val()!="") {
        $.post("../../query/check-data.php",
        {
          _name   : $("#SHName").val(),
          post : "Search-Customer"
        },
        function(d){
          var i = d.split("|||");
          $("#ACRefCode").val(i[0]);
          $("#ACCusName").val(i[1]);
          $("#ACMobile").val(i[2]);
          $("#ACLINEID").val(i[3]);
          if (i[4]=='1') {
            $("#ACGenderF").prop("checked",true);
          }else {
            $("#ACGenderM").prop("checked",true);
          }
          $("#ACAge").val(i[5]);
          $("#ACCusId").val(i[6]);
        });
      }
    });

    $("#SHMobile").keypress(function(e) {
      if (e.which==13 && $(this).val()!="") {
        $.post("../../query/check-data.php",
        {
          _mobile : $("#SHMobile").val(),
          post : "Search-Customer"
        },
        function(d){
          var i = d.split("|||");
          $("#ACRefCode").val(i[0]);
          $("#ACCusName").val(i[1]);
          $("#ACMobile").val(i[2]);
          $("#ACLINEID").val(i[3]);
          if (i[4]=='1') {
            $("#ACGenderF").prop("checked",true);
          }else {
            $("#ACGenderM").prop("checked",true);
          }
          $("#ACAge").val(i[5]);
          $("#ACCusId").val(i[6]);
        });
        return false;
      }
    });
    $(".SHMobile").click(function(e) {
      if ($(this).val()!="") {
        $.post("../../query/check-data.php",
        {
          _mobile : $("#SHMobile").val(),
          post : "Search-Customer"
        },
        function(d){
          var i = d.split("|||");
          $("#ACRefCode").val(i[0]);
          $("#ACCusName").val(i[1]);
          $("#ACMobile").val(i[2]);
          $("#ACLINEID").val(i[3]);
          if (i[4]=='1') {
            $("#ACGenderF").prop("checked",true);
          }else {
            $("#ACGenderM").prop("checked",true);
          }
          $("#ACAge").val(i[5]);
          $("#ACCusId").val(i[6]);
        });
      }
    });


  });
</script>
