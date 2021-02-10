<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Email</title>
    </head>
    <body>
        <h2>Welcome to Integra QA </h2>
        <p>This is your confirmation code: <a>{{  env('APP_FRONTEND_URL') . "/" . "email_confirmation/?vc=" .  $user->email_verification_token }}</a> </p>
    </body>
</html>