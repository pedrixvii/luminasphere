<?php
class Cekpeminjamanmodel extends CI_Model
{
	public function cek_peminjaman($id_user, $id_buku)
	{
		return $this->db->where('id_user', $id_user)
			->where('id_buku', $id_buku)
			->where('status_peminjaman', 'dipinjam')
			->get('peminjaman')
			->num_rows() > 0;
	}

	public function auto_return_peminjaman()
	{
		$today = date('Y-m-d');

		// **Cari semua peminjaman yang sudah melewati batas waktu**
		$this->db->where('tanggal_pengembalian <', $today);
		$this->db->where('status_peminjaman', 'dipinjam');
		$query = $this->db->get('peminjaman');

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $peminjaman) {
				if ($peminjaman->jenis_buku === 'offline') {
					// **Buku Offline: Kembalikan & Tambah Stok**
					$this->db->where('id_peminjaman', $peminjaman->id_peminjaman)
						->update('peminjaman', ['status_peminjaman' => 'dikembalikan']);

					// **Tambahkan kembali stok buku**
					$this->db->set('stock', 'stock + 1', FALSE)
						->where('id_buku', $peminjaman->id_buku)
						->update('buku');

					log_message('info', 'Buku offline dikembalikan otomatis: ID ' . $peminjaman->id_peminjaman);
				} else {
					// **Buku Online: Ubah Status Menjadi "Expired"**
					$this->db->where('id_peminjaman', $peminjaman->id_peminjaman)
						->update('peminjaman', ['status_peminjaman' => 'expired']);

					log_message('info', 'Buku online expired otomatis: ID ' . $peminjaman->id_peminjaman);
				}
			}
		}
	}

	public function approved_peminjaman($id_peminjaman)
	{
		$peminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row();

		if (!$peminjaman) {
			return false;
		}

		// **Cek apakah stok buku masih ada sebelum menyetujui**
		$buku = $this->db->get_where('buku', ['id_buku' => $peminjaman->id_buku])->row();
		if (!$buku || $buku->stock <= 0) {
			return false;
		}

		// **Kurangi stok hanya saat peminjaman disetujui**
		$this->db->set('stock', 'stock - 1', FALSE)
			->where('id_buku', $peminjaman->id_buku)
			->update('buku');

		// **Update status peminjaman menjadi 'approved'**
		return $this->db->where('id_peminjaman', $id_peminjaman)
			->update('peminjaman', [
				'status' => 'approved',
				'status_peminjaman' => 'dipinjam'
			]);
	}

	public function get_pending_peminjaman()
	{
		$this->db->select('
        p.id_peminjaman, 
        p.id_user, 
        p.id_buku, 
        p.status,
        p.status_peminjaman,
        p.tanggal_peminjaman, 
        p.tanggal_pengembalian, 
        u.poin AS poin_awal, 
        (u.poin - 10) AS poin_setelah_pinjam, 
        p.denda, 
        (CASE WHEN p.kehilangan = "ya" THEN 0 ELSE 10 END) AS poin_jika_hilang, 
        u.username, 
        b.title, 
        b.jenis_buku
    ');
		$this->db->from('peminjaman p');
		$this->db->join('user u', 'p.id_user = u.id_user');
		$this->db->join('buku b', 'p.id_buku = b.id_buku');
		$this->db->where_in('p.status', ['pending', 'approved']);
		$this->db->where('p.status_peminjaman !=', 'dikembalikan');

		return $this->db->get()->result();
	}

	public function update_status_peminjaman($id_peminjaman, $status)
	{
		return $this->db->where('id_peminjaman', $id_peminjaman)
			->update('peminjaman', ['status' => $status]);
	}
}
