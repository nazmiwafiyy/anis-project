<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        {{-- Custom Meta Tags --}}
        @yield('meta_tags')
    
        {{-- Title --}}
        <title>
            @yield('title_prefix', config('adminlte.title_prefix', ''))
            @yield('title', config('adminlte.title', 'AdminLTE 3'))
            @yield('title_postfix', config('adminlte.title_postfix', ''))
        </title>

        <!-- Bootstrap CSS -->
        {{-- <link href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}" rel="stylesheet" type="text/css" > --}}
        {{-- <link href="{{ asset('vendor/fontawesome-free/css/fontawesome.min.css') }}" rel="stylesheet" type="text/css" > --}}
        <style>
            body {margin: 20px}
            <?php
                require base_path('public\vendor\adminlte\dist\css\adminlte.css');
            ?>php
        </style>
    </head>
    <body>

        <table class="table table-bordered table-condensed table-striped">
        {{-- <table class="zui-table"> --}}
            @foreach($data as $row)
                @if ($loop->first)
                    <tr>
                        @foreach($row as $key => $value)
                            <th>{!! $key !!}</th>
                        @endforeach
                    </tr>
                @endif
                <tr>
                    @foreach($row as $key => $value)
                        @if(is_string($value) || is_numeric($value))
                            <td>{!! $value !!}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
    </body>
</html>