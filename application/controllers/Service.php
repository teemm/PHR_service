<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('model_service');
    }
	public function ShortNews(){
		echo json_encode($this->model_service->ShortNews());
	}
	public function FullNews(){
		echo json_encode($this->model_service->FullNews());
	}
	public function ShortTeam(){
		echo json_encode($this->model_service->ShortTeam());
	}
	public function FullTeam(){
		echo json_encode($this->model_service->FullTeam());
	}
	public function ShortProjects(){
		echo json_encode($this->model_service->ShortProjects());
	}
	public function FullProjects(){
		echo json_encode($this->model_service->FullProjects());
	}
	public function Partners(){
		echo json_encode($this->model_service->Partners());
	}
	public function Donors(){
		echo json_encode($this->model_service->Donors());
	}
}