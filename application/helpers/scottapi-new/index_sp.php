<?php include('includes/functions/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Avenger Analysis</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="includes/js/jslibsp.js"></script>
    <link href="includes/style/style.css"  type="text/css" rel="stylesheet" />
  </head>
  <body style="margin:0px; font-family:tahoma; font-size:11px">
    <div style="margin:auto; width:auto;">

	<table  align="center">
		<tr><td colspan="6" align="center"><h1>Avenger Analysis Demo</h1></td></tr>
		<Tr>
			<td> URL: <input type="text" name="my_site_url" id="my_site_url" /></td>
			<td></td>
			<td> Keyword: 
			<input type="text" name="key" id="key" /></td>
		</tr>
		<tr>
			<Td colspan="6">
				<h2>What Search Engine Would You Like to Focus on?</h2>
			</td>
		</tr>
		<tr><td><input id="isCrawlByGoogle" name="isCraw" class="css-checkbox" type="radio" value="gr">
                                                <img src="http://serpavenger.com/serp_avenger/images/add_key_1.jpg">

                                                  <select id="gr_se_domain" name="gr_se_domain" >
                          <option value="">Select Country</option>  
                            <option value="usa" selected="">United States</option>
						   <option value="uk">United Kingdom</option> 
						   <option value="au">Australia</option>
							<option value="ca">Canada</option>
                        </select>   
                                                </td>
                                             
                                             <td>  <input id="isCrawlByBing" name="isCraw" class="css-checkbox" type="radio" value="bing">
                                               
                                                <img src="http://serpavenger.com/serp_avenger/images/add_key_2.jpg">
                                               
                                                     <select id="bing_se_domain" name="bing_se_domain" >
  <option value="">Select Country</option>   
  <option value="usa" selected="">United States</option>
   <option value="uk">United Kingdom</option> 
   <option value="au">Australia</option>
    <option value="ca">Canada</option>
</select>
                                               </td>
                                            
<td>
                                               <input id="isCrawlByYahoo" name="isCraw" class="css-checkbox" type="radio" value="yahoo">
                                               
                                                <img src="http://serpavenger.com/serp_avenger/images/add_key_3.jpg">
                                                
                                                     <select id="yahoo_se_domain" name="yahoo_se_domain"  >
													  <option value="">Select Country</option>  
													 
														<option value="usa" selected="">United States</option>
													   <option value="uk">United Kingdom</option> 
													   <option value="au">Australia</option>
														<option value="ca">Canada</option>
													</select>
                                                
			</td>
		</tr>
			<Tr><td>&nbsp;</td></tr>
			<Tr><td colspan="6" align="center">     <input id="google-rank-btn" class="myButton" type="button" value="RUN Analysis" /></td></tr>
		</table>


    <img src="includes/images/icon_waiting.gif" id="ajax"  style="display:none;">
    <div id="result"></div>
  </body>
</html>




