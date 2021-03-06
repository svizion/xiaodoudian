<?php if(!defined('BASEPATH')) exit("No direct script access allowed");

class Home extends Public_Controller{

    function __Construct(){
        parent::Public_Controller();
        $this->load->module_model("galleries","galleries_m");
        $this->load->module_model("news","news_m");
        $this->load->module_model("staff","staff_m");
        $this->lang->load("home");
    }

    //public:list latest galleries and most hot galleries
    function index(){
        $this->load->helper('string');
	$this->load->helper('text');

        //get latest news
        $this->data->news=$this->news_m->getNews(array('limit'=>10));
        //get latest photos
        $this->data->photos=$this->galleries_m->galleryGetLatestPhotos('',20);

        //get all staff
        $this->data->staffs=$this->staff_m->getStaff();

        $this->layout->create("index",$this->data);
    }



}

?>
