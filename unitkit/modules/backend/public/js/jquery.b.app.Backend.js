/**
 * @author Kevin Walter
 * @version 1.0
 */
;
(function($) 
{
    $.b = $.b || {};
    $.b.app = $.b.app || {};
    
    $.b.app.Backend = function(args)
    {
        this.args = args;
    };
    
    /**
     * Init events
     */
    $.b.app.Backend.prototype.initEvents = function ()
    {
        $.b.app.initAjaxForm();
        $.b.app.initQuickAjaxBtn();
        $.b.app.initCsrfForm();
        $.b.app.initDynamicPageBtn();
        $.b.app.bindPopstate();
        $.b.tools.initMaxlengthTextarea();
        $.b.tools.initTooltip();
        this.initChangeLanguageActionEvent();
        this.initMenu();
    };
    
    $.b.app.Backend.prototype.initMenu = function()
    {
        $('body').on('click', '.navbar a[href!=#]:not(.static)', function () {
            var me = $(this);
            var href = me.attr('href');
            var content = $('#content');

            content.block(this.defaultBlockUI);

            me.closest('.open').removeClass('open');

            var ajaxRequest = function(async) {
                $.b.app.ajax(
                    href, 
                    function(data) {
                        if(data.loginReload) {
                            if($.b.app.loginReload(data)) {
                                ajaxRequest(false);
                            }
                        } else {
                            $.b.app.loadDynamicPage(href, content, data);
                            content.unblock();
                            $.b.app.scrollTop();
                        }
                    }, 
                    'renderScript=1', 
                    'GET',
                    'JSON',
                    true
                );
            };
            ajaxRequest(true);

            return false;
        }).on('click', '.navbar a.disabled', function() {
            return false;
        });
    };
    
    /**
     * Change language action
     */
    $.b.app.Backend.prototype.initChangeLanguageActionEvent = function ()
    {
        $('form.current-language').on('change', 'select.language-selector', function() {
            $(this).parents('form').submit();
        });
    };
})(jQuery);