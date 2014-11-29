/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
	$.backend = $.backend || {};
	$.backend.cms = $.backend.cms || {};
	$.backend.cms.pageContainer = $.backend.cms.pageContainer || {};
	
	/**
     * Transform string to slug
     */
    $.backend.cms.pageContainer.strToSlug = function(value)
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
   
        for(var i=0, len=rExps.length; i<len; ++i) {
            value = value.replace(rExps[i].re, rExps[i].ch);
        }

        return value.toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9-.]/g, '')
            .replace(/\-{2,}/g,'-');
    };
    
    /**
     * Translate component
     */
    $.backend.cms.pageContainer.Translate = function(args)
    {
        this.args = args;
        this.appList = this.args.list;
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
    };
	
    /**
     * Extend $.b.app.Translate
     */
    $.backend.cms.pageContainer.Translate.prototype = Object.create($.b.app.Translate.prototype);
    
    $.backend.cms.pageContainer.Translate.prototype.initExtendEvents = function(row)
    {
        this.main.find('input.active-slug').on('keyup', function(e) {
            var $this = $(this);
            if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
                $this.val($.backend.cms.pageContainer.strToSlug($this.val()));
            }
        });
    };
    
	/**
     * List component
     */
    $.backend.cms.pageContainer.List = function(args)
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
    $.backend.cms.pageContainer.List.prototype = Object.create($.b.app.List.prototype);
    
    $.backend.cms.pageContainer.List.prototype.initExtendEditingRowEvents = function(row)
    {
        row.find('input[name="BCmsPageI18n[slug]"]').on('keyup', function(e) {
            if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
                $('input[name="BCmsPageI18n[slug]"]').val($.backend.cms.pageContainer.strToSlug($(this).val()));
            }
        });
    };
	
    /**
     * Edit component 
     */
	$.backend.cms.pageContainer.Edit = function(args)
	{
        this.args = args;
        this.appList = this.args.list || {};
        this.swfUpload = [];
        this.message = {};
        this.message = $.extend($.b.app.defaultMessage, this.args.message || {});
        this.activeAutoScroll = (this.args.activeAutoScroll != undefined) ? this.args.activeAutoScroll : true;
	};
	
	/**
	 * Extend $.b.app.Edit
	 */
	$.backend.cms.pageContainer.Edit.prototype = Object.create($.b.app.Edit.prototype);

    /**
     * Init extend events
     */
	$.backend.cms.pageContainer.Edit.prototype.initExtendEvents = function()
	{
	    var $this = this;
	    
	    this.main.find('input[name="BCmsPageI18n[slug]"], input[name="BCmsPageI18n[title]"].active-slug').on('keyup', function(e) {
	        if($.inArray(e.which, [37, 38, 39, 40, 46, 8]) === -1) {
	            $('input[name="BCmsPageI18n[slug]"]').val($.backend.cms.pageContainer.strToSlug($(this).val()));
	        }
	    });

	    this.main.find('.btn-refresh-cms-page').on('click', function(){
	        var self = $(this);
            $this.main.block($this.blockUI);

	        var ajaxRequest = function(async) {
                $.b.app.ajax(
                    self.attr('href'),
                    function(json){
                        if(json.loginReload) {
                            if($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {
                            $this.main.unblock();
                            $(self.attr('data-targetContainer')).html(json.html);
                        }
                    }, 
                    'page_slug=' + $this.main.find('input[name="BCmsPageI18n[slug]"]').val(),
                    'POST', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
            
            return false;
	    });
	    
	    var pageContainer = $('#pageContainers');
	    
	    this.main.find('.input-ajax-select-layout').on('change', function(){
	        var self = $(this);

	        pageContainer.block($this.blockUI);
	        var ajaxRequest = function(async){
                $.b.app.ajax(
                    self.attr('data-actionLoadContent'),
                    function(json){
                        if(json.loginReload) {
                            if($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {                   
                            pageContainer.unblock();
                            $.b.app.destroyCKEDITOR();
                            pageContainer.html($.parseHTML(json.html));
                            pageContainer.find('.advanced-textarea').each(function() {
                                var textarea = $(this);
                                var options = {};
                                if((url = textarea.attr('data-ckeditorFilebrowserBrowseUrl')) !== undefined) {
                                    options.filebrowserBrowseUrl = url;
                                }
                                if((language = textarea.attr('data-ckeditorLanguage')) !== undefined) {
                                    options.language = language;
                                }
                                textarea.ckeditor(options);
                            });
                        }
                    }, 
                    'layout_id=' + self.val() + '&pageId=' + self.attr('data-pageId'),
                    'GET', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
	    });
	};
	
})(jQuery);