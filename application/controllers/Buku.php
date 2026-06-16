<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Buku extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bukumodel');
		$this->load->model('commentmodel');
		$this->load->model('cekpeminjamanmodel');
		$this->load->model('genremodel');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->config('google_books');
		$this->load->library('zip');
		$this->load->library('upload');
	}

	//Internet Archive
	private function getArchiveUrl($title)
	{
		$query = urlencode($title);
		$url = "https://archive.org/advancedsearch.php?q=$query&output=json&rows=1";

		$response = file_get_contents($url);
		if ($response) {
			$data = json_decode($response, true);
			if (isset($data['response']['docs'][0]['identifier'])) {
				$identifier = $data['response']['docs'][0]['identifier'];
				return 'https://archive.org/details/' . $identifier;
			}
		}
		return ''; // Jika tidak ditemukan
	}


	public function detail($id_buku)
	{
		// Ambil data buku + genre + rating
		$this->db->select('buku.*, genre.genre, (SELECT AVG(rating) FROM comments WHERE comments.id_buku = buku.id_buku) as rating');
		$this->db->from('buku');
		$this->db->join('genre', 'genre.id_genre = buku.id_genre', 'left'); // Join genre
		$this->db->where('buku.id_buku', $id_buku);
		$data['buku'] = $this->db->get()->row_array();

		if (!$data['buku']) {
			show_404(); // Jika buku tidak ditemukan, tampilkan halaman 404
		}

		// Ambil ID user dari session
		$id_user = $this->session->userdata('id_user');

		// Ambil data user dari database
		$user = $this->db->get_where('user', ['id_user' => $id_user])->row();

		// Pastikan foto user tersedia, jika tidak gunakan default
		$data['foto'] = (!empty($user->foto) && file_exists('./upload/foto_user/' . $user->foto)) ? $user->foto : 'ppfarel.jpg';

		// Cek apakah user sudah meminjam buku ini
		$this->db->select('id_peminjaman, id_user, id_buku, status_peminjaman, status');
		$this->db->from('peminjaman');
		$this->db->where('id_user', $id_user);
		$this->db->where('id_buku', $id_buku);
		$this->db->order_by('id_peminjaman', 'DESC'); // Ambil data terbaru
		$peminjaman = $this->db->get()->row();

		if ($peminjaman && $peminjaman->status_peminjaman === 'dipinjam') {
			$data['sudah_dipinjam'] = true;
			$data['status'] = $peminjaman->status;
			$data['id_peminjaman'] = $peminjaman->id_peminjaman;
		} else {
			$data['sudah_dipinjam'] = false; // Ini yang memastikan user bisa pinjam ulang
			$data['status'] = null;
			$data['id_peminjaman'] = null;
		}

		// Force reload cache (untuk memastikan data terbaru diambil)
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
		$this->output->set_header('Pragma: no-cache');

		// Hitung view hanya sekali per sesi
		if (!$this->session->has_userdata('viewed_' . $id_buku)) {
			$this->bukumodel->increase_views($id_buku);
			$this->session->set_userdata('viewed_' . $id_buku, TRUE);
		}

		// Load komentar dari model
		$data['comment'] = $this->commentmodel->get_comments_by_book($id_buku);

		$this->load->view('template_user/header', $data);
		$this->load->view('halaman_user/detail_buku', $data);
		$this->load->view('template_user/footer', $data);
	}




	public function index($page = 0)
	{

		// Konfigurasi Pagination
		$config['base_url'] = base_url('buku/index'); // URL pagination
		$config['total_rows'] = $this->bukumodel->getTotalBooks(); // Jumlah total buku
		$config['per_page'] = 5; // Jumlah buku per halaman
		$config['uri_segment'] = 3; // Posisi segment untuk pagination di URL

		// Styling Pagination Bootstrap 5
		$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item next">';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		$this->pagination->initialize($config);

		// Ambil data buku dengan limit pagination
		$data['buku'] = $this->bukumodel->getBuku($config['per_page'], $page);
		$data['total_buku'] = $config['total_rows'];
		$data['current_page'] = ($page / $config['per_page']) + 1; // Hitung halaman aktif
		$data['genre'] = $this->db->get('genre')->result_array();
		$data['title'] = 'Data Buku';
		$data['pagination'] = $this->pagination->create_links(); // Generate link pagination

		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar', $data);
		$this->load->view('dashboard_admin/databuku', $data);
	}


	public function tambah_ebook_link()
	{
		$title = $this->input->post('title');
		$archive_url = $this->getArchiveUrl($title); // Fungsi untuk ambil link

		$data_buku = [
			'title'          => $title,
			'archive_url'    => $archive_url,
			'thumbnail'      => $thumbnail,
			'file_ebook'     => $file_ebook,
			'id_genre' 		 => $this->input->post('id_genre', TRUE),
			'authors'        => $this->input->post('authors', TRUE),
			'publisher'      => $this->input->post('publisher', TRUE),
			'description'    => $this->input->post('description', TRUE),
			'stock'          => $this->input->post('stock', TRUE),
			'published_date' => $this->input->post('published_date', TRUE),
			'source_type'   => 'link'
		];

		$this->db->insert('buku', $data_buku);
		redirect('buku');
	}
	public function tambah_buku()
	{


		// **Konfigurasi upload untuk thumbnail**
		$config_thumb = [
			'upload_path'   => '././upload/thumbnails/',
			'allowed_types' => 'gif|jpg|png|jpeg',
			'max_size'      => 2048,
			'file_name'     => time() . '_' . $_FILES['thumbnail']['name']
		];

		$thumbnail = '';
		$this->upload->initialize($config_thumb);
		if (!empty($_FILES['thumbnail']['name']) && $this->upload->do_upload('thumbnail')) {
			$thumbnail_data = $this->upload->data();
			$thumbnail = $thumbnail_data['file_name'];
		}

		// **Konfigurasi upload untuk file PDF**
		$config_pdf = [
			'upload_path'   => './upload/ebooks/',
			'allowed_types' => 'pdf|epub|mobi',
			'max_size'      => 200000,
			'file_name'     => time() . '_' . $_FILES['file_ebook']['name']
		];

		$file_ebook = '';
		$this->upload->initialize($config_pdf);
		if (!empty($_FILES['file_ebook']['name']) && $this->upload->do_upload('file_ebook')) {
			$pdf_data = $this->upload->data();
			$file_ebook = $pdf_data['file_name'];
		}

		// **Data buku**
		$data_buku = [
			'thumbnail'      => $thumbnail,
			'file_ebook'     => $file_ebook,
			'isbn'           => $this->input->post('isbn', TRUE),
			'id_genre'       => $this->input->post('id_genre', TRUE),
			'title'          => $this->input->post('title', TRUE),
			'authors'        => $this->input->post('authors', TRUE),
			'publisher'      => $this->input->post('publisher', TRUE),
			'description'    => $this->input->post('description', TRUE),
			'stock'          => $this->input->post('stock', TRUE),
			'published_date' => $this->input->post('published_date', TRUE),
			'jenis_buku'     => $this->input->post('jenis_buku', TRUE),
		];

		$this->db->insert('buku', $data_buku);
		$this->session->set_flashdata('success', 'Buku berhasil ditambahkan.');
		redirect('buku');
	}


	public function update_edit()
	{
		if (empty($_POST)) {
			$this->session->set_flashdata('error', 'Tidak ada data yang dikirim.');
			redirect('buku');
		}

		$id_buku = $this->input->post('id_buku');

		// **Ambil data lama agar tidak hilang saat edit**
		$this->db->where('id_buku', $id_buku);
		$oldData = $this->db->get('buku')->row();

		if (!$oldData) {
			$this->session->set_flashdata('error', 'Buku tidak ditemukan.');
			redirect('buku');
		}

		$data = [
			'isbn'           => $this->input->post('isbn') ?? $oldData->isbn,
			'id_genre'       => $this->input->post('id_genre') ?? $oldData->id_genre,
			'title'          => $this->input->post('title') ?? $oldData->title,
			'authors'        => $this->input->post('authors') ?? $oldData->authors,
			'publisher'      => $this->input->post('publisher') ?? $oldData->publisher,
			'description'    => $this->input->post('description') ?? $oldData->description,
			'stock'          => $this->input->post('stock') ?? $oldData->stock,
			'published_date' => $this->input->post('published_date') ?? $oldData->published_date,
			'jenis_buku'     => $this->input->post('jenis_buku') ?? $oldData->jenis_buku,
			'thumbnail'      => $oldData->thumbnail,
			'file_ebook'     => $oldData->file_ebook
		];

		$this->load->library('upload');

		// **1. Cek apakah user upload thumbnail baru**
		if (!empty($_FILES['thumbnail']['name'])) {
			$config_thumb = [
				'upload_path'   => './upload/thumbnails/',
				'allowed_types' => 'gif|jpg|png|jpeg',
				'max_size'      => 2048,
				'file_name'     => time() . '_' . $_FILES['thumbnail']['name']
			];

			$this->upload->initialize($config_thumb);

			if ($this->upload->do_upload('thumbnail')) {
				$uploadData = $this->upload->data();
				$data['thumbnail'] = $uploadData['file_name'];

				// **Hapus thumbnail lama jika ada**
				if (!empty($oldData->thumbnail) && file_exists('./upload/thumbnails/' . $oldData->thumbnail)) {
					unlink('./upload/thumbnails/' . $oldData->thumbnail);
				}
			} else {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('buku');
			}
		}

		// **2. Cek apakah user upload file eBook baru**
		if (!empty($_FILES['file_ebook']['name'])) {
			$config_pdf = [
				'upload_path'   => './upload/ebooks/',
				'allowed_types' => 'pdf|epub|mobi',
				'max_size'      => 200000,
				'file_name'     => time() . '_' . $_FILES['file_ebook']['name']
			];

			$this->upload->initialize($config_pdf);

			if ($this->upload->do_upload('file_ebook')) {
				$uploadData = $this->upload->data();
				$data['file_ebook'] = $uploadData['file_name'];

				// **Hapus file eBook lama jika ada**
				if (!empty($oldData->file_ebook) && file_exists('./upload/ebooks/' . $oldData->file_ebook)) {
					unlink('./upload/ebooks/' . $oldData->file_ebook);
				}
			} else {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('buku');
			}
		}

		// **3. Update buku dengan data yang telah diperbaiki**
		if ($this->bukumodel->update_book($id_buku, $data)) {
			$this->session->set_flashdata('success', 'Buku berhasil diperbarui');
		} else {
			$this->session->set_flashdata('error', 'Gagal memperbarui buku');
		}

		redirect('buku');
	}


	public function delete($id_buku)
	{
		if ($this->bukumodel->delete($id_buku)) {
			$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		} else {
			$this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus buku.');
		}
		redirect('buku');
	}


	public function _rules()
	{
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('authors', 'Authors', 'trim|required');
		$this->form_validation->set_rules('publisher', 'Publisher', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('published_date', 'Published Date', 'trim|required');
	}
}
