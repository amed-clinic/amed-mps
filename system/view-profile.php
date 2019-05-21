<div class="row">
  <div class="col-md-6 col-xs-12">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#settings" data-toggle="tab">Profile</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="settings">

          <form class="form-horizontal" action="<?=$LinkPath;?>" method="post">
            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">Sale Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ep_FName" name="ep_FName" placeholder="Sale Name" value="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputName" class="col-sm-3 control-label">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="ep_UserName" name="ep_UserName" placeholder="Username" readonly value="">
              </div>

            </div>
            <div class="form-group">
              <label for="inputPass" class="col-sm-3 control-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="ep_Password" name="ep_Password" placeholder="Password" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputRePass" class="col-sm-3 control-label">Re-Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="ep_RePassword" name="ep_RePassword" placeholder="Re-Password" required>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="ep_CheckConfirm" name="ep_CheckConfirm" required>Confirm <!--<a href="#">terms and conditions</a>-->
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger" name="ep_SubmitUpdate" id="ep_SubmitUpdate">Update Profile</button>
              </div>
            </div>
          </form>




        </div>
      </div>
    </div>
  </div>
</div>
