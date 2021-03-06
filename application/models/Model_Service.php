<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Service extends CI_Model {
	public function ShortNews(){
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_en,phr_content.short_desc_ru,phr_content.short_desc_ka, phr_content.title_en,phr_content.title_ru,phr_content.title_ka');
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',40);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_en']=strip_tags($value['short_desc_en']);
			$query[$key]['short_desc_ka']=strip_tags($value['short_desc_ka']);
			$query[$key]['short_desc_ru']=strip_tags($value['short_desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);			
		}
		return $query;
	}
	public function FullNews(){
		$id =$this->input->get('id');
		$this->db->select('id, image, create_time, desc_ka,desc_en,desc_ru, title_ka,title_en,title_ru');
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_ka']=strip_tags($value['desc_ka']);
			$query[$key]['desc_en']=strip_tags($value['desc_en']);
			$query[$key]['desc_ru']=strip_tags($value['desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);
		}
		return $query;
	}
	public function ShortTeam(){
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_en,phr_content.short_desc_ru,phr_content.short_desc_ka, phr_content.title_en,phr_content.title_ka,phr_content.title_ru');
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',42);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_en']=strip_tags($value['short_desc_en']);
			$query[$key]['short_desc_ka']=strip_tags($value['short_desc_ka']);
			$query[$key]['short_desc_ru']=strip_tags($value['short_desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);			
		}
		return $query;
	}
	public function FullTeam(){
		$id = $_GET['id'];
		$this->db->select('id, image, create_time, desc_ka,desc_en,desc_ru, title_ka,title_en,title_ru');
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_ka']=strip_tags($value['desc_ka']);
			$query[$key]['desc_en']=strip_tags($value['desc_en']);
			$query[$key]['desc_ru']=strip_tags($value['desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);			
		}
		return $query;
	}
	public function ShortProjects(){
		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_en,phr_content.short_desc_ru,phr_content.short_desc_ka, phr_content.title_en,phr_content.title_ka,phr_content.title_ru');
		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
		$this->db->where('phr_menu_content.menu_id',47);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['short_desc_en']=strip_tags($value['short_desc_en']);
			$query[$key]['short_desc_ka']=strip_tags($value['short_desc_ka']);
			$query[$key]['short_desc_ru']=strip_tags($value['short_desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);			
		}
		return $query;
	}
	public function FullProjects(){
		$id = $_GET['id'];
		$this->db->select('id, image, create_time, desc_ka,desc_en,desc_ru, title_ka,title_en,title_ru');
		$this->db->where('id', $id);
		$query = $this->db->get('phr_content')->result_array();
		// $newArray=array()
		foreach ($query as $key => $value) {
			$query[$key]['desc_en']=strip_tags($value['desc_en']);
			$query[$key]['desc_ka']=strip_tags($value['desc_ka']);
			$query[$key]['desc_ru']=strip_tags($value['desc_ru']);

			$query[$key]['title_ka']=strip_tags($value['title_ka']);
			$query[$key]['title_en']=strip_tags($value['title_en']);
			$query[$key]['title_ru']=strip_tags($value['title_ru']);			
		}
		return $query;
	}
	public function Donors(){
				$Donors = array(
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/saia.png',
			    'url'=>'https://gyla.ge/geo/news'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/garemo.png',
			    'url'=>'http://www.ertad.org/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/assets/uploads/logo/42_muxli.png',
			    'url'=>'http://article42.blogspot.com/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/rrreee.jpg',
			    'url'=>'http://www.avng.ge/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/dri.png',
			    'url'=>'http://www.driadvocacy.org/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/centri.png',
			    'url'=>''
			  )
			);
		return $Donors;
	}
	public function Partners(){
		$Partners = array(
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/euro.png',
			    'url'=>'http://eeas.europa.eu/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/un_women.png',
			    'url'=>'http://www.ungeorgia.ge/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/qalta_fondi.png',
			    'url'=>'http://www.womenfundgeorgia.org/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/logo/sorosi.png',
			    'url'=>'http://www.osgf.ge/'
			  ),
			array(
			    'img'=>'http://phr.ge/assets/uploads/Partners/Horizontal_RGB_600.png',
			    'url'=>''
			  )
			);
		return $Partners;
	}
}


// <?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// class Model_Service extends CI_Model {
// 	public function ShortNews(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
// 		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
// 		$this->db->where('phr_menu_content.menu_id',40);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function FullNews(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$id =$this->input->get('id');
// 		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
// 		$this->db->where('id', $id);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function ShortTeam(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
// 		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
// 		$this->db->where('phr_menu_content.menu_id',42);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function FullTeam(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$id = $_GET['id'];
// 		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
// 		$this->db->where('id', $id);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function ShortProjects(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$this->db->select('phr_content.id, phr_content.image, phr_content.create_time, phr_content.short_desc_'.$language.', phr_content.title_'.$language);
// 		$this->db->join('phr_menu_content','phr_menu_content.content_id=phr_content.id');
// 		$this->db->where('phr_menu_content.menu_id',47);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['short_desc_'.$language]=strip_tags($value['short_desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function FullProjects(){
// 		$language = (isset($_POST['language']))?$_POST['language']:$_GET['language'];
// 		$id = $_GET['id'];
// 		$this->db->select('id, image, create_time, desc_'.$language.', title_'.$language);
// 		$this->db->where('id', $id);
// 		$query = $this->db->get('phr_content')->result_array();
// 		// $newArray=array()
// 		foreach ($query as $key => $value) {
// 			$query[$key]['desc_'.$language]=strip_tags($value['desc_'.$language]);
// 		}
// 		return $query;
// 	}
// 	public function Donors(){
// 				$Donors = array(
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/saia.png',
// 			    'url'=>'https://gyla.ge/geo/news'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/garemo.png',
// 			    'url'=>'http://www.ertad.org/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/assets/uploads/logo/42_muxli.png',
// 			    'url'=>'http://article42.blogspot.com/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/rrreee.jpg',
// 			    'url'=>'http://www.avng.ge/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/dri.png',
// 			    'url'=>'http://www.driadvocacy.org/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/centri.png',
// 			    'url'=>''
// 			  )
// 			);
// 		return $Donors;
// 	}
// 	public function Partners(){
// 		$Partners = array(
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/euro.png',
// 			    'url'=>'http://eeas.europa.eu/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/un_women.png',
// 			    'url'=>'http://www.ungeorgia.ge/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/qalta_fondi.png',
// 			    'url'=>'http://www.womenfundgeorgia.org/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/logo/sorosi.png',
// 			    'url'=>'http://www.osgf.ge/'
// 			  ),
// 			array(
// 			    'img'=>'http://phr.ge/assets/uploads/Partners/Horizontal_RGB_600.png',
// 			    'url'=>''
// 			  )
// 			);
// 		return $Partners;
// 	}
// }