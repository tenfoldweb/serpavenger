/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-user_2' : '&#xe000;',
			'icon-user_1' : '&#xe001;',
			'icon-Off-icon---small-White' : '&#xe002;',
			'icon-Off-icon---small-Greay' : '&#xe003;',
			'icon-Off-icon---BG' : '&#xe004;',
			'icon-On-icon---small-White' : '&#xe005;',
			'icon-On-icon---small-green' : '&#xe006;',
			'icon-On-icon---BG' : '&#xe007;',
			'icon-wordpress' : '&#xe008;',
			'icon-windows_1' : '&#xe009;',
			'icon-windows' : '&#xe00a;',
			'icon-user_1-2' : '&#xe00b;',
			'icon-user' : '&#xe00c;',
			'icon-upload' : '&#xe00d;',
			'icon-tick' : '&#xe00e;',
			'icon-icon' : '&#xe00f;',
			'icon-icon_1' : '&#xe010;',
			'icon-icon_2' : '&#xe011;',
			'icon-info' : '&#xe012;',
			'icon-iphone_app_store' : '&#xe013;',
			'icon-joomla' : '&#xe014;',
			'icon-key' : '&#xe015;',
			'icon-key_1' : '&#xe016;',
			'icon-map_marker' : '&#xe017;',
			'icon-pen' : '&#xe018;',
			'icon-right_arrow' : '&#xe019;',
			'icon-right_arrow_1' : '&#xe01a;',
			'icon-search' : '&#xe01b;',
			'icon-setting' : '&#xe01c;',
			'icon-social_media_icon' : '&#xe01d;',
			'icon-graph_1' : '&#xe01e;',
			'icon-graph' : '&#xe01f;',
			'icon-file_drawer' : '&#xe020;',
			'icon-eye' : '&#xe021;',
			'icon-edit_1' : '&#xe022;',
			'icon-edit' : '&#xe023;',
			'icon-dustbin' : '&#xe024;',
			'icon-disc_1' : '&#xe025;',
			'icon-disc' : '&#xe026;',
			'icon-cross' : '&#xe027;',
			'icon-check_mark_2' : '&#xe028;',
			'icon-check_mark_1' : '&#xe029;',
			'icon-check_mark' : '&#xe02a;',
			'icon-chain' : '&#xe02b;',
			'icon-briefcase' : '&#xe02c;',
			'icon-add_user' : '&#xe02d;',
			'icon-add_user_1' : '&#xe02e;',
			'icon-blank_box' : '&#xe02f;',
			'icon-blogger' : '&#xe030;',
			'icon-icon_12' : '&#xe031;',
			'icon-icon23' : '&#xe032;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};