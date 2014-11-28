<div class="topfilterblock">
  <div class="toprowfilter">
    <div class="choose-campaign choosec"> <span>Choose campaign:</span>
      <div class="dropdown">
        <select id="serpranking" name="selectblogtype" class="dropdown-select">
          <?php
if(is_array($campaign_domain_list) && count($campaign_domain_list) > 0){
	$camp_id='';//$campaign_domain_list[0]['c_id'];
	$camp_domain_id=$campaign_domain_list[0]['c_id'];
	$camp_domain=stripslashes($campaign_domain_list[0]['campaign_title']);  
	$domain_id=$campaign_domain_list[0]['campaign_id'];
	$domain=stripslashes($campaign_domain_list[0]['campaign_main_page_url']);  
	for($i=0; $i<count($campaign_domain_list); $i++){
		if($camp_id!=$campaign_domain_list[$i]['c_id']){
		
			if($i>0) echo '</optgroup>';
?>
          <optgroup label="<?php echo stripslashes($campaign_domain_list[$i]['campaign_title']);?>">
          <?php } ?>
          <option value="<?php echo $campaign_domain_list[$i]['campaign_id'];?>" <?php 
		if($cid == $campaign_domain_list[$i]['campaign_id']){ 
				 $camp_domain_id=$campaign_domain_list[$i]['c_id'];
				 $camp_domain=stripslashes($campaign_domain_list[$i]['campaign_title']);  
				 $domain_id=$campaign_domain_list[$i]['campaign_id'];
				 $domain=stripslashes($campaign_domain_list[$i]['campaign_main_page_url']);  
				 echo 'selected';
		}?>><?php echo '----' . stripslashes($campaign_domain_list[$i]['campaign_main_page_url']);?></option>
          <?php
		$camp_id=$campaign_domain_list[$i]['c_id'];
	}
}
?>
          </optgroup>
        </select>
      </div>
    </div>
    <div class="filterby choose-campaign"> <span>Crawled By:</span>
      <div class="dropdown">
        <select class="dropdown-select" name="search_engine_list" id="search_engine_list">
          <option value="yahoo" <?php if($sid == 'yahoo'){echo 'selected';}?>>Yahoo</option>
          <option value="bing" <?php if($sid == 'bing'){echo 'selected';}?>>Bing</option>
          <option value="google" <?php if($sid == 'google'){echo 'selected';}?>>Google</option>
        </select>
      </div>
    </div>
  </div>
  <div class="topbreadcrumbarea">
    <ol class="breadcrumb topbreadcrumb">
      <li><a href="#"><?php echo $camp_domain; ?></a></li>
      <li class="active"><?php echo $domain; ?></li>
    </ol>
  </div>
</div>
<div class="clearfix"></div>
<?php if($this->session->flashdata('message')) echo $this->session->flashdata('message'); ?>
<div class="row"> 
  
  <!-- Top row Start -->
  <div class="mtrranking-row">
    <div class="row">
      <div class="col-md-5 col-md-5-1">
        <div class="serprank">
          <div class="imgholder"> <img src="<?php echo base_url('images/'.$getdetailkeywordinfo->campaign_murl_thumb); ?>" alt=""> </div>
        </div>
        <div class="viewkeyword">
          <div class="metersecheader ">Choose KWs to plot</div>
          <div class="fropfilter">
            <div data-class="dropdown drpwsty" style="width:100%">
              <select id="kwDD" data-id="campaign_list" data-class="dropdown-select" multiple="multiple" name="selectblogtype">
                <?php
				$test=0;
if(is_array($selected_campaign_keyword_list) && count($selected_campaign_keyword_list) > 0){
	for($i=0; $i<count($selected_campaign_keyword_list); $i++){
		if($selected_campaign_keyword_list[$i]['keystatus']=='Active') $test++;
?>
                <option disabled="disabled" value="k<?php echo $selected_campaign_keyword_list[$i]['keyword_id'];?>"><?php echo stripslashes($selected_campaign_keyword_list[$i]['keyword']).' ('.$selected_campaign_keyword_list[$i]['keyword_type'].')'; ?></option>
                <?php
		//}
	}
}
?>
              </select>
            </div>
          </div>
          <div class="rating-block">
            <ul>
              <?php if(is_array($selected_campaign_keyword_list) && count($selected_campaign_keyword_list) > 0){
for($i=0; $i<count($selected_campaign_keyword_list); $i++){ ?>
              <li data-id="k<?php echo $selected_campaign_keyword_list[$i]['keyword_id']; ?>" data-type="<?php echo $selected_campaign_keyword_list[$i]['keyword_type']; ?>">
                <p> <span class="lightblue"></span> <?php echo stripslashes($selected_campaign_keyword_list[$i]['keyword']).' ('.$selected_campaign_keyword_list[$i]['keyword_type'].')'; ?> </p>
              </li>
              <?php if($selected_campaign_keyword_list[$i]['keyword_type']=='A') break; } } ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-5 col-md-5-2 bdrRL"> </div>
      <div class="col-md-2">
        <div class="metersecheader ">Tools</div>
        <ul class="tools">
          <li><img src="<?php echo base_url('images/KeywordsIcon.gif');?>" width="16" height="16" alt=""> <span><?php echo count($selected_campaign_keyword_list); ?> Keyword <a data-toggle="modal" data-target="#addKeywords">+ Add Keywords</a> <a data-toggle="modal" data-target="#ManageKeywords">+ Manage Keywords</a></span> </li>
          <li><img src="<?php echo base_url('images/SEOTestIcon.gif');?>" width="16" height="16" alt=""> <span><?php echo $test; ?> Keyword <a data-toggle="modal" data-target="#ManageKeywords">+ Manage Tests</a></span> </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="inner-table rankingchart">
    <div class="panel-heading-tbl">
      <h4>Ranking Chart</h4>
      <i class="fa fa-question query pull-right"></i> </div>
    <div class="clearfix"></div>
    <div class="panel-body-tbl">
      <div class="carveMapSec">
        <div style="height:400px; width:100%" id="container"> </div>
        <div id="tooltip" class="thetooltip">
          <p id="tooltiptext" style="margin:0">default</p>
        </div>
        <div style="height:400px; width:100%" id="container2"> </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>
<div class="inner-table rankingchart">
  <div class="panel-heading-tbl">
    <h4>Ranking Chart</h4>
    <i class="fa fa-question query pull-right"></i> </div>
  <div class="clearfix"></div>
  <div class="panel-body-tbl-onpage">
    <div class="rbktoprow"> </div>
    <div class="clearfix"></div>
    <table width="100%" id="ranking" class="table-bordered ranking-tbl">
    	<thead>
            <tr>
              <th>Campaign</th>
              <th>Type</th>
              <th>Site</th>
              <th>Keywords</th>
              <th>Keyword</th>
              <th>Google</th>
              <th>Trend</th>
              <th>Bing</th>
              <th>Trend</th>
              <th>Yahoo</th>
              <th>Trend</th>
              <th>Tests</th>
            </tr>
		</thead>   
    	<tfoot>
            <tr>
              <th>Campaign</th>
              <th>Type</th>
              <th>Site</th>
              <th>Keywords</th>
              <th>Keyword</th>
              <th>Google</th>
              <th>Trend</th>
              <th>Bing</th>
              <th>Trend</th>
              <th>Yahoo</th>
              <th>Trend</th>
              <th>Tests</th>
            </tr>
		</tfoot>
        <tbody>
<?php
if(is_array($campaign_details) && count($campaign_details) > 0){
	$camp_domain_ids=0;
	$camp_other_domains=array();
	$site_icon=array("",base_url('images/money-icon.png'),base_url('images/Parasite.gif'));
	$site=array("",'moneysite','parasite');
	for($i=0; $i<count($campaign_details); $i++){
		$grank='n/a';
		if(!is_null($campaign_details[$i]['gcurrent']))
		{
				$grank= $campaign_details[$i]['gcurrent'];
				if(is_null($campaign_details[$i]['gprev']))
					$grank.='<span class="badge small-badge">n/a</span>'; 							
				elseif($campaign_details[$i]['gprev']>$campaign_details[$i]['gcurrent'])
					$grank.='<span class="badge small-badge small-badgered">-'.ceil(($campaign_details[$i]['gprev']-$campaign_details[$i]['gcurrent'])/$campaign_details[$i]['gprev']).'</span>';
				else
					$grank.='<span class="badge small-badge small-badgegreen">+'.ceil(($campaign_details[$i]['gcurrent']-$campaign_details[$i]['gprev'])/$campaign_details[$i]['gprev']).'</span>'; 
		} 
		$brank='n/a';
		if(!is_null($campaign_details[$i]['bcurrent']))
		{
				$brank= $campaign_details[$i]['bcurrent'];
				if(is_null($campaign_details[$i]['bprev']))
					$brank.='<span class="badge small-badge">n/a</span>'; 							
				elseif($campaign_details[$i]['bprev']>$campaign_details[$i]['bcurrent'])
					$brank.='<span class="badge small-badge small-badgered">-'.ceil(($campaign_details[$i]['bprev']-$campaign_details[$i]['bcurrent'])/$campaign_details[$i]['bprev']).'</span>';
				else
					$brank.='<span class="badge small-badge small-badgegreen">+'.ceil(($campaign_details[$i]['bcurrent']-$campaign_details[$i]['bprev'])/$campaign_details[$i]['bprev']).'</span>'; 
		} 
		$yrank='n/a';
		if(!is_null($campaign_details[$i]['ycurrent']))
		{
				$yrank= $campaign_details[$i]['ycurrent'];
				if(is_null($campaign_details[$i]['yprev']))
					$yrank.='<span class="badge small-badge">n/a</span>'; 							
				elseif($campaign_details[$i]['yprev']>$campaign_details[$i]['ycurrent'])
					$yrank.='<span class="badge small-badge small-badgered">-'.ceil(($campaign_details[$i]['yprev']-$campaign_details[$i]['ycurrent'])/$campaign_details[$i]['yprev']).'</span>';
				else
					$yrank.='<span class="badge small-badge small-badgegreen">+'.ceil(($campaign_details[$i]['ycurrent']-$campaign_details[$i]['yprev'])/$campaign_details[$i]['yprev']).'</span>'; 
		} 
		
		
		
		
		
		if($camp_domain_ids==$campaign_details[$i]['campaign_id']){
			$camp_other_domains[$camp_domain_ids][]=array($campaign_details[$i]['campaign_title'],$campaign_details[$i]['campaign_site_type'],$campaign_details[$i]['campaign_main_page_url'],1,$campaign_details[$i]['keyword'],$grank,is_null($campaign_details[$i]['gtrend'])?'':$campaign_details[$i]['gtrend'],$brank,is_null($campaign_details[$i]['btrend'])?'':$campaign_details[$i]['btrend'],$yrank,is_null($campaign_details[$i]['ytrend'])?'':$campaign_details[$i]['ytrend'],$campaign_details[$i]['keyword_id']);
		}
		else{
?>
			<tr data-id="<?php echo $campaign_details[$i]['campaign_id'];?>">
                <td><?php echo $campaign_details[$i]['campaign_title']; ?></td>
            	<td data-order="<?php echo $site[$campaign_details[$i]['campaign_site_type']]; ?>" data-search="<?php echo $site[$campaign_details[$i]['campaign_site_type']]; ?>"><img src="<?php echo $site_icon[$campaign_details[$i]['campaign_site_type']]; ?>" /></td>
            	<td><?php echo $campaign_details[$i]['campaign_main_page_url']; ?></td>
            	<td><?php echo $campaign_details[$i]['key_count']; 
						 ?>
                	<ul class="pull-right">
                    	<li><a data-toggle="modal" class="yellowlink" data-target="#addKeywords">+Add</a></li> 
                        <?php 	if($campaign_details[$i]['key_count']>1){ ?>
                        <li><a href="#" id="1" class="toggle3" title="1">Show</a> </li>
                    <?php } ?>
                        <li><div class="table-responsive toggle_box arrowpopup arrowdata zindexauto" id="toggle_box" style="display: none;"></div></li>
                    </ul>
                </td>
            	<td><?php echo $campaign_details[$i]['keyword']; ?></td>
            	<td><?php echo $grank; ?>
                </td>
            	<td data-type="Google Rank" data-sparkline="<?php echo $campaign_details[$i]['gtrend']; ?>"></td>
            	<td><?php echo $brank; ?>
                </td>
            	<td data-type="Bing Rank" data-sparkline="<?php echo $campaign_details[$i]['btrend']; ?>"><?php echo $campaign_details[$i]['btrend']; ?></td>
            	<td><?php echo $yrank; ?>
                </td>
            	<td data-type="Yahoo Rank" data-sparkline="<?php echo $campaign_details[$i]['ytrend']; ?>"></td>
            	<td><?php echo $campaign_details[$i]['keyword_id']; ?></td>
			</tr>
<?php
		}
		$camp_domain_ids=$campaign_details[$i]['campaign_id'];
	}
}
?>
        </tbody>        
    </table>
  </div>
</div>
<script type="text/javascript">
var tbl=<?php echo json_encode($camp_other_domains); ?>;
var Color={	"algo":"rgba(194, 66, 66, 0.5)",
			"off":"rgba(151, 176, 111, 0.5)",
			"offr":{
				pattern: '<?php echo base_url('images/ofr.png');?>',
				width: 6,
				height: 6
			},
			"on":"rgba(80, 157, 199, 0.5)",
			"onr":{
				pattern: '<?php echo base_url('images/onr.png');?>',
				width: 6,
				height: 6
			}
};
var dd=<?php echo  $chart_data; ?>;
var de=<?php echo  $col_data; ?>;
var site_icon=['',"<?php echo base_url('images/money-icon.png').'","'.base_url('images/Parasite.gif'); ?>"];
var site=['',"moneysite","parasite"];

$(document).ready(function() {
	var table = $('#ranking').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
        "order": [[ 0, 'asc' ],[ 2, 'asc' ]],
        "displayLength": 25,
		"dom": 'C<"clear">lfrtip',
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="11">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
	doChunk();
	$('.toggle3').click(function(e){
		var j=$(this).closest('tr').data('id');
		var color='#'+(Math.floor(Math.random() * 105)+150).toString(16)+(Math.floor(Math.random() * 105)+150).toString(16)+(Math.floor(Math.random() * 105)+150).toString(16);
		if(!$(this).hasClass('shown')){
			$(this).addClass('shown').html('Hide');
			var rows=table.rows.add( tbl[j] ).draw()
						.nodes()
						.to$()
						.addClass( 'row-'+j )
						.css('backgroundColor',color);
			$(this).closest('td').css('backgroundColor',color);
			$('td:nth-child(1)','.row-'+j).each(function(index, element) {
                $(this).attr('data-search',site[tbl[j][index][1]]);
                $(this).attr('data-order',site[tbl[j][index][1]]);
                $(this).html('<img src="'+site_icon[tbl[j][index][1]]+'" />');
            });
			$('td:nth-child(6)','.row-'+j).each(function(index, element) {
                $(this).attr('data-sparkline',tbl[j][index][6]);
                $(this).attr('data-type',"Google Rank");
            });
			$('td:nth-child(8)','.row-'+j).each(function(index, element) {
                $(this).attr('data-sparkline',tbl[j][index][8]);
                $(this).attr('data-type',"Bing Rank");
            });
			$('td:nth-child(10)','.row-'+j).each(function(index, element) {
                $(this).attr('data-sparkline',tbl[j][index][10]);
                $(this).attr('data-type',"Yahoo Rank");
            });
			doChunk($('.row-'+j));
		}
		else{
			$(this).removeClass('shown').html('Show');
			var j=$(this).closest('tr').data('id');
			table.row('.row-'+j).remove().draw( );
			$(this).closest('td').css('backgroundColor','auto');
		}
		return false;
	});
	chart_val(dd);
	col_chart();

});

</script>
<style type="text/css">
tr.group,
tr.group:hover,.panel-body-tbl-onpage table tbody tr:nth-child(1)  {
    background:none;
	background-color: #ddd !important;
}
</style>