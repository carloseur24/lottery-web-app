<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-800">

    <section class="flex items-center justify-center min-h-screen">
        <artcile class="bg-gray-400 p-10 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-white mb-6">Registro</h2>

            <form action="/register" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="block text-white text-sm font-bold mb-2">Nombre:</label>
                    <input type="text" id="nombre" name="nombre"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label for="cedula_number" class="block text-white text-sm font-bold mb-2">Cédula:</label>
                    <input type="text" id="cedula_number" name="cedula_number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-white text-sm font-bold mb-2">Teléfono:</label>
                    <input type="tel" id="phone_number" name="phone_number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-white text-sm font-bold mb-2">Contraseña:</label>
                    <input type="password" id="password" name="password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-white text-sm font-bold mb-2">Verifica tu
                        Contraseña:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Registrar
                    </button>
                </div>
            </form>
        </artcile>
    </section>

</body>

</html>
