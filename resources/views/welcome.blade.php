<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Admin Panel</title>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <!-- FONT AWESOME -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
            {{-- <link rel= "icon" type= "image/x-icon" href= "/favicon.ico"> --}}
            <!-- Bootstrpa css -->
            <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.css')}}">

             <link rel="stylesheet" type="text/css" href="https://unpkg.com/view-design/dist/styles/iview.css">
            <!-- Common css -->
            <link rel="stylesheet" href="{{ asset('/assets/css/common.css')}}">
            <!-- Main css -->
            <link rel="stylesheet" href="{{ asset('/assets/css/main2.css')}}">
            <!-- Main css -->
            <link rel="stylesheet" href="{{ asset('/assets/css/main.css')}}">
            <!-- Responsive -->
            <link rel="stylesheet" href="{{ asset('/assets/css/responsive.css')}}">
            <!-- Form -->
            <link rel="stylesheet" href="{{ asset('/assets/css/form.css')}}">
            <!--Vue default css-->
            <link rel="stylesheet" href="{{ asset('css/app.css') }}" />


        </head>

    <body>

        <div id="app">
            {{-- <header-section></header-section> --}}
            <main-content></main-content>
        </div>

        <script>
			(function() {
				window.Laravel = {
					csrfToken: '{{ csrf_token() }}'
				};
				@if(Auth::check())
				window.authUser = {!! Auth::user() !!}
				@else
				window.authUser = false
				@endif
			})();
		</script>
        <script src="{{mix('/js/app.js')}}"></script>
    </body>

</html>
