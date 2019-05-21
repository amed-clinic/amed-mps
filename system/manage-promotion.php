
<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#promotion_show" data-toggle="tab">View Promotion</a></li>
          <li><a href="#promotion_new" data-toggle="tab">New Promotion</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="promotion_show">
            <?
              $sql = "SELECT *
                      FROM mps_promotion
                      ORDER BY pro_create_date DESC ";

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
                          ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                        }
                    ?>
                    </ul>
                  </nav>
                </div>
                <div class="component col-xs-12" style="padding:15px;">
                  <table>
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th>Promotion Name</th>
                        <th>ref Code</th>
                        <th>Detail</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Price</th>
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
                            <td class="text-center"><?=($id_run++);?></td>
                            <td class="text-left"><?=$row['pro_name'];?></td>
                            <td class="text-left"><?=$row['pro_ref'];?></td>
                            <td class="text-left"><?=$row['pro_detail'];?></td>
                            <td class="text-right"><?=number_format($row['pro_discount']);?></td>
                            <td class="text-right"><?=number_format($row['pro_price']);?></td>
                            <td class="text-center"><?=date_eng($row['pro_create_date']);?></td>
                            <td class="text-center">
                              <div class="btn-group" style="width: 117px;">
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-set"   class="btn btn-default "><i class="fa fa-search"></i></button>
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-edit" class="btn btn-default "><i class="fa fa-pencil"></i></button>
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-delete" class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                              </div>

                            </td>
                          </tr>
                          <?
                        }
                      }else {
                        ?>
                        <tr>
                          <td class="text-center" colspan="8">No Data.</td>
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
                          ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-promotion/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                        }
                    ?>
                    </ul>
                  </nav>
                </div>

              </div>
            </div>

          </div>
          <div class="tab-pane" id="promotion_new">
            <div class="row">
              <div class="col-xs-12">
                <form class="form-horizontal" action="<?=$HostLinkAndPath;?>" method="post">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">PromoName :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Name" id="au_Name" name="au_Name"  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Promo Detail :</label>
                      <div class="col-md-9">
                        <textarea name="name" class="form-control" placeholder="Promotion Detail"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">refCode:</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="reference code" id="" name=""  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Price :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="price 10000" id="" name=""  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Discount Price :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="price 9000" id="" name=""  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">For Month :</label>
                      <div class="col-md-9">
                        <select class="form-control" name="" required>
                          <option value="">Select Month</option>
                          <?
                            for ($i=1; $i <=12 ; $i++) {
                              ?><option value="<?=sprintf('%02d', $i);?>" <?=date("m")==sprintf('%02d', $i)?"selected":"";?> >Month <?=sprintf('%02d', $i);;?></option><?
                            };
                          ?>
                        </select>
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
