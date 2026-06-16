<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Commentmodel extends CI_Model
{

	public function add_comment($data)
	{
		// Pastikan 'username' ada dalam data yang dikirimkan
		$data['username'] = $this->session->userdata('username'); // Ambil username dari session jika diperlukan
		return $this->db->insert('comments', $data);
	}

	public function get_average_rating($id_buku)
	{
		$this->db->select_avg('rating');
		$this->db->where('id_buku', $id_buku);
		$query = $this->db->get('comments');

		if ($query->num_rows() > 0 && $query->row()->rating !== null) {
			return round($query->row()->rating, 1); // Dibulatkan ke 1 angka desimal
		} else {
			return 0; // Jika tidak ada rating, kembalikan 0
		}
	}



	public function get_comments_by_book($id_buku)
	{
		$this->db->select('comments.*, user.username, user.foto');
		$this->db->from('comments');
		$this->db->join('user', 'user.username = comments.username', 'left');
		$this->db->where('comments.id_buku', $id_buku);
		$query = $this->db->get();
		return $query->result_array();
	}
}
