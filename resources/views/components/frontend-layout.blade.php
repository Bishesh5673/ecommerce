<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('frontend/style.css')}}">
</head>
<body>

    <x-frontend-header/>

    <main>
        {{$slot}}
    </main>

    <footer>

    </footer>
</body>
</html>
