/////
// make form act as ajax login form
// it will just submit form to aMember's login url
// and handle login response
// options - 
// success: callback to be called on succes
//    by default - redirect or page reload
// failure: callback to be called on failure
//    by default - display error to $("ul.errors")    
/////
function amAjaxLoginForm(selector, options)
{
    if (typeof options == 'function') {
            options = {success: options};
    }
    options = jQuery.extend(true, {
        success: function(response, frm) { 
            if (response.url) window.location = response.url;
            else if (response.reload) window.location.reload(true);
        },
        error: function(response, frm) {
            var errUl = jQuery("ul.errors.am-login-errors");
            if (!errUl.length)
                frm.before(errUl = jQuery("<ul class='errors am-login-errors'></ul>"));
            else 
                errUl.empty();
            for (var i=0;i<response.error.length;i++)
                errUl.append("<li>"+response.error[i]+"</li>");
            // show recaptcha if enabled
            if (response.recaptcha_key)
            {
                jQuery("#recaptcha-row").show();
                if (typeof Recaptcha == "undefined")
                {
                    jQuery.getScript('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', function(){
                        frm.data('recaptcha', Recaptcha.create(response.recaptcha_key, 'recaptcha-element', {theme: jQuery("#recaptcha-row").data('recaptcha-theme')}));
                    });
                } else {
                    if (!frm.data('recaptcha'))
                    {
                        frm.data('recaptcha', Recaptcha.create(response.recaptcha_key, 'recaptcha-element', {theme: jQuery("#recaptcha-row").data('recaptcha-theme')}));
                    } else 
                        frm.data('recaptcha').reload();
                }
            } else {
                jQuery("#recaptcha-row").hide();
            }
        }
    }, options);
    jQuery(document).off("submit.ajax-login", selector);
    jQuery(document).on("submit.ajax-login", selector, function(){
        var frm = jQuery(this);
        jQuery.post(frm.attr("action"), frm.serialize(), function(response, status, request){
            if ((request.status != '200') && (request.status != 200))
                response = {ok: false, error: ["ajax request error: " + request.status + ': ' + request.statusText ]};
            if (!response)
                response = {ok: false, error: ["ajax request error: empty response"]};
            if (!response || !response.ok)
            {
                if (!response.error) response.error = ["Login failed"];
                options.error(response, frm);
            } else {
                options.success(response, frm);
            }
        });
        return false;
    });
}

/////
// make form act as ajax login form
// it will just submit form to aMember's login url
// and handle login response
// options - 
// success: callback to be called on succes
//    by default - redirect or page reload
// failure: callback to be called on failure
//    by default - display error to jQuery("ul.errors")    
/////
function amAjaxSendPassForm(selector, options)
{
    if (typeof options == 'function') {
            options = {success: options};
    }
    options = jQuery.extend(true, {
        successContainer: jQuery("success", this),
        success: function(response, frm) { 
            if (response.url) window.location = response.url;
            else if (response.reload) window.location.reload(true);
            else {
                if (!options.successContainer.length)
                {
                    frm.before(options.successContainer = jQuery('<div class="am-info"></div>'));
                }
                jQuery("ul.errors.am-sendpass-errors").remove();
                options.successContainer.html(response.error[0]);
                jQuery(":submit", frm).prop("disabled", "disabled");
            }
        },
        error: function(response, frm) {
            var errUl = jQuery("ul.errors.am-sendpass-errors");
            if (!errUl.length)
                frm.before(errUl = jQuery("<ul class='errors am-sendpass-errors'></ul>"));
            else 
                errUl.empty();
            for (var i=0;i<response.error.length;i++)
                errUl.append("<li>"+response.error[i]+"</li>");
        }
    }, options);
    jQuery(document).off("submit.ajax-send-pass", selector);
    jQuery(document).on("submit.ajax-send-pass", selector, function(){
        var frm = jQuery(this);
        jQuery.post(frm.attr("action"), frm.serialize(), function(response, status, request){
            if ((request.status != '200') && (request.status != 200))
                response = {ok: false, error: ["ajax request error: " + request.status + ': ' + request.statusText ]};
            if (!response)
                response = {ok: false, error: ["ajax request error: empty response"]};
            if (!response || !response.ok)
            {
                if (!response.error) response.error = ["Error while e-mailing lost password"];
                options.error(response, frm);
            } else {
                options.success(response, frm);
            }
        });
        return false;
    });
}

function ajaxLink(selector)
{
    jQuery(document).on('click', selector, function(){
        var $link = $(this);
        jQuery("#ajax-link").remove();
        jQuery.get(jQuery(this).attr('href'), {}, function(html){
            var options = {};
            if ($link.data('popup-width'))
                options.width = $link.data('popup-width');
            if ($link.prop('title'))
                options.title = $link.prop('title');
            jQuery('body').append('<div id="ajax-link" style="display:none"></div>');
            jQuery("#ajax-link").html(html).amPopup(options);
        })
        return false;
    });
}
(function($){
    // render a popup window for the element
    if (!$.fn.amPopup) { // if not yet re-defined by theme
        //recalculate popup position on resize event
        $(window).resize(function(){
            $('.am-popup').css({
                left: $('body').width()/2 - $('.am-popup').outerWidth(false)/2
            });
        })
        $.fn.amPopup = function(params){
        return this.each(function(){
            var options = params;
            if (options == 'close')
            {
                $(".am-popup-close").first().click();
                return;
            }
            // else do init
            var options = $.extend({
                width: null,
                title: '',
                animation: 300
            }, options);
            var $this = $(this);
            $("#mask").remove();

            var $popup = $("\
    <div class='am-popup'>\
        <div class='am-popup-header'>\
            <a href='javascript:' class='am-popup-close-icon am-popup-close' />\
            <div class='am-popup-title'>\
                <h2 class='am-popup-title' />\
            </div>\
        </div>\
        <div class='am-popup-content' />\
    </div>");

            var $parent = $this.wrap('<div><div>').parent();

            $popup.find(".am-popup-title").empty().append(options.title);
            options.width && $popup.css('width', options.width);
            $popup.find(".am-popup-content").empty().append($(this).css('display', 'block'));

            $('body').append('<div id="mask"></div>').append($popup);
            $popup.css({
                top: $(window).scrollTop() + 100,
                left: $('body').width()/2 - $popup.outerWidth(false)/2
            });

            $popup.show(options.animation);
            $popup.find(".am-popup-close").bind('click.popup', function(){
                $popup.hide(options.animation);
                $parent.append($this.css('display', 'none'));
                $this.unwrap();
                $(this).closest('.am-popup').remove();
                $("#mask").remove();
            });
        });};
    }
})(jQuery);

jQuery(function($) {
    // scroll to error message if any
    var errors = $(".errors:visible:first,.error:visible:first");
    if (errors.length) 
        $("html, body").scrollTop(Math.floor(errors.offset().top));
    
    $('input.datepicker').datepicker({
        defaultDate: window.uiDefaultDate,
        dateFormat: window.uiDateFormat,
        changeMonth: true,
        changeYear: true,
        yearRange:  'c-90:c+10'
    });

    $('.upload').upload();

    amAjaxLoginForm(".am-login-form form");
    
    amAjaxSendPassForm(".am-sendpass-form form");

    // cancel form support hooks (member/payment-history)
    $(document).on('click',".cancel-subscription", function(event){
        event.stopPropagation();
        var $div = $(".cancel-subscription-popup");
        $div.amPopup({
            width: 500,
            title: $div.data('popup-title')
        }).data('href', this.href);
        return false;
    });
    $(document).on('click',"#cancel-subscription-yes", function(){
        window.location.href = $(".cancel-subscription-popup").data('href');
    });
    // end of cancel form
    // upgrade form
    $(document).on('click',"a.upgrade-subscription", function(event){
        event.stopPropagation();
        var $div = $(".upgrade-subscription-popup-"+$(this).data('invoice_item_id'));
        $div.amPopup({
            width: 500,
            title: $div.data('popup-title')
        }).data('href', this.href);
        return false;
    });
    // end of upgrade 
    
    ajaxLink(".ajax-link");
    
    $(document).on("click",".am-switch-forms", function(){
        var el = $(this);
        $(el.data('show_form')).show();
        $(el.data('hide_form')).hide();
    });
    /// DEPRECATED, kept for compatiblity, handled by css .popup-close
    $(document).on('click',"#cancel-subscription-no, .upgrade-subscription-no", function(){
        if (!$(this).hasClass("popup-close"))
            $(".popup").amPopup("close");
    });
    
});