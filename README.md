# otp-wordpress-plugin-mobile-applications


otp wordpress plugin mobile applications - call otp1 to send sms token to mobile then call otp2 to create user pass in wp then get jwt token with jwt plugin ...


you can install this plugin for otp application with jwt plugin 

step 1: install and configure and test jwt plugin : from here : https://fa.wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
step 2: install this plugin
step 3: buy a service for sms verification from https://kavenegar.com/
step 4: add kavenegar token to plugin setting
step 5: create a channel or group in telegram for logs then create a bot and add your new bot as administrator to channel
step 6: set telegram bot token in settings
step 7: create a new database and import database.sql 
step 8: configure servername dbname dbuser dbpass in plugin settings
step 9: call with your ionic or android app with these templates: 
  call otp1 with : /wp-content/plugins/your-plugin-name/otp1.php?pusheid=asdfadsf&phone=09191231233
  call otp2 with this template : /wp-content/plugins/your-plugin-name/otp2.php?pusheid=asdfadsf&phone=09191231233&code=13212
  this 5 digit is randome number generate 11111 to 99999 and send to client by sms server
  then you recieve username and password in this format : 
  username : user_52a88db3076b5bc00907477020b5ebc9
  password : d12dbd37a4a8bc4327e3faa9bf8a20cf
  then you can use jwt https://fa.wordpress.org/plugins/jwt-authentication-for-wp-rest-api/
  
  token : for get token by username and password
  validate : for jwt in sharedpreferences in android or storage in cordova ionic app
