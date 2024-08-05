<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-slate-800">

    <section class="flex items-center justify-center min-h-screen">
        <artcile class="bg-gray-100 p-10 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-2xl font-bold text-slate-700 mb-6">Registro</h2>
            <div id="app" class="w-full h-full">
                <register />
            </div>
        </artcile>
    </section>

</body>
<script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' }
    window.user = {!! json_encode(Auth::check() ? Auth::user() : null) !!};
</script>

</html>
