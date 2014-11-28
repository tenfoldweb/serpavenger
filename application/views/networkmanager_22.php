<?php $this->load->helper('url'); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/styles.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/screen.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/css/toggles.css" media="all" />
<!--[if lt IE 9 ]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script src="<?php //echo base_url() ?>assets/js/ajaxfileupload.js"></script>-->
<script src="<?php echo base_url()?>assets/js/Chart.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.datatables.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.jeditable.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.blockui.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery-ui-1.10.4.js"></script>

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" media="all" />

<?php $pauseindx = "";
if(isset($retarr) && count($retarr) > 0) {
  foreach($retarr as $key=>$arr) {
  if(!$arr['status'])
  $pauseindx .= $key.",";
  }
  $pauseindx = rtrim($pauseindx,",");
  } ?>

<script type="text/javascript">

$(document).ready(function(){
	
	var pindx = "<?=$pauseindx; ?>";
	if(pindx != "")
	{
		var arr = pindx.split(",");
		
		for(var i=0;i<arr.length;i++)
		$("#pause"+arr[i]).css("border","red 5px solid")
	}

	var defaultblog = "<?php if(isset($networksetting['defaultblog'])) echo $networksetting['defaultblog']; ?>";

	$('input[name="defaultblog"]').each(function(){
		if(defaultblog == $(this).val())
		{
         $(this).attr("checked",true);
		 $("#selectblogtype").val(defaultblog);
		}
    });
	
	var defaultnetwork = "<?php if(isset($networksetting['defaultnetwork'])) echo $networksetting['defaultnetwork']; ?>";

	$('input[name="defaultnetwork"]').each(function(){
		if(defaultnetwork == $(this).val())
		{
        $(this).attr("checked",true);
		$("#selectnetwork").val(defaultnetwork);
		}
    });
	
	var indexfrequency = "<?php if(isset($networksetting['indexfrequency'])) echo $networksetting['indexfrequency']; ?>";

	$('input[name="indexfrequency"]').each(function(){
		if(indexfrequency == $(this).val())
        $(this).attr("checked",true);
    });
	
	var pauseposting = "<?php if(isset($networksetting['pauseposting'])) echo $networksetting['pauseposting']; ?>";
	
	var arr = pauseposting.split(",");
	for(var i=0;i<arr.length;i++)
	{
		$('input[type="checkbox"]').each(function(){
			
			var pr=arr[i].split("<");
			if(pr.length > 0)
			{
				if(pr[0] == $(this).val())
				{
			     $(this).attr("checked",true);
                 $("#pr").removeAttr('disabled');
				 $('#pr').val(pr[1]);
				}
			}
			else
			{
				if(arr[i] == $(this).val())
				 $(this).attr("checked",true);
			}
		});
	}
	
	var backlinkstat = "<?php if(isset($networksetting['backlinkstat'])) echo $networksetting['backlinkstat']; ?>";

	if(backlinkstat == 1)
	{
	  $('.backlinkdata').show();
	  $('.actvahrefs').hide();
	  $('.activated').show();
	}
	else
	{
	  $('.backlinkdata').hide();
	  $('.actvahrefs').show();
	  $('.activated').hide();
	}

	var backlinkcount = "<?php if(isset($networksetting['backlinkcount'])) echo $networksetting['backlinkcount']; ?>";
	if(backlinkcount == 1)
	 $('input[name="backlinkcount"]').attr("checked",true);
	else
	 $('input[name="backlinkcount"]').removeAttr('checked');

	var domainrank = "<?php if(isset($networksetting['domainrank'])) echo $networksetting['domainrank']; ?>";
	if(domainrank == 1)
	 $('input[name="domainrank"]').attr("checked",true);
	else
	 $('input[name="domainrank"]').removeAttr('checked');
	
	var referringdomains = "<?php if(isset($networksetting['referringdomains'])) echo $networksetting['referringdomains']; ?>";
	if(referringdomains == 1)
	 $('input[name="referringdomains"]').attr("checked",true);
	else
	 $('input[name="referringdomains"]').removeAttr('checked');
	
	var ahrefsfrequency = "<?php if(isset($networksetting['ahrefsfrequency'])) echo $networksetting['ahrefsfrequency']; ?>";
	$('input[name="ahrefsfrequency"]').each(function(){
		if(ahrefsfrequency == $(this).val())
        $(this).attr("checked",true);
    });
	
	var pagerank = "<?php if(isset($networksetting['pagerank'])) echo $networksetting['pagerank']; ?>";
	$('input[name="pagerank"]').each(function(){
		if(pagerank == $(this).val())
        $(this).attr("checked",true);
    });
  
   $("#togglesettings").click(function(){
	   $("#netsettings").css("display","block");
		$("#fade").css("display","block");
  });

	$('#closenetsettings').click(function(){
		$("#netsettings").css("display","none");
		$("#fade").css("display","none");
		$("#netwrksettings").submit();
	    });

   $("#lesspr").click(function(){
    if($("#lesspr").is(":checked"))
     $("#pr").removeAttr('disabled');
	else
	{
	 $("#pr").attr('disabled',true);
	 $("#pr").val("");
	}
  });

  $('#assigndomains').click(function(){
		$("#assigndom").css("display","block");
		$("#fade").css("display","block");
	    });
  
   $('#newnetwork').click(function(){
		$("#addnetwrk").css("display","block");
		$("#fade").css("display","block");
	    });

  $('#moredomain').click(function(){
		$("#light").css("display","block");
		$("#fade").css("display","block");
	    });
		
  $('#searchlinks').click(function(){
		$("#editlinks").css("display","block");
		$("#fade").css("display","block");
	    });

  $('.closepopup').click(function(){
	    $("#assigndom").css("display","none");
		$("#light").css("display","none");
		$("#addnetwrk").css("display","none");
		$("#managenetwrk").css("display","none");
		$("#fade").css("display","none");	
		$("#anchor_reset").css("display","none");
		$("#editlinks").css("display","none");
		$("#netwkname").val("");
		$("#netwkdesc").val("");
		$("#searchdata").val("");
		$('#addnetwrk').find('input[type=checkbox]:checked').removeAttr('checked');
		$('#assigndom').find('input[type=checkbox]:checked').removeAttr('checked');
		$('#assigndom').find('input[type=radio]:checked').removeAttr('checked');
		$('input[name="domainlist"]').val("");
		$("[id^=domainname]").val("");
		$("[id^=username]").val("");
		$("[id^=password]").val("");	
		$("#viewlist").empty();
		$('#edit').hide();
		$('[name^=post_]').removeAttr("checked");
		$('input[name=searchbyanchor]').removeAttr("checked");
		$('input[name=searchbydomain]').removeAttr("checked");
		$('#select_all_posts').removeAttr("checked");
		$("#ids").val("");
		$("#typesvals").val("");
		$("[name^=post_]").val("");
	    });
		
	$('.close').click(function(){
		$(".notification").css("display","none");
	  });
//for popup toggle function

$('.toggle_button').click(function(){
			if(!$(".toggle_box").is(":visible"))
			{
			  $('#edit').hide();
			  $('[name^=post_]').removeAttr("checked");
			}
		});

		$('.cross').click(function(){
			if(!$(".toggle_box").is(":visible"))
			{
			  $('#edit').hide();
			  $('[name^=post_]').removeAttr("checked");
			}
		});
$('#addcategory').click(function(){
			$('.rowhead').append('<th><form action="<?php echo base_url()?>networkmanager/addcategory" method="post"><input type="text" name="newcategory" placeholder="Enter Category Name"><input type="submit" value="Save"></form></th>')
		});

		 $('#select_all_posts').click(function () {
			if($(this).is(":checked")){
			  $('[name^=post_]').prop('checked', true);
			  
			var chk='';
			var ids=[];
			var typevals=[];
			 $("[name^=post_]:checked").each(function() { 							   
				   chk ='yes';
				 
				   ids.push([$(this).val()]);
				   typevals.push([$(this).attr('typevals')]);
			 });			 
			 $('#typesvals').val(typevals.toString(typevals));	
			 $('#ids').val(ids.toString(ids));	
			 
			 if(chk=='yes'){
				 $('#edit').show();
			 }else{
				 $('#edit').hide();
			 }	
			  
			}else{
			  $('[name^=post_]').prop('checked', false);
			  $('#edit').hide();
			}
		});

		$('#delete_domain').click(function () {

			var stat = window.confirm('Delete domain(s)?');
			
			if(stat)
			{
			 var domids=[];
			 $("[name^=record_]:checked").each(function() { 							   
				   domids.push([$(this).val()]);
			 });			 

			 var ids = domids.toString(domids);
				
				if(ids != "")
				{
					$.post("<?php echo base_url() ?>networkmanager/deletedomain", {domid:ids}, function(data){
						 window.location="networkmanager";
					});
				}
			}
		});
});
 function select_posts(cnt)
  {
	  var id = "select_all_posts_" + cnt;
	  
	  if($('#'+id).is(":checked")){

	  $('[name^=post_'+cnt+'_]').prop('checked', true);
		
	  var chk='';
	  var ids=[];
	  var typevals=[];
	  
	   $("[name^=post_"+cnt+"_]:checked").each(function() {
									 
			 chk ='yes';
		   
			 ids.push([$(this).val()]);
			 typevals.push([$(this).attr('typevals')]);
	   });
	   
	   $('#typesvals').val(typevals.toString(typevals));	
	   $('#ids').val(ids.toString(ids));	
	   
	   if(chk=='yes')
	   {
		   $('#edit').show();
	   }
	   else
	   {
		   $('#edit').hide();
	   }	
		
	  }
	  else
	  {
		$('[name^=post_'+cnt+'_]').prop('checked', false);
		$('#edit').hide();
	  }
  }

  function pause_posting(id)
  {	
	$.post('<?php echo base_url()?>networkmanager/pauseposting', { domid:id }, function(data){
		if(!data) { $("#pause"+id).css("border","red 5px solid") } else { $("#pause"+id).css("border","none") }
		});
  }

function toogle_sub(cnt)
{
  $("#toggle_box"+cnt).toggle();
}


//for uploading files

	 $('#uploadfile').click(function(){
		var inputfile = $('input[name="domainlist"]').val();
        var file_ext = inputfile.split('.').pop();

	if(file_ext.toLowerCase() == "csv")
	{
		$.ajaxFileUpload
		(
			{
		url:'<?php echo base_url() ?>networkmanager/uploadfile',
		secureuri:false,
				fileElementId:'domainlist',
				dataType: 'json',
				success: function (data, status)
				{
					$('#uploadfile').hide();
					$('#uploaded').show();
					
					if(data.retval != "")
					{
						var rec = data.retval.split("|");
						
						$('<tr/>', {
								html: '<td><b>Domain</b></td><td><b>Username</b></td><td><b>Password</b></td>'
							}).appendTo('#viewlist');
						
						for(var i=0;i<rec.length-1;i++)
						{
							var col = rec[i].split(",");

							$('<tr/>', {
								html: '<td>'+col[0]+'</td><td>'+col[1]+'</td><td><img src="<?php echo base_url() ?>assets/images/img20.png"></td>'
							}).appendTo('#viewlist');
						}
						
						alert(rec.length-1 + " Domains have been succesfully uploaded, click submit to continue");
					}
				
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
	}
	else
	alert("Upload a CSV file");
	});
	

	 $("#searchbtn").click(function(){
	  if(!$("input[name=searchdomain]").is(":checked") && !$("input[name=searchanchor]").is(":checked"))
	  {
		alert("Select search type");
		$(".searchtype").css("border","red 1px solid");
		return false;
	  }
	  else if($.trim($("#search").val()) == "")
	  {
		alert("Enter search string");
		$(".top1_up #search").css("border","red 1px solid");
	    return false;
	  }
	  else
	    return true;
  });
  
   $("#searchby").click(function(){
	  if(!$("input[name=searchbydomain]").is(":checked") && !$("input[name=searchbyanchor]").is(":checked"))
	  {
		alert("Select search by");
		$(".searchtype").css("border","red 1px solid");
		return false;
	  }
	  else if($.trim($("#searchdata").val()) == "")
	  {
		alert("Enter search string");
		$(".top2 #searchdata").css("border","red 1px solid");
	    return false;
	  }
	  else
	  {
		if($('input[name=searchbydomain]').is(":checked"))
		 query = "domain=";
		
		if($('input[name=searchbyanchor]').is(":checked"))
		 query = "anchor=";
		 
		 window.location="<?php echo base_url()?>networkmanager?editlink=1&" + query + $('#searchdata').val();
		 
	    return true;
	  }
  });
 
 
   <?php if(isset($_GET['searchdomain'])) { ?>
  $("input[name=searchdomain]").attr('checked','checked');
  <?php } if(isset($_GET['searchanchor'])) { ?>
  $("input[name=searchanchor]").attr('checked','checked');
  <?php } ?>

  if($("input[name=searchdomain]").is(":checked") || $("input[name=searchanchor]").is(":checked"))
    $("#search").val("<?php if(isset($_GET['search'])) echo $_GET['search']; ?>");
	
	<?php if(isset($searchdomainid)) { ?>
  $("#domains option[value=<?=$searchdomainid; ?>]").attr('selected', 'selected');
  <?php } elseif(isset($_GET['search'])) { ?>
   $("#domains option:contains(<?=$_GET['search']; ?>)").attr('selected', 'selected');
   <?php } ?>
 
  $("#domains").change(function(){
	  if($("#domains option:selected").text() != "Show All Domains")
	   {
		 domain = $("#domains option:selected").text();
         window.location="?search=" + domain;
	   }
	   else
	     window.location="<?php echo base_url()?>networkmanager";
  });
  
  $('#edit').click(function(){
		$("#anchor_reset").css("display","block");
		$("#fade").css("display","block");
	    });

  $("[name^=post_]").click(function(){
			var chk='';
			var ids=[];
			var typevals=[];
			 $("[name^=post_]:checked").each(function() { 							   
				   chk ='yes';
				   ids.push([$(this).val()]);
				   typevals.push([$(this).attr('typevals')]);
			 });			 
			 $('#typesvals').val(typevals.toString(typevals));	
			 $('#ids').val(ids.toString(ids));		 
			 
			 
			 if(chk=='yes'){
				 $('#edit').show();
			 }else{
				 $('#edit').hide();
			 }		
		});
			
		
             
	
	
		
 
function edit_login_data(id, type)
{
	$('#'+type+'_'+id).hide();
	$('#edit_'+type+'_'+id).show();
	$('#edit_'+type+'_'+id).focus();
}

function update_login_data(id, type){
	
	var hidval = $("#hid_"+type+"_"+id).val();
	var newval = $("#edit_"+type+"_"+id).val();
	
	if(newval != "")
	{
		 $.post("<?php echo base_url() ?>networkmanager/update_login_data", {id:id, field_name:type, new_value:newval}, function(data){
			 window.location="networkmanager";
		});
	}
	else
	  $("#edit_"+type+"_"+id).val(hidval);
	
	$('#edit_'+type+'_'+id).hide();
	$('.star').show();
}

function manage_network(netid,netname)
{
	$("#addnetwrk").css("display","none");
	$("#managenetwrk").css("display","block");
	$("#hidnetid").val(netid);
	$("#editnetwkname").val(netname);
	$("[class^=nid]").hide();
	//$(".showdomain" + netid).show();
	$("[class*=nid" + netid + "_]").show();
	
	if(netid == 1)
	$(".removedom").hide();
	
	if(netname.toLowerCase() == "uncategorized")
	  $("#delnetwork").hide();
	else
	  $("#delnetwork").show();
}

function delete_network()
{
	var status = window.confirm("Delete this network?");
	
	if(status)
	{
	  $("#hidsnetstat").val(0);
	  $("#managenetwork").submit();
	}
}

function remove_domain(id)
{
	var status = window.confirm("Remove the domain from this network?");
	
	if(status)
	{
	  $("#hiddomid").val(id);
	  $("#hiddomstat").val(0);
	  $("#managenetwork").submit();
	}
}

function add_domain()
{
	$("#light").css("display","block");
	$("#fade").css("display","block");
	$("#managenetwrk").css("display","none");
}

function edit_category(id)
{
	$("#"+id).show();
}

function search_type(el)
{
	window.location="?s=" + el;
}

function show_next(val)
{
	window.location="?show=" + val;
}

function update_links(id, field, field_val){
	//alert('hit');
	$('#'+field+'_'+id).removeAttr('onclick');
	var txt = '<input type="text" name="'+field+'" value="'+field_val+'" onblur="save_links('+id+',\''+ field+'\',\''+ field_val+'\')">';
	$('#'+field+'_'+id).html(txt);
	$('#'+field+'_'+id).find('input').focus();
}
function save_links(id, field, field_val){
	
  	var newlink = $('#'+field+'_'+id).find('input').val();
	$('#'+field+'_'+id).html('<img src="<?php echo base_url()?>assets/images/loader.gif" border="0" />');
	$.post( "<?php echo base_url()?>activesubmissions/update_link", { id:id, field_name:field, new_value:newlink}, function(data){
		//alert(data);
		if(data > 0){
		$('#'+field+'_'+id).attr("onclick","update_links("+id+", '"+field+"', '"+newlink+"')");
		$('#'+field+'_'+id).html(newlink);
		}else{
			$('#'+field+'_'+id).attr("onclick","update_links("+id+", '"+field+"', '"+field_val+"')");
		    $('#'+field+'_'+id).html(newlink);
		}
	});
	//alert(newlink);	
}

 <?php if(isset($domains) && count($domains) > 0) {
	    $domstring = "";
		foreach($domains as $doms) 
		$domstring .= $doms['domainname']."|";
		$domstring = rtrim($domstring,"|"); }
		
		if(isset($posts['linksearch']) && count($posts['linksearch']) > 0) {
			$linkstring = "";
			
			foreach($posts['linksearch'] as $lnk)
             $linkstring .= $lnk."|";
			
			$linkstring = rtrim($linkstring,"|");
		} ?>

$(function() {
	var mrefreshinterval = 500; // update display every 500ms
    var lastmousex=-1; 
    var lastmousey=-1;
    var lastmousetime;
    var mousetravel = 0;
    var mpoints = [];
    var mpoints_max = 30;
    $('html').mousemove(function(e) {
        var mousex = e.pageX;
        var mousey = e.pageY;
        if (lastmousex > -1) {
            mousetravel += Math.max( Math.abs(mousex-lastmousex), Math.abs(mousey-lastmousey) );
        }
        lastmousex = mousex;
        lastmousey = mousey;
    });
    var mdraw = function() {
        var md = new Date();
        var timenow = md.getTime();
        if (lastmousetime && lastmousetime!=timenow) {
            var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
            mpoints.push(pps);
            if (mpoints.length > mpoints_max)
                mpoints.splice(0,1);
            mousetravel = 0;
            $('.dynamicsparkline').sparkline(mpoints, { width: mpoints.length*2, tooltipSuffix: ' pixels per second' });
        }
        lastmousetime = timenow;
        setTimeout(mdraw, mrefreshinterval);
    }
    setTimeout(mdraw, mrefreshinterval); 
	
	var availableTags = new Array();
	//$(".ui-autocomplete").removeClass("ui-widget-content");
	<?php if((isset($_GET['s']) && $_GET['s'] == "searchdomain") || isset($_GET['searchdomain'])) { ?>
	$("input[name=searchdomain]").attr('checked','checked');
	var str = "<?php if(isset($domstring)) echo $domstring; ?>";
    availableTags = str.split("|");
    <?php } if((isset($_GET['s']) && $_GET['s'] == "searchanchor") || isset($_GET['searchanchor'])) { ?>
	$("input[name=searchanchor]").attr('checked','checked');
	var str = "<?php if(isset($linkstring)) echo $linkstring; ?>";
    availableTags = str.split("|");
	<?php } ?>
	
    $("#search").autocomplete({
      source: availableTags
    });
	
	/*$('input[name=searchbydomain]').click(function(){
	var availableTags = new Array();

	var str = "<?php if(isset($domstring)) echo $domstring; ?>";
	availableTags = str.split("|");
	
		 $("#searchdata").autocomplete({
		  source: availableTags
		});
	});
	
	$('input[name=searchbyanchor]').click(function(){
	var availableTags = new Array();

	var str = "<?php if(isset($linkstring)) echo $linkstring; ?>";
	availableTags = str.split("|");
	
		 $("#searchdata").autocomplete({
		  source: availableTags
		});
	});*/

  });
</script>

</head>
<body>
<div id="fade" class="black_overlay"></div>
<section class="page clearfix">
<?php $this->load->view('frontend/header');?>
  <section class="main">
    <section class="mainContent clearfix">

		 <?php $this->load->view('frontend/main_menu');?>
        <section class="">

      <div class="network">

      	<div class="network_top">

        	<div class="top1">

            	<div class="top1_up">

                	<form class="clearfix" id="searchrecord" name="searchrecord" method="get" action="<?php echo base_url()?>networkmanager">

                        <div class="ui-widget">
                    	<input type="text" name="search" id="search">

                        <input type="submit" id="searchbtn" name="submit" value="Search">
                        </div>
                        
                       <br><br><br>
                       <div class="searchtype">
                       <input type="checkbox" class="searchtype" name="searchdomain" value="domains" onClick="search_type(this.name)"><span>PR Domains</span>
                       <input type="checkbox" class="searchtype" name="searchanchor" value="anchors" onClick="search_type(this.name)"><span>Anchor / Links</span>
                       </div>

                    </form>
                </div>

                <div class="top1_down">

                	<div class="drop1">
						
                    	<select id="domains" name="domains">
                        	<option value="">Show All Domains</option>
                            <?php if(isset($domains) && count($domains) > 0) { 
							foreach($domains as $key=>$doms) { ?>
                        	<option value="<?=$key; ?>"><?=$doms['domainname']; ?></option>
                            <?php } } ?>
                        </select>
						
                    </div>

                    <button>View icon legend</button>

                </div>

            </div>

        	<div class="top2">

            	<div class="content_titel clearfix"><h2>My Network Overview</h2>
                
                <!--<img src="<?php //echo base_url() ?>assets/images/img10.png" alt="no img"/>-->
                
                <span class="dynamicsparkline"></span>
                
                </div>

                <div class="overview">

                	<ul>

                    	<li>

                        	<span>Manager</span>

                            <a href="javascript:void(0)" id="assigndomains">+ Manager Networks</a>
                            
                            <div id="assigndom" class="white_content">
                            <a href="javascript:void(0)" class="closepopup">Close</a>

                            <form id="assigndomain" name="assigndomain" action="<?php echo base_url()?>networkmanager/assigndomains" method="post">
                            
                            <table>
                            <tr>
                            <td colspan="3"><b>Assign Domains to Network</b></td>
                            </tr>
                            
                            <tr>
                            <td id="domain">
                            <b><u>Choose Domain(s)</u></b>
                            <ul class="list">
                            <?php if(isset($domains) && count($domains) > 0) {
								$sortdomains = $domains;
								krsort($sortdomains);
							foreach($sortdomains as $key=>$doms) { ?>
                            <li><input type="checkbox" name="domain[]" value="<?=$key; ?>">&nbsp;&nbsp;<?=$doms['domainname']; ?></li>
                            <?php } } ?>
                            </ul>
                            </td>
                           
                            <td><span class="assign">Assign to</span></td>
                           
                            <td id="network">
                            <b><u>Choose Network</u></b>
                            <ul class="list">
                            <?php if(isset($networks) && count($networks) > 0) {
							foreach($networks as $key=>$nets) { ?>
                            <li><input type="radio" name="network" value="<?=$key; ?>">&nbsp;&nbsp;<?=$nets['networkname']; ?></li>
                            <?php } } ?>
                            </ul>
                            </td>
                            </tr>
                          
                            <tr>
                            <td colspan="3">
                           <input type="submit" name="assign" value="Assign">
                           </td>
                           </tr>
                           
                           </table>
                            </form>
                            </div>

                        </li>

                    	<li>

                        	<span><?php if(isset($networks)) echo count($networks); else echo 0; ?> Networks</span>

                            <a href="javascript:void(0)" id="newnetwork">+ New Network</a>
                            
                             <div id="addnetwrk" class="white_content">
                            <a href="javascript:void(0)" class="closepopup">Close</a>

                            <form id="addnewnetwork" name="addnewnetwork" action="<?php echo base_url()?>networkmanager/addnetwork" method="post">
                            <table>
                            <tr>
                            <td><b>Create New Network</b></td>
                            <td><input type="text" id="netwkname" name="netwkname"></td>
                            <td><input type="submit" name="addnetwork" value="Submit"></td>
                            </tr>
                                   <tr><td colspan="3" height="10"></td></tr>                    
                            <tr>
                           <td colspan="3"><u>Click on Any of Your Existing Networks to Edit or Manage them:</u></td>
                           </tr>
                                   <tr><td colspan="3" height="10"></td></tr>
                             <?php if(isset($networks) && count($networks) > 0) { $i=1;
							foreach($networks as $key=>$net) {
								
								if($i==4)
								{
								echo '</tr>';
								$i=1;
								}
								
								if($i==1)
								echo '<tr>'; ?>
                            
                 <td><a href="javascript:void(0)" onClick="manage_network(<?=$key; ?>, &quot;<?=$net['networkname']; ?>&quot;)"><?=$net['networkname']; ?> (<?=$net['domcount']; ?>)</a></td>

                            <?php $i++; }} ?>
                           
                            </table>
                            </form>
                            </div>
                            
                            <div id="managenetwrk" class="white_content">
                            <a href="javascript:void(0)" class="closepopup">Close</a>

                           <form id="managenetwork" name="managenetwork" action="<?php echo base_url()?>networkmanager/editnetwork" method="post">
                            <table>
                            <tr><td colspan="4"><b>Manage Network</b></td></tr>
                            <tr>
                            <td>Network Name</td>
                            <td><input type="text" id="editnetwkname" name="editnetwkname"></td>
                            <td><input type="submit" name="editnetwork" value="Update"></td>
                            <td><a href="javascript:void(0)" onClick="delete_network()" id="delnetwork">Delete this network</a></td>
                            </tr>
                            
                            <tr><td colspan="4" height="10"></td></tr>
                            
                            <tr>
                            <td colspan="4"><a href="javascript:void(0)" onClick="add_domain()">Add new domain</a></td>
                            </tr>
                            
                            <tr><td colspan="4" height="10"></td></tr>
                            
                            <tr><td colspan="4">
                            
                             <?php if(isset($domains) && count($domains) > 0) { $i=1; ?>
                             <table id="domainlist">
							<?php foreach($domains as $key=>$dom) { ?>
							<tr>
                            <td class="<?=$dom['networkid']; ?>"><?=$dom['domainname']; ?></td>
                            <td class="<?=$dom['networkid']; ?> removedom"><a href="javascript:void(0)" onClick="remove_domain(<?=$key; ?>)">Remove</a></td>
                            </tr>
                            <?php $i++; } ?>
                            </table>
							<?php } ?>
                            
                            </td></tr>
                            </table>
                            
                            <input type="hidden" id="hidnetid" name="hidnetid"> 
                            <input type="hidden" id="hidsnetstat" name="hidsnetstat" value="1"> 
                            <input type="hidden" id="hiddomid" name="hiddomid">
                            <input type="hidden" id="hiddomstat" name="hiddomstat" value="1"> 
                            </form>
                            </div>

                        </li>

                    	<li>

                        	<span><?php if(isset($domains)) echo count($domains); else echo 0; ?> Domains</span>

                            <a href="javascript:void(0)" id="moredomain">+ More Domains</a>
                            
                            <div id="light" class="white_content">
                            <a href="javascript:void(0)" class="closepopup">Close</a>
                            
                            <b>How would you like to add more domains?</b><br><br>
                            <form id="addnewdomain" name="addnewdomain" action="<?php echo base_url()?>networkmanager/adddomain" method="post" enctype="multipart/form-data">
                            <table>
                            <tr>
                            <td>Assign to a network</td>
                            <td colspan="2"><select id="selectnetwork" name="selectnetwork">
                            <?php if(isset($networks) && count($networks) > 0) {
							foreach($networks as $key=>$netwrk) { ?>
                            <option value="<?=$key; ?>"><?=$netwrk['networkname']; ?></option>
                            <?php } } ?>
                            </select></td>
                            </tr>
                            <tr>
                            <td>Type of site</td>
                            <td colspan="2"><select id="selectblogtype" name="selectblogtype">
                            <option value="Blog+">Blog+</option>  
                            <option value="Traditional Blog">Traditional Blog</option>
                            <option value="HPBL">HPBL</option>
                            <option value="Mini Money">Mini Money</option>
                            </select></td>
                            </tr>
                            <tr><td colspan="3" height="10"></td></tr>
                            <tr>
                            <td>Domain Name</td>
                            <td>User Name</td>
                            <td>Password</td>
                            </tr>
                            
                            <?php for($i=1; $i<=10; $i++) { ?>
                            <tr>
                            <td><input type="text" id="domainname<?=$i; ?>" name="domainname<?=$i; ?>"></td>
                            <td><input type="text" id="username<?=$i; ?>" name="username<?=$i; ?>"></td>
                             <td><input type="password" id="password<?=$i; ?>" name="password<?=$i; ?>"></td>
                             </tr>
                            <?php } ?>
                            
                        <tr><td colspan="3" height="10"></td></tr>
                        
                            <tr>
                            <td>Need to upload in bulk?</td>
                            <td><input type="file" id="domainlist" name="domainlist"></td>
                            <td>
                            <!--<a href="javascript:void(0)" id="uploadfile">Upload</a>
                            <p id="uploaded">File Uploaded</p>-->
                            </td>
                            </tr>
                            <tr>
                            <td colspan="3"><br><br>
                                <table id="viewlist">
                               
                                </table>
                            </td>
                            </tr>
                            <tr>
                            <td colspan="3"><input type="submit" name="adddomain" value="Submit"></td>
                            </tr>
                            </table>
                            </form>
                            </div>
                            
                        </li>

                    	<li>

                        	<span><?php if(isset($posts['count'])) echo $posts['count']; ?> Posts</span>

                            <a href="<?php echo base_url()?>scrapper">+ New Posts</a>

                        </li>

                    	<li>

                        <span><?php if(isset($posts['countlink'])) echo $posts['countlink']; ?> Links</span>

                        <a href="javascript:void(0)" id="searchlinks">+ Edit Links</a>

                        <div id="editlinks" class="white_content">
                        <a class="closepopup" href="javascript:void(0)">Close</a>
                         <table id="">
                             <tr>
                              <td colspan="2" height="10" style="text-align:left"><b>Search and edit Anchors and/or Links...</b><br><br></td>            
                             </tr>
                             <tr><td height="10" colspan="2">
                             <div class="searchtype"> Search By &nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="checkbox" class="searchtype" name="searchbydomain" value="domains" onClick="jQuery('input[name=searchbyanchor]').removeAttr('checked')"> &nbsp;Link &nbsp;&nbsp; / 
                              &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="searchtype" name="searchbyanchor" value="anchors" onClick="jQuery('input[name=searchbydomain]').removeAttr('checked')"> &nbsp;Anchor
                              </div>
                             </td></tr>        
                             <tr>
                              <td width="150"> <input type="text" name="searchdata" id="searchdata"></td>
                              <td><input type="submit" id="searchby" name="searchby" value="Search" /></td>
                             </tr>						  
                        </table>
                        </div>
                        
                        </li>
                    </ul>

                    <br class="spacer">

                    <div class="overview_buttom clearfix">

                    	<a href="javascript:void(0)" id="togglesettings">Network Settings</a>
                        
                        <span>
                        
                        <?php $month = array();
						$getdt = array();
						foreach($domains as $dom) {
							$getdt = explode("/",$dom['domainexpiry']);
							$dt = $getdt[1]."-".$getdt[0]."-".$getdt[2];
							$month[] = date('M', strtotime($dt));
						}
						
						if(count($month) > 0)
						{
						$monthcount = array_count_values($month);
						
						$month1 = 0;
						$month2 = 0;
						$month3 = 0;
						
						if(isset($monthcount[date('M')]))
						$month1 = $monthcount[date('M')];
						
						if(isset($monthcount[date('M', strtotime("+1 month"))]))
						$month2 = $monthcount[date('M', strtotime("+1 month"))];
						
						if(isset($monthcount[date('M', strtotime("+2 month"))]))
						$month3 = $monthcount[date('M', strtotime("+2 month"))];

						echo "Domain Renewals: ";
						echo $month1." (".date('M').") ";
						echo $month2." (".date('M', strtotime("+1 month")).") ";
						echo $month3." (".date('M', strtotime("+2 month")).")"; } ?>
                        
                        </span>
                        
                        <br class="spacer">
                        
                        <div id="netsettings" class="white_content">
                        <a href="javascript:void(0)" id="closenetsettings" class="nobackground">Close</a>
                        
                        <form id="netwrksettings" name="netwrksettings" action="<?php echo base_url();?>networkmanager/updatesettings" method="post">
                        <table id="networksettings">
                        <tr>
                       <td><b>Default Blog Type</b> <br /><br />
                           <ul>  
                           <li><input type="radio" name="defaultblog" value="Blog+" />&nbsp;&nbsp;Blog+</li>
                           <li><input type="radio" name="defaultblog" value="Traditional Blog" checked="checked" />&nbsp;&nbsp;Traditional Blog</li>
                           <li><input type="radio" name="defaultblog" value="HPBL" />&nbsp;&nbsp;HPBL</li>
                           <li><input type="radio" name="defaultblog" value="Mini Money" />&nbsp;&nbsp;Mini Money</li>
                           </ul>
                       </td>
                       </tr>
                       <tr>
                        <td><b>Default Network</b> <br /><br />
                            <table class="defaultnetwks">
                            <?php if(isset($networks) && count($networks) > 0) { $i=1;
							foreach($networks as $key=>$netwrk) { 
							
							if($i==4)
								{
								echo '</tr>';
								$i=1;
								}
								
								if($i==1)
								echo '<tr>'; ?>
                            
                            <td><input type="radio" name="defaultnetwork" value="<?=$key; ?>" />&nbsp;&nbsp; <?=$netwrk['networkname']; ?> </td>
                            
                            <?php $i++; }} ?>
                            </table>
                            </td>
                        </tr>
                        <tr>
                        <td><b>Index Frequency</b> <br /><br />
                            <ul>
                            <li><input type="radio" name="indexfrequency" value="Weekly" />&nbsp;&nbsp;Weekly</li>
                            <li><input type="radio" name="indexfrequency" value="Monthly" checked="checked" />&nbsp;&nbsp;Monthly</li>
                            <li><input type="radio" name="indexfrequency" value="Never" />&nbsp;&nbsp;Never</li>
                            </ul>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <b>Automatically Pause Posting If</b> <br /><br />
                        <ul>
                          <li><input type="checkbox" name="unindexed" value="Unindexed" />&nbsp;&nbsp;Domain Not Indexed</li>
                          <!--<li><input type="checkbox" name="sitedown" value="Site down" />&nbsp;&nbsp;Site Down</li>-->
                          <li><input type="checkbox" id="lesspr" name="lesspr" value="Pagerank" />&nbsp;&nbsp;PageRank < </li>
                          <li><input type="text" id="pr" name="pr" maxlength="3" style="width:40px; height:20px; line-height:10px;" disabled /></li>
                        </ul>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <b style="float:left">Ahrefs Backlink Data</b> 
                        <a href="<?php echo base_url(); ?>networkmanager/ahrefsdata" class="nobackground actvahrefs">Activate</a>
                        <span class="activated">(Congrats, account authorized)</span><br /><br />
                        <ul class="backlinkdata">
                        <li><input type="checkbox" name="backlinkcount" value="1" />&nbsp;&nbsp;Backlink Count</li>
				        <li><input type="checkbox" name="domainrank" value="1" />&nbsp;&nbsp;Ahrefs Domain Rank</li>
                        <li><input type="checkbox" name="referringdomains" value="1" />&nbsp;&nbsp;Referring Domains</li>
                       </ul>
                       </td>
                        </tr>
                        <tr class="backlinkdata">
                       <td>
                       <b>Ahrefs Frequency</b> <br /><br />
                       <ul>
                       <li><input type="radio" name="ahrefsfrequency" value="Once" checked="checked" />&nbsp;&nbsp;Once</li>
                       <li><input type="radio" name="ahrefsfrequency" value="Weekly" />&nbsp;&nbsp;Weekly</li>
                       <li><input type="radio" name="ahrefsfrequency" value="Monthly" />&nbsp;&nbsp;Monthly</li>
                       <li><input type="radio" name="ahrefsfrequency" value="Never" />&nbsp;&nbsp;Never</li>
                       <li><a href="<?php echo base_url(); ?>networkmanager/check_ahrefs_now/true" class="nobackground">Update now</a></li>
                       </ul>
                       </td>
                       </tr>
                       <tr>
                        <td><b>Pagerank</b> <br /><br />
                        <ul>
                        <li><input type="radio" name="pagerank" value="Once" checked="checked" />&nbsp;&nbsp;Once</li>
                         <li><input type="radio" name="pagerank" value="Monthly" />&nbsp;&nbsp;Monthly</li>
                         <li><input type="radio" name="pagerank" value="Never" />&nbsp;&nbsp;Never</li>
                        <li><a href="<?php echo base_url(); ?>networkmanager/check_pr_now/true" class="nobackground">Update Now</a></li>
                        </ul>
                        </td>
                        </tr>
                        </table>
                        </form>
                        </div>
                    </div>

                </div>

            </div>

        	<div class="top3">
            
            <?php $type = array();
			foreach($domains as $doms) {
				$type[] = $doms['blogtype'];
			}
			
			$tradblog = 0;
			$blog = 0;
			$hpbl = 0;
			$minmoney = 0;
			
			if(count($type) > 0)
			{
			$blogtype = array_count_values($type);
						
			if(isset($blogtype['Traditional Blog']))
			$tradblog = $blogtype['Traditional Blog'];
			
			if(isset($blogtype['Blog+']))
			$blog = $blogtype['Blog+'];
			
			if(isset($blogtype['HPBL']))
			$hpbl = $blogtype['HPBL'];
			
			if(isset($blogtype['Mini Money']))
			$minmoney = $blogtype['Mini Money']; } ?>

            	<ul>
                	<li>Traditional Blog  (<?=$tradblog; ?>)</li>

                	<li>Blog + Booster (<?=$blog; ?>)</li>

                	<li>HPBL (others) (<?=$hpbl; ?>)</li>

                	<li>Mini Money Site (<?=$minmoney; ?>)</li>
                </ul>

                <div class="top3_right">

                	<!--<img src="<?php //echo base_url()?>assets/images/img9.png" alt="no img"/>-->
                    
                    <canvas id="canvas" height="73" width="73"></canvas>
    
					<script>
					 var pieData = [
						{
							//Traditional Blog
							value: <?=$tradblog; ?>,
							color:"#FBB52F"
						},
						{
							//Blog +
							value : <?=$blog; ?>,
							color : "#6F98AE"
						},
						{
							//HPBL
							value : <?=$hpbl; ?>,
							color : "#00275E"
						},
						{
							//Mini Money
							value : <?=$minmoney; ?>,
							color : "#87AE00"
						}		
					];
                    var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
                    </script>

                    <a href="javascript:void(0)" id="addcategory">+Add Custom Category</a>

                </div>

            </div>

            <br class="spacer">

        </div>
        
        <?php if($this->session->flashdata('message')) { 
		echo $this->session->flashdata('message'); } ?>    
        
        <?php if(isset($_REQUEST['searchanchor']) && $_REQUEST['searchanchor'] == "anchors") { ?>
        
        <div class="network_buttom box_two" style="text-align:center">
         <table class="" id="" width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <th>Post URL</th>

                        <th>Date Posted</th>

                        <th>Anchor / Link ID</th>

                        <th>Anchor</th>

                        <th>Link</th>
                        
                        <th>Select All &nbsp;&nbsp;<input type="checkbox" id="select_all_posts"></th>

                      </tr>
                      
                    <?php  $count = 0;
					if(isset($postsearch) && count($postsearch) > 0) { 
					foreach($postsearch as $psearch) {
					$count++; ?>

                      <tr>

                        <td><?=$psearch['domainname']."/".$psearch['post']; ?></td>
                        
                        <td><?=$psearch['postdate']; ?></td>

                        <td><?=$psearch['type']; ?></td>
                        
                        <td>
                        
                         <div id="anchor<?=$psearch['type']; ?>_<?=$psearch['pid']; ?>" onClick="update_links(<?=$psearch['pid']; ?>,'anchor<?=$psearch['type']; ?>','<?=$psearch['anchor']; ?>');"><?=$psearch['anchor']; ?></div>

                        </td>

                        <td>

                         <div id="link<?=$psearch['type']; ?>_<?=$psearch['pid']; ?>" onClick="update_links(<?=$psearch['pid']; ?>,'link<?=$psearch['type']; ?>','<?=$psearch['link']; ?>');"><?=$psearch['link']; ?></div>

                        </td>
                        
                        <td><input type="checkbox" name="post_<?=$count; ?>" value="<?=$psearch['pid']; ?>" typevals="<?=$psearch['type']; ?>"></td>

                      </tr>
                      
                      <?php } } ?>

                    </table>
                     <a href="javascript:void(0)" id="edit">Edit Anchor / Links</a>
                    </div>
      
        <?php } elseif(isset($_REQUEST['editlink']) && $_REQUEST['editlink'] == 1) { ?>
        
        <div class="network_buttom box_two" style="text-align:center">
         <table class="" id="" width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <th>Post URL</th>

                        <th>Date Posted</th>

                        <th> <?php if(isset($_REQUEST['anchor'])) echo "Anchor"; 
						if(isset($_REQUEST['domain'])) echo "Link"; ?> ID</th>

                        <th>Anchor</th>

                        <th>Link</th>

                        <th>Select All &nbsp;&nbsp;<input type="checkbox" id="select_all_posts"></th>

                      </tr>
                      
                    <?php  $count = 0;
					if(isset($postarr) && count($postarr) > 0) { 
					foreach($postarr as $postr) {
					$count++; ?>

                      <tr>

                        <td><?=$postr['domainname']."/".$postr['post']; ?></td>
                        
                        <td><?=$postr['postdate']; ?></td>

                        <td><?=$postr['type']; ?></td>
                        
                        <td align="center">
                        <div id="anchor<?=$postr['type']; ?>_<?=$postr['pid']; ?>" onClick="update_links(<?=$postr['pid']; ?>,'anchor<?=$postr['type']; ?>','<?=$postr['anchor']; ?>');"><?=$postr['anchor']; ?></div>
                        </td>

                        <td>
                        
                        <div id="link<?=$postr['type']; ?>_<?=$postr['pid']; ?>" onClick="update_links(<?=$postr['pid']; ?>,'link<?=$postr['type']; ?>','<?=$postr['link']; ?>');"><?=$postr['link']; ?></div>
                        
                        </td>

                        <td><input type="checkbox" name="post_<?=$count; ?>" value="<?=$postr['pid']; ?>" typevals="<?=$postr['type']; ?>"></td>

                      </tr>
                      
                      <?php } } ?>

                    </table>
                    <a href="javascript:void(0)" id="edit">Edit Anchor / Links</a>
                    </div>
                             
                    <?php } else { ?>

        <div class="network_buttom">

            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="">
            <thead>
              <tr class="rowhead">

                <th>Network</th>

                <th>Type</th>

                <th>CMS</th>

                <th>Domain</th>

                <th>PR</th>

                <th>Age</th>

                <th>IP Address</th>

                <th>NameServer</th>

                <th>Posts</th>

                <th>Updated</th>

                <th>Registar</th>

                <th>Expires</th>

                <th>OBL</th>

                <?php if(isset($networksetting['backlinkstat']) && $networksetting['backlinkstat'] == 1) { ?>
                
                <?php if(isset($networksetting['backlinkcount']) && $networksetting['backlinkcount'] == 1) { ?>
                <th>Backlinks</th>
                <?php } ?>
                
                <?php if(isset($networksetting['domainrank']) && $networksetting['domainrank'] == 1) { ?>
                <th>Domain Rank</th>
                <?php } ?>

                <?php if(isset($networksetting['referringdomains']) && $networksetting['referringdomains'] == 1) { ?>
                <th>Referring Domains</th>
                <?php }} ?>

                <th>User</th>

                <th>Pass</th>

                <th><img src="<?php echo base_url()?>assets/images/img19.png" alt="no img"/></th>

                <th>Login</th>

                <th>Pause</th>

                <th>Index</th>

                <th>&nbsp;</th>

                <th><img src="<?php echo base_url()?>assets/images/img18.png" alt="no img" id="delete_domain" /></th>
                
                <?php if(isset($category) && count($category) > 0) { 
				foreach($category['catname'] as $catg) { ?>
                <th><?=$catg['categoryname'] ;?></th>
                <?php }} ?>

              </tr>
              </thead>
              <tbody>
             <?php 
			 $range = 10;
			 $start = 1;
			 $end = $range;
			 
			 if(isset($retarr) && count($retarr) > 0) {
			 if(isset($_GET['show'])) {

				  if($_GET['show'] == "all")
				  {
					 $end = count($retarr);
				  }
				  else
				  {
						$end = $_GET['show'];
						$start = $end + 1;
						$end = $end + $range;
						
					  if($start > count($retarr))
					   redirect('networkmanager');
				  }
			}}
			 
			 if(isset($retarr) && count($retarr) > 0) { $cnt=0;
			 
			 $sortarr = $retarr;
			 krsort($sortarr);
			 
			 foreach($sortarr as $key=>$arr) { $cnt++;
			 
			 if($cnt >= $start && $cnt <= $end) { ?>
             
              <tr>

                <td><?=$arr['networkname']; ?><!--<img src="<?php //echo base_url(); ?>images/img21.png" alt="no img"/>--></td>

                <td><?=$arr['type']; ?></td>

                <td><img src="<?php echo base_url()?>assets/images/img23.png" alt="no img"/></td>

                <td><?=$arr['domain']; ?></td>

                <td><?=$arr['pagerank']; ?><!--4(4)--></td>

                <td><?=$arr['age']; ?> yrs</td>

                <td><?=$arr['domainip']; ?></td>

                <td><?=$arr['dns']; ?></td>

                <td><?php if(isset($arr['postdetail'])) echo count($arr['postdetail']); else echo 0; ?></td>

                <td>
				
				<?php if(isset($arr['postdetail']) && count($arr['postdetail']) > 0) {
					
				$dt = array();
                
                foreach($arr['postdetail'] as $postdetail)
                 $dt[] = $postdetail['postmodified'];
				 
				 $max = max(array_map('strtotime', $dt));
                 echo date('m/d/Y', $max); } ?>

                </td>

                <td><?=$arr['domainregistrar']; ?></td>

                <td><?=$arr['domainexpiry']; ?></td>

                <td><?=$arr['obl']; ?></td>

                 <?php if(isset($networksetting['backlinkstat']) && $networksetting['backlinkstat'] == 1) { ?>
                    
                 <?php if(isset($networksetting['backlinkcount']) && $networksetting['backlinkcount'] == 1) { ?>
                 <td><?=$arr['backlinks']; ?></td>
                 <?php } ?>
                 
                 <?php if(isset($networksetting['domainrank']) && $networksetting['domainrank'] == 1) { ?>
                 <td><?=$arr['domainrank']; ?></td>
                 <?php } ?>
                 
                 <?php if(isset($networksetting['referringdomains']) && $networksetting['referringdomains'] == 1) { ?>
                 <td><?=$arr['referringdomains']; ?></td>
                 <?php }} ?>

                <td id="u_<?=$key; ?>" onClick="edit_login_data('<?=$key; ?>','username')">
                
                <img src="<?php echo base_url()?>assets/images/img20.png" alt="no img" id="username_<?=$key; ?>" class="star" />
                
                <input type="text" id="edit_username_<?=$key; ?>" name="edit_username_<?=$key; ?>" value="<?=$arr['username']; ?>" onBlur="update_login_data(<?=$key; ?>,'username')">
                <input type="hidden" id="hid_username_<?=$key; ?>" name="hid_username_<?=$key; ?>" value="<?=$arr['username']; ?>">
                
                </td>

                <td id="p_<?=$key; ?>" onClick="edit_login_data('<?=$key; ?>','password')">
                
                <img src="<?php echo base_url()?>assets/images/img20.png" alt="no img" id="password_<?=$key; ?>" class="star"/>
                
                <input type="text" id="edit_password_<?=$key; ?>" name="edit_password_<?=$key; ?>" value="<?=$arr['password']; ?>" onBlur="update_login_data(<?=$key; ?>,'password')">
                <input type="hidden" id="hid_password_<?=$key; ?>" name="hid_password_<?=$key; ?>" value="<?=$arr['password']; ?>">
                
                </td>

                <td>

                <?php if($arr['valid_credentials']) $img="img19.png"; else $img="img18.png"; ?>
                
                <img src="<?php echo base_url()?>assets/images/<?=$img; ?>" alt="no img"/>

                </td>

                <td><button class="go"></button></td>

                <td><button class="pause" id="pause<?=$key; ?>" onClick="pause_posting(<?=$key; ?>)"></button></td>

                <td>

                <?php if($arr['indexed']) $img="img19.png"; else $img="img18.png"; ?>
                
                <img src="<?php echo base_url()?>assets/images/<?=$img; ?>" alt="no img"/>
                
                </td>

                <td><button class="toggle_button" id="toggle<?=$cnt; ?>" onClick="toogle_sub(<?=$cnt; ?>)"></button></td>

                <td><input type="checkbox" name="record_<?=$key; ?>" value="<?=$key; ?>"></td>
                
                 <?php if(isset($category) && count($category) > 0) { 
				foreach($category['catname'] as $catg) { ?>
                <td>
                <?php foreach($category['catvalue'] as $catgry)
				{
					if($catgry['domainid'] == $key) {
						if($catgry['categoryname'] == $catg['categoryname'])
						{
						  if(trim($catgry['categoryvalue']) == "")
						  { 
						  $string = $catgry['domainid'].'_'.$catgry['categoryname'];
						  $id = str_replace(" ","-",$string); ?>
                             <p class="custcategory" onClick="edit_category('<?=$id; ?>')">Click to Enter Value</p>
                             
                             <div class="editcustcategory" id="<?=$id; ?>">
                             <form action="<?php echo base_url() ?>networkmanager/updatecategory/<?=$id; ?>" method="post">
                                 <input type="text" name="<?=$id.'_txt'; ?>">
                                 <input type="submit" name="<?=$id.'_btn'; ?>" value="Save">
                             </form>
                             </div>
							 
						  <?php }
						  else
						     echo $catgry['categoryvalue'];
						}
					}
				} ?>
                </td>
                <?php }} ?>

              </tr>

             <!-- post popup-->
             
              <?php if(isset($arr['postdetail']) && count($arr['postdetail']) > 0) { ?>
              <tr>

                <td colspan="21">

                   <table class="toggle_box" id="toggle_box<?=$cnt; ?>" width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <th>Post URL</th>

                        <th>Created</th>

                        <th>Updated</th>

                        <th>Hp</th>

                        <th>Sc</th>

                        <th>Comments</th>

                        <th>OBL</th>

                        <th>Anchor 1</th>

                        <th>Link 1</th>

                        <th>Anchor 2</th>

                        <th>Link 2</th>

                        <th>Anchor 3</th>

                        <th>Link 3</th>

                        <th>Save</th>

                        <th>Promote</th>

                        <th>
                        <img src="<?php echo base_url() ?>assets/images/img18.png" alt="no img" class="cross" onClick="jQuery('.toggle_box').hide();"/>
                        Select All &nbsp;&nbsp;<input type="checkbox" id="select_all_posts_<?=$cnt; ?>" onClick="select_posts(<?=$cnt; ?>)">
                        </th>

                      </tr>
                      
                    <?php  $count = 0;
					foreach($arr['postdetail'] as $postdetail) { 
					$count++; ?>

                      <tr>

                        <td><?=$postdetail['posturl']; ?><!--/how-to-unlock-872--></td>

                        <td><?=$postdetail['postcreated']; ?></td>

                        <td><?=$postdetail['postupdated']; ?></td>

                        <td><?=$postdetail['hp']; ?></td>

                        <td><?=$postdetail['sc']; ?></td>

                        <td><?=$postdetail['comments']; ?></td>

                        <<td><?=$postdetail['obl']; ?></td>

                        <td>
                        
                        <div id="anchor1_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'anchor1','<?=$postdetail['anchor1']; ?>');"><?=$postdetail['anchor1']; ?></div>
                        
                        </td>

                        <td><?=$postdetail['link1']; ?>
                        
                        <div id="link1_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'link1','<?=$postdetail['link1']; ?>');"><?=$postdetail['link1']; ?></div>
                        
                        </td>

                        <td>
                        
                        <div id="anchor2_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'anchor2','<?=$postdetail['anchor2']; ?>');"><?=$postdetail['anchor2']; ?></div>
                        
                        </td>

                        <td>
                        
                        <div id="link2_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'link2','<?=$postdetail['link2']; ?>');"><?=$postdetail['link2']; ?></div>
                        
                        </td>

                        <td>
                        
                         <div id="anchor3_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'anchor3','<?=$postdetail['anchor3']; ?>');"><?=$postdetail['anchor3']; ?></div>
                        
                        </td>

                        <td>
                        
                        <div id="link3_<?=$postdetail['postid']; ?>" onClick="update_links(<?=$postdetail['postid']; ?>,'link3','<?=$postdetail['link3']; ?>');"><?=$postdetail['link3']; ?></div>
                        </td>

                       <td><button class="save">Save</button></td>

                        <td>Select Date</td>

                        <td><input type="checkbox" name="post_<?=$cnt."_".$count; ?>" value="<?=$postdetail['postid']; ?>"></td>

                      </tr>
                      
                      <?php } ?>

                    </table>
                    <a href="javascript:void(0)" id="edit">Edit Anchor / Links</a>
                    </td>

              </tr>
              
              <?php } } } } ?>

              </tbody>
            </table>	
   
             </div>
             
             <?php } ?>
             
             
             <?php if(isset($_REQUEST['editlink']) || isset($_REQUEST['searchanchor']))
			 {
			   $editlink = true;
			   $action_path = "update_anchor_link";
			 }
			 else
			 {
			   $editlink = false;
			   $action_path = "article_update";
			 } ?>

             <div id="anchor_reset" class="white_content">
                <a class="closepopup nobackground" href="javascript:void(0)" style="color:#ee7f02">Close</a>
                <form name="anchorreset" action="<?php echo base_url() ?>networkmanager/<?=$action_path; ?>" method="post">
                 <table id="">
                     <tr>
                      <td colspan="4" height="10" style="text-align:left"><b>Update Links & Anchors...</b><br><br></td>            
                     </tr>
                     <tr><td height="10" colspan="4"></td></tr>        
                     <tr>
                      <td><?php if($editlink) echo "Anchor"; else echo "Anchor 1"; ?>:</td><td><input type="text" name="anchor1" value=""></td>
                      <td><?php if($editlink) echo "Link"; else echo "Link 1"; ?>:</td><td><input type="text" name="link1" value=""></td>
                     </tr>
                     <tr><td height="10" colspan="4"></td></tr>
                     <?php if(!$editlink) { ?>
                     <tr>
                      <td>Anchor 2:</td><td><input type="text" name="anchor2" value=""></td>
                      <td>Link 2:</td><td><input type="text" name="link2" value=""></td>
                     </tr>
                     <tr><td height="10" colspan="4"></td></tr>
                     <tr>
                      <td>Anchor 3:</td><td> <input type="text" name="anchor3" value=""></td>
                      <td>Link 3:</td><td> <input type="text" name="link3" value=""></td>
                     </tr>
                     <?php } ?>
                     <input type="hidden" id="ids" name="ids">
                     <input type="hidden" id="typesvals" name="typesvals">
                     
                     <?php if(isset($_REQUEST['anchor'])) {
						 echo '<input type="hidden" id="searchedby" name="searchedby" value="anchor">';
						 } 
						 elseif(isset($_REQUEST['domain'])) {
							echo '<input type="hidden" id="searchedby" name="searchedby" value="link">'; } ?>

                     <tr><td colspan="4" height="10"><br><br><input type="submit" id="update_anchor" name="submit" value="Update" /></td></tr>							  
                </table>
                </form>
            </div>

      </div>
    </section>

    <div class="show_all"><a href="javascript:void(0)" onClick="show_next('all')">Show All</a> | 
    <a href="javascript:void(0)" onClick="show_next(<?=$end; ?>)"> Show Next 10</a>
    </div>

  </section>
</section>

<?php $this->load->view('frontend/footer');?>
