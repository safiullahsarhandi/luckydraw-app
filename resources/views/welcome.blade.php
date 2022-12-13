<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Committee Manager</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <script>
        window.Laravel = <?php
        echo json_encode([
            'base_url' => url('/'),
            'auth'=> auth()->check(),
            'user'=> auth()->user(),
        ])
         ?>;
    </script>
    </head>
    <body class="antialiased">
        <div id="app"></div>

        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
    </body>
</html>
