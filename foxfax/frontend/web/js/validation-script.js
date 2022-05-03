$path_url = window.location.protocol + "//" + window.location.host + "/";
	 $("#user_login").validate({
        rules: {
            user_email: {
                required: !0,
                email: !0
            },
            user_password: {
                required: !0
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
            $("#loginerrorinfo").html("");
            var e = $("form#user_login");
            $(".loading").html("<img src='" + $path_url + "images/loading5.gif' alt='Loading...' />"), $.ajax({
                type: "post",
                url: e.attr("action"),
                data: $("form#user_login").serialize(),
                success: function(e) {
					var a = e.split("##");
					"frontend" == a[0] || "dashboard" == a[0] ? window.location.replace($path_url + "" + a[1]) : $("#loginerrorinfo").html(a[1]), $(".loading").hide()
                },error: function (req, status, error) {
            alert(error);
         }
            })
      }
    });
	
 $("#forgotpassword").validate({
        rules: {
            username: {
                required: !0,
                email: !0
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
			form.submit();
			return true;
			/*
            var e = $("form#forgotpassword");
            $.ajax({
                type: "post",
                url: e.attr("action"),
                data: e.serialize(),
                success: function(e) {
			 //"login/message" == e ? window.location.replace($path_url + "" + e) :
				$(".error-message").html(e)
				},error: function (req, status, error) {
            alert(error);
         }
            })
        */}
    });	
$("#re_setpassword").validate({
        rules: {
            password: {
                required: !0,
                minlength: 5,
            },
			 r_password: {
                required: !0,
                 minlength: 5,
                equalTo: "#password"
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
			form.submit();
			return true;
		}
    });
	$("#newregister").validate({
        rules: {
            username: {
                required: !0,
				 minlength: 2
            },
		    inputemail: {
                required: !0,
                email: !0
            },
            userpassword: {
                required: !0,
                minlength: 5
            },
			 r_password: {
                required: !0,
                 minlength: 5,
                equalTo: "#userpassword"
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
			
	       var e = $("form#newregister");
		   $.ajax({
                type: "post",
                url: e.attr("action"),
                data: e.serialize(),
                success: function(e) {
				var a = e.split("##");
				if(  a[0]== 'error' )
				{
				$("#errorinfo").html(a[1]);
				}else
				{
				 window.location.replace($path_url + "" + a[1])	
				return false;
				}
                },error: function (req, status, error) {
            alert(error);
         }
            })
	
		}
    });			
	$("#footerregister").validate({
        rules: {
		   username: {
                required: !0,
				 minlength: 2
            },
		    inputemail: {
                required: !0,
                email: !0
            },
            userpassword: {
                required: !0,
                minlength: 5
            },
        },
        errorPlacement: function() {
            return !1
        },
        messages: {
            userpassword: " Enter Password with 5 characters ",
        },
        submitHandler: function() {
	       var e = $("form#footerregister");
		   $.ajax({
                type: "post",
                url: e.attr("action"),
                data: e.serialize(),
                success: function(e) {
				var a = e.split("##");
				if(  a[0]== 'error' )
				{
				$("#fottererrorinfo").html(a[1]);
				}else
				{
				 window.location.replace($path_url + "" + a[1])	
				return false;
				}
                },error: function (req, status, error) {
            alert(error);
         }
            })
	}
    });
	$("#homeregister").validate({
        rules: {
		    inputemail: {
                required: !0,
                email: !0
            },
            userpassword: {
                required: !0,
                minlength: 5
            },
        },
        errorPlacement: function() {
            return !1
        },
        messages: {
            password: " Enter Password with 5 characters ",
        },
        submitHandler: function() {
	       var e = $("form#homeregister");
		   $(".loading").html("<img src='" + $path_url + "images/facebook.gif' alt='Loading...' />");
		   $.ajax({
                type: "post",
                url:e.attr("action"),
                data: e.serialize(),
                success: function(e) {
				var a = e.split("##");
				if(  a[0]== 'error' )
				{
				$("#errorinfo").html(a[1]);
				}else
				{
				window.location.replace($path_url + "" + a[1])	
				return false;
				}
					/*
				$(".loading").html("");
				if( e == 'No' )
				{
				$(".errorinfo").html(""); 
				//alert($("#useremail").val());
		     	$(".user_password").val($("#userpassword").val());
				$(".user_email").val($("#inputemail").val());
				$('#fullsignup').modal({backdrop: 'static'},'show');	
				}else
				{
			    $("#errorinfo").html(e); 
				return false;
				}
				
                */},error: function (req, status, error) {
            alert(error);
         }
            })
	}
    });
	 $("#userregister").validate({
        rules: {
           email: {
                required: !0,
                email: !0
            },
			firstname: {
                required: !0
            },
            lastname: {
                required: !0
            },
           country: {
                required: !0
            },
			timezone: {
                required: !0
            },
			 company: {
                required: !0
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
			form.submit();
			return true;	/*
          $(".regloading").html("<img src='" + $path_url + "frontend-imgs/facebook.gif' alt='Loading...' />");
            var e = $("form#userregister");
            $.ajax({
                type: "post",
                url: e.attr("action"),
                data: e.serialize(),
                success: function(e) {
				      var a = e.split("##");
                    "dashboard" == a[0] ? window.location.replace($path_url + "" + a[1]) : $(".error-message").html(a[0]), $(".regloading").hide()
                },error: function (req, status, error) {
            alert(error);
         }
            })
        */}
    });
$("#contactus").validate({
        rules: {
            name: {
                required: !0
            },
            email: {
                required: !0,
                email: !0
            },
            subject: {
                required: !0
            },
            mobile: {
                required: !0,
                number: !0,
                minlength: 10
            },
            message: {
                required: !0
            }
        },
        errorPlacement: function() {
            return !1
        },
        submitHandler: function() {
			$("#cont-error-message").hide();
            $(".loading").html("<img src='" + $path_url + "images/loading.gif' alt='Loading...' />");
            var e = $("form#contactus");
         /* $.ajax({
                type: "post",
                url: e.attr("action"),
                data: e.serialize(),
                success: function(e) {
				      var a = e.split("##");
                    "dashboard" == a[0] ? window.location.replace($path_url + "" + a[1]) : $(".error-message").html(a[0]), $(".regloading").hide()
                },error: function (req, status, error) {
            alert(error);
         }
            }) */
        }
		
    });	



	