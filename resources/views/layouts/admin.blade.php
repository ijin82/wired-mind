<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(!empty($pageTitle)){{ $pageTitle }} - @endif
        {{ config('app.name', 'noname') }} | {{ __('Admin') }}
    </title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.min.js" defer></script>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- highlight.js -->
    <link rel="stylesheet"
          href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono&display=swap" rel="stylesheet">

</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'wm4') }} | {{ __('Admin') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    @include('partials/right-navbar')
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container mb-3">
                <div class="col-sm-12">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <?php
                            $activeUsers = $activePosts = $activeComments = '';

                            if (empty($admActive)) {
                                $admActive = 'users';
                            }

                            switch($admActive) {
                                case 'users':
                                    $activeUsers = 'active';
                                break;

                                case 'posts':
                                    $activePosts = 'active';
                                break;

                                case 'comments':
                                    $activeComments = 'active';
                                break;
                            }
                        ?>
                        <a class="flex-sm-fill text-sm-center nav-link {{ $activeUsers }}"
                           href="{{ route('a.users') }}">Users</a>
                        <a class="flex-sm-fill text-sm-center nav-link {{ $activePosts }}"
                           href="{{ route('a.posts') }}" aria-disabled="true">Posts</a>
                        <a class="flex-sm-fill text-sm-center nav-link {{ $activeComments }}"
                           href="{{ route('a.comments') }}">Comments</a>
                    </nav>
                </div>
            </div>

            @yield('content')
        </main>

        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                {{ __('Want this blog? Checkout that') }}&nbsp;
                <a href="https://github.com/ijin82/wired-mind" target="_blank">{{ __('here') }}</a>
            </div>
        </div>

    </div>

    <script>
        // common
        $(document).ready(function () {

        });

        // highlight.js
        hljs.configure({useBR: false});
        document.querySelectorAll('pre.code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    </script>

    <!-- counters -->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter24153016 = new Ya.Metrika({id:24153016,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/24153016" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- google -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-3932107-4', 'wired-mind.info');
        ga('send', 'pageview');

    </script>
    <!-- /google-->

    <!-- /counters -->

</body>
</html>
