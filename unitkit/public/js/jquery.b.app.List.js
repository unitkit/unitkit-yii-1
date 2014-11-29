/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function ($) 
{
    $.b = $.b || {};
    $.b.app = $.b.app || {};
    
    /**
     * List component
     */
    $.b.app.List = function (args)
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
     * Add $.b.app.Settings object
     * 
     * @param object $.b.app.Settings
     */
    $.b.app.List.prototype.addAppSettings = function (object)
    {
        this.appSettings = object;
    };
    
    /**
     * Add $.b.app.Edit object
     * 
     * @param object $.b.app.Edit
     */
    $.b.app.List.prototype.addAppEdit = function (object)
    {
        this.appEdit = object;
    };
    
    /**
     * Add $.b.app.Translate object
     * 
     * @param object $.b.app.Translate
     */
    $.b.app.List.prototype.addAppTranslate = function (object)
    {
        this.appTranslate = object;
    };

    /**
     * BlockUI options
     */
    $.b.app.List.prototype.blockUIOptions = $.extend($.b.app.defaultBlockUI, {});

    /**
     * Save request information 
     */
    $.b.app.List.prototype.saveRequest = function (url, data, type)
    {
        this.requestSaved.url = url;
        this.requestSaved.data = data;
        this.requestSaved.type = type;
    };
    
    /**
     * Refresh data grid
     * 
     * @param url string ajax url
     * @param data Object ajax data
     * @param type string ajax type
     * @param save bool save request information
     * @param callBack function to execute 
     */
    $.b.app.List.prototype.loadDataGrid = function (url, data, type, save)
    {
        var self = this;

        if(save === true) {
            this.saveRequest(url, data, type);
        }
        
        this.grid.block(this.blockUIOptions);

        var ajaxRequest = function (async) {
            $.b.app.ajax(
                url, 
                function (json) {
                    if(json.loginReload) {
                        if($.b.app.loginReload(json)) {
                            ajaxRequest(false);
                        }
                    } else {
                        $.b.app.destroyCKEDITOR();
                        self.destroyAllSwfUpload();
                        self.grid.unblock();
                        if(json.filters) {
                            self.filters = json.filters;
                        }
                        $.b.app.loadDynamicPage(self.activeLocationUpdate ? url : false, self.grid, json);
                        self.initGridEvents();
                        if(self.activeAutoScroll) {
                            $.b.app.scrollTop();
                        }
                    }
                }, 
                (data != '' && data != undefined ? data + '&' : '') + 'partial=1' , 
                type, 
                'JSON', 
                async
            );
        };
        ajaxRequest(true);
    };
    
    /**
     * Destroy all swf upload objects
     */
    $.b.app.List.prototype.destroyAllSwfUpload = function (id)
    {
        if(id !== undefined) {
            if(this.swfUpload[id]) {
                for(var i = 0; i < this.swfUpload[id].length; ++i) {
                    this.destroySwfUpload(id, i);
                }
            }
        } else {
            for(var i = 0; i < this.swfUpload.length; ++i) {
                if(this.swfUpload[i]) {
                    for(var j = 0; j < this.swfUpload[i].length; ++j) {
                        this.destroySwfUpload(i, j);
                    }
                }
            }
        }
    };
    
    /**
     * Destroy an swf upload objects
     * 
     * @param rowId row ID of the data grid
     * @param elmtId position
     */
    $.b.app.List.prototype.destroySwfUpload = function (rowId, elmtId)
    {
        if(this.swfUpload[rowId][elmtId] != null) {
            this.swfUpload[rowId][elmtId].destroy();
            this.swfUpload[rowId][elmtId] = null;
        }
    };
    
    /**
     * Refresh a row
     * 
     * @param row jQuery object
     * @param url jQuery ajax url
     * @param data jQuery ajax data
     * @param type jQuery ajax type
     */
    $.b.app.List.prototype.refreshRow = function (row, url, data, type)
    {
        var self = this;
        
        this.grid.block(this.blockUIOptions);
        
        var ajaxRequest = function (async) {
            $.b.app.ajax(
                url, 
                function (json) {
                    if(json.loginReload) {
                        if($.b.app.loginReload(json)) {
                            ajaxRequest(false);
                        }
                    } else {
                        $.b.app.destroyCKEDITOR();
                        self.destroyAllSwfUpload(row.index());
                        self.grid.unblock();
                        $row = $($.parseHTML(json.html));
                        row.replaceWith($row);
                        self.initRowEvents($row);
                    }
                }, 
                data, 
                type, 
                'JSON'
            );
        };
        ajaxRequest(true);
    };
    
    /**
     * Edit a row
     * 
     * @param Object row jQuery object
     * @param string url jQuery ajax url
     * @param string data jQuery ajax data
     * @param string type jQuery ajax type
     * @param {function} callback Function execute on request complete
     */
    $.b.app.List.prototype.editRow = function (row, url, data, type, callback)
    {
        var self = this;

        this.grid.block(this.blockUIOptions);

        var ajaxRequest = function (async) {
            $.b.app.ajax(
                url, 
                function (json){
                    if(json.loginReload) {
                        if($.b.app.loginReload(json))
                            ajaxRequest(false);
                    } else {
                        $.b.app.destroyCKEDITOR();
                        self.destroyAllSwfUpload(row.index());
                        self.grid.unblock();
                        $row = $($.parseHTML(json.html));
                        row.replaceWith($row);
                        if( ! json.refreshRow) {
                            self.initEditingRowEvents($row);
                        } else {
                            self.initRowEvents($row);
                        }

                        if(typeof callback !== 'undefined') {
                            callback();
                        }
                    }
                }, 
                data,
                type, 
                'JSON', 
                async
            );
        };
        ajaxRequest(true);
    };
    
    /**
     * Initilizing events
     */
    $.b.app.List.prototype.initEvents = function ()
    {
        this.main = $(this.args.main);
        this.grid = this.main.find('.grid');
        this.advSearch = this.main.find('.adv-search');
        this.actions = this.main.find('.actions');
        this.initAdvSearchEvents();
        this.initActionsEvents();
        this.initGridEvents();
        this.initExtendEvents();
    };

    /**
     * Init extend events (main)
     */
    $.b.app.List.prototype.initExtendEvents = function (){};
    
    /**
     * Init extend events (grid)
     */
    $.b.app.List.prototype.initExtendGridEvents = function (grid){};
    
    /**
     * Init Extend events (editing row)
     */
    $.b.app.List.prototype.initExtendEditingRowEvents = function (row){};
    
    /**
     * Init Extend events (row)
     */
    $.b.app.List.prototype.initExtendRowEvents = function (row){};
    
    /**
     * Actions events
     */
    $.b.app.List.prototype.initActionsEvents = function ()
    {
        this.initEditActionEvent(this.actions);
        this.initSettingsActionEvent(this.actions);
        this.initAdvSearchActionEvent(this.actions);
        this.initExportActionEvent(this.actions);
    };
    
    /**
     * Grid events
     */
    $.b.app.List.prototype.initGridEvents = function ()
    {
        this.initEditActionEvent(this.grid);
        this.initTranslateActionEvent(this.grid);
        this.initQuickEditRowsActionEvent(this.grid);
        this.initSelectRowEvent(this.grid);
        this.initDeleteRowsEvents();
        this.initCheckRowsEvents();
        this.initSearchEvents();
        this.initPagerEvent();
        this.initExtendGridEvents(this.grid);
    };
    
    /**
     * Edit
     */
    $.b.app.List.prototype.initEditActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-add, .btn-update').on('click', function () {
            var link = $(this);
            self.main.block(self.blockUIOptions);
            
            var ajaxRequest = function (async) {
                var url = link.attr('href');
                $.b.app.ajax(
                    url, 
                    function (json) {
                        if(json.loginReload) {
                            if($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {   
                            var dynamic = $(self.appEdit.args.main);
                            $.b.app.loadDynamicPage(self.activeLocationUpdate ? url : false, dynamic, json);
                            self.appEdit.initEvents();
                            self.main.unblock();
                            self.main.hide();
                            if(self.activeAutoScroll) {
                                $.b.app.scrollTop();
                            }
                        }
                    }, 
                    null, 
                    'GET', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
            
            return false;
        }); 
    };
    
    /**
     * Settings
     */
    $.b.app.List.prototype.initSettingsActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-settings').on('click', function () {
            var link = $(this);

            self.main.block(self.blockUIOptions);

            var ajaxRequest = function (async){
                var url = link.attr('href');

                $.b.app.ajax(
                    url, 
                    function (json) {
                        if (json.loginReload) {
                            if($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {
                            var dynamic = $(self.appSettings.args.main);
                            $.b.app.loadDynamicPage(self.activeLocationUpdate ? url : false, dynamic, json);
                            self.appSettings.initEvents();
                            self.main.unblock();
                            self.main.hide();
                            if(self.activeAutoScroll) {
                                $.b.app.scrollTop();
                            }
                        }
                    }, 
                    null, 
                    'GET', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);
            
            return false;
        });
    };
    
    /**
     * Advanced search
     */
    $.b.app.List.prototype.initAdvSearchActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-adv-search').on('click', function () {
            self.advSearch.show();
            if(self.activeAutoScroll) {
                $.b.app.scrollTop();
            }
            return false;
        });
    };
    
    /**
     * Export
     */
    $.b.app.List.prototype.initExportActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-export').on('click', function () {
            window.location = $(this).attr('href') + '?' + self.filters;
            return false;
        });
    };
    
    /**
     * Translate
     */ 
    $.b.app.List.prototype.initTranslateActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-translate').on('click', function (){
            var link = $(this);
            var url = link.attr('href');

            self.main.block(self.blockUIOptions);

            var ajaxRequest = function (async){
                $.b.app.ajax(
                    link.attr('href'), 
                    function (json){
                        if (json.loginReload) {
                            if ($.b.app.loginReload(json)) {
                                ajaxRequest(false);
                            }
                        } else {
                            var dynamic = $(self.appTranslate.args.main);
                            $.b.app.loadDynamicPage(self.activeLocationUpdate ? url : false, dynamic, json);
                            self.appTranslate.initEvents();
                            self.main.unblock();
                            self.main.hide();

                            if (self.activeAutoScroll) {
                                $.b.app.scrollTop();
                            }
                        }
                    }, 
                    null, 
                    'GET', 
                    'JSON', 
                    async
                );
            };
            ajaxRequest(true);

            return false;
        });
    };
    
    /**
     * Initializing advanced search events
     */
    $.b.app.List.prototype.initAdvSearchEvents = function ()
    {
        this.initInputActionAdvSearchEvent();   
        this.initSearchActionAdvSearchEvent();
        this.initDatePickerAdvSearch();
        this.initAjaxSelectAdvSearch();
        this.initCloseActionAdvSearchEvent();
    };
    
    /**
     * Input action
     */
    $.b.app.List.prototype.initInputActionAdvSearchEvent = function ()
    {
        var self = this;
        this.advSearch.find('input').on('keyup', function (e) {
            if (e.keyCode == 13) {
                self.submitAdvSearch();
            }
            return false;
        });
    };
    
    /**
     * Search
     */
    $.b.app.List.prototype.initSearchActionAdvSearchEvent = function ()
    {
        var self = this;
        this.advSearch.find('.btn-search').on('click', function () {
            self.submitAdvSearch();
            return false;
        });
    };
    
    /**
     * Date picker
     */
    $.b.app.List.prototype.initDatePickerAdvSearch = function ()
    {
        this.advSearch.find('.date-picker').datepicker({
            dateFormat:'yy-mm-dd'
        });
    };
    
    /**
     * Close
     */
    $.b.app.List.prototype.initCloseActionAdvSearchEvent = function ()
    {
        var self = this;
        this.advSearch.find('.close').on('click', function () {
            self.advSearch.hide();
            self.advSearch.find('input, select, textarea').val('');
            self.advSearch.find('.input-ajax-select').select2('val','');
            return false;
        });
    };
    
    /**
     * Ajax select
     */
    $.b.app.List.prototype.initAjaxSelectAdvSearch = function ()
    {
        this.advSearch.find('.input-ajax-select').each(function () {
            $.b.app.select2Ajax($(this));
        });
    };
    
    /**
     * Initializing search header events
     */
    $.b.app.List.prototype.initSearchEvents = function ()
    {
        this.initAjaxSelectSearchEvent();
        this.initDatePickerSearchEvent();
        this.initInputActionSearchEvent();
        this.initSearchActionSearchEvent();
        this.initSortActionSearchEvent();
    };
    
    /**
     * Ajax select
     */
    $.b.app.List.prototype.initAjaxSelectSearchEvent = function ()
    {
        this.grid.find('.tr-search .input-ajax-select').each(function () {
            $.b.app.select2Ajax($(this));
        });         
    };
    
    /**
     * Date picker
     */
    $.b.app.List.prototype.initDatePickerSearchEvent = function ()
    {
        this.grid.find('.tr-search .date-picker').datepicker({dateFormat: 'yy-mm-dd'});
    };
    
    /**
     * Input
     */
    $.b.app.List.prototype.initInputActionSearchEvent = function ()
    {
        var self = this;
        this.grid.find('.tr-search input').on('keyup', function (e) {
            if (e.keyCode == 13) {
                self.submitSearch();
            }
            return false;
        });         
    };
    
    /**
     * Search
     */
    $.b.app.List.prototype.initSearchActionSearchEvent = function ()
    {
        var self = this;
        this.grid.find('.tr-search .btn-search').on('click', function () {
            self.submitSearch();
            return false;
        });         
    };
    
    /**
     * Sort
     */
    $.b.app.List.prototype.initSortActionSearchEvent = function ()
    {
        var self = this;
        this.grid.find('.tr-sort a').on('click', function () {
            self.loadDataGrid($(this).attr('href'), '', 'GET', true);
            return false;
        });         
    };
    
    /**
     * Initializing row editing events
     * 
     * @param row jQuery object
     */
    $.b.app.List.prototype.initEditingRowEvents = function (row)
    {
        this.initActionUpdateEditingRowEvent(row);
        this.initActionInputKeyPressEditingRowEvent(row);
        this.initActionCloseEditingRowEvent(row);
        this.initUploadFileEditingRow(row);
        this.initAjaxSelectEditingRow(row);
        this.initDatePickerEditingRow(row);
        this.initAdvancedTextareaEditingRow(row);
        this.initExtendEditingRowEvents(row);
    };
    
    /**
     * Update
     * 
     * @param row
     */
    $.b.app.List.prototype.initActionUpdateEditingRowEvent = function (row)
    {
        var self = this;
        row.find('.btn-update-row').on('click', function () {
            self.editRow(row, $(this).attr('href'), row.find('input, select, textarea').serialize(), 'POST');
            return false;
        });
    };

    /**
     * Input key press
     * 
     * @param row
     */
    $.b.app.List.prototype.initActionInputKeyPressEditingRowEvent = function (row)
    {
        var self = this;
        row.find('input').on('keypress', function (e) {
            if (e.keyCode == 13) {
                self.editRow(row, row.find('.btn-update-row').attr('href'), row.find('input, select, textarea').serialize(), 'POST');
                return false;
            }
        });
    };
    
    /**
     * Close
     * 
     * @param row
     */
    $.b.app.List.prototype.initActionCloseEditingRowEvent = function (row)
    {
        var self = this;
        row.find('.btn-close-row').on('click', function () {
            self.refreshRow(row, $(this).attr('href'));
            return false;
        });
    };
    
    /**
     * Upload file
     * 
     * @param row
     */
    $.b.app.List.prototype.initUploadFileEditingRow = function (row)
    {
        var self = this;
        row.find('.upload-file').each(function () {
            if ( ! self.swfUpload[row.index()]) {
                self.swfUpload[row.index()] = [];
            }
            var uploader = new $.b.app.Uploader($(this));
            uploader.initEvents();
            self.swfUpload[row.index()][self.swfUpload[row.index()].length] = uploader.swfUpload;
        });
    };
    
    /**
     * Ajax Select
     * 
     * @param row
     */
    $.b.app.List.prototype.initAjaxSelectEditingRow = function (row)
    {
        row.find('.input-ajax-select').each(function () {
            var me = $(this);
            $.b.app.select2Ajax(me, {allowClear: me.hasClass('allow-clear')});
        });
    };
    
    /**
     * DatePicker
     * 
     * @param row
     */
    $.b.app.List.prototype.initDatePickerEditingRow = function (row)
    {
        row.find('.date-picker').datepicker({
            dateFormat:'yy-mm-dd'
        });
    };
    
    /**
     * Advanced textarea
     * 
     * @param row
     */
    $.b.app.List.prototype.initAdvancedTextareaEditingRow = function (row) 
    {
        row.find('.advanced-textarea').each(function () {
            var $this = $(this);
            var options = {},
                url,
                language;
            if ((url = $this.attr('data-ckeditorFilebrowserBrowseUrl')) !== undefined) {
                options.filebrowserBrowseUrl = url;
            }
            if ((language = $this.attr('data-ckeditorLanguage')) !== undefined) {
                options.language = language;
            }
            $this.ckeditor(options);
        });
    };
    
    /**
     * Initializing pager events
     */
    $.b.app.List.prototype.initPagerEvent = function ()
    {
        var self = this;
        this.grid.find('.pagination li a').on('click', function () {
            var me = $(this);
            if (me.parent('li:not(.disabled, .active)').length > 0) {
                self.loadDataGrid(me.attr('href'), '', 'GET', true);
            }
            return false;
        });
    };
    
    /**
     * Submit advanced search
     */
    $.b.app.List.prototype.submitAdvSearch = function ()
    {
        this.loadDataGrid(
            this.advSearch.find('form').attr('action'), 
            $.b.tools.removeEmptyStrSeria(this.advSearch.find('input[value!=""], select, textarea').serialize()), 
            this.advSearch.find('form').attr('method'),
            true
        );  
    };
    
    /**
     * Submit search
     */
    $.b.app.List.prototype.submitSearch = function ()
    {
        this.advSearch.hide();
        this.loadDataGrid(
            this.grid.find('thead .tr-search').attr('data-action'), 
            $.b.tools.removeEmptyStrSeria(this.grid.find('.tr-search input[value!=""], .tr-search select').serialize()), 
            'GET',
            true
        );  
    };
    
    /**
     * Initializing events of rows
     */
    $.b.app.List.prototype.initRowEvents = function (row)
    {
        this.initQuickEditRowsActionEvent(row);
        this.initCheckRowsActionEvent(row);
        this.initDeleteRowsActionEvent(row);
        this.initEditActionEvent(row);
        this.initTranslateActionEvent(row);
        this.initSelectRowEvent(row);
        this.initExtendRowEvents(row);
    };
    
    /**
     * Quick edit
     * 
     * @param container
     */
    $.b.app.List.prototype.initSelectRowEvent = function (container)
    {
        var self = this;
        container
            .find('td:not(.td-action)')
            .on('click', function (e){
                var tr = $(this).closest('tr');
                var checkRow = tr.children('td:first').find('.check-row');
                var target = $(e.target);

                if ( ! target.is('input, textarea, select') && checkRow.length > 0) {
                    var isChecked = checkRow.is(':checked');
                    if (isChecked) {
                        tr.removeClass('row-selected');
                    } else {
                        tr.addClass('row-selected');
                    }
                    checkRow.prop('checked', ! isChecked);
                }
            })
            .on('dblclick', function (e){
                var target = $(e.target);
                var me = $(this);
                var tr = me.closest('tr');
                var editButton = tr.children('td:first').find('.btn-edit-row');

                if (editButton.length > 0) {
                    var callback = undefined;
                    if (target.is('td')) {
                        var tbody = tr.closest('tbody');
                        var trIndex = tr.index();
                        var tdIndex = me.index();

                        callback = function (){
                            var tr = tbody.children('tr:eq(' + trIndex + ')');
                            var td = tr.children('td:eq(' + tdIndex + ')');
                            var input = td.find(':input:not([type=hidden], [type=checkbox], select, textarea)');
                            if (input.length > 0) {
                                var inputVal = td.find('input').val();
                                input.focus().val('').val(inputVal);
                            }
                        };
                    }

                    self.editRow(
                        tr, 
                        editButton.attr('href'), 
                        '', 
                        'GET',
                        callback
                    );
                }
            });
    };
    
    /**
     * Quick edit
     * 
     * @param container
     */
    $.b.app.List.prototype.initQuickEditRowsActionEvent = function (container)
    {
        var self = this;
        container.find('.btn-edit-row').on('click', function () {
            var me = $(this);
            self.editRow(me.closest('tr'), me.attr('href'));
            return false;
        });
    };
    
    /**
     * Initializing delete actions events
     */
    $.b.app.List.prototype.initDeleteRowsEvents = function ()
    {
        this.initDeleteAllRowsActionEvent();
        this.initDeleteRowsActionEvent(this.grid);
    };
    
    /**
     * Delete rows
     * 
     * @param container jQuery
     */
    $.b.app.List.prototype.initDeleteRowsActionEvent = function (container)
    {
        var self = this;
        
        container.find('.btn-delete-row').on('click', function () {
            var link = $(this);
            var params = $.b.tools.removeEmptyStrSeria(self.grid.find('thead input, thead select, thead textarea').serialize()) + 
                '&' + link.attr('data-name') + '=' + encodeURIComponent(link.attr('data-value'));
            
            var modal = new $.b.app.Modal('modal-delete-row');
            modal.setHeader(self.message.modalRemoveOne);
            modal.setBtnPrimary(self.message.modalBtnConfirm);
            modal.setBtnSecondary(self.message.modalBtnCancel);
            modal.addData('list', self);
            modal.component.find('.btn-secondary, .close').on('click', function () {
                modal.remove();
                return false;
            });
            modal.component.find('.btn-primary').on('click', function () {
                var ajaxRequest = function (async) {
                    $.b.app.ajax(
                        link.attr('href'), 
                        function (json) {
                            if (json.loginReload) {
                                if ($.b.app.loginReload(json)) {
                                    ajaxRequest(false);
                                }
                            } else {
                                modal.datas.list.loadDataGrid(
                                    modal.datas.list.requestSaved.url, 
                                    modal.datas.list.requestSaved.data, 
                                    modal.datas.list.requestSaved.type
                                );
                                if (self.activeAutoScroll) {
                                    $.b.app.scrollTop();
                                }
                            }
                        }, 
                        (params !== '' ? params + '&' : '') + 'partial=1' ,
                        'POST', 
                        'JSON', 
                        async
                    );
                };

                ajaxRequest(true);

                modal.remove();
                return false;
            });
            modal.open();
            return false;
        });
    };
    
    /**
     * Delete all row
     */
    $.b.app.List.prototype.initDeleteAllRowsActionEvent = function ()
    {
        var self = this;

        this.grid.find('.btn-delete-all').on('click', function () {
            var checkBoxSelector = 'tbody tr input[type=checkbox].check-row:checked';
            if ($(checkBoxSelector).length > 0) {
                var link = $(this);
                var params = $.b.tools.removeEmptyStrSeria(self.grid.find('thead input, thead select, thead textarea').serialize()) + 
                    '&' + $.b.tools.removeEmptyStrSeria(self.grid.find(checkBoxSelector).serialize());
                
                var modal = new $.b.app.Modal('modal-delete-all');
                modal.setHeader(self.message.modalRemoveAll);
                modal.setBtnPrimary(self.message.modalBtnConfirm);
                modal.setBtnSecondary(self.message.modalBtnCancel);
                modal.addData('list', self);
                modal.component.find('.btn-secondary, .close').on('click', function (){
                    modal.remove();
                    return false;
                });
                modal.component.find('.btn-primary').on('click', function (){
                    var ajaxRequest = function (async) {
                        $.b.app.ajax(
                            link.attr('href'), 
                            function (json) {
                                if (json.loginReload) {
                                    if ($.b.app.loginReload(json)) {
                                        ajaxRequest(false);
                                    }
                                } else {
                                    modal.datas.list.loadDataGrid(
                                        modal.datas.list.requestSaved.url, 
                                        modal.datas.list.requestSaved.data, 
                                        modal.datas.list.requestSaved.type
                                    );
                                    if (self.activeAutoScroll) {
                                        $.b.app.scrollTop();
                                    }
                                }
                            }, 
                            (params !== '' ? params + '&' : '') + 'partial=1' ,
                            'POST', 
                            'JSON', 
                            async
                        );
                    };
                    ajaxRequest(true);
                    
                    modal.remove();
                    return false;
                });
                modal.open();
            }
            return false;
        });
    };
    
    /**
     * Check/uncheck events
     */
    $.b.app.List.prototype.initCheckRowsEvents = function ()
    {
        this.initCheckRowsActionEvent(this.grid);
        this.initCheckAllRowsActionEvents();
    };
    
    /**
     * Check/uncheck row event
     */
    $.b.app.List.prototype.initCheckRowsActionEvent = function (container)
    {
        container.find('input[type=checkbox].check-row').on('change', function (){
            var me = $(this);
            var tr = me.closest('tr');
            if (me.is(':checked')) {
                tr.addClass('row-selected');
            } else {
                tr.removeClass('row-selected');
            }
        });
    };
    
    /**
     * Check/uncheck all rows event
     */
    $.b.app.List.prototype.initCheckAllRowsActionEvents = function ()
    {
        var self = this;
        
        this.grid.find('.check-all').on('click', function () {
            var input = self.grid.find('input[type=checkbox].check-row');
            input.closest('tr').addClass('row-selected');
            input.prop('checked', true);
            return false;
        });
        
        this.grid.find('.uncheck-all').on('click', function () {
            var input = self.grid.find('input[type=checkbox].check-row');
            input.closest('tr').removeClass('row-selected');
            input.prop('checked', false);
            return false;
        });
    };
})(jQuery);