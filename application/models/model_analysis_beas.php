<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_analysis_beas extends CI_Model

{

	var $tblCampaigns		= 'serp_users_campaign_detail';

	var $tblCrawledURLDataGoogle	= 'serp_google_crawl_data';

	var $tblCrawledURLDataBing	= 'serp_bing_crawl_data';

	var $tblCrawledURLDataYahoo	= 'serp_yahoo_crawl_data';

	var $tblUsersCampaignMaster 	= 'serp_users_campaign_master';

	var $sql_current_date		='';

	var $graph_data_limit		=14;

	var $long_term_limit		=3;

	

	public function __construct()

	{

		// Call the Model constructor

		

		parent::__construct();

		$ci = get_instance();

		$ci->load->helper('dom');		

		

//		$this->key_word_where=' AND CG.keyword = "' . $campaign_list . '"';

		//$this->sql_current_date=date("Y-m-d", strtotime('-1 days', strtotime(date('Y-m-d'))));

		$this->sql_current_date=date('Y-m-d');

	}

	function getUsersCampaignsKeywords($users_id){

	$rec	= false;

	$sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGN_MASTER . " WHERE users_id = '".$users_id."' AND campaign_status = 'Active'";

	$query	= $this->db->query($sql);

	if($query->num_rows() > 0){

	   // pr($query->result_array());

	    foreach($query->result_array() as $index=>$data){

		

		    $sql	= '';

		    $query	= '';

		    $sql	= "SELECT * FROM " . TABLE_USERS_CAMPAIGNS_KEYWORD . " AS CK, " . TABLE_USERS_CAMPAIGNS . " AS UC WHERE CK.campaign_id = UC.campaign_id AND UC.c_id = '".$data['campaign_id']."'";

		    $query	= $this->db->query($sql);

		    foreach($query->result_array() as $sub_row=>$sub_data){

			   $rec[$data['campaign_title']][$sub_data['keyword_id']] = $sub_data['keyword']; 

		    }

		    

	    }

	}

	

	return $rec;

    }



function get_recovery_site($campaign_list, $campaign_server_engine){

$user_id=$this->session->userdata("LOGIN_USER");

		$rec	= FALSE;$record=FALSE;

		$crawl_server="";

		$table="";

		switch($campaign_server_engine){

			case "google" :

				$table="serp_google_crawl_data";

$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

			$table="serp_yahoo_crawl_data";

$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

			$table="serp_bing_crawl_data";

$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$WC="";

				if(!empty($campaign_list)){

					if($campaign_list=="Show All Combined"){

						$this->db->where("users_id",$user_id);

						$cam_query=$this->db->get($this->tblUsersCampaignMaster);

						$c_list="";

						foreach($cam_query->result_array() as $c_index=>$c_data){

							$c_list .=$c_data["campaign_id"].",";

						}

						$c_list=rtrim($c_list,",");

						$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

					}else{

						$WC	.= $this->key_word_where($campaign_list);

					}

				}

				

				$sql	= "SELECT CG.*

						  FROM " . $table . " AS CG, "

						  . $this->tblCampaigns .  " AS TC

						  WHERE CG.campaign_id = TC.campaign_id

						    AND TC.users_id = '". $user_id ."'

						    AND  ".$crawl_server." "

						    . $WC." group by CG.url" ;

	//			echo $sql;die;

	$query=$this->db->query($sql);

	foreach($query->result_array() as $index=>$data ){

			

		$sub_sql="SELECT rank,date_added from ".$table

		         ." where url='".$data['url']."' order by date_added desc limit 0,3";

			

			$sub_query=$this->db->query($sub_sql);

			

			if($sub_query->num_rows() == 3){

				

				$rank_record=$sub_query->result_array();

				$current_rank=$rank_record[2]['rank'];

				$pre_rank=$rank_record[1]['rank'];

				$pre_pre_rank=$rank_record[0]['rank'];

				if($pre_pre_rank <= 10 and $pre_rank > 10 and $current_rank <= 10)

				{

					$rec[$data['keyword']][]=$data['id'];

					$rec['total_rows'][]=$data['id'];

				}

			}

	}

	//echo $table;

	//print_r($rec);

	//die;

	return $rec;

}



function get_long_term_site($campaign_list, $campaign_server_engine){

$user_id=$this->session->userdata("LOGIN_USER");

		$rec	= FALSE;$record=FALSE;

		$crawl_server="";

		$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

			$crawl_table="serp_yahoo_crawl_data";

$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

			$crawl_table="serp_bing_crawl_data";

$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$WC="";

				if(!empty($campaign_list)){

					if($campaign_list=="Show All Combined"){

						$this->db->where("users_id",$user_id);

						$cam_query=$this->db->get($this->tblUsersCampaignMaster);

						$c_list="";

						foreach($cam_query->result_array() as $c_index=>$c_data){

							$c_list .=$c_data["campaign_id"].",";

						}

						$c_list=rtrim($c_list,",");

						$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

					}else{

						$WC	.= $this->key_word_where($campaign_list);

					}

				}

				

				$sql	= "SELECT CG.*

						  FROM " . $crawl_table . " AS CG, "

						  . $this->tblCampaigns .  " AS TC

						  WHERE CG.campaign_id = TC.campaign_id

						    AND TC.users_id = '". $user_id ."'

						    AND  ".$crawl_server." "

						    . $WC." group by CG.url" ;

	//			echo $sql;die;

	$query=$this->db->query($sql);$long_term_site=array();

	foreach($query->result_array() as $row=>$data){

			

		

			$sql="";$day_limit=60;

			//$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

			//$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$day_limit." days", strtotime($this->sql_current_date))).'"';

			$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				    AND TC.users_id = '". $user_id ."'

				    AND  ".$crawl_server." "

				    ." AND CG.url='".$data['url']."' AND CG.rank <= 10 "

				    . $WC . " order by CG.date_added desc";

				   

			$query1=$this->db->query($sql);

			

			$count=0;

			foreach($query1->result_array() as $index=>$sub_data){

				if($sub_data['date_added'] == date("Y-m-d",strtotime("-".$count." days", strtotime($this->sql_current_date)))  )

				{

					//$long_term_site[ $sub_data['url'] ][] = $sub_data['date_added']."==>".date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))."==>".$sub_data['rank'];

					$long_term_site[ $sub_data['url'] ]['sub_data'][$count] = $sub_data['date_added'];

					$long_term_site[ $sub_data['url'] ]['details']['id'] = $sub_data['id'];

					$long_term_site[ $sub_data['url'] ]['details']['keyword'] = $sub_data['keyword'];

				}

				$count++;

			}

			

		}

		

		foreach($long_term_site as $row=>$data){

			

			if(count($data['sub_data']) >= $this->long_term_limit){

				    $rec[$data['details']['keyword']][]=$data['details']['id'];

					$rec['total_rows'][]=$data['details']['id'];

			}

		}

	//echo $table;

	//print_r($rec);

	//die;

	return $rec;

	

}





	

	function key_word_where($campaign_list){

		//$key_word_where=' AND CG.campaign_id = "' . $campaign_list . '"';

		$key_word_where=' AND CG.keyword = "' . $campaign_list . '"';

		

		return $key_word_where;

	}



public function renderUsersDomainAge($campaign_list, $campaign_server_engine,$site_type){

		$usr 	= $this->session->userdata('current_user');

		$rec	= FALSE;$crawl_server="";

		$user_id=$this->session->userdata("LOGIN_USER");

		$crawl_server="";

		$WC ="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				

				$WC	.= $this->key_word_where($campaign_list);

			}

			

		}

		

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

			$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

			$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

			$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

			$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		

		for($i=0; $i< $this->graph_data_limit; $i++){

				$oldCount	= 0;

				$youngCount	= 0;

				$newCount	= 0;

				$sumAge		= 0;

				$avgAge		= 0;

				$avgAge14	= 0;

				$percentOld	= 0;

				$percentYoung	= 0;

				$percentNew	= 0;

				$strAvgAge	= '';

				$oldArray	= array();

				$youngArray	= array();

				$newArray	= array();

				

			    $WC="";

			    $cal_date=date("Y-m-d", strtotime("-".$i." days", strtotime($this->sql_current_date)));

				

				if(!empty($campaign_list)){

					if($campaign_list=="Show All Combined"){

						$this->db->where("users_id",$user_id);

						$cam_query=$this->db->get($this->tblUsersCampaignMaster);

						$c_list="";

						foreach($cam_query->result_array() as $c_index=>$c_data){

							$c_list .=$c_data["campaign_id"].",";

						}

						$c_list=rtrim($c_list,",");

						$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

					}else{

						

						$WC	.= $this->key_word_where($campaign_list);

					}

					

				}

			    $WC		.= ' AND CG.date_added = "'.$cal_date.'"';

			 

				$sql	= "SELECT COUNT(*) AS ageCount, DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age, CASE

				    WHEN DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) >= 365 THEN 'old' 

				    WHEN (DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) < 365 AND DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) > 180) THEN 'young'

				    WHEN DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) <= 180 THEN 'new'

				    END AS ageType,

				    CG.date_added

				    FROM " . $this->tblCrawledURLDataGoogle . " AS CG, "

				    . $this->tblCampaigns .  " AS TC

				    WHERE CG.campaign_id = TC.campaign_id

				      AND TC.users_id = '". $user_id ."'

				      AND ".$crawl_server." "

				          . $WC ;

			      

				switch($site_type){

						case "top_ten":

							

							$sql .=" ORDER BY rank LIMIT 0, 10";

							     

							break;

						case "top_three":

							$sql .=" ORDER BY rank LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY ageType  ORDER BY rank';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY ageType  ORDER BY rank';

							break;

						case "recovery":

							$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY ageType  ORDER BY rank';

						break;

						case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY ageType  ORDER BY rank';

						break;

					}

			//echo $sql."\n"	;      	

				$query	= $this->db->query($sql);

				if($query->num_rows() > 0){

					$num_rows	= $query->num_rows();

					//$sumAge = 0;

					foreach($query->result() AS $row){

						 

						if($row->ageType == 'old'){

							$oldCount++;

						}elseif($row->ageType == 'young'){

							$youngCount++;

						}elseif($row->ageType == 'new'){

							$newCount++;

						}

						

						$sumAge	= $sumAge+$row->age;

						//$ageArr[] = $row->age;

						

					}

					//pr($ageArr, 0);

					$percentOld	= round(($oldCount/$num_rows)*100);

					$percentYoung	= round(($youngCount/$num_rows)*100);

					$percentNew	= round(($newCount/$num_rows)*100);

					$avgAge		= round($sumAge/$num_rows);

					$avgAge14      .= $avgAge . ',';

					/*

					if(round($avgAge/365) > 0){

						$strAvgAge	= round($avgAge/365) . ' Years';

					}else if(round($avgAge/30) > 0){

						$strAvgAge	= round($avgAge/30) . ' Months';

					}else{

						$strAvgAge	= $avgAge . ' Days';

					}

					  */

				}

				if($cal_date==$this->sql_current_date){

					$return['percentOld']	= $percentOld;

					$return['percentYoung']	= $percentYoung;

					$return['percentNew']	= $percentNew;

					$return['avg']		= $strAvgAge;

					

				}

				$return['percentOld_graph'][]	= $percentOld;

				$return['percentYoung_graph'][]	= $percentYoung;

				$return['percentNew_graph'][]	= $percentNew;

				$return['avg_graph'][]		= $strAvgAge;

		}

				$return['oldnum'][]	= implode($return['percentOld_graph'], ',');

				$return['youngnum'][]	= implode($return['percentYoung_graph'], ',');

				$return['newnum'][]	= implode($return['percentNew_graph'], ',');

				$return['avgAge'][]	= implode($return['avg_graph'], ',');

		

		//print_r($return);

		//die;

		return $return;

		

}

	

	public function renderUsersDomainAge2($campaign_list, $campaign_server_engine,$site_type){

		$usr 	= $this->session->userdata('current_user');

		$rec	= FALSE;$crawl_server="";

		$user_id=$this->session->userdata("LOGIN_USER");

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

			$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

			$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		for($i=0;$i<$this->graph_data_limit; $i++)

				$oldCount	= 0;

				$youngCount	= 0;

				$newCount	= 0;

				$sumAge		= 0;

				$avgAge		= 0;

				$avgAge14	= 0;

				$percentOld	= 0;

				$percentYoung	= 0;

				$percentNew	= 0;

				$strAvgAge	= '';

				$oldArray	= array();

				$youngArray	= array();

				$newArray	= array();

				

				$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

				if(!empty($campaign_list)){

					if($campaign_list=="Show All Combined"){

						$this->db->where("users_id",$user_id);

						$cam_query=$this->db->get($this->tblUsersCampaignMaster);

						$c_list="";

						foreach($cam_query->result_array() as $c_index=>$c_data){

							$c_list .=$c_data["campaign_id"].",";

						}

						$c_list=rtrim($c_list,",");

						$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

					}else{

						

						$WC	.= $this->key_word_where($campaign_list);

					}

					

				}

				$date_WC ="";

				//$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

			    //    $date_WC.=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

				$WC		= str_replace($WC,' AND CG.date_added = "'.date("Y-m-d").'"',"");

				$sql	= "SELECT COUNT(*) AS ageCount, DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age, CASE

    WHEN DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) >= 365 THEN 'old' 

    WHEN (DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) < 365 AND DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) > 180) THEN 'young'

    WHEN DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) <= 180 THEN 'new'

    END AS ageType,

    CG.date_added

    FROM " . $this->tblCrawledURLDataGoogle . " AS CG, "

    . $this->tblCampaigns .  " AS TC

    WHERE CG.campaign_id = TC.campaign_id

      AND TC.users_id = '". $user_id ."'

      AND ".$crawl_server." "

          . $WC ;

      

      //echo $sql; die;

      //. " GROUP BY ageType " . " ORDER BY rank LIMIT 0, 10";

      switch($site_type){

		case "top_ten":

			

			$sql .=" GROUP BY ageType  ORDER BY rank LIMIT 0, 10";

			     

			break;

		case "top_three":

			$sql .=" GROUP BY ageType  ORDER BY rank LIMIT 0, 3";

			break;

		case "new_site":

			$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY ageType  ORDER BY rank';

			break;

		case "aged":

			$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY ageType  ORDER BY rank';

			break;

	}

 

				$query	= $this->db->query($sql);

				if($query->num_rows() > 0){

					$num_rows	= $query->num_rows();

					foreach($query->result() AS $row){

						 

						if($row->ageType == 'old'){

							$oldCount++;

						}elseif($row->ageType == 'young'){

							$youngCount++;

						}elseif($row->ageType == 'new'){

							$newCount++;

						}

						$sumAge	= $sumAge+$row->age;

					}

					

					$percentOld	= round(($oldCount/$num_rows)*100);

					$percentYoung	= round(($youngCount/$num_rows)*100);

					$percentNew	= round(($newCount/$num_rows)*100);

					$avgAge		= round($sumAge/$num_rows);

					$avgAge14      .= $avgAge . ',';

					

					if(round($avgAge/365) > 0){

						$strAvgAge	= round($avgAge/365) . ' Years';

					}else if(round($avgAge/30) > 0){

						$strAvgAge	= round($avgAge/30) . ' Months';

					}else{

						$strAvgAge	= $avgAge . ' Days';

					}

				}

				$return['percentOld']	= $percentOld;

				$return['percentYoung']	= $percentYoung;

				$return['percentNew']	= $percentNew;

				$return['avg']		= $strAvgAge;

				//$return['avgAge14']     = rtrim($avgAge14,',');

				

				

				$sql= '';

				$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

				$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

				$sql	= "SELECT DATEDIFF( NOW(),

				                  FROM_UNIXTIME(CG.domain_creation_date) ) AS days

					   FROM " . $this->tblCrawledURLDataGoogle . " AS CG, "

					   . $this->tblCampaigns .  " AS TC

					   WHERE CG.campaign_id = TC.campaign_id

					     AND TC.users_id = '". $user_id ."'

					     AND TC.isCrawlByGoogle = 1 "

					     

					     . $WC ;

					     //. " ORDER BY rank LIMIT 0, 10";

					     switch($site_type){

						case "top_ten":

							

							$sql .=" ORDER BY rank LIMIT 0, 10";

							     

							break;

						case "top_three":

							$sql .="ORDER BY rank LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 ORDER BY rank';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 ORDER BY rank';

							break;

					}

				$query	= $this->db->query($sql);

				

				if($query->num_rows() > 0){

					foreach($query->result() AS $row){

						if($row->days >= 365){

							$oldArray[]	= $row->days;

						}elseif($row->days < 365 && $row->days > 180){

							$youngArray[]	= $row->days;

						}elseif($row->days <= 180){

							$newArray[]	= $row->days;

						}

					}

				}

				

				$return['oldnum']	= implode(",", $oldArray);

				$return['youngnum']	= implode(",", $youngArray);

				$return['newnum']	= implode(",", $newArray);

				

				

				// For Top 3 Sites

			

				

				$oldCount2	= 0;

				$youngCount2	= 0;

				$newCount2	= 0;

				$sumAge2	= 0;

				$percentOld2	= 0;

				$percentYoung2	= 0;

				$percentNew2	= 0;

				$avgAge2	= 0;

				

				$sql	= "SELECT COUNT(*) AS ageCount, DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age, CASE

    WHEN DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) >= 365 THEN 'old' 

    WHEN (DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) < 365 AND DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) > 180) THEN 'young'

    WHEN DATEDIFF(NOW(), FROM_UNIXTIME(CG.domain_creation_date)) <= 180 THEN 'new'

    END AS ageType FROM " . $this->tblCrawledURLDataGoogle . " AS CG, " . $this->tblCampaigns .  " AS TC WHERE CG.campaign_id = TC.campaign_id AND TC.users_id = '". $user_id ."' AND ".$crawl_server." " . $WC ;

    

				$query	= $this->db->query($sql);

				if($query->num_rows() > 0){

					$num_rows	= $query->num_rows();

					foreach($query->result() AS $row){

						if($row->ageType == 'old'){

							$oldCount2++;

						}elseif($row->ageType == 'young'){

							$youngCount2++;

						}elseif($row->ageType == 'new'){

							$newCount2++;

						}

						$sumAge2	= $sumAge2+$row->age;

					}

					

					$percentOld2	= round(($oldCount2/$num_rows)*100);

					$percentYoung2	= round(($youngCount2/$num_rows)*100);

					$percentNew2	= round(($newCount2/$num_rows)*100);

					$avgAge2	= round($sumAge2/$num_rows);

				}

				$return['percentOld2']	= $percentOld2;

				$return['percentYoung2']= $percentYoung2;

				$return['percentNew2']	= $percentNew2;

				

				

				return $return;

		return $rec;

	}

	

	public function renderUsersDomainPageCount($campaign_list, $campaign_server_engine,$site_type){

			$user_id=$this->session->userdata("LOGIN_USER");

			$rec	= FALSE;

			$percent_10_num	= 0;

			$crawl_server="";

			switch($campaign_server_engine){

				case "google" :

					$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

					$crawl_server="TC.isCrawlByGoogle = 1";

					break;

				case "yahoo" :

					$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

					$crawl_server="TC.isCrawlByYahoo = 1";

					break;

				case "bing" :

					$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

					$crawl_server="TC.isCrawlByBing = 1";

					break;

			}		

				

				$WC="";

				

				$camp_sql="";

								

				$sql = "";

				if(!empty($campaign_list)){

					$sqlWC = " AND keyword_id = '".$campaign_list."'";

				}else{

					$sqlWC = "";

				}

				

				switch($site_type){

					case "top_ten":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 10";

						break;

					case "top_three":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 3";

						break;

					case "new_site":

						$sqlWC .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) <= 365 ';

						$sqlOrd = "  ORDER BY rank ";

						break;

					case "aged":

						$sqlWC .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) > 365';

						$sqlOrd = ' ORDER BY rank';

						break;

					case "recovery":

							$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

						break;

						case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

				}

				

				$avg_percent_data = 0;

				for($kk = 0; $kk<$this->graph_data_limit; $kk++){					

					if($kk == 0){

						$maxPage	= 0;

						//$minWord	= 0;

						$avgPage	= 0;

						$sumPage	= 0;

						$avg_num_rows = 0;

						$percent_10_num = 0;

						$sql = "SELECT domain_page_count FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d")."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumPage = $sumPage+$rec[$i]['domain_page_count'];

								if(isset($minPage)){

									if($rec[$i]['domain_page_count'] < $minPage){

										$minPage = $rec[$i]['domain_page_count'];

									}

								}else{

									$minPage = $rec[$i]['domain_page_count'];

								}

								

								

								if($rec[$i]['domain_page_count'] > $maxPage){

									$maxPage = $rec[$i]['domain_page_count'];

								}

							}

							$avgPage = $sumPage/$totalRow;

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_page_count'] >= ($avgPage-10) && $rec[$i]['domain_page_count'] <= ($avgPage+10)){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_page_count'].",";	

								}

							}

							$percent_10_num	= round(($avg_num_rows/$totalRow)*100);

						}

						$record['maxPage'] = $maxPage;

						$record['minPage'] = $minPage;

						$record['avgPage'] = $avgPage;

						$record['percent_10_num']	= $percent_10_num;

						$record['percent_data'] = $avg_percent_data;

						$graph_avg_page_percent[] = $percent_10_num;

						

						$graph_max_page[] = $maxPage;

						$graph_min_page[] = $minPage;

						$graph_avg_page[] = $avgPage;

					}else{

						$maxPage	= 0;						

						$avgPage	= 0;

						$sumPage	= 0;

						$avg_num_rows = 0;

						$percent_10_num = 0;

						$sql = "SELECT domain_page_count FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d", strtotime( "-".$kk." days", strtotime(date("Y-m-d"))))."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumPage = $sumPage+$rec[$i]['domain_page_count'];

								if(isset($minPage)){

									if($rec[$i]['domain_page_count'] < $minPage){

										$minPage = $rec[$i]['domain_page_count'];

									}

								}else{

									$minPage = $rec[$i]['domain_page_count'];

								}

								

								if($rec[$i]['domain_page_count'] > $maxPage){

									$maxPage = $rec[$i]['domain_page_count'];

								}

							}

							$avgPage = $sumPage/$totalRow;

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_page_count'] >= ($avgPage-10) && $rec[$i]['domain_page_count'] <= ($avgPage+10)){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_page_count'].",";	

								}

							}

							$percent_10_num	= round(($avg_num_rows/$totalRow)*100);

						}

					}

					$record['percent_10_num']	= $percent_10_num;

					$graph_max_page[] = $maxPage;

					$graph_min_page[] = $minPage;

					$graph_avg_page[] = $avgPage;

					$graph_avg_page_percent[] = $percent_10_num;				

				}

				

				

				

				if(is_array($graph_max_page) && count($graph_max_page) > 0){

					$record['graph_max_page'] = implode(",", $graph_max_page);

				}else{

					$record['graph_max_page'] = '';

				}

				

				if(is_array($graph_min_page) && count($graph_min_page) > 0){

					$record['graph_min_page'] = implode(",", $graph_min_page);

				}else{

					$record['graph_min_page'] = '';

				}

				

				if(is_array($graph_avg_page) && count($graph_avg_page) > 0){

					$record['graph_avg_page'] = implode(",", $graph_avg_page);

				}else{

					$record['graph_avg_page'] = '';

				}

				

				if(is_array($graph_avg_page_percent) && count($graph_avg_page_percent) > 0){

					$record['graph_avg_page_percent'] = implode(",", $graph_avg_page_percent);

				}else{

					$record['graph_avg_page_percent'] = '';

				}

		return $record;

	}

	

	public function renderUsersDomainWordCount($campaign_list, $campaign_server_engine,$site_type){

		$usr 	= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec	= FALSE;$record=FALSE;

		$percent_below_avg	= 0;

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$WC="";

		$camp_sql="";						

			//echo $sql;

				$sql = "";

				if(!empty($campaign_list)){

					$sqlWC = " AND keyword_id = '".$campaign_list."'";

				}else{

					$sqlWC = "";

				}

				

				switch($site_type){

					case "top_ten":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 10";

						break;

					case "top_three":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 3";

						break;

					case "new_site":

						$sqlWC .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) <= 365 ';

						$sqlOrd = "  ORDER BY rank ";

						break;

					case "aged":

						$sqlWC .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) > 365 ';

						$sqlOrd = ' ORDER BY rank';

						break;

					case "recovery":

							$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

							if($campaign_list=="Show All Combined"){

								$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

							}else{

								$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

							}

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

						break;

						case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

							if($campaign_list=="Show All Combined"){

								$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

							}else{

								$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

							}

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

				}

				$avg_percent_data = 0;

				for($kk = 0; $kk<$this->graph_data_limit; $kk++){					

					if($kk == 0){

						$maxWord	= 0;

						//$minWord	= 0;

						$avgWord	= 0;

						$sumWord	= 0;

						$avg_num_rows = 0;

						$sql = "SELECT domain_word_count FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d")."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumWord = $sumWord+$rec[$i]['domain_word_count'];

								if(isset($minWord)){

									if($rec[$i]['domain_word_count'] < $minWord){

										$minWord = $rec[$i]['domain_word_count'];

									}

								}else{

									$minWord = $rec[$i]['domain_word_count'];

								}

								

								

								if($rec[$i]['domain_word_count'] > $maxWord){

									$maxWord = $rec[$i]['domain_word_count'];

								}

							}

							$avgWord = $sumWord/$totalRow;

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_word_count'] < $avgWord){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_word_count'].",";	

								}

							}

							

							$percent_below_avg	= round(($avg_num_rows/$totalRow)*100);

						}

						$record['maxWord'] = $maxWord;

						$record['minWord'] = $minWord;

						$record['avgWord'] = $avgWord;

						$record['percent_below_avg']	= $percent_below_avg;

						$record['percent_data'] = $avg_percent_data;

						

						$graph_max_word[] = $maxWord;

						$graph_min_word[] = $minWord;

						$graph_avg_word[] = $avgWord;

						$graph_avg_word_percent[] = $percent_below_avg;

					}else{

						$maxWord	= 0;

						//$minWord	= 0;

						$avgWord	= 0;

						$sumWord	= 0;

						$avg_num_rows = 0;

						$sql = "SELECT domain_word_count FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d", strtotime( "-".$kk." days", strtotime(date("Y-m-d"))))."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumWord = $sumWord+$rec[$i]['domain_word_count'];

								if(isset($minWord)){

									if($rec[$i]['domain_word_count'] < $minWord){

										$minWord = $rec[$i]['domain_word_count'];

									}

								}else{

									$minWord = $rec[$i]['domain_word_count'];

								}

								

								if($rec[$i]['domain_word_count'] > $maxWord){

									$maxWord = $rec[$i]['domain_word_count'];

								}

							}

							$avgWord = $sumWord/$totalRow;

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_word_count'] < $avgWord){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_word_count'].",";	

								}

							}

							

							$percent_below_avg	= round(($avg_num_rows/$totalRow)*100);

						}

					}

					$graph_max_word[] = $maxWord;

					$graph_min_word[] = $minWord;

					$graph_avg_word[] = $avgWord;

					$graph_avg_word_percent[] = $percent_below_avg;

				}

				

		if(is_array($graph_max_word) && count($graph_max_word) > 0){

			$record['graph_max_word'] = implode(",", $graph_max_word);

		}else{

			$record['graph_max_word'] = '';

		}

		

		if(is_array($graph_min_word) && count($graph_min_word) > 0){

			$record['graph_min_word'] = implode(",", $graph_min_word);

		}else{

			$record['graph_min_word'] = '';

		}

		

		if(is_array($graph_avg_word) && count($graph_avg_word) > 0){

			$record['graph_avg_word'] = implode(",", $graph_avg_word);

		}else{

			$record['graph_avg_word'] = '';

		}

		

		if(is_array($graph_avg_word_percent) && count($graph_avg_word_percent) > 0){

			$record['graph_avg_word_percent'] = implode(",", $graph_avg_word_percent);

		}else{

			$record['graph_avg_word_percent'] = '';

		}		

		return $record;

	}

	

	public function renderUsersDomainKWRatio($campaign_list, $campaign_server_engine,$site_type){

		$usr 	= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec	= FALSE;$record=FALSE;

		$percent_within_1 = 0;

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		$camp_sql="";

		

		

				//echo $sql;

				$sql = "";

				if(!empty($campaign_list)){

					$sqlWC = " AND keyword_id = '".$campaign_list."'";

				}else{

					$sqlWC = "";

				}

				

				switch($site_type){

					case "top_ten":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 10";

						break;

					case "top_three":

						$sqlOrd =" ORDER BY rank  LIMIT 0, 3";

						break;

					case "new_site":

						$sqlWC .= " AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) <= 365";

						$sqlOrd = "  ORDER BY rank ";

						break;

					case "aged":

						$sqlWC .= ' AND DATEDIFF( NOW(), FROM_UNIXTIME(domain_creation_date) ) > 365 ';

						$sqlOrd = ' ORDER BY rank';

						break;

					case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

				}

				$avg_percent_data = 0;

				for($kk = 0; $kk<$this->graph_data_limit; $kk++){					

					if($kk == 0){

						$maxKW	= 0;

						//$minKW	= 0;

						$avgKW	= 0;

						$sumKW = 0;

						$avg_num_rows = 0;

						$percent_within_1 = 0;				

						$sql = "SELECT domain_kw_ratio FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d")."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumKW = $sumKW+$rec[$i]['domain_kw_ratio'];

								if(isset($minKW)){

									if($rec[$i]['domain_kw_ratio'] < $minKW){

										$minKW = $rec[$i]['domain_kw_ratio'];

									}

								}else{

									$minKW = $rec[$i]['domain_kw_ratio'];

								}



								

								if($rec[$i]['domain_kw_ratio'] > $maxKW){

									$maxKW = $rec[$i]['domain_kw_ratio'];

								}

							}

							$avgKW = $sumKW/$totalRow;

							

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_kw_ratio'] >= ($avgKW-1) && $rec[$i]['domain_kw_ratio'] <= ($avgKW+1)){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_kw_ratio'].",";	

								}

							}

							$percent_within_1	= round(($avg_num_rows/$totalRow)*100);

						}

						$record['maxKW'] = $maxKW;

						$record['minKW'] = $minKW;

						$record['avgKW'] = $avgKW;

						$record['percent_within_1']	= $percent_within_1;

						$record['percent_data'] = $avg_percent_data;

						

						$graph_max_KW[] = $maxKW;

						$graph_min_KW[] = $minKW;

						$graph_avg_KW[] = $avgKW;

						$graph_avg_KW_percent[] = $percent_within_1;

					}else{

						$maxKW	= 0;

						//$minKW	= 0;

						$avgKW	= 0;

						$sumKW = 0;

						$avg_num_rows = 0;

						$percent_within_1 = 0;	

						$sql = "SELECT domain_kw_ratio FROM ".$this->tblCrawledURLDataGoogle." WHERE date_added = '".date("Y-m-d", strtotime( "-".$kk." days", strtotime(date("Y-m-d"))))."'" . $sqlWC . $sqlOrd;

						$query	= $this->db->query($sql);

						if($query->num_rows() > 0){

							$totalRow = $query->num_rows();

							$rec = $query->result_array();

							for($i=0; $i<count($rec); $i++){

								$sumKW = $sumKW+$rec[$i]['domain_kw_ratio'];

								if(isset($minKW)){

									if($rec[$i]['domain_kw_ratio'] < $minKW){

										$minKW = $rec[$i]['domain_kw_ratio'];

									}

								}else{

									$minKW = $rec[$i]['domain_kw_ratio'];

								}

								

								if($rec[$i]['domain_kw_ratio'] > $maxKW){

									$maxKW = $rec[$i]['domain_kw_ratio'];

								}

							}

							$avgKW = $sumKW/$totalRow;

							

							for($i=0; $i<count($rec); $i++){

								if($rec[$i]['domain_kw_ratio'] >= ($avgKW-1) && $rec[$i]['domain_kw_ratio'] <= ($avgKW+1)){

									$avg_num_rows++;

									$avg_percent_data .=$rec[$i]['domain_kw_ratio'].",";	

								}

							}

							$percent_within_1	= round(($avg_num_rows/$totalRow)*100);

							

							$graph_max_KW[] = $maxKW;

							$graph_min_KW[] = $minKW;

							$graph_avg_KW[] = $avgKW;

							$graph_avg_KW_percent[] = $percent_within_1;

						}

					}

				}

				if(is_array($graph_max_KW) && count($graph_max_KW) > 0){

					$record['graph_max_KW'] = implode(",", $graph_max_KW);

				}else{

					$record['graph_max_KW'] = '';

				}

				

				if(is_array($graph_min_KW) && count($graph_min_KW) > 0){

					$record['graph_min_KW'] = implode(",", $graph_min_KW);

				}else{

					$record['graph_min_KW'] = '';

				}

				

				if(is_array($graph_avg_KW) && count($graph_avg_KW) > 0){

					$record['graph_avg_KW'] = implode(",", $graph_avg_KW);

				}else{

					$record['graph_avg_KW'] = '';

				}

				

				if(is_array($graph_avg_KW_percent) && count($graph_avg_KW_percent) > 0){

					$record['graph_avg_KW_percent'] = implode(",", $graph_avg_KW_percent);

				}else{

					$record['graph_avg_KW_percent'] = '';

				}

		return $record;

	}	

	

	

	public function renderUsersDomainKWOptimization($campaign_list, $campaign_server_engine,$site_type){

		$usr 			= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;$record=array();

		$kwInURlCount		= 0;

		$kwInTitleCount		= 0;

		$kwInMetaDescCount	= 0;

		$kwInH1Count		= 0;

		

		$kwInURlPercent		= 0;

		$kwInTitlePercent	= 0;

		$kwInMetaDescPercent	= 0;

		$kwInH1Percent		= 0;

		$mean			= 0;

		

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";	

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$camp_sql="";

				if(!empty($campaign_list)){

					if($campaign_list=="Show All Combined"){

						$this->db->where("users_id",$user_id);

						$cam_query=$this->db->get($this->tblUsersCampaignMaster);

						$c_list="";

						foreach($cam_query->result_array() as $c_index=>$c_data){

							$c_list .=$c_data["campaign_id"].",";

						}

						$c_list=rtrim($c_list,",");

						$camp_sql 	= ' AND CG.campaign_id IN (' . $c_list . ')';	

					}else{

						$camp_sql	= $this->key_word_where($campaign_list);	

					}

					$WC .=$camp_sql;

				}

				

				$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

				$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

				$sql	= "SELECT CG.* FROM "

					 . $this->tblCrawledURLDataGoogle . " AS CG,

					 " . $this->tblCampaigns .  " AS TC

					 WHERE CG.campaign_id = TC.campaign_id

					 AND TC.users_id = '". $user_id ."'

					 AND  ".$crawl_server." "

					 .$date_WC." " 

					 . $WC ;

					 

					 switch($site_type){

						case "top_ten":

							

							$sql .= " ORDER BY rank  LIMIT 0, 10";

							break;

						case "top_three":

							$sql .= " ORDER BY rank  LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY CG.date_added '

							     . ' ORDER BY rank ';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY CG.date_added '

							     . ' ORDER BY rank';

							break;

						case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

						 case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

					}

					

				$query	= $this->db->query($sql);

				$sub_record=array();

				$rec['title_graph'] ='';

				$rec['desc_graph'] ='';

				$rec['h1_graph'] ='';

				$rec['mean_graph'] ='';

				$rec['kwInURlPercent']		= 0;

				$rec['kwInTitlePercent']	= 0;

				$rec['kwInMetaDescPercent']	= 0;

				$rec['kwInH1Percent']		= 0;

				$rec['mean']			= 0;

				if($query->num_rows() > 0){

					$totalCount	= $query->num_rows();

					foreach($query->result() AS $index=>$row){

						

						

						if($row->keyword_in_url == 1){

							$sub_record[ $row->date_added]['url'][]=$row->id;

							$kwInURlCount++;

						}

						

						if($row->keyword_in_title == 1){

							$sub_record[ $row->date_added]['title'][]=$row->id;

							$kwInTitleCount++;

						}

						

						if($row->keyword_in_meta_desc == 1){

							$sub_record[ $row->date_added]['desc'][]=$row->id;

							$kwInMetaDescCount++;

						}

						

						if($row->keyword_in_h1 == 1){

							$sub_record[ $row->date_added]['h1'][]=$row->id;

							$kwInH1Count++;

						}

						$sub_record[$row->date_added ]['total_rows'][]=$row->id;

					}

					foreach($sub_record as $sub_row=>$sub_data){

						$total_rows=$sub_data['total_rows'];

						if(array_key_exists('url',$sub_data)){

							$kwInURlPercent =count($sub_data['url']);

						}

						if(array_key_exists('title',$sub_data)){

							$kwInTitlePercent =count($sub_data['title']);

						}

						if(array_key_exists('desc',$sub_data)){

							$kwInMetaDescPercent =count($sub_data['desc']);

						}

						if(array_key_exists('h1',$sub_data)){

							$kwInH1Percent =count($sub_data['h1']);

						}

						

						$kwInURlPercent		= round(($kwInURlCount/$totalCount)*100);

						$kwInTitlePercent	= round(($kwInTitleCount/$totalCount)*100);

						$kwInMetaDescPercent	= round(($kwInMetaDescCount/$totalCount)*100);

						$kwInH1Percent		= round(($kwInH1Count/$totalCount)*100);

						$mean			= ($kwInURlPercent+$kwInTitlePercent+$kwInMetaDescPercent+$kwInH1Percent)/4;

						

						if($sub_row == $this->sql_current_date ){

						        $rec['kwInURlPercent']		= $kwInURlPercent;

							$rec['kwInTitlePercent']	= $kwInTitlePercent;

							$rec['kwInMetaDescPercent']	= $kwInMetaDescPercent;

							$rec['kwInH1Percent']		= $kwInH1Percent;

							$rec['mean']			= $mean;

						}

						$rec['title_graph'] .=$kwInTitlePercent.",";

						$rec['desc_graph'] .=$kwInMetaDescPercent.",";

						$rec['h1_graph'] .=$kwInH1Percent.",";

						$rec['mean_graph'] .=$mean.",";

						

					}

					

					$rec['title_graph'] =rtrim($rec['title_graph'],",");

					$rec['desc_graph'] =rtrim($rec['desc_graph'],",");

					$rec['h1_graph'] =rtrim($rec['h1_graph'],",");

					$rec['mean_graph'] =rtrim($rec['mean_graph'],",");

					

				}

		

		return $rec;

	}

	

	public function renderUsersDomainHidingLinks($campaign_list, $campaign_server_engine,$site_type){

		$usr 			= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;$record=FALSE;

		$hidingLinkCount	= 0;

		$hidingLinkPercent	= 0;

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$camp_sql ="";

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$camp_sql= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$camp_sql = $this->key_word_where($campaign_list);

			}

			$WC .=$camp_sql;

		}

		$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

		$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

		$sql	= "SELECT MAX(CONVERT(REPLACE(domain_hiding_links, ',', ''), SIGNED INTEGER)) AS maxHideLink,

				  MIN(CONVERT(REPLACE(domain_hiding_links, ',', ''), SIGNED INTEGER)) AS minHideLink,

				  ROUND(AVG(CONVERT(REPLACE(domain_hiding_links, ',', ''), SIGNED INTEGER))) AS avgHideLink,

				  DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age,

				  CG.date_added

				  FROM " . $this->tblCrawledURLDataGoogle . " AS CG,

				  " . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND  ".$crawl_server." "

				  .$date_WC." "

				  . $WC ;

				  //. " group by CG.date_added ORDER BY rank LIMIT 0, 10";

				  switch($site_type){

					case "top_ten":

						

						$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 10";

						break;

					case "top_three":

						$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 3";

						break;

					case "new_site":

						$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY CG.date_added '

						     . ' ORDER BY rank ';

						break;

					case "aged":

						$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY CG.date_added '

						     . ' ORDER BY rank';

						break;

					case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

				}

				

		$query	= $this->db->query($sql);

		$record['percent']=0;$record['maxHideLink']=0;$record['minHideLink']=0;$record['avgHideLink']=0;

		$record['graph_percent']='';$record['graph_max']="";$record['graph_min']="";$record['graph_avg']="";

		if($query->num_rows() > 0){

			

			foreach($query->result_array() as $index=>$data){

				

				$rec	= $data;

				$sql	= '';

				$sql	= "SELECT CG.* FROM "

					. $this->tblCrawledURLDataGoogle . " AS CG, "

					. $this->tblCampaigns .  " AS TC

					WHERE CG.campaign_id = TC.campaign_id

					AND TC.users_id = '". $user_id ."'

					AND  ".$crawl_server." "

					." AND CG.date_added='".$data['date_added']."'"

					. $WC ;

					//. " ORDER BY rank LIMIT 0, 10";

					switch($site_type){

						case "top_ten":

							

							$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 10";

							break;

						case "top_three":

							$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY CG.date_added '

							     . ' ORDER BY rank ';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY CG.date_added '

							     . ' ORDER BY rank';

							break;

						case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

					}

					

				

				$query1	= $this->db->query($sql);

				

				

				if($query1->num_rows() > 0){

					$hidingLinkCount=0;

					$totalCount	= $query1->num_rows();

					foreach($query1->result() AS $row1){

						if($row1->domain_hiding_links >= 1){

							$hidingLinkCount++;

						}

					}

					

					$hidingLinkPercent		= round(($hidingLinkCount/$totalCount)*100);

					

				}

				

				if($data['date_added']== $this->sql_current_date ){

					$record['maxHideLink'] =$data['maxHideLink'];

					$record['minHideLink'] =$data['minHideLink'];

					$record['avgHideLink'] =$data['avgHideLink'];

					$record['percent']	= $hidingLinkPercent;	

				}

				$record['graph_percent'] .=$hidingLinkPercent.',';

				$record['graph_max']     .=$data['maxHideLink'].",";

				$record['graph_min']	 .=$data['minHideLink'].",";

				$record['graph_avg']	 .=$data['avgHideLink'].",";

				/**/

			}

			

			$record['graph_percent'] =rtrim($record['graph_percent'],",");

			$record['graph_max']     =rtrim($record['graph_max'],",");

			$record['graph_min']	 =rtrim($record['graph_min'],",");

			$record['graph_avg']	 =rtrim($record['graph_avg'],",");

			/**/

		}

		

		

		return $record;

	}

	

	function renderSocialLinks($campaign_list, $campaign_server_engine,$site_type){

		//$this->load->library('sharecount');

		require_once('shareCount.php');

		$usr 			= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;$record=FALSE;

		$hidingLinkCount	= 0;

		$hidingLinkPercent	= 0;

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$camp_sql="";

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$camp_sql = ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$camp_sql = $this->key_word_where($campaign_list);

			}

			$WC .=$camp_sql;

		}

		$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

		$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

		$sql	= "SELECT CG.*

				  FROM " . $this->tblCrawledURLDataGoogle . " AS CG,

				  " . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND  ".$crawl_server." "

				  .$date_WC." "

				  . $WC ;

				  //. " group by CG.date_added ORDER BY rank LIMIT 0, 10";

				  switch($site_type){

					case "top_ten":

						

						$sql .= " ORDER BY rank  LIMIT 0, 10";

						break;

					case "top_three":

						$sql .= " ORDER BY rank  LIMIT 0, 3";

						break;

					case "new_site":

						$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 '

						     . ' ORDER BY rank ';

						break;

					case "aged":

						$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 '

						     . ' ORDER BY rank';

						break;

					case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= '  ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

				}

				

		$query	= $this->db->query($sql);

		

		$rec=array();

		$total_site=$query->num_rows();$rec['fb_like']=array();

		foreach($query->result_array() as $row=>$data){

			$sourceUrl = parse_url($data['url']);

			$url= $sourceUrl['scheme']."://".$sourceUrl['host'];

			$obj=new Sharecount($url);

			$fb_share_link		= 'https://graph.facebook.com/' . $url;

			$fb_share_content	= json_decode(file_get_contents($fb_share_link));						

			

			$rec['tweets'][]=$obj->get_tweets();

			//$rec['fb_like'][]=$obj->get_fb();

			$rec['google_like'][]=$obj->get_plusones();

			print_r($fb_share_content);

			if(count($fb_share_content)>0){

			 $rec['fb_share'][]=$fb_share_content->shares;

			}

			

		}

		$rec['fb_like_avg']=0;

		$rec['t_like_avg']=round(array_sum($rec['tweets'])/count($rec['tweets']));

		//$rec['fb_like_avg']=round(array_sum($rec['fb_like'])/count($rec['fb_like']));

		$rec['go_like_avg']=round(array_sum($rec['google_like'])/count($rec['google_like']));

		$rec['fb_share_avg']=round(array_sum($rec['fb_share'])/count($rec['fb_share']));

		

		$rec['fb_like_per']=0;

		$rec['t_like_per']=round((count($rec['tweets'])/$total_site) * 100);

		//$rec['fb_like_per']=round((count($rec['fb_like'])/$total_site)*100);

		$rec['go_like_per']=round((count($rec['google_like'])/$total_site) *100);

		$rec['fb_share_per']=round((count($rec['fb_share'])/$total_site)*100);

		

		return $rec;

		

	}

	

	

	

	public function renderUsersDomainExternalLinks($campaign_list, $campaign_server_engine,$site_type){

		$usr 			= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;$record=FALSE;

		$externalLinkCount	= 0;

		$externalLinkPercent	= 0;

		$crawl_server="";

		switch($campaign_server_engine){

			case "google" :

				$this->tblCrawledURLDataGoogle="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$this->tblCrawledURLDataGoogle="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$this->tblCrawledURLDataGoogle="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";$camp_sql="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$camp_sql = ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$camp_sql = $this->key_word_where($campaign_list);

			}

			$WC .=$camp_sql;

		}

		

		$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

		$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

		$sql	= "SELECT MAX(CONVERT(REPLACE(domain_external_links, ',', ''), SIGNED INTEGER)) AS maxExtrnLink,

				  MIN(CONVERT(REPLACE(domain_external_links, ',', ''), SIGNED INTEGER)) AS minExtrnLink,

				  ROUND(AVG(CONVERT(REPLACE(domain_external_links, ',', ''), SIGNED INTEGER))) AS avgExtrnLink,

				  DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age,

				  CG.date_added

			   FROM " . $this->tblCrawledURLDataGoogle . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

			   WHERE CG.campaign_id = TC.campaign_id

			     AND TC.users_id = '". $user_id ."'

			     AND  ".$crawl_server." "

			     .$date_WC." "

			     . $WC ;

			     //. " GROUP BY CG.date_added ORDER BY rank LIMIT 0, 10";

			    switch($site_type){

				case "top_ten":

					

					$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 10";

					break;

				case "top_three":

					$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 3";

					break;

				case "new_site":

					$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY CG.date_added '

					     . ' ORDER BY rank ';

					break;

				case "aged":

					$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY CG.date_added '

					     . ' ORDER BY rank';

					break;

					

				case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

			}

		$record['maxExtrnLink']=0;$record['minExtrnLink']=0;$record['avgExtrnLink']=0;$record['percent']= 0;

		$record['graph_max']="";$record['graph_min']="";$record['graph_avg']="";$record['graph_percent']= "";	     

		$query	= $this->db->query($sql);

		if($query->num_rows() > 0){

			

			foreach($query->result_array() as $index=>$data){

				$rec	= $data;

				$sql	= '';

				

				$sql	= "SELECT * FROM "

					. $this->tblCrawledURLDataGoogle . " AS CG, "

					. $this->tblCampaigns .  " AS TC

					WHERE CG.campaign_id = TC.campaign_id

					  AND TC.users_id = '". $user_id ."'

					  AND ".$crawl_server." "

					  ." AND CG.date_added='".$rec['date_added']."'"

					  . $WC ;

					  //. " ORDER BY rank LIMIT 0, 10";

					  switch($site_type){

						case "top_ten":

							

							$sql .= " ORDER BY rank  LIMIT 0, 10";

							break;

						case "top_three":

							$sql .= " ORDER BY rank  LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 '

							     . ' ORDER BY rank ';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 '

							     . ' ORDER BY rank';

							break;

							

				case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= '  ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= '  ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

					}

					

				$query	= $this->db->query($sql);

				if($query->num_rows() > 0){

					$externalLinkCount=0;

					$totalCount	= $query->num_rows();

					foreach($query->result() AS $row){

						if($row->domain_external_links >= 1){

							$externalLinkCount++;

						}

					}

					

					$externalLinkPercent		= round(($externalLinkCount/$totalCount)*100);

				}

				

				if($rec['date_added']==$this->sql_current_date){

					$record['maxExtrnLink']=$rec['maxExtrnLink'];

					$record['minExtrnLink']=$rec['minExtrnLink'];

					$record['avgExtrnLink']=$rec['avgExtrnLink'];

					$record['percent']		= $externalLinkPercent;

				}

				$record['graph_max'] .=$rec['maxExtrnLink'].",";

				$record['graph_min'] .=$rec['minExtrnLink'].",";

				$record['graph_avg'] .=$rec['avgExtrnLink'].",";

				$record['graph_percent'].= $externalLinkPercent.",";	     

			

			}

			

			$record['graph_max']=rtrim($record['graph_max'],",");

			$record['graph_min']=rtrim($record['graph_min'],",");

			$record['graph_avg']=rtrim($record['graph_avg'],",");

			$record['graph_percent']=rtrim($record['graph_percent'],",");

		}

		

		

		return $record;

	}

	

	public function renderUsersDomainExactKWAnchor($campaign_list, $campaign_server_engine,$site_type){

		$usr 			= $this->session->userdata('current_user');

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;$record=FALSE;

		$exactMatchCount	= 0;

		$exactMatchPercent	= 0;

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		$camp_sql="";

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$camp_sql = ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$camp_sql= $this->key_word_where($campaign_list);

				

			}

			$WC .=$camp_sql;

		}

		

		$record['max_graph'] ="";$record['min_graph'] ="";$record['avg_graph'] ="";$record['percent_graph'] ="";

		$record['maxExactMatch']=0;

		$record['minExactMatch']=0;

		$record['avgExactMatch']=0;

		$record['percent']= 0;

		$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

		$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$this->graph_data_limit." days", strtotime($this->sql_current_date))).'"';

		$sql	= "SELECT MAX(CONVERT(REPLACE(exact_match_anchors, ',', ''), SIGNED INTEGER)) AS maxExactMatch,

		                  MIN(CONVERT(REPLACE(exact_match_anchors, ',', ''), SIGNED INTEGER)) AS minExactMatch,

				  ROUND(AVG(CONVERT(REPLACE(exact_match_anchors, ',', ''), SIGNED INTEGER))) AS avgExactMatch,

				  DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age,

				  CG.date_added

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				    AND TC.users_id = '". $user_id ."'

				    AND  ".$crawl_server." "

				    .$date_WC." "

				    . $WC ;

				    //. " group by CG.date_added ORDER BY rank LIMIT 0, 10";

				    switch($site_type){

						case "top_ten":

							

							$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 10";

							break;

						case "top_three":

							$sql .= " group by CG.date_added ORDER BY rank  LIMIT 0, 3";

							break;

						case "new_site":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 GROUP BY CG.date_added '

							     . '  ORDER BY rank ';

							break;

						case "aged":

							$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365 GROUP BY CG.date_added '

							     . ' group by CG.date_added ORDER BY rank';

							break;

						case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND CG.id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND CG.id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					     break;

						 

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

					}

					 

		$query	= $this->db->query($sql);

		if($query->num_rows() > 0){

			

			foreach($query->result_array() as $row=>$data){

				

				$rec	= $data;

				$sql	= '';

				$sql	= "SELECT * FROM " . $crawl_table . " AS CG, "

							   . $this->tblCampaigns .  " AS TC

						    WHERE CG.campaign_id = TC.campaign_id

						      AND TC.users_id = '". $user_id ."'

						      AND  ".$crawl_server." "

						      ." AND CG.date_added='".$data['date_added']."'"

						      . $WC ;

						      //. " ORDER BY rank LIMIT 0, 10";

						      

						       switch($site_type){

								case "top_ten":

									

									$sql .= " ORDER BY rank  LIMIT 0, 10";

									break;

								case "top_three":

									$sql .= "ORDER BY rank  LIMIT 0, 3";

									break;

								case "new_site":

									$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 '

									     . '  ORDER BY rank ';

									break;

								case "aged":

									$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365'

									     . '  ORDER BY rank';

									break;

								case "recovery":

									$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

								    if($campaign_list=="Show All Combined"){

								    	$sql .= " AND id IN(".implode($recover_data['total_rows'], "," ).")";

								    }else{

								    	$sql .= " AND id IN(".implode($recover_data[$campaign_list], "," ).")";

								    }

									$sql .= ' GROUP BY CG.date_added ORDER BY rank';

									$sql= str_replace($camp_sql, "", $sql);

					             break;

								

					     case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' GROUP BY CG.date_added ORDER BY rank';

							$sql= str_replace($camp_sql, "", $sql);

							

						break;

							}

				$query1	= $this->db->query($sql);

				if($query1->num_rows() > 0){

					$totalCount	= $query1->num_rows();

					foreach($query1->result() AS $row){

						if($row->exact_match_anchors >= 1){

							$exactMatchCount++;

						}

					}

					

					$exactMatchPercent		= round(($exactMatchCount/$totalCount)*100);

				}

				

				if($data['date_added']==$this->sql_current_date){

					$record['maxExactMatch']=$data['maxExactMatch'];

					$record['minExactMatch']=$data['minExactMatch'];

					$record['avgExactMatch']=$data['avgExactMatch'];

					$record['percent']= $exactMatchPercent;

				}

				$record['max_graph'] .=$data['maxExactMatch'].",";

				$record['min_graph'] .=$data['minExactMatch'].",";

				$record['avg_graph'] .=$data['avgExactMatch'].",";

				$record['percent_graph'] .=$exactMatchPercent.",";

				

			}

			$record['max_graph'] =rtrim($record['max_graph'],",");

			$record['min_graph'] =rtrim($record['min_graph'],",");

			$record['avg_graph'] =rtrim($record['avg_graph'],",");

			$record['percent_graph'] =rtrim($record['percent_graph'],",");

			

		}

		

		return $record;

	}

	

	public function renderUsersPageOneRank(){

		$percent	= 0;

		$sql = "SELECT * FROM " . $this->tblCrawledURLDataGoogle . " where rank >= 1 AND rank <= 10 AND date_added BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";

		$query	= $this->db->query($sql);

		$top10_num	= $query->num_rows();

		

		$sql= '';

		$sql = "SELECT * FROM " . $this->tblCrawledURLDataGoogle . " where date_added BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";

		$query	= $this->db->query($sql);

		$total_num	= $query->num_rows();

		

		if($top10_num > 0 && $total_num > 0){

			$percent	= round(($top10_num/$total_num)*100);

		}

		$rec['percent']	= $percent;

		return $rec;

	}

	

	public function renderUsersLongTermPageOneRank(){

		$usr 			= $this->session->userdata('current_user');

		$rec			= FALSE;

		

		switch($campaign_server_engine){

			case "google" :

				$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

				if(!empty($campaign_list)){

					$WC	.= ' AND CG.campaign_id = "' . $campaign_list . '"';

				}

				break;

			case "yahoo" :

				break;

			case "" :

				break;

		}

	}

	

	function rendersiteStat($campaign_list, $campaign_server_engine){

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$exactMatchCount	= 0;

		$exactMatchPercent	= 0;

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

	     $rec["new"]=array();$rec["recovery"]=array();$rec["old"]=array();

	     $WC		= ' AND CG.date_added = "'.$this->sql_current_date.'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$WC	.= $this->key_word_where($campaign_list);

			}

		}

		

		$sql	= "SELECT CG.url, CG.id, CG.rank ,CG.domain_creation_date, DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND ".$crawl_server." " . $WC . "  ORDER BY rank ";

		//echo $sql;

		

				$query	= $this->db->query($sql);

				$new_site=array();$old_site=array();

				$rec['new']['top_three']=0;

					$rec['new']['top_ten']=0;

					$rec['new']['top_three_graph']="";

					$rec['new']['top_ten_graph']="";

					

					$rec['old']['top_three']=0;

					$rec['old']['top_ten']=0;

					$rec['old']['top_three_graph']="";

					$rec['old']['top_ten_graph']="";

					

					$rec['recovery']['top_three']=0;

					$rec['recovery']['top_ten']=0;

					$rec['recovery']['top_three_graph']="";

					$rec['recovery']['top_ten_graph']="";

				if($query->num_rows()>0){

					

					$rec['total_site']=$query->num_rows();

					$new_top_three_graph="";$new_top_ten_graph="";

					$new_site['top_three']=array();$new_site['top_ten']=array();

					

					$old_top_three_graph="";$old_top_ten_graph="";

					$old_site['top_three']=array();$old_site['top_ten']=array();

					

					$rec_top_three_graph="";$rec_top_ten_graph="";

					$recvory_site['top_three']=array(); $recvory_site['top_ten']=array();

					

					foreach($query->result_array() as $row=>$data){

						/*$create_date=strtotime(date($data['domain_creation_date']));

						$current_date=strtotime(date('Y-m-d'));

						$day_diff=round(($current_date - $create_date )/ 864000) ;

						*/

						$day_diff=$data['age'];

						if($day_diff>=0 and $day_diff<=365){  // new

							if($data['rank']<=3){

								$new_site['top_three'][]=$data['id'];

								$new_top_three_graph .=$day_diff.",";

							}

							if($data['rank']<=10){

								$new_site['top_ten'][]=$data['id'];

								$new_top_ten_graph .=$day_diff.",";

							}

						}

						else if($day_diff>365){  // old

							if($data['rank']<=3){

								$old_site['top_three'][]=$data['id'];

								$old_top_three_graph .=$day_diff.",";

							}

							if($data['rank']<=10){

								$old_site['top_ten'][]=$data['id'];

								$old_top_ten_graph .=$day_diff.",";

							}

						}

						

						

						$sub_sql="SELECT rank,date_added from ".$crawl_table." where url='".$data['url']."' order by date_added limit 0,3";

						

						$sub_query=$this->db->query($sub_sql);

						

						if($sub_query->num_rows() == 3){

							$rank_record=$sub_query->result_array();

							$current_rank=$rank_record[2]['rank'];

							$pre_rank=$rank_record[1]['rank'];

							$pre_pre_rank=$rank_record[0]['rank'];

							if($pre_pre_rank <= 10 and $pre_rank > 10 and $current_rank <= 10)

							{

								if($current_rank <= 3){

									$recvory_site['top_three'][]=$data['id'];

									$rec_top_three_graph .=$current_rank.",";

								}

								$recvory_site['top_ten'][]=$data['id'];

								$rec_top_ten_graph .=$current_rank .",";

							}

						}

						

					}

					

					$rec['new']['top_three']=round((count($new_site['top_three'])/$rec['total_site'])*100);

					$rec['new']['top_ten']=round((count($new_site['top_ten'])/$rec['total_site'])*100);

					$rec['new']['top_three_graph']=rtrim($new_top_three_graph,",");

					$rec['new']['top_ten_graph']=rtrim($new_top_ten_graph,",");

					

					$rec['old']['top_three']=round((count($old_site['top_three'])/$rec['total_site'])*100);

					$rec['old']['top_ten']=round((count($old_site['top_ten'])/$rec['total_site'])*100);

					$rec['old']['top_three_graph']=rtrim($old_top_three_graph,",");

					$rec['old']['top_ten_graph']=rtrim($old_top_ten_graph,",");

					

					$rec['recovery']['top_three']=round((count($recvory_site['top_three'])/$rec['total_site'])*100);

					$rec['recovery']['top_ten']=round((count($recvory_site['top_ten'])/$rec['total_site'])*100);

					$rec['recovery']['top_three_graph']=rtrim($rec_top_three_graph,",");

					$rec['recovery']['top_ten_graph']=rtrim($rec_top_ten_graph,",");

				}

				//print_r($rec);

				//die;

				return $rec;

				

		

	}

	

	function renderonpageelement($campaign_list, $campaign_server_engine){

		$user_id=$this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$exactMatchCount	= 0;

		$exactMatchPercent	= 0;

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

	     $rec["new"]=array();$rec["long"]=array();$rec["old"]=array();

	     //$WC		= ' AND CG.date_added IN("'.date("Y-m-d").'","'.date("Y-m-d",strtotime("-1 days", strtotime(date('Y-m-d')))).'")';

	     

	     $date_WC=' AND CG.date_added IN("'.$this->sql_current_date.'","'.date("Y-m-d",strtotime("-1 days", strtotime($this->sql_current_date))).'")';

	     $WC		= $date_WC;

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$WC	.= $this->key_word_where($campaign_list);

			}

		}

		

		$sql	= "SELECT CG.*, DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) AS age

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND ".$crawl_server." " . $WC . "  ORDER BY rank limit 0,10";

		

				$query	= $this->db->query($sql);

				$new_site=array();$old_site=array();$long_site=array();

				if($query->num_rows()>0){

					

					$rec['total_site']=$query->num_rows();

					/*

					$new_site['top']=array();$new_site['top_url_title']=array();$new_site['top_desc']=array();

					$new_site['top_h1']=array();$new_site['top_h2']=array();$new_site['words']=array();

					

					$old_site['top']=array();$old_site['top_url_title']=array();$old_site['top_desc']=array();

					$old_site['top_h1']=array();$old_site['top_h2']=array();$old_site['words']=array();	

					*/

					foreach($query->result_array() as $row=>$data){

						//$create_date=strtotime($data['domain_creation_date']);

						//$current_date=strtotime($data['date_added']);

						//$day_diff=round(($current_date - $create_date )/ 864000) ;

						$day_diff =$data['age'];

						

						if($day_diff>=0 and $day_diff<=365){   // new

							

							$new_site[$data['date_added']]['top'][]=$data['id'];

							if($data['keyword_in_url']==1 ){

								$new_site[$data['date_added']]['top_url'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_title']==1){

								$new_site[$data['date_added']]['top_title'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_meta_desc']==1){

								$new_site[$data['date_added']]['top_desc'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_h1']==1){

								$new_site[$data['date_added']]['top_h1'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_h2']==1){

								$new_site[$data['date_added']]['top_h2'][$data["id"]]=$data["id"];

							}

							$new_site[$data['date_added']]['words'][$data["id"]]=$data['domain_word_count'];

							$new_site[$data['date_added']]['image'][$data["id"]]=$data['domain_image'];

							$new_site[$data['date_added']]['keyword_ratio'][$data["id"]]=$data['domain_kw_ratio'];

							

							if($data['domain_external_links'] >=1){

								$new_site[$data['date_added']]['external_link_percent'][$data["id"]]=$data['domain_external_links'];	

							}

							$new_site[$data['date_added']]['external_link'][$data["id"]]=$data['domain_external_links'];	

							

							

						}

						else if($day_diff>365){ // old

							 

							$old_site[$data['date_added']]['top'][]=$data['id'];

							if($data['keyword_in_url']==1 ){

								$old_site[$data['date_added']]['top_url'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_title']==1){

								$old_site[$data['date_added']]['top_title'][$data["id"]]=$data["id"];

							}

							

							if($data['keyword_in_meta_desc']==1){

								$old_site[$data['date_added']]['top_desc'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_h1']==1){

								$old_site[$data['date_added']]['top_h1'][$data["id"]]=$data["id"];

							}

							if($data['keyword_in_h2']==1){

								$old_site[$data['date_added']]['top_h2'][$data["id"]]=$data["id"];

							}

							$old_site[$data['date_added']]['words'][$data["id"]]=$data['domain_word_count'];

							$old_site[$data['date_added']]['image'][$data["id"]]=$data['domain_image'];

							$old_site[$data['date_added']]['keyword_ratio'][$data["id"]]=$data['domain_kw_ratio'];

							

							if($data['domain_external_links'] >=1){

								$old_site[$data['date_added']]['external_link_percent'][$data["id"]]=$data['domain_external_links'];	

							}

							$old_site[$data['date_added']]['external_link'][$data["id"]]=$data['domain_external_links'];	

						}

						

						// long term 

						$WC=str_replace($WC,$date_WC,"");

						$sql	= "SELECT CG.*

								FROM " . $crawl_table . " AS CG, "

								. $this->tblCampaigns .  " AS TC

								WHERE CG.campaign_id = TC.campaign_id

								  AND TC.users_id = '". $user_id ."'

								  AND  ".$crawl_server." "

								  ." AND CG.url='".$data['url']."' AND CG.rank <= 10 "

								  . $WC . "  order by CG.date_added desc";

							

						      $query1=$this->db->query($sql);

						      $no_of_rank_day= $query1->num_rows();

						      $count=0;

						      foreach($query1->result_array() as $index=>$sub_data){

							      if($sub_data['date_added'] == date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))  )

							      {

								$count++;      

							      }

							      

						      }

						     

						      

						      	if($count >= $this->long_term_limit){

								

									$long_site[$data['date_added']]['top'][]=$data['id'];

									if($data['keyword_in_url']==1 ){

										$long_site[$data['date_added']]['top_url'][$data["id"]]=$data["id"];

									}

									if($data['keyword_in_title']==1){

										$long_site[$data['date_added']]['top_title'][$data["id"]]=$data["id"];

									}

									

									if($data['keyword_in_meta_desc']==1){

										$long_site[$data['date_added']]['top_desc'][$data["id"]]=$data["id"];

									}

									if($data['keyword_in_h1']==1){

										$long_site[$data['date_added']]['top_h1'][$data["id"]]=$data["id"];

									}

									if($data['keyword_in_h2']==1){

										$long_site[$data['date_added']]['top_h2'][$data["id"]]=$data["id"];

									}

									$long_site[$data['date_added']]['words'][$data["id"]]=$data['domain_word_count'];

									$long_site[$data['date_added']]['image'][$data["id"]]=$data['domain_image'];

									$long_site[$data['date_added']]['keyword_ratio'][$data["id"]]=$data['domain_kw_ratio'];

									

									if($data['domain_external_links'] >=1){

										$long_site[$data['date_added']]['external_link_percent'][$data["id"]]=$data['domain_external_links'];	

									}

									$long_site[$data['date_added']]['external_link'][$data["id"]]=$data['domain_external_links'];	

							}

							

						

						/**/

					}

				}

				

				//$avg = array_sum($values) / count($value);

				///****** new site ******//

				$key="";$rec['new']=array();

				foreach($new_site as $d=>$data){

					$total_site=count($data['top']);

					$first_index=array_keys($old_site);

					if($d == $first_index[0]){

						$key="current";

					}else{

						$key="past";

					}

					if(array_key_exists('top_url',$data)){

						if(count($data['top_url'])>=3){

							$rec['new'][$key]['top_three']['url']=100;

						}else{

							$rec['new'][$key]['top_three']['url']=round(( count( $data['top_url'] ) / 3 )* 100);	

						}

						$rec['new'][$key]['top_ten']['url']=round(( count( $data['top_url'] ) / $total_site )* 100);

					}else{

						$rec['new'][$key]['top_three']['url']=0;

						$rec['new'][$key]['top_ten']['url']=0;

					}

					

					if(array_key_exists('top_title',$data)){

						if(count($data['top_title'])>=3){

							$rec['new'][$key]['top_three']['title']=100;

						}else{

							$rec['new'][$key]['top_three']['title']=round(( count( $data['top_title'] ) / 3 )* 100);	

						}

						$rec['new'][$key]['top_ten']['title']=round(( count( $data['top_title'] ) / $total_site )* 100);

					}else{

						$rec['new'][$key]['top_three']['title']=0;

						$rec['new'][$key]['top_ten']['title']=0;

					}

					

					if(array_key_exists('top_desc',$data)){

						if(count($data['top_desc'])>=3){

							$rec['new'][$key]['top_three']['dec']=100;

						}else{

							$rec['new'][$key]['top_three']['dec']=round(( count( $data['top_desc'] ) / 3 )* 100);	

						}

						$rec['new'][$key]['top_ten']['dec']=round(( count( $data['top_desc'] ) / $total_site )* 100);

					}else{

						$rec['new'][$key]['top_three']['dec']=0;

						$rec['new'][$key]['top_ten']['dec']=0;

					}

					

					if(array_key_exists('top_h1',$data)){

						if(count($data['top_h1'])>=3){

							$rec['new'][$key]['top_three']['h1']=100;

						}else{

							$rec['new'][$key]['top_three']['h1']=round(( count( $data['top_h1'] ) / 3 )* 100);	

						}

						$rec['new'][$key]['top_ten']['h1']=round(( count( $data['top_h1'] ) / $total_site )* 100);

					}else{

						$rec['new'][$key]['top_three']['h1']=0;

						$rec['new'][$key]['top_ten']['h1']=0;

					}

					

					if(array_key_exists('top_h2',$data)){

						if(count($data['top_h2'])>=3){

							$rec['new'][$key]['top_three']['h2']=100;

						}else{

							$rec['new'][$key]['top_three']['h2']=round(( count( $data['top_h2'] ) / 3 )* 100);	

						}

						$rec['new'][$key]['top_ten']['h2']=round(( count( $data['top_h2'] ) / $total_site )* 100);

					}else{

						$rec['new'][$key]['top_three']['h2']=0;

						$rec['new'][$key]['top_ten']['h2']=0;

					}

					

					$rec['new'][$key]['top_three']['adove_fold']=0;

					$rec['new'][$key]['top_ten']['adove_fold']=0;

					$rec['new'][$key]['top_three']['img']=0;

					$rec['new'][$key]['top_ten']['img']=0;

					

					$rec['new'][$key]['top_three']['word']=0;

					$rec['new'][$key]['top_ten']['word']=0;

					$rec['new'][$key]['top_three']['min_word']=0;

					$rec['new'][$key]['top_ten']['min_word']=0;

					$rec['new'][$key]['top_three']['max_word']=0;

					$rec['new'][$key]['top_ten']['max_word']=0;

					

					if(array_key_exists('words',$data)){

						$top_three_word_arr=array();$count=0;

						foreach($data['words'] as $w_index=>$w_data){

							if($count==2){break;}

							$top_three_word_arr[]=$w_data;

							$count++;

						}

						$rec['new'][$key]['top_three']['word']= round(array_sum($top_three_word_arr)/3) ;

						$rec['new'][$key]['top_ten']['word']=round(array_sum($data['words'])/count($data['words']));

						

						$rec['new'][$key]['top_three']['min_word']=min($top_three_word_arr);

						$rec['new'][$key]['top_ten']['min_word']=min($data['words']);

						

						$rec['new'][$key]['top_three']['max_word']=max($top_three_word_arr);

						$rec['new'][$key]['top_ten']['max_word']=max($data['words']);

					}

					

					$rec['new'][$key]['top_three']['image']=0;

					$rec['new'][$key]['top_ten']['image']=0;

					

					if(array_key_exists('image',$data)){

						$top_three_image_arr=array();$count=0;

						foreach($data['image'] as $i_index=>$i_data){

							if($count==2){break;}

							$top_three_image_arr[]=$i_data;

							$count++;

						}

						$rec['new'][$key]['top_three']['image']= round(array_sum($top_three_image_arr)/3) ;

						$rec['new'][$key]['top_ten']['image']=round(array_sum($data['image'])/count($data['image']));

					}

					

					

					$rec['new'][$key]['top_three']['kw']=0;

					$rec['new'][$key]['top_ten']['kw']=0;

					

					$rec['new'][$key]['top_three']['min_kw']=0;

					$rec['new'][$key]['top_ten']['min_kw']=0;

					

					$rec['new'][$key]['top_three']['max_kw']=0;

					$rec['new'][$key]['top_ten']['max_kw']=0;

					if(array_key_exists('keyword_ratio',$data)){

						$top_three_kw_arr=array();$count=0;

						foreach($data['keyword_ratio'] as $kw_index=>$kw_data){

							if($count==2){break;}

							$top_three_kw_arr[]=$kw_data;

							$count++;

						}

						

						$rec['new'][$key]['top_three']['kw']= round(array_sum($top_three_kw_arr)/3) ;

						$rec['new'][$key]['top_ten']['kw']=round(array_sum($data['keyword_ratio'])/count($data['keyword_ratio']));

						

						$rec['new'][$key]['top_three']['min_kw']=min($top_three_kw_arr);

						$rec['new'][$key]['top_ten']['min_kw']=min($data['keyword_ratio']);

						

						$rec['new'][$key]['top_three']['max_kw']=max($top_three_kw_arr);

						$rec['new'][$key]['top_ten']['max_kw']=max($data['keyword_ratio']);

					}

					

					

					$rec['new'][$key]['top_three']['el_percent']=0;

					$rec['new'][$key]['top_three']['el_avg']=0;

					

					$rec['new'][$key]['top_ten']['el_percent']=0;

					$rec['new'][$key]['top_ten']['el_avg']=0;

					if(array_key_exists('external_link_percent',$data)){

						$top_three_e_link_per_arr=array();$count=0;

						

						foreach($data['external_link_percent'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_per_arr[]=$el_data;

							$count++;

						}

						

						$top_three_e_link_arr=array();$count=0;

						foreach($data['external_link'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_arr[]=$el_data;

							$count++;

						}

						

						$rec['new'][$key]['top_three']['el_percent']=round( (count($top_three_e_link_per_arr)/count($top_three_e_link_arr)) *100);

						$rec['new'][$key]['top_three']['el_avg']=round((array_sum($top_three_e_link_arr)/3));

						

						$rec['new'][$key]['top_ten']['el_percent']=round( (count($data['external_link_percent'])/count($data['external_link'])) *100);

						$rec['new'][$key]['top_ten']['el_avg']=round((array_sum($data['external_link'])/count($data['external_link'])));

					}

					

					$rec['new'][$key]['total_site']=$total_site;

					

					

				}

				///****** new site END ***//

				

				///****** old site ******//

				$key="";$rec['old']=array();

				foreach($old_site as $d=>$data){

					$total_site=count($data['top']);

					$first_index=array_keys($old_site);

					if($d == $first_index[0]){

						$key="current";

					}else{

						$key="past";

					}

					if(array_key_exists('top_url',$data)){

						if(count($data['top_url'])>=3){

							$rec['old'][$key]['top_three']['url']=100;

						}else{

							$rec['old'][$key]['top_three']['url']=round(( count( $data['top_url'] ) / 3 )* 100);	

						}

						$rec['old'][$key]['top_ten']['url']=round(( count( $data['top_url'] ) / $total_site )* 100);

					}else{

						$rec['old'][$key]['top_three']['url']=0;

						$rec['old'][$key]['top_ten']['url']=0;

					}

					

					if(array_key_exists('top_title',$data)){

						if(count($data['top_title'])>=3){

							$rec['old'][$key]['top_three']['title']=100;

						}else{

							$rec['old'][$key]['top_three']['title']=round(( count( $data['top_title'] ) / 3 )* 100);	

						}

						$rec['old'][$key]['top_ten']['title']=round(( count( $data['top_title'] ) / $total_site )* 100);

					}else{

						$rec['old'][$key]['top_three']['title']=0;

						$rec['old'][$key]['top_ten']['title']=0;

					}

					

					if(array_key_exists('top_desc',$data)){

						if(count($data['top_desc'])>=3){

							$rec['old'][$key]['top_three']['dec']=100;

						}else{

							$rec['old'][$key]['top_three']['dec']=round(( count( $data['top_desc'] ) / 3 )* 100);	

						}

						$rec['old'][$key]['top_ten']['dec']=round(( count( $data['top_desc'] ) / $total_site )* 100);

					}else{

						$rec['old'][$key]['top_three']['dec']=0;

						$rec['old'][$key]['top_ten']['dec']=0;

					}

					

					if(array_key_exists('top_h1',$data)){

						if(count($data['top_h1'])>=3){

							$rec['old'][$key]['top_three']['h1']=100;

						}else{

							$rec['old'][$key]['top_three']['h1']=round(( count( $data['top_h1'] ) / 3 )* 100);	

						}

						$rec['old'][$key]['top_ten']['h1']=round(( count( $data['top_h1'] ) / $total_site )* 100);

					}else{

						$rec['old'][$key]['top_three']['h1']=0;

						$rec['old'][$key]['top_ten']['h1']=0;

					}

					

					if(array_key_exists('top_h2',$data)){

						if(count($data['top_h2'])>=3){

							$rec['old'][$key]['top_three']['h2']=100;

						}else{

							$rec['old'][$key]['top_three']['h2']=round(( count( $data['top_h2'] ) / 3 )* 100);	

						}

						$rec['old'][$key]['top_ten']['h2']=round(( count( $data['top_h2'] ) / $total_site )* 100);

					}else{

						$rec['old'][$key]['top_three']['h2']=0;

						$rec['old'][$key]['top_ten']['h2']=0;

					}

					

					$rec['old'][$key]['top_three']['adove_fold']=0;

					$rec['old'][$key]['top_ten']['adove_fold']=0;

					$rec['old'][$key]['top_three']['img']=0;

					$rec['old'][$key]['top_ten']['img']=0;

					

					

					$rec['old'][$key]['top_three']['word']=0;

					$rec['old'][$key]['top_ten']['word']=0;

					$rec['old'][$key]['top_three']['min_word']=0;

					$rec['old'][$key]['top_ten']['min_word']=0;

					$rec['old'][$key]['top_three']['max_word']=0;

					$rec['old'][$key]['top_ten']['max_word']=0;

					

					if(array_key_exists('words',$data)){

						$top_three_word_arr=array();$count=0;

						foreach($data['words'] as $w_index=>$w_data){

							if($count==2){break;}

							$top_three_word_arr[]=$w_data;

							$count++;

						}

						

						$rec['old'][$key]['top_three']['word']= round(array_sum($top_three_word_arr)/3) ;

						$rec['old'][$key]['top_ten']['word']=round(array_sum($data['words'])/count($data['words']));

						

						$rec['old'][$key]['top_three']['min_word']=min($top_three_word_arr);

						$rec['old'][$key]['top_ten']['min_word']=min($data['words']);

						

						$rec['old'][$key]['top_three']['max_word']=max($top_three_word_arr);

						$rec['old'][$key]['top_ten']['max_word']=max($data['words']);

					}

					

					$rec['old'][$key]['top_three']['image']=0;

					$rec['old'][$key]['top_ten']['image']=0;

					

					if(array_key_exists('image',$data)){

						$top_three_image_arr=array();$count=0;

						foreach($data['image'] as $i_index=>$i_data){

							if($count==2){break;}

							$top_three_image_arr[]=$i_data;

							$count++;

						}

						$rec['old'][$key]['top_three']['image']= round(array_sum($top_three_image_arr)/3) ;

						$rec['old'][$key]['top_ten']['image']=round(array_sum($data['image'])/count($data['image']));

					}

					

					

					$rec['old'][$key]['top_three']['kw']=0;

					$rec['old'][$key]['top_ten']['kw']=0;

					

					$rec['old'][$key]['top_three']['min_kw']=0;

					$rec['old'][$key]['top_ten']['min_kw']=0;

					

					

					if(array_key_exists('keyword_ratio',$data)){

						$top_three_kw_arr=array();$count=0;

						foreach($data['keyword_ratio'] as $kw_index=>$kw_data){

							if($count==2){break;}

							$top_three_kw_arr[]=$kw_data;

							$count++;

						}

						

						$rec['old'][$key]['top_three']['kw']= round(array_sum($top_three_kw_arr)/3) ;

						$rec['old'][$key]['top_ten']['kw']=round(array_sum($data['keyword_ratio'])/count($data['keyword_ratio']));

						

						$rec['old'][$key]['top_three']['min_kw']=min($top_three_kw_arr);

						$rec['old'][$key]['top_ten']['min_kw']=min($data['keyword_ratio']);

						

						$rec['old'][$key]['top_three']['max_kw']=max($top_three_kw_arr);

						$rec['old'][$key]['top_ten']['max_kw']=max($data['keyword_ratio']);

						

					}

					

					

					$rec['old'][$key]['top_three']['el_percent']=0;

					$rec['old'][$key]['top_three']['el_avg']=0;

					

					$rec['old'][$key]['top_ten']['el_percent']=0;

					$rec['old'][$key]['top_ten']['el_avg']=0;

					

					if(array_key_exists('external_link_percent',$data)){

						$top_three_e_link_per_arr=array();$count=0;

						

						foreach($data['external_link_percent'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_per_arr[]=$el_data;

							$count++;

						}

						

						$top_three_e_link_arr=array();$count=0;

						foreach($data['external_link'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_arr[]=$el_data;

							$count++;

						}

						

						$rec['old'][$key]['top_three']['el_percent']=round( (count($top_three_e_link_per_arr)/count($top_three_e_link_arr)) *100);

						$rec['old'][$key]['top_three']['el_avg']=round((array_sum($top_three_e_link_arr)/3));

						

						$rec['old'][$key]['top_ten']['el_percent']=round( (count($data['external_link_percent'])/count($data['external_link'])) *100);

						$rec['old'][$key]['top_ten']['el_avg']=round((array_sum($data['external_link'])/count($data['external_link'])));

					}

					

					$rec['old'][$key]['total_site']=$total_site;

					

					

				}

				///****** old site END ******//

				///****** long term  site ******//

				

				$key="";$rec['long']=array();

				foreach($long_site as $d=>$data){

					$total_site=count($data['top']);

					$first_index=array_keys($old_site);

					if($d == $first_index[0]){

						$key="current";

					}else{

						$key="past";

					}

					if(array_key_exists('top_url',$data)){

						if(count($data['top_url'])>=3){

							$rec['long'][$key]['top_three']['url']=100;

						}else{

							$rec['long'][$key]['top_three']['url']=round(( count( $data['top_url'] ) / 3 )* 100);	

						}

						$rec['long'][$key]['top_ten']['url']=round(( count( $data['top_url'] ) / $total_site )* 100);

					}else{

						$rec['long'][$key]['top_three']['url']=0;

						$rec['long'][$key]['top_ten']['url']=0;

					}

					

					if(array_key_exists('top_title',$data)){

						if(count($data['top_title'])>=3){

							$rec['long'][$key]['top_three']['title']=100;

						}else{

							$rec['long'][$key]['top_three']['title']=round(( count( $data['top_title'] ) / 3 )* 100);	

						}

						$rec['long'][$key]['top_ten']['title']=round(( count( $data['top_title'] ) / $total_site )* 100);

					}else{

						$rec['long'][$key]['top_three']['title']=0;

						$rec['long'][$key]['top_ten']['title']=0;

					}

					

					if(array_key_exists('top_desc',$data)){

						if(count($data['top_desc'])>=3){

							$rec['long'][$key]['top_three']['dec']=100;

						}else{

							$rec['long'][$key]['top_three']['dec']=round(( count( $data['top_desc'] ) / 3 )* 100);	

						}

						$rec['long'][$key]['top_ten']['dec']=round(( count( $data['top_desc'] ) / $total_site )* 100);

					}else{

						$rec['long'][$key]['top_three']['dec']=0;

						$rec['long'][$key]['top_ten']['dec']=0;

					}

					

					if(array_key_exists('top_h1',$data)){

						if(count($data['top_h1'])>=3){

							$rec['long'][$key]['top_three']['h1']=100;

						}else{

							$rec['long'][$key]['top_three']['h1']=round(( count( $data['top_h1'] ) / 3 )* 100);	

						}

						$rec['long'][$key]['top_ten']['h1']=round(( count( $data['top_h1'] ) / $total_site )* 100);

					}else{

						$rec['long'][$key]['top_three']['h1']=0;

						$rec['long'][$key]['top_ten']['h1']=0;

					}

					

					if(array_key_exists('top_h2',$data)){

						if(count($data['top_h2'])>=3){

							$rec['long'][$key]['top_three']['h2']=100;

						}else{

							$rec['long'][$key]['top_three']['h2']=round(( count( $data['top_h2'] ) / 3 )* 100);	

						}

						$rec['long'][$key]['top_ten']['h2']=round(( count( $data['top_h2'] ) / $total_site )* 100);

					}else{

						$rec['long'][$key]['top_three']['h2']=0;

						$rec['long'][$key]['top_ten']['h2']=0;

					}

					

					$rec['long'][$key]['top_three']['adove_fold']=0;

					$rec['long'][$key]['top_ten']['adove_fold']=0;

					$rec['long'][$key]['top_three']['img']=0;

					$rec['long'][$key]['top_ten']['img']=0;

					

					

					$rec['long'][$key]['top_three']['word']=0;

					$rec['long'][$key]['top_ten']['word']=0;

					$rec['long'][$key]['top_three']['min_word']=0;

					$rec['long'][$key]['top_ten']['min_word']=0;

					$rec['long'][$key]['top_three']['max_word']=0;

					$rec['long'][$key]['top_ten']['max_word']=0;

					

					if(array_key_exists('words',$data)){

						$top_three_word_arr=array();$count=0;

						foreach($data['words'] as $w_index=>$w_data){

							if($count==2){break;}

							$top_three_word_arr[]=$w_data;

							$count++;

						}

						

						$rec['long'][$key]['top_three']['word']= round(array_sum($top_three_word_arr)/3) ;

						$rec['long'][$key]['top_ten']['word']=round(array_sum($data['words'])/count($data['words']));

						

						$rec['long'][$key]['top_three']['min_word']=min($top_three_word_arr);

						$rec['long'][$key]['top_ten']['min_word']=min($data['words']);

						

						$rec['long'][$key]['top_three']['max_word']=max($top_three_word_arr);

						$rec['long'][$key]['top_ten']['max_word']=max($data['words']);

					}

					

					$rec['long'][$key]['top_three']['image']=0;

					$rec['long'][$key]['top_ten']['image']=0;

					

					if(array_key_exists('image',$data)){

						$top_three_image_arr=array();$count=0;

						foreach($data['image'] as $i_index=>$i_data){

							if($count==2){break;}

							$top_three_image_arr[]=$i_data;

							$count++;

						}

						$rec['long'][$key]['top_three']['image']= round(array_sum($top_three_image_arr)/3) ;

						$rec['long'][$key]['top_ten']['image']=round(array_sum($data['image'])/count($data['image']));

					}

					

					

					$rec['long'][$key]['top_three']['kw']=0;

					$rec['long'][$key]['top_ten']['kw']=0;

					

					$rec['long'][$key]['top_three']['min_kw']=0;

					$rec['long'][$key]['top_ten']['min_kw']=0;

					

					$rec['long'][$key]['top_three']['max_kw']=0;

					$rec['long'][$key]['top_ten']['max_kw']=0;

					

					if(array_key_exists('keyword_ratio',$data)){

						$top_three_kw_arr=array();$count=0;

						foreach($data['keyword_ratio'] as $kw_index=>$kw_data){

							if($count==2){break;}

							$top_three_kw_arr[]=$kw_data;

							$count++;

						}

						

						$rec['long'][$key]['top_three']['kw']= round(array_sum($top_three_kw_arr)/3) ;

						$rec['long'][$key]['top_ten']['kw']=round(array_sum($data['keyword_ratio'])/count($data['keyword_ratio']));

						

						$rec['long'][$key]['top_three']['min_kw']=min($top_three_kw_arr);

						$rec['long'][$key]['top_ten']['min_kw']=min($data['keyword_ratio']);

						

						$rec['long'][$key]['top_three']['max_kw']=max($top_three_kw_arr);

						$rec['long'][$key]['top_ten']['max_kw']=max($data['keyword_ratio']);

						

					}

					

					

					$rec['long'][$key]['top_three']['el_percent']=0;

					$rec['long'][$key]['top_three']['el_avg']=0;

					

					$rec['long'][$key]['top_ten']['el_percent']=0;

					$rec['long'][$key]['top_ten']['el_avg']=0;

					

					if(array_key_exists('external_link_percent',$data)){

						$top_three_e_link_per_arr=array();$count=0;

						

						foreach($data['external_link_percent'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_per_arr[]=$el_data;

							$count++;

						}

						

						$top_three_e_link_arr=array();$count=0;

						foreach($data['external_link'] as $el_index=>$el_data){

							if($count==2){break;}

							$top_three_e_link_arr[]=$el_data;

							$count++;

						}

						

						$rec['long'][$key]['top_three']['el_percent']=round( (count($top_three_e_link_per_arr)/count($top_three_e_link_arr)) *100);

						$rec['long'][$key]['top_three']['el_avg']=round((array_sum($top_three_e_link_arr)/3));

						

						$rec['long'][$key]['top_ten']['el_percent']=round( (count($data['external_link_percent'])/count($data['external_link'])) *100);

						$rec['long'][$key]['top_ten']['el_avg']=round((array_sum($data['external_link'])/count($data['external_link'])));

					}

					

					$rec['long'][$key]['total_site']=$total_site;

					

					

				}

				///****** recovery  site END  ******//

				/*echo "<pre>";

				print_r($rec);

				print_r($rec);

				print_r($new_site);

				print_r($old_site);

				echo "</pre>";

				die;

				*/

				

				return $rec;

	}



	public function renderUsersLinkElement($campaign_list, $campaign_server_engine,$type){

		$usr 			= $this->session->userdata('current_user');

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		$countRedirect		= 0;

		$countNoRedirect	= 0;

		$countNoFollow		= 0;

		$countDoFollow		= 0;

		$countSiteWide		= 0;

		$countNotSideWide	= 0;

		$countText		= 0;

		$countImage		= 0;

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.keyword IN (' . $c_list . ')';	

			}else{

				$WC	.= ' AND CG.keyword = "' . $campaign_list . '"';	

			}

		}

		

		$condition = "";

		if($type == 'top10')

		{

			$condition = " ORDER BY rank limit 0,10 ";

			

		}

		if($type == 'top3')

		{

			$condition = " ORDER BY rank limit 0,3 ";

		}

		if($type == 'newsite')

		{

			$today = date('Y-m-d');

			$srchDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . " - 366 days"));

			$condition = " AND domain_creation_date > '".$srchDate."'";

		}

		

		if($type == 'aged1yr')

		{

			$today = date('Y-m-d');

			$srchDate = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . " - 365 days"));

			$condition = " AND domain_creation_date < '".$srchDate."'";

		}

		if($type == 'longterm')

		{

			$condition = " ORDER BY rank limit 0,10 ";

			

		}

		if($type == 'parasite')

		{

			$condition = " ORDER BY rank ";

			

		}

		

		$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND ".$crawl_server." " . $WC .$condition ;

		echo $sql;die();

		$query	= $this->db->query($sql);

		

		if($type == 'parasite')

		{

			$res = $query->result_array();

			

			if(is_array($res) && count($res)>0)

			{

				foreach($res as $data){

					$sub_sql="SELECT * from ".$crawl_table." where url='".$data['url']."' order by date_added limit 0,3";

					//die();

					$sub_query=$this->db->query($sub_sql);

					

					if($sub_query->num_rows() == 3){

						$rank_record=$sub_query->result_array();

						$current_rank=$rank_record[2]['rank'];

						$pre_rank=$rank_record[1]['rank'];

						$pre_pre_rank=$rank_record[0]['rank'];

						if($pre_pre_rank <= 10 and $pre_rank > 10 and $current_rank <= 10)

						{

							

							$sub_data = $rank_record[0]; 

							if($sub_data['domain_redirect'] > 0){

								$countRedirect++;

							}else{

								$countNoRedirect++;

							}

							

							if($sub_data['domain_nofollow'] > 0){

								$countNoFollow++;

							}

							if($sub_data['domain_dofollow'] > 0){

								$countDoFollow++;

							}

							

							if($sub_data['domain_sitewide'] > 0){

								$countSiteWide++;

							}

							if($sub_data['domain_notsitewide'] > 0){

								$countNotSideWide++;

							}

							

							if($sub_data['domain_text'] > 0){

								$countText++;

							}

							if($sub_data['domain_image'] > 0){

								$countImage++;

							}

							

						}

					}

				}

			}

		}		

		elseif($type == 'longterm' )

		{

			

			

			$total_rows=$query->num_rows();$long_term_site=array();

			foreach($query->result_array() as $row=>$data){

			

			$WC=str_replace($WC,' AND CG.date_added = "'.$this->sql_current_date.'"',"");

			$sql="";$day_limit=60;

			

			$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				    AND TC.users_id = '". $user_id ."'

				    AND  ".$crawl_server." "

				    ." AND CG.url='".$data['url']."' AND CG.rank <= 10 "

				    . $WC . " group by CG.date_added order by CG.date_added desc";

				   

			$query1=$this->db->query($sql);

			$no_of_rank_day= $query1->num_rows();

			$count=0;

			foreach($query1->result_array() as $index=>$sub_data){

				if($sub_data['date_added'] == date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))  )

				{

					//$long_term_site[ $sub_data['url'] ][] = $sub_data['date_added']."==>".date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))."==>".$sub_data['rank'];

					

					

					if($sub_data['domain_redirect'] > 0){

						$countRedirect++;

					}else{

						$countNoRedirect++;

					}

					

					if($sub_data['domain_nofollow'] > 0){

						$countNoFollow++;

					}

					if($sub_data['domain_dofollow'] > 0){

						$countDoFollow++;

					}

					

					if($sub_data['domain_sitewide'] > 0){

						$countSiteWide++;

					}

					if($sub_data['domain_notsitewide'] > 0){

						$countNotSideWide++;

					}

					

					if($sub_data['domain_text'] > 0){

						$countText++;

					}

					if($sub_data['domain_image'] > 0){

						$countImage++;

					}

					

					

					

					

					

				}

				//$count++;

			}

			



			}



		}

		else

		{

			if($query->num_rows() > 0){

			$rec = $query->result_array();

			if(is_array($rec) && count($rec) > 0){

				for($i=0; $i<count($rec); $i++){

					if($rec[$i]['domain_redirect'] > 0){

						$countRedirect++;

					}else{

						$countNoRedirect++;

					}

					

					if($rec[$i]['domain_nofollow'] > 0){

						$countNoFollow++;

					}

					if($rec[$i]['domain_dofollow'] > 0){

						$countDoFollow++;

					}

					

					if($rec[$i]['domain_sitewide'] > 0){

						$countSiteWide++;

					}

					if($rec[$i]['domain_notsitewide'] > 0){

						$countNotSideWide++;

					}

					

					if($rec[$i]['domain_text'] > 0){

						$countText++;

					}

					if($rec[$i]['domain_image'] > 0){

						$countImage++;

					}

				}

			}

			}	

			

		}

		

		

		

		/*$countRedirect		= 2;

		$countNoRedirect	= 3;

		$countNoFollow		= 4;

		$countDoFollow		= 5;

		$countSiteWide		= 6;

		$countNotSideWide	= 7;

		$countText		= 8;

		$countImage		= 9;*/

		

		// Redirect/Notredirect

		$sumRedirect =    $countRedirect+$countNoRedirect;

		

		if($sumRedirect > 0){

			$percentRedirect = ($countRedirect/$sumRedirect)*100;

			$percentNotRedirect = ($countNoRedirect/$sumRedirect)*100;

		}else{

			$percentRedirect = 0;

			$percentNotRedirect = 0;

		}

		$redirectDegree = (180*$percentRedirect)/100;

		$notredirectDegree = (180*$percentNotRedirect)/100;

		

		// Follow/Nofollow

		$sumFollow =    $countNoFollow+$countDoFollow;

		

		if($sumFollow > 0){

			$percentFollow = ($countNoFollow/$sumFollow)*100;

			$percentNoFollow = ($countDoFollow/$sumFollow)*100;

		}else{

			$percentFollow = 0;

			$percentNoFollow = 0;

		}

		

		$followDegree = (180*$percentFollow)/100;

		$notfollowDegree = (180*$percentNoFollow)/100;

		

		// Site Wide

		$sumSiteWide =    $countSiteWide+$countNotSideWide;

		

		if($sumSiteWide > 0){

			$percentSiteWide = ($countSiteWide/$sumSiteWide)*100;

			$percentNotSiteWide = ($countSiteWide/$sumSiteWide)*100;

		}else{

			$percentSiteWide = 0;

			$percentNotSiteWide = 0;

		}

		

		$sitewideDegree = (180*$percentSiteWide)/100;

		$nositewideDegree = (180*$percentNotSiteWide)/100;

		

		// Text/Image

		$sumTextImage =    $countText+$countImage;

		

		if($sumTextImage > 0){

			$percentText = ($countText/$sumTextImage)*100;

			$percentImage = ($countImage/$sumTextImage)*100;

		}else{

			$percentText = 0;

			$percentImage = 0;

		}

		

		$sitewideDegree = (180*$percentSiteWide)/100;

		$nositewideDegree = (180*$percentNotSiteWide)/100;

		

		$return['Redirect']	= $redirectDegree;

		$return['NotRedirect']	= $notredirectDegree;

		$return['NoFollow']	= $followDegree;

		$return['DoFollow']	= $notfollowDegree;

		$return['SiteWide']	= $sitewideDegree;

		$return['NotSideWide']	= $nositewideDegree;

		$return['Text']		= $percentText;

		$return['Image']	= $percentImage;

		

		return $return;

		exit;

	}

	

	public function renderanalysiscomparison($campaign_list, $campaign_server_engine,$keyword){

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		if(!empty($campaign_list) && $campaign_list != 'Show All Combined'){

			$sql = "SELECT * FROM " . $this->tblCampaigns . " WHERE campaign_main_keyword = '".$campaign_list."' AND users_id = '".$user_id."'";

		}else{

			$sql = "SELECT * FROM " . $this->tblCampaigns . " WHERE users_id = '".$user_id."' limit 1";

		}

		//echo $sql;

		//die();

		$rs = $this->db->query($sql);

		$resl = $rs->result_array();

		//pr($resl);

		$campaign_murl_thumb = $resl[0]['campaign_murl_thumb'];

		$keyword = $resl[0]['campaign_main_keyword'];

		$keyword = stripslashes(trim($keyword));

		$murl = $resl[0]['campaign_main_page_url'];

		

		$API_URL = "http://images.shrinktheweb.com/xino.php?stwu=c1871&stwxmax=320&stwymax=240&stwaccesskeyid=37c50d761e16b0b&stwurl=".$murl;            

        

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $API_URL);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$output = curl_exec($ch);

		curl_close($ch);

		$oDOM = new DOMDocument;

		$oDOM->loadXML($output);

		$sXML = simplexml_import_dom($oDOM);

		$sXMLLayout = 'http://www.shrinktheweb.com/doc/stwresponse.xsd';

		

		// Pull response codes from XML feed

		$aThumbnail = (array)$sXML->children($sXMLLayout)->Response->ThumbnailResult->Thumbnail;

		$thumb = $aThumbnail[0];

		

		$parse_url = parse_url($murl);

			

		if(isset($parse_url['host']) && !empty($parse_url['host'])){

			$host = $parse_url['host'];

		}else{

			$host = '';

		}

		if(!empty($host)){

			$hoisApiurl = 'http://whois.my-addr.com/api_parsed_json/2AC307DEF0FCEC41D30BF33683CD862B/' . $host;

			$json = file_get_contents($hoisApiurl);

			$resultsiteage = json_decode($json,TRUE);

			$creation_date = $resultsiteage['body']['domain']['created'];

			$datetime1 = date_create($creation_date);

			$datetime2 = date_create(date('Y-m-d'));

			$diff=$datetime2->diff($datetime1);			

			$interval = $diff->y . ' years ' . $diff->m . ' months ' . $diff->d . ' days';

			

			$pageCountURL = 'http://www.google.com/search?q=site:'.$host;

			// get the result content		

			$html 	= file_get_html($pageCountURL);

			$pageCount = 0;

			foreach($html->find('div#resultStats') AS $htmlresult){				

				$pos1 = strpos($htmlresult->plaintext, 'About');

				$pos2 = strpos($htmlresult->plaintext, 'results');			

				$pageCount	= substr($htmlresult->plaintext, 6, $pos2-7);

			}

		}else{

			$interval = '0 years';

			$pageCount = 0;

		}

		$content = '';

		$wordCount = 0;

		$keyword_ratio = 0;

		

		$html		= file_get_html($murl);

		foreach($html->find('body') AS $htmlresult){

			$content	= $htmlresult->plaintext;

		}

		if(!empty($content)){			

			$wordCount 		= str_word_count($content, 0);			

			$keywordcount		= substr_count(strtolower($content), strtolower($keyword));			

			$keyword_ratio		= round(($keywordcount/$wordCount)*100);

		}

		

		

		if(isset($parse_url['path']) && strlen($parse_url['path'])<=1){

			$result['home_page'] = 'Yes';

		}else{

			$result['home_page'] = 'No';

		}

		$keywordScoreTitle = 0;

		$keywordScoreDesc = 0;

		$keywordScoreH1 = 0;

		// if keyword found in title

		foreach($html->find('title') AS $htmlresult){

			$content	= $htmlresult->plaintext;

			if(strpos(strtolower($content),strtolower($keyword))>-1){

			    $keywordScoreTitle = 1;

			    break;

			}

		}

		

		// if keyword found in Meta description

		foreach($html->find('mata[name="description"]') AS $htmlresult){

			$content	= $htmlresult->plaintext;

			if(strpos(strtolower($content),strtolower($keyword))>-1){

			    $keywordScoreDesc = 1;

			    break;

			}

		}

		

		// if keyword found in H1

		foreach($html->find('h1') AS $htmlresult){

			$content	= $htmlresult->plaintext;

			if(strpos(strtolower($content),strtolower($keyword))>-1){

			    $keywordScoreH1 = 1;

			    break;

			}

		}

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		

		$cond = '';

		$cond = " CG.campaign_id = TC.campaign_id  AND TC.users_id = '". $user_id ."' AND ".$crawl_server." " . $WC ." AND ";

		

		$sql3	= "SELECT CG.*

			  FROM " . $crawl_table . " AS CG, "

			  . $this->tblCampaigns .  " AS TC

			  WHERE ".$cond." keyword like '%".$keyword."%' GROUP BY id  ORDER BY date_added,rank asc LIMIT 10 ";

		$home_page10 = 0;

		$query3 = $this->db->query($sql3);

		if($query3->num_rows()>0)

		{

		

			$res = $query3->result_array();

			

			

			foreach($res as $rec3){

			$url3 = parse_url($rec3['url']);

				if(strlen($url3['path'])<=1)

				{

					$home_page10++;

				}

			}

		}

		

		$sql4	= "SELECT CG.*

			  FROM " . $crawl_table . " AS CG, "

			  . $this->tblCampaigns .  " AS TC

			  WHERE ".$cond." keyword like '%".$keyword."%' GROUP BY id  ORDER BY date_added,rank asc LIMIT 20 ";

		$query4 = $this->db->query($sql4);

		

		$home_page20 = 0;

		if($query4->num_rows()>0)

		{

			$res2 = $query4->result_array();

			foreach($res2 as $rec4){

			$url4 = parse_url($rec4['url']);

				if(strlen($url4['path'])<=1)

				{

					$home_page20++;

				}

			}

		}

		

		$result['home_page10'] = $home_page10/10*100;

		$result['home_page20'] = $home_page20/20*100;

		

		//if(!empty($campaign_list)){

		//	if($campaign_list=="Show All Combined"){

		//		$this->db->where("users_id",$user_id);

		//		$cam_query=$this->db->get($this->tblUsersCampaignMaster);

		//		$c_list="";

		//		foreach($cam_query->result_array() as $c_index=>$c_data){

		//			$c_list .=$c_data["campaign_id"].",";

		//		}

		//		$c_list=rtrim($c_list,",");

		//		$WC	.= ' AND CG.keyword IN (' . $c_list . ')';	

		//	}else{

		//		$WC	.= ' AND CG.keyword = "' . $campaign_list . '"';	

		//	}

		//}

		//$cond = '';

		//$cond = " CG.campaign_id = TC.campaign_id  AND TC.users_id = '". $user_id ."' AND ".$crawl_server." " . $WC ." AND ";

		//$sql	= "SELECT CG.*

		//		  FROM " . $crawl_table . " AS CG, "

		//		  . $this->tblCampaigns .  " AS TC

		//		  WHERE ".$cond." keyword like '%".$keyword."%' ORDER BY domain_creation_date desc LIMIT 1";

		////echo $sql;

		//$query	= $this->db->query($sql);

		//$result = array();

		//if($query->num_rows() > 0){

		//	$rec = $query->result_array();

		//	$result['url'] = stripslashes($rec[0]['url']);

		//	$result['current_rank'] = $rec[0]['rank'];

		//	

		//	$datetime1 = date_create($rec[0]['domain_creation_date']);

		//	$datetime2 = date_create(date('Y-m-d'));

		//	$interval = date_diff($datetime1, $datetime2);

		//	

		//	if($interval->format('%y') != 0){$years =  $interval->format('%y Years');} else{$years = '';}

		//	if($interval->format('%m') != 0){$months =  $interval->format(' %m Months');} else{$months = '';}

		//	if($interval->format('%d') != 0){$days =  $interval->format(' %d Days');} else{$days = '';}

		//	$result['site_age'] = $years.$months.$days;

		//	

		//	

		//	if($rec[0]['keyword_in_title']==0){$keyword_title = 'No';}else{	$keyword_title = 'Yes';	}

		//	if($rec[0]['keyword_in_h1']==0){$keyword_h1 = 'No';}else{$keyword_h1 = 'Yes';}

		//	if($rec[0]['keyword_in_meta_desc']==0){$keyword_desc = 'No';}else{$keyword_desc = 'Yes';}

		//	if($rec[0]['domain_kw_ratio']==''){$keyword_ratio = '0';}else{$keyword_ratio = $rec[0]['domain_kw_ratio'];}

		//	

		//	$result['domain_kw_ratio'] = $keyword_ratio;

		//	$result['keyword_in_title'] = $keyword_title;

		//	$result['keyword_in_meta_desc'] = $keyword_desc;

		//	$result['keyword_in_h1'] = $keyword_h1;

		//	$result['domain_page_count'] = $rec[0]['domain_page_count'];

		//	$result['domain_word_count'] = $rec[0]['domain_word_count'];

		//	

		//	$sql2	= "SELECT CG.*

		//		  FROM " . $crawl_table . " AS CG, "

		//		  . $this->tblCampaigns .  " AS TC

		//		  WHERE ".$cond." url = '".$rec[0]['url']."' GROUP BY id  ORDER BY date_added desc ";

		//	$query2 = $this->db->query($sql2);

		//	if($query2->num_rows()>0)

		//	{

		//		$rec2 = $query2->result_array();

		//		$result['yesterday_rank'] = 0;

		//		if($query2->num_rows()>1)

		//		{

		//			$result['yesterday_rank'] = $rec2[1]['rank'];			

		//		}

		//		$result['starting_rank'] = $rec2[$query2->num_rows()-1]['rank'];

		//		$position = $result['current_rank']-$result['yesterday_rank'];

		//		if($position>0){ $position = "+".$position; }

		//		$result['position_change'] = $position;			

		//		

		//	}

		//	

		//	$url = parse_url($result['url']);

		//	if(strlen($url['path'])<=1)

		//	{

		//		$result['home_page'] = 'Yes';

		//	}

		//	else

		//	{

		//		$result['home_page'] = 'No';

		//	}

		//	

		//	

		//	$sql3	= "SELECT CG.*

		//		  FROM " . $crawl_table . " AS CG, "

		//		  . $this->tblCampaigns .  " AS TC

		//		  WHERE ".$cond." keyword like '%".$keyword."%' GROUP BY id  ORDER BY date_added,rank asc LIMIT 10 ";

		//	$home_page10 = 0;

		//	$query3 = $this->db->query($sql3);

		//	if($query3->num_rows()>0)

		//	{

		//	

		//		$res = $query3->result_array();

		//		

		//		

		//		foreach($res as $rec3){

		//		$url3 = parse_url($rec3['url']);

		//			if(strlen($url3['path'])<=1)

		//			{

		//				$home_page10++;

		//			}

		//		}

		//	}

		//	

		//	$sql4	= "SELECT CG.*

		//		  FROM " . $crawl_table . " AS CG, "

		//		  . $this->tblCampaigns .  " AS TC

		//		  WHERE ".$cond." keyword like '%".$keyword."%' GROUP BY id  ORDER BY date_added,rank asc LIMIT 20 ";

		//	$query4 = $this->db->query($sql4);

		//	

		//	$home_page20 = 0;

		//	if($query4->num_rows()>0)

		//	{

		//		$res2 = $query4->result_array();

		//		foreach($res2 as $rec4){

		//		$url4 = parse_url($rec4['url']);

		//			if(strlen($url4['path'])<=1)

		//			{

		//				$home_page20++;

		//			}

		//		}

		//	}

		//	

		//	$result['home_page10'] = $home_page10/10*100;

		//	$result['home_page20'] = $home_page20/20*100;

		//	

		//}

		$result['url'] = $murl;

		$result['keyword'] = $keyword;

		$result['campaign_murl_thumb'] = $thumb;

		$result['site_age'] = $interval;

		$result['page_size'] = $pageCount;

		$result['site_page'] = $wordCount;

		$result['kw_ratio'] = $keyword_ratio;

		$result['kw_title'] = $keywordScoreTitle;

		$result['kw_desc'] = $keywordScoreDesc;

		$result['kw_h1'] = $keywordScoreH1;

		return $result;	

		

	}

	

	public function renderserpmeter($campaign_list,$campaign_server_engine,$currDate)

	{

		$user_id	= $this->session->userdata("LOGIN_USER");

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.keyword IN (' . $c_list . ')';	

			}else{

				$WC	.= ' AND CG.keyword = "' . $campaign_list . '"';	

			}

		}

		

		$condition = "";

		$condition = " LIMIT 0,10 ";

		

		$sql	= "SELECT CG.rank,CG.url

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND ".$crawl_server." " . $WC ." AND CG.date_added = '".$currDate."' ORDER BY rank ASC LIMIT 0,10" ;

		

		$query	= $this->db->query($sql);

		

		$res = $query->result_array();

		return $res;

	}

	

/*	public function renderUsersLinkElement($campaign_list, $campaign_server_engine){

		$usr 			= $this->session->userdata('current_user');

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		$countRedirect		= 0;

		$countNoRedirect	= 0;

		$countNoFollow		= 0;

		$countDoFollow		= 0;

		$countSiteWide		= 0;

		$countNotSideWide	= 0;

		$countText		= 0;

		$countImage		= 0;

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.date("Y-m-d").'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$WC	.= $this->key_word_where($campaign_list);

			}

		}

		

		$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				  AND TC.users_id = '". $user_id ."'

				  AND ".$crawl_server." " . $WC . "  ORDER BY rank limit 0,10";

		

		$query	= $this->db->query($sql);

		if($query->num_rows() > 0){

			$rec = $query->result_array();

			if(is_array($rec) && count($rec) > 0){

				for($i=0; $i<count($rec); $i++){

					if($rec[$i]['domain_redirect'] > 0){

						$countRedirect++;

					}else{

						$countNoRedirect++;

					}

					

					if($rec[$i]['domain_nofollow'] > 0){

						$countNoFollow++;

					}

					if($rec[$i]['domain_dofollow'] > 0){

						$countDoFollow++;

					}

					

					if($rec[$i]['domain_sitewide'] > 0){

						$countSiteWide++;

					}

					if($rec[$i]['domain_notsitewide'] > 0){

						$countNotSideWide++;

					}

					

					if($rec[$i]['domain_text'] > 0){

						$countText++;

					}

					if($rec[$i]['domain_image'] > 0){

						$countImage++;

					}

				}

			}

		}

		$countRedirect		= 2;

		$countNoRedirect	= 3;

		$countNoFollow		= 4;

		$countDoFollow		= 5;

		$countSiteWide		= 6;

		$countNotSideWide	= 7;

		$countText		= 8;

		$countImage		= 9;

		$return['Redirect']	= $countRedirect;

		$return['NotRedirect']	= $countNoRedirect;

		$return['NoFollow']	= $countNoFollow;

		$return['DoFollow']	= $countDoFollow;

		$return['SiteWide']	= $countSiteWide;

		$return['NotSideWide']	= $countNotSideWide;

		$return['Text']		= $countText;

		$return['Image']	= $countImage;

		

		return $return;

		exit;

	}

*/	

	

	function renderlongtermsite($campaign_list, $campaign_server_engine){

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		

		$WC		= ' AND CG.date_added = "'.$this->sql_current_date.'"';

		if(!empty($campaign_list)){

			if($campaign_list=="Show All Combined"){

				$this->db->where("users_id",$user_id);

				$cam_query=$this->db->get($this->tblUsersCampaignMaster);

				$c_list="";

				foreach($cam_query->result_array() as $c_index=>$c_data){

					$c_list .=$c_data["campaign_id"].",";

				}

				$c_list=rtrim($c_list,",");

				$WC	.= ' AND CG.campaign_id IN (' . $c_list . ')';	

			}else{

				$WC	.= $this->key_word_where($campaign_list);

			}

		}

		$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				    AND TC.users_id = '". $user_id ."'

				    AND  ".$crawl_server." "

				    . $WC . "  ORDER BY rank LIMIT 0, 10";

		//echo $sql;

		//die;

		$query	= $this->db->query($sql);

		$total_rows=$query->num_rows();$long_term_site=array();

		foreach($query->result_array() as $row=>$data){

			

			$WC=str_replace($WC,' AND CG.date_added = "'.$this->sql_current_date.'"',"");

			$sql="";$day_limit=60;

			//$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

			//$date_WC .=' AND CG.date_added >= "'.date("Y-m-d", strtotime( "-".$day_limit." days", strtotime($this->sql_current_date))).'"';

			$sql	= "SELECT CG.*

				  FROM " . $crawl_table . " AS CG, "

				  . $this->tblCampaigns .  " AS TC

				  WHERE CG.campaign_id = TC.campaign_id

				    AND TC.users_id = '". $user_id ."'

				    AND  ".$crawl_server." "

				    ." AND CG.url='".$data['url']."' AND CG.rank <= 10 "

				    . $WC . " group by CG.date_added order by CG.date_added desc";

				   

			$query1=$this->db->query($sql);

			$no_of_rank_day= $query1->num_rows();

			$count=0;

			foreach($query1->result_array() as $index=>$sub_data){

				if($sub_data['date_added'] == date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))  )

				{

					$long_term_site[ $sub_data['url'] ][] = $sub_data['date_added']."==>".date("Y-m-d",strtotime("-".$count." days", strtotime(date('Y-m-d'))))."==>".$sub_data['rank'];

				}

				$count++;

			}

			

		}

		

		$record['percent_data']=0;$record["graph_data"]="";

		foreach($long_term_site as $row=>$data){

			

			if(count($data) >= $this->long_term_limit){

				$record['percent_data']++;

				$record["graph_data"] .=count($data). ",";

			}

		}

		$record['percent_data']=0;

		$record["graph_data"]="";

		if($total_rows>0){

			$record['percent_data']=($record['percent_data']/$total_rows)*100;

			$record["graph_data"]=rtrim($record["graph_data"],",");

		}

		

		return $record;

		

	}

	

	

	function rendersitefressness($campaign_list, $campaign_server_engine,$site_type){

		

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		$WC		= ' AND CG.date_added = "'.$this->sql_current_date.'"';

		

		

		                                 

						 

		$sql	= "SELECT CG.*

			 FROM " . $crawl_table . " AS CG, "

			 . $this->tblCampaigns .  " AS TC

			 WHERE CG.campaign_id = TC.campaign_id

			   AND TC.users_id = '". $user_id ."'

			   AND  ".$crawl_server." "

			   . $WC." ";

			   //. " ORDER BY rank LIMIT 0, 10";

			switch($site_type){

				case "top_ten":

					

					$sql .= " ORDER BY rank  LIMIT 0, 10";

					break;

				case "top_three":

					$sql .= "ORDER BY rank  LIMIT 0, 3";

					break;

				case "new_site":

					$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) <= 365 '

					     . '  ORDER BY rank ';

					break;

				case "aged":

					$sql .=' AND DATEDIFF( NOW(), FROM_UNIXTIME(CG.domain_creation_date) ) > 365'

					     . '  ORDER BY rank';

					break;

				case "recovery":

								$recover_data=$this->get_recovery_site($campaign_list, $campaign_server_engine);

							    if($campaign_list=="Show All Combined"){

							    	$sql .= " AND id IN(".implode($recover_data['total_rows'], "," ).")";

							    }else{

							    	$sql .= " AND id IN(".implode($recover_data[$campaign_list], "," ).")";

							    }

								$sql .= ' ORDER BY rank';

								$sql= str_replace(' AND CG.date_added = "'.$this->sql_current_date.'"', "", $sql);

				     break;

					 case "long_term":

							$long_data=$this->get_long_term_site($campaign_list, $campaign_server_engine);

						    if($campaign_list=="Show All Combined"){

						    	$sql .= " AND CG.id IN(".implode($long_data['total_rows'], "," ).")";

						    }else{

						    	$sql .= " AND CG.id IN(".implode($long_data[$campaign_list], "," ).")";

						    }

							$sql .= ' ORDER BY rank';

//							$sql= str_replace($camp_sql, "", $sql);

							

						break;

			}

			

		$query=$this->db->query($sql);

		$avg_week_arr=array();

		$avg_month_arr=array();$graph_week_arr=array();$graph_month_arr=array();$graph_never="";

		$rec['week']=0;$rec['month']=0;

		$rec['never']=0;

		$rec['score']=0;

		$rec['week_graph']='';$rec['graph_month']='';$rec['never_graph']='';$rec['score_graph']='';

		foreach($query->result_array() as $row=>$data){

			

			$WC=str_replace($WC,' AND CG.date_added = "'.date("Y-m-d").'"',"");

		

			$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

			$date_WC .='AND CG.date_added >= "'.date("Y-m-d", strtotime("-7 days", strtotime($this->sql_current_date))).'"';

			$sql	= "SELECT ROUND(AVG(CONVERT(REPLACE(domain_page_count, ',', ''), SIGNED INTEGER))) AS avgWord 

			 FROM " . $crawl_table . " AS CG, "

			 . $this->tblCampaigns .  " AS TC

			 WHERE CG.campaign_id = TC.campaign_id

			   AND TC.users_id = '". $user_id ."'

			   AND  ".$crawl_server." "

			   . $WC." "

			   ." AND CG.id='".$data['id']."'"

			   .$date_WC." ";

			   

			   $query=$this->db->query($sql);

			   $r=$query->row_array();

			   $avg_week_arr[$data['id']]=$r['avgWord'];

			   

			   

			$date_WC ='AND CG.date_added <= "'.$this->sql_current_date.'"';

			$date_WC .='AND CG.date_added >= "'.date("Y-m-d", strtotime("-30 days", strtotime($this->sql_current_date))).'"';

			$sql	= "SELECT ROUND(AVG(CONVERT(REPLACE(domain_page_count, ',', ''), SIGNED INTEGER))) AS avgWord 

			 FROM " . $crawl_table . " AS CG, "

			 . $this->tblCampaigns .  " AS TC

			 WHERE CG.campaign_id = TC.campaign_id

			   AND TC.users_id = '". $user_id ."'

			   AND  ".$crawl_server." "

			   . $WC." "

			   ." AND CG.id='".$data['id']."'"

			   .$date_WC." ";

			   

			   $query=$this->db->query($sql);

			   $r=$query->row_array();

			   $avg_month_arr[$data['id']]=$r['avgWord'];

			   

			   

			   

			   

			   for($i=0; $i< $this->graph_data_limit; $i++){

				if($i==0){

					$from_week=0;

					$to_week=$i+1;

					$from_month=0;

					$to_month=$i+1;

				}else{

					$from_week =$from_week+7;

					$to_week=$to_week+1;

					$from_month=$from_month+1;

					$to_month=$to_month+1;

				}

					$date_WC ='AND CG.date_added <= "'.date("Y-m-d", strtotime("-".$from_week." days", strtotime($this->sql_current_date))).'"';

					$date_WC .='AND CG.date_added >= "'.date("Y-m-d", strtotime("-".$to_week." week", strtotime($this->sql_current_date))).'"';

					$sql	= "SELECT ROUND(AVG(CONVERT(REPLACE(domain_page_count, ',', ''), SIGNED INTEGER))) AS avgWord 

					 FROM " . $crawl_table . " AS CG, "

					 . $this->tblCampaigns .  " AS TC

					 WHERE CG.campaign_id = TC.campaign_id

					   AND TC.users_id = '". $user_id ."'

					   AND  ".$crawl_server." "

					   . $WC." "

					   ." AND CG.id='".$data['id']."'"

					   .$date_WC." ";

					  

					   $query=$this->db->query($sql);

					   $r=$query->row_array();

					   $graph_week_arr[$data['id']][] =$r['avgWord'];

					  // echo "week: ".$sql."\n";

					   

					$date_WC ='AND CG.date_added <= "'.date("Y-m-d", strtotime("-".$from_month." month", strtotime($this->sql_current_date))).'"';

					$date_WC .='AND CG.date_added >= "'.date("Y-m-d", strtotime("-".$to_month." month", strtotime($this->sql_current_date))).'"';

					$sql	= "SELECT ROUND(AVG(CONVERT(REPLACE(domain_page_count, ',', ''), SIGNED INTEGER))) AS avgWord 

					 FROM " . $crawl_table . " AS CG, "

					 . $this->tblCampaigns .  " AS TC

					 WHERE CG.campaign_id = TC.campaign_id

					   AND TC.users_id = '". $user_id ."'

					   AND  ".$crawl_server." "

					   . $WC." "

					   ." AND CG.id='".$data['id']."'"

					   .$date_WC." ";

					   

					   $query=$this->db->query($sql);

					   $r=$query->row_array();

					   $graph_month_arr[$data['id']][] =$r['avgWord'];

					  // echo "month: ".$sql."\n";

			   }

			   

		}

		//print_r($avg_month_arr);

		//print_r($avg_week_arr);

		//echo "graph_month:". $graph_month."\n graph_week:".$graph_week;

		//die;

		

		if(count($avg_week_arr) >0){

			$rec['week']=round(array_sum($avg_week_arr)/count($avg_week_arr));

		}

		

		if(count($avg_week_arr) >0){

			$rec['month']=round(array_sum($avg_month_arr)/count($avg_month_arr));

		}

		$never_change=array();

		foreach($avg_month_arr as $row=>$data){

			if($data == $avg_week_arr[$row] ){

				$never_change[$row]=$row;

			}

		}

		

		if(count($never_change)>0){

		 $rec['never']=((count($never_change)/10)*100);

		}

		$rec['score']=(100-$rec['never']);

		

		

		

		$w_count=0;$m_count=0;

		if(count($graph_week_arr)>0){

		for($i=0; $i< $this->graph_data_limit ; $i++){

			$g_month=array();$g_week=array();

			foreach($graph_week_arr as $row=>$data){

				

				$g_week[]=$data[$w_count];

				

			}

			$f_inddx=array_keys($graph_week_arr);

			if(end(array_keys($graph_week_arr[ $f_inddx[0] ]))==$w_count){

				$w_count=0;

			}else{

				$w_count++;

			}

			

			if(count($g_week)>0 ){

				$rec['week_graph'] .=array_sum($g_week)/count($g_week).",";

			}

			

			

			foreach($graph_month_arr as $row=>$data){

				

				$g_month[]=$data[$m_count];

				

			}

			if(end(array_keys($data))==$m_count){

				$m_count=0;

			}else{

				$m_count++;

			}

			

			if(count($g_month)>0 ){

				$rec['graph_month'] .=array_sum($g_month)/count($g_month).",";

			}

			

			

			$never_change=array();

			foreach($g_month as $row1=>$data1){

				if($data1 == $g_week[$row1] ){

					$never_change[$row1]=$row1;

				}

			}

			$never=0;

			if(count($never_change)>0){

			 $never=((count($never_change)/10)*100);

			 $rec['never_graph'].=$never.",";

			}

			$score=(100-$never);

			$rec['score_graph'] .=$score.',';

			

		}

		}

		

			

		

		return $rec;

	}

	

	

	function renderLinkGraph($campaign_list, $campaign_server_engine){
	//echo $campaign_list;die();

		$user_id		= $this->session->userdata("LOGIN_USER");

		$rec			= FALSE;

		$record			= FALSE;

		

		

		$crawl_server="";$crawl_table="";

		switch($campaign_server_engine){

			case "google" :

				$crawl_table="serp_google_crawl_data";

				$crawl_server="TC.isCrawlByGoogle = 1";

				break;

			case "yahoo" :

				$crawl_table="serp_yahoo_crawl_data";

				$crawl_server="TC.isCrawlByYahoo = 1";

				break;

			case "bing" :

				$crawl_table="serp_bing_crawl_data";

				$crawl_server="TC.isCrawlByBing = 1";

				break;

		}

		$WC="";

		//$WC		= ' AND CG.date_added = "'.$this->sql_current_date.'"';
		$WC		= ' AND CG.date_added = "2014-05-19"';

		
		if($campaign_list !=''){
			$filterby_kw = " AND CG.keyword_id = '".$campaign_list."'";
		}else{
			$filterby_kw = "";
		}
		

		                                 

						 

		$sql	= "SELECT CG.*

			 FROM " . $crawl_table . " AS CG, "

			 . $this->tblCampaigns .  " AS TC

			 WHERE CG.campaign_id = TC.campaign_id

			   AND TC.users_id = '". $user_id ."'

			   AND  ".$crawl_server." "

			   . $WC." "
			   .$filterby_kw

			   . " ORDER BY rank LIMIT 0, 10";

	//echo $sql;die();

		$query=$this->db->query($sql);

		$record['ex_link']="";$record['blanded_link']="";$record['brand_link']="";$record['raw_link']="";

		$ex_link_top_ten=0; $ex_link_top_three=0;$ex_link_recover=0;

		$blanded_link_top_ten=0; $blanded_link_top_three=0;$blanded_link_recover=0;

		$brand_link_top_ten=0; $brand_link_top_three=0;$brand_link_recover=0;

		$raw_link_top_ten=0; $raw_link_top_three=0;$raw_link_recover=0;

		

		foreach($query->result_array() as $row=>$data){

			$record['ex_link'] .=$data['exact_match_anchors'].",";

			$record['blanded_link'] .=$data['blended_match_anchors'].",";

			$record['brand_link'] .=$data['brand_match_anchors'].",";

			$record['raw_link'] .=$data['raw_url_match_anchors'].",";

			

			if($row<=3){  // top 3

				if($data['exact_match_anchors']>0){

					//$ex_link_top_three++;
					$ex_link_top_three = $ex_link_top_three+$data['exact_match_anchors'];

				}

				if($data['blended_match_anchors']>0){

					//$blanded_link_top_three++;
					$blanded_link_top_three = $blanded_link_top_three+$data['blended_match_anchors'];

				}

				if($data['brand_match_anchors']>0){

					//$brand_link_top_three++;
					$brand_link_top_three = $brand_link_top_three+$data['brand_match_anchors'];

				}

				if($data['raw_url_match_anchors']>0){

					//$raw_link_top_three++;
					$raw_link_top_three = $raw_link_top_three+$data['raw_url_match_anchors'];

				}

					

			}

			if($row<=10){  // top 10

				if($data['exact_match_anchors']>0){

					//$ex_link_top_ten++;
					$ex_link_top_ten = $ex_link_top_ten+$data['exact_match_anchors'];

				}

				if($data['blended_match_anchors']>0){

					//$blanded_link_top_ten++;
					$blanded_link_top_ten = $blanded_link_top_ten+$data['blended_match_anchors'];

				}

				if($data['brand_match_anchors']>0){

					//$brand_link_top_ten++;
					$brand_link_top_ten = $brand_link_top_ten+$data['brand_match_anchors'];

				}

				if($data['raw_url_match_anchors']>0){

					//$raw_link_top_ten++;
					$raw_link_top_ten = $raw_link_top_ten+$data['raw_url_match_anchors'];

				}

			}

			

			$sub_sql="SELECT rank,date_added from ".$crawl_table." where url='".$data['url']."' order by date_added limit 0,3";

						

			$sub_query=$this->db->query($sub_sql);

			

			if($sub_query->num_rows() == 3){

				$rank_record=$sub_query->result_array();

				$current_rank=$rank_record[2]['rank'];

				$pre_rank=$rank_record[1]['rank'];

				$pre_pre_rank=$rank_record[0]['rank'];

				if($pre_pre_rank <= 10 and $pre_rank > 10 and $current_rank <= 10)

				{

					if($data['exact_match_anchors']>0){

						$ex_link_recover++;

					}

					if($data['blended_match_anchors']>0){

						$blanded_link_recover++;

					}

					if($data['brand_match_anchors']>0){

						$brand_link_recover++;

					}

					if($data['raw_url_match_anchors']>0){

						$raw_link_recover++;

					}

				}

			}

			

			

		}

		

		$record['ex_link'] =rtrim($record['ex_link'],",");

		$record['blanded_link'] =rtrim($record['blanded_link'],",");

		$record['brand_link'] =rtrim($record['brand_link'],",");

		$record['raw_link'] =rtrim($record['raw_link'],",");

		

		//$record['percent_ex_link'] = (($ex_link_top_ten/10)*100) .",".(($ex_link_top_three/10)*100)  .",".(($ex_link_recover/10)*100);
		//echo $ex_link_top_ten.'>>'.$ex_link_top_ten.'>>'.$blanded_link_top_ten.'>>>>'.$brand_link_top_ten.'>>>>'.$raw_link_top_ten.'===';
		//echo $ex_link_top_three.'>>'.$ex_link_top_three.'>>'.$blanded_link_top_three.'>>>>'.$brand_link_top_three.'>>>>'.$raw_link_top_three;
		if($ex_link_top_ten == 0){
			$ex_topten = '0.00';
		}else{
			$ex_topten = number_format((float)($ex_link_top_ten*100)/($ex_link_top_ten+$blanded_link_top_ten+$brand_link_top_ten+$raw_link_top_ten), 2, '.', '');
		}
		if($ex_link_top_three == 0){
			$ex_topthree = '0.00';
		}else{
			$ex_topthree = number_format((float)($ex_link_top_three*100)/($ex_link_top_three+$blanded_link_top_three+$brand_link_top_three+$raw_link_top_three), 2, '.', '');
		}
		if($ex_link_recover == 0){
			$ex_recover = '0.00';
		}else{
			$ex_recover = number_format((float)($ex_link_recover/10)*100, 2, '.', '');
		}
		
		
		if($blanded_link_top_ten == 0){
			$blanded_topten = '0.00';
		}else{
			$blanded_topten = number_format((float)($blanded_link_top_ten*100)/($ex_link_top_ten+$blanded_link_top_ten+$brand_link_top_ten+$raw_link_top_ten), 2, '.', '');
		}
		if($blanded_link_top_three == 0){
			$blanded_topthree = '0.00';
		}else{
			$blanded_topthree = number_format((float)($blanded_link_top_three*100)/($ex_link_top_three+$blanded_link_top_three+$brand_link_top_three+$raw_link_top_three), 2, '.', '');
		}
		if($blanded_link_recover == 0){
			$blanded_recover = '0.00';
		}else{
			$blanded_recover = number_format((float)($blanded_link_recover/10)*100, 2, '.', '');
		}
		
		if($brand_link_top_ten == 0){
			$brand_topten = '0.00';
		}else{
			$brand_topten = number_format((float)($brand_link_top_ten*100)/($ex_link_top_ten+$blanded_link_top_ten+$brand_link_top_ten+$raw_link_top_ten), 2, '.', '');
		}
		if($brand_link_top_three == 0){
			$brand_topthree = '0.00';
		}else{
			$brand_topthree = number_format((float)($brand_link_top_three*100)/($ex_link_top_three+$blanded_link_top_three+$brand_link_top_three+$raw_link_top_three), 2, '.', '');
		}
		if($brand_link_recover == 0){
			$brand_recover = '0.00';
		}else{
			$brand_recover = number_format((float)($brand_link_recover/10)*100, 2, '.', '');
		}

		if($raw_link_top_ten == 0){
			$raw_topten = '0.00';
		}else{
			$raw_topten = number_format((float)($raw_link_top_ten*100)/($ex_link_top_ten+$blanded_link_top_ten+$brand_link_top_ten+$raw_link_top_ten), 2, '.', '');
		}
		if($raw_link_top_three == 0){
			$raw_topthree = '0.00';
		}else{
			$raw_topthree = number_format((float)($raw_link_top_three*100)/($ex_link_top_three+$blanded_link_top_three+$brand_link_top_three+$raw_link_top_three), 2, '.', '');
		}
		if($raw_link_recover == 0){
			$raw_recover = '0.00';
		}else{
			$raw_recover = number_format((float)($raw_link_recover/10)*100, 2, '.', '');
		}

		
		$record['percent_ex_link'] = $ex_topten.",".$ex_topthree.",".$ex_recover;

		$record['percent_blanded_link'] = $blanded_topten.",". $blanded_topthree.",".$blanded_recover;

		$record['percent_brand_link'] = $brand_topten.",".$brand_topthree.",".$brand_recover;

		$record['percent_raw_link'] = $raw_topten.",".$raw_topthree.",".$raw_recover;

		

		$record['percent_ex_link'] = rtrim($record['percent_ex_link'],",");

		$record['percent_blanded_link'] = rtrim($record['percent_blanded_link'],",");

		$record['percent_brand_link'] = rtrim($record['percent_brand_link'],',');

		$record['percent_raw_link']=rtrim($record['percent_raw_link'],",");

		//echo '<pre>';print_r($record);die();

		

		return $record;

	}

	

	

	

}

