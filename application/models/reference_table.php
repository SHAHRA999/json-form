<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reference_Table_Model  { //dari class sini 

    public function __construct() {
        $this->db = new Mysql_Driver();
    }
    
    public function Discipline() {
        $sql = "SELECT main_discipline_code, main_discipline_name "
                . " FROM ref_main_disciplines ORDER BY main_discipline_name ASC";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function GeneralDiscipline() {
        $sql = "SELECT discipline_code, discipline_name "
                . " FROM ref_generaldisciplines ORDER BY discipline_name ASC";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function MainDiscipline() {
        $sql = "SELECT main_discipline_code, main_discipline_name "
                . " FROM ref_main_disciplines WHERE module='cd' ORDER BY main_discipline_name ASC";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function MainDisciplineGroup(){
        $sql = "SELECT main_discipline_code as code, main_discipline_name as label "
                . " FROM ref_main_disciplines ";
        if(PROJECT_PATH == 'cd'):
        $sql .= "WHERE module='cd' ORDER BY main_discipline_name ASC ";
        elseif (PROJECT_PATH == 'rispac'):
        $sql .= "WHERE main_discipline_code = '08' ";
        else:
        $sql .= "WHERE module='cd' ORDER BY main_discipline_name ASC ";
        endif;
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function SubDisciplineGroup(){
        $sql = "SELECT discipline_code as code, discipline_name as label "
                . " FROM ref_generaldisciplines ORDER BY discipline_name ASC";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function DocumentMainGroup(){
        $sql = "SELECT doc_group_code as code, doc_group_desc as label"
                . " FROM ref_document_group";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    //zarith-8/3 
    public function DocumentGroup() {
        $sql = "SELECT doc_group_code as code, doc_group_desc as label "
                . " FROM ref_document_group ";
        if(PROJECT_PATH == 'cd'):
        $sql .= "WHERE doc_group_code IN ('CN','RL','PS') ";
        elseif(PROJECT_PATH == 'rispac'):
        $sql .= "WHERE doc_group_code IN ('RR') ";
        else:
        $sql .= "WHERE doc_group_code IN ('CN','RL')"; 
        endif;
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
//    public function DocumentType($groupCode = null) {
//        $sql = "SELECT dc_type_code as code, dc_type_desc as label"
//                . " FROM ref_document_type "
//                . " WHERE doc_group_code ='$groupCode'";
//        $this->db->connect();
//        $this->db->prepare($sql);
//        $this->db->queryexecute();
//        $result = $this->db->fetchOut('array');
//        return ($result) ? $result : false;
//    }
    //zarith-23/3 
    public function DocumentType($groupCode = null) {
        $sql = "SELECT dc_type_code as code, dc_type_desc as label"
                . " FROM ref_document_type ";
		if($groupCode == 'CN'):
		$sql .= "WHERE doc_group_code ='CN'";
		else:
		$sql .= "WHERE doc_group_code ='RL' AND dc_type_code IN('RFL','RPL') ";
                endif;
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }

    public function DocumentTypeFiltering($groupCode) {
        $sql = "SELECT dc_type_code as code, dc_type_desc as label"
                . " FROM ref_document_type "
                . " WHERE doc_group_code = '$groupCode'";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function DocumentDisFiltering($disCode = null) {
        $sql = "SELECT discipline_code as code, discipline_name as label"
                . " FROM ref_generaldisciplines ";
        if(PROJECT_PATH == 'cd'):
        $sql .= "WHERE main_discipline_code = '$disCode' AND module = 'CD' ";
        elseif(PROJECT_PATH == 'rispac'):
        $sql .= "WHERE main_discipline_code = '$disCode' ";
        else:
        $sql .= "WHERE main_discipline_code = '$disCode' AND module = 'CD' ";    
        endif;
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
     public function MainProductCategory(){
        $sql = "SELECT form_code as code, form_name as label "
                . "FROM product_forms "
                . "WHERE form_code IN ('0','11','3','7','8','9')";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
    
    public function ProductTypeFiltering($groupCode = null  ) {
        $sql = "SELECT form_code as code, form_name as label"
                . " FROM product_forms "
                . " WHERE form_code = '$groupCode'";
        $this->db->connect();
        $this->db->prepare($sql);
        $this->db->queryexecute();
        $result = $this->db->fetchOut('array');
        return ($result) ? $result : false;
    }
 
}
