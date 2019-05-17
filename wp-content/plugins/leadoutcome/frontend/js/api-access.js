
//var baseURL = "http://ffl.leadoutcometest.com:8080"
var baseURL = "https://www.mysuccessbyleads.com"
	
function login() {
	
}
function loginOld() {
    var data = { 
      	  apikey:"e444450e-aa9e-1",
  		  email:$('#loginEmail').val(),
  		  password:$('#loginPass').val()
     };
    $.ajax({
  	    type: 'POST',
  	    url: baseURL+ '/app/remote-auto-login',
  	    data: JSON.stringify(data),
  	    success: function(data) { 
  	    	alert('login drupal success'); 
  	    },
  	    failed: function(data) {
  	    	alert('login failed'); 
  	    	}
  	});
   /* var data = {
        	  apikey:"e444450e-aa9e-1",
    		  email:$('#loginEmail').val(),
    		  password:$('#loginPass').val()
       };
      $.ajax({
    	    type: 'POST',
    	    url: baseURL+ '/app/mce/API/authenticate/login',
    	    data: JSON.stringify(data),
    	    success: function(data) { 
    	    	alert('login java success'); 
    	    },
    	    failed: function(data) {
    	    	alert('login failed'); 
    	    	},
    	    contentType: "application/json",
    	    dataType: 'json'
    	});
    	*/
}

function logout() {
    var data = {
     };
    $.ajax({
  	    type: 'POST',
  	    url: baseURL + '/app/remote-auto-logout',
  	    success: function(data) { 
  	    	alert('logout success'); 
  	    },
  	    failed: function(data) {
  	    	alert('login failed'); 
  	    	}
  	});
    var data = {
    };
   $.ajax({
 	    type: 'POST',
 	    url: baseURL + '/app/mce/logout',
 	    success: function(data) { 
 	    	alert('logout success'); 
 	    },
 	    failed: function(data) {
 	    	alert('login failed'); 
 	    	},
 	});
    
}


function createMember() {
    var data = {
    	  apikey:"e444450e-aa9e-1",
    	  first:$('newFirst').val(),
    	  last:$('newLast').val(), 
    	  sponsorId:$('newSponsorId').val(),
    	  email:$('newEmail').val(),
    	  pass:$('newPass').val(),
     };
    $.ajax({
  	    type: 'POST',
  	    url: baseURL + '/app/create-member',
  	    data: JSON.stringify(data),
  	    success: function(data) { 
  	    	alert('login success'); 
  	    },
  	    failed: function(data) {
  	    	alert('login failed'); 
  	    	},
  	    contentType: "application/json",
  	    dataType: 'json'
  	});
}

function updateMember() {
    var data = {
    	  apikey:"e444450e-aa9e-1",
    	  findMemberByEmail:$('#findEmail').val(),
    	  first:$('#updateFirst').val(),
    	  last:$('#updateLast').val(),
    	  email:$('#updateEmail').val(),
    	  pass:$('#updatePass').val(),
    	  
    	  phone:$('#updatePhone').val(),
    	  company:$('#updateCompany').val(),
    	  timezone:$('#updateTimezone').val(),
    	  
    	  street:$('#updateStreet').val(),
    	  pob:$('#updatePob').val(),
    	  city:$('#updateCity').val(),
    	  state:$('#updateState').val(),
    	  zip:$('#updateZip').val(),
    	  country:$('#updateCountry').val()
     };
    console.log("data="+data);
    $.ajax({
  	    type: 'POST',
  	    url: baseURL + '/app/update-member',
  	    data: JSON.stringify(data),
  	    success: function(data) { 
  	    	login();
  	    	alert('login success'); 
  	    },
  	    failed: function(data) {
  	    	alert('login failed'); 
  	    },
  	    contentType: "application/json",
  	    dataType: 'json'
  	});
}


function logout2() {
    var data = {
     };
    $.ajax({
  	    type: 'POST',
  	    url: baseURL + '/app/remote-auto-logout',
  	    data: JSON.stringify(data),
  	    success: function(data) { 
  	    	alert('logout success'); 
  	    },
  	    failed: function(data) {
  	    	alert('login failed'); 
  	    	},
  	    contentType: "application/json",
  	    dataType: 'json'
  	});
    var data = {
    };
   $.ajax({
 	    type: 'POST',
 	    url: baseURL + '/app/mce/logout',
 	    success: function(data) { 
 	    	alert('logout success'); 
 	    },
 	    failed: function(data) {
 	    	alert('login failed'); 
 	    	},
 	});
    
}

