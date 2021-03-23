<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body style="background-color:#4c2c68;">
    <center><form style="margin-top:200px" method="POST" action="{{url('api/forgot_password1', $user->id)}}">
         <h1>{{ $user->name }}</h1>
         @csrf
         @method('PUT')
         <label for="password">New Password: </label>
         <input type="password" id="new_password" name="new_password" ><br>

         <label for="password">Confirm Password: </label>
         <input type="password" id="confirm_password" name="confirm_password" ><br>

         <input type="submit" value="Submit">
    </form>
    </center>
</body>
</html>