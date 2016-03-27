<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Service extends CI_Model {
	public function ShortNews(){
		$language = $_GET['language'];
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',40);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
		}
		return $query;
	}
	public function FullNews(){
		$language = $_GET['language'];
		$id =$this->input->get('id');
		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
		}
		return $query;
	}
	public function ShortTeam(){
		$language = $_GET['language'];
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',42);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
		}
		return $query;
	}
	public function FullTeam(){
		$language = $_GET['language'];
		$id = $_GET['id'];
		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
		}
		return $query;
	}
	public function ShortProjects(){
		$language = $_GET['language'];
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',47);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
		}
		return $query;
	}
	public function FullProjects(){
		$language = $_GET['language'];
		$id = $_GET['id'];
		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
		}
		return $query;
	}
	public function DonorsAndPartners(){
		$language = $_GET['language'];
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',46);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
		}
		return $query;
	}
}