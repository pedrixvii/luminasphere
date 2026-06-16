<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserSettings extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('authmodel');
		$this->load->library('session');
		$this->load->helper('url');

		if (!$this->session->userdata('id_user')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row();

		if (!$user) {
			show_404();
		}

		$data['poin'] = $user->poin ?? 0;
		$data['user'] = $user;
		$data['foto'] = (!empty($user->foto) && file_exists(FCPATH . 'upload/foto_user/' . $user->foto)) ? $user->foto : 'default.jpg';

		$this->load->view('template_user/header', $data);
		$this->load->view('halaman_user/settingsakun', $data);
		$this->load->view('template_user/footer');
	}

	public function update_profile()
	{
		$id_user = $this->session->userdata('id_user');

		if (!$id_user) {
			$this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
			redirect('auth');
		}

		$data = [
			'username'    => $this->input->post('username'),
			'email'       => $this->input->post('email'),
			'namalengkap' => $this->input->post('namalengkap'),
			'alamat'      => $this->input->post('alamat'),
			'nis'         => $this->input->post('nis'),
			'kelas'       => $this->input->post('kelas')
		];

		if (!empty($_FILES['foto']['name'])) {
			$config['upload_path']   = './upload/foto_user/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size']      = 2048;
			$config['file_name']     = time() . '_' . $_FILES['foto']['name'];

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('foto')) {
				$uploadData = $this->upload->data();
				$data['foto'] = $uploadData['file_name'];
			} else {
				$this->session->set_flashdata('error', 'Gagal mengunggah foto: ' . $this->upload->display_errors());
				redirect('usersettings');
			}
		}

		if ($this->authmodel->update_user($id_user, $data)) {
			$this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
		} else {
			$this->session->set_flashdata('error', 'Gagal memperbarui profil.');
		}

		redirect('usersettings');
	}

	public function change_password()
	{
		$id_user = $this->session->userdata('id_user');
		$old_password = $this->input->post('old_password');
		$new_pass = $this->input->post('new_pass');

		$user = $this->authmodel->get_user($id_user);

		if (password_verify($old_password, $user['password'])) {
			if ($this->authmodel->change_password($id_user, $new_pass)) {
				$this->session->set_flashdata('success', 'Password berhasil diperbarui.');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui password.');
			}
		} else {
			$this->session->set_flashdata('error', 'Password lama salah.');
		}
		redirect('halaman_user/settingakun');
	}

	public function delete_account()
	{
		$id_user = $this->session->userdata('id_user');

		if ($this->authmodel->delete_user($id_user)) {
			$this->session->sess_destroy();
			redirect('login');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus akun.');
			redirect('halaman_user/settingakun');
		}
	}
}
