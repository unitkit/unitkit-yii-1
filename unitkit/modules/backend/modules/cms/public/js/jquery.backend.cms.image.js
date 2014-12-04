/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.cms = $.backend.cms || {};
	$.backend.cms.image = $.backend.cms.image || {};
    
	/**
     * List component
     */
    $.backend.cms.image.List = function(args)
    {
        this.args = args;
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
        this.activeLocationUpdate = (this.args.activeLocationUpdate != undefined) ? this.args.activeLocationUpdate : true;
        this.requestSaved = {url: window.location.href || '', data: undefined, type: undefined};
        this.swfUpload = [];
        this.message = $.extend($.unitkit.app.defaultMessage, this.args.message || {});
        this.filters = '';
    };
    
    /**
     * Extend $.unitkit.app.List
     */
    $.backend.cms.image.List.prototype = Object.create($.unitkit.app.List.prototype);
    
    $.backend.cms.image.List.prototype.initAdvancedTextarea = function()
    {
        this.main.find('.advanced-textarea').each(function(){
            $(this).ckeditor();
        });
    };
	
    /**
     * Edit component 
     */
	$.backend.cms.image.Edit = function(args)
	{
        this.args = args;
        this.appList = this.args.list || {};
        this.swfUpload = [];
        this.message = {};
        this.message = $.extend($.unitkit.app.defaultMessage, this.args.message || {});
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};
	
	/**
	 * Extend $.unitkit.app.Edit
	 */
	$.backend.cms.image.Edit.prototype = Object.create($.unitkit.app.Edit.prototype);

	
})(jQuery);