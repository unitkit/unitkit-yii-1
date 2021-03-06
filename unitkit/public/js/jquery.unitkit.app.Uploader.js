/**
 * @author Kevin Walter <walkev13@gmail.com>
 * @version 1.0
 */
;
(function ($) 
{
	$.unitkit = $.unitkit || {};
	$.unitkit.app = $.unitkit.app || {};

	/**
	 * Uploader component 
	 * 
	 * @param upload jQuery container
	 * @param settings SWFUpload settings
	 * @returns {SWFUpload}
	 */
	$.unitkit.app.Uploader = function (upload, settings)
	{
		this.upload = upload;
		this.button = upload.children('.btn-upload');

		// settings
		var localSettings = (settings) ? settings : new $.unitkit.app.uploaderSettings();
		localSettings.upload_url = this.button.attr('data-action');
		localSettings.file_size_limit = this.button.attr('data-size');
		localSettings.file_post_name = this.button.attr('data-model');
		localSettings.file_types = this.button.attr('data-type');
		localSettings.post_params = { 
			'sess_id': $.unitkit.tools.getSessId(),
			'sess_key': this.button.attr('data-sessKey'),
			'upload': this.button.attr('data-model'),
			'overview': this.button.attr('data-overview'),
			'u_csrf_token': $('meta[name=u_csrf_token]').attr('content')
		};

		localSettings.button_placeholder = upload.children('.upload-file-flash-btn');
		localSettings.custom_settings.progressTarget = upload.children('.upload-file-progress-container');
		localSettings.custom_settings.maxFiles = this.button.attr('data-max') || 1;
		localSettings.custom_settings.dataModel = this.button.attr('data-model');
		localSettings.custom_settings.countFiles = upload.find('.upload-file-progress').length;
		localSettings.custom_settings.upload = upload;
		localSettings.custom_settings.uploader = this;
		
		// create a SWFUpload component
		this.swfUpload = new SWFUpload(localSettings);

		// init button action
		if (this.swfUpload.customSettings.maxFiles > 1 &&
                this.swfUpload.customSettings.countFiles == swfUpload.customSettings.maxFiles) {
			this.button.addClass('disabled');
			$('#' + this.swfUpload.movieName).css('left','-99999px');
		}
	};
	
	/**
	 * Init events
	 */
	$.unitkit.app.Uploader.prototype.initEvents = function ()
	{
		this.initDeleteActionEvent();
	};
	
	/**
	 * Init delete event
	 */
	$.unitkit.app.Uploader.prototype.initDeleteActionEvent = function ()
	{
		var self = this;

		// delete action
        self.upload.find('.remove').on('click', function (){
			var progress = $(this).parents('.upload-file-progress');
			var input = progress.find('.upload-file-input');
			var dataId = input.attr('data-id');

			if (dataId != undefined) {
                self.swfUpload.cancelUpload(dataId);
            }

            self.swfUpload.customSettings.countFiles--;
			
			// style
			if (self.swfUpload.customSettings.maxFiles > 1) {
                self.button.removeClass('disabled');
				$('#' + $this.swfUpload.movieName).css('left','0');
			}

			if ( progress.hasClass('insert')) {
				if (self.swfUpload.customSettings.maxFiles == 1) {
					var tmp = self.swfUpload.customSettings.upload.find('.upload-file-progress.original');
					if ( tmp.length > 0 ) {
						tmp.find('.upload-file-input').attr('disabled', false);
						if ( ! tmp.hasClass('delete')) {
                            tmp.show();
                        }
					}
				}
				progress.remove();
			} else if ( progress.hasClass('original')) {
				var array = input.val().split('?');
				if ( array.length > 0) {
                    input.val(array[0] + '?delete');
                }
				progress.addClass('delete');
				progress.hide();
			}
			
			return false;
		});
	};
	
	/**
	 * Default settings
	 */
	$.unitkit.app.uploaderSettings = function ()
	{ 
	   	this.flash_url =  '/vendor/manual/swfupload/Flash/swfupload.swf';
	   	this.file_types = '*.*';
	   	this.button_image_url = "/vendor/manual/swfupload/images/image.png";
	   	this.button_cursor = SWFUpload.CURSOR.HAND;
	   	this.button_width = '154';
	   	this.button_height = '35';
	   	this.button_text_left_padding = 0;
	   	this.button_text_top_padding = 0;
	   	this.button_window_mode = SWFUpload.WINDOW_MODE.TRANSPARENT;
	   	
	   	this.custom_settings = {
			progressTarget:'',
			dataModel: '',
			countFiles:0,
			maxFiles:1,
			upload:{}
		};
	   	
	   	this.file_queued_handler = function (file) {
			if (this.customSettings.maxFiles == 1)
			{
				this.customSettings.countFiles++;
				this.customSettings.upload.find('.upload-file-progress:not(.original)').remove();
				this.customSettings.upload.find('.upload-file-progress.original').hide();
				var progress = new $.unitkit.app.UploaderFileProgress(file, this);
				progress.addFileQueue();
			}
			else if (this.customSettings.countFiles < this.customSettings.maxFiles)
			{
				this.customSettings.countFiles++;
				var progress = new $.unitkit.app.UploaderFileProgress(file, this);
				progress.addFileQueue();
			}
			else {
                this.cancelUpload(file.id);
            }
		};
		
		this.file_queue_error_handler = function (file, errorCode, message) {};
		
		this.file_dialog_complete_handler = function (numFilesSelected, numFilesQueued) {
			this.startUpload();
		};
		
		this.upload_start_handler = function (file) {
			return true;
		};
		
		this.upload_progress_handler = function (file, bytesLoaded, bytesTotal) {
			var progress = new $.unitkit.app.UploaderFileProgress(file, this);
			progress.setProgress(Math.ceil((bytesLoaded / bytesTotal) * 100));
		};
		
		this.upload_error_handler = function (file, errorCode, message) {
			var progress = new $.unitkit.app.UploaderFileProgress(file, this);
			progress.setError(message);
		};
		
		this.upload_success_handler = function (file, serverData) {
			var progress = new $.unitkit.app.UploaderFileProgress(file, this);
			progress.setComplete(serverData);

			var tmp = this.customSettings.upload.find('.upload-file-progress.original');
			if ( tmp.length > 0) {
                tmp.find('.upload-file-input').attr('disabled', true);
            }
		};
		
		this.upload_complete_handler = function (file) 
		{
			if (this.getStats().files_queued !== 0) {
                this.startUpload();
            }
		};
	}; 
	
	/**
	 * Upload file progress
     *
	 * @param file
	 * @param swfUpload
	 */
	$.unitkit.app.UploaderFileProgress = function (file, swfUpload)
	{
		this.swfUpload = swfUpload;
		this.id = file.id;
		this.progress = $('#' + this.id);
		
		if (this.progress.length === 0) {
			this.progress = this.getTemplate();
			this.swfUpload.customSettings.progressTarget.append(this.progress);
			this.fileNameContainer = this.progress.find('.upload-file-progress-details-file');
			this.fileNameContainer.html(this.reduceFileName(file.name, 12));
			this.fileInfoContainer = this.progress.find('.upload-file-progress-details-info');
			this.progressBarContainer = this.progress.find('.progress');
			this.progressBar = this.progressBarContainer.find('.progress-bar');
		} else {
			this.fileNameContainer = this.progress.find('.upload-file-progress-details-file');
			this.fileInfoContainer = this.progress.find('.upload-file-progress-details-info');
			this.progressBarContainer = this.progress.find('.progress');
			this.progressBar = this.progressBarContainer.find('.progress-bar');
		}
	};
	
	/**
	 * Reduce file name
	 */
	$.unitkit.app.UploaderFileProgress.prototype.reduceFileName = function (fileName, length)
	{
		var parts = fileName.split('.');	
		if (parts[0 /* filename */].length > length) {
            fileName = fileName.substr(0, length - 5) + '(...).' + parts[1];
        }
		return fileName;
	};
	
	/**
	 * Template
	 */
	$.unitkit.app.UploaderFileProgress.prototype.getTemplate = function ()
	{
		return $ (
			'<div class="upload-file-progress insert" id="' + this.id + '">' +
				'<div class="upload-file-progress-details">' +
					'<div class="upload-file-progress-details-action">' +
						'<a href="#" class="remove"><span class="glyphicon glyphicon-trash"></span></a>' +
					'</div> ' +
					'<div class="upload-file-progress-details-file"></div>' +
					'<div class="upload-file-progress-details-info"></div>' +
				'</div>' +
				'<div class="progress">' +
					'<div class="progress-bar" style="width: 0%;">0%</div>' +
				'</div>' +
				'<div class="upload-file-progress-overview"></div>' +
				'<input name="' + this.swfUpload.customSettings.dataModel + '" data-id="' + this.id + '" type="hidden" class="upload-file-input" />' +
			 '</div>'
		);
	};
	
	/**
	 * Add file in queue
	 */
	$.unitkit.app.UploaderFileProgress.prototype.addFileQueue = function ()
	{
		if (this.swfUpload.customSettings.maxFiles > 1 &&
                this.swfUpload.customSettings.countFiles == this.swfUpload.customSettings.maxFiles) {
			this.swfUpload.customSettings.upload.children('.btn-upload').addClass('disabled');
			$('#' + this.swfUpload.movieName).css('left','-99999px');
		}
	};
	
	/**
	 * Set error
	 */
	$.unitkit.app.UploaderFileProgress.prototype.setError = function (error)
	{
		this.fileInfoContainer.html(error);
	};
	
	/**
	 * Set progress
	 */
	$.unitkit.app.UploaderFileProgress.prototype.setProgress = function (percentage)
	{
		this.progressBar.width(percentage + '%').html(percentage + '%');
	};
	
	/**
	 * Set complete
	 */
	$.unitkit.app.UploaderFileProgress.prototype.setComplete = function (json)
	{
		// get data
		var data = jQuery.parseJSON(json);

		// update input
		this.progress.find('.upload-file-input').val(data.key + '?insert');
		this.progress.find('.upload-file-progress-overview').html(data.overview);
		this.fileNameContainer.html(this.reduceFileName(data.name, 40));
		this.swfUpload.customSettings.uploader.initEvents();
		
		// remove progress bar
		var $this = this;
		setTimeout(function (){ 
		}, 500); 
		setTimeout(function (){ $this.progressBarContainer.hide(); }, 1000); 
	};
})(jQuery);