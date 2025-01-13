<!DOCTYPE html>
<html lang="en">

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
                <h1>Halaman Dashboard</h1>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('notification')): ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('notification'); ?></div>
                <?php endif; ?>

                <div class="d-flex justify-content-between mb-3">
                    <button type="button" class="btn btn-primary btnTambahUser" data-bs-toggle="modal" data-bs-target="#modal-user">+ Add User</button>
                    <a href="<?= base_url('login/logout'); ?>" class="btn btn-danger">Logout</a>
                </div>

                <div class="table-user">
                    <table class="table table-striped" id="tabelUser">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($users as $user) :
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->password ?></td>
                                    <td>
                                        <?php if ($this->session->userdata('user_id') == $user->id): ?>
                                            <button type="button" class="btn btn-secondary" disabled>Edit</button>
                                            <button type="button" class="btn btn-secondary" disabled>Delete</button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?= $user->id ?>" data-username="<?= $user->username ?>" data-password="<?= $user->password ?>">Edit</button>
                                            <a href="<?= base_url('dashboard/delete/' . $user->id); ?>" class="btn btn-danger">Delete</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah User -->
    <div class="modal" id="modal-user" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close " data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-user">
                        <form id="form_add_user" action="#" method="post">
                            <div class="mb-1">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="">
                                <div class="error-block"></div>
                            </div>
                            <div class="mb-1">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="">
                                <div class="error-block"></div>
                            </div>
                            <div class="mb-1">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="">
                                <div class="error-block"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editUserModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditUser" action="<?= base_url('dashboard/update_user'); ?>" method="post">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('public/template/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('public/template/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
        // Menambahkan user baru
        $('#form_add_user').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '<?= base_url('dashboard/ajax_save') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        var newRow = '<tr>' +
                            '<td>' + (<?= $no ?>) + '</td>' +
                            '<td>' + response.username + '</td>' +
                            '<td>' + response.password + '</td>' +
                            '<td>' +
                            '<a href="<?= base_url('dashboard/edit/'); ?>' + response.id + '" class="btn btn-primary">Edit</a> ' +
                            '<a href="<?= base_url('dashboard/delete/'); ?>' + response.id + '" class="btn btn-danger">Delete</a>' +
                            '</td>' +
                            '</tr>';
                        $('#userTableBody').append(newRow);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            });
        });

        // Ketika tombol Edit ditekan
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var username = button.getAttribute('data-username');
            var password = button.getAttribute('data-password');

            document.getElementById('editUserId').value = id;
            document.getElementById('editUsername').value = username;
            document.getElementById('editPassword').value = password;
        });

        // Save button function for adding user
        $('.saveBtn').on('click', function() {
            var id = $('#id').val();
            var username = $('#username').val();
            var password = $('#password').val();
            let url = '<?php echo base_url('dashboard/save'); ?>';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id: id,
                    username: username,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $('#modal-user').modal('hide');
                        tableUser();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    </script>
</body>

</html>
