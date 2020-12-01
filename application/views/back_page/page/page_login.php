<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo form_open('Auth/doLogin'); ?>
                        <form role="form">
                            <fieldset>                                  
                                <?php if ($disp = $this->session->flashdata('logout_ok')) { ?>  
                                    <?php echo $disp; } ?>
                                    <?php if ($disp = $this->session->flashdata('login')) { ?>  
                                        <?php echo $disp; } ?>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control"  name="username" type="text" autofocus required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" name="password" type="password" value="" required="">
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                            </label>
                                        </div>
                                        <!-- Change this to a button or input when using this as a form -->
                                        <button class="btn btn-primary btn-block" type="submit" value="true">Login</button> 
                                    </fieldset>
                                </form>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(".closealert").fadeTo(2000, 500).slideUp(500, function(){
            $(".closealert").slideUp(500);
        });
    </script>