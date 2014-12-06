/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.unitkit = $.unitkit || {};
	$.unitkit.app = $.unitkit.app || {};

	/**
	 * Edit component 
	 */
	$.unitkit.app.Edit = function(args)
	{
		this.args = args;
		this.swfUpload = [];
        this.appList = this.args.list || {};
		this.message = $.extend($.unitkit.app.defaultMessage, this.args.message || {});
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};
	
	/**
	 * BlockUI options
	 */
	$.unitkit.app.Edit.prototype.blockUIOptions = $.extend($.unitkit.app.defaultBlockUI, {});
	
	/**
	 * Destroy swf Upload
	 */
	$.unitkit.app.Edit.prototype.destroySwfUpload = function ()
	{
		for(var i = 0; i < this.swfUpload.length; ++i) {
			this.swfUpload[i].destroy();
		}
	};
	
	/**
	 * Submit form
	 * 
	 * @param url
	 * @param data
	 * @param type
	 */
	$.unitkit.app.Edit.prototype.submit = function(url, data, type)
	{
		var self = this;

		this.main.block(this.blockUIOptions);

		var ajaxRequest = function(async) {
			$.unitkit.app.ajax(
			    url, 
			    function(json) {
					if (json.loginReload) {
						if ($.unitkit.app.loginReload(json)) {
							ajaxRequest(false);
						}
					} else {
						self.destroySwfUpload();
                        $.unitkit.app.destroyCKEDITOR();
						self.main.unblock();
						self.main.html($.parseHTML(json.html));
						self.initEvents();
						if (self.activeAutoScroll) {
						    $.unitkit.app.scrollTop();
						}
					}
				}, 
				(data || '') + '&partial=1', 
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
	$.unitkit.app.Edit.prototype.initEvents = function ()
	{
		this.main = $(this.args.main);
		this.initAjaxSelect();
		this.initSubmitActionEvent();
		this.initInputKeyPressActionEvent();
		this.initUpdateActionEvent();
		this.initAddAgainActionEvent();
		this.initCloseActionEvent();
		this.initUploadFile();
		this.initDatePicker();
		this.initAdvancedTextarea();
		this.initExtendEvents();
	};
	
	/**
	 * Init extend events
	 */
	$.unitkit.app.Edit.prototype.initExtendEvents = function () {};
	
	/**
	 * Init advanced textarea
	 */
	$.unitkit.app.Edit.prototype.initAdvancedTextarea = function ()
	{
		this.main.find('.advanced-textarea').each(function () {
		    var $this = $(this);
		    var options = {};
		    if ((url = $this.attr('data-ckeditorFilebrowserBrowseUrl')) !== undefined) {
		        options.filebrowserBrowseUrl = url;
		    }
		    if((language = $this.attr('data-ckeditorLanguage')) !== undefined) {
                options.language = language;
            }
		    $this.ckeditor(options);
		});
	};
	
	/**
	 * Date picker
	 */
	$.unitkit.app.Edit.prototype.initDatePicker = function ()
	{
		this.main.find('.jui-datePicker').datepicker({
			dateFormat:'yy-mm-dd'
		});
	};
	
	/**
	 * Upload file
	 */
	$.unitkit.app.Edit.prototype.initUploadFile = function ()
	{
		var self = this;
		this.main.find('.upload-file').each(function () {
			var uploader = new $.unitkit.app.Uploader($(this));
			uploader.initEvents();
			self.swfUpload[self.swfUpload.length] = uploader.swfUpload;
		});
	};
	
	/**
	 * Add again
	 */
	$.unitkit.app.Edit.prototype.initAddAgainActionEvent = function ()
	{
		var self = this;
		this.main.find('.btn-add-again').on('click', function (){
			var link = $(this);
			self.main.block(self.blockUIOptions);
			
			var ajaxRequest = function(async){
				$.unitkit.app.ajax(
				    link.attr('href'), 
				    function(json) {
						if (json.loginReload) {
							if ($.unitkit.app.loginReload(json)) {
								ajaxRequest(false);
							}
						} else {					
							self.destroySwfUpload();
                            $.unitkit.app.destroyCKEDITOR();
							self.main.unblock();
							self.main.html($.parseHTML(json.html));
							self.initEvents();
							if (self.activeAutoScroll) {
							    $.unitkit.app.scrollTop();
							}
						}
					}, 
					'partial=1', 
					'GET', 
					'JSON', 
					async
				);
			};
			ajaxRequest(true);
			
			return false;
		});
	};
	
	/**
	 * Update
	 */
	$.unitkit.app.Edit.prototype.initUpdateActionEvent = function ()
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
	$.unitkit.app.Edit.prototype.initInputKeyPressActionEvent = function ()
	{
		var self = this;
		this.main.find('form input').on('keypress', function(e) {
			if (e.keyCode == 13) {
				self.main.find('form').submit();
				return false;
			}
		});
	};
	
	/**
	 * Submit
	 */
	$.unitkit.app.Edit.prototype.initSubmitActionEvent = function ()
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
	
	/**
	 * Ajax select
	 */
	$.unitkit.app.Edit.prototype.initAjaxSelect = function ()
	{
		this.main.find('.input-ajax-select').each(function () {
			$.unitkit.app.select2Ajax($(this));
		});
	};
	
	/**
	 * Close
	 */
	$.unitkit.app.Edit.prototype.initCloseActionEvent = function ()
	{
		var self = this;
		this.main.find('.btn-close').on('click', function () {
		    if ($.isEmptyObject(self.appList)) {
                return true;
		    }
            $.unitkit.app.destroyCKEDITOR();
			self.destroySwfUpload();
			self.appList.main.show();
			self.appList.loadDataGrid(
				self.appList.requestSaved.url, 
				(self.appList.requestSaved.data || ''), 
				self.appList.requestSaved.type
			);			
			self.main.html('');

			if (self.activeAutoScroll) {
			    $.unitkit.app.scrollTop();
			}
			
			return false;
		});
	};
})(jQuery);