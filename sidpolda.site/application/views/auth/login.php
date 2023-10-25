<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="login.html">
                    <img src="assets/login/images/polda.svg" alt="">
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <!-- <li><a href="register.html">Register</a></li> -->
                    <li><a href='auth/registration' class="btn btn-link top_register"><i class="dw dw-logout"
                                aria-hidden="true"></i> Sign Out</a></li>
                    <!-- <li><a href='auth/index' class="btn btn-link top_login"><i class="dw dw-login" aria-hidden="true"></i> <b>Sign In</b></button></li> -->
                </ul>
            </div>
        </div>
    </div>

    <?= $this->session->flashdata('message'); ?>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img class="pic_login" src="assets/login/images/log_sidpolda.png" alt="">
                    <!-- <img class="pic_register" src="assets/login/images/register.png" alt=""> -->
                </div>
                <div class="col-md-6 col-lg-5">
                    <!-- FORM LOGIN -->
                    <div class="login-box bg-white box-shadow border-radius-10 tampil_login">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To Apps</h2>
                        </div>
                        <form method="post" action="auth/index" autocomplete="off">
                            <div class="form-group">
                                <?php (empty(form_error('username')) ? $c_user = 'is-valid' : $c_user = 'is-invalid'); ?>
                                <input type="text" name="username" class="form-control form-control-lg <?= $c_user; ?>"
                                    placeholder="Username" value="<?= set_value('username') ?>">
                                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <?php (empty(form_error('password')) ? $c_pass = 'is-valid' : $c_pass = 'is-invalid'); ?>
                                <input type="password" name="password"
                                    class="form-control form-control-lg <?= $c_pass; ?>" placeholder="**********">
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button type="submit" class="btn btn-success btn-lg btn-block" name="login"><i
                                                class="icon-copy fa fa-send-o" aria-hidden="true"></i> Login</button>
                                        <!-- <button type="button" class="btn btn-primary btn-lg btn-block" id="login"><i class="fa fa-sign-in" aria-hidden="true"></i></i> Sign In</button> -->
                                    </div>
                                    <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR
                                    </div>
                                    <div class="input-group mb-0">
                                        <a href='auth/registration' class="btn btn-outline-primary btn-lg btn-block"><i
                                                class="dw dw-logout" aria-hidden="true"></i> Register</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>