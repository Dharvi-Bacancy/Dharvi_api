<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to the site {{$register['name']}}</h2>
    <br/>
    Your registered email-id is {{$register['email']}} , Please click on the below link to change your password
    <br/>
    <a href="{{url('api/forgot_password', $register->validate_email->token)}}">Click here to change Password</a>
  </body>
</html>