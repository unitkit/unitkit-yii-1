/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function ($) 
{
	$.unitkit = $.unitkit || {};
	$.unitkit.tools = $.unitkit.tools || {};
	
	/**
	 * Include script file
	 * 
	 * @param path File path to include
	 */
	$.unitkit.tools.includeScriptFile = function (path)
	{
		if ($('script[src="' + path + '"]').length === 0) {
			$('body').append('<script src="' + path + '" type="text/javascript"></script>');
		}
	};
	
	/**
	 * Include css file
	 * 
	 * @param path File path to include
	 */
	$.unitkit.tools.includeCssFile = function (path)
	{
		if ($('link[href="' + path + '"]').length === 0) {
			$('head').append('<link rel="stylesheet" href="' + path +'" type="text/css" />');
		}
	};
	
	/**
	 * Read the session id from cookie
	 */
	$.unitkit.tools.getSessId = function ()
	{
		return $.unitkit.tools.getCookie('PHPSESSID');
	};
	
	/**
	 * Read a cookie
	 */
	$.unitkit.tools.getCookie = function (name)
	{
		var i, x, y, ARRcookies = document.cookie.split(";");
		for(i = 0; i < ARRcookies.length; i++) {
			x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
			y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
			x = x.replace(/^\s+|\s+$/g,"");
			if (x == name) {
				return unescape(y);
			}
		}
	};
	
	/**
	 * Remove empty string serialized
	 * @param string to transform
	 * @return string
	 */
	$.unitkit.tools.removeEmptyStrSeria = function (string)
	{
	    string = string.replace(/[^&]+=\.?(?:&|$)/g, '');
		var iLastChar = string.length - 1;
		if (string[iLastChar] == '&') {
			string = string.substring(0, iLastChar);
		}
		
		return string;
	};
	
	/**
	 * Parse query string
	 */
	$.unitkit.tools.parseQueryString = function (queryString)
	{
	    var params = {}, queries, temp, i, l;
	    // split into key/value pairs
	    queries = queryString.split('&');
	    // convert the array of strings into an object
	    for(i = 0, l = queries.length; i < l; ++i) {
	        temp = queries[i].split('=');
	        params[temp[0]] = decodeURIComponent(temp[1]);
	    }
	    
	    return params;
	};

	/**
	 * Extended
	 */
	$.fn.outerHTML = function () 
	{
		return $(this).clone().wrap('<div></div>').parent().html();
	};
	
	/**
	 * Create function
	 */
	if (typeof Object.create !== 'function') 
	{
		Object.create = function (o) {
			function f() {}
			f.prototype = o;
			return new f();
		};
	}
	
    /**
     * Set a maximum length to a textarea
     */
    $.unitkit.tools.initMaxlengthTextarea = function ()
    {
        $(document).on('keyup', 'textarea', function (){ 
            var $this = $(this);
            var limit = parseInt($(this).attr('maxlength'));  
            var text = $this.val();

            if (text.length > limit) {
                $this.val(text.substr(0, limit));
            }
        });  
    };
    
    
    /**
     * Init tooltip
     */
    $.unitkit.tools.initTooltip = function (delay)
    {
        delay = $.isEmptyObject(delay) ? { show: 500, hide: 100 } : delay;
        $('body').tooltip({
            selector: '[rel=tooltip]',
            delay: delay
        });
    };
})(jQuery);
