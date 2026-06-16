<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('authmodel');
		$this->load->library('form_validation');
		$this->load->library('session');
	}


	public function register_user()
	{
		$this->load->view('auth/registeruser');
	}
	public function login()
	{
		$this->load->view('auth/login');
	}

	public function create_register_user()
	{
		$config['upload_path']   = './upload/foto_user/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048; // Maksimal 2MB
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('foto')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('auth/register_user');
		} else {
			$upload_data = $this->upload->data();
			$foto = $upload_data['file_name'];
		}

		$data = [
			'username'     => $this->input->post('username'),
			'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
			'email'        => $this->input->post('email'),
			'namalengkap'  => $this->input->post('namalengkap'),
			'nis'          => $this->input->post('nis'),
			'kelas'        => $this->input->post('kelas'),
			'foto'         => $foto,
			'role'         => 'user',
			'poin' => 100
		];

		$this->authmodel->register($data);
		$this->session->set_flashdata('success', 'Registrasi berhasil!');
		redirect('auth/login');
	}

	public function register_staff()
	{
		$this->load->view('auth_staff/register_staffonly');
	}
	public function create_register_staff()
	{
		$username = $this->input->post('username');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$email = $this->input->post('email');
		$namalengkap = $this->input->post('namalengkap');
		$alamat = $this->input->post('alamat');

		$data = [
			'username' => $username,
			'password' => $password,
			'email' => $email,
			'namalengkap' => $namalengkap,
			'alamat' => $alamat,
			'role' => 'staff',
		];

		$this->authmodel->register($data);
		redirect('auth/login');
	}

	public function attempt_login()
	{

		$username = $this->input->post('username', true);
		$password = $this->input->post('password', true);

		// Check user credentials
		$user = $this->authmodel->validate_user($username, $password);

		if ($user) {
			// Set session data
			$session_data = [
				'id_user' => $user->id_user,
				'username' => $user->username,
				'email' => $user->email,
				'namalengkap' => $user->namalengkap,
				'alamat' => $user->alamat,
				'role' => $user->role,
				'foto' => $user->foto,
				'is_logged_in' => true
			];
			$this->session->set_userdata($session_data);
			// Redirect based on role
			// Redirect berdasarkan role
			if ($user->role === 'admin') {
				redirect('dashboard/admin');
			} elseif ($user->role === 'staff') {
				redirect('dashboard/staff');
			} else {
				redirect('dashboard/user');
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid username or password.');
			redirect(base_url('auth/login'));
		}
	}

	public function logout()
	{
		// Hapus semua data session
		$this->session->sess_destroy();

		// Redirect ke halaman login
		redirect('auth/login');
	}
}
