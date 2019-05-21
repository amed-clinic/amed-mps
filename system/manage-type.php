<div class="row">
  <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#typeuser_show" data-toggle="tab">View Type User</a></li>
          <li><a href="#typeuser_new" data-toggle="tab">New Type User</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="typeuser_show">
            <?
              $sql = "SELECT *
                      FROM mps_type
                      ORDER BY create_date DESC ";

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
                <div class="component col-xs-12" style="padding:15px;">
                  <table>
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th class="text-left">Type Name</th>
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
                            <td class="text-left"><?=$row['type_name'];?></td>
                            <td class="text-center"><?=date_eng($row['create_date']);?></td>
                            <td class="text-center">
                              <div class="btn-group" style="width: 117px;">
                                <button id="<?=$row['type_id'];?>" data-toggle="modal" data-target="#modal-set"   class="btn btn-default "><i class="fa fa-search"></i></button>
                                <button id="<?=$row['type_id'];?>" data-toggle="modal" data-target="#modal-edit" class="btn btn-default "><i class="fa fa-pencil"></i></button>
                                <button id="<?=$row['type_id'];?>" data-toggle="modal" data-target="#modal-delete" class="btn btn-default"><i class="fa fa-trash-o"></i></button>
                              </div>

                            </td>
                          </tr>
                          <?
                        }
                      }else {
                        ?>
                        <tr>
                          <td class="text-center" colspan="4">No Data.</td>
                        </tr>
                        <?
                      }
                      ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div>

          </div>
          <div class="tab-pane" id="typeuser_new">
            <div class="row">
              <div class="col-xs-12">
                <form class="form-horizontal" action="<?=$HostLinkAndPath;?>" method="post">
                  <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                      <label for="" class="col-md-3 control-label">TypeName :</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" placeholder="Name" id="au_Name" name="au_Name"  required />
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
