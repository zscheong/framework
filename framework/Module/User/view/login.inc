<h2>Login</h2>

<div class='container-fluid'>
    <div class='col-sm-offset-3 col-sm-6'>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <form id="form_login" role="form" method="POST" action='' onsubmit="">
                    <input type="hidden" name="txt_action" id="txt_action" value="frm_login_submit">
                    <div class="form-group">
                        <label for="txt_mobile_number">User Name</label>
                        <input type="text" class="form-control" id="txt_mobile_number" name="txt_mobile_number" autocomplete="off" tabindex="1" required>
                    </div>
                    <div class="form-group">
                        <label class="" for="txt_passwd">Password</label>
                        <input type="password" class="form-control" id="txt_passwd" name="txt_passwd" tabindex="2" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-6 col-sm-6">
                            <button type="submit" tabindex="6" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

