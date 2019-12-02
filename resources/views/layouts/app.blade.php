<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <link rel="stylesheet" href="{{asset('css/app.css')}}"> {{-- <- bootstrap css --}}
            <link rel="stylesheet" href="{{asset('css/footer-basic.css')}}">
            <link rel="stylesheet" href="{{asset('css/custom.css')}}">
            <link rel="stylesheet" href="{{asset('css/mikrosoft.css')}}"> {{-- <- bootstrap css --}} <!-- added temp css sheet -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" />

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

            <!-- Font awesome-->
            <script src="https://kit.fontawesome.com/b42a9b5167.js" crossorigin="anonymous"></script>
            <title>@yield('title','Mikrosoft')</title>
        </head>
    <body>
        @include('inc.navbar')
        <main class="container mt-4">
        <div class="">
            @yield('content')
            </div>
        </main>
        @include('inc.footer')
        <script src="{{asset('js/app.js')}}"></script> {{-- <- bootstrap and jquery --}}
        @if(session('status')) {{-- <- If session key exists --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('status')}} {{-- <- Display the session value --}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <script>
        //close the alert after 3 seconds.
        $(document).ready(function(){
                setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });
        </script>
        <style>
        .alert{
            z-index: 99;
            top: 60px;
            right:18px;
            min-width:30%;
            position: fixed;
            animation: slide 0.3s forwards;
        }
        @keyframes slide {
            100% { top: 30px; }
        }
        @media screen and (max-width: 668px) {
            .alert{ /* center the alert on small screens */
                left: 10px;
                right: 10px; 
            }
        }
        .wrapper { 
            height: 100%;
            width: 100%;
            left:0;
            right: 0;
            top: 0;
            bottom: 0;
            position: absolute;
            background: linear-gradient(124deg, #ff2400, #e81d1d, #e8b71d, #e3e81d, #1de840, #1ddde8, #2b1de8, #dd00f3, #dd00f3);
            background-size: 1800% 1800%;

            -webkit-animation: rainbow 18s ease infinite;
            -z-animation: rainbow 18s ease infinite;
            -o-animation: rainbow 18s ease infinite;
            animation: rainbow 18s ease infinite;}

            @-webkit-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @-moz-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @-o-keyframes rainbow {
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
            @keyframes rainbow { 
                0%{background-position:0% 82%}
                50%{background-position:100% 19%}
                100%{background-position:0% 82%}
            }
        </style>
    </body>
</html>
