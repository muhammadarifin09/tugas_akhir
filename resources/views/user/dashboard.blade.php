<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>halaman user</h1>
    <a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</body>
</html>