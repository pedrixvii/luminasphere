<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bukumodel');
		$this->load->model('slidersmodel');
		$this->load->model('commentmodel');
	}

	public function staff()
	{
		// Hanya petugas yang bisa mengakses halaman ini
		if ($this->session->userdata('role') !== 'staff') {
			$this->session->set_flashdata('error', 'Lu ngapain bjir? 😹😂');

			// Kembali ke halaman sebelumnya jika tersedia, jika tidak, arahkan ke halaman login
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('auth/login');
			redirect($referer);
		}
		$this->check_role('staff');
		$this->load->view('template_staff/header');
		$this->load->view('template_staff/sidebar');
		$this->load->view('dashboard_staff/dashboard');
		$this->load->view('template_staff/footer');
	}
	public function admin()
	{
		if ($this->session->userdata('role') !== 'admin') {
			$this->session->set_flashdata('error', 'Lu ngapain bjir? 😹😂');

			// Kembali ke halaman sebelumnya jika tersedia, jika tidak, arahkan ke halaman login
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('auth/login');
			redirect($referer);
		}
		$this->db->select('user.username, user.email, peminjaman.tanggal_peminjaman, peminjaman.tanggal_pengembalian');
		$this->db->from('peminjaman');
		$this->db->join('user', 'user.id_user = peminjaman.id_user');
		$this->db->where('peminjaman.status_peminjaman', 'dipinjam');
		$query = $this->db->get();

		$data['user_peminjam'] = $query->result(); // <-- Pastikan ini dimasukkan dalam array data

		// Ambil rating tertinggi dari tabel comments
		$this->db->select_max('rating');
		$query = $this->db->get('comments');
		$rating_tertinggi = $query->row()->rating ?? 0;

		// Hitung jumlah buku yang memiliki rating tertinggi
		$this->db->select('COUNT(DISTINCT id_buku) AS jumlah_buku_tertinggi');
		$this->db->from('comments');
		$this->db->where('rating', $rating_tertinggi);
		$jumlah_buku_tertinggi = $this->db->get()->row()->jumlah_buku_tertinggi ?? 0;

		// Ambil daftar buku dengan rating tertinggi
		$this->db->select('buku.title, comments.rating');
		$this->db->from('comments');
		$this->db->join('buku', 'buku.id_buku = comments.id_buku');
		$this->db->where('comments.rating', $rating_tertinggi);
		$this->db->group_by('comments.id_buku');
		$this->db->order_by('buku.title', 'ASC');
		$buku_tertinggi = $this->db->get()->result();

		$data['rating_tertinggi'] = $rating_tertinggi;
		$data['jumlah_buku_tertinggi'] = $jumlah_buku_tertinggi;
		$data['buku_tertinggi'] = $buku_tertinggi;

		// Ambil jumlah eBook
		$jumlah_ebook = $this->db->count_all('buku');

		// Ambil jumlah user yang sedang meminjam
		$this->db->select('COUNT(*) AS jumlah_user_pinjam');
		$this->db->from('peminjaman');
		$this->db->where('status_peminjaman', 'dipinjam');
		$jumlah_user_pinjam = $this->db->get()->row()->jumlah_user_pinjam;


		// Ambil jumlah genre eBook
		$jumlah_genre = $this->db->count_all('genre');

		// Ambil data jumlah sebelumnya dari session (jika ada)
		$previous_ebook_count = $this->session->userdata('previous_ebook_count') ?? $jumlah_ebook;
		$previous_user_count = $this->session->userdata('previous_user_count') ?? $jumlah_user_pinjam;
		$previous_genre_count = $this->session->userdata('previous_genre_count') ?? $jumlah_genre;

		// Hitung perubahan jumlah (bukan persen)
		$ebook_change = $jumlah_ebook - $previous_ebook_count;
		$user_change = $jumlah_user_pinjam - $previous_user_count;
		$genre_change = $jumlah_genre - $previous_genre_count;

		// Update sesi dengan data terbaru
		$this->session->set_userdata([
			'previous_ebook_count' => $jumlah_ebook,
			'previous_user_count' => $jumlah_user_pinjam,
			'previous_genre_count' => $jumlah_genre,
		]);

		// Kirim data ke view
		$data['jumlah_ebook'] = $jumlah_ebook;
		$data['jumlah_user_pinjam'] = $jumlah_user_pinjam;
		$data['jumlah_genre'] = $jumlah_genre;
		$data['ebook_change'] = $ebook_change;
		$data['user_change'] = $user_change;
		$data['genre_change'] = $genre_change;

		$this->check_role('admin');

		$this->load->view('template_admin/header');
		$this->load->view('template_admin/sidebar');
		$this->load->view('dashboard_admin/dashboard', $data);
		$this->load->view('template_admin/footer');
	}

	public function user()
	{
		if ($this->session->userdata('role') !== 'user') {
			$this->session->set_flashdata('error', 'Anda tidak mempunyai akses kesini');

			// Kembali ke halaman sebelumnya jika tersedia, jika tidak, arahkan ke halaman login
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('auth/login');
			redirect($referer);
		}

		$this->check_role('user');
		$data['top_views'] = $this->bukumodel->get_top_views();
		$data['new_books'] = $this->bukumodel->get_new_books();
		$data['sliders'] = $this->slidersmodel->get_sliders();
		$data['genres'] = $this->bukumodel->getGenres();
		$data['buku_by_genre'] = $this->bukumodel->getBooksByGenre();

		// Ambil data user, termasuk foto user
		$id_user = $this->session->userdata('id_user');
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row();

		// Pastikan foto user tersedia, jika tidak gunakan default
		$data['foto'] = (!empty($user->foto) && file_exists('./upload/foto_user/' . $user->foto)) ? $user->foto : 'ppfarel.jpg.';

		// Pastikan semua view mendapatkan data
		$this->load->view('template_user/header', $data);
		$this->load->view('halaman_user/view_user', $data);
		$this->load->view('template_user/sidebar', $data);
		$this->load->view('template_user/footer', $data);
	}


	private function check_role($required_role)
	{
		if ($this->session->userdata('role') != $required_role) {
			redirect('auth/login');
		}
	}
}
