<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://teamjavahealth.com/will/wp-content/plugins/leadoutcome/frontend/js/api-access.js" type="text/javascript"></script>

<h1>
Test LeadOutcome API
</h1>

<p>
Use this page to verify and test that the API to LeadOutcome is functioning properly.
</p>


<h2>Authenticating</h2>
<p>
First time we access leadoutcome we must authenticate and obtain valid token.
</p>

<table>
<tr>
<td>
<b>1. Test Login API Call</b>
</td>
</tr>
<tr>
<td>
<form action="/will/wp-admin/admin.php?page=lo_admin_test_api" method="post">
Email <input id="loginEmail" type="text" name="email" />
Password <input id="loginPass" type="text" name="pass" />
<input type="hidden" name="login" value="true" /> 

<input type="submit" value="Submit" /></form>
</td>
</tr>

<tr>
<td>
<b>2. Test Logout API Call</b>
</td>
</tr>
<tr>
<td>
<input type="button" onclick="logout();" value="Logout" >
</td>
</tr>


<tr>
<td>
<b>3. Test Create User API Call</b>
</td>
</tr>

<tr> 
<td>
<form action="/dale/wp-admin/admin.php?page=lo_admin_test_api" method="post" name="myForm">
	First <input id="newUser" type="text" name="newFirst" />
	Last <input id="newLast" type="text" name="newLast" />
	SponsorId <input id="newLast" type="text" name="newSponsorId" value="1" />
	<input type="hidden" name="newUser" value="true" />
	<input type="submit" value="Submit" />
</form>

</form></td>
<!-- 
</tr>
<tr>
<td>
<form  onsubmit="return createMember();" method="post" name="myForm">
First <input id="newUser" type="text" name="newFirst" />
Last <input id="newLast" type="text" name="newLast" />
SponsorId <input id="newLast" type="text" name="newSponsorId" value="1" />
</td>
</tr>

 -->
<tr>
<td>
<b>4. Test Update User API Call</b>
</td>
</tr>
<tr>
<td>
<form onsubmit="return updateMember();" method="post" name="myForm">
Update by Email <input id="findEmail" type="text" name="findEmail" />
</td>
</tr>
<tr>
<td>
First <input id="updateFirst" type="text" name="updatefirst" />
Last <input id="updateLast" type="text" name="updatelast" />
Email <input id="updateEmail" type="text" name="updateEmail" />
Pass <input id="updatePass" type="text" name="updatePass" />
</td>
</tr>
<tr>
<td>
Phone <input id="updatePhone" type="text" name="updatePhone" />
Company <input id="updateCompany" type="text" name="updateCompany" />
Country <input id="updateCountry" type="text" name="updateCountry" />
Timezone <input id="updateTimezone" type="text" name="updateTimezone" />
</td>
</tr>
<tr>
<td>
Street <input id="updateStreet" type="text" name="updateStreet" />
POB <input id="updatePob" type="text" name="updatePob" />
City <input id="updateCity" type="text" name="updateCity" />
State <input id="updateState" type="text" name="updateState" />
Zip <input id="updateZip" type="text" name="updateZip" />
Country <input id="updateCountry" type="text" name="updateCountry" />

<input type="submit" value="Submit" />
</form>
</td>
</tr>

</table>

<tr>
<td colspan="2">
<input type="button" onclick="createMember();" value="Create Member" >
<input type="button" onclick="updateMember();" value="Update Member" >
<input type="button" onclick="login();" value="Login" >
</td>
</tr>
</table>

