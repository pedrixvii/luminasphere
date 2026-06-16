<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Genre extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('GenreModel');
    }

    public function index()
    {
        $data['genres'] = $this->GenreModel->get_all_genres();
		$data['current_page'] = $this->uri->segment(1); // Mengambil segmen pertama dari URL
		$data['title'] = 'Data Genre';
		$this->load->view('template_admin/header', $data);
		$this->load->view('template_admin/sidebar', $data);
        $this->load->view('dashboard_admin/genre', $data);
    }

    public function add()
    {
        $this->GenreModel->add_genre(['genre' => $this->input->post('genre')]);
        redirect('genre');
    }

    public function edit()
    {
        $id_genre = $this->input->post('id_genre');
        $data = ['genre' => $this->input->post('genre')];
        $this->GenreModel->update_genre($id_genre, $data);
        redirect('genre');
    }

    public function delete($id_genre)
    {
        $this->GenreModel->delete_genre($id_genre);
        redirect('genre');
    }
}
