if(location.hostname == 'localhost'){
	var SERVER_NAME = "http://localhost:8000";
}else{
	var SERVER_NAME = "http://mobigst.mobisofttech.co.in:8989";
}

//Create Object of form data
(function ($) {
	$.fn.serializeFormJSON = function () {
		var o = {};
		var a = this.serializeArray();
		$.each(a, function () {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};
})(jQuery);


function onlyAlphaNumeric(event){
	var regex = new RegExp("^[a-zA-Z0-9]+$");
	var str = String.fromCharCode(!event.charCode ? event.which : event.charCode);
	var key_code = event.keyCode;
	if (regex.test(str)) {
		return true;
	}

	if(key_code == 8 || key_code == 9){
		return true;
	}

	event.preventDefault();
	return false;
}



function onlyNumeric(event){
	if(event.which != 8 && event.keyCode != 9 && isNaN(String.fromCharCode(event.which))){
		event.preventDefault();
	}
}


var token = $.cookie("token");
var userTokenId = $.cookie("tokenId");
var userTokenEmail = $.cookie("tokenEmail");

var d = new Date();
var current_month = d.getMonth()+1;
var current_day = d.getDate();
var current_date = d.getFullYear() + '-' +
(current_month<10 ? '0' : '') + current_month + '-' +
(current_day<10 ? '0' : '') + current_day;


if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
	$("#login_li").show();
	$("#signup_li").show();
	$("#welcome_user_li").hide();
} else {
	$("#login_li").hide();
	$("#signup_li").hide();
	$("#welcome_user_li").show();
}


function logout(){

	var formData =  new FormData();
	formData.append('token',$.cookie('token'));
	formData.append('tokenId',$.cookie('tokenId'));

	$.ajax({
		"async": true,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/logout",
		"method": "POST",
		"headers": {
			"cache-control": "no-cache",
			"postman-token": "5d6d42d9-9cdb-e834-6366-d217b8e77f59"
		},
		"processData": false,
		"contentType": false,
		"mimeType": "multipart/form-data",
		"data": formData,
		"dataType":"JSON",                
		beforeSend:function(){

		},
		success:function(response){
			
			$.removeCookie("token", { path: '/' });
			$.removeCookie("tokenId", { path: '/' });
			$.removeCookie("tokenEmail", { path: '/' });

			$.removeCookie("token");
			$.removeCookie("tokenId");
			$.removeCookie("tokenEmail");

			window.location.href = SERVER_NAME;	
			return false;            
		},
		complete:function(){

		}
	});
}

$(function(){
	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
		$("#login_li").show();
		$("#signup_li").show();
		$("#welcome_user_li").hide();
	}else{
		$("#login_li").hide();
		$("#signup_li").hide();
		$("#welcome_user_li").show();
	}
});


$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})