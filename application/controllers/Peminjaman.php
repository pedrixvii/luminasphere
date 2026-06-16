<?php

class Peminjaman extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cekpeminjamanmodel');
		$this->load->model('DepositModel');
		$this->load->model('bukumodel'); // Tambahkan model untuk buku
	}

	public function pinjam($id_buku)
	{
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_flashdata('error', 'Silakan login untuk meminjam eBook.');
			redirect('auth');
		}

		$id_user = $this->session->userdata('id_user');
		$buku = $this->db->get_where('buku', ['id_buku' => $id_buku])->row();

		if (!$buku) {
			$this->session->set_flashdata('error', 'Buku tidak ditemukan.');
			redirect('buku');
		}

		// Jika buku online, langsung bisa dibaca tanpa approval
		if ($buku->jenis_buku === 'online') {
			$this->db->insert('peminjaman', [
				'id_user' => $id_user,
				'id_buku' => $id_buku,
				'tanggal_peminjaman' => date('Y-m-d'),
				'tanggal_pengembalian' => date('Y-m-d', strtotime('+3 days')),
				'status' => 'approved', // Langsung disetujui
				'status_peminjaman' => 'dipinjam',
				'jenis_buku' => 'online'
			]);

			$this->session->set_flashdata('success', '✅ Peminjaman berhasil! Anda bisa langsung membaca eBook ini.');
			redirect('buku/detail/' . $id_buku);
		}

		// Jika buku offline, harus menunggu approval dan stok berkurang
		if ($buku->stock <= 0) {
			$this->db->insert('antrian_peminjaman', [
				'id_user' => $id_user,
				'id_buku' => $id_buku,
				'tanggal_antri' => date('Y-m-d'),
				'status' => 'menunggu'
			]);

			$this->session->set_flashdata('info', '📌 Stok buku habis. Anda telah masuk ke dalam antrian peminjaman.');
			redirect('buku/detail/' . $id_buku);
		}

		// Kurangi poin user (-10 poin)
		$this->db->set('poin', 'poin - 10', FALSE)
			->where('id_user', $id_user)
			->update('user');

		// Kurangi stok buku offline
		$this->db->set('stock', 'stock - 1', FALSE)
			->where('id_buku', $id_buku)
			->update('buku');

		// Simpan data peminjaman untuk buku offline
		$this->db->insert('peminjaman', [
			'id_user' => $id_user,
			'id_buku' => $id_buku,
			'tanggal_peminjaman' => date('Y-m-d'),
			'tanggal_pengembalian' => date('Y-m-d', strtotime('+3 days')),
			'status' => 'pending',
			'status_peminjaman' => 'dipinjam',
			'jenis_buku' => 'offline'
		]);

		$this->session->set_flashdata('success', '✅ Peminjaman berhasil! Poin dikurangi -10. Menunggu persetujuan staff.');
		redirect('buku/detail/' . $id_buku);
	}

	public function kembalikan($id_peminjaman)
	{
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_flashdata('error', 'Silakan login untuk mengembalikan eBook.');
			redirect('auth');
		}

		$peminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();
		if (!$peminjaman || $peminjaman->status_peminjaman !== 'dipinjam') {
			$this->session->set_flashdata('error', 'Peminjaman tidak valid atau sudah dikembalikan.');
			redirect('buku/detail/' . $peminjaman->id_buku);
		}

		$id_user = $peminjaman->id_user;
		$id_buku = $peminjaman->id_buku;
		$buku = $this->db->get_where('buku', ['id_buku' => $id_buku])->row();
		$jenis_buku = $buku->jenis_buku; // Cek apakah offline atau online

		// **Ambil tanggal sekarang dan tanggal pengembalian**
		$tanggal_pengembalian = new DateTime($peminjaman->tanggal_pengembalian);
		$tanggal_sekarang = new DateTime();

		// **Cek keterlambatan**
		$terlambat = $tanggal_sekarang > $tanggal_pengembalian;
		$selisih_hari = $tanggal_sekarang->diff($tanggal_pengembalian)->days;
		$denda = ($terlambat) ? ($selisih_hari * 5) : 0; // -5 poin per hari keterlambatan

		// **Kembalikan poin jika tidak terlambat**
		if (!$terlambat) {
			$this->db->set('poin', 'poin + 10', FALSE)
				->where('id_user', $id_user)
				->update('user');
			$this->session->set_flashdata('success', 'Buku dikembalikan tepat waktu! Poin dikembalikan.');
		} else {
			// **Kurangi poin jika terlambat**
			$this->db->set('poin', 'poin - ' . $denda, FALSE)
				->where('id_user', $id_user)
				->update('user');
			$this->session->set_flashdata('error', 'Anda terlambat! Denda: -' . $denda . ' poin.');
		}

		// **Hanya tambahkan stok jika buku offline**
		$this->db->set('stock', 'stock + 1', FALSE)
			->where('id_buku', $id_buku)
			->update('buku');

		// **Update status peminjaman**
		$this->db->set('status_peminjaman', 'dikembalikan')
			->where('id_peminjaman', $id_peminjaman)
			->update('peminjaman');

		redirect('buku/detail/' . $peminjaman->id_buku);
	}

	public function buku_hilang($id_peminjaman)
	{
		if (!$this->session->userdata('is_logged_in')) {
			$this->session->set_flashdata('error', 'Silakan login.');
			redirect('auth');
		}

		// Ambil data peminjaman berdasarkan ID
		$peminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();

		if (!$peminjaman) {
			$this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
			redirect('buku/detail/' . $peminjaman->id_buku);
		}

		$id_user = $peminjaman->id_user;
		$id_buku = $peminjaman->id_buku;
		$deposit = $peminjaman->deposit;

		// **Tandai buku sebagai hilang**
		$this->db->set('kehilangan', 'ya')
			->where('id_peminjaman', $id_peminjaman)
			->update('peminjaman');

		// **Saldo tidak dikembalikan karena buku hilang**
		$this->session->set_flashdata('error', '📌 Buku dinyatakan hilang. Saldo yang sudah dipotong tidak dikembalikan.');

		redirect('buku/detail/' . $id_buku);
	}
}
