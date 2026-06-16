<?php
class GenreModel extends CI_Model
{

	public function get_all_genres()
	{
		return $this->db->get('genre')->result_array(); // Pastikan ini result_array()
	}

	public function get_genre_by_id($id_genre)
	{
		return $this->db->get_where('genre', ['id_genre' => $id_genre])->row_array(); // Pastikan ini row_array()
	}

	public function add_genre($data)
	{
		return $this->db->insert('genre', $data);
	}

	public function update_genre($id_genre, $data)
	{
		$this->db->where('id_genre', $id_genre);
		return $this->db->update('genre', $data);
	}

	public function delete_genre($id_genre)
	{
		$this->db->where('id_genre', $id_genre);
		return $this->db->delete('genre');
	}
}
