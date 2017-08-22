$(function(){

	if (typeof $.cookie('token') === 'undefined' && typeof $.cookie('tokenId') === 'undefined'){
        window.location.href = SERVER_NAME;  
    }

   $(".logOut").click(function(){

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
	            //console.log(response);
                //alert($.cookie('tokenEmail'));
                $.removeCookie("token", { path: '/' });
                $.removeCookie("tokenId", { path: '/' });
                $.removeCookie("tokenEmail", { path: '/' });
                $.removeCookie("tokenRole", { path: '/' });
                $.removeCookie("tokenBranch", { path: '/' });

                $.removeCookie("token");
                $.removeCookie("tokenId");
                $.removeCookie("tokenEmail");
                $.removeCookie("tokenRole");
                $.removeCookie("tokenBranch");

                window.location.href = SERVER_NAME;	
                return false;            
            },
            complete:function(){

            }
        });
   });

});

/*function loggedInUser(){
	var formData =  new FormData();
	formData.append('token',$.cookie('token'));
	formData.append('tokenId',$.cookie('tokenId'));
	console.log(formData);
	return false;

	$.ajax({
		"async": false,
		"crossDomain": true,
		"url": SERVER_NAME+"/api/loggedInUser",
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
            console.log(response);
            return false;
            if(response.status == 200){

            	if($.cookie("tokenRole") == 3){
            		alert("You are not authorised to access this panel. Only Super Admin or Admin are allowed.");
            		window.location.href = SERVER_NAME+"/abiAdmin/";
            		return false;
            	}

            	$("#abiUserTitle").html($.cookie('tokenEmail'));
                //alert($.cookie("tokenRole"));
                if($.cookie("tokenRole") == 1)
                {
                	$(".adminControl").show();
                }else{
                	$(".adminControl").hide();
                }
                //alert($.cookie('tokenId'));
                $("#admin_id").val($.cookie('tokenId')); 
                $("#added_by_pack").val($.cookie('tokenId'));                
                $("#added_by_renew").val($.cookie('tokenId')); 
                $("#added_by_update").val($.cookie('tokenId')); 
            }else{
            	$.removeCookie("token", { path: '/' });
            	$.removeCookie("tokenId", { path: '/' });
            	$.removeCookie("tokenEmail", { path: '/' });
            	$.removeCookie("tokenRole", { path: '/' });
            	$.removeCookie("tokenBranch", { path: '/' });

            	$.removeCookie("token");
            	$.removeCookie("tokenId");
            	$.removeCookie("tokenEmail");
            	$.removeCookie("tokenRole");
            	$.removeCookie("tokenBranch");

            	window.location.href = SERVER_NAME+"/abiAdmin/";
            	return false;
            }

        },
        complete:function(){

        }
    }); 
}*/