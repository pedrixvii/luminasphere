<?php
class Slidersmodel extends CI_Model
{
	public function get_sliders()
	{
		$query = $this->db->get('sliders'); // Ganti 'sliders' dengan nama tabel Anda
		return $query->result(); // Pastikan menggunakan result() untuk mengembalikan array objek
	}

	public function addSlider($data_slider)
	{
		return $this->db->insert('sliders', $data_slider);  // Menambah data buku ke tabel 'buku'
	}

	// Fungsi untuk mengupdate data buku
	public function updateSlider($id_slider, $data_slider)
	{
		$this->db->where('id_slider', $id_slider);  // Menentukan ID buku yang akan diupdate
		return $this->db->update('sliders', $data_slider);  // Update data sliders di tabel 'sliders'
	}

	// Fungsi untuk menghapus sliders
	public function deleteSlider($id_slider)
	{
		$this->db->where('id_slider', $id_slider);  // Menentukan ID sliders yang akan dihapus
		return $this->db->delete('sliders');  // Menghapus sliders dari tabel 'sliders'
	}
}
