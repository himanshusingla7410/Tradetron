<!DOCTYPE html>
<html>
<head>
    <title>Chat Escalated</title>
</head>
    <body>
        <h1>Chat Escalated Notification!</h1>
        <p>Dear {{ Auth::user()->name }},</p>
        <p>This following chat has been escalated by you.</p>
        <a href =" {{ $chatLink }} " class="text-blue-500 font-bold hover:underline" target="_blank">View your escalated chat.</a>
        <p>Thank You!</p>
    </body>
</html>