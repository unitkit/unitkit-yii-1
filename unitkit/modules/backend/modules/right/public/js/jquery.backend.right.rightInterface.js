/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.right = $.backend.right || {};
	
	$.backend.right.rightInterface = function(args)
	{
		this.args = args;
	};
	
	/**
	 * Default blockUI options
	 */
	$.backend.right.rightInterface.prototype.defaultBlockUI = $.extend($.b.app.defaultBlockUI, {});
	
	/**
	 * Init events
	 */
	$.backend.right.rightInterface.prototype.initEvents = function()
	{
		this.main = $(this.args.main);
		this.rights = $(this.args.rights);
		this.interfaces = $(this.args.interfaces);
		this.initAjaxSelect();
		this.initChangeInterfaceActionEvent();
	};
	
	/**
	 * Init ajax select component
	 */
	$.backend.right.rightInterface.prototype.initAjaxSelect = function()
	{
		this.interfaces.find('.input-ajax-select').each(function(){
			$.b.app.select2Ajax($(this), {allowClear: false});
		});
	};
	
	/**
	 * Init main events
	 */
	$.backend.right.rightInterface.prototype.initChangeInterfaceActionEvent = function()
	{
		var $this = this;
		
		// select interface
		this.interfaces.find('input').change(function(){
			var input = $(this);
			if(input.val() != '')
			{
				var form = $(this).parents('form');
				// block UI
				$this.main.block($this.defaultBlockUI);
				// ajax request
				var ajaxRequest = function(async)
				{
					$.b.app.ajax(
						form.attr('action'), 
						function(json) {
							if(json.loginReload)
							{
								if($.b.app.loginReload(json))
								{
									ajaxRequest(false);
									input.change();
								}
							}
							else
							{
								$this.main.unblock();
								$this.rights.html(json.html);
								
								var edit = $this.edit({main: $this.rights});
								edit.initEvents();
								$.b.app.scrollTop();
							}
						}, 
						input.serialize(), 
						form.attr('method'), 
						'JSON'
					);
				};
				ajaxRequest(true);
			}
		});
	};
	
	/**
	 * Create $.b.app.edit component
	 */
	$.backend.right.rightInterface.prototype.edit = function(args)
	{
		var edit = new $.b.app.edit(args);
		
		/**
		 * Override $.b.app.edit.prototype.initExtendEvents
		 */
		edit.initExtendEvents = function(){
			var table = this.main.find('table');
			// check / uncheck column
			table.find('thead input.check-all').on('click', function(){
				var isChecked = $(this).is(':checked');
				var indice = $(this).parents('th').prevAll().length;
				table.find('tbody tr').each(function(){
					$(this).children('th,td').eq(indice).find('input[type=checkbox]').attr('checked', isChecked);
				});
			});
		};
		
		return edit;
	};
	
})(jQuery);