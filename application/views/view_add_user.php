<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url('public/template/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body>
    <div class="row justify-content-center">
        <div class="card col-md-8 mt-5 ">
            <div class="card-header">
                <h1>Add User</h1>
            </div>
            <div class="card-body">
                <div class="form-user">
                    <form action="<?php echo base_url('dashboard/save'); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-1">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="">
                            <div class="error-block"></div>
                        </div>
                        <div class="mb-1">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value="">
                            <div class="error-block"></div>
                        </div>

                        <button type="submit" id="saveBtn" class="btn btn-primary mt-3 ">Simpan</button>
                    </form>

                    <div>
                        <?php
                        echo '<p class="text-danger">', null !== $this->session->flashdata('update_error') ? $this->session->flashdata('insert_error') : '', '</p>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('public/template/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/template/js/jquery-3.7.1.min.js'); ?>"></script>

    <script>
        $(document).ready(function () {
            $('#saveBtn').click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '<?php echo base_url('dashboard/ajax_save'); ?>',
                    type: 'POST',
                    data: {
                        username: $('#username').val(),
                        password: $('#password').val()
                    },
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        if (response.status) {
                            location.href = '<?php echo base_url('dashboard'); ?>';
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
