<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('Model_Service');
    }
	public function ShortNews(){
		echo json_encode($this->Model_Service->ShortNews());
	}
	public function FullNews(){
		echo json_encode($this->Model_Service->FullNews());
	}
	public function ShortTeam(){
		echo json_encode($this->Model_Service->ShortTeam());
	}
	public function FullTeam(){
		echo json_encode($this->Model_Service->FullTeam());
	}
	public function ShortProjects(){
		echo json_encode($this->Model_Service->ShortProjects());
	}
	public function FullProjects(){
		echo json_encode($this->Model_Service->FullProjects());
	}
	public function DonorsAndPartners(){
		echo json_encode($this->Model_Service->DonorsAndPartners());
	}
}