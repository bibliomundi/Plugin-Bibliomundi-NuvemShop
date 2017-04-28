/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "./";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 54);
/******/ })
/************************************************************************/
/******/ ({

/***/ 43:
/***/ (function(module, exports) {

(function ($) {

	$(document).ready(function () {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('.btn-delete-webhook').click(function (e) {
			e.preventDefault();

			if (confirm("Are you sure you want to delete this item ?") == true) {
				var url = $(this).data("url");
				$.ajax({
					url: url,
					type: 'DELETE',
					beforeSend: function beforeSend() {
						$('#overlay').removeClass('hide');
					},
					success: function success(result) {
						$('#overlay').addClass('hide');
						if (result.redirect_url != '') {
							window.location.href = result.redirect_url;
						}
					},
					error: function error(xhr) {
						// if error occured
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
				success: function success(data) {
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
  				success: function success(data) {
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
})(window.jQuery);

/***/ }),

/***/ 54:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ })

/******/ });