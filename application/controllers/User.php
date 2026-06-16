<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('bukumodel');
		$this->load->library('session');
	}
	public function search()
	{
		$id_user = $this->session->userdata('id_user');
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row();

		// Pastikan foto user tersedia, jika tidak gunakan default
		$data['foto'] = (!empty($user->foto) && file_exists('./upload/foto_user/' . $user->foto)) ? $user->foto : 'ppfarel.jpg';

		$keyword = $this->input->get('keyword');
		$filter = $this->input->get('filter');

		$this->db->select('buku.*, genre.genre');
		$this->db->from('buku');
		$this->db->join('genre', 'buku.id_genre = genre.id_genre', 'left');

		// Filter berdasarkan input user
		if ($filter == "title") {
			$this->db->like('buku.title', $keyword);
		} elseif ($filter == "author") {
			$this->db->like('buku.authors', $keyword);
		} elseif ($filter == "genre") {
			$this->db->like('genre.genre', $keyword);
		} elseif ($filter == "isbn") {
			$this->db->where('buku.isbn', $keyword);
		}

		$query = $this->db->get();
		$buku = $query->result();

		// Kelompokkan berdasarkan genre
		$buku_by_genre = [];

		if (!empty($buku)) {
			foreach ($buku as $bku) {
				$genre = !empty($bku->genre) ? $bku->genre : 'Tanpa Genre';
				$buku_by_genre[$genre][] = $bku;
			}
		} else {
			$buku_by_genre['Tanpa Genre'] = [];
		}

		$data['buku_by_genre'] = $buku_by_genre;

		// **Tambahkan $data['foto'] agar tersedia di view**
		$this->load->view('template_user/header', $data);
		$this->load->view('halaman_user/view_user', $data);
		$this->load->view('template_user/footer', $data);
	}

	public function buku_dipinjam()
	{
		$id_user = $this->session->userdata('id_user');
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row();

		if (!$user) {
			show_404();
		}

		// Ambil buku yang sedang dipinjam oleh user
		$this->db->select('peminjaman.*, buku.*, genre.genre, 
		(SELECT COUNT(*) FROM comments WHERE comments.id_buku = buku.id_buku) AS comment_count, 
		(SELECT AVG(rating) FROM comments WHERE comments.id_buku = buku.id_buku) AS rating');
		$this->db->from('peminjaman');
		$this->db->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left');
		$this->db->join('genre', 'genre.id_genre = buku.id_genre', 'left');
		$this->db->where('peminjaman.id_user', $id_user);
		$this->db->where('peminjaman.status_peminjaman', 'dipinjam');
		$this->db->order_by('peminjaman.tanggal_peminjaman', 'DESC');

		$buku_dipinjam = $this->db->get()->result();

		$data['buku_dipinjam'] = $buku_dipinjam;
		$data['user'] = $user;
		$data['foto'] = (!empty($user->foto) && file_exists(FCPATH . 'upload/foto_user/' . $user->foto)) ? $user->foto : 'default.jpg';

		$this->load->view('template_user/header', $data);
		$this->load->view('halaman_user/buku_dipinjam', $data);
		$this->load->view('template_user/footer');
	}
}
