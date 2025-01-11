<?php
defined('BASEPATH') or exit('Akses langsung tidak diperbolehkan');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Memuat model yang diperlukan
        $this->load->model('User_model');

        // Periksa apakah pengguna sudah login
        log_message('debug', 'Session User ID: ' . $this->session->userdata('user_id'));
        if (!$this->session->userdata('user_id') && $this->router->fetch_class() !== 'login') {
            redirect('login');
        }
    }

    public function index()
    {
        // Ambil data semua pengguna dari database
        $q = $this->User_model->getUserAll();
        $data['users'] = $q->result();

        // Memuat tampilan dashboard dan mengirimkan data pengguna
        $this->load->view('view_dashboard', $data);
    }

    public function add()
    {
        $this->load->view('view_add_user');
    }

    public function save()
    {
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');

        $insert = $this->User_model->insertUser($data);

        if ($insert) {
            redirect('dashboard');  // Arahkan ke halaman dashboard setelah data berhasil disimpan
        } else {
            echo 'Data gagal disimpan';
        }
    }

    public function ajax_save()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Validasi: username harus unik
        $exists = $this->User_model->getUserByUsername($username);
        if ($exists->num_rows() > 0) {
            echo json_encode(['status' => false, 'message' => 'Username sudah digunakan']);
            return;
        }

        $data = ['username' => $username, 'password' => $password];
        $insert = $this->User_model->insertUser($data);

        echo json_encode([
            'status' => $insert ? true : false,
            'message' => $insert ? 'Pengguna berhasil ditambahkan' : 'Gagal menambahkan pengguna'
        ]);
    }

    public function edit($id = null){
        $userId = $this->session->userdata('user_id');
        
        // Mengecek jika yang ingin diedit adalah akun pengguna yang sedang login
        if ($id == $userId) {
            $this->session->set_flashdata('notification', 'Anda tidak dapat mengedit akun Anda sendiri!');
            redirect('dashboard');
        }

        $q = $this->User_model->getUserByID($id);
        $data['user'] = $q->row();

        $this->load->view('view_edit_user', $data);
    }

    public function update_user()
    {
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $data = array(
            'username' => $username,
            'password' => $password
        );

        $update = $this->User_model->updateUser($id, $data);

        if ($update) {
            redirect('dashboard', 'refresh');
        } else {
            $this->session->set_flashdata('update_error', 'Data gagal diperbarui');
            redirect('dashboard/edit/' . $id, 'refresh');
        }
    }

    public function delete($id = null){
        $userId = $this->session->userdata('user_id');
        
        // Mengecek jika yang ingin dihapus adalah akun pengguna yang sedang login
        if ($id == $userId) {
            $this->session->set_flashdata('notification', 'Anda tidak dapat menghapus akun Anda sendiri!');
            redirect('dashboard');
        }
    
        $this->User_model->deleteUser($id);
        redirect('dashboard');
    }
}
?>
