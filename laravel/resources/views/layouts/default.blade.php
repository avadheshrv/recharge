<!doctype html>
<html>
<head>
	<title>@yield('title')</title>
    @include('layouts.head')
</head>
<body>
 <div id="wrapper">

   <header class="row">
        @include('layouts.header')
    </header>

    <div id="main" class="row">

            @yield('content')

    </div>

</div>
</body>
</html>