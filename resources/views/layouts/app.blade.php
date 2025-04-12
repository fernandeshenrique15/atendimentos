<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
    @livewireStyles
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Estilos do menu horizontal */
        .navbar {
            background-color:rgb(0, 0, 0);
            padding: 1rem;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .navbar ul li a:hover {
            background-color: rgb(248 113 113);
        }

        .navbar ul li a.active {
            background-color: rgb(248 113 113);
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <ul>
            <li><a href="{{ url('/user/calendar') }}" class="{{ request()->is('user/calendar') ? 'active' : '' }}">Agenda</a></li>
            <li><a href="{{ url('/user/clients') }}" class="{{ request()->is('user/clients*') ? 'active' : '' }}">Clientes</a></li>
            <li><a href="{{ url('/user/appointments') }}" class="{{ request()->is('user/appointments*') ? 'active' : '' }}">Atendimentos</a></li>
            <li><a href="{{ url('/user/expenses') }}" class="{{ request()->is('user/expenses*') ? 'active' : '' }}">Despesas</a></li>
            <li><a href="{{ url('/user/service-types') }}" class="{{ request()->is('user/service-types*') ? 'active' : '' }}">Tipos de Serviços</a></li>
            <li><a href="{{ url('/user/expense-types') }}" class="{{ request()->is('user/expense-types*') ? 'active' : '' }}">Tipos de Despesas</a></li>
        </ul>
    </nav>
    <div class="container">
        {{ $slot }}
    </div>
    </body>
</html>