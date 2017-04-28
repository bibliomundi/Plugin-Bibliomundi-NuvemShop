(function($){
	
	$(document).ready(function(){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$('.btn-delete-webhook').click(function(e) {
			e.preventDefault();

			if (confirm("Are you sure you want to delete this item ?") == true) {
				var url = $(this).data("url");
				$.ajax({
					url: url,
					type: 'DELETE',
					beforeSend: function () {
				        $('#overlay').removeClass('hide');
				    },
					success: function(result) {
						$('#overlay').addClass('hide');
						if(result.redirect_url != ''){
							window.location.href = result.redirect_url;
						}
					},
				    error: function (xhr) { // if error occured
				        $('#overlay').addClass('hide');
				        alert(xhr.statusText + xhr.responseText);
				    }

				});
			}
		});		

		function importProccess(url) {
			$.ajax({
				url: url,
				dataType: 'json',
				beforeSend: function beforeSend() {
					$('#overlay').removeClass('hide');					
				},
				success: function (data) {
					window.setTimeout(function() { $('#overlay').addClass('hide'); }, 3000);
					try {
						var realData = JSON.parse(data);
						if (typeof realData.code != 'undefined') {
							var strAlert = "The process of importing was interrupted cause of NuvemShop APIs 's errors. Here is the response detail: \n";
							strAlert += "\tcode: " + realData.code + "\n";
							strAlert += "\tmessage: " + realData.message + "\n";
							strAlert += "\tdescription: " + realData.description;
							alert(strAlert);
						}
					} catch (e) {
						// alert(data.result);
					}
				},
				error: function error(xhr) {
					// if error occured
					$('#overlay').addClass('hide');
					alert('An eror occured! Please re-authenticate and try again! If this popup re-appear, contact to the administrator.');
					console.log(xhr.statusText, xhr.responseText);
				}
			});
		}

		function pollingImportStatus() {
			$.ajax({
				url: 'intergrate/getprocess',
				dataType: 'json',
  				success: function (data) {
					switch(data.status) {
						case 'progress':
							window.setTimeout(function() { pollingImportStatus(); }, 1000);
							break;
						default:
							break;
					}
					if (data.current) $('#process').html(data.current + '/' + data.total);
				}				
			});
		}

		$('.btn-sync').click(function (e) {

			e.preventDefault();
			
			importProccess($(this).data("url"));					
			window.setTimeout(function() {
				pollingImportStatus();
			}, 1000);
		});

		$('.ckeditor').ckeditor();
	});

})(window.jQuery)