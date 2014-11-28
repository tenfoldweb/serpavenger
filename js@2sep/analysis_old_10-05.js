function _renderSiteAge(base_url,type){
            $('#loader-site-age').show();
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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
            str     +='<div class="wave" id="avg_age_graph"></div>';
            
            /*<img src="'+base_url+'images/analysis_img4.jpg" alt="">*/
            //alert(str);
            $('#contain-site-age').html(str);
$('#grpOldSiteAge').html(data.oldnum);
$('#grpNewSiteAge').html(data.newnum);
$('#grpYoungSiteAge').html(data.youngnum);
$('#avg_age_graph').html(data.avgAge14);



$('#grpOldSiteAge').sparkline();
$('#grpNewSiteAge').sparkline();
$('#grpYoungSiteAge').sparkline();
$('#avg_age_graph').sparkline();

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

function _renderSitePageCount(base_url,type) {
$('#loader-site-page-count').show();
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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

function _renderSiteWordCount(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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

function _renderSiteKWRatio(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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

function _renderSiteKWOptimization(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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

function _renderSiteHidingLinks(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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

function _renderSocialLinks(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/socialLinks',
        data: dataString,
        beforesend: function(){
            $('#contain-share-signal').hide();
            $('#loader-share-signal').show();
        },
        success: function(data){
            //alert(data);
           // return false;
            data = JSON.parse(data);          
            
              var str = '<h3 id="site-hiding-links-heading">Social Score 50 </h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>FB Likes: </td><td> '+data.fb_like_per+'%</td>';
            str     +='<td>&nbsp;</td><td>('+data.fb_like_avg+')</td>';
            str     +='</tr><tr>';
            str     +='<td>FB Share: </td><td>'+data.fb_share_per+'%</td>';
            str     +='<td>&nbsp;</td><td>('+data.fb_share_avg+')</td>';
            str     +='</tr><tr>';
            str     +='<td>G+: </td><td>'+data.go_like_per+'%</td>';
            str     +='<td>&nbsp;&nbsp;</td><td>('+data.go_like_avg+')</td>';
            str     +='</tr><tr>';
            str     +='<td>Tweets: </td><td>'+data.t_like_per+'%</td>';
            str     +='<td>&nbsp;&nbsp;</td><td>('+data.t_like_avg+')</td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="hidden_link_ave_data"></div>';

            $('#contain-share-signal').html(str);
            
            $('#loader-share-signal').hide();
            $('#contain-share-signal').show();
          
        }
    });
}

function _renderSiteExternalLinks(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/siteexternallinks',
        data: dataString,
        beforesend: function(){
            $('#contain-site-external-links').hide();
            $('#loader-site-external-links').show();
        },
        success: function(data){
           // alert(data);
           // return false;
        
            data = JSON.parse(data);          
            
            var str = '<h3 id="site-hiding-links-heading">'+data.percent+'% Link Out</h3>';
            str     += '<div class="mapArea">';
            str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            str     +='<tr>';
            str     +='<td>Min Count: </td><td> '+data.minExtrnLink+'</td>';
            str     +='<td>&nbsp;</td><td id="ex_link_min_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Max Count: </td><td>'+data.maxExtrnLink+'</td>';
            str     +='<td>&nbsp;</td><td id="ex_link_max_data"></td>';
            str     +='</tr><tr>';
            str     +='<td>Ave Count: </td><td>'+data.avgExtrnLink+'</td>';
            str     +='<td>&nbsp;&nbsp;</td><td id="ex_link_ave_data"></td>';
            str     +='</tr></table>';
            str     +='<div class="wave" id="ex_link_percent_data"></div>';

            $('#contain-site-external-links').html(str);
            
            $("#ex_link_min_data").html(data.graph_min);
            $('#ex_link_min_data').sparkline();
            
            $("#ex_link_max_data").html(data.graph_max);
            $('#ex_link_max_data').sparkline();
            
            $("#ex_link_percent_data").html(data.graph_percent);
            $('#ex_link_percent_data').sparkline();
            
            $("#ex_link_ave_data").html(data.graph_avg);
            $('#ex_link_ave_data').sparkline();
            
            $('#loader-site-external-links').hide();
            $('#contain-site-external-links').show();
            
        }
    });
}

function _renderSiteExactKWAnchor(base_url,type){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    dataString +='&site_type='+type;
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
            $('#content-rec-site').hide();
            $('#loader-rec-site').show();
            
        },
        success: function(data){
            //alert(data);
            //return  false;
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
            
            
            var rec_str = '';
            rec_str     += '<div class="mapArea">';
            rec_str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
            rec_str     +='<tr>';
            rec_str     +='<td>Top  3: </td>';
            rec_str     +='<td>&nbsp;</td><td id="rec_top_three"></td>';
            rec_str     +='<td>&nbsp;</td><td> '+data.recovery.top_three+'%</td>'
            rec_str     +='</tr><tr>';
            rec_str     +='<td>Top 10: </td>';
            rec_str     +='<td>&nbsp;</td><td id="rec_top_ten"></td>';
            rec_str     +='<td>&nbsp;</td><td>'+data.recovery.top_ten+'%</td>'
            rec_str     +='</tr></table>';
            

            $('#content-rec-site').html(rec_str);
            $("#rec_top_three").html(data.recovery.top_three_graph);
            $('#rec_top_three').sparkline();
            $("#rec_top_ten").html(data.recovery.top_ten_graph);
            $('#rec_top_ten').sparkline();
            
            $('#content-rec-site').show();
            $('#loader-rec-site').hide();
            
            
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
            if (Object.keys(data.new).length >0 && Object.keys(data.new.current).length >0 && Object.keys(data.new.past).length >0) {
                
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
                new_site_str +='<td><p>'+data.new.current.top_three.image+'';
                if (Number(data.new.current.top_three.image) >= Number(data.new.past.top_three.image) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
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
                new_site_str +='<td><p>'+data.new.current.top_ten.image+'';
                if (Number(data.new.current.top_ten.image) >= Number(data.new.past.top_ten.image) ) {
                    new_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    new_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                new_site_str+='</p></td>';
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
            if (Object.keys(data.old).length >0 && Object.keys(data.old.current).length >0 && Object.keys(data.old.past).length >0) {
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
                old_site_str +='<td><p>'+data.old.current.top_three.image+'';
                if (Number(data.old.current.top_three.image) >= Number(data.old.past.top_three.image) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
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
                old_site_str +='<td><p>'+data.old.current.top_ten.image+'';
                if (Number(data.old.current.top_ten.image) >= Number(data.old.past.top_ten.image) ) {
                    old_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    old_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                old_site_str+='</p></td>';
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
            
            var long_site_str='';
            if (Object.keys(data.long).length >0 && Object.keys(data.long.current).length >0 && Object.keys(data.long.past).length >0) {
                
                long_site_str +=main_str_top;
                long_site_str +='<tr>';
                long_site_str+='<td><p><span>TOP 3</span></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_three.title+'%';
                if (Number(data.long.current.top_three.title) >= Number(data.long.past.top_three.title) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_three.url+'%';
                if (Number(data.long.current.top_three.url) >= Number(data.long.past.top_three.url) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str+='<td><p>'+data.long.current.top_three.dec+'%';
                if (Number(data.long.current.top_three.dec) >= Number(data.long.past.top_three.dec) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str +='<td><p>'+data.long.current.top_three.h1+'%';
                if (Number(data.long.current.top_three.h1) >= Number(data.long.past.top_three.h1) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str +='<td><p>'+data.long.current.top_three.h2+'%';
                if (Number(data.long.current.top_three.h2) >= Number(data.long.past.top_three.h2) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                long_site_str +='<td><p>'+data.long.current.top_three.image+'';
                if (Number(data.long.current.top_three.image) >= Number(data.long.past.top_three.image) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str+='<td><p>'+data.long.current.top_three.word;
                if (Number(data.long.current.top_three.word) >= Number(data.long.past.top_three.word) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_three.min_word+'/'+data.long.current.top_three.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_three.kw+'%';
                
                if (Number(data.long.current.top_three.kw) >= Number(data.long.past.top_three.kw) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_three.min_kw+'%/'+data.long.current.top_three.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_three.el_percent+'%';
                
                if (Number(data.long.current.top_three.el_percent) >= Number(data.long.past.top_three.el_percent) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                long_site_str +='('+data.long.current.top_three.el_avg+')</p></td>';
                long_site_str+='</tr>';
                
                long_site_str +='<tr>';
                long_site_str+='<td><p><span>TOP 10</span></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_ten.title+'%';
                if (Number(data.long.current.top_ten.title) >= Number(data.long.past.top_ten.title) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_ten.url+'%';
                if (Number(data.long.current.top_ten.url) >= Number(data.long.past.top_ten.url) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str+='<td><p>'+data.long.current.top_ten.dec+'%';
                if (Number(data.long.current.top_ten.dec) >= Number(data.long.past.top_ten.dec) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str +='<td><p>'+data.long.current.top_ten.h1+'%';
                if (Number(data.long.current.top_ten.h1) >= Number(data.long.past.top_ten.h1) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str +='<td><p>'+data.long.current.top_ten.h2+'%';
                if (Number(data.long.current.top_ten.h2) >= Number(data.long.past.top_ten.h2) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str +='<td><p>0%<img src="'+base_url+'images/red_arrow.jpg"></p></td>';
                long_site_str +='<td><p>'+data.long.current.top_ten.image+'';
                if (Number(data.long.current.top_ten.image) >= Number(data.long.past.top_ten.image) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                long_site_str+='<td><p>'+data.long.current.top_ten.word;
                if (Number(data.long.current.top_ten.word) >= Number(data.long.past.top_ten.word) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_ten.min_word+'/'+data.long.current.top_ten.max_word+'<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_ten.kw+'%';
                
                if (Number(data.long.current.top_ten.kw) >= Number(data.long.past.top_ten.kw) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                long_site_str+='</p></td>';
                
                long_site_str+='<td><p>'+data.long.current.top_ten.min_kw+'%/'+data.long.current.top_ten.max_kw+'%<img src="'+base_url+'images/green_arrow.jpg"></p></td>';
                long_site_str+='<td><p>'+data.long.current.top_ten.el_percent+'%';
                
                if (Number(data.long.current.top_ten.el_percent) >= Number(data.long.past.top_ten.el_percent) ) {
                    long_site_str+='<img src="'+base_url+'images/green_arrow.jpg">';    
                }else{
                    long_site_str+='<img src="'+base_url+'images/red_arrow.jpg">';
                }
                
                long_site_str +='('+data.long.current.top_ten.el_avg+')</p></td>';
                long_site_str+='</tr>';
                long_site_str +=main_str_bottom;
            }
            $("#long-tarm-onpage-content").html(long_site_str);
            
            
        }
    });
    
}

function _renderSiteLinkElement(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    var linkelement_search_type          = $('#linkelement_search_type').val(); 
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine) + '&linkelement_search_type=' + encodeURIComponent(linkelement_search_type);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis_demo/sitelinkelement',
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

function _renderSiteAnalysisComparison(base_url) {
            var campaign_list               = $('#campaign_list').val();
            var campaign_server_engine      = $('#campaign_server_engine').val();
            var keyword_value               = $('#keyword_value').val();
           //alert(keyword_value); 
            var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine) + '&keyword_value='+encodeURIComponent(keyword_value);
            $.ajax({
                type: 'post',
                url: base_url + 'renderanalysis_demo/siteanalysiscomparison',
                data: dataString,
                beforesend: function(){
                    $('#contain-analysis-comparison').hide();
                    $('#loader-analysis-comparison').show();            
                },
                success: function(data){
                    $('#contain-analysis-comparison').show();
                    $('#loader-analysis-comparison').hide();
                    //alert(data);
                    data = JSON.parse(data);
                    //alert(data.site_age);
                    $('#search_url').text(data.url);
                    $('#site_rank').text(data.current_rank);
                    $('#site_age').text(data.site_age);
                    $('#position_change').text(data.position_change);
                    $('#starting_rank').text(data.starting_rank);
                    $('#page_size').text(data.domain_page_count);
                    $('#domain_word_count').text(data.domain_page_count);
                    $('#keyword_ratio').text(data.domain_kw_ratio);
                    $('#keyword_title').text(data.keyword_in_title);
                    $('#keyword_desc').text(data.keyword_in_meta_desc);
                    $('#keyword_h1').text(data.keyword_in_h1);
                    $('#home_page').text(data.home_page);
                    $('#home_page10').text(data.home_page10);
                    $('#home_page20').text(data.home_page20);
                    $('#site_keyword').text(data.keyword);
                    $('#comparision_image').attr('src', image_path+data.campaign_murl_thumb);
                }
            });
}

function _renderSerpMeter(base_url) {
            var campaign_list               = $('#campaign_list').val();
            var campaign_server_engine      = $('#campaign_server_engine').val();
           
          
            var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine) ;
            $.ajax({
                type: 'post',
                url: base_url + 'renderanalysis_demo/renderserpmeter',
                data: dataString,
                beforesend: function(){
                               
                },
                success: function(data){
                    
                    
                    data = JSON.parse(data);
                    //alert(data.today);
                    $('#today_meter').text(data.today);
                    $('#yesterday_meter').text(data.yesterday);
                  
                }
            });      
}
function _renderLongTermSite(base_url){
    var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
    var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
    $.ajax({
        type: 'post',
        url: base_url + 'renderanalysis/sitelongterm',
        data: dataString,
        beforesend: function(){
            $('#content-long-term-site').hide();
            $('#loader-long-term-site').show();            
        },
        success: function(data){
           //alert(data);
            //$('#content-long-term-site').html(data);
           //return false;
           data = JSON.parse(data);
           
           var str ="";
           str +='<div class="para">'+ data.percent_data +'% Ranking for 60+ Days </div>';
           str +='<div id="long_term_percent_graph"></div>';
           
           $('#content-long-term-site').html(str);
           $("#long_term_percent_graph").html(data.graph_data);
            $('#long_term_percent_graph').sparkline();
            
           $('#content-long-term-site').show();
           $('#loader-long-term-site').hide();            
        }
    });
}

function _renderLinkGraphSite(base_url) {
      var campaign_list               = $('#campaign_list').val();
      var campaign_server_engine      = $('#campaign_server_engine').val();
    
        var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
        $.ajax({
            type: 'post',
            url: base_url + 'renderanalysis/siteLinkGraph',
            data: dataString,
            beforesend: function(){
                $('#match_keyword_box').hide();
                //$('#loader-frace-ness').show();            
            },
            success: function(data){
                //alert(data);
                //return false;
                 /*str +='<div class="matchProgressRt">';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanOne"><em style="width:95%"><strong>95%</strong></em></span>';
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanTwo"><em style="width:47%"><strong>47%</strong></em></span>'
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanThree"><em style="width:100%"><strong>100%</strong></em></span>';
                str +='</div>';*/
                 
                data = JSON.parse(data);            
                
               
                var str = '';
                str +='<div class="matchProgressdiv clearfix ">';
                str +='<div class="matchProgressLt">'
                str +='<span class="textMatch">Exact Match %</span>';
                str +='<p id="ex_match_link_graph"></p>'
                str +='</div>';
                str +='<div class="matchProgressRt">';
                 str +='<div class="colorDiv">';
                 var ex_link=data.percent_ex_link;
                 var ex_link_split=ex_link.split(',');
                str +='<span class="colorSpanOne"><em style="width:'+ex_link_split[0]+'%"><strong>'+ex_link_split[0]+'%</strong></em></span>';
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanTwo"><em style="width:'+ex_link_split[1]+'%"><strong>'+ex_link_split[1]+'%</strong></em></span>'
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanThree"><em style="width:'+ex_link_split[2]+'%"><strong>'+ex_link_split[2]+'%</strong></em></span>';
                str +='</div>';
                str +='</div>';
                
                str +='</div>';
                str +='</div>';
                
                str +='<div class="matchProgressdiv clearfix ">';
                str +='<div class="matchProgressLt">'
                str +='<span class="textMatch">Blended %</span>';
                str +='<p id="blended_link_graph"></p>'
                str +='</div>';
                var blanded_link=data.percent_blanded_link;
                 var blanded_link_split=blanded_link.split(',');
                str +='<div class="matchProgressRt">';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanOne"><em style="width:'+blanded_link_split[0]+'%"><strong>'+blanded_link_split[0]+'%</strong></em></span>';
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanTwo"><em style="width:'+blanded_link_split[1]+'%"><strong>'+blanded_link_split[1]+'%</strong></em></span>'
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanThree"><em style="width:'+blanded_link_split[2]+'%"><strong>'+blanded_link_split[2]+'%</strong></em></span>';
                str +='</div>';
                str +='</div>';
                
                
                str +='</div>';
                str +='</div>';
                
                str +='<div class="matchProgressdiv clearfix ">';
                str +='<div class="matchProgressLt">'
                str +='<span class="textMatch">Brand %</span>';
                str +='<p id="brand_link_graph"></p>'
                str +='</div>';
                var brand_link=data.percent_brand_link;
                 var brand_link_split=blanded_link.split(',');
                str +='<div class="matchProgressRt">';
                 str +='<div class="colorDiv">';
                str +='<span class="colorSpanOne"><em style="width:'+brand_link_split[0]+'%"><strong>'+brand_link_split[0]+'%</strong></em></span>';
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanTwo"><em style="width:'+brand_link_split[1]+'%"><strong>'+brand_link_split[1]+'%</strong></em></span>'
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanThree"><em style="width:'+brand_link_split[2]+'%"><strong>'+brand_link_split[2]+'%</strong></em></span>';
                str +='</div>';
                str +='</div>';
                
                str +='</div>';
                str +='</div>';
                
                str +='<div class="matchProgressdiv clearfix ">';
                str +='<div class="matchProgressLt">'
                str +='<span class="textMatch">Raw URL %</span>';
                str +='<p id="raw_link_graph"></p>'
                str +='</div>';
                var raw_link=data.percent_raw_link;
                 var raw_link_split=raw_link.split(',');
                str +='<div class="matchProgressRt">';
                 str +='<div class="colorDiv">';
                str +='<span class="colorSpanOne"><em style="width:'+raw_link_split[0]+'%"><strong>'+raw_link_split[0]+'%</strong></em></span>';
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanTwo"><em style="width:'+raw_link_split[1]+'%"><strong>'+raw_link_split[1]+'%</strong></em></span>'
                str +='</div>';
                str +='<div class="colorDiv">';
                str +='<span class="colorSpanThree"><em style="width:'+raw_link_split[2]+'%"><strong>'+raw_link_split[2]+'%</strong></em></span>';
                str +='</div>';
                str +='</div>';
                
                str +='</div>';
                str +='</div>';
                
                
                str +='<div class="matchOption clearfix">';
                str +='<ul>';
                str +='<li><em><img src="'+base_url+'images/match-view1.jpg" alt="match-view"/></em>Top 10</li>';
                str +='<li><em><img src="'+base_url+'images/match-view2.jpg" alt="match-view"/></em>Top 3</li>';
                str +='<li><em><img src="'+base_url+'images/match-view3.jpg" alt="match-view"/></em>Recovered</li>'
                str +='</ul>';
                
                /*<img src="'+base_url+'images/analysis_img4.jpg" alt="">*/
                //alert(str);
                $('#match_keyword_box').html(str);
                
                $('#ex_match_link_graph').html(data.ex_link);   
                $('#ex_match_link_graph').sparkline('html', {type: 'bar', barColor: '#4473CF'} );
                
                $('#blended_link_graph').html(data.blanded_link);   
                $('#blended_link_graph').sparkline('html', {type: 'bar', barColor: '#4473CF'} );
                
                $('#brand_link_graph').html(data.brand_link);   
                $('#brand_link_graph').sparkline('html', {type: 'bar', barColor: '#4473CF'} );
                
                $('#raw_link_graph').html(data.raw_link);   
                $('#raw_link_graph').sparkline('html', {type: 'bar', barColor: '#4473CF'} );
                
                /*$('#grpOldSiteAge').html(data.oldnum);
                $('#grpNewSiteAge').html(data.newnum);
                $('#grpYoungSiteAge').html(data.youngnum);
                
                $('#grpOldSiteAge').sparkline();
                $('#grpNewSiteAge').sparkline();
                $('#grpYoungSiteAge').sparkline();
                */
                
                //$('#loader-site-age').hide();
                $('#match_keyword_box').show();
            }
        });
}


function _renderSiteFreshness(base_url,type){
     var campaign_list               = $('#campaign_list').val();
    var campaign_server_engine      = $('#campaign_server_engine').val();
    
        var dataString  = 'campaign_list=' + encodeURIComponent(campaign_list) + '&campaign_server_engine=' + encodeURIComponent(campaign_server_engine);
        dataString +="&site_type="+type;
        $.ajax({
            type: 'post',
            url: base_url + 'renderanalysis/sitefraceness',
            data: dataString,
            beforesend: function(){
                $('#content-frace-ness').hide();
                $('#loader-frace-ness').show();            
            },
            success: function(data){
                //alert(data);
                //return false;
                data = JSON.parse(data);            
                
                $('#loader-site-age').hide();
                $('#contain-site-age').show();
                var str = '<h3 id="site-age-heading">Fresh Score '+data.score+'</h3>';
                str     += '<div class="mapArea">';
                str     +='<table width="100%" border="0" cellspacing="0" cellpadding="0" background="none">';
                str     +='<tr>';
                str     +='<td>Week: </td><td> '+data.week+'</td>';
                str     +='<td>&nbsp;</td><td id="week_grph"></td>';
                str     +='</tr><tr>';
                str     +='<td>Month: </td><td>'+data.month+'</td>';
                str     +='<td>&nbsp;</td><td id="month_graph"></td>';
                str     +='</tr><tr>';
                str     +='<td>Never:  </td><td>'+data.never+'%</td>';
                str     +='<td>&nbsp;</td><td  id="never_graph"></td>';
                str     +='</tr></table>';
                str     +='<div class="wave" id="fress_score_graph"></div>';
                
                /*<img src="'+base_url+'images/analysis_img4.jpg" alt="">*/
                //alert(str);
                $('#content-frace-ness').html(str);
                $("#week_grph").html(data.week_graph);
                $('#week_grph').sparkline();
                $("#month_graph").html(data.graph_month);
                $('#month_graph').sparkline();
                $("#never_graph").html(data.never_graph);
                $('#never_graph').sparkline();
                $("#fress_score_graph").html(data.never_graph);
                $('#fress_score_graph').sparkline();
                /*$('#grpOldSiteAge').html(data.oldnum);
                $('#grpNewSiteAge').html(data.newnum);
                $('#grpYoungSiteAge').html(data.youngnum);
                
                $('#grpOldSiteAge').sparkline();
                $('#grpNewSiteAge').sparkline();
                $('#grpYoungSiteAge').sparkline();
                */
                $('#loader-frace-ness').hide();
                $('#content-frace-ness').show();
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


function _setDynmicData(base_url,type='top_ten'){
    _renderSiteAge(base_url,type);
    _renderSitePageCount(base_url,type);
    _renderSiteWordCount(base_url,type);
    _renderSiteKWRatio(base_url,type);
    _renderSiteKWOptimization(base_url,type);
    _renderSiteHidingLinks(base_url,type);
    _renderSocialLinks(base_url,type)
    _renderSiteExternalLinks(base_url,type);
    _renderSiteExactKWAnchor(base_url,type);
    _renderSiteFreshness(base_url,type);
    //_renderSiteLongTermPageOneRank(base_url);
    
    _renderSiteStat(base_url);
    _renderSiteOnPageElement(base_url);
    _renderSiteLinkElement(base_url);
    
    _renderLongTermSite(base_url);
    
    
    _renderLinkGraphSite(base_url);
}

function _renderSiteSnapeShot(type){
      var base_url_suffix	= 'serp-new/';
    var base_url = location.protocol + '//' + location.host + '/' + base_url_suffix;
    _setDynmicData(base_url,type);
        
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
    
    $('#linkelement_top10').click(function(){
          $('#linkelement_search_type').val('top10');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
    $('#linkelement_top3').click(function(){
          $('#linkelement_search_type').val('top3');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
    $('#linkelement_newsite').click(function(){
          $('#linkelement_search_type').val('newsite');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
    $('#linkelement_parasite').click(function(){
          $('#linkelement_search_type').val('parasite');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
    $('#linkelement_aged1yr').click(function(){
          $('#linkelement_search_type').val('aged1yr');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
    $('#linkelement_longterm').click(function(){
          $('#linkelement_search_type').val('longterm');  
         _renderSiteLinkElement(base_url);           
                        
    });
    
  $("#top_ten_snape_shot").click(function(){
      _renderSiteSnapeShot('top_ten');
  })    ;
  $("#top_three_snape_shot").click(function(){
      _renderSiteSnapeShot('top_three');
  })    ;
  $("#new_site_snape_shot").click(function(){
      _renderSiteSnapeShot('new_site');
  })    ;
  $("#recovery_snape_shot").click(function(){
      _renderSiteSnapeShot('recovery');
  })    ;
  $("#aged_snape_shot").click(function(){
      _renderSiteSnapeShot('aged');
  })    ;
  $("#long_term_snape_shot").click(function(){
      _renderSiteSnapeShot('long_term');
  })    ;



});
