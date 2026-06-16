<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('commentmodel');
	}

	// Fungsi untuk menambahkan komentar dan rating
	public function add()
	{
		$data = [
			'id_buku' => $this->input->post('id_buku'),
			'username' => $this->input->post('username'),
			'comment' => $this->input->post('comment'),
			'rating' => $this->input->post('rating')
		];

		if ($this->commentmodel->add_comment($data)) {
			echo "Data berhasil disimpan!";
		} else {
			echo "Gagal menyimpan data.";
		}
		redirect('buku/detail/' . $data['id_buku']);
	}

	public function get_rating($id_buku)
	{
		$rating = $this->commentmodel->get_average_rating($id_buku);
		echo json_encode(['rating' => $rating]);
	}

	// Fungsi untuk mengambil komentar terkait eBook
	public function get_comments($id_buku)
	{
		$this->db->select('username, comment, rating, created_at');
		$this->db->where('id_buku', $id_buku);
		$this->db->order_by('created_at', 'DESC');
		return $this->db->get('comments')->result();
	}
}
