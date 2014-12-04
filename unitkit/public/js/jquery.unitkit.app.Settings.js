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
	 * Settings component
	 */
	$.unitkit.app.Settings = function (args)
	{
		this.args = args;
		this.appList = this.args.list || {};
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};

	/**
	 * Submit form
	 * 
	 * @param url
	 * @param data
	 * @param type
	 */
	$.unitkit.app.Settings.prototype.submit = function (url, data, type)
	{
		var self = this;

		this.main.block(this.blockUIOptions);

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
	$.unitkit.app.Settings.prototype.initEvents = function ()
	{
		this.main = $(this.args.main);
		this.initAjaxSelect();
		this.initSubmitActionEvent();
		this.initInputKeyPressActionEvent();
		this.initUpdateActionEvent();
		this.initCloseActionEvent();
	};

	/**
	 * BlockUI options
	 */
	$.unitkit.app.Settings.prototype.blockUIOptions = $.extend($.unitkit.app.defaultBlockUI, {});

	/**
	 * Close
	 */
	$.unitkit.app.Settings.prototype.initCloseActionEvent = function ()
	{
		var self = this;
		this.main.find('.btn-close').on('click', function () {
		    if ($.isEmptyObject(self.appList)) {
		        return true;
		    }
		    
			self.main.html('');
			self.appList.main.show();

            self.appList.loadDataGrid(
                self.appList.requestSaved.url, 
                (self.appList.requestSaved.data || ''),
                self.appList.requestSaved.type
            );

            if (self.activeAutoScroll) {
                $.unitkit.app.scrollTop();
            }

			return false;
		});
	};

	/**
	 * Ajax select
	 */
	$.unitkit.app.Settings.prototype.initAjaxSelect = function ()
	{
		this.main.find('.input-ajax-select').each(function () {
			$.unitkit.app.select2Ajax($(this), {allowClear: false});
		});
	};

	/**
	 * Update
	 */
	$.unitkit.app.Settings.prototype.initUpdateActionEvent = function ()
	{
		var self = this;
		this.main.find('.btn-update').on('click', function () {
			self.main.find('form').submit();
			return false;
		});
	};

	/**
	 * Input key press
	 */
	$.unitkit.app.Settings.prototype.initInputKeyPressActionEvent = function ()
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
	 * Submit
	 */
	$.unitkit.app.Settings.prototype.initSubmitActionEvent = function ()
	{
	    var self = this;
	    this.main.find('form').on('submit', function () {
	        self.submit(
	            self.main.find('form').attr('action'),
	            self.main.find('input, select, textarea').serialize(), 
	            self.main.find('form').attr('method')
			);
			return false;
		});
	};
})(jQuery);