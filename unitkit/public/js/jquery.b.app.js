/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function($)
{
	$.b = $.b || {};
	$.b.app = $.b.app || {};
	
	/**
	 * Default message
	 */
	$.b.app.defaultMessage = {};
	
    /**
     * Default blockUI options
     */
    $.b.app.defaultBlockUI = $.extend($.blockUI.defaults, {
        message:'&nbsp;', 
        css: {  
            width:'60px', 
            height:'60px', 
            border:'1px solid #505052',
            background:'white url(/b/images/blockUI/ajax-loader.gif) no-repeat center center'
        }
    });
    
    /**
     * Bind popstate event
     */
    $.b.app.bindPopstate = function()
    {
        $(window).bind('popstate', function(e) {
            $.b.app.loadAjaxContent(window.location, '', $('#content'));
        });
    };
    
    /**
     * Destroy CKEDITOR instances
     */
    $.b.app.destroyCKEDITOR = function()
    {
        for(name in CKEDITOR.instances) {
            CKEDITOR.instances[name].destroy();
        }
    };
	
	/**
	 * Load page in content container with ajax call
	 * 
	 * @param url Url request
	 * @param urlData Datas to send
	 */
	$.b.app.loadAjaxContent = function(url, urlData, container) 
	{
	    container.block($.b.app.defaultBlockUI);

        var ajaxRequest = function(async) {
            $.b.app.ajax(
                url, 
                function(data) {
                    if(data.loginReload) {
                        if($.b.app.loginReload(data)) {
                            ajaxRequest(false);
                        }
                    } else {
                        $.b.app.loadDynamicPage(url, container, data);
                        container.unblock();
                        $.b.app.scrollTop();
                    }
                }, 
                'renderScript=1' + (urlData !== '' ? '&' + urlData : ''), 
                'GET',
                'JSON',
                true
            );
        };
        ajaxRequest(true);
	};
	
    /**
     * Ajax action 
     * 
     * @param url Url request
     * @param success Success function
     * @param data Datas to send
     * @param type Request method (GET or POST). The default value is GET
     * @param dataType Data type (HTML, JSON ...). The default value is HTML
     * @param async Request is asynchronous. To be synchronous you will set value to false. The default value is true
     */
    $.b.app.ajax = function(url, success, data, type, dataType, async)
    {
        // default args
        dataType = dataType || 'HTML';
        type = type || 'GET';
        async = (async !== undefined) ? async : true;
        data = data || '';

        if(type.toUpperCase() == 'POST') {
            data = ((data != '') ? data + '&' : '') + 'b_csrf_token=' + encodeURI($('meta[name=b_csrf_token]').attr('content'));
        }
        
        $.ajax({
            url: url,
            data: data,
            dataType: dataType,
            type: type,
            success: success,
            async: async
        });
    };
	
	/**
     * Load dynamic page
     */
    $.b.app.loadDynamicPage = function(href, container, data)
    {
        // update current location
        if(href != window.location && href !== false) {
            window.history.pushState({path:href}, '', href);
        }
        
        // update title
        if(data.title) {
            $('title').html(data.title);
        }
        
        // update container
        if(data.html != '') {
            container.html(data.html);
        }
        
        // script
        var script = '';
        for(var key in data.scripts) {
            script += data.scripts[key];
        }
        
        // include script files
        for(var key in data.scriptFiles) {
            $.b.tools.includeScriptFile(data.scriptFiles[key]);
        }
        
        // include css files
        for(var key in data.cssFiles) {
            $.b.tools.includeCssFile(data.cssFiles[key]);
        }
        
        // include script
        if(script != '') {
            $.b.app.includeScript(script);
        }
    };
    
    /**
     * Include scripts
     * 
     * @param scripts Scripts to insert
     */
    $.b.app.includeScript = function(scripts)
    {
        $('#bDynamicScript').remove();
        $('#b').append('<script type="text/javascript" id="bDynamicScript">' + scripts +'</script>');
    };
	
	/**
	 * Ajax login
	 */
	$.b.app.loginReload = function(json)
	{
		if(json.url) { // redirect
			window.location = json.url;
			return false;
		} else { // update csrf token and session key
			$('meta[name=b_csrf_token]').attr('content', json.csrf);
			$('.btn-upload').attr('data-sessKey', json.sess_key);
			return true;
		}
	};
	
	/**
	 * Scroll to top
	 */
	$.b.app.scrollTop = function(scrollTop, time)
	{
		time = (time) ? time : 200;
		scrollTop = (scrollTop) ? scrollTop : 0;
		$('html,body').animate({scrollTop: scrollTop}, time);
	};
	
	/**
     * Initialization of select2 plugin
     * 
     * @param object jQuery object
     * @param option select2 option
     */
    $.b.app.select2Ajax = function(object, option)
    {
        var defaultOption = {
            minimumInputLength: 0,
            allowClear: object.hasClass('allow-clear'),
            initSelection : function (element, callback) {
                callback({id:element.val(), text: element.attr('data-text')});
            },
            nextSearchTerm : function displayCurrentValue(selectedObject, currentSearchTerm) {
                return object.attr('data-updateAction') !== undefined ? selectedObject.text : '';
            },
            ajax: { 
                url: object.attr('data-action'),
                dataType: 'JSON',
                type: 'GET',
                quietMillis: 100,
                data: function (term, page) {
                    return {search: term};
                },
                results: function (data, page) {
                    if(data.loginReload) {
                        $.b.app.loginReload(data);                          
                        object.select2('close');
                        object.select2('open');
                    }
                    else {
                        return {results: data};
                    }
                }
            },
        };
        
        if(object.attr('data-addAction') !== undefined) {
            defaultOption.addItem = {
                url: object.attr('data-addAction')
            };
        }
        
        if(object.attr('data-updateAction') !== undefined) {
            defaultOption.updateItem = {
                url: object.attr('data-updateAction'),
                argument: 'id'
            };
            
            if(object.attr('data-updateArgument') !== undefined) {
                defaultOption.updateItem.argument = object.attr('data-updateArgument');
            } 
        }
        
        defaultOption.item = {};
        if(object.attr('data-relatedField') !== undefined) {
            defaultOption.item.relatedField = object.attr('data-relatedField');
        } else {
            defaultOption.item.relatedField = '.select-related-field';
        }
        
        var finalOption = $.extend(defaultOption, option || {});
        object.select2(finalOption);    
    };
    
    /**
     * Instanciate ajax form
     */
    $.b.app.initAjaxForm = function()
    {
        $(document).on('submit', 'form.ajax', function(){
            var form = $(this);
            var dataTarget = form.attr('data-ajaxTarget');
            var target = form;
            
            if(dataTarget !== undefined) {
                target = $(dataTarget);
            }

            form.block($.b.app.defaultBlockUI);

            var ajaxRequest = function(async) {
                $.b.app.ajax(
                    form.attr('action'), 
                    function(json) {
                        if(json.loginReload) {
                            if($.b.app.loginReload(json))
                                ajaxRequest(false);
                        } else {
                            target.replaceWith($.parseHTML(json.html));
                        }
                    }, 
                    form.serialize(), 
                    form.attr('method'), 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
            
            return false;
        });
    };
    
    /**
     * Init dynamic page button
     */
    $.b.app.initDynamicPageBtn = function()
    {
        $(document).on('click', '.btn-dyn-page', function() {
            $.b.app.loadAjaxContent($(this).attr('href'), '', $('#content'));
            return false;
        });
    };
    
    /**
     * Init quick ajax button
     */
    $.b.app.initQuickAjaxBtn = function()
    {
        $(document).on('click', '.btn-quick-ajax', function() {
            var $this = $(this);
            var loadContainer = null;
            var targetContainer = null;
            var dataQuery = null;
            
            if ($this.attr('data-loadContainer') !== undefined) {
                loadContainer = $($this.attr('data-loadContainer'));
            }
            if ($this.attr('data-targetContainer') !== undefined) {
                targetContainer = $($this.attr('data-targetContainer'));
            }
            if ($this.attr('data-dataQuery') !== undefined) {
                dataQuery = $this.attr('data-dataQuery');
            }
            if (loadContainer !== null) {
                loadContainer.block($.b.app.defaultBlockUI);
            }
            
            var ajaxRequest = function(async) {
                $.b.app.ajax(
                    $this.attr('href'), 
                    function(json){
                        if (json.loginReload) {
                            if ($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {    
                            if (loadContainer !== null) {
                                loadContainer.unblock();
                            }
                            if (targetContainer !== null) {
                                targetContainer.html(json.html);
                                targetContainer.removeClass('hide');
                            }
                        }
                    }, 
                    dataQuery, 
                    'POST', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
            
            return false;
        });
    };
    
    /**
     * Attach csrf token to a form
     */
    $.b.app.initCsrfForm = function()
    {
        $(document).on('submit', 'form.csrf', function() {
            var $csrf = $('meta[name=b_csrf_token]');
            $('<input>').attr({
                'type': 'hidden',
                'name': $csrf.attr('name')
            })
            .val($csrf.attr('content'))
            .appendTo($(this));
        });
    };
})(jQuery);