<?php
class Bukumodel extends CI_Model
{
	public function pinjam_ebook($id_buku, $id_user)
	{
		$buku = $this->db->get_where('buku', ['id' => $id_buku])->row();

		if ($buku && $buku->stock > 0) {
			// Kurangi stok eBook
			$this->db->set('stock', 'stock-1', false)
				->where('id', $id_buku)
				->update('buku');

			// Simpan data peminjaman
			$this->db->insert('peminjaman', [
				'id_buku' => $id_buku,
				'id_user' => $id_user,
				'tanggal_pinjam' => date('Y-m-d'),
				'status' => 'dipinjam'
			]);

			return 'Berhasil dipinjam';
		} else {
			// Tambahkan ke antrian jika stok habis
			$this->db->insert('antrian_peminjaman', [
				'id_buku' => $id_buku,
				'id_user' => $id_user,
				'status' => 'menunggu'
			]);

			return 'Ditambahkan ke antrian';
		}
	}

	// Fungsi untuk mengembalikan eBook
	public function kembalikan_ebook($id_peminjaman)
	{
		$peminjaman = $this->db->get_where('peminjaman', ['id' => $id_peminjaman])->row();

		if ($peminjaman) {
			// Update status peminjaman
			$this->db->set('status', 'dikembalikan')
				->where('id', $id_peminjaman)
				->update('peminjaman');

			// Tambahkan stok kembali
			$this->db->set('stock', 'stock+1', false)
				->where('id', $peminjaman->id_buku)
				->update('buku');

			// Proses antrian
			$antrian = $this->db->get_where('antrian_peminjaman', [
				'id_buku' => $peminjaman->id_buku,
				'status' => 'menunggu'
			])->row();

			if ($antrian) {
				$this->pinjam_ebook($antrian->id_buku, $antrian->id_user);
				$this->db->set('status', 'diproses')
					->where('id', $antrian->id)
					->update('antrian_peminjaman');
			}

			return 'Berhasil dikembalikan';
		}
		return 'Peminjaman tidak ditemukan';
	}

	public function getBuku($limit, $start)
	{
		$this->db->select('buku.*, genre.genre'); // Pilih semua kolom dari `buku` + `nama_genre`
		$this->db->from('buku');
		$this->db->join('genre', 'genre.id_genre = buku.id_genre', 'left'); // Left Join dengan `genre`
		$this->db->order_by('buku.id_buku', 'DESC'); // Urutkan dari terbaru
		$this->db->limit($limit, $start);
		return $this->db->get()->result();
	}
	// Fungsi untuk mengecek antrian
	public function cek_antrian($id_buku)
	{
		return $this->db->get_where('antrian_peminjaman', [
			'id_buku' => $id_buku,
			'status' => 'menunggu'
		])->result();
	}

	public function get_comment_count($id_buku)
	{
		$this->db->where('id_buku', $id_buku);
		return $this->db->count_all_results('comments'); // Gantilah 'comments' dengan nama tabel komentar Anda
	}
	// Fungsi untuk menghitung jumlah total buku
	public function getTotalBooks()
	{
		return $this->db->count_all('buku');  // Menghitung total buku dalam tabel 'buku'
	}
	public function getGenres()
	{
		return $this->db->get('genre')->result(); // Ambil semua genre
	}

	// Ambil buku berdasarkan id_genre
	public function getBooksByGenre()
	{
		$query = $this->db->select('buku.*, 
        COALESCE(genre.genre, "Tanpa Genre") AS genre, 
        COALESCE(AVG(comments.rating), 0) AS rating, 
        COUNT(comments.id_comments) AS comment_count')
			->from('buku')
			->join('genre', 'buku.id_genre = genre.id_genre', 'left')
			->join('comments', 'buku.id_buku = comments.id_buku', 'left')
			->group_by('buku.id_buku')
			->get();

		$result = $query->result();

		if (!$result) return []; // Pastikan tidak NULL atau FALSE

		$buku_by_genre = [];
		foreach ($result as $bku) {
			$buku_by_genre[$bku->genre][] = $bku;
		}

		return $buku_by_genre;
	}

	public function get_new_books()
	{
		$this->db->select('buku.id_buku, buku.title, buku.thumbnail, buku.views, buku.published_date');
		$this->db->from('buku');
		$this->db->order_by('buku.published_date', 'DESC'); // Urutkan berdasarkan tanggal terbaru
		$this->db->limit(5); // Ambil 5 buku terbaru
		return $this->db->get()->result_array();
	}

	public function get_top_views()
	{
		$this->db->select('buku.id_buku, buku.title, buku.thumbnail, buku.views');
		$this->db->from('buku');
		$this->db->order_by('buku.views', 'DESC'); // Urutkan berdasarkan views terbanyak
		$this->db->limit(5); // Ambil 5 buku dengan views tertinggi
		return $this->db->get()->result_array();
	}
	public function getBookById($id_buku)
	{
		$this->db->select('b.*, g.genre');
		$this->db->from('buku b');
		$this->db->join('genre g', 'b.id_genre = g.id_genre', 'left');
		$this->db->where('b.id_buku', $id_buku);
		return $this->db->get()->row_array();
	}

	public function addBook($data_buku)
	{
		return $this->db->insert('buku', $data_buku);  // Menambah data buku ke tabel 'buku'
	}

	public function update_book($id_buku, $data)
	{
		$this->db->where('id_buku', $id_buku);
		return $this->db->update('buku', $data);
	}

	public function delete($id_buku)
	{
		// Hapus semua data peminjaman yang terkait dengan buku ini
		$this->db->where('id_buku', $id_buku);
		$this->db->delete('peminjaman');

		// Setelah peminjaman dihapus, hapus data buku
		$this->db->where('id_buku', $id_buku);
		return $this->db->delete('buku');
	}

	public function increase_views($id_buku)
	{
		$this->db->where('id_buku', $id_buku);
		$this->db->set('views', 'views+1', FALSE);
		$this->db->update('buku');
	}
	public function search_buku($keyword, $filter)
	{
		$this->db->like($filter, $keyword);
		return $this->db->get('buku')->result();
	}
}
