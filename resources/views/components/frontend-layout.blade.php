<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    {{-- @if (Auth::guard('seller')->user()) --}}
     {{-- <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
     <script>
         window.OneSignalDeferred = window.OneSignalDeferred || [];
         window.OneSignalDeferred.push(async function(OneSignal) {
             await OneSignal.init({
                 appId: "a5371de8-a1c2-403d-93f1-09ea984b34ce",
                 notifyButton: {
                     enable: true
                 },
                 serviceWorkerPath: "/OneSignalSDKWorker.js",
             });
         });
     </script> --}}

     {{-- @endif --}}
</head>

<body>

    <x-frontend-header />

    <main>
        {{ $slot }}
    </main>

    <footer>

    </footer>
</body>

</html>
