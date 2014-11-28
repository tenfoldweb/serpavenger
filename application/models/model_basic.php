<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_basic extends CI_Model{
	
    public function __construct(){        
        // Call the Model constructor
        parent::__construct();
    }
	
    public function timeDifference($startDate){
	    $datetime1 = date_create($startDate);
	    $datetime2 = date_create(date("Y-m-d"));
	    $interval = date_diff($datetime1, $datetime2);
	    if($interval->format('%a') > 0){
		    return $interval->format('%a days');
	    }elseif($interval->format('%h') > 0){
		    return $interval->format('%h hours');
	    }elseif($interval->format('%i') > 0){
		    return $interval->format('%i mins');
	    }elseif($interval->format('%s') > 0){
		    return $interval->format('%s secs');
	    }
    }

    public function getValue_condition($TableName, $FieldName, $AliasFieldName, $Condition=''){	
	    if($Condition=="") 	
		    $Condition="";
	    else 				
		    $Condition=" WHERE ".$Condition;

	    if($AliasFieldName == '')
	    {
		    $getField = $FieldName;
	    }
	    else
	    {
		    $getField = $AliasFieldName;
		    $FieldName = $FieldName ." AS ".$AliasFieldName;
	    }

	    $sql = "SELECT ".$FieldName." FROM ".$TableName.$Condition; // exit();
	    $rs = $this->db->query($sql);
	    if($rs->num_rows() >0)
	    {
		    $rec = $rs->result_array();
		    return $rec;
	    }
	    else
	    {
		    return false;
	    }
    }
	public function deleteRecords($tableName = '', $condition = ''){
		$this->db->delete($tableName, $condition); 
	}
    public function isRecordExist($tableName = '', $condition = '', $idField = '', $idValue = ''){
            if($condition == '') $condition = 1;
			
            $sql = "SELECT COUNT(*) as CNT FROM ".$tableName." WHERE ".$condition."";

            if($idValue > 0 && $idValue <> ''){
                    $sql .=" AND ".$idField." <> '".$idValue."'";
            }

           $rs = $this->db->query($sql);

            $rec = $rs->row();
            $cnt = $rec->CNT;

            return $cnt;
    }
   
    public function getSingle($tableName, $whereCondition){
            if($whereCondition <> '')
                    $where = " WHERE ".$whereCondition;
            else
                    $where = " WHERE 1 ";

            $sql = "SELECT * FROM ".$tableName." ".$where." ";
            $rs = $this->db->query($sql);

            if($rs->num_rows()){
                $rec = $rs->result();
                return $rec;			
            }
            return false;
    }
    
    public function getSinglestoredsearch($tableName, $whereCondition){
            if($whereCondition <> '')
                    $where = " WHERE ".$whereCondition;
            else
                    $where = " WHERE 1 ";

            $sql = "SELECT * FROM ".$tableName." ".$where." ";
            $rs = $this->db->query($sql);

            if($rs->num_rows()){
                $rec = $rs->row_array();
                return $rec;			
            }
            return false;
    }

    public function create_unique_slug($string,$table,$field='slug',$key=NULL,$value=NULL){
            $t =& get_instance();
            $slug = url_title($string);
            $slug = strtolower($slug);
            $i = 0;
            $params = array ();
            $params[$field] = $slug;

            if($key)$params["$key !="] = $value;
            while ($t->db->where($params)->get($table)->num_rows()) {
                    if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                            $slug .= '-' . ++$i;
                    else
                            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
                    $params [$field] = $slug;
            }
            return $slug;
    }

    public function get_default_seo(){
    $sql = "SELECT option_value,option_name FROM option_master WHERE option_id IN(2,3,4)";
    $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
                $rec[$row['option_name']] = $row['option_value'];
            }
            return $rec;
        }
        return FALSE;
    }

    public function getValues_conditions($TableName, $FieldNames, $AliasFieldName = '', $Condition='', $OrderBy='', $OrderType='', $Limit=0) {
        if($Condition=="")
            $Condition="";
        else
            $Condition=" WHERE ".$Condition;

        $select = '*';
        if($FieldNames && is_array($FieldNames))
            $select = implode(",", $FieldNames);

        $sql = "SELECT ".$select." FROM ".$TableName.$Condition;

        if($OrderBy != '') {
            $sql .= " ORDER BY `".$OrderBy."` ".$OrderType;
        }
        if($Limit > 0 ) {
            $sql .= " LIMIT 0, $Limit";
        }
        //echo $sql;exit;
        $rec = FALSE;
        $rs = $this->db->query($sql);
        if($rs->num_rows()) {
            $rec = $rs->result_array();
			
        }else{
            $rec = FALSE;
        }
        return $rec;
    }
	
    public function populateDropdown($idField, $nameField, $tableName, $condition, $orderField, $orderBy){
	$sql = "SELECT ".$idField.", ".$nameField." FROM ".$tableName." WHERE ".$condition." ORDER BY ".$orderField." ".$orderBy."";
	$rs = $this->db->query($sql);

	if($rs->num_rows()){
	    $rec = $rs->result_array();
	    return $rec;			
	}
		
	return false;
    }
	
	
    public function insertIntoTable($tableName,$insertArr,$condition1)
    {
	    $ret = false;
	    if($tableName == '')
		    return $ret;
	    
	   $sql = "UPDATE " .$tableName.  " SET keyword = '".$insertArr."' WHERE ".$condition1;
	    	
	    if($this->db->query($sql)){
		$ret = true;
	
	    }
	    
	    return $ret;
    }
	

	public function insertIntoTable1($tableName,$insertArr)
    {
	    $ret = false;
	    if($tableName == '')
		    return $ret;
	    
	    if($insertArr && is_array($insertArr))
	    {
		    $this->db->insert($tableName, $insertArr);
		    $ret = $this->db->insert_id(); 
	    }
	    
	    return $ret;
    }
	
    public function recordInsert($tableName,$data = array()){
	    $fields = "";
	    if(is_array($data) && count($data) > 0){
		    foreach($data as $k => $v){
			    $fields	.= $k . ' = "' . $v . '", ';
		    }
		    $fields		= substr($fields, 0, strlen($fields)-2);
		    
	    }
	    
	    $sql = "INSERT INTO " .$tableName.  " SET ". $fields ;	
    
	    $rs = $this->db->query($sql);
	    $rec = false;
	    if($this->db->insert_id())
	    {
		    $rec = $this->db->insert_id();
	    }
	    
	    return $rec;
    }
	
    public function recordUpdate($tableName,$data = array(),$condition){
	    $fields = "";
	    if(is_array($data) && count($data) > 0){
		    foreach($data as $k => $v){
			    $fields	.= $k . ' = "' . $v . '", ';
		    }
		    $fields		= substr($fields, 0, strlen($fields)-2);
	    }	    
	    $sql = "UPDATE " .$tableName.  " SET ". $fields." WHERE ".$condition;
	    $rec = false;
	    if($this->db->query($sql)){
		$rec = true;
	    }	    
	    return $rec;
    }
    
    public function getCampaignList($se){
	$rec	= false;
	if($se == 'google'){
	    $wc	= " AND isCrawlByGoogle = 'Yes'";
	}elseif($se == 'yahoo'){
	    $wc	= " AND isCrawlByYahoo = 'Yes'";
	}elseif($se == 'bing'){
	    $wc	= " AND isCrawlByBing = 'Yes'";
	}
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " AS UC, " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS UCK WHERE UC.campaign_id = UCK.campaign_id AND (UCK.keyword_type = 'M' OR UCK.keyword_type = 'S')" . $wc;
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	}
	return $rec;
    }
    
    public function insertCrawlData($se, $data){
	if($se == 'google'){	
		$sql	= "INSERT INTO " . TABLE_GOOGLE_CRAWL_DATA . " SET
			       campaign_id	= '".$data['campaign_id']."',
			       keyword	= '".addslashes($data['keyword'])."',
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       rank		= '".addslashes($data['rank'])."',
			       main_url_pos	= '".addslashes($data['main_url_pos'])."',
			       date_added	= '".$data['date_added']."'";
		$this->db->query($sql);
	}elseif($se == 'yahoo'){	
		$sql	= "INSERT INTO " . TABLE_YAHOO_CRAWL_DATA . " SET
			       campaign_id	= '".$data['campaign_id']."',
			       keyword	= '".addslashes($data['keyword'])."',
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       rank		= '".addslashes($data['rank'])."',
			       main_url_pos	= '".addslashes($data['main_url_pos'])."',
			       date_added	= '".$data['date_added']."'";
		$this->db->query($sql);
	}elseif($se == 'bing'){	
		$sql	= "INSERT INTO " . TABLE_BING_CRAWL_DATA . " SET
			       campaign_id	= '".$data['campaign_id']."',
			       keyword	= '".addslashes($data['keyword'])."',
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       rank		= '".addslashes($data['rank'])."',
			       main_url_pos	= '".addslashes($data['main_url_pos'])."',
			       date_added	= '".$data['date_added']."'";
		$this->db->query($sql);
	}
	return true;
    }
    
    public function getActiveCampaignList($users_id)
    {
	$result_array = array();

	//$user_id=$this->session->userdata("LOGIN_USER");
	echo $sql = "SELECT campaign_id,campaign_title FROM serp_users_campaign_master WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
	$qry = $this->db->query($sql);
	if($qry->num_rows()>0)
	{
	    $rs = $qry->result_array();	    
	    foreach($rs as $res){
		
		$c_id = $res['campaign_id'];
		$sl = "SELECT campaign_site_type,campaign_main_page_url FROM serp_users_campaign_detail WHERE c_id = '".$c_id."'";
		$qr = $this->db->query($sl);
		if($qr->num_rows()>0){
		    $row = $qr->result_array();
		    foreach( $row as $r=>$data){
//			    echo $data['campaign_main_page_url'];
			    $main_page = parse_url($data['campaign_main_page_url']); 
			    if($data['campaign_site_type'] == 1)
			    {
								
				$result_array[$res['campaign_title']]['moneysite'][] = $main_page['host'];
			    }
			    else
			    {
				$result_array[$res['campaign_title']]['parasite'][] = $main_page['host'];
				
			    }
			}
		}
		
	    }
	}
	
	return $result_array;
    }
}