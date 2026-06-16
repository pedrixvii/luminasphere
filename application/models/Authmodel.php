<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authmodel extends CI_Model
{

	// Simpan data register
	public function register($data)
	{
		return $this->db->insert('user', $data);
	}

	public function validate_user($username, $password) {
        // Validate user by username and password
        $this->db->where('username', $username);
        $query = $this->db->get('user'); // Make sure the table name is 'users'

        if ($query->num_rows() == 1) {
            $user = $query->row();

            // Verify password (Assuming password is hashed in DB)
            if (password_verify($password, $user->password)) {
                return $user; // Return user data if valid
            }
        }

        return null; // Return null if no user found or password doesn't match
    }
	// Ambil data user berdasarkan username
	public function get_user($username)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('user');
		if ($query->num_rows() > 0) {
			return $query->row(); // Kembalikan data sebagai objek
		}
		return FALSE;
	}

	public function update_user($id_user, $data) {
		$this->db->where('id_user', $id_user);
		return $this->db->update('user', $data);
	}

	public function update_pw($id_user, $new_pass){
		$data = ['password' => password_hash($new_pass, PASSWORD_DEFAULT)];
		$this->db->where('id_user', $id_user);
		return $this->db->update('user', $data);
	}

	public function delete_user($id_user) {
		$this->db->where('id_user', $id_user);
		return $this->db->delete('user');
	}


}
