<?php
defined('BASEPATH') or exit('Akses langsung tidak diperbolehkan');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('view_login');
    }

    public function proses_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        log_message('debug', 'Proses login dimulai');
        log_message('debug', 'Username: ' . $username);
        log_message('debug', 'Password: ' . $password);

        // Cek username dan password di database
        $user = $this->db->where('username', $username)->where('password', $password)->get('user')->row();

        if ($user) {
            // Set session untuk pengguna yang berhasil login
            $this->session->set_userdata(['user_id' => $user->id]);
            log_message('debug', 'Login sukses, session user_id diset: ' . $user->id);

            // Arahkan ke halaman dashboard
            redirect('dashboard');
        } else {
            log_message('debug', 'Login gagal, username atau password salah');
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('login');
        }
    }
}
?>
