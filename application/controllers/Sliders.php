<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sliders extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->model('slidersmodel');
	}

	public function index()
	{
		$data['sliders'] = $this->slidersmodel->get_sliders();
		$data['current_page'] = $this->uri->segment(1); // Mengambil segmen pertama dari URL
		$data['title'] = 'Data sliders';
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar', $data);
		$this->load->view('dashboard_admin/sliders', $data);
	}

	public function tambah_slider()
	{
		$config['upload_path']          = './slider/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 10000; // Ukuran maksimal file lebih besar
		$config['max_width']            = 10000; // Lebar maksimal lebih besar
		$config['max_height']           = 10000; // Tinggi maksimal lebih besar

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			// Jika upload gagal, tampilkan pesan error
			$error = array('error' => $this->upload->display_errors());
			print_r($error); // Anda dapat mengganti ini dengan view yang lebih baik
		} else {
			// Jika upload berhasil, simpan nama file dan data lainnya
			$image_path = $this->upload->data();
			$image_path = $image_path['file_name'];

			// Ambil input dari form
			$title = $this->input->post('title', TRUE);
			$description = $this->input->post('description', TRUE);

			// Buat array data untuk disimpan ke database
			$data_sliders = array(
				'image_path' => $image_path,
				'title' => $title,
				'description' => $description
			// Simpan fasilitas sebagai string
			);

			// Insert data kamar ke tabel
			$this->db->insert('sliders', $data_sliders);

			// Redirect ke halaman user
			redirect('sliders');
		}
	}

	public function update_edit($id_slider)
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->edit($id_slider);
		} else {
			// Konfigurasi upload image_path
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 2048;
			$config['file_name'] = uniqid();

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('userfile')) {
				// Jika image_path tidak diupload, gunakan data image_path yang lama
				$data_sliders = array(
					'image_path' => $image_path,
					'title' => $title,
					'description' => $description
				);
			} else {
				// Jika cover berhasil diupload, simpan cover baru
				$upload_data = $this->upload->data();
				$data_sliders = array(
					'image_path' => $image_path,
					'title' => $title,
					'description' => $description,
					'image_path' => $upload_data['file_name']
				);
			}
			$this->slidersmodel->updateSlider($id_slider, $data_sliders, 'sliders');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diupdate<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('sliders');
		}
	}

	public function delete()
	{
		$id_slider = $_GET['id'];
		$this->slidersmodel->deleteSlider($id_slider, 'sliders');
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('sliders');
	}

	public function _rules()
	{
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('des$description', 'des$description', 'trim|required');
		$this->form_validation->set_rules('publisher', 'Publisher', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('published_date', 'Published Date', 'trim|required');
	}

}
