/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function ($) 
{
	$.unitkit = $.unitkit || {};
	$.unitkit.app = $.unitkit.app || {};
	
	/*
	 * Bootstrap issue v2 & v3
	 */
	$.fn.modal.Constructor.prototype.enforceFocus = function () {};
	
	/**
	 * Modal component
	 */
	$.unitkit.app.Modal = function (cssClass, createOption)
	{
		this.datas = {};
		this.component = this.create(createOption);
		this.component.addClass(cssClass);
	};
	
	$.unitkit.app.Modal.currentModal = null;
	
	$.unitkit.app.Modal.prototype.prevModal = null;
	
	/**
	 * Add new data
	 */
	$.unitkit.app.Modal.prototype.addData = function (name, value)
	{
		this.datas[name] = value;
	};
		
	/**
	 * Create html
	 */
	$.unitkit.app.Modal.prototype.create = function (createOption)
	{
		createOption = (createOption != undefined) ? createOption : '';
		$('#unitkit').append(
			'<div class="modal" role="dialog" tabindex="-1" '+ createOption +'>' +
				'<div class="modal-dialog">' +
					'<div class="modal-content">' +
						'<div class="modal-header" style="display:none;">' +
			         		'<h5><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></h5>' +
			         	'</div>' +
			         	'<div class="modal-body" style="display:none;"></div>' +
			         	'<div class="modal-footer" style="display:none;">' +
			         		'<a href="#" class="btn btn-primary" style="display:none;"></a>' +
			         		'<a href="#" class="btn btn-secondary btn-default" style="display:none;"></a>' +			         	
			         	'</div>'+
			         '</div>'+
	         	'</div>'+
			'</div>'
	    );
		return $('#unitkit').children('.modal:last');
	};
	
	/**
	 * Clean values
	 */
	$.unitkit.app.Modal.prototype.clean = function ()
	{
		this.setBtnSecondary('');
		this.setBtnPrimary('');
		this.setBody('');
		this.setHeader('');
	};
	
	/**
	 * Close modal
	 */
	$.unitkit.app.Modal.prototype.close = function (openPrev)
	{
		openPrev = (openPrev === undefined) ? true : false;
		this.component.modal('hide');
		
		if (openPrev) {
			$.unitkit.app.Modal.currentModal = null;
			if (this.prevModal !== null) {
                this.prevModal.open();
            }
		}
	};
	
	/**
	 * Remove modal
	 */
	$.unitkit.app.Modal.prototype.remove = function ()
	{
		this.close();
		this.component.remove();
	};
	
	/**
	 * Open modal
     *
	 * @param option
	 */
	$.unitkit.app.Modal.prototype.open = function (option)
	{
		if ($.unitkit.app.Modal.currentModal !== null) {
			this.prevModal = $.unitkit.app.Modal.currentModal;
			this.prevModal.close(false);
		}
		$.unitkit.app.Modal.currentModal = this;
		
		option = option || {};
		this.component.modal('toggle');
	};
	
	/**
	 * Set value of secondary button
     *
	 * @param value
	 */
	$.unitkit.app.Modal.prototype.setBtnSecondary = function (value)
	{
		var btnSecondary = this.component.find('.btn-secondary');
		if (value != '') {
			btnSecondary.show();
			this.component.find('modal-footer').show();
		} else {
			btnSecondary.hide();
			if (this.component.find('.btn-primary').is(':hidden')) {
                this.component.find('.modal-footer').hide();
            }
		}
		btnSecondary.html(value);			
	};
	
	/**
	 * Set value of primary button
     *
	 * @param value
	 */
	$.unitkit.app.Modal.prototype.setBtnPrimary = function (value)
	{
		var btnPrimary = this.component.find('.btn-primary');
		if (value != '') {
			btnPrimary.show();
			this.component.find('.modal-footer').show();
		} else {
			btnPrimary.hide();
			if (this.component.find('.btn-secondary').is(':hidden')) {
                this.component.find('.modal-footer').hide();
            }
		}
		btnPrimary.html(value);
	};
	
	/**
	 * Set Body
     *
	 * @param value
	 */
	$.unitkit.app.Modal.prototype.setBody = function (value)
	{
		if (value != '') {
            this.component.find('.modal-body').show();
        }
		this.component.find('.modal-body').html(value);
	};
	
	/**
	 * Set title
     *
	 * @param value
	 */
	$.unitkit.app.Modal.prototype.setHeader = function (value)
	{
		if (value != '') {
            this.component.find('.modal-header').show();
        }
		this.component.find('.modal-header h5').html(value);
	};
})(jQuery);