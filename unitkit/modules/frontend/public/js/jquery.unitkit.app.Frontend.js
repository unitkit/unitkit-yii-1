/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($) 
{
    $.unitkit = $.unitkit || {};
    $.unitkit.app = $.unitkit.app || {};
    
    $.unitkit.app.Frontend = function(args)
    {
        this.args = args;
    };
    
    /**
     * Init events
     */
    $.unitkit.app.Frontend.prototype.initEvents = function ()
    {
        $.unitkit.app.initCsrfForm();
    };
})(jQuery);