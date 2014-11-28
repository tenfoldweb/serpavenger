<?php include('includes/functions/config.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Scott's Spider</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="includes/js/jslib.js"></script>
    <link href="includes/style/style.css"  type="text/css" rel="stylesheet" />
  </head>
  <body style="margin:0px; font-family:tahoma; font-size:11px">
    <div style="margin:auto; width:auto;">
      <table width="29%" border="0" cellspacing="0" cellpadding="10" align="center" style="margin-top:20px;border:1px dotted #000000;background-color:#DDDDDD">
        <tr>
          <td>
            <div align="left">
            Location:
            <select name="location" id="location">
              <option value="usa">USA</option>
              <option value="uk">UK</option>
              <option value="au">Australia</option>
              <option value="ca">Canada</option>
            </select>
          </div>
          </td>
          <td>
            <div align="left">
              Bot :
              <select name="bot" id="bot">
                <option value="gr">Google Rank</option>
                <option value="bing">Bing Rank</option>
                <option value="yahoo">Yahoo Rank</option>
              </select>
            </div>
          </td>          
          <td>
            <div align="left">
              Keywords :
              <select name="key" id="key">
                <?php 
                  foreach($keywordArray as $keyword){
                ?>
                <option value="<?php echo str_replace(' ','+',$keyword);?>"><?php echo ucwords($keyword);?></option>
                <?php } ?>
              </select>
            </div>
          </td>
          <td>
            <div align="left">
              Page :
              <input type="text" name="page" id="page" value="1" size="3"/>
            </div>
          </td>
          <td>
            <div align="left">
              Delay 
              <input type="checkbox" name="delay" id="delay" value="1" />
            </div>
          </td>
          <td colspan="1" >
            <div align="left">
              <input id="google-rank-btn" type="button" value="Start Bot" />
              
            </div>
          </td>
          
        </tr>
      </table>      
    </div>
    <img src="includes/images/icon_waiting.gif" id="ajax"  style="display:none;">
    <div id="result"></div>
  </body>
</html>