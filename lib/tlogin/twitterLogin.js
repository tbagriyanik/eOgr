// Twitter style login with jQuery and CSS3
// (c) Skyrocket Labs
// http://www.skyrocketlabs.com
// skyrocketlabs@gmail.com
// Created: 02.27.2010
// Last updated: 02.27.2010

$(document).ready(function(){
	// Toggle the login form
	$("#loginButton").click(function() {
		$("#loginForm").toggle();
		$("#loginButton a").toggleClass("active");
		
		if (document.getElementById("userN")!=null && document.getElementById("userN").value=="")  
		   	$("#userN").focus();
		if (document.getElementById("userN")!=null && document.getElementById("userN").value!="")  
			$("#userP").focus();
		
		return false;
	});
});