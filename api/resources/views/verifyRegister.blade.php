<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to the site {{$register['name']}}</h2>
    <br/>
    Your registered email-id is {{$register['email']}} , Please click on the below link to verify your email account
    <br/>
    <a href="{{url('api/register1/verify', $register->validate_email->token)}}">Verify Email</a>
  </body>
</html>