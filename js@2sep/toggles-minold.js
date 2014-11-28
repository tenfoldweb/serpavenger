/*
 jQuery Toggles v3.0.0
Copyright 2014 Simon Tabor - MIT License
https://github.com/simontabor/jquery-toggles / http://simontabor.com/labs/toggles
*/
(function(f){function k(a){a.fn.toggles=function(b){return this.each(function(){new h(a(this),b)})}}var h=f.Toggles=function(a,b){if(a.data("toggles")&&"boolean"===typeof b)a.data("toggles").toggle(b);else{for(var c="drag click width height animate easing type".split(" "),e={},d=0;d<c.length;d++){var g=a.data("toggle-"+c[d]);"undefined"!==typeof g&&(e[c[d]]=g)}b=this.b=$.extend({/*drag:!0,*/click:!0,text:{on:"ON",off:"OFF"},on:!1,animate:250,easing:"swing",checkbox:null,clicker:null,width:50,height:20,
type:"compact"},b||{},e);this.c=a;this.active=b.on;a.data("toggles",this);this.h="select"===b.type;this.l=$(b.checkbox);b.clicker&&(this.n=$(b.clicker));this.m();this.k()}};h.prototype.m=function(){function a(a){return $('<div class="toggle-'+a+'">')}var b=this.c.height(),c=this.c.width();b||this.c.height(b=this.b.height);c||this.c.width(c=this.b.width);this.g=b;this.i=c;this.a={f:a("slide"),e:a("inner"),on:a("on"),off:a("off"),d:a("blob")};var e=b/2,d=c-e,g=this.h;this.a.on.css({height:b,width:d,
textIndent:g?"":-e,lineHeight:b+"px"}).html(this.b.text.on);this.a.off.css({height:b,width:d,marginLeft:g?"":-e,textIndent:g?"":e,lineHeight:b+"px"}).html(this.b.text.off).addClass("active");this.a.d.css({height:b,width:b,marginLeft:-e});this.a.e.css({width:2*c-b,marginLeft:g||this.active?0:-c+b});this.h&&(this.a.f.addClass("toggle-select"),this.c.css("width",2*d),this.a.d.hide());this.a.e.append(this.a.on,this.a.d,this.a.off);this.a.f.html(this.a.e);this.c.html(this.a.f)};h.prototype.k=function(){function a(a){a.target===
b.a.d[0]&&b.b.drag||b.toggle()}var b=this;if(b.b.click&&(!b.b.clicker||!b.b.clicker.has(b.c).length))b.c.on("click",a);if(b.b.clicker)b.b.clicker.on("click",a);b.b.drag&&!b.h&&b.j()};h.prototype.j=function(){var a=this,b,c=(a.i-a.g)/4,e=function(d){a.c.off("mousemove");a.a.f.off("mouseleave");a.a.d.off("mouseup");!b&&a.b.click&&"mouseleave"!==d.type?a.toggle():(a.active?b<-c:b>c)?a.toggle():a.a.e.stop().animate({marginLeft:a.active?0:-a.i+a.g},a.b.animate/2)}.bind(a),d=-a.i+a.g;a.a.d.on("mousedown",
function(c){b=0;a.a.d.off("mouseup");a.a.f.off("mouseleave");var f=c.pageX;a.c.on("mousemove",a.a.d,function(c){b=c.pageX-f;a.active?(c=b,0<b&&(c=0),b<d&&(c=d)):(c=b+d,0>b&&(c=d),b>-d&&(c=0));a.a.e.css("margin-left",c)});a.a.d.on("mouseup",e);a.a.f.on("mouseleave",e)})};h.prototype.toggle=function(a){this.active!==a&&(a=this.active=!this.active,this.c.data("toggle-active",a),this.c.trigger("toggle",a),this.a.off.toggleClass("active",!a),this.a.on.toggleClass("active",a),this.l.prop("checked",a),this.h||
(a=a?0:-this.i+this.g,this.a.e.stop().animate({marginLeft:a},this.b.animate)))};"function"===typeof define&&define.amd?define(["jquery"],k):k(f.jQuery||f.Zepto||f.ender||f.$)})(this);