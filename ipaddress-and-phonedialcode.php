	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>

$.get("https://ipinfo.io", function (response) {
    $("#ip").html("IP: " + response.ip);
    $("#address").html("Location: " + response.city + ", " + response.region);
    $("#details").html(JSON.stringify(response, null, 4));
   
    document.getElementById('input_1_10').value = response.country;
	document.getElementById('input_1_11').value = response.region;
	document.getElementById('input_1_13').value = response.timezone;
	
	 
}, "jsonp");
  
  /***********************for dial code******************/
  
  <html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>International Telephone Input With Flags and Dial Codes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var code = "+91123456789"; // Assigning value from model.
            $('#txtPhone').val(code);
            $('#txtPhone').intlTelInput({
                autoHideDialCode: true,
                autoPlaceholder: "ON",
                dropdownContainer: document.body,
                formatOnDisplay: true,
                hiddenInput: "full_number",
                initialCountry: "auto",
                nationalMode: true,
                placeholderNumberType: "MOBILE",
                preferredCountries: ['US'],
                separateDialCode: true
            });
            $('#btnSubmit').on('click', function () {
                var code = $("#txtPhone").intlTelInput("getSelectedCountryData").dialCode;
                var phoneNumber = $('#txtPhone').val();
                var name = $("#txtPhone").intlTelInput("getSelectedCountryData").name;
                alert('Country Code : ' + code + '\nPhone Number : ' + phoneNumber + '\nCountry Name : ' + name);
            });
        });
    </script>
</head>
<body>
    <input type="tel" id="txtPhone" />
    <input type="button" id="btnSubmit" value="Get Dial Details" />
</body>
</html>
