<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body class="bg-slate-800 w-full h-screen">
    <div id="app" class="w-full h-full">
        <home />
    </div>

</body>
<script>
    window.user = {!! json_encode(Auth::check() ? Auth::user() : null) !!};
    // console.log(window.user);
</script>

</html>
