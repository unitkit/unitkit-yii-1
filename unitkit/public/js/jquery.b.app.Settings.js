/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.b = $.b || {};
	$.b.app = $.b.app || {};

	/**
	 * Settings component
	 */
	$.b.app.Settings = function(args)
	{
		this.args = args;
		this.appList = this.args.list || {};
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};

	/**
	 * Sumbit form
	 * 
	 * @param url
	 * @param data
	 * @param type
	 */
	$.b.app.Settings.prototype.submit = function(url, data, type)
	{
		var self = this;

		this.main.block(this.blockUIOptions);

		var ajaxRequest = function(async) {
			$.b.app.ajax(
			    url, 
			    function(json) {
					if(json.loginReload) {
						if($.b.app.loginReload(json)) {
							ajaxRequest(false);
						}
					} else {
						self.main.unblock();
						self.main.html($.parseHTML(json.html));
						self.initEvents();
						if(self.activeAutoScroll) {
						    $.b.app.scrollTop();
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
	$.b.app.Settings.prototype.initEvents = function()
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
	$.b.app.Settings.prototype.blockUIOptions = $.extend($.b.app.defaultBlockUI, {});

	/**
	 * Close
	 */
	$.b.app.Settings.prototype.initCloseActionEvent = function()
	{
		var self = this;
		this.main.find('.btn-close').on('click', function() {
		    if($.isEmptyObject(self.appList)) {
		        return true;
		    }
		    
			self.main.html('');
			self.appList.main.show();

            self.appList.loadDataGrid(
                self.appList.requestSaved.url, 
                (self.appList.requestSaved.data || ''),
                self.appList.requestSaved.type
            );

            if(self.activeAutoScroll) {
                $.b.app.scrollTop();
            }

			return false;
		});
	};

	/**
	 * Ajax select
	 */
	$.b.app.Settings.prototype.initAjaxSelect = function()
	{
		this.main.find('.input-ajax-select').each(function() {
			$.b.app.select2Ajax($(this), {allowClear: false});
		});
	};

	/**
	 * Update
	 */
	$.b.app.Settings.prototype.initUpdateActionEvent = function()
	{
		var self = this;
		this.main.find('.btn-update').on('click', function() {
			self.main.find('form').submit();
			return false;
		});
	};

	/**
	 * Input key press
	 */
	$.b.app.Settings.prototype.initInputKeyPressActionEvent = function()
	{
		var self = this;
		this.main.find('form input').on('keypress', function(e) {
			if(e.keyCode == 13) {
				self.main.find('form').submit();
				return false;
			}
		});
	};

	/**
	 * Submit
	 */
	$.b.app.Settings.prototype.initSubmitActionEvent = function()
	{
	    var self = this;
	    this.main.find('form').on('submit', function() {
	        self.submit(
	            self.main.find('form').attr('action'),
	            self.main.find('input, select, textarea').serialize(), 
	            self.main.find('form').attr('method')
			);
			return false;
		});
	};
})(jQuery);