<div class="row">
  <div class="col-xs-12">

    <?
      $SqlBranch = "SELECT *
                    FROM mps_branch
                    WHERE ( branch_status = '1' )
                    ORDER BY  branch_name ASC;";
      if (select_num($SqlBranch)>0) {
        foreach (select_tb($SqlBranch) as $row) {
          $Sql = "SELECT *
                  FROM mps_sale
                  WHERE ( branch_id = '".$row['branch_id']."' );";
          if (select_num($Sql)>0) {
              ?>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="fa fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text"><?=$row['branch_name'];?></span>
                    <span class="info-box-number"><?=select_num($Sql);?></span>
                    <div class="progress"><div class="progress-bar" style="width: 70%"></div></div>
                    <span class="progress-description">70%</span>
                  </div>
                </div>
              </div>
              <?
          }
        }
      }
    ?>

  </div>
</div>


<?
if (isset($_POST["SubmitAdd"])) {
  $SqlU = "INSERT INTO mps_sale
              VALUES(0,
                '".$_POST['au_Name']."',
                '".$_POST['au_Status']."',
                '".$_POST['au_Branch']."',
                '".$_POST['au_TypeUser']."',
                now()
              );";
  if (insert_tb($SqlU)==true) {
    ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-success"></i> Alert!</h4>
        Insert  User Complete.
      </div>
      <meta http-equiv="refresh" content="2;url=<?=$HostLinkAndPath;?>"/>
    <?
  }else {
    ?>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      incorrect.
    </div>
    <?
  }
}
?>
<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#member_show" data-toggle="tab">View User</a></li>
          <li><a href="#member_new" data-toggle="tab">New User</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="member_show">
            <?
              $sql = "SELECT ms.*,mt.type_name,mb.branch_name
                      FROM mps_sale ms
                      INNER JOIN mps_type mt ON ( ms.type_id = mt.type_id )
                      INNER JOIN mps_branch mb ON ( ms.branch_id = mb.branch_id )
                      ORDER BY ms.create_date DESC ";

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
                          ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
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
                        <th>Name</th>
                        <th class="text-left">TypeUser</th>
                        <th class="text-left">Branch</th>
                        <th class="text-center">create Date</th>
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
                            <td class="text-left"><?=$row['sale_name'];?></td>
                            <td class="text-left"><?=$row['type_name'];?></td>
                            <td class="text-left"><?=$row['branch_name'];?></td>
                            <td class="text-center"><?=$row['create_date'];?></td>
                            <td class="text-center">
                              <div class="btn-group" style="width: 153px;">
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-set"   class="btn btn-default "><i class="fa fa-search"></i></button>
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-edit" class="btn btn-default "><i class="fa fa-pencil"></i></button>
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-delete" class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                                <button id="<?=$row['sale_id'];?>" data-toggle="modal" data-target="#modal-cogs" class="btn <?=check_in_login($row['sale_id'])==true?"btn-warning":"btn-default";?>"><i class="fa fa-key"></i></button>
                              </div>

                            </td>
                          </tr>
                          <?
                        }
                      }else {
                        ?>
                        <tr>
                          <td class="text-center" colspan="6">No Data.</td>
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
                          ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$Prev_Page;?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?
                        }
                        for($i=1; $i<=$Num_Pages; $i++){
                          $Page1 = $Page-2;
                          $Page2 = $Page+2;
                          if($i != $Page && $i >= $Page1 && $i <= $Page2){
                            ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$i;?>"><?=$i;?></a></li><?
                          }else if($i==$Page){
                            ?><li class="active"><a href="#"><?=$i;?></a></li><?
                          }
                        }
                        if($Page!=$Num_Pages){
                          ?><li><a href="<?=$LinkWeb;?>manage-user/<?=$Next_Page;?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?
                        }
                    ?>
                    </ul>
                  </nav>
                </div>

              </div>
            </div>

          </div>
          <div class="tab-pane" id="member_new">
            <div class="row">
              <div class="col-xs-12">
                <form class="form-horizontal" action="<?=$HostLinkAndPath;?>" method="post">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Name :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Name" id="au_Name" name="au_Name"  required />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Type User :</label>
                      <div class="col-md-9">
                        <select class="form-control" id="au_TypeUser" name="au_TypeUser" required >
                          <?
                            $SqlType = "SELECT *
                                        FROM mps_type
                                        ORDER BY type_name ASC ";
                            if (select_num($SqlType)>0) {
                              ?><option value="">Select Type User</option><?
                              foreach (select_tb($SqlType) as $row) {
                                ?><option value="<?=$row['type_id'];?>"><?=$row['type_name'];?></option><?
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Branch :</label>
                      <div class="col-md-9">
                        <select class="form-control" id="au_Branch" name="au_Branch" required >
                          <?
                            $SqlBranch = "SELECT *
                                        FROM mps_branch
                                        ORDER BY branch_name ASC ";
                            if (select_num($SqlBranch)>0) {
                              ?><option value="">Select Branch</option><?
                              foreach (select_tb($SqlBranch) as $row) {
                                ?><option value="<?=$row['branch_id'];?>"><?=$row['branch_name'];?></option><?
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">Status User :</label>
                      <div class="col-md-9">
                        <select class="form-control" name="au_Status" id="au_Status" required>
                          <option value="">Select status User</option>
                          <option value="Y">Online</option>
                          <option value="N">Offline</option>
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
