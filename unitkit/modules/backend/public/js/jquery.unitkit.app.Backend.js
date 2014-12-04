/**
 * @author Kevin Walter
 * @version 1.0
 */
;
(function($) 
{
    $.unitkit = $.unitkit || {};
    $.unitkit.app = $.unitkit.app || {};
    
    $.unitkit.app.Backend = function(args)
    {
        this.args = args;
    };
    
    /**
     * Init events
     */
    $.unitkit.app.Backend.prototype.initEvents = function ()
    {
        $.unitkit.app.initAjaxForm();
        $.unitkit.app.initQuickAjaxBtn();
        $.unitkit.app.initCsrfForm();
        $.unitkit.app.initDynamicPageBtn();
        $.unitkit.app.bindPopstate();
        $.unitkit.tools.initMaxlengthTextarea();
        $.unitkit.tools.initTooltip();
        this.initChangeLanguageActionEvent();
        this.initMenu();
    };
    
    $.unitkit.app.Backend.prototype.initMenu = function()
    {
        $('body').on('click', '.navbar a[href!=#]:not(.static)', function () {
            var me = $(this);
            var href = me.attr('href');
            var content = $('#content');

            content.block(this.defaultBlockUI);

            me.closest('.open').removeClass('open');

            var ajaxRequest = function(async) {
                $.unitkit.app.ajax(
                    href, 
                    function(data) {
                        if(data.loginReload) {
                            if($.unitkit.app.loginReload(data)) {
                                ajaxRequest(false);
                            }
                        } else {
                            $.unitkit.app.loadDynamicPage(href, content, data);
                            content.unblock();
                            $.unitkit.app.scrollTop();
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
    $.unitkit.app.Backend.prototype.initChangeLanguageActionEvent = function ()
    {
        $('form.current-language').on('change', 'select.language-selector', function() {
            $(this).parents('form').submit();
        });
    };
})(jQuery);