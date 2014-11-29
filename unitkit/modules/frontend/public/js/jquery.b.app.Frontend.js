/**
 * @author Kevin Walter
 * @version 1.0
 */
;
(function($) 
{
    $.b = $.b || {};
    $.b.app = $.b.app || {};
    
    $.b.app.Frontend = function(args)
    {
        this.args = args;
    };
    
    /**
     * Init events
     */
    $.b.app.Frontend.prototype.initEvents = function ()
    {
        $.b.app.initCsrfForm();
    };
})(jQuery);