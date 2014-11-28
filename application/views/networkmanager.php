<?php $this->load->helper('url');
$this->load->helper('text');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">
    <title>Welcome</title>
   <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
   <!--<script type="text/javascript" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>-->
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.dataTables.css" media="screen" />
    <!-- Main CSS SETTINGS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/grey.css" >
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">

<!--   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/site.js"></script>-->
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="http://legacy.datatables.net/extras/thirdparty/ColReorderWithResize/ColReorderWithResize.js"></script>

  
<script src="<?php echo base_url(); ?>assets/js/jquery.datatables.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ColResize.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.jeditable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.blockui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.4.js"></script>

    <!-- font -->
 
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css"> -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
 <script src="<?php echo base_url(); ?>js/icheck.js"></script>
<?php $pauseindx = "";
if(isset($retarr) && count($retarr) > 0) {
  foreach($retarr as $key=>$arr) {
  if(!$arr['status'])
  $pauseindx .= $key.",";
  }
  $pauseindx = rtrim($pauseindx,",");
  } 
  
    if(isset($domains) && count($domains) > 0) {
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
<script language="javascript" type="text/javascript"> 

function scrollmain(){
$(".network_buttom").scrollLeft(500);
}
/* Formatting function for row details - modify as you need */
function format (d) {
  //alert(d);
    j = JSON.parse(d);
    var b = Object.keys(j);
    //alert(b.length);
    var newrow = '';
    for (i=0; i< b.length; i++){ 
        //alert(j[b[i]].anchor1);
        newrow += '<tr>'+
                                    '<td>'+j[b[i]].posturl+'</td>'+
                                    '<td>'+j[b[i]].postcreated+'</td>'+
                                    '<td>'+j[b[i]].postupdated+'</td>'+
                                    '<td>'+j[b[i]].hp+'</td>'+
                                    '<td>'+j[b[i]].sc+'</td>'+
                                    '<td>'+j[b[i]].comments+'</td>'+
                                    '<td>'+j[b[i]].obl+'</td>'+
                                    '<td><div id="anchor1_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'anchor1\',\''+j[b[i]].anchor1+'\');">'+j[b[i]].anchor1+'</div></td>'+
                                    '<td><div id="link1_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'link1\',\''+j[b[i]].link1+'\');">'+j[b[i]].link1+'</div></td>'+
                                    '<td><div id="anchor2_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'anchor2\',\''+j[b[i]].anchor2+'\');">'+j[b[i]].anchor2+'</div></td>'+
                                    '<td><div id="link2_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'link2\',\''+j[b[i]].link2+'\');">'+j[b[i]].link2+'</div></td>'+
                                    '<td><div id="anchor3_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'anchor3\',\''+j[b[i]].anchor3+'\');">'+j[b[i]].anchor3+'</div></td>'+
                                    '<td><div id="link3_'+j[b[i]].postid+'" onClick="update_links('+j[b[i]].postid+',\'link3\',\''+j[b[i]].link3+'\');">'+j[b[i]].link3+'</div></td>'+
                                    '<td align="center"><img src="<?php echo base_url(); ?>images/save-icon.gif" width="12" height="12" alt=""></td>'+
                                    '<td><span class="label label-success">'+j[b[i]].post_status+'</span></td>'+
                                  '</tr>';
    }
    
    // `d` is the original data object for the row
    return '<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="table table-hover tablesorter pop_table" id="myTable">'+
                                  '<thead>'+
                                    '<th>Post URL</th>'+
                                    '<th>Created</th>'+
                                    '<th>Updated</th>'+
                                    '<th>HP</th>'+
                                    '<th>SC</th>'+
                                    '<th>Comments</th>'+
                                    '<th>OBL</th>'+
                                    '<th>Anchor&nbsp;1</th>'+
                                    '<th>Link&nbsp;1</th>'+
                                    '<th>Anchor&nbsp;2</th>'+
                                    '<th>Link&nbsp;2</th>'+
                                    '<th>Anchor&nbsp;3</th>'+
                                    '<th>Link&nbsp;3</th>'+
                                    '<th>Save</th>'+
                                    '<th>Status</th>'+
                                  '</thead>'+
                                  '<tbody>'+newrow+
                                  '</tbody>'+
                                  '</table>';
//    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
//        '<tr>'+
//            '<td>Full name:</td>'+
//            '<td>'+d+'</td>'+
//        '</tr>'+
//        '<tr>'+
//            '<td>Extension number:</td>'+
//            '<td>'+d.extn+'</td>'+
//        '</tr>'+
//        '<tr>'+
//            '<td>Extra info:</td>'+
//            '<td>And any further details here (images etc)...</td>'+
//        '</tr>'+
//    '</table>';
}
  </script>
  <script>
$(document).ready(function(){

  var table = jQuery('#example').DataTable( {
        dom: 'Rlfrtip',
		 "order": [[ 0, "desc" ]]
    } );

//  jQuery('.details-control').click(function(){
//      alert('hiii');
//                var tr = $(this).closest('tr');
//                var row = table.row( tr );
//
//                if ( row.child.isShown() ) {
//                    // This row is already open - close it
//                    row.child.hide();
//                    tr.removeClass('shown');
//                }
//                else {
//                    // Open this row
//                    row.child( format(row.data()) ).show();
//                    tr.addClass('shown');
//                }
//      });
    
  // Add event listener for opening and closing details
   $('#example tbody').on('click', 'img.details-control', function () {
        var tr = $(this).closest('tr');
        var thisid = tr.attr("id");
      //  alert(thisid);
       
        var popupdata = $("#"+thisid+"_popup").val();
        //alert('kk');
       // alert(popupdata);
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(popupdata) ).show();
            tr.addClass('shown');
        }
    } );
    
$('#addcategory').click(function(){
$(".network_buttom").scrollLeft( 0 );
$('#rowhead').append('<th><form action="<?php echo base_url()?>index.php/networkmanager/addcategory" method="post"><input type="text" name="newcategory" placeholder="Enter Category Name"><input type="submit" value="Save"></form></th>');
        });
    
    var pindx = "<?=$pauseindx; ?>";
    if(pindx != "")
    {
        var arr = pindx.split(",");
        
        for(var i=0;i<arr.length;i++)
        
        $("#pause"+arr[i]).css("background","#cc0d0d").css("color","#fff");
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
        $("#moredomains").css("display","block");
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
$("#searchbtn").click(function(){

      if(!$("input[name=searchdomain]").is(":checked") && !$("input[name=searchanchor]").is(":checked"))
      {

        alert('Select search type');
        $(".searchtype").css("border","none");
        return false;
      }
      else if($.trim($("#search").val()) == "")
      {
        alert("Enter search string");
        $(".top1_up #search").css("border","none");
        return false;
      }
      else
        return true;
  });


     $("#searchby").click(function(){
      if(!$("input[name=searchbydomain]").is(":checked") && !$("input[name=searchbyanchor]").is(":checked"))
      {
        alert("Select search by");
        $(".searchtype").css("border","none");
        return false;
      }
      else if($.trim($("#searchdata").val()) == "")
      {
        alert("Enter search string");
        $(".top2 #searchdata").css("border","none");
        return false;
      }
      else
      {
        if($('input[name=searchbydomain]').is(":checked"))
         query = "domain=";
        
        if($('input[name=searchbyanchor]').is(":checked"))
         query = "anchor=";
         
         window.location="<?php echo base_url()?>index.php/networkmanager?editlink=1&" + query + $('#searchdata').val();
         
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
         window.location="<?php echo base_url()?>index.php/networkmanager";
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
                    $.post("<?php echo base_url() ?>index.php/networkmanager/deletedomain", {domid:ids}, function(data){
                         window.location="networkmanager";
                    });
                }
            }
        });
		
		$('#domain_no').blur(function () {
		if($('#domain_no').val() >= 5)
		{
		   $('input[name=new_domain_no]').val($('#domain_no').val());
		}
		else
		   alert('You must purchase a minimum of 5 domains');
		});
		
});
function removeColom(elem,name){
			
			var stat = window.confirm('Delete Columns(s)?');
			if(stat){
					$.post("<?php echo base_url() ?>index.php/networkmanager/DeleteColom", {name:name}, function(data){
					window.location.href="networkmanager?delete_column=yes";
					});
			}	
		}
function set_domain_val(domain_cost, package_id, permission_name, frm_id)
{
	if($('#domain_no').val() >= 5)
		{
		   var new_domain_no = $('input[name=new_domain_no]').val();

		   var total_cost = new_domain_no*domain_cost;
		   
		   $.post("<?php echo base_url() ?>index.php/networkmanager/add_user_permissions", {name:permission_name, cost:total_cost}, function(data){
	 
						 $('input[name=item_number]').val(data);
						 
						 $('input[name=a3]').val(total_cost);
	
	                     $('input[name=return]').val("http://serpavenger.com/serp_avenger/networkmanager/?custom="+package_id+"&domainno="+new_domain_no);
						 
						 $('#'+frm_id).submit();
                    });
		}
		else
		{
		   alert('You must purchase a minimum of 5 domains');
		}
}

function set_network_permission(permission_cost, permission_name, frm_id)
{
		   $.post("<?php echo base_url() ?>index.php/networkmanager/add_user_permissions", {name:permission_name, cost:permission_cost}, function(data){
			   
			  $('input[name=item_number]').val(data);
			   
			  $('#'+frm_id).submit();

               });								
}
        
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
    $.post('<?php echo base_url()?>index.php/networkmanager/pauseposting', { domid:id }, function(data){
        if(!data) {
             $("#pause"+id).css("background","#cc0d0d").css("color","#fff");
             jQuery('#tr_'+id).addClass('red-stripe-line');
        } 
        else { 
        
        $("#pause"+id).css("background","#fff").css("border","1px solid rgb(221, 221, 221)").css("color","rgb(102, 102, 102)");
        jQuery('#tr_'+id).removeClass('red-stripe-line');
         }
        });
  }

function toogle_sub(cnt)
{
  $("#toggle_box"+cnt).toggle();
  //$('#myTable'+cnt).dataTable();
  /*if ( $.fn.dataTable.isDataTable( '#myTable'+cnt ) ) {
    //table = $('#example').DataTable();
  var oTable = $('#myTable'+cnt).dataTable();
    }
    else {
        
  var oTable = $('#myTable'+cnt).dataTable({ 
  
            "oLanguage": {
                            "oPaginate": {
                              "sNext": " Show Next ",
                              "sPrevious" : "Show Prev "
                            }
                          },
            "pagingType": "simple",
            "aLengthMenu": [
              [10, -1],
              [10, "All"]
          ], 


  "iDisplayLength" : 10 });
    }
    $('#show_nxt_10').click(function(e){
        oTable._iDisplayLength = 10;
         oTable.fnDraw(); 
     });*/
}

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
         $.post("<?php echo base_url() ?>index.php/networkmanager/update_login_data", {id:id, field_name:type, new_value:newval}, function(data){
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
	{
	  $("#editnetwork").hide();
      $("#delnetwork").hide();
	}
    else
	{
	  $("#editnetwork").show();
      $("#delnetwork").show();
	}
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
	$prvs_val  = $("#"+id+ "+p").html();
	$('#'+id+"_id").val($prvs_val);
	$("#"+id+ "+p").hide();
}
function SaveCategory(domain_id,cat_name,div_id)
{
	var comment = $('#'+div_id+"_id").val();
	 $.post("<?php echo base_url() ?>index.php/networkmanager/updatecategory", {id:domain_id, cat_name:cat_name, new_value:comment}, function(data){
             //window.location="networkmanager";
				//console.log(data);
				$("#"+div_id + "+p").html(comment);
				$("#"+div_id+ "+p").show();
				$("#"+div_id).hide();
        });
    
	return false;
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
    $('#'+field+'_'+id).html('<img src="<?php echo base_url()?>assets/images/loader.gif" border="0">');
    $.post( "<?php echo base_url()?>index.php/activesubmissions/update_link", { id:id, field_name:field, new_value:newlink}, function(data){
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
 
<?php if(!$permission) { ?>
var overlay = $('<div id="overlay"></div>');
overlay.show();
overlay.appendTo(document.body);
$('.popup').show();
<?php } ?>

}); 
</script>

<!-- Added by beas  Making Pop up -->
<style type="text/css">
#overlay {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-color: #000;
filter:alpha(opacity=70);
-moz-opacity:0.7;
-khtml-opacity: 0.7;
opacity: 0.7 !important;
z-index: 100;
display: none;
}
.cnt223 a{
text-decoration: none;
}
.popup{
width: 100%;
margin: 0 auto;
display: none;
position: fixed;
z-index: 101;
}
.cnt223{
min-width: 600px;
width: 600px;
min-height: 150px;
margin: 100px auto;
background: #f3f3f3;
position: relative;
z-index: 103;
padding: 10px;
border-radius: 5px;
box-shadow: 0 2px 5px #000;
}
.cnt223 p{
clear: both;
color: #555555;
text-align: justify;
}
.cnt223 p a{
color: #d91900;
font-weight: bold;
}
.cnt223 .x{
float: right;
height: 35px;
left: 22px;
position: relative;
top: -25px;
width: 34px;
}
.cnt223 .x:hover{
cursor: pointer;
}
</style>
                          
</head>
<?php if($_GET['delete_column']=='yes' || $_GET['add_category']=='yes'){ ?>
  <body onload="scrollmain()">  
<?php } ?>
<body>
  
  <?php if(!$permission) { ?>
  
  <!-- Added by beas  Making Pop up -->
	 <div class='popup'>
     <div class="modal-dialog cnt223">
      <div class="modal-content">
        <div class="modal-header popup-header">
          <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Upgrade Package</h4>
        </div>
        
          <h4>Please subscribe to get access to this section</h4>
             <table id="" width="" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive"> 
           <tr>
           <td>
<?php
//$fcnt = 1;
$pckgarr = array();

foreach($packages as $row)
{
	$pckgarr[$row['networkmanager_upgrade_cost']] = array('package_id' => $row['package_id'], 
	'package_name' => $row['package_name'], 
	'networkmanager_upgrade_cost' => $row['networkmanager_upgrade_cost']);
}

ksort($pckgarr);

foreach($pckgarr as $row){
?>

<!--<form name="_xclick" id="nw_permission"  action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<form name="_xclick" id="nw_permission" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">

<!--<input type="hidden" name="cmd" value="_xclick">-->
<input type="hidden" name="cmd" value="_xclick-subscriptions">

<!--<input type="hidden" name="business" value="billing@rpautah.com">-->
<input type="hidden" name="business" value="abhrabeas@gmail.com">

<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">

<!--<input type="hidden" name="no_note" value="1">-->
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="item_number">
<input type="hidden" name="item_name" value="<?=$row['package_name']; ?> - Network Manager Permission">
<!--<input type="hidden" name="amount">-->
<input type="hidden" name="a3" value="<?php echo $row['networkmanager_upgrade_cost']; ?>">
<!--<input type="hidden" name="discount_rate">-->
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
<input type='hidden' name='rm' value="0">
<input type="hidden" name="return" value="http://serpavenger.com/serp_avenger/networkmanager/?custom=<?=$row['package_id']; ?>">
<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_SM.gif:NonHostedGuest">
</form>

<br>
<input type="button" name="submit" value="UPGRADE NOW"
 onClick="set_network_permission('<?=$row['networkmanager_upgrade_cost']; ?>', '<?=$row['package_name']; ?> - Network Manager Permission', 'nw_permission')">
<br>
 
<?php break; } ?>
                    
        </td> 
      </tr>   
    </table>
      </div>
    </div>
    </div>
                        
<?php } ?>

    <div class="container">
        <div class="row" id="header">
            <div class="col-md-3 left-col">
                <div id="logo"><a href="<?php echo base_url()?>index.php/networkmanager"><img src="<?php echo base_url(); ?>images/logo.png" width="214" height="84" alt=""></a></div>
            </div>
          
            <div class="col-md-9 menusec right-col">
                <?php $this->load->view('includes/header'); ?>

                
                <nav class="mainmenu">
                    <ul id="menu">
                        <li><a href="<?php echo base_url()?>mypannel">My Panel </a></li>
                  <li><a href="<?php echo base_url()?>campaign">My Campaigns 
                  <!-- <i class="fa fa-caret-down"></i> --></a>
                            <!-- <ul>    
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                                <li><a href="#">item1</a></li>
                                <li><a href="#">item2</a></li>
                            </ul> -->
                        </li>
                      <li><a href="<?php echo base_url()?>ranking">Rankings</a></li>
                      <li><a href="<?php echo base_url()?>analysis">Analysis</a></li>
                      <li><a href="<?php echo base_url()?>networkmanager">Network Manager</a></li>
                      <li><a href="<?php echo base_url()?>scrapper">Submitter</a></li>
                      <li><a href="#">Reports</a></li>
                      <li><a href="#">Video Tutorials</a></li>
                  </ul>       
                </nav>
            </div>
        </div>
        
        <div class="row top-pannel">
          <div class="domainsrc">
<div class="top1_up">
<form class="clearfix" id="searchrecord" name="searchrecord" method="get" action="<?php echo base_url()?>index.php/networkmanager">

                        <div class="ui-widget">
                        <input type="text" name="search" id="search" class="pull-left smsrc">

                        <input type="submit" id="searchbtn" name="submit" value="Search" class="pull-left mgr-left" style="margin-left: 234px;margin-top: -31px;    padding: 6px 10px;">
                        </div>
                        
                       <br><br><br>
                       <div class="searchtype chkbx" style="margin-top: -12px;">
                       <input type="checkbox" class="searchtype" name="searchdomain" value="domains" onClick="search_type(this.name)">&nbsp;<span>PBN Domains</span>
                       <input type="checkbox" class="searchtype" name="searchanchor" value="anchors" onClick="search_type(this.name)">&nbsp;<span>Anchor / Links</span>
                       </div>

                    </form>
                </div>

                <div class="btn-group">
                  <button type="button" class="btn btn-grey btn-default dropdown-toggle" data-toggle="dropdown">
                    Show all Domains <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu showall-domain" role="menu">
                    <li><a href="#">Show All Domains</a>
                        <ul class="domain-in">
                       <?php if(isset($networks) && count($networks) > 0) { 
                            foreach($networks as $key=>$net) {?>
                             
                            <li>
                            <a href="<?php echo base_url()?>index.php/networkmanager?search=<?=$net['network_id']; ?>&type=network"><img src="<?php echo base_url(); ?>images/networks.png" width="20" height="20" alt=""> <?=$net['networkname']; ?></a>
                            </li>
                            <?php }}?>
                           
                        </ul>
                    </li>

                    <li class="divider"></li>
            
                       <?php if(isset($domains) && count($domains) > 0) { 
                            foreach($domains as $key=>$doms) { ?>
                        <li>    <a href="<?php echo base_url()?>index.php/networkmanager?search=<?=$doms['domainname']; ?>"><?=$doms['domainname']; ?></a></li>
                            <?php } } ?>
                            
                  </ul>
                </div>
              <div class="btn-group">
                <button type="button" class="btn btn-default darkgrey pull-right dropdown-toggle" data-toggle="dropdown">View icon Legends <span class="caret"></span></button>
                <ul class="dropdown-menu view-icon-legends" role="menu">
                    <li><i class="fa fa-check verified"></i> = Verified</li>
                    <li><i class="glyphicon glyphicon-flag login-error"></i> = Login Error</li>
                    <li><i class="fa fa-ban site-down"></i> = Site Down</li>
                    <li class="wdt156"><img src="<?php echo base_url(); ?>images/pending-icon.png"  alt=""> = Pending Renewals</li>
                    
                    <li><i class="fa fa-caret-down show-posts"></i> = Show Posts</li>
                    <li><i class="fa fa-pause posting-paused"></i> = Posting Paused</li>
                    <li><i class="glyphicon glyphicon-remove not-indexed"></i> = Not Indexed</li>
                    <li class="wdt156"><img src="<?php echo base_url(); ?>images/4star.png" width="31" height="7" alt=""> = Hidden User/ Pass</li>
                </ul>
                </div>
                
            </div>
            <div id="network-overview">
                <h1>My Network Overview</h1>
                <ul class="networkinfo">
                    <!--<li>
                        <span class="manager"> Manager</span>
                        <a>+ Manager Network</a>
                    </li>-->
                    <li>
                        <span class="networks"> <?php if(isset($networks)) echo count($networks); else echo 0; ?> Networks</span>
                        <a data-toggle="modal" data-target="#newnetwork">+ New Network</a>
                        <!-- New Network popup-->
                        <div class="modal fade" id="newnetwork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">New Network</h4>
                          </div>
                          <div class="modal-body popupbody">
<form id="addnewnetwork" name="addnewnetwork" action="<?php echo base_url()?>index.php/networkmanager/addnetwork" method="post">
                            <div class="modal-header">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                  <tr>
                                    <td width="30%" valign="middle" class="valgn-middle">Create New Network</td>
                                    <td><input id="netwkname" name="netwkname" type="text"></td>
                                    <td><input type="submit" name="addnetwork" value="Create" class="btn btn-primary" style="margin-left:15px; width: 64px;"></td>
                                 
                                  </tr>
                                </table>

                            </div>
                            <div class="existing-networks">
                                <p>Click on Any of Your Existing Networks to Edit or Manage them:</p>
                                <ul> 
<?php if(isset($networks) && count($networks) > 0) { $i=1;
                            foreach($networks as $key=>$net) {
                                
                                if($i==4)
                                {
                                echo '</tr>';
                                $i=1;
                                }
                                
                                if($i==1)
                                echo '<tr>'; ?>
                            
                 <li><a data-toggle="modal" class="popupinner" id="popupinner" data-target="#manage-network" onclick="manage_network(<?=$key; ?>, &quot;<?=$net['networkname']; ?>&quot;)"><?=$net['networkname']; ?> (<?=$net['domcount']; ?>)</a>
</li>

                            <?php $i++; }} ?>
                             </ul>
                            </div> 
                            <div class="clearfix"></div>   
                          </div>
</form>
                        </div>
                        </div>
                        </div>
                         <!-- Manage Network popup-->
                        <div class="modal fade" id="manage-network" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Manage Network</h4>
                          </div>
                          <div class="modal-body popupbody" id="managenetwrk">
                            <div class="modal-header">
<form id="managenetwork" name="managenetwork" action="<?php echo base_url()?>index.php/networkmanager/editnetwork" method="post">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive manage-net">
                                  <tr>
                                    <td width="30%" valign="middle" class="valgn-middle">Network Name</td>
                                    <td><input type="text" id="editnetwkname" name="editnetwkname"></td>
                            <td><input type="submit" name="editnetwork" id="editnetwork" value="Update" class="btn btn-primary" style="margin-left:15px"></td>
                            <td><button type="button" class="btn btn-default" onClick="delete_network()" id="delnetwork" style="margin-left:20px"><i class="fa fa-trash-o red"></i> Delete this network</button></td>
                                  </tr>
                                </table>

                            </div>
                            <div class="existing-networks" style="height:700px;">
                                <p>
<button type="button" data-toggle="modal" data-target="#moredomains" class="btn btn-primary">More Domains</button>
<span class="remove-selected pull-right"><i class="fa fa-trash-o"></i> <a href="#">Remove Selected</a></span></p>
<?php if(isset($domains) && count($domains) > 0) { $i=1; ?>
                                <table  width="100%" border="0" cellspacing="0" cellpadding="0" id="domainlist" class="table-striped" style="border:1px solid rgb(221, 221, 221);">
<?php foreach($domains as $key=>$dom) { if($dom['networkid'] != "") { ?>
                            
<tr> 
<td class="<?=$dom['networkid']; ?>"><?=$dom['domainname']; ?></td>
<td><input type="checkbox" class="<?=$dom['networkid'];?> removedom" onClick="remove_domain(<?=$key; ?>)"></td>
</tr>
                           
                            <?php } $i++; } ?> 
                            </table>
                            <?php } ?>
                            <input type="hidden" id="hidnetid" name="hidnetid"> 
                            <input type="hidden" id="hidsnetstat" name="hidsnetstat" value="1"> 
                            <input type="hidden" id="hiddomid" name="hiddomid">
                            <input type="hidden" id="hiddomstat" name="hiddomstat" value="1">                           
                               
</form>
                            </div> 
                            <div class="clearfix"></div>   
                          </div>
                        </div>
                        </div>
                        </div>
                    </li>
                    <li>
                        <span class="domains"> <?php if(isset($domains)) echo count($domains); else echo 0; ?> Domains</span>
                        <a data-toggle="modal" data-target="#moredomains">+ More Domains</a>
                        <!-- More domains popup -->
                        <div class="modal fade" id="moredomains" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content" id="light">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">More Domains</h4>
                          </div>

                          <div class="modal-body popupbody">
                          
                          <?php if($adddomain) { ?>
                            <h2>How would you like to add more domains?</h2>
 <form id="addnewdomain" name="addnewdomain" action="<?php echo base_url()?>index.php/networkmanager/adddomain" method="post" enctype="multipart/form-data">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                  <tr>
                                    <td>Assign to a network</td>
                                    <td>
                                        <div class="dropdown">
                                           <select class="dropdown-select" id="selectnetwork" name="selectnetwork">
                            <?php if(isset($networks) && count($networks) > 0) {
                            foreach($networks as $key=>$netwrk) { ?>
                            <option value="<?=$key; ?>"><?=$netwrk['networkname']; ?></option>
                            <?php } } ?>
                            </select>
                                 </div>      
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Type of site</td>
                                    <td>
                                        <div class="dropdown">
                                            <select class="dropdown-select" name="selectblogtype" id="selectblogtype">
                                            
                                               <!-- <option value="Blog+">Blog+</option>  
                                                <option value="Traditional Blog">Traditional Blog</option>
                                                <option value="HPBL">HTML</option>
                                                <option value="Mini Money">Mini Money</option>-->
                                                
                                                <option value="WP Blog +">WP Blog +</option>
                                                <option value="Wordpress">Wordpress</option>
                                                <option value="Drupal">Drupal</option>
                                                <option value="Joomla">Joomla</option>
                                                <option value="HTML">HTML</option>     
                                            </select>
                                        </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="filldomain">
                                          <tr>
                                            <td>
                                                Domain Name
                                                
                                            </td>
                                            <td>
                                                User Name
                                                
                                            </td>
                                            <td>
                                                Password
                                               
                                            </td>
                                          </tr>
<?php for($i=1; $i<=5; $i++) { ?>
                            <tr>
                            <td><input type="text" id="domainname<?=$i; ?>" name="domainname<?=$i; ?>"></td>
                            <td><input type="text" id="username<?=$i; ?>" name="username<?=$i; ?>"></td>
                             <td><input type="password" id="password<?=$i; ?>" name="password<?=$i; ?>" style="box-shadow:0px 2px 2px 0px rgb(221, 221, 221) inset; border:1px solid rgb(221, 221, 221); border-radius:6px 6px 6px 6px;padding:5px 0px;"></td>
                             </tr>
                            <?php } ?>
                                          <tr>
                                            <td colspan="3">
<input type="submit" name="adddomain" value="Add Domains" class="btn btn-primary" style="width: 104px;"></td>
                                                <!--button type="button" class="btn btn-primary">Add Domains</button-->
                                            </td>
                                          </tr>
                                        </table>
      
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Need to upload in bulk? <br><a href="">See CSV Requirements</a></td>
                                    <td>
                                    <div class="uploadsec">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td><input type="file" id="domainlist" name="domainlist" class="pull-left" style="width:auto">
<!--button style="margin-left:10px" type="button" class="btn btn-primary pull-left">Upload</button-->
<input type="submit" name="adddomain" value="Upload" class="btn btn-primary" style="width: 104px; margin-left:10px;">
</td>
                                          </tr>
                                        </table>
                                    </div>
                                    </td>
                                  </tr>
                                </table>
      </form>
      
      <?php } else { ?>
      <br>
      You have reached the maximum limit of adding new domains.
      <br>
      Please upgrade your membership to continue.<br> <br>
      <form action="" id="" name="">
      Enter number of domains you want to purchase&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="domain_no" id="domain_no">
      <br>(You must purchase a minimum of 5 domains)
      </form><br><br>
<?php
//$fcnt = 1;

$pckgarr = array();

foreach($packages as $row)
{
	$pckgarr[$row['more_domain_adding_cost']] = array('package_id' => $row['package_id'], 
	'package_name' => $row['package_name'], 
	'more_domain_adding_cost' => $row['more_domain_adding_cost']);
}

ksort($pckgarr);

foreach($pckgarr as $row){ ?>

<!--<form name="_xclick" id="add_dom" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">-->
<form name="_xclick" id="add_dom" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">

<!--<input type="hidden" name="cmd" value="_xclick">-->
<input type="hidden" name="cmd" value="_xclick-subscriptions">

<!--<input type="hidden" name="business" value="billing@rpautah.com">-->
<input type="hidden" name="business" value="abhrabeas@gmail.com">

<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">

<!--<input type="hidden" name="no_note" value="1">-->
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="item_number">
<input type="hidden" name="item_name" value="<?=$row['package_name']; ?> - Add More Domains">
<!--<input type="hidden" name="amount">-->
<input type="hidden" name="new_domain_no">
<input type="hidden" name="a3">
<!--<input type="hidden" name="discount_rate">-->
<input type="hidden" name="p3" value="1">
<input type="hidden" name="t3" value="M">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
<input type='hidden' name='rm' value="0">
<input type="hidden" name="return">
<input type="hidden" name="bn" value="PP-SubscriptionsBF:btn_subscribe_SM.gif:NonHostedGuest">
</form>

<br>
<input type="button" name="submit" value="UPGRADE NOW"
 onClick="set_domain_val('<?=$row['more_domain_adding_cost']; ?>', <?=$row['package_id']; ?>, '<?=$row['package_name']; ?> - Add More Domains', 'add_dom')">
<br>

<?php break; }} ?>
       <br>
                          </div>
 
                        </div>
                        </div>
                        </div>
                    </li>
                    <li>
                        <span class="posts"> <?php if(isset($posts['count'])) echo $posts['count']; ?> Posts</span>
                        <a href="<?php echo base_url()?>index.php/scrapper">+ New Posts</a>
                    </li>
                    <li>
                        <span class="links"><?php if(isset($posts['countlink'])) echo $posts['countlink']; ?> Links</span>
                        <a href="javascript:void(0)" id="searchlinks" data-toggle="modal" data-target="#editlinks">+ Edit Links</a>
                        <!-- More domains popup -->
                        <div class="modal fade" id="editlinks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Edit Your Links</h4>
                          </div>
                          <div class=" searchtype modal-body popupbody">
                            <h2>How would you like to find your links?</h2>
                               <table id="" width="" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                  
                             <tr><td>
                             <div class="searchtype pull-left" style="margin-right:10px; height:42px;" > Search By</div>
                              <input type="checkbox" class="searchtype" name="searchbydomain" value="domains" onClick="jQuery('input[name=searchbyanchor]').removeAttr('checked')" style="width:auto;"> &nbsp;URL  <br>
                    <input type="checkbox" class="searchtype" name="searchbyanchor" value="anchors" onClick="jQuery('input[name=searchbydomain]').removeAttr('checked')" style="width:auto;">&nbsp;Anchor Text
</div>
                                    </td>
                                    <td></td>
                                  </tr>
                   
                                  <tr>
                                    <td> <input type="text" name="searchdata" id="searchdata"></td>
                              <td class="mgr-left">&nbsp;<input type="submit" id="searchby" name="searchby" value="Find My Links" class="btn btn-primary" style="width: 115px; height: 31px;"/></td>
</td>
                                  </tr>
                                </table>

                          </div>
                        </div>
                        </div>
                        </div>
                    </li>
                </ul>
                
                <div class="netbtm">
                    <a class="assignblogs pull-left manager" data-toggle="modal" data-target="#asignblogs">Assign Blogs </a>
                        <!-- Asign blogs popup-->
                        <div class="modal fade" id="asignblogs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                     
<div class="modal-dialog">
<form id="assigndomain" name="assigndomain" action="<?php echo base_url()?>index.php/networkmanager/assigndomains" method="post">
<table>
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Assign Blogs</h4>
                          </div>


                          <div class="modal-body popupbody">
                            
                            <div class="existing-networks">
                                <p><img src="<?php echo base_url(); ?>images/domain-icon2.png" alt=""> Assign Domains to Network</p>
                                <!-- choose-domain -->

                           
                                <div class="choose-domain" id="domain">
                                    <p class="listhead">Choose Domain(s)</p>
                                    <ul class="select-domain">
                                        
<?php if(isset($domains) && count($domains) > 0) {
                                $sortdomains = $domains;
                                krsort($sortdomains);
                            foreach($sortdomains as $key=>$doms) { ?>
                                            
<li><input type="checkbox" name="domain[]"  value="<?=$key; ?>">&nbsp;&nbsp;<?=$doms['domainname']; ?>
                                            </li> <?php } } ?>      
                                  </ul>
                                
                              </div>
                              <div class="arrowright-choose">
                                Assign to <i class="fa fa-arrow-right"></i>
                              </div>
                              <!-- Choose Network -->
                              
                              <div class="choose-network" id="network">
                                    <p class="listhead">Choose Network</p>
                                    <ul class="select-domain">
                                        <?php if(isset($networks) && count($networks) > 0) {
                            foreach($networks as $key=>$nets) { ?>
                            <li><input type="radio" name="network" value="<?=$key; ?>">&nbsp;&nbsp;<?=$nets['networkname']; ?></li>
                            <?php } } ?>
                                  </ul>  
                              </div>   
                       </div> 
                            <div class="clearfix"></div>   
                          </div>
                         
                          <div class="modal-footer popupfooter ">
<input type="submit" name="assign" value="Assign" class="btn btn-primary">
                          
                          </div>
                        </div>
</table>
</form>
                        </div>
                        </div>
                    
                    <a class="netwrkset pull-left mgr-left" data-toggle="modal" data-target="#pagepopup">Admin Settings</a>
                    <!-- Network Settings popup -->
                    <div class="modal fade" id="pagepopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header popup-header">
                            <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Network Settings</h4>
                          </div>
                          <div class="modal-body popupbody">
<form id="netwrksettings" name="netwrksettings" action="<?php echo base_url();?>index.php/networkmanager/updatesettings" method="post">
                                <table id="networksettings" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                  <tr>
                                    <td>Default Blog type</td>
                                    <td class="radio-btn">
                                       <!-- <span>
                                            <input type="radio" name="defaultblog" id="blogplus"  value="Blog+" />
                                            <label for="blogplus" class="radGroup1">Blog+</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="traditional-blog"  value="Traditional Blog"/>
                                            <label for="traditional-blog" class="radGroup1">Traditional Blog </label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="HPBL"  value="HPBL"/>
                                            <label for="HPBL" class="radGroup1">HTML</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="mini-money"  value="Mini Money"/>
                                            <label for="mini-money" class="radGroup1">Mini Money</label>
                                        </span>-->
                                        
                                        <span>
                                            <input type="radio" name="defaultblog" id="wpblogplus"  value="WP Blog +" />
                                            <label for="wpblogplus" class="radGroup1">WP Blog +</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="wordpress"  value="Wordpress"/>
                                            <label for="wordpress" class="radGroup1">Wordpress</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="drupal"  value="Drupal"/>
                                            <label for="drupal" class="radGroup1">Drupal</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="defaultblog" id="joomla"  value="Joomla"/>
                                            <label for="joomla" class="radGroup1">Joomla</label>
                                        </span>
                                         <span>
                                            <input type="radio" name="defaultblog" id="HTML"  value="HTML"/>
                                            <label for="HTML" class="radGroup1">HTML</label>
                                        </span>
                                    
                                    </td>
                    
                                  </tr>
                                  <tr>
                                    <td>Default network </td>
                                    <td class="default-net">
                                        <table class="defaultnetwks">
                            <?php if(isset($networks) && count($networks) > 0) { $i=1;
                            foreach($networks as $netkey=>$netwrk) { 
                            
                            if($i==4)
                                {
                                echo '</tr>';
                                $i=1;
                                }
                                
                                if($i==1)
                                echo '<tr>'; ?>
                            
                            <td><input type="radio" name="defaultnetwork" value="<?=$netkey; ?>"  id="<?=$netkey;?>"/>
                            <label for="<?=$netkey;?>" class="radGroup1"> <?=$netwrk['networkname']; ?></label> </td>
                            
                            <?php $i++; }} ?>
                            </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Index Frequency </td>
                                    <td class="radio-btn">
                                        <span>
                                            <input type="radio" name="indexfrequency" id="weekly" value="Weekly"  />
                                            <label for="weekly" class="radGroup1">Weekly</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="indexfrequency" id="monthly" value="Monthly"  />
                                            <label for="monthly" class="radGroup1">Monthly</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="indexfrequency" id="never" value="Never"  />
                                            <label for="never" class="radGroup1">Never </label>
                                        </span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Automatically Pause Posting If </td>
                                    <td valign="middle" class="radio-btn" style="color:rgb(51, 51, 51);">
                                        <span>
                                            <input type="checkbox" name="unindexed" value="Unindexed" />&nbsp;&nbsp;
                                            Domain Not Indexed
                                        </span>
                                        <span>
                                          <input type="checkbox" name="sitedown" value="Site down" />&nbsp;&nbsp;
                                          Site Down
                                        </span>
                                        <span>
                                            <input type="checkbox" id="lesspr" name="lesspr" value="Pagerank" />&nbsp;&nbsp;
                                            PageRank < 
                                             <input type="text" id="pr" name="pr" maxlength="3" style="width:40px; height:20px; line-height:10px;" disabled />
                                        </span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Ahrefs&nbsp;Backlink&nbsp;Data</td>
                                    <td class="abData">
                                       <a href="<?php echo base_url(); ?>networkmanager/ahrefsdata" class="nobackground actvahrefs">Activate</a>
                        <span class="activated">(Congrats, account authorized)</span><br /><br />
                        <ul class="backlinkdata" style="color:rgb(51, 51, 51);">
                        <span><input type="checkbox" name="backlinkcount" value="1" />&nbsp;&nbsp;Backlink Count</span>
                        <span><input type="checkbox" name="domainrank" value="1" />&nbsp;&nbsp;Ahrefs Domain Rank</span>
                        <span><input type="checkbox" name="referringdomains" value="1" />&nbsp;&nbsp;Referring Domains</span>
                       </ul>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Ahrefs Frequency</td>
                                    <td class="radio-btn">
                                        <span>
                                            <input type="radio" name="ahrefsfrequency" value="Once" />
                                            <label for="afonce" class="radGroup1">Once</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="ahrefsfrequency" value="Weekly"/>
                                            <label for="afweekly" class="radGroup1">Weekly</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="ahrefsfrequency" value="Monthly"  />
                                            <label for="afmonthly" class="radGroup1">Monthly</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="ahrefsfrequency" id="afnever" value="Never"/>
                                            <label for="afnever" class="radGroup1">Never</label>
                                        </span>
                                    
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Pagerank</td>
                                    <td class="radio-btn">
                                        <span>
                                            <input type="radio" name="pagerank" id="paonce" value="Once"/>
                                            <label for="paonce" class="radGroup1">Once</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="pagerank" id="paweekly" value="Weekly"/>
                                            <label for="paweekly" class="radGroup1">Weekly</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="pagerank" id="panever" value="Never"/>
                                            <label for="panever" class="radGroup1">Never</label>&nbsp&nbsp;&nbsp;&nbsp;
                                           <a href="<?php echo base_url(); ?>index.php/networkmanager/check_pr_now/true" class="nobackground">Update Now</a>
                                        </span>
                                    </td>
                                  </tr>
                                </table>
            
                          </div>
                          <div class="modal-footer popupfooter">
                            <input type="submit" class="btn btn-primary" value="Save" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button></form>
                          </div>
                        </div>

                      </div>
                    </div>
                    <span class="pull-left pull-left-custom  renualdate"><?php $month = array();
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
                        echo $month3." (".date('M', strtotime("+2 month")).")"; } ?></span>
                </div>
            </div>
            <div class="custom-gategory">
            <div class="colorplate">
<?php $type = array();
            foreach($domains as $doms) {
                $type[] = $doms['blogtype'];
            }
            
            /*$tradblog = 0;
            $blog = 0;
            $hpbl = 0;
            $minmoney = 0;*/

		    $WP_blog_plus = 0;
		    $Wordpress = 0;
		    $Drupal = 0;
		    $Joomla = 0;
		    $HTML = 0;
            
            if(count($type) > 0)
            {
				$blogtype = array_count_values($type);
							
			   /* if(isset($blogtype['Traditional Blog']))
				$tradblog = $blogtype['Traditional Blog'];
				
				if(isset($blogtype['Blog+']))
				$blog = $blogtype['Blog+'];
				
				if(isset($blogtype['HPBL']))
				$hpbl = $blogtype['HPBL'];
				
				if(isset($blogtype['Mini Money']))
				$minmoney = $blogtype['Mini Money'];*/
	
				 if(isset($blogtype['WP Blog +']))
				$WP_blog_plus = $blogtype['WP Blog +'];
				
				if(isset($blogtype['Wordpress']))
				$Wordpress = $blogtype['Wordpress'];
				
				if(isset($blogtype['Drupal']))
				$Drupal = $blogtype['Drupal'];
				
				if(isset($blogtype['Joomla']))
				$Joomla = $blogtype['Joomla'];
				
				if(isset($blogtype['HTML']))
				$HTML = $blogtype['HTML'];
			 } ?>
                    <ul>
                      <!--  <li><span class="yellow"></span>Traditional Blog (<?//=$tradblog; ?>)</li>
                        <li><span class="light-blue"></span>Blog + Booster (<?//=$blog; ?>)</li>
                        <li><span class="dark-blue"></span>HTML (others) (<?//=$hpbl; ?>)</li>
                        <li><span class="green"></span>Mini Money Site (<?//=$minmoney; ?>)</li>-->
                        
                        <li><span class="yellow"></span>WP Blog + (<?=$WP_blog_plus; ?>)</li>
                        <li><span class="light-blue"></span>Wordpress (<?=$Wordpress; ?>)</li>
                        <li><span class="dark-blue"></span>Drupal (<?=$Drupal; ?>)</li>
                        <li><span class="green"></span>Joomla (<?=$Joomla; ?>)</li>
                        <li><span class="red"></span>HTML (<?=$HTML; ?>)</li>
                    </ul>
                </div>
                <div class="top3_right colorcirle pull-right">

                                 <canvas id="canvas" height="73" width="73"></canvas>
    
                    <script>
                     var pieData = [
                        {
                            //Traditional Blog
                            value: <?=$WP_blog_plus; ?>,
                            color:"#FBB52F"
                        },
                        {
                            //Blog +
                            value : <?=$Wordpress; ?>,
                            color : "#6F98AE"
                        },
                        {
                            //HPBL
                            value : <?=$Drupal; ?>,
                            color : "#00275E"
                        },
                        {
                            //Mini Money
                            value : <?=$Joomla; ?>,
                            color : "#87AE00"
                        },
						{
                            //Mini Money
                            value : <?=$HTML; ?>,
                            color : "#F00"
                        }      
                    ];
                    var myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData);
                    </script>
                    <!--img src="../images/circle.png" alt="" style="margin-bottom:17px"-->
                    <div class="clearfix"></div>
                    
                </div>
            </div>
        </div>

        
    </div>

    <div class="container">
        <div class="row pdglr">
        <?php if($this->session->flashdata('message')) { 
        echo $this->session->flashdata('message'); } ?>    
        
        <?php if(isset($_REQUEST['searchanchor']) && $_REQUEST['searchanchor'] == "anchors") { ?>
        
        <div class="table-responsive table-scroll pre-scrollable network_buttom box_two">

         <table class="table table-bordered table-hover" id="" width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
                      <tr>

                        <th>Post URL</th>

                        <th>Date Posted</th>

                        <th>Link ID</th>

                        <th>Anchor</th>

                        <th>Link</th>
<th>Link Status</th>
                        
                         <th><input type="checkbox" id="select_all_posts">&nbsp;&nbsp;Select All 
 <button class="btn btn-primary mgr-left editlinkbtn" type="button" data-toggle="modal" data-target="#edit-links">Edit Links</button>
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
 <div class="modal fade" id="edit-links" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header popup-header">
                                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Update Links & Anchors</h4>
                              </div>
                              <div class="modal-body popupbody">
                              <form name="anchorreset" action="<?php echo base_url() ?>index.php/networkmanager/<?=$action_path; ?>" method="post">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                      <tr>
                                      <td> <?php if($editlink) echo "Anchor"; else echo "Anchor 1"; ?>:</td><td><input type="text" name="anchor1" value=""></td>
                                      </tr>
                                      <tr>
                                       <td><?php if($editlink) echo "Link"; else echo "Link 1"; ?>:</td><td><input type="text" name="link1" value=""></td>
                                      </tr>
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
                                      <tr>
                                        <td></td>
                                        <td><input type="submit" id="update_anchor" name="submit" value="Update" class="btn btn-primary" style="width: 72px;"/>
                                       
                                      </tr>
                                    </table>

                                    </form>
                
                              </div>
                              
                            </div>
                          </div>
                        </div>
</th>
                      </tr></thead><tbody>
                      
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
<td></td>
                        
                        <td><input type="checkbox" name="post_<?=$count; ?>" value="<?=$psearch['pid']; ?>" typevals="<?=$psearch['type']; ?>"></td>

                      </tr>
                      
                      <?php } } ?>
</tbody>
                    </table>
 <div class="pagination-row text-right">
                <div class="result-per-page">
                    <span>Results Per Page:</span>
                    <ul> 
                        <li><a href="javascript:void(0)" onClick="show_next(<?=$end; ?>)" class="current">10</a></li>
                          
                        <li><a href="javascript:void(0)" onClick="show_next(<?=$hundred;?>)">100</a></li>  
                        <li class="show_all"><a href="javascript:void(0)" onClick="show_next('all')">All</a></li>
                    </ul>
                </div>
                 <?php if(isset($links) && $links!='' ){ ?>
                <div class="pagination">
                    <?php echo $links; ?> Page <input name="page" type="text" value="<?php if(isset($current)) echo $current; ?>" readonly> of <?php if(isset($total)) echo $total; ?>
                </div>
                <?php } ?>
            </div>
                    
                    </div>
      
        <?php } elseif(isset($_REQUEST['editlink']) && $_REQUEST['editlink'] == 1) { ?>
        
        <div class="table-responsive table-scroll pre-scrollable network_buttom box_two">
         <table class="table table-bordered table-hover" id="" width="100%" border="0" cellspacing="0" cellpadding="0">
<thead>
                      <tr>

                        <th>Post URL</th>

                        <th>Date Posted</th>

                        <th> <?php if(isset($_REQUEST['anchor'])) echo "Anchor"; 
                        if(isset($_REQUEST['domain'])) echo "Link"; ?> ID</th>

                        <th>Anchor</th>

                        <th>Link</th>
                        <th>Link Status</th>

                        <th><input type="checkbox" id="select_all_posts">&nbsp;&nbsp;Select All 
<button class="btn btn-primary mgr-left editlinkbtn" type="button" data-toggle="modal" data-target="#edit-links">Edit Links</button>
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
 <div class="modal fade" id="edit-links" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header popup-header">
                                <button type="button" class="close popupclose" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Update Links & Anchors</h4>
                              </div>
                              <div class="modal-body popupbody">
                              <form name="anchorreset" action="<?php echo base_url() ?>index.php/networkmanager/<?=$action_path; ?>" method="post">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed popuptbl table-responsive">
                                      <tr>
                                      <td> <?php if($editlink) echo "Anchor"; else echo "Anchor 1"; ?>:</td><td><input type="text" name="anchor1" value=""></td>
                                      </tr>
                                      <tr>
                                       <td><?php if($editlink) echo "Link"; else echo "Link 1"; ?>:</td><td><input type="text" name="link1" value=""></td>
                                      </tr>
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
                                      <tr>
                                        <td></td>
                                        <td><input type="submit" id="update_anchor" name="submit" value="Update" class="btn btn-primary" style="width: 72px;"/>
                                       
                                      </tr>
                                    </table>
                                    </form>
                
                              </div>
                              
                            </div>
                          </div>
                        </div>
</th>

                      </tr></thead><tbody>
                      
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
<td></td>
                        <td><input type="checkbox" name="post_<?=$count; ?>" value="<?=$postr['pid']; ?>" typevals="<?=$postr['type']; ?>"></td>

                      </tr></tbody>
                      
                      <?php } } ?>

                    </table>
 <div class="pagination-row text-right">
                <div class="result-per-page">
                    <span>Results Per Page:</span>
                    <ul> 
                        <li><a href="javascript:void(0)" onClick="show_next(<?=$end; ?>)" class="current">10</a></li>
                          
                        <li><a href="javascript:void(0)" onClick="show_next(<?=$hundred;?>)">100</a></li>  
                        <li class="show_all"><a href="javascript:void(0)" onClick="show_next('all')">All</a></li>
                    </ul>
                </div>
                 <?php if(isset($links) && $links!='' ){ ?>
                <div class="pagination">
                    <?php echo $links; ?> Page <input name="page" type="text" value="<?php if(isset($current)) echo $current; ?>" readonly> of <?php if(isset($total)) echo $total; ?>
                </div>
                <?php } ?>
            </div>
                    </div>
                             
                    <?php } else { ?>
            <div class="network_buttom table-responsive table-scroll pre-scrollable">
                <table id="example" class="table table-bordered table-hover">
                <thead id="rowhead">
                    
                    <th  style="width: 7em;" >Network </th>
                   <!-- <th>Type</th> -->
                    <th>CMS</th>
                    <th>Domain</th>
                    <th>PR</th>
                    <th>Age</th>
                    <th>IP Address</th>
                    <th>Name server </th>
                    <th>Posts</th>
                    <th>Updated</th>
                    <th>Registar</th>
                    <th>Expires</th>
                    <th>OBL</th>
                    <th>User</th>
                    <th>Pass </th>
                    <th>&nbsp;</th>
                    <!--<th>Login</th>-->
                    <th>Pause</th>
                    
                    <th>&nbsp;&nbsp; Index &nbsp;&nbsp;</th>
                    <th><i class="glyphicon glyphicon-remove not-indexed" id="delete_domain" /></i></th>
					
				<?php if(isset($category) && count($category) > 0) { 
                foreach($category['catname'] as $catg) { ?>
                <th><i class="glyphicon glyphicon-remove not-indexed" id="delete_column_<?php  echo $catg['categoryname'] ;?>" onclick="removeColom(this,'<?php  echo $catg['categoryname'] ;?>')"><span style="color: #666;font: 13px 'Open Sans', Arial, Helvetica, sans-serif;"><?php  echo $catg['categoryname'] ;?></span></th>
                <?php }} ?>

                    <th><span>
                    <a href="javascript:void(0)" id="addcategory" class="font11">+ Add Column</a></span></th>
                </thead>
                <tbody>
                   <?php //print_r(count($retarr));
             if(isset($retarr) && count($retarr) > 0) { $cnt=0;
             
             $sortarr = $retarr;
             krsort($sortarr);
//                         echo '<pre>';
//                         print_r($sortarr);
//                         echo '</pre>';
             $imgcount = 0;
//                         $row = '1';
             foreach($sortarr as $key=>$arr) { $cnt++;
             $imgcount++;
//           if($row=='29'){
//                             print_r($arr);
//                         }
//                         $row++;
            
             if($imgcount > 4){
             $imgcount = 1;
}

$networkname=$arr['networkname'];
$strin_len =  strlen ( $networkname );
if($strin_len>10)
$net_work=substr($networkname,0,10);
else
$net_work=substr($networkname,0,7)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";

// $net_work_f=$networkname;
// $type=$arr['type'];
// $net_type=substr($type,0,10);
// $net_type_f=$type;

$netdomain=$arr['domain'];
$strin_len =  strlen ( $netdomain );
if($strin_len>10)
$net_dom=substr($netdomain,0,10);
else
$net_dom=substr($netdomain,0,7)."&nbsp;&nbsp;&nbsp;&nbsp;";
$net_dom_f=$netdomain;

$dns=$arr['dns'];
$net_dns=substr($dns,0,15)."&nbsp;&nbsp;";
$net_dns_f=$dns;

$domreg=$arr['domainregistrar'];
$dom_reg=substr($domreg,0,12);
$dom_reg_f=$domreg;

$domainip =$arr['domainip'];
$strin_len =  strlen ( $domainip );
if($strin_len>10)
$domain_ip = substr($domainip,0,13);
else
$domain_ip = substr($domainip,0,10)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

$domain_ip_f = $domainip; ?>

<?php  if(($arr['valid_credentials'])==0){ ?>    
<tr id="tr_<?=$key; ?>" class="yellow-stripe">
 <?php }
 elseif (($arr['indexed'])==0) { ?>
<tr id="tr_<?=$key; ?>" class="blue-stripe"> 
 <?php } 
 elseif (($arr['status'])==0) {?>
<tr id="tr_<?=$key; ?>" class="red-stripe-line"> 
<?php } 
else{ ?>
<tr id="tr_<?=$key; ?>">
<?php }?>
  
  <?php if(isset($arr['postdetail'])) { //echo $key;?>
                <input type="hidden" id="tr_<?php echo $key; ?>_popup" value="<?php echo htmlspecialchars(json_encode($arr['postdetail'])); ?>" />
  <?php } ?>

                  <td title="<?php echo $net_work_f;?>"><?php echo $net_work;// echo $key; ?><!--<img src="<?php //echo base_url(); ?>images/img21.png" alt="no img"/>--></td>
                  <!--<td><?php echo $net_type; ?></td>-->

                  <?php switch($arr['cms'])
				  {
					  case "WP Blog +":
					  $type_logo = 'wordpress-plus';
					  break;
					  
					  case "Wordpress":
					  $type_logo = 'img1';
					  break;
					  
					  case "Drupal":
					  $type_logo = 'img3';
					  break;
					  
					  case "Joomla":
					  $type_logo = 'img2';
					  break;
					  
					  case "HTML":
					  $type_logo = 'htmlLogo';
					  break;
					  
					  default:
					  $type_logo = '';
				  } ?>

                  <td><img src="<?php echo base_url(); ?>images/LOGOS/<?=$type_logo; ?>.png" alt="no img"/>&nbsp;</td>
                  <td title="<?php echo $net_dom_f; ?>"><?php echo $net_dom; ?></td>
                  <td><?=$arr['pagerank']; ?><!--4(4)--></td>
                  <td><?=$arr['age']; ?>&nbsp;yrs&nbsp;</td>
                  <td title="<?=$domain_ip_f; ?>"><?=$domain_ip; ?></td>
                  <td title="<?php echo $net_dns_f; ?>"><?php echo $net_dns; ?></td>
                  <td><?php if(isset($arr['postdetail'])) echo count($arr['postdetail']); else echo 0; ?></td>
                  <td><?php if(isset($arr['postdetail']) && count($arr['postdetail']) > 0) {
              $dt = array();
             // echo "my";
                      foreach($arr['postdetail'] as $postdetail)
                      $dt[] = $postdetail['postmodified'];
              $max = max(array_map('strtotime', $dt));
                     echo date('m/d/Y', $max); } ?></td>
                 <td title="<?php echo $dom_reg_f; ?>"><?php echo $dom_reg; ?></td>
                 <td><?=$arr['domainexpiry']; ?></td>
                 <td><?=$arr['obl']; ?></td>
                 <td id="u_<?=$key; ?>" onClick="edit_login_data('<?=$key; ?>','username')">
                 <img src="<?php echo base_url(); ?>images/grey-star.png" alt="no img" id="username_<?=$key; ?>" class="star" />
                  <input type="text" id="edit_username_<?=$key; ?>" name="edit_username_<?=$key; ?>" value="<?=$arr['username']; ?>"  onBlur="update_login_data(<?=$key; ?>,'username')" style="display:none;">
                 <input type="hidden" id="hid_username_<?=$key; ?>" name="hid_username_<?=$key; ?>" value="<?=$arr['username']; ?>">
                 
                 </td>
                 <td id="p_<?=$key; ?>" onClick="edit_login_data('<?=$key; ?>','password')">
                 <img src="<?php echo base_url(); ?>images/grey-star.png" alt="" id="password_<?=$key; ?>" class="star"/>
                 <input type="text" id="edit_password_<?=$key; ?>" name="edit_password_<?=$key; ?>" value="<?=$arr['password']; ?>" onBlur="update_login_data(<?=$key; ?>,'password')" style="display:none;">
                <input type="hidden" id="hid_password_<?=$key; ?>" name="hid_password_<?=$key; ?>" value="<?=$arr['password']; ?>">
                 </td>
                 <td><?php if($arr['valid_credentials']){?> <img src="<?php echo base_url(); ?>images/right-sign.png" alt=""> <?php } else{ ?> <i class="glyphicon glyphicon-flag login-error" style="color:#e39500";></i><?php }?></td>
               <!--  <td><button class="btn-table btn-yellow">GO&nbsp;<i class="fa fa-caret-right"></i></button></td>-->
                 <td><button class="pause btn-playpause " id="pause<?=$key; ?>" onClick="pause_posting(<?=$key; ?>)" ><i class="fa fa-pause"></i></button></td>
                 
                 <td class="details-control index-col"><?php if($arr['indexed']) { ?> <img src="<?php echo base_url(); ?>images/right-sign.png" alt=""> <?php } else{ ?> <img src="<?php echo base_url(); ?>images/close-icon.png" alt=""><?php }?><span class="mgr-left2 pull-right"> <img src="<?php echo base_url(); ?>images/arrowdown.png" class="denvernew2 details-control" id="toggle<?=$cnt; ?>" > 
                 </span>

                 </td>
  <td><input type="checkbox" name="record_<?=$key; ?>" value="<?=$key; ?>" ></td>
 <?php if(isset($category) && count($category) > 0) { 

                foreach($category['catname'] as $catg) { ?>
                <td>
                <?php foreach($category['catvalue'] as $catgry)
                {
                    if($catgry['domainid'] == $key) {
                        if($catgry['categoryname'] == $catg['categoryname'])
                        {
                          // if(trim($catgry['categoryvalue']) == "")
                          // { 
                          $string = $catgry['domainid'].'_'.$catgry['categoryname'];
                          $id = str_replace(" ","-",$string); ?>
                             <p class="custcategory" onClick="edit_category('<?=$id; ?>')" style="color: rgb(232, 232, 232);"><?php
							
								$string1="Click to Enter Value"; 
								$text=substr($string1,0,6)."...";
								echo $text; ?>
                                
							<div class="editcustcategory" id="<?=$id; ?>" style="display:none;" >
                             <form action="#" method="post" onsubmit="return SaveCategory('<?=$catgry['domainid']?>','<?=$catgry['categoryname']?>','<?=$id; ?>');">
                                 <input type="text" name="<?=$id.'_txt'; ?>" id="<?=$id.'_id'; ?>"  value=""> 
                                 <input type="submit" name="<?=$id.'_btn'; ?>" value="Save">
                             </form>
                             </div>
                             
                          <p><?php echo $catgry['categoryvalue']; ?> </p></p><?php
						  //}
                          // else
                             // echo $catgry['categoryvalue'];
                        }
                    }
                } ?>
                </td>
                <?php }} ?>
              
<td>&nbsp;</td>
                 </tr>
                 <?php }}?>
                </tbody>
              </table>
            <?php } ?>
        </div>
    </div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/script.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.slicknav.js"></script>

 <script src="<?php echo base_url(); ?>assets/js/Chart.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
		  $('input').iCheck({
			checkboxClass: 'icheckbox_minimal-grey',
			radioClass: 'iradio_minimal-grey'
			//increaseArea: '20%' // optional
		  });
		});
    </script> 
  </body>
</html>