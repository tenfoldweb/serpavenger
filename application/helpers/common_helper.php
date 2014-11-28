<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * This function is used for output of the array
 * @param array
 * @param print option optional
 * @return String
 */
if ( ! function_exists('pr'))
{
	function pr($arr,$e=1)
	{
		if(is_array($arr))
		{
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
		}
		else
		{
			echo "<br>Not an array...<br>";
			echo "<pre>";
			var_dump($arr);
			echo "</pre>";
	
		}
		if($e==1)
		    exit();
		else
		    echo "<br>";
	}
}

/*
 * This function is used for output a string with certain limit
 * @param strings : input_string, limit
 * @return String
 */

if ( ! function_exists('sub_word'))
{
    function sub_word($str, $limit)
    {
            $text = explode(' ', $str, $limit);
            if (count($text)>=$limit)
            {
                    array_pop($text);
                    $text = implode(" ",$text).'...';
            }
            else
            {
                    $text = implode(" ",$text);
            }
            $text = preg_replace('`\[[^\]]*\]`','',$text);
            return strip_tags($text);
    }
}

/*
 * This function is used for sending mail
 * @param arrays : mail_array and attachment_array
 * @param strings : cc and bcc optional
 * @return Boolean TRUE||FALSE
 */

if (!function_exists('send_email'))
{
	function send_email(&$mail_config, &$attachment_file='', $cc='', $bcc='') //$to, $from, $from_name, $subject, $message,
	{
		$CI = & get_instance();
		$CI->load->library('email');
		
		
		$config['mailtype'] = "html";
		$CI->email->initialize($config);
		
		$to		= $mail_config['to'];
		$from		= $mail_config['from'];
		$from_name	= $mail_config['from_name'];
		$subject	= $mail_config['subject'];
		$message	= $mail_config['message'];
		
		$CI->email->to($to);
		$CI->email->from($from, $from_name);
		$CI->email->subject($subject);
		$CI->email->message($message);
		
		if($cc != '') {
			$CI->email->cc($cc);
		}
		
		if($bcc != '') {
			$CI->email->bcc($bcc);
		}
		
		if(is_array($attachment_file)) {
			$attach_file_path = '';
			for($a=0;$a<count($attachment_file);$a++)
			{
				$attach_file_path = $attachment_file[$a];
				$CI->email->attach($attach_file_path);
			}
		}
		
		
		
		$i_email = $CI->email->send();
		$CI->email->clear();
		return $i_email;
	}
}

/*
 * This function is used for file upload
 * @param array : upload_array
 * @return String 
 */
if (!function_exists('file_upload'))
{
	function file_upload(&$file_upload_config)
	{
		$CI = & get_instance();
		$CI->load->library('Upload');
		
		$field_name 		= $file_upload_config['field_name'];
		$file_upload_path 	= $file_upload_config['file_upload_path'];
		$max_size 			= $file_upload_config['max_size'];
		$allowed_types 		= $file_upload_config['allowed_types'];
		
		$config['upload_path'] 	= file_upload_absolute_path().$file_upload_path;
		
		if($allowed_types != '')
		{
			$config['allowed_types'] 	= $allowed_types;
		}
		
		if($max_size != '')
		{
			$config['max_size']		= $max_size;
		}
		
		if(isset($file_upload_config['encrypt_name']))
		{
			$config['encrypt_name']		= $file_upload_config['encrypt_name'];
		}
		else
		{
			$config['encrypt_name']		= true;
		}
		
		$uploaded_file_name = '';
		$CI->upload->set_config($config);
		$i_upload = $CI->upload->do_upload($field_name,true);
		
		//echo $CI->upload->display_errors();
		
		$CI->session->set_userdata('upload_err',$CI->upload->display_errors());
		
		$file_upload_config['upload_err'] = $CI->upload->display_errors();
		
		if($i_upload) {
			$uploaded_file_name = $CI->upload->file_name;
			
		} 
		return $uploaded_file_name;
	}
}

/*
 * This function is used for image upload
 * @param arrays : upload_array and thumb_array
 * allowed_types, encrypt_name
 * @return String 
 */
if (!function_exists('image_upload'))
{
	function image_upload(&$upload_config, &$thumb_config)
	{
		$CI = & get_instance();
		
		$CI->load->library('Upload');
		
		$field_name 		= $upload_config['field_name'];
		$file_upload_path 	= $upload_config['file_upload_path'];
		$max_size 		= $upload_config['max_size'];
		$max_width 		= $upload_config['max_width'];
		$max_height 		= $upload_config['max_height'];
		$allowed_types 		= $upload_config['allowed_types'];
		$thumb_create 		= $thumb_config['thumb_create'];
		$thumb_file_upload_path = $thumb_config['thumb_file_upload_path'];
		$thumb_width 		= $thumb_config['thumb_width'];
		$thumb_height 		= $thumb_config['thumb_height'];
		
		$config['upload_path'] 	= file_upload_absolute_path().$file_upload_path;
		
		
		if($allowed_types != '') {
			$config['allowed_types'] 	= $allowed_types;
		}
		
		if($max_size != '') {
			$config['max_size']		= $max_size;
		} else {
			$config['max_size']		= '';
		}
		
		if($max_width != '') {
			$config['max_width']		= $max_width;
		} else {
			$config['max_width']		= '';
		}
		
		if($max_height != '') {
			$config['max_height']		= $max_height;
		} else {
			$config['max_height']		= '';
		}
		
		if(isset($upload_config['encrypt_name'])) {
			$config['encrypt_name']		= $upload_config['encrypt_name'];
		} else {
			$config['encrypt_name']		= true;
		}
                
		$uploaded_file_name = '';
		$CI->upload->set_config($config);
		$i_upload = $CI->upload->do_upload($field_name,true);
		
		$CI->session->set_userdata('upload_err',$CI->upload->display_errors());
		
		$upload_config['upload_err'] = $CI->upload->display_errors();
		
		if($i_upload) {
			$uploaded_file_name = $CI->upload->file_name;
			if($thumb_create) {
				$config['source_image']		= file_upload_absolute_path().$file_upload_path.$uploaded_file_name;
				$config['new_image'] 		= file_upload_absolute_path().$file_upload_path.$thumb_file_upload_path.$uploaded_file_name;
				$config['create_thumb'] 	= TRUE;
				$config['maintain_ratio']	= TRUE;
				$config['width']	 	= $thumb_width;
				$config['height']		= $thumb_height;
				$config['thumb_marker']		= '';
				
				$CI->load->library('image_lib', $config); 
				$CI->image_lib->resize();
			}
			else {
				//return true;
			}
		} else {
			return false;
		}
		return $uploaded_file_name;
	}
}

/* This function is to create thumb from a already uploaded file
*/
if (!function_exists('create_file_thumb')){
	function create_file_thumb($uploaded_file_name, &$upload_config, &$thumb_config){
		
		$file_upload_path 			= $upload_config['file_upload_path'];
		$thumb_file_upload_path 	= $thumb_config['thumb_file_upload_path'];
		$thumb_width 				= $thumb_config['thumb_width'];
		$thumb_height 				= $thumb_config['thumb_height'];
		
		$config['source_image']		= file_upload_absolute_path().$file_upload_path.$uploaded_file_name;
		$config['new_image'] 		= file_upload_absolute_path().$thumb_file_upload_path.$uploaded_file_name;
		$config['create_thumb'] 	= TRUE;
		$config['maintain_ratio']	= TRUE;
		$config['width']	 		= $thumb_width;
		$config['height']			= $thumb_height;
		$config['thumb_marker']		= '';
		
		$CI = & get_instance();
		$CI->load->library('image_lib');
		
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();
		$CI->image_lib->clear();
	}
}

/* This function is used for Download File
 * @param strings : file_name_path, original_file_name
 * @return NULL
*/
if (!function_exists('file_download'))
{
	function file_download($file_name_path, $original_file_name='') 
	{
		if(isset($original_file_name)) {
			$file_name = $original_file_name;
		} else {
			$file_name = $file_name_path;
		}
		$mime = 'application/force-download';
		header('Pragma: public');    
		header('Expires: 0');        
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
		header('Content-Transfer-Encoding: binary');
		header('Connection: close');
		readfile($file_name_path);
		return true;
		
	}
}

/* This function is used for creation of PDF
 * @param  strings : view_file_name, output_file_name_path, output_option,
 * landscape_portrait and paper_size
 * @return NULL
 */
if (!function_exists('generate_pdf'))
{
	function generate_pdf($view_file_name, $output_file_name_path='', $output_option, $landscape_portrait='', $paper_size='')
	{
		$CI = & get_instance();
		$CI->load->library('pdf');
		
		// set document information
		$CI->pdf->SetAuthor('Author');
		$CI->pdf->SetTitle('Title');
		$CI->pdf->SetSubject('Subject');
		$CI->pdf->SetKeywords('keywords');
		
		// set font
		$CI->pdf->SetFont('helvetica', 'N', 6);
		
                $CI->pdf->setPrintHeader(false);
		$CI->pdf->setPrintFooter(false);
                
                // add a page
                if($landscape_portrait != '' && $paper_size != '')
                {
			// set default monospaced font
			$CI->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			// set margins
			//$CI->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$CI->pdf->SetMargins(10, 10, 10);
			// set auto page breaks
			$CI->pdf->SetAutoPageBreak(TRUE, 0);
			$CI->pdf->AddPage($landscape_portrait, $paper_size);
                }
                else
                {
                    $CI->pdf->AddPage();
                }
		
		// write html on PDF
		$CI->pdf->writeHTML($view_file_name, true, false, true, false, '');
		ob_clean();
		
		//Close and output PDF document
		$CI->pdf->Output($output_file_name_path, $output_option);
	}
}

/* This function is used for removing special character
 * @param  String
 * @return String
 */
if (!function_exists('removeSpecialChar'))
{
	function removeSpecialChar($psString)
	{
            return preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%-]/s', '', $psString);
	}
}

if (!function_exists('timeDifference'))
{
	function timeDifference($startDate){
		$return = '';
		$datetime1 = date_create($startDate);
		$datetime2 = date_create(date("Y-m-d"));
		$interval = date_diff($datetime1, $datetime2);
		$return = $interval->format('%y years %m months %d days');		
		return $return;
	}
}

if(! function_exists('rearrange_array'))
{
    function rearrange_array($array)
    {
        $output = array();
        foreach($array as $a){
            array_push($output,$a);
        }
        return $output;
    }
}    

if(! function_exists('array_sort')){
	function array_sort ($array, $key) {
		$sorter=array();
		$ret=array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array=$ret;
		return $array;
	}
}/* Function name: check_thumb_image_exists* By : Ravi Prakash* Desc: This function is used to check is thumbnail exist or not in db*/
if(! function_exists('check_thumb_image_exists')){	function check_thumb_image_exists($url){		$CI= get_instance();		$CI->load->model('model_thumbnail');		$imagedata = $CI->model_thumbnail->get_image_thumbnail($url);				if($imagedata->num_rows>0){				$data = $imagedata->result();				return $data[0]->imagename;		}		return '';	}}/* Function name: save_thumb_image_exists* By : Ravi Prakash* Desc: This function is used to save data of thumbnail into db*/if(! function_exists('save_thumb_image_exists')){	function save_thumb_image_exists($id1,$url){			$data = array('imagename'=>"$id1",'siteurl'=>$url);		$CI = get_instance();		$CI->load->model('model_thumbnail');		$CI->model_thumbnail->save_image_thumbnail($data);			}}

/* End of file common_helper.php */
/* Location: ./front-app/helpers/common_helper.php */