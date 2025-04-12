<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Agenda</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <div class="container">
            {{ $slot }}
        </div>
    </body>
</html>