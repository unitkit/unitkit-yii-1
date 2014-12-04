/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.mail = $.backend.mail || {};
	$.backend.mail.mailSendingRole = $.backend.mail.mailSendingRole || {};

	$.backend.mail.mailSendingRole.List = function(args)
	{
		this.args = args;
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
		this.requestSaved = {url: window.location.href || '', data: undefined, type: undefined};
		this.activeLocationUpdate = false;
		this.swfUpload = [];
		this.message = $.extend($.unitkit.app.defaultMessage, this.args.message || {});
		this.filters = '';
	};
	
	/**
	 * Extend $.unitkit.app.list
	 */
	$.backend.mail.mailSendingRole.List.prototype = Object.create($.unitkit.app.List.prototype);
	
	
	$.backend.mail.mailSendingRole.List.prototype.initGridEvents = function ()
	{
		this.initEditActionEvent(this.grid);
		this.initTranslateActionEvent(this.grid);
		this.initQuickEditRowsActionEvent(this.grid);
		this.initDeleteRowsEvents();
		this.initCloseActionEvent();
		this.initCheckRowsEvents();
		this.initSearchEvents();
		this.initPagerEvent();
	};
	
	$.backend.mail.mailSendingRole.List.prototype.initCloseActionEvent = function ()
	{
		this.actions.find('.btn-close').on('click', function(){
			var row = $(this).parents('tr');
			row.prev('tr').children('td:last').find('.btn-list-sending-role').show();
			row.hide();
			row.parents('table').addClass('table-hover');
			return false;
		});
	};

})(jQuery);