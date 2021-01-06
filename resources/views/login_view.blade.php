<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ env('APP_NAME') }}</title>
        <link rel="icon" href="{{ asset('app/images/icons/favicon_icn.png') }}" type="image/png"/>
        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/app/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/app/css/dataTables.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/app/css/custom.css') }}">
    </head>
    <body class="login__body">
        <header class="app_header login___header">
            <nav class="navbar navbar-dark navbar-expand-lg">
                <div class="navbar-brand">
                    <a href="/project/shopify/BasicSetup/dashboard" class="">Logo Here</a> 
                </div>
            </nav>
        </header>
        <section class="login_page">
            <div class="login__outer">
                <div class="login_block">
                    <div class="card__panel">
                        <h3 class="h3_title">{{ env('APP_NAME') }}</h3>
                        <p>
                        Insert your domain below to Add and Install the {{ env('APP_NAME') }} App to your Shopify store.<br>
                        Start your free trial now and utilise all amazing features to attract your customers.
                        </p>
                        @if(Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ url('auth/install') }}" method="GET">
                            <div class="form-group text-left">
                                <label>Store Domain</label>
                                <input
                                type="text"
                                class="form-control"
                                placeholder="Please enter your URL"
                                name="shop"
                                />
                            </div>
                            <div class="login__btn">
                                <button type="submit" class="primary_btn">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="pawered_by text-center">
                        <p>Powered by <a href="https://hubifyapps.com/">Hubify apps</a></p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="app_footer">
            <p><a href="{{ url('privacy-policy') }}">Privacy Policy</a> | © {{ date("Y") }} {{ env('APP_NAME') }}, All rights reserved
            </p>
        </footer>
    </body>
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/app/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/app/js/grids.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/app/js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/app/js/custom.js') }}"></script>
</html>    