<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Landing Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.3/socket.io.js"></script>

<body class="bg-slate-800 w-full h-screen">
    <div id="app" class="w-full h-full">
        <home />

    </div>

</body>
<script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' }
    window.user = {!! json_encode(Auth::check() ? Auth::user() : null) !!};
</script>

</html>