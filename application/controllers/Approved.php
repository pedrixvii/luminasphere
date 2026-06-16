<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approved extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cekpeminjamanmodel');
	}

	public function index()
	{
		// Ambil daftar peminjaman yang belum disetujui
		$data['peminjaman_pending'] = $this->cekpeminjamanmodel->get_pending_peminjaman();
		// Load view untuk staff
		$this->load->view('template_staff/header', $data);
		$this->load->view('template_staff/sidebar', $data);
		$this->load->view('dashboard_staff/databuku', $data);
	}

	public function approve($id_peminjaman)
	{
		$peminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();

		if (!$peminjaman) {
			$this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
			redirect('approved');
		}

		// Jika buku online, langsung return karena tidak butuh approval
		if ($peminjaman->jenis_buku === 'online') {
			redirect('approved');
		}

		// Update status peminjaman untuk buku offline
		$this->db->where('id_peminjaman', $id_peminjaman);
		$this->db->update('peminjaman', [
			'status' => 'approved',
			'status_peminjaman' => 'dipinjam'
		]);

		$this->session->set_flashdata('success', "✅ Peminjaman telah disetujui.");
		redirect('approved');
	}

	public function cek_approve()
	{
		$id_user = $this->session->userdata('id_user');

		$this->db->where('id_user', $id_user);
		$this->db->where('status', 'approved');
		$this->db->where('notifikasi_dibaca', 0);
		$peminjaman = $this->db->get('peminjaman')->result();

		if (!empty($peminjaman)) {
			foreach ($peminjaman as $p) {
				$this->db->where('id_peminjaman', $p->id_peminjaman);
				$this->db->update('peminjaman', ['notifikasi_dibaca' => 1]);
			}

			echo json_encode([
				'status' => 'success',
				'message' => "✅ Peminjaman telah disetujui! Silakan baca atau ambil buku Anda.",
				'data' => $peminjaman
			]);
		} else {
			echo json_encode(['status' => 'none', 'debug' => $this->db->last_query()]);
		}
	}

	public function reject($id_peminjaman)
	{
		$peminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();
		if (!$peminjaman) {
			$this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
			redirect('approved');
		}

		// Jika buku online, langsung return karena tidak butuh rejection
		if ($peminjaman->jenis_buku === 'online') {
			redirect('approved');
		}

		// Tambahkan kembali stok buku offline
		$this->db->set('stock', 'stock + 1', FALSE)
			->where('id_buku', $peminjaman->id_buku)
			->update('buku');

		// Tambahkan kembali poin user (+10) untuk buku offline
		$this->db->set('poin', 'poin + 10', FALSE)
			->where('id_user', $peminjaman->id_user)
			->update('user');

		// Update status peminjaman menjadi "rejected"
		$this->db->where('id_peminjaman', $id_peminjaman);
		$this->db->update('peminjaman', [
			'status' => 'rejected',
			'status_peminjaman' => 'ditolak'
		]);

		$this->session->set_flashdata('reject', "❌ Peminjaman buku <strong>{$peminjaman->id_buku}</strong> ditolak oleh staff. Poin dikembalikan +10.");
		redirect('approved');
	}

	public function cek_reject()
	{
		log_message('debug', 'Memeriksa peminjaman yang ditolak...');

		$id_user = $this->session->userdata('id_user');

		$this->db->where('id_user', $id_user);
		$this->db->where('status', 'rejected');
		$this->db->where('notifikasi_dibaca', 0);
		$peminjaman = $this->db->get('peminjaman')->result();

		header('Content-Type: application/json'); // Pastikan response JSON

		if (!empty($peminjaman)) {
			log_message('debug', 'Ditemukan peminjaman yang ditolak.');

			foreach ($peminjaman as $p) {
				$this->db->where('id_peminjaman', $p->id_peminjaman);
				$this->db->update('peminjaman', ['notifikasi_dibaca' => 1]);
			}

			echo json_encode([
				'status' => 'rejected',
				'message' => "❌ Peminjaman eBook telah ditolak oleh staff.",
				'data' => $peminjaman
			]);
		} else {
			log_message('debug', 'Tidak ada peminjaman yang ditolak.');
			echo json_encode(['status' => 'none']);
		}
	}
}
