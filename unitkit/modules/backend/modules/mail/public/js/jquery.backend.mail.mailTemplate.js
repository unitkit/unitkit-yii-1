/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.mail = $.mail || {};
	$.backend.mail.mailTemplate = $.backend.mail.mailTemplate || {};
	
	$.b.tools.includeScriptFile('/modules/mail/js/jquery.backend.mail.mailSendingRole.js');
	$.b.tools.includeCssFile('/modules/mail/css/backend.mail.mailSendingRole.css');
	
	$.backend.mail.mailTemplate.List = function(args)
	{
		this.args = args;
		this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
		this.activeLocationUpdate = (this.args.activeLocationUpdate != undefined) ? this.args.activeLocationUpdate : true;
		this.requestSaved = {
			url: window.location.href || '', 
			data: undefined, 
			type: undefined
		};
		this.swfUpload = [];
		this.message = $.extend($.b.app.defaultMessage, this.args.message || {});
		this.filters = '';
	};
	
	/**
	 * Extend $.b.app.list
	 */
	$.backend.mail.mailTemplate.List.prototype = Object.create($.b.app.List.prototype);
	
	/**
	 * Overread
	 */
	$.backend.mail.mailTemplate.List.prototype.initExtendRowEvents = function (row)
	{
		this.initListSendingRoleActionEvent(row);
	};
	
	/**
	 * Overread
	 */
	$.backend.mail.mailTemplate.List.prototype.initExtendGridEvents = function (grid)
	{
		this.initListSendingRoleActionEvent(grid);
	};
	
	/**
	 * List sending role event
	 */
	$.backend.mail.mailTemplate.List.prototype.initListSendingRoleActionEvent = function (container)
	{
		var $this = this;
		container.find('.btn-list-sending-role').on('click', function(){
			// button
			var button = $(this);
			// hide button
			button.hide();
			// row
			var row = button.parents('tr');
			// container
			var container = row.next('tr.tr-sending-role');
			
			row.parents('table').removeClass('table-hover');
			
			// container already exist
			if(container.length > 0) {
                container.show();
            } else { // in other case
				// block UI
				$this.grid.block(this.blockUI);
				// ajax request
				var ajaxRequest = function(async) {
					$.b.app.ajax(button.attr('href'), function(json) {
						if (json.loginReload) {
							if ($.b.app.loginReload(json)) {
                                ajaxRequest(true);
                            }
						} else {
							var container = $('<tr class="tr-sending-role">' +
											  	'<td class="container-sending-role" colspan="'+ row.find('td').length +'">' + 
											  	json.html +
											  	'</td>' + 
											  '</tr>').insertAfter(row);
							
							var list = new $.backend.mail.mailSendingRole.List({ 
								main: container.find('.list:first'),
								activeAutoScroll: false
							});
							list.saveRequest(button.attr('href'), 'grid=1', 'GET');
							list.addAppEdit(new $.b.app.Edit({
								main: container.find('.dynamic'),
								list: list,
								activeAutoScroll: false
							}));
							list.initEvents();
							
							$this.grid.unblock();
						}
					}, null, 'GET', 'JSON', async);
				};
				ajaxRequest(true);
			}
			return false;
		});
	};

})(jQuery);