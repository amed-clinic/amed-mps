<?
if (isset($_POST["SubmitUpload"])) {
  $allowed =  array('pdf');
  $File = pathinfo($_FILES['ap_Upload']['name'], PATHINFO_EXTENSION);
  if (  !in_array($File,$allowed)  ) {
    ?>
    <div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      type (pdf) only.
      <br>File  : <?=$_FILES['ap_Upload']['type'];?>
    </div>
    <?
  }else {

    $tem = explode(".", $_FILES["ap_Upload"]["name"]);
    $NewFile   = "doctor_".date("Ymd_his").".".end($tem);
    $Direct =  "file/doctor/";
    if (  move_uploaded_file($_FILES["ap_Upload"]["tmp_name"], $Direct.$NewFile)   ) {

        $sql = "INSERT INTO mps_plan_doctor
                  VALUES(0,
                      '".$_POST['ap_Name']."',
                      '".$_POST['ap_Detail']."',
                      '".$NewFile."',
                      now(),
                      '".base64url_decode($_COOKIE[$CookieID])."'
                  );";
        if (insert_tb($sql)==true) {
          ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Upload Complete.
          </div>
          <meta http-equiv="refresh" content="2;url=<?=$HostLinkAndPath;?>"/>
          <?
        }else {
          ?>
          <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            Can not insert to database.
          </div>
          <?
        }
    }else {
      ?>
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
        Can not Upload.
      </div>
      <?
    }
  }
}
?>

<div class="row">
  <div class="col-sm-12 col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#manage_doctor_view" data-toggle="tab">View Plan Doctor</a></li>
        <li><a href="#manage_doctor_add" data-toggle="tab">New Upload Plan</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane" id="manage_doctor_add">
          <!-- UPload  -->
          <div class="row">
            <div class="col-xs-12" style="padding:20px 15px;">
              <form class="form-horizontal" action="<?=$HostLinkAndPath;?>" method="post" enctype="multipart/form-data">
                <div class="col-sm-12 col-md-6 col-lg-6">

                  <div class="form-group">
                    <label for="" class="col-md-3 control-label">Name Title :</label>
                    <div class="col-md-9">
                      <input type="text" class="form-control" id="ap_Name" name="ap_Name" placeholder="name title"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-md-3 control-label">Detail  :</label>
                    <div class="col-md-9">
                      <textarea class="form-control" rows="5" id="ap_Detail" name="ap_Detail" placeholder="Detail doctor update...."></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-md-3 control-label">Upload file :*</label>
                    <div class="col-md-9">
                      <input type="file" class="form-control" id="ap_Upload" name="ap_Upload"/>
                    </div>
                  </div>

                </div>
                <div class="col-xs-12">
                    <button type="submit" name="SubmitUpload" id="SubmitUpload" class="btn btn-info ">Upload</button>
                  </div>
              </form>
            </div>
          </div>
          <!-- UPload  -->
        </div>
        <div class="tab-pane active" id="manage_doctor_view">

          <!-- plan doctor view
         -->
          <div class="row">
            <div class="col-xs-12" style="margin:15px 0 0 0;padding:0px;">
              <div class="col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search name , detail ....." id="SearchView">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default">Search</button>
                    </span>
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="component col-xs-12" style="padding:15px;">
                  <table>
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th>NameTitle</th>
                        <th>Detail</th>
                        <th>Link</th>
                        <th class="text-center">Date Upload</th>
                        <th class="text-center">Manage</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?
                        $sql = "SELECT *
                                FROM mps_plan_doctor
                                ORDER BY doc_upload_date DESC";
                        if (select_num($sql)>0) { $i=1;
                          foreach (select_tb($sql) as $row) {
                            ?>
                              <tr>
                                <td class="text-center"><?=($i++);?></td>
                                <td><?=$row['doc_name'];?></td>
                                <td><?=$row['doc_detail'];?></td>
                                <td><a class="btn btn-default btn-xs" href="<?=$LinkWeb."file/doctor/".$row['doc_file'];?>" target="_blank">View</a></td>
                                <td class="text-center"><?=date_eng($row['doc_upload_date']);?></td>
                                <td class="text-center">
                                  <div class="btn-group" style="width: 100px;">
                                    <!--<button id="<?=$row['file_id'];?>" data-toggle="modal" data-target="#modal-view" class="btn btn-default click_view_price_upload"><i class="fa fa-search"></i></button>-->
                                    <button id="<?=$row['doc_id'];?>" data-toggle="modal" data-target="#modal-edit" class="btn btn-default "><i class="fa fa-pencil"></i></button>
                                    <button id="<?=$row['doc_id'];?>" data-toggle="modal" data-target="#modal-delete" class="btn btn-danger "><i class="fa fa-trash-o"></i></button>
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
            </div>
          </div>
          <!-- plan doctor view
         -->

        </div>
      </div>
    </div>
  </div>
</div>





<!-- edit plan doctor -->
<script type="text/javascript">
  $(document).ready(function() {

    $(".").click(function(e) {
      $(".").attr("id",$(this).attr("id"));
      $.post("../../query/check-data.php",
      {
        value : $(this).attr("id"),
        post  : "view-plan-doctor"
      },
      function(d) {
        var i = d.split("|||");
        $("#ep_StructureName").val(i[0]);
        $("#ep_StructureDetail").val(i[1]);
        $("#ep_StructureGroup").val(i[2]);
        $("#ep_StatusStructure").val(i[3]);
      });
    });

    $(".ep_UpdatePriceUpload").click(function(e) {
      if ( $("#ep_StructureName").val() != "" &&
           $("#ep_StructureDetail").val() != "" &&
           $("#ep_StructureGroup").val() != "" &&
           $("#ep_StatusStructure").val() != "" ) {

        $.post('../../jquery/others.php',
        {
          fileid   : $(this).attr("id"),
          filename : $("#ep_StructureName").val(),
          filedetail: $("#ep_StructureDetail").val(),
          filegroup: $("#ep_StructureGroup").val(),
          filestatus: $("#ep_StatusStructure").val(),
          post     : "StructurePriceUploadUpdate"
        },
        function(d) {
          $(".alert_update_price_upload").html(d);
          setTimeout(function(){
            window.location.href = "<?=$HostLinkAndPath;?>";
          },2000);
        });

      }else {

      }
    });

  });
</script>
<div class="modal fade" id="modal-edit" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Plan Doctor</h4>
      </div>

      <div class="modal-body"  >
        <div class="row">
          <div class="col-xs-12">

            <!-- Form -->
            <form class="form-horizontal">
              <div class="form-group">
                <label for="" class="col-md-3 control-label">Name Title :</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" id="ep_StructureName" name="ep_StructureName" placeholder="name title "/>
                </div>
              </div>
              <div class="form-group">
                <label for="" class="col-md-3 control-label">Detail  :</label>
                <div class="col-md-9">
                  <textarea class="form-control" rows="5" id="ep_StructureDetail" name="ep_StructureDetail" placeholder="detail ...."></textarea>
                </div>
              </div>
            </form>
            <!-- Form -->

          </div>
        </div>
        <div class="row">
          <div class="col-xs-12 alert_update_price_upload">

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info ep_UpdatePriceUpload">บันทึก</button>
      </div>

    </div>
  </div>
</div>
<!-- edit plan doctor -->



<!-- delete plan doctor -->
<script>
  $(document).ready(function() {

      $(".").click(function(e) {
        $(".").attr("id", $(this).attr("id"));
      });
      //// check delete
      $(".").click(function(e) {
        $.post("../../query/check-data.php",
        {
          value : $(this).attr("id"),
          post : "delete-plan-doctor"
        },
        function(data) {
            $("#").html(data);
            setTimeout(function(){
              window.location.href = "<?=$HostLinkAndPath;?>";
            },2000);
        });
      });

  });
</script>
<div class="modal fade" id="modal-delete" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="color: white;background-color: #f00;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id=""><i class="fa fa-trash-o" style=" color: #FFF"></i> Delete</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group" style="text-align: center; margin: 0;">
            <div class="control-label" id="" style="padding:25px 0;">Are you delete</div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="background-color: white; text-align: center;">
        <button type="button" style="width: 48%;float:left;" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" style="width: 48%;float:right;" class="btn btn-danger ">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- delete plan doctor -->





<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="<?=$LinkHostWeb;?>plugins/StickyTableHeaders/css/component.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
<script src="<?=$LinkHostWeb;?>plugins/StickyTableHeaders/js/jquery.stickyheader.js"></script>
