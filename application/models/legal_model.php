<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class legal_model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->library('session');
        date_default_timezone_set('America/Lima');
        
        $this->db_1 = $this->load->database('prueba', TRUE);
        $this->table_1= "";
        $this->table_2 = "categoria_juridica";
    }
	
    public function listarCategoria($filter,$filter_not){
        $this->db_1->select('*');
        $this->db_1->from($this->table_2.' c');
        $this->db_1->where('c.grupo',$filter->grupo);
        $this->db_1->where('c.estado','1');
        $this->db_1->order_by('c.descripcion','asc');
        
        $query = $this->db_1->get();
        
        $result = new stdClass();
        if($query->num_rows()>0){
        $result = $query->result();
        }
        return $result;
    }
}