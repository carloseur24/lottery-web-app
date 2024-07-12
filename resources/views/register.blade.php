<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Registro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-800">

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-400 p-10 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-white mb-6">Registro</h2>

            <form action="" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nombre" class="block text-white text-sm font-bold mb-2">Nombre:</label>
                    <input type="text" id="nombre" name="nombre"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label for="cedula" class="block text-white text-sm font-bold mb-2">Cédula:</label>
                    <input type="text" id="cedula" name="cedula"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-white text-sm font-bold mb-2">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-6">
                    <label for="contraseña" class="block text-white text-sm font-bold mb-2">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña"
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
        </div>
    </div>

</body>

</html>
