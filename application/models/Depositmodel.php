<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DepositModel extends CI_Model
{
	public function get_pending_deposits()
	{
		$this->db->select('d.id_deposit, d.id_user, d.jumlah, d.bukti_transfer, d.status, u.username');
		$this->db->from('deposit d');
		$this->db->join('user u', 'd.id_user = u.id_user', 'left');
		$this->db->where('d.status', 'pending'); // Hanya deposit yang belum disetujui
		$this->db->order_by('d.id_deposit', 'DESC');

		return $this->db->get()->result();
	}


	public function get_deposit_by_id($id_deposit)
	{
		return $this->db->get_where('deposit', ['id_deposit' => $id_deposit])->row();
	}
}
