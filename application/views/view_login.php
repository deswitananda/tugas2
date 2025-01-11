<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('public/template/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="row justify-content-center">
        <div class="card col-md-8 mt-5 ">
            <div class="card-header">
                <h1>Sign In</h1>
            </div>
            <div class="card-body">
                <div class="form-login">
                    <form action="<?php echo base_url('login/proses_login'); ?>" method="post">
                        <div class="mb-1">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-1">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3 ">Login</button>
                    </form>
                    <div>
                        <?php
                        echo '<p class="text-danger">', null !== $this->session->flashdata('error') ? $this->session->flashdata('error') : '', '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('public/template/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/template/js/jquery-3.7.1.min.js'); ?>"></script>

</body>

</html>
