<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @yield('title')

        <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('_css/custom.min.css') }}" rel="stylesheet">        
        <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
        <style type="text/css">
            /* scroller */
                /* scroller browser */
                    ::-webkit-scrollbar {
                        width: 5px;
                        height: 5px;
                    }
                /* scroller browser */

                /* Track */
                    ::-webkit-scrollbar-track {
                        -webkit-box-shadow: inset 0 0 5px rgb(215,215,215); 
                        -webkit-border-radius: 10px;
                        border-radius: 10px;
                    }
                /* Track */

                /* Handle */
                    ::-webkit-scrollbar-thumb {
                        -webkit-border-radius: 10px;
                        border-radius: 10px;
                        background: rgb(1,151,88);
                        -webkit-box-shadow: inset 0 0 6px rgb(215,215,215); 
                    }
                    ::-webkit-scrollbar-thumb:window-inactive {
                        background: rgb(215,215,215); 
                    }
                /* Handle */
            /* scroller */
            /* loading page */
                #loading-page{
                    position: fixed;
                    top: 0;
                    z-index: 99999;
                    width: 100vw;
                    height: 100vh;
                    background-color: rgba(112,112,112,.4);
                    transition: all 1.51s;
                }
                #loading-page .dis-table .row .cel{
                    text-align: center;
                    width: 100%;
                    height: 100vh;
                }
            /* loading page */
            .modal{
                z-index: 9999;
            }
            .modal-lg{
                width: 75%;
            }
        </style>
        @yield('css')
    </head>

    <body class="nav-md">

        <div class="container body">
            <div class="main_container">
                <!-- side bar -->
                @include('_layout.content.sidebar')
                <!-- side bar -->

                <!-- top navigation -->
                @include('_layout.content.topbar')
                <!-- top navigation -->

                <!-- main content -->
                <div class="right_col" role="main">
                    <div class="">
                        @yield('content')
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- main content -->

                <footer>
                    <div class="pull-right">
                        Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
            </div>
        </div>


        <div id="loading-page">
            <div class="dis-table">
                <div class="row">
                    <div class="cel">
                        <img src="{{ asset('images/loading_1.gif') }}">
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('_js/custom.min.js') }}"></script>
        <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
        <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>

        <script type="text/javascript">
            $( document ).ready(function() {
                $('#loading-page').hide();
                postData(null,"{{ route('config.menu') }}");
            });

            function postData(data,url) {

              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url: url,
                  type: 'post',
                  dataType: 'json',
                  data: data,
                  beforeSend: function() {
                    $('#loading-page').show();
                  },
                  success: function(data) {
                    responsePostData(data);
                    $('#loading-page').hide();
                  }
              });
            }

            function responsePostData(data) {
                if (typeof(data.append) != "undefined" && data.append.excute == true) { 
                    $(data.append.location).append(data.append.value); 
                }
                if (typeof(data.html) != "undefined" && data.html.excute == true) { 
                    $(data.html.location).html(data.html.value); 
                }
            }
        </script>
        @yield('js')
    </body>
</html>