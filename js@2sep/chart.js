var orgHighchartsRangeSelectorPrototypeRender = Highcharts.RangeSelector.prototype.render;
Highcharts.RangeSelector.prototype.render = function (min, max) {
    orgHighchartsRangeSelectorPrototypeRender.apply(this, [min, max]);
    var leftPosition = this.chart.plotLeft,
        topPosition = this.chart.plotTop+250,
        space = 2;
    this.zoomText.attr({
        x: leftPosition,
        y: topPosition + 15
    });
    leftPosition += this.zoomText.getBBox().width;
    for (var i = 0; i < this.buttons.length; i++) {
        this.buttons[i].attr({
            x: leftPosition,
            y: topPosition 
        });
        leftPosition += this.buttons[i].width + space;
    }
};
function chart_val(data){
	var ser=Array(),plotb=Array();
	var d=data.data;
	for(var i=0;i<d.length;++i){
		var x=Array();
		x.name=d[i].keyword;
		x.marker={"enabled" : true,"radius" : 3};
		x.shadow=true;
		x.data=Array();
		for(var j=0;j<d[i].data.length;++j){
			var y=Array();
			y.push(parseInt(d[i].data[j].date,10));
			y.push(parseInt(d[i].data[j].rank,10));
			x.data.push(y);
		}
		ser.push(x);
	}
	d=data.flags;
	var algo_flag=false,off_flag=false,on_flag=false, onr_flag=false,offr_flag=false;
	var pbs=Object();
	pbs.algo=Array(),pbs.on=Array(),pbs.off=Array(),pbs.onr=Array(),pbs.offr=Array();
	var algo=Object(),off=Object(),on=Object(),onr=Object(),offr=Object();
	var dt1,dt2,col,titl;
	for(var i=0;i<d.length;++i){
		if(d[i].type_of_page=="Algo"){
			algo.from=parseInt(d[i].start_date,10);
			algo.to=parseInt(d[i].start_date,10)+12*3600*1000;
			algo_flag=true;
			algo.color=Color['algo'];
			algo.title=d[i].title;
			algo.type="Algo Update";
			algo.zIndex=2;
			algo.id="p"+plotb.length;
			plotb.push(algo);
			pbs.algo.push(plotb.length-1);
			algo=new Object();
		}
		
		if(d[i].type_of_page=="Offpage"){
			var dur;
			if(d[i].duration=='') dur=1;
			off.from=parseInt(d[i].start_date,10);
			off.to=parseInt(d[i].start_date,10)+24*3600*1000;
			off_flag=true;
			off.color=Color.off;
			off.title=d[i].title;
			off.type="Offpage Test";
			off.zIndex=1;
			off.id="p"+plotb.length;
			plotb.push(off);
			off=new Object();
			pbs.off.push(plotb.length-1);
		}
		if(d[i].type_of_page=="Onpage"){
			var dur;
			if(d[i].duration=='') dur=1;
			else dur=parseInt(d[i].duration,10);
			on.to=parseInt(d[i].start_date,10)+dur*24*3600*1000;
			on.from=parseInt(d[i].start_date,10);
			on_flag=true;
			on.color=Color.on;
			on.title=d[i].title;
			on.type="Onpage Test";
			on.zIndex=2;
			on_flag=false;
			on.id="p"+plotb.length;
			plotb.push(on);
			on=new Object();
			pbs.on.push(plotb.length-1);
		}
		if(d[i].type_of_page=="Onpage" && d[i].reverse_date!=0){
				onr.to=parseInt(d[i].reverse_date,10)+24*3600*1000;
				onr.from=parseInt(d[i].reverse_date,10);
				onr.color=Color.onr;
				onr.type='Onpage Reversal';
				onr.zIndex=2;
				onr.id="p"+plotb.length;
				plotb.push(onr);
				onr=new Object();
				pbs.onr.push(plotb.length-1);
		}
		if(d[i].type_of_page=="Offpage" && d[i].reverse_date!=0){
				offr.from=parseInt(d[i].reverse_date,10);
				offr.to=parseInt(d[i].reverse_date,10)+24*3600*1000;
				offr_flag=true;
				offr.color=Color.offr;
				offr.type='Offpage Reversal';
				offr.zIndex=1;
				offr.id="p"+plotb.length;
				plotb.push(offr);
				offr=new Object();
				pbs.offr.push(plotb.length-1);
		}
	}
	/*if(offr_flag){
		offr_flag=false;
		offr.id="p"+plotb.length;
		plotb.push(offr);
		offr=new Object();
		pbs.offr.push(plotb.length-1);
	}
	if(onr_flag){
		onr_flag=false;
		onr.id="p"+plotb.length;
		plotb.push(onr);
		onr=new Object();
		pbs.onr.push(plotb.length-1);
	}
	if(on_flag){
		on_flag=false;
		on.id="p"+plotb.length;
		plotb.push(on);
		on=new Object();
		pbs.on.push(plotb.length-1);
	}
	if(off_flag){
		off_flag=false;
		off.id="p"+plotb.length;
		plotb.push(off);
		off=new Object();
		pbs.off.push(plotb.length-1);
	}
	if(algo_flag){
		algo_flag=false;
		algo.id="p"+plotb.length;
		plotb.push(algo);
		pbs.algo.push(plotb.length-1);
		algo=new Object();
	}*/
	chart(ser,plotb,pbs);
}
var plb;
function chart(series,plotbands,pbs){
	var $tooltip = $('#tooltip');
    $tooltip.hide();
    var $text = $('#tooltiptext');
    displayTooltip = function (text, left) {
        $text.html(text);
        $tooltip.show();
        $tooltip.css('left', parseInt(left) + 24 + 'px');
    };
    var timer;
    hideTooltip = function (e) {
        clearTimeout(timer);
        timer = setTimeout(function () {
            $tooltip.fadeOut();
        }, 2000);
    };
	for(var i=0; i<plotbands.length;++i){
		plotbands[i].events={"mouseover":function(){
				var plotBandOverlay = this.options;
				if(this.options.id!=="bandOverlay") {
					plotBandOverlay.color = "rgba(255, 255, 255, .5)";
					plotBandOverlay.id = "bandOverlay";
					var disp='Type: '+this.options.type;
					if(this.options.to-this.options.from>24*3600*1000)
						disp+='<br>Date: '+Highcharts.dateFormat('%d %B',this.options.from)+"-"+Highcharts.dateFormat('%d %B',this.options.to);
					else
						disp+='<br>Date: '+Highcharts.dateFormat('%d %B',this.options.from);
					if(this.options.title)
						disp+="<br>Test: "+this.options.title;
					displayTooltip(disp,this.svgElem.d.split(' ')[1]);
					plotBandOverlay.events={mouseout: function(){
						this.axis.chart.xAxis[0].removePlotBand("bandOverlay");   
						hideTooltip();            
					}}; 
					this.axis.chart.xAxis[0].addPlotBand(plotBandOverlay);
					this.options.id='';
				}
			}
		};
	}
	$('#container').highcharts('StockChart', {
			chart:{
				events:{
					redraw: function(){
						for(var i=0;i<pbs.algo.length;++i){
							el=this.xAxis[0].plotLinesAndBands[pbs.algo[i]];
							if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
								el.svgElem[ el.visible ? 'hide' : 'show' ]();
						}
						for(var i=0;i<pbs.off.length;++i){
							el=this.xAxis[0].plotLinesAndBands[pbs.off[i]];
							if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
								el.svgElem[ el.visible ? 'hide' : 'show' ]();
						}
						for(var i=0;i<pbs.offr.length;++i){
							el=this.xAxis[0].plotLinesAndBands[pbs.offr[i]];
							if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
								el.svgElem[ el.visible ? 'hide' : 'show' ]();
						}
						for(var i=0;i<pbs.on.length;++i){
							el=this.xAxis[0].plotLinesAndBands[pbs.on[i]];
							if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
								el.svgElem[ el.visible ? 'hide' : 'show' ]();
						}
						for(var i=0;i<pbs.onr.length;++i){
							el=this.xAxis[0].plotLinesAndBands[pbs.onr[i]];
							if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
								el.svgElem[ el.visible ? 'hide' : 'show' ]();
						}
					}
				}
			},
			rangeSelector : {
				selected : 1
			},
			yAxis : {
				title : {
					text : 'Rank'
				},
				//max : 100,
				min : 0,
				showLastLabel:true,
				opposite: false,
				reversed:true
			},
			navigator: {
				margin: 50,
				yAxis:{
					reversed:true
				}
			},
			rangeSelector:{
				selected:0,
				inputPosition:{
					y:285
				}
			},
			legend: {
				enabled:false,
				align:'right',
				verticalAlign:'middle',
				layout: 'vertical'
			},
			xAxis:{
				plotBands  : plotbands
			},
			exporting: {
				buttons: {
					algoButton: {
						x:60,
						verticalAlign: 'top',
						align:'left',
						onclick: function (e) {
							for(var i=0;i<pbs.algo.length;++i){
								el=this.xAxis[0].plotLinesAndBands[pbs.algo[i]];
								this.xAxis[0].plotLinesAndBands[pbs.algo[i]].visible = !this.xAxis[0].plotLinesAndBands[pbs.algo[i]].visible;
								if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
									el.svgElem[ el.visible==false ? 'show' : 'hide' ]();
							}
						},
						symbol: 'square',
						text: 'Algo Update',
						symbolFill: Color.algo,
					},
					offButton: {
						x: 168,
						verticalAlign: 'top',
						align:'left',

						onclick: function (e) {
							for(var i=0;i<pbs.off.length;++i){
								el=this.xAxis[0].plotLinesAndBands[pbs.off[i]];
								this.xAxis[0].plotLinesAndBands[pbs.off[i]].visible = !this.xAxis[0].plotLinesAndBands[pbs.off[i]].visible;
								if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
									el.svgElem[ el.visible==false ? 'show' : 'hide' ]();
							}
						},
						symbol: 'square',
						text: 'Offpage Test',
						symbolFill: Color.off
					},
					offrButton: {
						x: 280,
						verticalAlign: 'top',
						align:'left',

						onclick: function (e) {
							for(var i=0;i<pbs.offr.length;++i){
								el=this.xAxis[0].plotLinesAndBands[pbs.offr[i]];
								this.xAxis[0].plotLinesAndBands[pbs.offr[i]].visible = !this.xAxis[0].plotLinesAndBands[pbs.offr[i]].visible;
								if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
									el.svgElem[ el.visible==false ? 'show' : 'hide' ]();
							}
						},
						symbol: 'square',
						text: 'Offpage Reversal',
						symbolFill: Color.offr
					},
					onButton: {
						x: 415,
						verticalAlign: 'top',
						align:'left',
						onclick: function (e) {
							for(var i=0;i<pbs.on.length;++i){
								el=this.xAxis[0].plotLinesAndBands[pbs.on[i]];
								this.xAxis[0].plotLinesAndBands[pbs.on[i]].visible = !this.xAxis[0].plotLinesAndBands[pbs.on[i]].visible;
								if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
									el.svgElem[ el.visible==false ? 'show' : 'hide' ]();
							}
						},
						symbol: 'square',
						text: 'Onpage Test',
						symbolFill: Color.on
					},
					onrButton: {
						x:525,
						verticalAlign: 'top',
						align:'left',
						onclick: function (e) {
							for(var i=0;i<pbs.onr.length;++i){
								el=this.xAxis[0].plotLinesAndBands[pbs.onr[i]];
								this.xAxis[0].plotLinesAndBands[pbs.onr[i]].visible = !this.xAxis[0].plotLinesAndBands[pbs.onr[i]].visible;
								if(el.svgElem && el.options.from > this.xAxis[0].getExtremes().min && el.options.to < this.xAxis[0].getExtremes().max)
									el.svgElem[ el.visible==false ? 'show' : 'hide' ]();
							}
						},
						symbol: 'square',
						text: 'Onpage Reversal',
						symbolFill: Color.onr
					}
				}
			},
			series : series
		});
}
function col_chart(){
	var x1=[],x2=[],x3=[];
	x1.name="Below 4";
	x1.type="column";
	x1.data=Array();
	x2.name="4 - 6";
	x2.type="column";
	x2.data=Array();
	x3.name="6+";
	x3.type="column";
	x3.data=Array();
	var groupingUnits = [['week',[1]
	]];
	x1.dataGrouping={units: groupingUnits};
	x2.dataGrouping={units: groupingUnits};
	x3.dataGrouping={units: groupingUnits};
	for(var j=0;j<de.data.length;++j){
		var y=parseInt(de.data[j].rank,10);
		var a1=0,a2=0,a3=0;
		if(y<4)
			a1=1;
		else if(y<6)
			a2=1;
		else
			a3=1;
		x1.data.push([parseInt(de.data[j].date,10),a1]);
		x2.data.push([parseInt(de.data[j].date,10),a2]);
		x3.data.push([parseInt(de.data[j].date,10),a3]);
		
	}
	$('#container2').highcharts('StockChart', {
			chart:{
			},
			rangeSelector : {
				selected : 1
			},
			plotOptions: {
				column: {
					stacking: 'normal',
					dataGrouping:{
						groupPixelWidth:100
					}
				}
			},
			yAxis : {
				title : {
					text : 'Rank'
				},
				//max : 100,
				min : 0,
				showLastLabel:true,
				opposite: false
			},
			navigator: {
				margin: 50,
				yAxis:{
					reversed:true
				}
			},
			rangeSelector:{
				selected:0,
				inputPosition:{
					y:285
				}
			},
			legend: {
				enabled:false,
				align:'right',
				verticalAlign:'middle',
				layout: 'vertical'
			},
			xAxis:{
				//plotBands  : plotbands
			},
			series : [x1,x2,x3]
		});
}