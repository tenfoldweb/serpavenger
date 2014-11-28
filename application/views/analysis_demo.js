function _renderSiteAge(base_url){
            $('#loader-site-age').show();
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/siteage',
        data: dataString,
        beforesend: function(){
            $('#contain-site-age').hide();
            $('#loader-site-age').show();
        },
        success: function(data){
            /* alert(data);
           return false;*/
            data = JSON.parse(data);            
            
            $('#loader-site-age').hide();
            $('#contain-site-age').show();
            var str = '<h3 id="site-age-heading">'+data.avg+'</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>New: </td><td> '+data.percentNew+'%</td>';
            str     +='<td>&nbsp;</td><td id="grpNewSiteAge"></td>';
            str     +='</tr><tr>';
            str     +='<td>Young: </td><td>'+data.percentYoung+'%</td>';
            str     +='<td>&nbsp;</td><td id="grpYoungSiteAge"></td>';
            str     +='</tr><tr>';
            str     +='<td>Old:  </td><td>'+data.percentOld+'%</td>';
            str     +='<td>&nbsp;</td><td  id="grpOldSiteAge"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave"><img src="'+base_url+'images/analysis_img5.jpg" alt=""></div>';
            
            /*<img src="'+base_url+'images/analysis_img4.jpg" alt="">*/
            //alert(str);
            $('#contain-site-age').html(str);
$('#grpOldSiteAge').html(data.oldnum);
$('#grpNewSiteAge').html(data.newnum);
$('#grpYoungSiteAge').html(data.youngnum);

$('#grpOldSiteAge').sparkline();
$('#grpNewSiteAge').sparkline();
$('#grpYoungSiteAge').sparkline();

//           $('#grpNewSiteAge').sparkline(data.newnum, {type: 'line', width: 80, lineColor: '#ef00bb'});
  //          $('#grpYoungSiteAge').sparkline(data.youngnum, {type: 'line', width: 80, lineColor: '#ef00bb'});
//            $('#grpOldSiteAge').sparkline(data.oldnum, {type: 'line', width: 80, lineColor: '#ef00bb', fillColor: '#CCDDFF'});
 
         /*    $('#grpNewSiteAge').sparkline(data.newnum);
            $('#grpYoungSiteAge').sparkline(data.youngnum);
            $('#grpOldSiteAge').sparkline(data.oldnum); */
            
            //$('#serp-profile-new-top3').html(data.percentNew2 + '%');
            //$('#serp-profile-new-top10').html(data.percentNew + '%');
            
            //$('#serp-profile-old-top3').html(data.percentOld2 + '%');
            //$('#serp-profile-old-top10').html(data.percentOld + '%');
        }
    });
}

function _renderSitePageCount(base_url) {
$('#loader-site-page-count').show();
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitepagecount',
        data: dataString,
        beforesend: function(){
            $('#contain-site-page-count').hide();
            $('#loader-site-page-count').show();
 	   
	


        },
        success: function(data){   
/*alert(data);
return false;         
*/
            data = JSON.parse(data);    
 $('#loader-site-page-count').hide();
            $('#contain-site-page-count').show();        
               var str = '<h3 id="site-page-count-heading">'+data.avgPage+' Pages</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>Min : </td><td> '+data.minPage+'</td>';
            str     +='<td>&nbsp;</td><td id="page_count_min_graph"></td>';
            str     +='</tr><tr>';
            str     +='<td>Max: </td><td>'+data.maxPage+'</td>';
            str     +='<td>&nbsp;</td><td id="page_count_max_graph"></td>';
            str     +='</tr><tr>';
            str     +='<td>+/- 10%:  </td><td>'+data.percent_10_num+' %</td>';
            str     +='<td>&nbsp;</td><td id="percent_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="page_avg_graph"></div>';

$('#contain-site-page-count').html(str);
$('#percent_data').html(data.graph_avg_page_percent);
$('#percent_data').sparkline();
$('#page_count_min_graph').html(data.graph_max_page);
$('#page_count_min_graph').sparkline();
$('#page_count_max_graph').html(data.graph_max_page);
$('#page_count_max_graph').sparkline();
$('#page_count_max_graph').html(data.graph_max_page);
$('#page_count_max_graph').sparkline();
$('#page_avg_graph').html(data.graph_avg_page);
$('#page_avg_graph').sparkline();


           /*
            $('#site-page-count-heading'). html(data.avgPage + ' Pages');
            $('#site-page-count-min').html(data.minPage);
            $('#site-page-count-max').html(data.maxPage);
            $('#site-page-count-avg').html(data.percent_10_num + '%');
*/
        }
    });
}

function _renderSiteWordCount(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitewordcount',
        data: dataString,
        beforesend: function(){
            $('#contain-site-word-count').hide();
            $('#loader-site-word-count').show();
        },
        success: function(data){
            /*
            alert(data);
            return false;
            */
            data = JSON.parse(data);          
            var str = '<h3 id="site-word-count-heading">'+data.avgWord+'Words</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>High : </td><td> '+data.maxWord+'</td>';
            str     +='<td>&nbsp;</td><td  id="word_max_graph"></td>';
            str     +='</tr><tr>';
            str     +='<td>Low: </td><td>'+data.minWord+'</td>';
            str     +='<td>&nbsp;</td><td id="word_min_graph"></td>';
            str     +='</tr><tr>';
            str     +='<td>&lt; '+data.avgWord+' :  </td><td>'+data.percent_below_avg+' %</td>';
            str     +='<td>&nbsp;</td><td id="word_percent_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="word_avg_graph"></div>';

            $('#contain-site-word-count').html(str);

            $('#loader-site-word-count').hide();
            $('#contain-site-word-count').show();
            $("#word_percent_data").html(data.graph_avg_word_percent);
            $('#word_percent_data').sparkline();
            $("#word_min_graph").html(data.graph_min_word);
            $('#word_min_graph').sparkline();
            $("#word_max_graph").html(data.graph_max_word);
            $('#word_max_graph').sparkline();
            
            $('#word_avg_graph').html(data.graph_avg_word);
            $('#word_avg_graph').sparkline();
           /* $('#site-word-count-heading'). html(data.avgWord + ' Words');
            $('#site-word-count-high').html(data.maxWord);
            $('#site-word-count-low').html(data.minWord);
            $('#site-word-count-avg_heading').html(data.avgWord);
            $('#site-word-count-avg').html(data.percent_below_avg + '%');*/
        }
    });
}

function _renderSiteKWRatio(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitekwratio',
        data: dataString,
        beforesend: function(){
            $('#contain-site-kw-ratio').hide();
            $('#loader-site-kw-ratio').show();
        },
        success: function(data){            
            /*  alert(data);
            return false;
          */
            data = JSON.parse(data);          
            var str = '<h3 id="site-word-count-heading">'+data.avgKW+'% KW</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>High : </td><td> '+data.maxKW+' %</td>';
            str     +='<td>&nbsp;</td><td id="keyword_max_percent_data"><img src="'+base_url+'images/analysis_img4.jpg" alt=""></td>';
            str     +='</tr><tr>';
            str     +='<td>Low: </td><td>'+data.minKW+' %</td>';
            str     +='<td>&nbsp;</td><td id="keyword_min_percent_data"><img src="'+base_url+'images/analysis_img4.jpg" alt=""></td>';
            str     +='</tr><tr>';
            str     +='<td>+/- 1%:  </td><td>'+data.percent_within_1+' %</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="keyword_percent_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="kw_avg_graph"><img src="'+base_url+'images/analysis_img5.jpg" alt=""></div>';

            $('#contain-site-kw-ratio').html(str);

            $("#keyword_percent_data").html(data.graph_avg_KW_percent);
            $('#keyword_percent_data').sparkline();
            
            $("#keyword_max_percent_data").html(data.graph_max_KW);
            $('#keyword_max_percent_data').sparkline();
            
            $("#keyword_min_percent_data").html(data.graph_min_KW);
            $('#keyword_min_percent_data').sparkline();
            
            $("#kw_avg_graph").html(data.graph_avg_KW);
            $('#kw_avg_graph').sparkline();
            
            
            $('#loader-site-kw-ratio').hide();
            $('#contain-site-kw-ratio').show();
           
        }
    });
}

function _renderSiteKWOptimization(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitekwoptimization',
        data: dataString,
        beforesend: function(){
            $('#contain-site-kw-optimization').hide();
            $('#loader-site-kw-optimization').show();
        },
        success: function(data){
            /* alert(data);
             return false;
            */
            data = JSON.parse(data);
            

            
             var str = '<h3 id="site-word-count-heading">KW Score '+data.mean+'</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>Title: </td><td> '+data.kwInTitlePercent+' %</td>';
            str     +='<td>&nbsp;</td><td id="kwo_title_percent_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Desc: </td><td>'+data.kwInMetaDescPercent+' %</td>';
            str     +='<td>&nbsp;</td><td id="kwo_desc_percent_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>H1: </td><td>'+data.kwInH1Percent+' %</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="kwo_h1_percent_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="kwo_avg_percent_data"></div>';

            $('#contain-site-kw-optimization').html(str);
            
            $("#kwo_title_percent_data").html(data.title_graph);
            $('#kwo_title_percent_data').sparkline();
            
            $("#kwo_desc_percent_data").html(data.desc_graph);
            $('#kwo_desc_percent_data').sparkline();
            
            $("#kwo_h1_percent_data").html(data.h1_graph);
            $('#kwo_h1_percent_data').sparkline();
            
            $("#kwo_avg_percent_data").html(data.mean_graph);
            $('#kwo_avg_percent_data').sparkline();
            
            $('#loader-site-kw-optimization').hide();
            $('#contain-site-kw-optimization').show();
            
        }
    });
}

function _renderSiteHidingLinks(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitehidinglinks',
        data: dataString,
        beforesend: function(){
            $('#contain-site-hiding-links').hide();
            $('#loader-site-hiding-links').show();
        },
        success: function(data){
            //alert(data);
            //return false;
            data = JSON.parse(data);          
            
              var str = '<h3 id="site-hiding-links-heading">'+data.percent+'% Hide Links</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>Min Count: </td><td> '+data.minHideLink+'</td>';
            str     +='<td>&nbsp;</td><td id="hidden_link_min_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Max Count: </td><td>'+data.maxHideLink+'</td>';
            str     +='<td>&nbsp;</td><td id="hidden_link_max_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Ave Count: </td><td>'+data.avgHideLink+'</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="hidden_link_percent_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="hidden_link_ave_data"></div>';

            $('#contain-site-hiding-links').html(str);
            
            $("#hidden_link_min_data").html(data.graph_min);
            $('#hidden_link_min_data').sparkline();
            
            $("#hidden_link_max_data").html(data.graph_max);
            $('#hidden_link_max_data').sparkline();
            
            $("#hidden_link_percent_data").html(data.graph_percent);
            $('#hidden_link_percent_data').sparkline();
            
            $("#hidden_link_ave_data").html(data.graph_avg);
            $('#hidden_link_ave_data').sparkline();
            
            $('#loader-site-hiding-links').hide();
            $('#contain-site-hiding-links').show();
          
        }
    });
}

function _renderSiteExternalLinks(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/siteexternallinks',
        data: dataString,
        beforesend: function(){
            $('#contain-site-external-links').hide();
            $('#loader-site-external-links').show();
        },
        success: function(data){
            alert(data);
            return false;
        
            data = JSON.parse(data);          
            
            var str = '<h3 id="site-hiding-links-heading">'+data.percent+'% Link Out</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>Min Count: </td><td> '+data.minExtrnLink+'</td>';
            str     +='<td>&nbsp;</td><td id="hidden_link_min_percent_data"><img src="'+base_url+'images/analysis_img4.jpg" alt=""></td>';
            str     +='</tr><tr>';
            str     +='<td>Max Count: </td><td>'+data.maxExtrnLink+'</td>';
            str     +='<td>&nbsp;</td><td id="hidden_link_max_percent_data"><img src="'+base_url+'images/analysis_img4.jpg" alt=""></td>';
            str     +='</tr><tr>';
            str     +='<td>Ave Count: </td><td>'+data.avgExtrnLink+'</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="hidden_link_ave_percent_data"><img src="'+base_url+'images/analysis_img4.jpg" alt=""></td>';
            str     +='</tr></table>';
            str     +='<div class="wave"><img src="'+base_url+'images/analysis_img5.jpg" alt=""></div>';

            $('#contain-site-external-links').html(str);
            
            $('#loader-site-external-links').hide();
            $('#contain-site-external-links').show();
            
        }
    });
}

function _renderSiteExactKWAnchor(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/siteexactkwanchors',
        data: dataString,
        beforesend: function(){
            $('#contain-site-exact-kw-anchor').hide();
            $('#loader-site-exact-kw-anchor').show();
        },
        success: function(data){
            
           // alert(data);
           // return false;
            data = JSON.parse(data);          
            
             var str = '<h3 id="site-hiding-links-heading">'+data.avgExactMatch+' Links</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>High: </td><td> '+data.maxExactMatch+'</td>';
            str     +='<td>&nbsp;</td><td id="eaxct_link_min_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Low: </td><td>'+data.minExactMatch+'</td>';
            str     +='<td>&nbsp;</td><td id="exact_link_max_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Link %: </td><td>'+data.percent+'</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="percent_exact_link_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="exact_link_ave_data"></div>';

            $('#contain-site-exact-kw-anchor').html(str);
            
            $("#eaxct_link_min_data").html(data.min_graph);
            $('#eaxct_link_min_data').sparkline();
            
            $("#exact_link_max_data").html(data.max_graph);
            $('#exact_link_max_data').sparkline();
            
            $("#exact_link_ave_data").html(data.avg_graph);
            $('#exact_link_ave_data').sparkline();
            
            $("#percent_exact_link_data").html(data.percent_graph);
            $('#percent_exact_link_data').sparkline();
            
            
            $('#loader-site-exact-kw-anchor').hide();
            $('#contain-site-exact-kw-anchor').show();
            
            /*$('#site-exact-kw-anchor-heading'). html(data.avgExactMatch + ' Links');
            $('#site-exact-kw-anchor-high').html(data.maxExactMatch);
            $('#site-exact-kw-anchor-low').html(data.minExactMatch);            
            $('#site-exact-kw-anchor-percent').html(data.percent);
            */
        }
    });
}

function _renderSiteLongTermPageOneRank(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitelongtermpageonerank',
        data: dataString,
        beforesend: function(){
            $('#contain-site-long-term-page-one-rank').hide();
            $('#loader-site-long-term-page-one-rank').show();
        },
        success: function(data){            
            data = JSON.parse(data);          
            
            $('#loader-site-long-term-page-one-rank').hide();
            $('#contain-site-long-term-page-one-rank').show();
            
            $('#long-term-page-one-rank-percent'). html(data.percent + '%');            
        }
    });
}

function _renderSiteOnePageElements(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitelongtermpageonerank',
        data: dataString,
        beforesend: function(){
            $('#contain-site-one-page-elements').hide();
            $('#loader-site-site-one-page-elements').show();
        },
        success: function(data){            
            data = JSON.parse(data);          
            
            $('#loader-site-site-one-page-elements').hide();
            $('#contain-site-one-page-elements').show();
        }
    });
}

function _renderSiteStat(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/siteStat',
        data: dataString,
        beforesend: function(){
            $('#content-new-site').hide();
            $('#loader-new-site').show();
            $('#content-old-site').hide();
            $('#loader-old-site').show();
        },
        success: function(data){
           // alert(data);
            data = JSON.parse(data);          
            
             var new_str = '';
            new_str     += '<div class="mapArea">';
            new_str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            new_str     +='<tr>';
            new_str     +='<td>Top  3: </td>';
            new_str     +='<td>&nbsp;</td><td id="new_top_three"></td>';
            new_str     +='<td>&nbsp;</td><td> '+data.new.top_three+'%</td>'
            new_str     +='</tr><tr>';
            new_str     +='<td>Top 10: </td>';
            new_str     +='<td>&nbsp;</td><td id="new_top_ten"></td>';
            new_str     +='<td>&nbsp;</td><td>'+data.new.top_ten+'%</td>'
            new_str     +='</tr></table>';
            

            $('#content-new-site').html(new_str);
            $("#new_top_three").html(data.new.top_three_graph);
            $('#new_top_three').sparkline();
            $("#new_top_ten").html(data.new.top_ten_graph);
            $('#new_top_ten').sparkline();
            
            
            $('#content-new-site').show();
            $('#loader-new-site').hide();
            
            
            var old_str = '';
            old_str     += '<div class="mapArea">';
            old_str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            old_str     +='<tr>';
            old_str     +='<td>Top  3: </td>';
            old_str     +='<td>&nbsp;</td><td id="old_top_three"></td>';
            old_str     +='<td>&nbsp;</td><td> '+data.old.top_three+'%</td>'
            old_str     +='</tr><tr>';
            old_str     +='<td>Top 10: </td>';
            old_str     +='<td>&nbsp;</td><td id="old_top_ten"></td>';
            old_str     +='<td>&nbsp;</td><td>'+data.old.top_ten+'%</td>'
            old_str     +='</tr></table>';
            

            $('#content-old-site').html(old_str);
            $("#old_top_three").html(data.old.top_three_graph);
            $('#old_top_three').sparkline();
            $("#old_top_ten").html(data.old.top_ten_graph);
            $('#old_top_ten').sparkline();
            
            
            $('#content-old-site').show();
            $('#loader-old-site').hide();
        }
    });
}

function _renderSiteOnPageElement(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
            $('#new-site-onpage-content').hide();
            //$('#old-site-onpage-content').hide();
            $("#aged-link").css('font-weight','bold');
            $('#long-tarm-onpage-content').hide();
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/randeronpageelement',
        data: dataString,
        beforesend: function(){
           
            //$('#loader-old-site').show();
            //$('#loader-new-site').show();
        },
        success: function(data){
           // alert(data); 
            // $("#old-site-onpage-content").html(data);            
            //return false;
            
            data = JSON.parse(data);
            var main_str_top ='<div class="rating_inner">';
                main_str_top +='<table width="100%" border="1" cellspacing="0" cellpadding="0">';
                main_str_top +='<tr><td width="20%">&nbsp;</td>';
                main_str_top +='<td><p>Title</p></td>';
                main_str_top +='<td><p>URL</p></td>';
                main_str_top +='<td><p>Descr</p></td>';
                main_str_top +='<td><p>H1</p></td>';
                main_str_top +='<td><p>H2</p></td>';
                main_str_top +='<td><p>Above Fold</p></td>';
                main_str_top +='<td><p>Image</p></td>';
                main_str_top +='<td><p>Words</p></td>';
                main_str_top +='<td><p>Min/ Max</p></td>';
                main_str_top +='<td><p> KW%</p></td>';
                main_str_top +='<td><p>Min/ Max</p></td>';
                main_str_top +='<td><p>Ext Link</p></td>';
                main_str_top +='</tr>';
                
              var main_str_bottom ='</table>';
                  main_str_bottom +='</div>';
                  
            var new_site_str='';
            if (Object.keys(data.new).length >0) {
                
                new_site_str +=main_str_top;
                new_site_str +='<tr>';
                new_site_str+='<td><p><span>TOP 3</span></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_three.title+'%';
                if (Number(data.new.current.top_three.title) >= Number(data.new.past.top_three.title) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_three.url+'%';
                if (Number(data.new.current.top_three.url) >= Number(data.new.past.top_three.url) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                new_site_str+='<td><p>'+data.new.current.top_three.dec+'%';
                if (Number(data.new.current.top_three.dec) >= Number(data.new.past.top_three.dec) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str +='<td><p>'+data.new.current.top_three.h1+'%';
                if (Number(data.new.current.top_three.h1) >= Number(data.new.past.top_three.h1) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                new_site_str +='<td><p>'+data.new.current.top_three.h2+'%';
                if (Number(data.new.current.top_three.h2) >= Number(data.new.past.top_three.h2) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                new_site_str +='<td><p>0<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_three.word;
                if (Number(data.new.current.top_three.word) >= Number(data.new.past.top_three.word) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_three.min_word+'/'+data.new.current.top_three.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_three.kw+'%';
                
                if (Number(data.new.current.top_three.kw) >= Number(data.new.past.top_three.kw) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_three.min_kw+'%/'+data.new.current.top_three.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_three.el_percent+'%';
                
                if (Number(data.new.current.top_three.el_percent) >= Number(data.new.past.top_three.el_percent) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                new_site_str +='('+data.new.current.top_three.el_avg+')</p></td>';
                new_site_str+='</tr>';
                
                new_site_str +='<tr>';
                new_site_str+='<td><p><span>TOP 10</span></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_ten.title+'%';
                if (Number(data.new.current.top_ten.title) >= Number(data.new.past.top_ten.title) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_ten.url+'%';
                if (Number(data.new.current.top_ten.url) >= Number(data.new.past.top_ten.url) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                new_site_str+='<td><p>'+data.new.current.top_ten.dec+'%';
                if (Number(data.new.current.top_ten.dec) >= Number(data.new.past.top_ten.dec) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str +='<td><p>'+data.new.current.top_ten.h1+'%';
                if (Number(data.new.current.top_ten.h1) >= Number(data.new.past.top_ten.h1) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                new_site_str +='<td><p>'+data.new.current.top_ten.h2+'%';
                if (Number(data.new.current.top_ten.h2) >= Number(data.new.past.top_ten.h2) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                new_site_str +='<td><p>0<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_ten.word;
                if (Number(data.new.current.top_ten.word) >= Number(data.new.past.top_ten.word) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_ten.min_word+'/'+data.new.current.top_ten.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_ten.kw+'%';
                
                if (Number(data.new.current.top_ten.kw) >= Number(data.new.past.top_ten.kw) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
                
                new_site_str+='<td><p>'+data.new.current.top_ten.min_kw+'%/'+data.new.current.top_ten.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                new_site_str+='<td><p>'+data.new.current.top_ten.el_percent+'%';
                
                if (Number(data.new.current.top_ten.el_percent) >= Number(data.new.past.top_ten.el_percent) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                new_site_str +='('+data.new.current.top_ten.el_avg+')</p></td>';
                new_site_str+='</tr>';
                new_site_str +=main_str_bottom;
            }
            $("#new-site-onpage-content").html(new_site_str);
            
            var old_site_str='';
            if (Object.keys(data.old).length >0) {
                old_site_str +=main_str_top;
                 old_site_str +='<tr>';
                old_site_str+='<td><p><span>TOP 3</span></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_three.title+'%';
                if (Number(data.old.current.top_three.title) >= Number(data.old.past.top_three.title) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_three.url+'%';
                if (Number(data.old.current.top_three.url) >= Number(data.old.past.top_three.url) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                old_site_str+='<td><p>'+data.old.current.top_three.dec+'%';
                if (Number(data.old.current.top_three.dec) >= Number(data.old.past.top_three.dec) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str +='<td><p>'+data.old.current.top_three.h1+'%';
                if (Number(data.old.current.top_three.h1) >= Number(data.old.past.top_three.h1) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                old_site_str +='<td><p>'+data.old.current.top_three.h2+'%';
                if (Number(data.old.current.top_three.h2) >= Number(data.old.past.top_three.h2) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                old_site_str +='<td><p>0<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_three.word;
                if (Number(data.old.current.top_three.word) >= Number(data.old.past.top_three.word) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_three.min_word+'/'+data.old.current.top_three.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_three.kw+'%';
                
                if (Number(data.old.current.top_three.kw) >= Number(data.old.past.top_three.kw) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_three.min_kw+'%/'+data.old.current.top_three.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_three.el_percent+'%';
                
                if (Number(data.old.current.top_three.el_percent) >= Number(data.old.past.top_three.el_percent) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                old_site_str +='('+data.old.current.top_three.el_avg+')</p></td>';
                old_site_str+='</tr>';
                
                old_site_str +='<tr>';
                old_site_str+='<td><p><span>TOP 10</span></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_ten.title+'%';
                if (Number(data.old.current.top_ten.title) >= Number(data.old.past.top_ten.title) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_ten.url+'%';
                if (Number(data.old.current.top_ten.url) >= Number(data.old.past.top_ten.url) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                old_site_str+='<td><p>'+data.old.current.top_ten.dec+'%';
                if (Number(data.old.current.top_ten.dec) >= Number(data.old.past.top_ten.dec) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str +='<td><p>'+data.old.current.top_ten.h1+'%';
                if (Number(data.old.current.top_ten.h1) >= Number(data.old.past.top_ten.h1) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                old_site_str +='<td><p>'+data.old.current.top_ten.h2+'%';
                if (Number(data.old.current.top_ten.h2) >= Number(data.old.past.top_ten.h2) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                old_site_str +='<td><p>0<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_ten.word;
                if (Number(data.old.current.top_ten.word) >= Number(data.old.past.top_ten.word) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_ten.min_word+'/'+data.old.current.top_ten.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_ten.kw+'%';
                
                if (Number(data.old.current.top_ten.kw) >= Number(data.old.past.top_ten.kw) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
                
                old_site_str+='<td><p>'+data.old.current.top_ten.min_kw+'%/'+data.old.current.top_ten.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                old_site_str+='<td><p>'+data.old.current.top_ten.el_percent+'%';
                
                if (Number(data.old.current.top_ten.el_percent) >= Number(data.old.past.top_ten.el_percent) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                old_site_str +='('+data.old.current.top_ten.el_avg+')</p></td>';
                old_site_str+='</tr>';
                
                old_site_str +=main_str_bottom;
            }
            $("#old-site-onpage-content").html(old_site_str);
            
            var long_term_str='';
            long_term_str +=main_str_top;
            long_term_str +='<tr>';
            long_term_str+='<td><p><span>TOP 3</span></p></td>';
            long_term_str+='<td><p>100%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>40%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str+='<td><p>80%<img src="'+base_url+'images/green_arrow.jpg">50%</p></td>';
            long_term_str +='<td><p>10%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str +='<td><p>75%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str +='<td><p>10%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str +='<td><p>429<img src="'+base_url+'images/green_arrow.jpg">52/</p></td>';
            long_term_str+='<td><p>15282<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>0%/8%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>2%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>0%/1%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>60%<img src="'+base_url+'images/green_arrow.jpg">(3)</p></td>';
            long_term_str+='</tr>';
            
            long_term_str+='<tr>';
            long_term_str+='<td><p><span>TOP 10</span></p></td>';
            long_term_str+='<td><p>100%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>40%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str+='<td><p>80%<img src="'+base_url+'images/green_arrow.jpg">50%</p></td>';
            long_term_str +='<td><p>10%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str +='<td><p>75%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str+='<td><p>10%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
            long_term_str+='<td><p>429<img src="'+base_url+'images/green_arrow.jpg">52/</p></td>';
            long_term_str+='<td><p>15282<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>0%/8%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>2%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>0%/1%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
            long_term_str+='<td><p>60%<img src="'+base_url+'images/green_arrow.jpg">(3)</p></td>';
            long_term_str +='</tr>';
            long_term_str +=main_str_bottom;
            $("#long-tarm-onpage-content").html(long_term_str);
            
            
        }
    });
    
}

function _renderSiteLinkElement(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitelinkelement',
        data: dataString,
        beforesend: function(){
            $('#contain-link-element').hide();
            $('#loader-link-element').show();            
        },
        success: function(data){
           //alert(data);
           data = JSON.parse(data);
           
           var doughnutData1 = [
                    {
                            value : data.Redirect,
                            color : "#264061"
                    },
                    {
                            value : data.NotRedirect,
                            color : "#366092"
                    }            
            ];
           
            var myDoughnut1 = new Chart(document.getElementById("canvas301Redirect").getContext("2d")).Doughnut(doughnutData1);
            
            var doughnutData2 = [
                    {
                            value : data.NoFollow,
                            color : "#264061"
                    },
                    {
                            value : data.DoFollow,
                            color : "#366092"
                    }
            
            ];
           
            var myDoughnut2 = new Chart(document.getElementById("canvasFollow").getContext("2d")).Doughnut(doughnutData2);
            
            var doughnutData3 = [
                    {
                            value : data.SiteWide,
                            color : "#264061"
                    },
                    {
                            value : data.NotSideWide,
                            color : "#366092"
                    }
            
            ];
           
            var myDoughnut3 = new Chart(document.getElementById("canvasSiteWide").getContext("2d")).Doughnut(doughnutData3);
            
            
            var doughnutData4 = [
                    {
                            value : data.Text,
                            color : "#264061"
                    },
                    {
                            value : data.Image,
                            color : "#366092"
                    }
            
            ];

            var myDoughnut4 = new Chart(document.getElementById("canvasTextImage").getContext("2d")).Doughnut(doughnutData4);
        }
    });

}

$(function(){
    $("#new-site-link").click(function(){
        $(".onpage-element-box").fadeOut();
        $("#new-site-onpage-content").fadeIn();
        $('.sub-link-lable').css('font-weight','normal');
        $(this).css('font-weight','bold');
        });
    $("#aged-link").click(function(){
        $(".onpage-element-box").fadeOut();
        $("#old-site-onpage-content").fadeIn();
        $('.sub-link-lable').css('font-weight','normal');
        $(this).css('font-weight','bold');
        });
    $("#long-tarm-link").click(function(){
        $(".onpage-element-box").fadeOut();
        $("#long-tarm-onpage-content").fadeIn();
        $('.sub-link-lable').css('font-weight','normal');
        $(this).css('font-weight','bold');
    });
});


function _setDynmicData(base_url){
    _renderSiteAge(base_url);
    _renderSitePageCount(base_url);
    _renderSiteWordCount(base_url);
    _renderSiteKWRatio(base_url);
    _renderSiteKWOptimization(base_url);
    _renderSiteHidingLinks(base_url);
    _renderSiteExternalLinks(base_url);
    _renderSiteExactKWAnchor(base_url);
    //_renderSiteLongTermPageOneRank(base_url);
    
    _renderSiteStat(base_url);
    _renderSiteOnPageElement(base_url);
    _renderSiteLinkElement(base_url);
}

$(document).ready(function(){
    var base_url_suffix	= 'serp-new/';
    var base_url = location.protocol + '//' + location.host + '/' + base_url_suffix;
    _setDynmicData(base_url)
    
    
    $('#campaign_list').change(function(){
       _setDynmicData(base_url)
    });

    $('#campaign_server_engine').change(function(){
       _setDynmicData(base_url)
    });



});
