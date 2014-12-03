/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.message = $.backend.message || {};
	$.backend.message.message = $.backend.message.message || {};
	
	$.backend.message.message.List = function(args)
	{
        this.args = args;
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
        this.activeLocationUpdate = (this.args.activeLocationUpdate != undefined) ? this.args.activeLocationUpdate : true;
        this.requestSaved = {url: window.location.href || '', data: undefined, type: undefined};
        this.swfUpload = [];
        this.message = $.extend($.b.app.defaultMessage, this.args.message || {});
        this.filters = '';
	};
	
	/**
	 * Extend $.b.app.List
	 */
	$.backend.message.message.List.prototype = Object.create($.b.app.List.prototype);

	$.backend.message.message.List.prototype.initExtendGridEvents = function(grid)
	{
		this.initAjaxSelect();
		this.initTranslateAllActionEvent();
	};
	
	/**
	 * Init ajax select component
	 */
	$.backend.message.message.List.prototype.initAjaxSelect = function()
	{
		this.main.find('tbody .input-ajax-select').each(function(){
			$.b.app.select2Ajax($(this), {allowClear: false});
		});
	};
	
	/**
	 * Translate all messages
	 */
	$.backend.message.message.List.prototype.initTranslateAllActionEvent = function()
	{
		var $this = this;
		this.grid.find('.btn-translate-all').on('click', function(){
			var link = $(this);
			// block UI
			$this.grid.block($this.blockUI);
			// ajax request
			var ajaxRequest = function(async){
				$.b.app.ajax(
					link.attr('href'), 
					function(json) {
						if(json.loginReload) {
							if($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
						} else {
							$this.grid.unblock();
							$this.grid.html(json.html);
							if(json.filters) {
                                $this.filters = json.filters;
                            }
							$this.initGridEvents();
							$.b.app.scrollTop();
						}
					}, 
					$this.grid.find('tbody input, tbody select, tbody textarea').serialize() + '&partial=1', 
					'POST', 
					'JSON',
					async
				);
			};
			ajaxRequest(true);
			return false;
		});
	};

})(jQuery);