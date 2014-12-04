/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.cms = $.backend.cms || {};
	$.backend.cms.menu = $.backend.cms.menu || {};
	
	/**
     * Transform string to slug
     */
    $.backend.cms.menu.strToSlug = function(value)
    {
        var rExps=[
            {re:/[\xC0-\xC6]/g, ch:'A'},
            {re:/[\xE0-\xE6]/g, ch:'a'},
            {re:/[\xC8-\xCB]/g, ch:'E'},
            {re:/[\xE8-\xEB]/g, ch:'e'},
            {re:/[\xCC-\xCF]/g, ch:'I'},
            {re:/[\xEC-\xEF]/g, ch:'i'},
            {re:/[\xD2-\xD6]/g, ch:'O'},
            {re:/[\xF2-\xF6]/g, ch:'o'},
            {re:/[\xD9-\xDC]/g, ch:'U'},
            {re:/[\xF9-\xFC]/g, ch:'u'},
            {re:/[\xC7-\xE7]/g, ch:'c'},
            {re:/[\xD1]/g, ch:'N'},
            {re:/[\xF1]/g, ch:'n'} 
        ];
   
        for(var i=0, len=rExps.length; i<len; ++i)
            value = value.replace(rExps[i].re, rExps[i].ch);
   
        return value.toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9-.:\/]/g, '')
            .replace(/\-{2,}/g,'-');
    };
    
    /**
     * Translate component
     */
    $.backend.cms.menu.Translate = function(args)
    {
        this.args = args;
        this.appList = this.args.list;
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
    };
	
    /**
     * Extend $.unitkit.app.Translate
     */
    $.backend.cms.menu.Translate.prototype = Object.create($.unitkit.app.Translate.prototype);
    
    $.backend.cms.menu.Translate.prototype.initExtendEvents = function(row)
    {
        this.main.find('input.active-slug').on('keyup', function(e) {
            var $this = $(this);
            if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
                $this.val($.backend.cms.menu.strToSlug($this.val()));
            }
        });
    };
    
	/**
     * List component
     */
    $.backend.cms.menu.List = function(args)
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
    $.backend.cms.menu.List.prototype = Object.create($.unitkit.app.List.prototype);
    
    $.backend.cms.menu.List.prototype.initExtendEditingRowEvents = function(row)
    {
        row.find('input.active-slug').on('keyup', function(e) {
            if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
                var $this = $(this);
                $this.val($.backend.cms.menu.strToSlug($this.val()));
            }
        });
    };
	
    /**
     * Edit component 
     */
	$.backend.cms.menu.Edit = function(args)
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
	$.backend.cms.menu.Edit.prototype = Object.create($.unitkit.app.Edit.prototype);

    /**
     * Init extend events
     */
	$.backend.cms.menu.Edit.prototype.initExtendEvents = function()
	{
	    this.main.find('input.active-slug').on('keyup', function(e) {
	        if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
                var $this = $(this);
                $this.val($.backend.cms.menu.strToSlug($this.val()));
	        }
	    });
	};
	
})(jQuery);