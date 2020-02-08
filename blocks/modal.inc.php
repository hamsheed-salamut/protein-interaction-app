<div id="register" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="panel-title">Please register<small> It's free!</small></h3>
      </div>
      <div class="modal-body">
        
        <form role="form">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <input type="text" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm" placeholder="Confirm Password">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <input type="submit" value="Register" class="btn btn-info btn-block">
          </div>
        </form> 
      </div>
    </div>
  </div>
</div>

<div id="login" class="modal fade " role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content ">
      <div class="modal-header">
        <h3 class="panel-title">Log in</h3>
      </div>
      <div class="modal-body">
        <div class="panel-body">
          <form action="admin/admin.php" method="post" role="form">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                  <div class="icon-addon addon-md">
                      <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username">
                      <label for="username" class="fa fa-user" rel="tooltip" title="username"></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <div class="icon-addon addon-md">
                      <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password">
                      <label for="password" class="fa fa-key" rel="tooltip" title="password"></label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <input type="submit" value="Log in" class="btn btn-info btn-block">
              </div>
            </div>
          </form>
        </div>
      </div>      
    </div>
  </div>
</div>