<?php ini_set('memory_limit', '-1');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scrapper_model extends CI_Model {
 public function __construct()
 {
  parent::__construct();
 }
 
 	/*
	This function gets a complete list of all sub building
	*/
 	function get_domains($ids, $orderby='', $order=""){
		
		if($orderby !=''){
			if($order == ''){ $order = 'ASC';}
			$orderby = 'ORDER BY '.$orderby;
		}
		$select_sql="SELECT domainid, domainname, network_id, type FROM domains WHERE network_id IN ( $ids ) ".$orderby." ".$order;
		$query = $this->db->query($select_sql);
		//$num_rows=$query->num_rows();	
		//return $num_rows;
		$res= $query->result_array();
		return $res;
	  }
	  function blog_domains($ids){
				
		$select_sql="SELECT domainid, domainname, network_id, type FROM domains WHERE type='Blog+' and network_id IN ( $ids )";
		$query = $this->db->query($select_sql);
		$num_rows=$query->num_rows();	
		return $num_rows;
		
	  }
	 function domainpost_is_exist($domain_id){
			$this->db->select('*');
			$this->db->from('campaign_posts');					
			if($post_id!=''){
			  $this->db->where('domain_id', $domain_id);			  	 
			}
			//$this->db->where('comments', $comment);	
			$result = $this->db->get();
			//echo '<pre>'; print_r($result);die();
			if($result->num_rows > 0){
				return true;			
			}else{
				return false;
			}
	   }  
	  
	function get_campaigns($user_id){
		
		$this->db->select('*');
		$this->db->from('campaign');				
		$this->db->order_by('campaign_id', 'ASC');
		$this->db->order_by('project_name', 'ASC');
		if($user_id){
		  $this->db->where('user_id', $user_id);	
		}
		$result = $this->db->get();
		$result = $result->result();		
		return $result;
		
	}
    function save($campaign)
	  {
		
			$this->db->insert('campaign', $campaign);
			return $this->db->insert_id();
		
	  }
	function post_save($post)
	  {
		$this->db->insert('campaign_posts', $post);
		return $this->db->insert_id();		
	  }
	function save_link($links)
	  {
		$this->db->insert('campaign_links', $links);
		return $this->db->insert_id();		
	  }  
	function save_settings($settings)
	  {
		$this->db->insert('campaign_settings', $settings);
		return $this->db->insert_id();		
	  } 
	  
	function spin($s){
			preg_match('#\{(.+?)\}#is',$s,$m);
			if(empty($m)) return $s;		
			$t = $m[1];		
			if(strpos($t,'{')!==false){
				$t = substr($t, strrpos($t,'{') + 1);
			}		
			$parts = explode("|", $t);
			$s = preg_replace("+\{".preg_quote($t)."\}+is", $parts[array_rand($parts)], $s, 1);
			//$s = preg_replace("+\{".preg_quote($t)."\}+is", $parts[array_rand($parts)], $s, 1);
			
			return $this->spin($s);
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

	    $sql = "SELECT ".$FieldName." FROM ".$TableName.$Condition;  
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
	
	
    public function insertIntoTable($tableName,$insertArr)
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
	/*$rec	= false;
	if($se == 'google'){
	    $wc	= " AND isCrawlByGoogle = 'Yes'";
	}elseif($se == 'yahoo'){
	    $wc	= " AND isCrawlByYahoo = 'Yes'";
	}elseif($se == 'bing'){
	    $wc	= " AND isCrawlByBing = 'Yes'";
	}
	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS . " AS UC, " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS UCK WHERE UC.campaign_id = UCK.campaign_id AND (UCK.keyword_type = 'M' OR UCK.keyword_type = 'S')" . $wc;*/
	$sql = "SELECT * FROM serp_users_campaign_master";
	$query	= $this->db->query($sql);
	if($query->num_rows() > 0){
	    $rec	= $query->result_array();
	}
	return $rec;
    }
    
    public function insertSearchCrawlData($se, $data){
		
	$status = false;
		
	if($data['crawlby'] == 'google'){
		$sql	= "INSERT INTO " . TABLE_GOOGLE_CRAWL_DATA . " SET
			       campaign_id	= '".$data['campaign_id']."',
				   user_id = ".$data['user_id'].",
			       proxy	= '".addslashes($data['proxy'])."',
			       keyword	= '".addslashes($data['keyword'])."',
				   searchstring	= '".addslashes($data['searchstring'])."',
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       query_url		= '".addslashes($data['query_url'])."',
				   crawlby		= '".$data['crawlby']."',
			       date_added	= '".$data['date_added']."'";
		$query = $this->db->query($sql);
	}
	
	if($data['crawlby'] == 'yahoo'){
		$sql	= "INSERT INTO " . TABLE_GOOGLE_CRAWL_DATA . " SET
			       campaign_id	= '".$data['campaign_id']."',
				   user_id = ".$data['user_id'].",
			       proxy	= '".addslashes($data['proxy'])."',
			       keyword	= '".addslashes($data['keyword'])."',
				   searchstring	= '".addslashes($data['searchstring'])."',
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       query_url		= '',
				   crawlby		= '".$data['crawlby']."',
			       date_added	= '".$data['date_added']."'";
		$query = $this->db->query($sql);
	}
	
		if($this->db->affected_rows() > 0)
		  $status = true;
		  
	return $status;
    }
	
    public function getTitle($identifier){
		$rec = array();
		$sql = "SELECT * FROM serp_user_title WHERE title LIKE '%".$identifier."%'";
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$rec	= $query->result_array();
		}
		return $rec;
    }
	
    public function campaignKeywords($campaign_id, $users_id ){
		$rec = array();
		$sql = "SELECT * FROM serp_users_campaign_keywords WHERE campaign_id = '".$campaign_id."' AND users_id = '".$users_id ."'";
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$rec	= $query->row();
		}
		return $rec;
    }
	public function get_search_crawl_data($action, $uid=""){
		$rec = array();
		$sql = "SELECT * FROM serp_google_crawl_data WHERE crawlby = '".$action."'";
		
		if($uid != "")
		 $sql = "SELECT * FROM serp_google_crawl_data WHERE crawlby = '".$action."' AND user_id=".$uid;
		
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$rec = $query->result_array();
		}
		return $rec;
    }
	public function google_search($data){
		$sql	= "INSERT INTO google_search SET
			       title	= '".addslashes($data['title'])."',
			       url		= '".addslashes($data['url'])."',
			       query_url		= '".addslashes($data['query_url'])."'";
				   
		$this->db->query($sql);

	}

	public function search_url($string, $uid){
		$arr = array();
		$sql = "SELECT url FROM serp_crawl_data WHERE searchstring = '".$string."' AND users_id=".$uid;
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$arr = $query->result_array();
		}
		return $arr;
	}

	public function return_crawl_data(){
		$arr = array();
		$sql = "SELECT * FROM serp_crawl_data";
		$query	= $this->db->query($sql);
		if($query->num_rows() > 0){
			$arr = $query->result_array();
		}
		return $arr;
	}
	
	public function insertCrawlData($data){
		
		$intro = "";
		$body = "";
		$conclusion = "";
		
		if(isset($data['content_intros']) && $data['content_intros'] != "")
		 $intro = addslashes($data['content_intros']);
		 
		if(isset($data['body_content']) && $data['body_content'] != "")
		 $body = addslashes($data['body_content']);
		 
		if(isset($data['conclusion']) && $data['conclusion'] != "")
		 $conclusion = addslashes($data['conclusion']);
		
		$sql	= "INSERT INTO serp_crawl_data SET
			       serp_google_crawl_data_id	= '".$data['serp_google_crawl_data_id']."',
			       campaign_id	= '".addslashes($data['campaign_id'])."',
			       users_id	= '".addslashes($data['users_id'])."',
				   crawlby	= '".addslashes($data['crawlby'])."',
				   url	= '".addslashes($data['url'])."',
			       proxy	= '".addslashes($data['proxy'])."',
			       keyword		= '".addslashes($data['keyword'])."',
			       searchstring		= '".addslashes($data['searchstring'])."',
				   content_intros	= '".$intro."',
				   body_content		= '".$body."',
				   conclusion		= '".$conclusion."',
				   bullet_points		= '".$data['bullet_points']."',
				   campaign_main_page_url		= '".addslashes($data['campaign_main_page_url'])."',
				   date_entered		= '".$data['date_entered']."',
				   date_modified		= '".$data['date_modified']."',
				   title		= '".addslashes($data['title'])."'";
		$this->db->query($sql);
		return true;
	}
	function content_formatting($content){
		
	$m=explode('.',$content);	
	$nums_of_sentense = count($m);           // count number of paragraphs
	$position=rand(0,($nums_of_sentense-2));   // randamly heading total paragraphs - 2.
	
	$content = $this->word_format($position, $content);
	
	if($nums_of_sentense>10){
	$heading1 = "<p><h3>".ucfirst($m[$position]).".</h3></p>";	
		$content=str_replace($m[$position].".",$heading1,$content);
		
		// for sub heading 		
		$sub_rand = rand(0,9);
		if($sub_rand==1){
			$position=$position+$sub_rand;
			$sub_heading = "<p><b>".ucfirst($m[$position]).".</b></p>";	
			$content=str_replace($m[$position].".",$sub_heading,$content);
		}	
		if($sub_rand==2){
			$position=$position+1;
			$sub_heading = "<p><b><u>".ucfirst($m[$position]).".</u></b></p>";	
			$content=str_replace($m[$position].".",$sub_heading,$content);
		}
		if($sub_rand==3){
			for($middle_content=1;$middle_content<$sub_rand;$middle_content++){	
				$position=$position+$middle_content;				
			}
		}
		if($sub_rand==4){
			for($middle_content=1;$middle_content<=2;$middle_content++){	
				$position=$position+$middle_content;				
			}
			$position=$position+1;
			if(!empty($m[$position])){
				$sub_heading = "<p><b>".ucfirst($m[$position]).".</b></p>";	
				$content=str_replace($m[$position].".",$sub_heading,$content);
			}else{ $content=$content;}
		}
		if($sub_rand==5){ // sub heading underline
			for($middle_content=1;$middle_content<=2;$middle_content++){	
				$position=$position+$middle_content;				
			}
			$position=$position+1;
			if(!empty($m[$position])){
				$sub_heading = "<p><b><u>".ucfirst($m[$position]).".</u></b></p>";	
				$content=str_replace($m[$position].".",$sub_heading,$content);
			}else{ $content=$content;}
		}
		if($sub_rand==6){ // sub heading italics
			for($middle_content=1;$middle_content<=2;$middle_content++){	
				$position=$position+$middle_content;				
			}
			$position=$position+1;
			if(!empty($m[$position])){
				$sub_heading = "<p><b><i>".ucfirst($m[$position]).".</i></b></p>";	
				$content=str_replace($m[$position].".",$sub_heading,$content);
			}else{ $content=$content;}
		}
        if($sub_rand==7){
			for($middle_content=1;$middle_content<2;$middle_content++){	
				$position=$position+$middle_content;				
			}
		}
        if($sub_rand==8){ // sub heading italics
			for($middle_content=1;$middle_content<=3;$middle_content++){	
				$position=$position+$middle_content;				
			}
			$position=$position+1;
			if(!empty($m[$position])){
				$sub_heading = "<p><b>(".ucfirst($m[$position]).".)</b></p>";	
				$content=str_replace($m[$position].".",$sub_heading,$content);
			}else{ $content=$content;}
		}
		if($sub_rand==9){ // sub heading italics
			for($middle_content=1;$middle_content<=3;$middle_content++){	
				$position=$position+$middle_content;				
			}
			$position=$position+1;
			if(!empty($m[$position])){
				$sub_heading = "<p><b>&quot;".ucfirst($m[$position]).".&quot;</b></p>";	
				$content=str_replace($m[$position].".",$sub_heading,$content);
			}else{ $content=$content;}
		}
		
			
		// Bullets italics Quotes and parentheses
		$bullet_rand = rand(0,7);		
		switch ($bullet_rand) {				
				case 0:				   
					$bullet_styles= "circle";
					break;
				case 1:
				    $bullet_styles= "lower-roman";
					break;
				case 2:
				    $bullet_styles= "upper-roman";
					break;				
				case 3:				    
					$bullet_styles= "decimal";
					break;
				case 4:
				    $bullet_styles= "square";
					break;				
				case 5:				    
					$bullet_styles= "disc";
					break;
				case 6:				    
					$bullet_styles= "none";
					break;
				case 7:				   
					$bullet_styles= "circle";
					break;						
												
			}
			$num_bullets = rand(2,8);
			for($j=1;$j<=$num_bullets;$j++){						
				$bullet_position= $position+$j;
				if(!empty($m[$bullet_position])){
					if($j==1){ $prefix='<ul type="'.$bullet_styles.'">'; } else{ $prefix='';}
					if($j==$num_bullets){ $postfix='</ul>'; } else{ $postfix='';}
					if($bullet_styles=='none'){							
						$bullet=$prefix." <li><u><i>".ucfirst($m[$bullet_position]).".</i></u></li> ".$postfix;
					}else{
						$bullet=$prefix." <li>".ucfirst($m[$bullet_position]).".</li> ".$postfix;	
					}
					$content=str_replace($m[$bullet_position].".",$bullet,$content);
				}else{ $content=$content;}
			}
		  return $content;
	      }	
    }
	function link_identifier($anchors = '', $link = '',$content, $words){
		  if($anchors!='' && $link!=''){			
			$anchor = $this->spin($anchors);
			$link = $this->spin($link);			
				$links = ' <a href="'.$link.'" title="">'.$anchor.'</a> ';	
				$content=str_replace($words,$links,$content);
			}else{ $content=$content;}
		return $content;
	}
	
	function word_format($position,$content){
		$m=explode('.',$content);		
		if($position > 5) {    // randamly italics, bold, bold italics, underlined etc.
		  $new_position = $position-1;  //6
		  $serp_format = rand(1,$new_position); 	//2-6	      
		  
		  if (strpos($m[$serp_format],',') !== false) {
				$chars=explode(',',$m[$serp_format]);
				$p=rand(0,(count($chars)-1));
				$n=$chars[$p];
				
				$farmat_words= str_word_count($n);
				$new= explode(' ',$n);
				
				$x=rand(3,$farmat_words);
				$arr= array();
				for($format=1;$format<$x;$format++){						
					if(!empty($new[$format])){
						array_push($arr, $new[$format]);						
					}						
				}
				
			}	
		  
		    $case_format= rand(0,5);
		    switch ($case_format) {				
				case 0:
				    if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <b><u>".$new_str."</u></b> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}				
				break;
				case 1:
				    if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <b>".$new_str."</b> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}
				break;
				case 2:
				    if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <i><u>".$new_str."</u></i> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}
				break;				
				case 3:				    
					if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <b><i>".$new_str."</i></b> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}
				break;
				case 4:
				    if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <i>".$new_str."</i> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}
				break;				
				case 5:				    
					if(!empty($arr)){
					$new_str = implode(" ", $arr);
					$xx = " <u>".$new_str."</u> ";	
					$content=str_replace($new_str,$xx,$content);
					}else{ $content=$content;}
				break;
									
			    }
			   return $content; 
	       }else{
			  return $content; 
		   }
		
	    } //function close
		
		
		function key_replace($anchor, $link, $content, $syms_all, $settings = ''){
			
			$words=explode(',',$syms_all);
			$sy_rand = rand(0,count($words));
			
			for($i=0;$i<count($words);$i++){					
				$position1 = strpos($content, trim($words[$i]));
				 if ($position1 == false) {
					 $find_words=trim($words[$i]);					
				 }else{
					 $find_words=trim($words[$i]);					
					 break;
				 }
			}
				
				    $myfind = explode(trim($find_words),$content);					
					$position=rand(0,(count($myfind)-1));
					$new_pos=$position+1;
				
				if($settings=='Keyword' || $settings == ''){					
					
					if(!empty($myfind[$position])){	
						$content_new=str_replace($find_words,' <a href="'.$link.'" title="">'.$anchor.'</a> ',$find_words.$myfind[$position]);
						$content=str_replace($find_words.$myfind[$position],$content_new,$content);					
					}					
					
				}
				if($settings=='Brand'){
					
					
					if(!empty($myfind[$position])){
						
						$pos = strpos($content, $find_words);
                        if ($pos == true) {
							
							$content_new=str_replace($find_words,$find_words.' <a href="'.$link.'" title="">'.$anchor.'</a> ',$find_words.$myfind[$position]);
							//$links = $myfind[$position].' <a href="'.$link.'" title="">'.$anchor.'</a> ';						
							//$content=str_replace($myfind[$position],$links,$content);
							$content=str_replace($find_words.$myfind[$position],$content_new,$content);			
						}else{$content=$content;}
					}
					
				}
				if($settings=='Raw URL'){
					
					if(!empty($myfind[$position])){
						
						$pos = strpos($content, $find_words);
                        if ($pos == true) {
							//$links = ' <a href="'.$link.'" title="">'.$anchor.'</a> '.$myfind[$position];						
							//$content=str_replace($myfind[$position],$links,$content);
							$content_new=str_replace($find_words,' <a href="'.$link.'" title="">'.$anchor.'</a> '.$find_words,$find_words.$myfind[$position]);
							$content=str_replace($find_words.$myfind[$position],$content_new,$content);
						}else{$content=$content;}
					}		
					//$links = $words[$i].' <a href="'.$link.'" title="">'.$anchor.'</a> ';	
					//$content=str_replace($words[$i],$links,$content);
				}
				if($settings=='Generic'){
					
					
					$pos = strpos($content, $find_words);
                    if ($pos == false) {
                        $links = $syms_all.' <a href="'.$link.'" title="">'.$anchor.'</a> ';						
						$content=str_replace($syms_all,$links,$content);
						
					} else {						
						
						if(!empty($myfind[$position])){
						//$links = $myfind[$position].' <a href="'.$link.'" title="">'.$anchor.'</a> ';
						//$content=str_replace($myfind[$position],$links,$content);
						$content_new=str_replace($find_words,$find_words.' <a href="'.$link.'" title="">'.$anchor.'</a> ',$find_words.$myfind[$position]);
						$content=str_replace($find_words.$myfind[$position],$content_new,$content);	
						
							if(!empty($myfind[$new_pos])){
								$links2 = $find_words.$myfind[$new_pos];				
								$content=str_replace($links2,$myfind[$new_pos],$content);
								
							}
							 $pos=true;
							}							
							}
				
				}
			return $content; 
		}
		
		
	   function comment_save($post_id,$all_comments){
		   
		    $nums_of_comments = count($all_comments);// count number of comments
			if($nums_of_comments > 18){
			$perpost=rand(2,18);	
			}else{				
			$perpost=rand(2,$nums_of_comments);	
			}
	        $comment_count=0;   
			for($i=0;$i<=$perpost;$i++){
			 $comment_num_rand = rand(2,$nums_of_comments);
			 
			   $is_esist = $this->check_is_exist($post_id, $all_comments[$comment_num_rand]);			 
               if ($is_esist) {
               //echo '1'.$data[$c];
               } else {
				   $comment_count++;
                   $sql = "INSERT INTO post_comments SET
			       post_id	    = ".$post_id.",
			       comments		= '".addslashes($all_comments[$comment_num_rand])."',
			       status	= 'publish',
				   create_date	= '".date("Y-m-d H:i:s")."',
				   update_date	= '".date("Y-m-d H:i:s")."'";
		           $this->db->query($sql);        
               }			
			
			}
			$sql = "UPDATE campaign_posts SET comment_count=".$comment_count." WHERE ID=".$post_id;			
			$this->db->query($sql);
	   }
	   
	   function check_is_exist($post_id, $comment){
			$this->db->select('*');
			$this->db->from('post_comments');					
			if($post_id!=''){
			  $this->db->where('post_id', $post_id);			  	 
			}
			$this->db->where('comments', $comment);	
			$result = $this->db->get();
			//echo '<pre>'; print_r($result);die();
			if($result->num_rows > 0){
				return true;			
			}else{
				return false;
			}
	   }
	   
	 function get_active_posts($user_id='',$status='',$id='')
	    {
		$this->db->select('*');
		$this->db->from('campaign_posts');
		//$this->db->group_by('id');
		if($user_id){ 
			 $this->db->where('user_id', $user_id);	
		}		
		if($status){
			$this->db->where('post_status', $status);
		}
		if($id!=''){
		  $this->db->where('ID', $id);	
		}
		
		$this->db->order_by('ID', 'DESC');
		$result = $this->db->get();
		$result = $result->result();		
		return $result;
	 }
	 
	 
	 public function fetch_campaign_posts()
     {
		 $retarr = array();
		 
		 $query = $this->db->select("*")->from("campaign_posts")->get();
		 
		 if($query->num_rows() > 0)
		  {
			  foreach($query->result() as $row)
			  {
				  $retarr[$row->ID] = array('posttitle' => $row->post_title);
			  }
		  }
		 
		 return $retarr;
     }
	 
	 
	public function update_article($id, $data=array(), $mode="get")
	{
		$retarr = array();
		$status = false;
		
		if($mode == "get")
		{
			$result = $this->db->select('*')->from("campaign_posts")->where('ID',$id)->get();
				
			if($result->num_rows() > 0)
			{
				$status = true;
				
				foreach($result->result() as $row)
				{
					$original_data['id'] = $row->ID;
					$original_data['content'] = $row->post_content;
					$original_data['anchor1'] = $row->anchor1;
					$original_data['anchor2'] = $row->anchor2; 			
					$original_data['anchor3'] = $row->anchor3;
					$original_data['link1']	= $row->link1;
					$original_data['link2']	= $row->link2; 			
					$original_data['link3']	= $row->link3;
				}
				
				$retarr['data'] = $original_data;
			}
		}
		
		if($mode == "update")
		{
			if(count($data) > 0)
			{
				$update_data = array();
				
				if(trim($data['anchor1']) != "")
				$update_data['anchor1'] = $data['anchor1'];
				
				if(trim($data['anchor2']) != "")
				$update_data['anchor2'] = $data['anchor2'];
				
				if(trim($data['anchor3']) != "")
				$update_data['anchor3'] = $data['anchor3'];
				
				if(trim($data['link1']) != "")
				$update_data['link1'] = $data['link1'];
				
				if(trim($data['link2']) != "")
				$update_data['link2'] = $data['link2'];
				
				if(trim($data['link3']) != "")
				$update_data['link3'] = $data['link3'];
				
				if(count($update_data) > 0)
				$this->db->update("campaign_posts", $update_data, array('ID' => $id));
				
				$status = true;
			}
		}
		
		$retarr['status'] = $status;
		
		return $retarr;
	}
	
	public function update_content($id, $update_data)
	{
		if(count($update_data) > 0)
		$this->db->update("campaign_posts", $update_data, array('ID' => $id));
	}
	
	public function update_keywords($campaignid, $userid, $topics, $keywords, $synonyms)
	{
		$update_data['campaign_id'] = $campaignid;
		$update_data['users_id'] = $userid;
		$update_data['topics'] = $topics;
		$update_data['keywords'] = $keywords;
		$update_data['synonyms'] = $synonyms;
		
		$update_data['date_added'] = date('Y-m-d H:i:s');
		$update_data['date_modified'] = date('Y-m-d H:i:s');
		
		$this->db->update("serp_users_campaign_keywords", $update_data, array('keyword_id' => 1));
	}
	
	public function truncate_data()
	{
		$this->db->truncate('serp_google_crawl_data');
		$this->db->truncate('serp_crawl_data'); 
	}
	
	public function get_obl($domain)
	{
		$reffer = "http://www.google.com";

		$agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";
	
		$query = $this->db->select('proxy')->from('serp_proxies')->where('status', 1)->get();

    		if($query->num_rows() > 0)
			{
    			foreach($query->result() as $row)
				{
					$proxy_list[] = $row->proxy;
				}
			}
			
		$proxy = $proxy_list[rand(0,count($proxy_list)-1)];
		
        $html_answer = str_get_html($this->crawl_list($reffer, $domain, $agent, $proxy));
		
		$counter = 0;

        foreach($html_answer->find('body a') as $content)
		{
			$flag = true;
			
			if(trim($content->href) == "")
			  $flag = false;
			else
			{
				if(substr($content->href,0,1) == "/" || substr($content->href,0,1) == "#")
				{
					$flag = false;
				}
				else
				{
					$link = "";
					$url = parse_url($content->href);
	
					if(!empty($url["host"]))
					   $link = strtolower($url["host"]);
					else
					{
						if(!empty($url["path"]))
					     $link = strtolower($url["path"]);
					}
				
					$link = str_replace("www.","",$link);
					
					if($link == "" || $link == $domain)
					 $flag = false;
					 
					if(empty($url["scheme"]))
					 $flag = false;
				}
			}

			if($flag)
			$counter++;
		}

		return $counter;
	}
	
	public function crawl_list($reffer, $url, $agent, $proxy)
	{
			ob_start();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $agent);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_REFERER, $reffer);
			
			/*Proxy curl settings*/
			curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
			// curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'username:passord');
			
			/*SSL settings*/
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			//curl_setopt($ch, CURLOPT_HEADER, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			//ob_flush();
			return $result;
	}
	function find_posts($id = false)
	{
		$this->db->select('*');
		$this->db->from('campaign_posts');			
		if($id){
		  $this->db->where('ID', $id);	
		}
		$result = $this->db->get();		
		$result = $result->result();
		//$sql = $this->db->last_query();
		//echo $sql;die;		
		return $result;
	}
	
	function update_links($id, $field_name, $new_link){
		$val_num = substr($field_name,-1);
		$anchor_field = 'anchor'.$val_num;
		$link_field =  'link'.$val_num;
		$res=$this->find_posts($id);
		//echo "<pre>";print_r($res);
		
		 $old_link = $res[0]->$link_field;
		 $anchor = $res[0]->$anchor_field;
		 $content = $res[0]->post_content;
		 $find_words = '<a href="'.$old_link.'" title="">'.$anchor.'</a>';
		 if (strpos($field_name,'link') !== false) {
			$content_new = '<a href="'.$new_link.'" title="">'.$anchor.'</a>';
		 }else{
		    $content_new = '<a href="'.$old_link.'" title="">'.$new_link.'</a>';
		 }
		 $content1 = str_replace($find_words,$content_new,$content);
		//update here
		$post['ID']=$id;
		$post[$field_name] = $new_link;
		$post['post_content'] = $content1;
		$post['post_modified'] = date('Y-m-d H:i:s');
		//echo "<pre>";print_r($post);
		$this->db->where('id', $id);
		$this->db->update('campaign_posts', $post);
		return $this->db->affected_rows();
		
	}   
		public function getUsersCampaigns($users_id){
			$rec	= false;
			$sql	= "SELECT * FROM serp_users_campaign_master WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";
			$query	= $this->db->query($sql);
			if($query->num_rows() > 0){
				$rec	= $query->result_array();
				if(is_array($rec) && count($rec) > 0){
				for($i=0; $i<count($rec); $i++){
					$sql	= '';
					$query	= '';
					$sql	= "SELECT * FROM serp_users_campaign_keywords AS CK, serp_users_campaign_detail AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$rec[$i]['campaign_id']."'";
					$query	= $this->db->query($sql);
					if($query->num_rows() > 0){
					$rec[$i]['campaign'] = $query->result_array();
					}else{
					$rec[$i]['campaign'] = '';
					}
				}
				}
			}
			return $rec;
		}
	} //class end;
?>