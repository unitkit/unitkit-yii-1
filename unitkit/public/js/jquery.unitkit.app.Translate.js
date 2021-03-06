/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function ($) 
{
	$.unitkit = $.unitkit || {};
	$.unitkit.app = $.unitkit.app || {};

	/**
	 * Translate component
	 */
	$.unitkit.app.Translate = function (args)
	{
		this.args = args;
		this.appList = this.args.list;
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};
	
	/**
	 * BlockUI options
	 */
	$.unitkit.app.Translate.prototype.blockUIOptions = $.extend($.unitkit.app.defaultBlockUI, {});
	
	/**
	 * Submit form
     *
	 * @param url
	 * @param data
	 * @param type
	 */
	$.unitkit.app.Translate.prototype.submit = function (url, data, type)
	{
		var self = this;

		self.main.block(this.blockUIOptions);

		var ajaxRequest = function (async) {
			$.unitkit.app.ajax(
			    url, 
			    function (json) {
					if (json.loginReload) {
						if ($.unitkit.app.loginReload(json)) {
                            ajaxRequest(false);
                        }
					} else {
						self.main.unblock();
                        $.unitkit.app.destroyCKEDITOR();
						self.main.html($.parseHTML(json.html));
						self.initEvents();
						if (self.activeAutoScroll) {
						    $.unitkit.app.scrollTop();
						}
					}
				}, 
				data, 
				type, 
				'JSON', 
				async
			);
		};
		
		ajaxRequest(true);
	};
	
	/**
	 * Init events
	 */
	$.unitkit.app.Translate.prototype.initEvents = function ()
	{
		this.main = $(this.args.main);
		this.initSubmitActionEvent();
		this.initUpdateActionEvent();
		this.initInputKeyPressActionEvent();
		this.initCloseActionEvent();
		this.initAdvancedTextarea();
		this.initExtendEvents();
	};
	
    /**
     * Init extend events (main)
     */
    $.unitkit.app.Translate.prototype.initExtendEvents = function (){};
	
	/**
	 * Init external events
	 */
    $.unitkit.app.Translate.prototype.initAdvancedTextarea = function ()
	{
		this.main.find('.advanced-textarea').each(function () {
            var $this = $(this);
            var options = {};
            if ((url = $this.attr('data-ckeditorFilebrowserBrowseUrl')) !== undefined) {
                options.filebrowserBrowseUrl = url;
            }
            if ((language = $this.attr('data-ckeditorLanguage')) !== undefined) {
                options.language = language;
            }
            $this.ckeditor(options);
		});
	};
	
	/**
	 * Submit event
	 */
	$.unitkit.app.Translate.prototype.initSubmitActionEvent = function ()
	{
		var self = this;
		this.main.find('form').on('submit', function () {
			self.submit(self.main.find('form').attr('action'), self.main.find('input, textarea').serialize(), 
			        self.main.find('form').attr('method'));
			return false;
		});	
	};
	
	/**
	 * Update event
	 */
	$.unitkit.app.Translate.prototype.initUpdateActionEvent = function ()
	{
		var self = this;
		this.main.find('.btn-update').on('click', function () {
		    self.main.find('form').submit();
			return false;
		});
	};
	
	/**
	 * Input key press event
	 */
	$.unitkit.app.Translate.prototype.initInputKeyPressActionEvent = function ()
	{
		var self = this;
		this.main.find('form input').on('keypress', function (e) {
			if (e.keyCode == 13) {
			    self.main.find('form').submit();
				return false;
			}
		});
	};
	
	/**
	 * Close event
	 */
	$.unitkit.app.Translate.prototype.initCloseActionEvent = function ()
	{
		var self = this;
		
		this.main.find('.btn-close').on('click', function () {
		    if ($.isEmptyObject(self.appList)) {
		        return true;
		    }
            $.unitkit.app.destroyCKEDITOR();
		    self.appList.main.show();
		    self.appList.loadDataGrid(
		        self.appList.requestSaved.url, 
				(self.appList.requestSaved.data || '') + '&partial=1', 
				self.appList.requestSaved.type
			);
		    self.main.html('');
			
			return false;
		});
	};
})(jQuery);