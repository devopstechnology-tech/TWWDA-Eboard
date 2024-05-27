<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">

    <title>nexus: testing 2</title>

    
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png?v=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png?v=1">
    <link rel="manifest" href="/favicon/site.webmanifest?v=1">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg?v=1" color="#ff6a3d">
    <link rel="shortcut icon" href="/favicon/favicon.ico?v=1">
    <meta name="msapplication-TileColor" content="#ff6a3d">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml?v=1">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/v4/css/vendor.css">
    <link rel="stylesheet" href="/v4/css/theme.css">
    <link rel="stylesheet" href="/v4/css/app.css?id=14bb870ccf15296039f7919b2e49cfb8">

    <script src="https://kit.fontawesome.com/fb951c71e8.js" crossorigin="anonymous"></script>

    
    <script>
        window.dataLayer = window.dataLayer || [];
            </script>
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});
        var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
        j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K4LVGKX');
    </script>

    <script src="//d2wy8f7a9ursnm.cloudfront.net/v7/bugsnag.min.js"></script>
    <script>window.Bugsnag || document.write('<script src="/vendor/bs/bs.min.js">\x3C/script>')</script>

<script>
    try {
        if (typeof Bugsnag === 'undefined') {
            Bugsnag = {
                notify: (ex, ev) => {
                    console.log('bsless', ex, ev);
                }
            };
            window.notify = (exception, data = []) => {
                console.log('bsless.', exception, data);
            }
        } else {
            Bugsnag.start({
                apiKey: 'dd68ee99c1644ba323ef4ad5e4429d0d',
                releaseStage: 'production',
                onError: event => {
                                            event.setUser('323280')
                                    }
            });

            window.notify = (exception, data = []) => {
                Bugsnag.notify(exception, function(event) {
                    Object.keys(data).forEach(k => event.addMetadata(k, data[k]));
                });
            }
        }
    } catch(bs_error) {
        console.error('bs_error', bs_error);
    }

    window.simulateError = () => {
        const test = nothing / 0;
    }
</script>
    <script>
        window.heap = window.heap || [], heap.load = function(e, t) {
            window.heap.appid = e, window.heap.config = t = t || {};
            var r = document.createElement("script");
            r.type = "text/javascript", r.async = !0, r.src = "https://cdn.heapanalytics.com/js/heap-" + e + ".js";
            var a = document.getElementsByTagName("script")[0];
            a.parentNode.insertBefore(r, a);
            for (var n = function(e) {
                    return function() {
                        heap.push([e].concat(Array.prototype.slice.call(arguments, 0)))
                    }
                }, p = ["addEventProperties", "addUserProperties", "clearEventProperties", "identify", "resetIdentity", "removeEventProperty",
                    "setEventProperties", "track", "unsetEventProperty"
                ], o = 0; o < p.length; o++) heap[p[o]] = n(p[o])
        };
        heap.load("1360233978");

            </script>
    <script>
            (function(doc) {
                const elem = doc.createElement('script');
                elem.setAttribute('data-account', 'GZJuZ01E8f');
                elem.setAttribute('src', 'https://cdn.userway.org/widget.js');
                (doc.body || doc.head).appendChild(elem);
            })(document);
        </script>
        <script src="https://global.localizecdn.com/localize.473.js" integrity="sha384-2XLQ1tkUx6Un64em/D5ZJVxKpe4RQlamLlq8O34A9uJyBCvXPu+IVpvbuXY9kvKy" crossorigin="anonymous"></script>
    <script>
        ! function(a) {
            if (!a.Localize) {
                a.Localize = {};
                const e = [
                    "translate",
                    "untranslate",
                    "phrase",
                    "initialize",
                    "translatePage",
                    "setLanguage",
                    "getLanguage",
                    "getSourceLanguage",
                    "detectLanguage",
                    "getAvailableLanguages",
                    "untranslatePage",
                    "bootstrap",
                    "prefetch",
                    "on",
                    "off",
                    "hideWidget",
                    "showWidget"
                ];
                for (let t = 0; t < e.length; t++) {
                    a.Localize[e[t]] = function() {}
                }
            }
        }(window);
    </script>

    <script>
        Localize.initialize({
            key: '31e348373840b',
            rememberLanguage: true
        });
    </script>
    <script>
        window.intercomSettings = {"app_id":"jby5aft8","hide_default_launcher":true,"custom_launcher_selector":".intercom-trigger","id":323280,"email":"engfelixnyachio@gmail.com","name":"Nyariki Felix","numOrgs":3,"domain":"US","role":"owner","lastVisit":"2024-05-21 12:04:51","lastActivity":{"date":"2024-05-21 12:04:52","timezone":"UTC"},"company":{"id":36907,"name":"nexus","url":"https:\/\/app.boardable.com\/nexus-3\/","slug":"nexus-3","pql_score":0,"num_users":1,"num_users_in_mobile_app":0,"upcoming_meetings":0,"published_meetings":0,"unpublished_meetings":0,"csm":"","rep":"","plan":"","manage_url":"https:\/\/manage.boardable.com\/organizations\/36907","plg_demo_meeting":"https:\/\/app.boardable.com\/nexus-3\/meetings\/04de73-test-board-meeting","BApp_subscription_view":"per_user_pricing"}};
    </script>

    <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/jby5aft8';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>

        
</head>

<body id="" class="production bg-gray-100 font-sans text-black flex flex-col flex-1 min-h-screen h-screen">

    <script>
        function gtmPush() {
                    }
        addEventListener("load", gtmPush);
    </script>
    <noscript>
        <iframe
            src="https://www.googletagmanager.com/ns.html?id=GTM-K4LVGKX"
            height="0"
            width="0"
            style="display:none;visibility:hidden"
        ></iframe>
    </noscript>
    <span id="accessibilityWidget" aria-label="accessibility" hidden></span>
    <noscript>
        Please ensure Javascript is enabled for accessibility application access
    </noscript>



    
    <nav aria-label="Main" class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light">
    <div class="container-fluid w-full">

        
        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarCollapse"
            aria-controls="sidebarCollapse"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        
                    <a class="flex items-center text-center relative md:my-8 md:block" href="https://app.boardable.com/nexus-3/">
                                    <span class="company-name text-wrap">nexus</span>
                            </a>
        
        
        <div class="navbar-user md:hidden">

            <div id="mobile-topbar-apps" class="flex items-center">
                                    <broadcast-message-widget
                        class="mr-3"
                        v-if="true"
                        :enabled="0"
                        icon-class="btn-sm"
                        upgrade-url="https://app.boardable.com/nexus-3/subscription/plans"></broadcast-message-widget>
                            </div>

            <div class="dropdown h-10">
                <a href="#" id="mobileUserToggle" class="dropdown-toggle avatar avatar-sm"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                        <img src="https://app.boardable.com/img/default_user.svg" class="avatar-img rounded-full"
                            alt="profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-end right-0 !mt-2" aria-labelledby="mobileUserToggle">
                    <a href="https://app.boardable.com/nexus-3/user-settings" class="dropdown-item">User Settings</a>

    <a href="#" class="dropdown-item" id="accessibilityWidget">Accessibility</a>


<hr class="dropdown-divider" />

<a href="/accounts" class="dropdown-item">Switch Organizations</a>

<button data-bs-toggle="modal" data-bs-target="#create-org" class="dropdown-item">Create A New Organization</button>

<a href="#" class="dropdown-item" onclick="document.getElementById('logout').submit()">Logout</a>
                </div>
            </div>
        </div>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidebarCollapse">

        
                    <div class="alert alert-warning !p-3">
                
                <p class="text-center">Your trial ends in  <strong>12 days.</strong></p>

                <a href="https://app.boardable.com/nexus-3/subscription/plans" class="btn btn-orange block">Upgrade Now</a>
            </div>
        
        <form action="https://app.boardable.com/nexus-3/search" method="get" class="mb-4 md:hidden" id="sidebar-search">
            <div class="input-group input-group-merge input-group-reverse input-group-sm">
                <!-- Input -->
                <input id="search-org"
                       type="search"
                       class="form-control shadow-none !rounded-r-full !pl-2"
                       name="q"
                       placeholder="Search"
                       aria-label="Search"
                />
                <div class="input-group-text !rounded-l-full">
                    <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#magnifying-glass"></use>
</svg>
                </div>
            </div>
        </form>

        
            
            <ul class="navbar-nav">
            
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-home" href="https://app.boardable.com/nexus-3/">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#house"></use>
</svg>
                        
                                                Home
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-documents" href="https://app.boardable.com/nexus-3/documents">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#file-lines"></use>
</svg>
                        
                                                Documents
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link active sb-meetings" href="https://app.boardable.com/nexus-3/meetings">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#calendar-check"></use>
</svg>
                        
                                                Meetings
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-groups" href="https://app.boardable.com/nexus-3/groups">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#user-group"></use>
</svg>
                        
                                                Groups
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-discussions" href="https://app.boardable.com/nexus-3/discussions">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#messages"></use>
</svg>
                        
                                                Discussions
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-polls" href="https://app.boardable.com/nexus-3/polls">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#square-poll-horizontal"></use>
</svg>
                        
                                                Polls
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-tasks" href="https://app.boardable.com/nexus-3/tasks">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#list-check"></use>
</svg>
                        
                                                Tasks
                    </a>
                            </li>
                    
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-goals" href="https://app.boardable.com/nexus-3/goals">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#flag"></use>
</svg>
                        
                                                Goals
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 sb-people" href="https://app.boardable.com/nexus-3/people">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#book"></use>
</svg>
                        
                                                People
                    </a>
                            </li>
            </ul>

                            <hr class="navbar-divider my-3" />
                                <ul class="navbar-nav">
            
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 " href="https://app.boardable.com/nexus-3/notifications-history">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#bell"></use>
</svg>
                        
                                                Notifications History
                    </a>
                            </li>
            </ul>
            
                            <hr class="navbar-divider my-3">
                <p class="text-caps mx-2 mb-2">Admin</p>
                <ul class="navbar-nav">
            
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 " href="https://app.boardable.com/nexus-3/reports">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#chart-mixed"></use>
</svg>
                        
                                                Reports
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 " href="https://app.boardable.com/nexus-3/settings">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#gear"></use>
</svg>
                        
                                                Settings
                    </a>
                            </li>
                    
                    <li class="navbar-item">
                                    <a id="" class="nav-link hover:!text-gray-700 " href="https://app.boardable.com/nexus-3/subscription">
                                                <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#credit-card-front"></use>
</svg>
                        
                                                Subscription
                    </a>
                            </li>
            </ul>
            
            
            <div class="mt-auto"></div>

            <ul class="navbar-nav">
            
                    <li class="navbar-item">
                                    <a class="nav-link" href="#sb-0" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="#sb-0">
                                                    <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#headset"></use>
</svg>
                            
                                                Support
                    </a>

                                        <div id="sb-0" class="collapse ">
                        <ul class="nav flex-col">
                                                                                                                            <li class="nav-item">
                                    <a class="nav-link !pl-6  intercom-trigger" href="#" >
                                                                                    <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#messages-question"></use>
</svg>
                                            
                                                                                Contact Support
                                    </a>
                                </li>
                                                                                                                                                            <li class="nav-item">
                                    <a class="nav-link !pl-6  " href="https://docs.boardable.com/en" target='_blank'>
                                                                                    <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#screen-users"></use>
</svg>
                                            
                                                                                Help Center
                                    </a>
                                </li>
                                                                                                                                                            <li class="nav-item">
                                    <a class="nav-link !pl-6  " href="https://boardable.com/customer-experience/boardable-academy/" target='_blank'>
                                                                                    <svg aria-hidden="true" class="fill-current fa-icon mr-2">
    <use xlink:href="/v4/icons/fa-sprite.svg#chalkboard-user"></use>
</svg>
                                            
                                                                                Boardable Academy
                                    </a>
                                </li>
                                                                                    </ul>
                    </div>
                            </li>
            </ul>

            
                            <div class="mb-4 mt-4">
                    <v-button variant="secondary"
                            class="w-full"
                            icon="user-plus"
                            data-bs-toggle="modal"
                            data-bs-target="#invite-people">
                        Add Users
                    </v-button>
                </div>
                                    </div>
            </div>
</nav>


    <div id="main" role="main" class="main-content flex flex-col flex-1 bg-white">

        <nav class="navbar-expand-md hidden md:relative md:flex md:py-3" id="topbar">
    <div class="container-fluid md:flex md:items-center md:justify-between">

        <form action="https://app.boardable.com/nexus-3/search" method="get" class="form-inline mr-4 hidden md:flex" id="topbar-search">
            <div class="input-group input-group-merge input-group-reverse">
                <!-- Input -->
                <input id="search-org"
                       type="search"
                       class="form-control shadow-none !rounded-r-full !pl-2"
                       name="q"
                       placeholder="Search"
                       aria-label="Search"
                />
                <div class="input-group-text !rounded-l-full">
                    <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#magnifying-glass"></use>
</svg>
                </div>
            </div>
        </form>

        <!-- User -->
        <div class="navbar-user">

            <!--HubSpot Call-to-Action Code -->
    <div class="hs-cta-wrapper mr-2" id="hs-cta-wrapper-af68ef9e-c658-4224-aa34-37c1ca1e0433">
        <span class="hs-cta-node hs-cta-af68ef9e-c658-4224-aa34-37c1ca1e0433" id="hs-cta-af68ef9e-c658-4224-aa34-37c1ca1e0433">
            <a href="https://cta-redirect.hubspot.com/cta/redirect/4073229/af68ef9e-c658-4224-aa34-37c1ca1e0433">
            </a>
        </span>
    </div>
    <!-- end HubSpot Call-to-Action Code -->

    

            <div id="topbar-apps" class="flex items-center space-x-2 mr-2">
                                    <broadcast-message-widget
                        v-if="true"
                        :enabled="0"
                        upgrade-url="https://app.boardable.com/nexus-3/subscription/plans"></broadcast-message-widget>
                    <notifications-app></notifications-app>
                            </div>

            <!-- Dropdown -->
            <div class="dropdown">
                <!-- Toggle -->
                <a href="#" class="avatar avatar-sm dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                    <img src="https://app.boardable.com/img/default_user.svg"
                        class="avatar-img rounded-full"
                        id="topbar-avatar"
                        alt="profile image">
                </a>

                <!-- Menu -->
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="https://app.boardable.com/nexus-3/user-settings" class="dropdown-item">User Settings</a>

    <a href="#" class="dropdown-item" id="accessibilityWidget">Accessibility</a>


<hr class="dropdown-divider" />

<a href="/accounts" class="dropdown-item">Switch Organizations</a>

<button data-bs-toggle="modal" data-bs-target="#create-org" class="dropdown-item">Create A New Organization</button>

<a href="#" class="dropdown-item" onclick="document.getElementById('logout').submit()">Logout</a>
                    <form action="/logout" method="POST" id="logout" style="display:none"><input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1"></form>
                </div>

            </div>

        </div>

    </div>
</nav>


        
                    <div class="container-fluid">
                    <div class="py-6">

    <div class="flex items-center">

        <div class="hidden lg:inline-flex p-3 mr-4 bg-gray-200 rounded-lg">
            <div class="calendar-icon w-10 h-10 flex flex-col items-center justify-center mt-1 ">
    <div class="month">May</div>
    <div class="day font-medium">
                    <span>15</span>
            </div>
</div>
        </div>

        <div class="">
            <p class="header-pretitle text-xs mb-1">
                <span>Wednesday, May 15</span>
                            </p>

            <div class="flex items-center space-x-4">
                <h1 class="header-title leading-10">testing 2</h1>
                <button class="!hidden lg:!flex text-muted btn btn-icon"
                    data-bs-toggle="tooltip"
                    title="Copy meeting link"
                    data-copy-btn
                    data-copy-text="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2"
                    aria-label="Copy meeting link">
                    <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-link"></use>
</svg>
                </button>
            </div>

        </div>

        <div class="ml-auto flex self-end">

                            <div class="dropdown" id="meeting-more">

    <button class="btn btn-icon text-muted dropdown-ellipses dropdown-toggle mx-2" id="meeting-more-trigger"
        data-bs-toggle="dropdown"
        data-bs-target="#meeting-more-dropdown"
        aria-label="More actions"
        aria-expanded="false"
        aria-haspopup="true">
       <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-ellipsis-vertical"></use>
</svg>
    </button>

    <ul class="dropdown-menu dropdown-menu-end z-[1046]" aria-labelledby="meeting-more-trigger" id="meeting-more-dropdown">

        
        
                            <li class="lg:hidden">
                    <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/edit" class="dropdown-item" aria-label="Edit meeting">Edit meeting</a>
                </li>

                <li class="lg:hidden">
                    <button data-bs-target="#send-message" data-bs-toggle="modal" class="dropdown-item">
    Email attendees
</button>


                </li>
            
                        <li class="lg:hidden">
                <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#take-minutes">
    Minutes
</button>


            </li>
            
        
        
                    <li>
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#resend-meeting-invites" data-meeting-id="364953">Re-send meeting invite</button>
                            </li>

        
        
                    <li>
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#send-meeting-summary" data-meeting-id="364953">Send meeting summary</button>
            </li>
                    
        

        
        
        
        


        
                    <li>
                <a class="dropdown-item" href="https://app.boardable.com/nexus-3/meetings/follow-up/new?follows=5fb1df-testing-2">Create Follow Up Meeting</a>
            </li>
        
                <hr class="dropdown-divider">
        <li>
                            <a data-bs-toggle="modal" href="#delete-meeting" data-meeting-id="364953" data-published-level="2" class="dropdown-item text-red hover:text-red hover:bg-red-soft"> <i class="fa-regular fa-trash-can mr-2"></i>Delete Meeting</a>

    
                    </li>
            </ul>
</div>

                
                <div class="hidden lg:flex mr-2">
                                            <button data-bs-target="#send-message" data-bs-toggle="modal" class="btn btn-icon text-muted" data-bs-tooltip aria-label="Email attendees">
    <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#envelope"></use>
</svg>
</button>



                                                    <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/edit" class="btn btn-icon text-muted mx-2" data-bs-toggle="tooltip" title="Edit meeting" aria-label="Edit meeting">
                                <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#pen-to-square"></use>
</svg>
                            </a>
                                            
                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#take-minutes">
    Minutes
</button>


                </div>
            
                            <div id="rsvp-status">
            <meeting-rsvp
            
            meeting-slug="5fb1df-testing-2"
            btn-size=""
            :user-id="323280"
            
            :status='{"meeting_id":364953,"user_id":323280,"rsvp":"maybe","rsvp_note":"","attendance":"","collaborator":0,"automated_attendance":"","automated_attendance_override":1,"left_meeting":0}'
            :disable-remote-rsvp="0" />
    </div>

                    </div>
    </div>

    
        <ul class="nav nav-tabs nav-overflow header-tabs" id="meeting-tabs">
            
        <li class="nav-item">
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2"
               class="nav-link flex items-center whitespace-nowrap active"
               
            >
                Meeting Details

                        </a>
    </li>
        
        <li class="nav-item">
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/agenda/edit"
               class="nav-link flex items-center whitespace-nowrap "
               
            >
                Agenda

                        </a>
    </li>
        
        <li class="nav-item">
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/documents"
               class="nav-link flex items-center whitespace-nowrap "
               
            >
                Documents

                        </a>
    </li>
        
        <li class="nav-item">
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/tasks-polls"
               class="nav-link flex items-center whitespace-nowrap "
               
            >
                Tasks & Polls

                        </a>
    </li>
        
        <li class="nav-item">
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/public"
               class="nav-link flex items-center whitespace-nowrap "
               
            >
                Public Page

                        </a>
    </li>
</ul>

</div>
            </div>
        
        <div id="page-content" class="page-content flex-1 flex relative pl-6 pb-10 bg-gray-100 border-t border-gray-300 pt-8">
            
    <div class="mx-auto w-full max-w-5xl">
    <div id="notifications-and-card">
        
        
        
        
        
        <div class="card">

            <div class="card-header flex items-center">

                            <h2 class="card-header-title h3">Details</h2>
            
            
            

                            <div class="ml-auto flex items-center space-x-2">
                    <div class="dropdown" id="calendar-select">
    <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="add-to-calendar-dropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        Add to calendar
    </button>
    <ul class="dropdown-menu" aria-labelledby="add-to-calendar-dropdown">
        <li>
            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&amp;dates=20240515T043000Z/20240515T053000Z&amp;text=testing+2&amp;details=https%3A%2F%2Fapp.boardable.com%2Fnexus-3%2Fmeetings%2F5fb1df-testing-2" target="_blank" class="dropdown-item">
                <i class="fa-brands fa-google mr-2" aria-hidden="true"></i> Google
            </a>
        </li>
        <li>
            <a href="https://calendar.yahoo.com/?v=60&amp;view=d&amp;type=20&amp;title=testing+2&amp;st=20240515T073000Z&amp;dur=0100&amp;desc=https%3A%2F%2Fapp.boardable.com%2Fnexus-3%2Fmeetings%2F5fb1df-testing-2" target="_blank" class="dropdown-item">
                <i class="fa-brands fa-yahoo mr-2" aria-hidden="true"></i> Yahoo
            </a>
        </li>
        <li>
            <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/ical" target="_blank" class="dropdown-item">
                <i class="fa-brands fa-windows mr-2" aria-hidden="true"></i> Outlook
            </a>
        </li>
        <li>
            <a href="data:text/calendar;charset=utf8;base64,QkVHSU46VkNBTEVOREFSDQpWRVJTSU9OOjIuMA0KQkVHSU46VkVWRU5UDQpVSUQ6NDYyMTViOGVhYzBmNThhMDk3Nzk1ZmI5MjAwZjk5YzINClNVTU1BUlk6dGVzdGluZyAyDQpEVFNUQVJUO1RaSUQ9QWZyaWNhL05haXJvYmk6MjAyNDA1MTVUMDczMDAwDQpEVEVORDtUWklEPUFmcmljYS9OYWlyb2JpOjIwMjQwNTE1VDA4MzAwMA0KREVTQ1JJUFRJT046aHR0cHM6Ly9hcHAuYm9hcmRhYmxlLmNvbS9uZXh1cy0zL21lZXRpbmdzLzVmYjFkZi10ZXN0aW5nLTINCkVORDpWRVZFTlQNCkVORDpWQ0FMRU5EQVI=" target="_blank" class="dropdown-item">
                <i class="fa-brands fa-apple mr-2" aria-hidden="true"></i> Apple Calendar
            </a>
        </li>
    </ul>
</div>
                </div>
            
                    </div>
    
            <div class="card-body">
            <div class="space-y-6">
            <div class=" flex items-start">

            <div class="mr-4 w-6 text-muted">
            <i class="fa-regular fa-calendar-day h-6 w-6" aria-hidden="true"></i>
        </div>
    
            <div class="">

            <div class="h3 mb-0">
    <p class="m-0">Wednesday, May 15 2024</p>

    
    <p class="m-0">
        7:30am - 8:30am
        EAT
    </p>
</div>

                    </div>
    </div>
            
            <div class="flex items-center">
            <div class="w-6 mr-4 text-center text-muted">
                <i class="fa-light h-6 w-6 fa-location-dot mx-auto" aria-hidden="true"></i>
            </div>
            <p class="m-0">testing 2</p>
        </div>
        
    <div class="flex items-center">
                    <p class="m-0 text-sm">You are the meeting owner.</p>
            </div>

    </div>

                                                <hr class="my-5" />
                    <div class="user-content">
                        <p>testing 2</p>
                    </div>
        </div>
    
    </div>
        </div>

        
            <div id="members">
    <div class="card">

            <div class="card-header flex items-center">

                            <h2 class="card-header-title h3">People</h2>
            
            
            

                            <div class="ml-auto flex items-center space-x-2">
                    <a href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/edit?page=members" class="btn btn-secondary btn-sm w-icon">
                    <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#user"></use>
</svg>
 Update Members
                </a>
                </div>
            
                    </div>
    
            <div class="table-responsive overflow-visible">
            <table class="table card-table table-stacked">
            <thead>
                <tr>
                    <th scope="col">
                        <button class="btn btn-link btn-sm list-sort asc" data-sort="user-name">Name</button>
                    </th>

                                            <th scope="col">
                            <button class="btn btn-link btn-sm list-sort px-0" data-sort="role">Role</button>
                            <a  href="https://docs.boardable.com/en/articles/5368693-meeting-roles-and-permissions"
                                target="_blank"
                                aria-label="Learn more about the collaborator role">
                                <i class="fa-regular fa-arrow-up-right-from-square"></i>
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <button class="btn btn-link btn-sm list-sort asc" data-sort="invited">Invited</button>
                        </th>
                    
                    <th scope="col" class="text-center">
                        <button class="btn btn-link btn-sm list-sort" data-sort="rsvp">RSVP</button>
                    </th>

                                            <th scope="col" class="text-center">
                            <button class="btn btn-link btn-sm list-sort" data-sort="attendance">Attendance</button>
                        </th>
                                    </tr>
            </thead>

            <tbody class="list" id="member-table">
                                    <tr data-id="323280" class="member">
                        <td class="user-name" data-name="Felix Nyariki">
                            <span class="cell-label">Name</span>
                            <div class="flex items-center">

                                <div class="avatar avatar-sm mr-3 flex-shrink-0">
                                    <img src="https://app.boardable.com/img/default_user.svg" class="avatar-img rounded-full"
                                        alt="Nyariki Felix profile picture">
                                </div>

                                <div>
                                    <div class="flex items-center space-x-2">
                                                                            <p class="mb-0"><a href="#"
    class="person-card"
    tabindex="0"
    role="button"
    data-profile_url="https://app.boardable.com/nexus-3/people/nyariki-felix"
    data-name="Nyariki Felix"
    data-pronoun=""
    data-img="https://app.boardable.com/img/default_user.svg"
    data-board_role="Administrative Staff"
    data-company=""
    data-ptitle=""
    data-contact_email=""
    data-contact_phone=""
    data-pronoun=""
    aria-label="Nyariki Felix profile">
    Nyariki Felix
</a>
</p>
                                    
                                                                            
                                        
                                                                                                                                                        </div>
                                    <p class="text-muted text-sm mb-0">Administrative Staff</p>
                                </div>
                            </div>
                        </td>
                                                    
                            <td class="role" data-role="meetingOwner">
                                <span class="cell-label">Collaborator</span>
                                                                    <span class="text-sm">Meeting Owner</span>
                                                            </td>

                            <td class="invited lg:text-center">
                                <span class="cell-label">Invited</span>
                                                                                                    <span class="text-muted" data-bs-toggle="tooltip" title="User was invited by email">
                                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#envelope"></use>
</svg>
                                    </span>
                                                            </td>
                        
                        <td class="rsvp" data-rsvp="maybe" ref="rsvp-323280">
                            <span class="cell-label">RSVP</span>
                            <div class="flex items-center space-x-2 justify-center">
                                                                    <meeting-rsvp
                                        meeting-slug="5fb1df-testing-2"
                                        :user-id="323280"
                                        :status='{"meeting_id":364953,"user_id":323280,"rsvp":"maybe","rsvp_note":"","attendance":"","collaborator":0,"automated_attendance":"","automated_attendance_override":1,"left_meeting":0}'
                                        @rsvp-updated="updatedRSVP($event)"
                                        :disable-remote-rsvp="0">
                                    </meeting-rsvp>
                                
                                                            </div>
                        </td>

                        
                        
                                                    <td class="attendance" data-attendance="">
                                <span class="cell-label">Attendance</span>
                                                                    <button
                                        class="btn btn-icon lg:mx-auto attendance-select"
                                        data-id="323280"
                                        data-status=""
                                        aria-label="Mark Nyariki Felix as present"
                                        aria-live="polite"
                                        @click="setAttendance($event)">
                                                                                    <svg aria-hidden="true" class="fill-current h-5 w-5 text-muted">
    <use xlink:href="/v4/icons/fa-sprite.svg#circle-check"></use>
</svg>
                                                                            </button>
                                                            </td>
                        
                    </tr>
                            </tbody>
        </table>
        </div>
    
    </div>
    </div>
</div>
            
    
    <div id="page-spacer" class="flex-none"></div>
    <div id="page-sb" class="top-0 bottom-0 ml-6 -my-8 right-0 border-l border-gray-300 bg-white px-2 py-4">
        <button class="btn btn-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#page-offcanvas" aria-controls="page-offcanvas">
            <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#message-lines"></use>
</svg>
            <span class="sr-only">View Comments</span>
        </button>
    </div>

    <div id="meeting-sidebar-app">
        <div id="page-offcanvas" class="offcanvas offcanvas-end border border-l-gray-300" tabindex="-1" aria-labelledby="page-offcanvas-label" data-bs-scroll="true" data-bs-backdrop="false">

            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="page-offcanvas-label">Comments</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="bg-white offcanvas-body !p-0">
                <comments-widget commentable_type="meeting" commentable_id="364953" display="column" ref="comments_widget"></comments-widget>
            </div>
        </div>
        <portal-target name="modals" multiple></portal-target>
    </div>
            </div>
    </div>


        <div aria-labelledby="send-message-title" aria-hidden="true" tabindex="-1" class="modal fade" id="send-message">
    <div class="modal-dialog modal-lg ">
        <form class="modal-content" ref="sendMessageForm" action="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/send-message" id="send-message-form" method="POST" @submit.prevent="submit">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="send-message-title">Email Attendees</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">
            <fieldset>
                <legend class="form-label text-base">Send to</legend>
                <notifications-list
                    ref="notificationsList"
                    model-type="meeting"
                    :model-id="364953"
                    :default-groups="['everyone','guests']"
                    :notify-error="errorMessage"
                    @users-selected="form.notify = $event"
                    @guests-selected="form.notify_guests = $event"
                    :reload-on-close="true">
                </notifications-list>
            </fieldset>

            <div class="form-group ">
    <label class="form-label" for="subject">
        Email subject
            </label>

    
    
        
        <input type="text" inputmode="text" id="subject" :class="{&#039;is-invalid&#039; : form.errors.has(&#039;subject&#039;)}" class="form-control !placeholder-gray-600 rounded-end" name="subject" v-model="form.subject"  />

        
                
        <div v-if="form.errors.has('subject')" class="invalid-feedback block" v-html="form.errors.getAll('subject').join(', ')"></div>
        
    
</div>

            <div class="form-group mt-3">
    <label class="form-label" for="send-message-editor">
        Message
            </label>

    
    <textarea id="send-message-editor" :class="{&#039;is-invalid&#039; : form.errors.has(&#039;message&#039;)}" class="form-control" name="message" placeholder="Type your message" v-model="form.message" ref="editor" v-wysiwyg>form.message</textarea>

        <div v-if="form.errors.has('message')" class="invalid-feedback block" v-html="form.errors.getAll('message').join(', ')"></div>
    </div>

            <div class="flex flex-col">
            <checkbox v-model="form.include_meeting_info" label="Include meeting info" description="This will include the time, date, and location of your meeting."></checkbox>

                        </div>
            </div>

                        <div class="modal-footer">
                                    <v-button variant="secondary" data-bs-dismiss="modal">Cancel</v-button>
            <v-button variant="primary" :loading="submitting" @click.prevent="submit">Send</v-button>
                            </div>
                    </form>
    </div>
</div>
    <div aria-labelledby="take-minutes-title" aria-hidden="true" tabindex="-1" class="modal fade" id="take-minutes">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="take-minutes-title">Take Minutes</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <h3 class="text-center text-base font-thin">How would you like to start?</h4>
        <div class="flex justify-center space-x-4 py-6">
            <a class="btn btn-secondary h-auto !p-0 p-0 mb-0 card flex-1" href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/minutes/edit?template=blank">
    <img class="object-cover card-img-top max-h-14" src="/img/bg_abstract-blue.png"/>
    <div class="text-center card-body">
        <div class="flex items-center justify-center mx-auto mb-1 -mt-12 bg-white rounded-full shadow w-11 h-11">
            <i class="fa-regular fa-list"></i>
        </div>
        <h4 class='mb-0 text-gray-900'>Start From Scratch</h4>
    </div>
</a>            <a class="btn btn-secondary h-auto !p-0 p-0 mb-0 card flex-1" href="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/minutes/edit?template=agenda">
    <img class="object-cover card-img-top max-h-14" src="/img/bg_abstract-orange.png"/>
    <div class="text-center card-body">
        <div class="flex items-center justify-center mx-auto mb-1 -mt-12 bg-white rounded-full shadow w-11 h-11">
            <i class="fa-regular fa-file"></i>
        </div>
        <h4 class='mb-0 text-gray-900'>Start From the Agenda</h4>
    </div>
</a>        </div>
            </div>

                    </div>
    </div>
</div>
    <div aria-labelledby="delete-meeting-title" aria-hidden="true" tabindex="-1" class="modal fade" id="delete-meeting">
    <div class="modal-dialog modal-lg ">
        <form class="modal-content" action="#" id="delete-meeting-form" method="post">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="delete-meeting-title">Delete Meeting</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">
            <p>This will remove all polls, tasks, attachments, documents, agendas, and minutes.</p>

            <span v-if="publishedLevel > 0">
                    <div class="form-group mt-3">
    <label class="form-label" for="send-message-editor">
        Message
            </label>

    
    <textarea id="send-message-editor" :class="{&#039;is-invalid&#039; : form.errors.has(&#039;message&#039;)}" class="form-control" name="message" placeholder="Type your message" v-model="form.message" ref="editor" >form.message</textarea>

        <div v-if="form.errors.has('message')" class="invalid-feedback block" v-html="form.errors.getAll('message').join(', ')"></div>
    </div>
            </span>

            <notification variant="info" text="Note: All meeting attendees will receive an email notification.">
            </notification>
            
            <div class="form-group form-check hidden">

    <input type="checkbox" id="notify" class="form-check-input" name="notify" checked="checked" v-model="form.notify">

    <label class="form-check-label" for="notify">Notify meeting members that it has been canceled</label>

    
    
</div>
            </div>

                        <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger" @click.prevent="deleteMeeting">Delete Meeting</button>
                            </div>
                    </form>
    </div>
</div>
                                            
                    
                                                            <div aria-labelledby="resend-meeting-invites-title" aria-hidden="true" tabindex="-1" class="modal fade" id="resend-meeting-invites">
    <div class="modal-dialog modal-lg ">
        <form class="modal-content" action="https://app.boardable.com/nexus-3/meeting-messages/resend-meeting-invites-v2" method="post" id="resend-meeting-invites-form" @submit.prevent="submitForm">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="resend-meeting-invites-title">Re-send Meeting Invites</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">
        <notification variant="info" text="Note: All meeting attendees will receive an email invitation."></notification>

        <div class="form-group hidden">
            <legend class="form-label text-base">Send to</legend>
            
            <notifications-list
                ref="notificationsList"
                :default-groups="['everyone','guests']"
                :model-id="form.id"
                model-type="meeting"
                @users-selected="form.notify = $event"
                @guests-selected="form.notify_guests = $event"
            ></notifications-list>
        </div>
            </div>

                        <div class="modal-footer">
                                    <v-button variant="secondary" data-bs-dismiss="modal">Cancel</v-button>
        <v-button variant="primary" :loading="submitting" @click.prevent="submitForm">Send</v-button>
                            </div>
                    </form>
    </div>
</div>

                                                    <div aria-labelledby="send-meeting-summary-title" aria-hidden="true" tabindex="-1" class="modal fade" id="send-meeting-summary">
    <div class="modal-dialog modal-lg ">
        <form class="modal-content" action="https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/send-summary" id="send-summary-form" method="POST" @submit.prevent="submitForm">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="send-meeting-summary-title">Send Meeting Summary</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">
        <a href="#" class="btn btn-primary btn-action btn-sm float-right" @click.prevent='openPreview'>Open</a>

        <fieldset>
            <legend class="form-label text-base">Send to</legend>
            <notifications-list
                ref="notificationsList"
                :default-groups="['everyone']"
                :model-id="form.id"
                model-type="meeting"
                @users-selected="form.notify = $event"
                @guests-selected="form.notify_guests = $event"
            ></notifications-list>
            <input type="hidden" name="to" v-model="form.notify">
        </fieldset>


        <fieldset class="mb-4">
            <legend class="form-label text-base">Customize Summary</legend>
            <div class="form-group form-check mb-1">

    <input type="checkbox" class="form-check-input" v-model="form.summary.cover">

    <label class="form-check-label" for="">Cover Page</label>

    
    
</div>
            <div class="form-group form-check mb-1">

    <input type="checkbox" class="form-check-input" v-model="form.summary.attendance">

    <label class="form-check-label" for="">Attendance</label>

    
    
</div>

                        
                    </fieldset>


        <input-text name="subject" label="Email Subject" v-model="form.subject" :form="form"></input-text>
        <input-textarea name="message" v-model="form.message" :form="form"></input-textarea>
            </div>

                        <div class="modal-footer">
                                    <div class="space-x-2">
    
            <v-button variant="secondary" data-bs-dismiss="modal">Cancel</v-button>
    
    <button class="btn btn-primary" type="submit" :disabled="form.busy">

        <div v-if="form.busy" class="spinner-border spinner-border-sm" role="status">
            <span class="sr-only">Saving...</span>
        </div>
        <span v-if="!form.busy">Send</span>

        
    </button>

</div>
                            </div>
                    </form>
    </div>
</div>

            			<form action="https://app.boardable.com/sign-up/organization" method="POST" id="organization-form">
		<div aria-labelledby="create-org-title" aria-hidden="true" tabindex="-1" class="modal fade" id="create-org">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="create-org-title">Add Organization</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <input type="hidden" name="_token" value="tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1">                <div class="form-group required" id="signup-org-name">
            <label class="form-label">Organization Name</label>
            <input type="text" name="organization_name" class="form-control" placeholder="E.g. Girls Inc.">
        </div>
                            <div class="form-group required" id="current_role">
                <div class="form-group choices-max-height">
    <label class="form-label" for="current_role">
        Current Role
            </label>
            <span data-toggle="tooltip" title=" Please indicate your role on the board by selecting one of the options from the list below"><i class="fa-regular fa-circle-question" aria-hidden="true"></i></span>
        
            <select id="current_role" class="form-select" name="current_role" data-display-error="true" data-choices>
                            <option value="" selected>Not Selected</option>
                            <option value="administration_staff" >Administrative Staff</option>
                            <option value="board_chair" >Board Chair</option>
                            <option value="board_member" >Board Member</option>
                            <option value="executive_director" >Executive Director</option>
                            <option value="advisor" >Advisor/Consultant</option>
                            <option value="support_staff" >Support Staff</option>
                            <option value="other" >Other</option>
                    </select>
            </div>
            </div>
                    <div class="form-group required" id="organization_category">
                <div class="form-group choices-max-height">
    <label class="form-label" for="organization_category">
        Organization Category
            </label>
            <span data-toggle="tooltip" title=" Please indicate your organization category by selecting one of the options from the list below"><i class="fa-regular fa-circle-question" aria-hidden="true"></i></span>
        
            <select id="organization_category" class="form-select" name="organization_category" data-display-error="true" data-choices>
                            <option value="" selected>Not Selected</option>
                            <option value="charitable_organization" >Charitable Organization</option>
                            <option value="federated_charity" >Federated Charity</option>
                            <option value="member_organization" >Association/Member Organization</option>
                            <option value="for_profit" >For Profit Company</option>
                            <option value="government_agency" >Government Agency</option>
                            <option value="educational_institution" >Educational Institution</option>
                            <option value="religious_organization" >Religious Organization</option>
                            <option value="other" >Other</option>
                    </select>
            </div>
            </div>
                    <div class="form-group required" id="expected_number_of_users">
                <div class="form-group choices-max-height">
    <label class="form-label" for="expected_number_of_users">
        Board Size
            </label>
            <span data-toggle="tooltip" title=" Select the number of people expected to use the platform"><i class="fa-regular fa-circle-question" aria-hidden="true"></i></span>
        
            <select id="expected_number_of_users" class="form-select" name="expected_number_of_users" data-display-error="true" data-choices>
                            <option value="" selected>Not Selected</option>
                            <option value="1" >1-9</option>
                            <option value="10" >10-19</option>
                            <option value="20" >20-49</option>
                            <option value="50" >50+</option>
                    </select>
            </div>
            </div>
                <div class="form-group choices-max-height">
    <label class="form-label" for="default_timezone">
        Default Timezone
            </label>
            <span data-toggle="tooltip" title="New users will be set in this timezone by default."><i class="fa-regular fa-circle-question" aria-hidden="true"></i></span>
        
            <select id="default_timezone" class="form-select" name="default_timezone" local_timezone="true" data-choices>
                            <optgroup label="United States">
            <option value="America/New_York" >Eastern</option>
            <option value="America/Chicago" >Central</option>
            <option value="America/Denver" >Mountain</option>
            <option value="America/Los_Angeles" >Pacific</option>
            <option value="Pacific/Honolulu" >Hawaii</option>
            <option value="America/Juneau" >Alaska</option>
            <option value="America/Phoenix" >Arizona</option>
    </optgroup>

                    </select>
            </div>
        <div class="form-group">
            <div class="checkbox">
                <label class="user-content">
                    <input type="checkbox" name="agreements" class="mr-1 w-4 h-4 form-check-input bg-white border-2 border-solid border-gray-600 !rounded-sm focus:shadow-none">
                    I agree to the <a href="https://vault.pactsafe.io/s/c4e3e423-eab8-4b66-9b14-85c0888d2db5/y3szqlgkf.html#template-zmm2-olis" target="_blank" style="text-decoration:none">End User Terms of Use</a> and acknowledge the <a href="https://vault.pactsafe.io/s/c4e3e423-eab8-4b66-9b14-85c0888d2db5/y3szqlgkf.html#template-s4lbxejdt" target="_blank" style="text-decoration:none">Privacy Policy</a>.
                </label>
            </div>
            <div class="form-group required" id="signup-rate-limit">
                <input type="hidden" name="rate_limit" class="form-control">
            </div>
        </div>
            </div>

                        <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Get Started</button>
                            </div>
                    </div>
    </div>
</div>
	</form>
    <div aria-labelledby="invite-people-title" aria-hidden="true" tabindex="-1" class="modal fade" id="invite-people">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">

                            <div class="modal-header">
                    <h2 class="modal-title h3 mb-0" id="invite-people-title">Add Users</h2>
                    <button type="button" class="btn btn-icon absolute right-2.5 top-2.5" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" class="fill-current fa-icon">
    <use xlink:href="/v4/icons/fa-sprite.svg#solid-xmark"></use>
</svg>
                    </button>
                </div>
            
            <div class="modal-body">
                <div class="flex flex-col justify-center items-center h-100 flex-grow-1" v-if="loading">
    <div class="spinner-border  text-gray-500" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

        <div v-show="!loading && !invite && !invite_success">
            <div class="fs-5 mb-3">
                {{ org.num_users }} user{{ org.num_users === 1 ? '' : 's' }} in your organization
                <span v-if="org.subscribed">
                    (max users: {{ org.max_users }})
                </span>
            </div>
            <div class="form-group" v-show="!showFileUploader">
                <label for="email" class="form-label">Add Emails <span class="text-red">*</span> </label>
                <div class="mb-2">
                    <input type="text" class="form-control" ref="emails_input" />
                </div>
                <notification class="mt-2" variant="error" v-if="(hasError && !file) || empty" :text="hasErrorText"></notification>
            </div>
            <div class="form-group">
                <button class="btn btn-secondary btn-sm" v-text="importButtonText" @click.prevent="showFileUploader = !showFileUploader"></button>
                <div v-show="showFileUploader" v-cloak class="mt-3">
                    <label for="file" class="form-label w-full flex justify-between">
                        CSV/Excel file to import
                        <div class="fs-5 float-end"><a href="/templates/user_upload_template.csv">Click here to download
                                template</a></div>
                    </label>
                    <input id="file" type="file" class="form-control" name="file" ref="file" v-on:change="handleFileUpload()">
                    <notification class="mt-2" variant="error" v-if="(hasError && file) || empty" :text="hasErrorText"></notification>
                    <div class="mt-3">
                        <small>Please include a header row and use the column names shown in the image below</small>
                        <img src="/img/example_spreadsheet.png" class="example-spreadsheet" style="max-width: 400px;">
                    </div>
                </div>

                <hr class="mt-3 mb-3" />

                <fieldset class="mb-5">

    <legend class="form-label font-medium text-base">Assign Account Role</legend>

                    <div class="form-check-inline mb-2">
            <div class="flex flex-col">
                <div class="flex items-baseline">
                    <radio id="role_0" value="member" checked="checked" class="form-check-input" type="radio" name="role" v-model="form.role" label="Member"  ></radio>
                     <i data-bs-toggle="tooltip" data-bs-placement="top" class="w-4 h-4 fa-regular fa-circle-info ml-1" title="Members can create meetings, polls, discussions, upload documents and view all activity to groups that they are a member of."></i>
                </div>
            </div>
        </div>
                    <div class="form-check-inline mb-2">
            <div class="flex flex-col">
                <div class="flex items-baseline">
                    <radio id="role_1" value="observer" class="form-check-input" type="radio" name="role" v-model="form.role" label="Observer"  ></radio>
                     <i data-bs-toggle="tooltip" data-bs-placement="top" class="w-4 h-4 fa-regular fa-circle-info ml-1" title="Observers can participate in groups, discussions, polls and meetings that they are invited to."></i>
                </div>
            </div>
        </div>
                    <div class="form-check-inline mb-2">
            <div class="flex flex-col">
                <div class="flex items-baseline">
                    <radio id="role_2" value="admin" class="form-check-input" type="radio" name="role" v-model="form.role" label="Admin"  ></radio>
                     <i data-bs-toggle="tooltip" data-bs-placement="top" class="w-4 h-4 fa-regular fa-circle-info ml-1" title="Admins have all privileges including billing information, ability to change plan type, adding people, account settings and updating announcements."></i>
                </div>
            </div>
        </div>
                    </fieldset>

                <hr class="mt-3 mb-3">

                <fieldset>
                    <legend class="form-label font-medium text-base">Assign to Groups</legend>
                    <div v-for="group in org.groups">
                        <checkbox :value="group.id" v-model="form.groups" :label="group.name"></checkbox>
                    </div>
                </fieldset>
            </div>
        </div>
        <div v-show="!loading && invite && !invite_success">
            <notification class="mb-4" variant="success" v-if="hasSuccess" :text="hasSuccessText"></notification>
            <div class="form-group message-area">
                <label class="control-label">Invitation Message&nbsp;<span class="text-gray-700">(optional)</span></label><br>
                <small class="form-text text-muted">
                    Feel free to customize this message to your new users.
                </small>
                <textarea class="form-control editor"  v-model="form.message"></textarea>
            </div>
        </div>
        <div v-show="!loading && invite_success">
            <notification class="mb-4" variant="success" v-if="hasInviteSuccess" :text="hasInviteSuccessText"></notification>
        </div>
            </div>

                        <div class="modal-footer" v-show="!loading">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-if="!invite && !invite_success">Cancel</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-else-if="invite && !invite_success">Send Invitation Later</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" v-else>Close</button>
            <button class="btn btn-primary" type="submit" :disabled="submitting" @click="submit" v-if="!invite && !invite_success">
                <div v-if="submitting" class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Submitting</span>
                </div>
                <span v-else>Add Users</span>
            </button>
            <button class="btn btn-primary" type="submit" :disabled="submitting" @click="submit" v-else-if="invite && !invite_success">
                <div v-if="submitting" class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Inviting</span>
                </div>
                <span v-else>Send Invitation</span>
            </button>
                            </div>
                    </div>
    </div>
</div>
    
        <script>
        var Boardable = JSON.parse('{\u0022app_url\u0022:\u0022https:\\\/\\\/app.boardable.com\u0022,\u0022org_url\u0022:\u0022https:\\\/\\\/app.boardable.com\\\/nexus-3\\\/\u0022,\u0022org_slug\u0022:\u0022nexus-3\u0022,\u0022org_id\u0022:36907,\u0022group_url\u0022:null,\u0022timezone\u0022:\u0022Africa\\\/Nairobi\u0022,\u0022user\u0022:{\u0022id\u0022:323280,\u0022email\u0022:\u0022engfelixnyachio@gmail.com\u0022,\u0022name\u0022:\u0022Nyariki Felix\u0022,\u0022hide_document_left_panel\u0022:0,\u0022hide_document_right_panel\u0022:0,\u0022profile.document_sort\u0022:\u0022default\u0022},\u0022user_has_new_notifications\u0022:false,\u0022document_sort\u0022:\u0022default\u0022,\u0022isAdmin\u0022:true,\u0022isMember\u0022:false,\u0022isObserver\u0022:false,\u0022isPro\u0022:1,\u0022google\u0022:{\u0022developerKey\u0022:\u0022AIzaSyBIOMK6CKsetPjifCaNHlKhERQvrearlY4\u0022,\u0022clientId\u0022:\u0022211296066633-f45roh6ftt8f9sjfdl3iun3lbqo84k5q.apps.googleusercontent.com\u0022},\u0022onedrive\u0022:{\u0022clientId\u0022:\u00224e1d7775-5208-4845-a17e-60001f948f0d\u0022},\u0022dropbox\u0022:{\u0022appKey\u0022:\u0022ct62iasd6ansxkz\u0022},\u0022pusher\u0022:{\u0022key\u0022:\u0022f922879235c5fe3a363f\u0022,\u0022cluster\u0022:\u0022mt1\u0022},\u0022date_format\u0022:\u0022M\\\/D\\\/Y\u0022}');
        Boardable.data_url = function(path) {
            return `/${this.org_slug}/${path}`;
        };
        try {
            Boardable.local_timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; // not all browsers may have this property
        } catch (e) {
            Boardable.local_timezone = 'America/New_York';
        }
    </script>

    <script
        src="https://cdn.tiny.cloud/1/lsc0spwig4s420pl8bq8psksieg1t6eizuwpwdoe34vnn6r2/tinymce/6/tinymce.js"
        referrerpolicy="origin"
    ></script>

    <script src="/v4/js/manifest.js?id=c8556d6164902f994c962f51e09e688a"></script>
    <script src="/v4/js/vendor.js?id=7f07324266cd3920d33fbe57bd5165da"></script>
    <script src="/v4/js/vendor.bundle.js"></script>
    <script src="/v4/js/theme.bundle.js"></script>
    <script src="/v4/js/app.js?id=0c396f6abda2ce9fade92a207e877a14"></script>
    <script>
        let sendMessageEl = document.getElementById('send-message')
        let sendMessageModal = Modal.getOrCreateInstance(sendMessageEl)

        sendMessageEl.addEventListener('shown.bs.modal', function() {
            meetingSendMessage.$refs.notificationsList.fetchData()
        })

        const meetingSendMessage = new Vue({
            el: '#send-message-form',
            data() {
                return {
                    submitEnabled: false,
                    errorMessage: '',
                    form: $form.make({
                        'subject': 'testing 2',
                        'include_meeting_info': true,
                        'attach_agenda': null,
                        additional_agenda: {},
                        'message': '',
                        'notify': [],
                        'notify_guests': []
                    }),
                    submitting: false
                }
            },
            mounted() {
                autosize(this.$refs.editor)
            },
            destroyed() {
                autosize(this.$refs.editor).destroy()
            },
            methods: {
                setSubmitEnabled: function(bool) {
                    this.submitEnabled = bool;
                },
                submit() {
                    this.submitting = true
                    this.form.post(this.$el.action)
                        .then(response => {
                            sendMessageModal.hide();
                            this.errorMessage = '';
                            this.$refs.sendMessageForm.reset();
                            this.form.subject = 'testing 2';
                            this.form.message = '';
                            this.form.attach_agenda = null;
                            this.submitting = false
                        }).catch(e => {
                            if(this.form.errors.has('notify')){
                                this.errorMessage = this.form.errors.getAll('notify').join(', ');
                            }
                            this.submitting = false
                        })
                }
            },
            computed: {
                additionalDays() {
                    return []                }
            }
        });

        meetingSendMessage.name = 'Send Meeting Message'
    </script>
    <script>
        let resendMtgInvites = document.getElementById('resend-meeting-invites')
        let resendMtgInvitesModal = Modal.getOrCreateInstance(resendMtgInvites)

        resendMtgInvites.addEventListener('shown.bs.modal', function(evt) {
            resendMtgInvitesVue.$data.form.id = parseInt(evt.relatedTarget.dataset.meetingId)
            resendMtgInvitesVue.updateNotificationsList()
        })

        const resendMtgInvitesVue = new Vue({
            el: '#resend-meeting-invites-form',
            data() {
                return {
                    submitting: false,
                    form: $form.make({
                        id: null,
                        notify: [],
                        notify_guests: [],
                        true_resend: true,
                    })
                }
            },
            computed: {
                calendarWarning() {
                    return !this.form.send_email_invitation
                },
            },
            methods: {
                updateNotificationsList() {
                    this.$nextTick( () => {
                        this.$refs.notificationsList.fetchData()
                    })
                },
                submitForm() {
                    this.submitting = true
                    this.form.post(this.$el.action)
                        .then(response => {
                            resendMtgInvitesModal.hide()
                            window.$toast[response.data.type](response.data.text)
                            this.submitting = false
                        }).catch(e => {
                            // $toast.error('An error occurred.')
                            this.submitting = false
                        })
                }
            }
        });

        resendMtgInvitesVue.name = "Resend Meeting Invites"
    </script>
    <script>
        let sendSummaryEl = document.getElementById('send-meeting-summary')
        let sendSummaryModal = Modal.getOrCreateInstance(sendSummaryEl)

        sendSummaryEl.addEventListener('shown.bs.modal', function(evt) {
            meetingSummaryForm.$data.form.id = parseInt(evt.relatedTarget.dataset.meetingId)
            meetingSummaryForm.updateNotificationsList()
        })

        let meetingSummaryForm = new Vue({
            el: '#send-summary-form',
            data() {
                return {
                    form: $form.make({
                        id: null,
                        notify: [],
                        notify_guests: [],
                        subject: 'Meeting Summary',
                        message: '',
                        summary: {
                            cover: true,
                            attendance: true,
                            tasks: "",
                            agenda: "",
                            minutes: "",
                        }
                    })
                }
            },
            methods: {
                openPreview() {
                    const params = new URLSearchParams()

                    if (this.form.summary.cover)
                        params.append('summary[cover]', 'on');
                    if (this.form.summary.attendance)
                       params.append('summary[attendance]', 'on');
                    if (this.form.summary.tasks)
                        params.append('summary[tasks]', 'on');
                    if (this.form.summary.agenda)
                        params.append('summary[agenda]', 'on');
                    if (this.form.summary.minutes)
                        params.append('summary[minutes]', 'on');

                    window.open('https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/summary?' + params.toString(), '_blank');
                },
                updateNotificationsList() {
                    this.$nextTick( () => {
                        this.$refs.notificationsList.fetchData()
                    })
                },
                submitForm() {
                    this.form.post(this.$el.action)
                        .then(response => {
                            sendSummaryModal.hide()
                            window.$toast[response.data.type](response.data.text)
                        }).catch(e => {
                            // $toast.error('An error occurred.')
                        })
                }
            }
        });
    </script>
    <script>
        let deleteMeetingEl = document.getElementById('delete-meeting')
        let deleteMeetingModal = Modal.getOrCreateInstance(deleteMeetingEl)

        new Vue({
            el: "#delete-meeting-form",
            name: 'Delete Meeting Form',
            data() {
                return {
                    meetingId: null,
                    publishedLevel: null,
                    hasSeries: null,
                    form: $form.make({
                        'notify': true,
                        'message': '',
                    })
                }
            },
            mounted() {
                let scope = this
                deleteMeetingEl.addEventListener('shown.bs.modal', function(e) {
                    scope.meetingId = e.relatedTarget.dataset.meetingId;
                    scope.publishedLevel = e.relatedTarget.dataset.publishedLevel
                    scope.hasSeries = e.relatedTarget.dataset.hasSeries
                });
            },
            methods: {
                deleteMeeting() {
                    let url = "https://app.boardable.com/nexus-3/meetings_v2/" + this.meetingId + "/delete"

                    axios.post(url, this.form)
                        .then(response => {
                            window.location = response.data.url
                        })
                        .catch(e => {})
                }
            }
        })
    </script>
    <script>
        let mobileTopbar = new Vue({
            el: '#mobile-topbar-apps',
            name: 'Mobile Top Bar'
        });
        new Vue({
            el: '#sidebarCollapse',
        });
    </script>
    <script>
        let topbarAppsVue = new Vue({
            el: '#topbar-apps'
        });
        topbarAppsVue.name = 'Topbar Apps'
    </script>
    <script>
        let rsvpStatus = new Vue({
            el: '#rsvp-status'
        });
        rsvpStatus.name = 'RSVP Status'
    </script>
    <script>
        // $('.resend-invite').tooltipster({
        //     contentAsHTML: true,
        //     interactive: true,
        //     theme: 'tooltipster-shadow'
        // });

        // $('.guest-link-placeholder').tooltipster();
        let baseUrl = Boardable.data_url('meetings/5fb1df-testing-2')
        let membersTableListOptions = {
            item: `<tr><td class="user-name"></td><td class="role"></td><td class="rsvp"></td><td class="attendance"></td></tr>`,
            sortClass: "list-sort",
            searchClass: "list-search",
            valueNames: [{
                    "name": "user-name",
                    "attr": "data-name"
                },
                {
                    "name": "role",
                    "attr": "data-role"
                },
                {
                    "name": "rsvp",
                    "attr": "data-rsvp"
                },
                {
                    "name": "attendance",
                    "attr": "data-attendance"
                },
            ]
        }

        let membersTable = new Vue({
            el: '#members',
            name: 'Members Table',
            data() {
                return {
                    listInstance: null
                }
            },
            mounted() {
                this.listInstance = new List(this.$el, membersTableListOptions)
                this.initPeopleCards()
                this.initRsvpNotes()
            },
            methods: {
                initRsvpNotes() {
                    // Initialize popovers since Vue removes events
                    const rsvps = this.$el.querySelectorAll('.rsvp-note')
                    const rsvpsPopovers = [...rsvps].map(popoverTriggerEl => {
                        popoverTriggerEl.addEventListener('click', (e) => e.preventDefault())
                        return Popover.getOrCreateInstance(popoverTriggerEl)
                    })
                },
                initPeopleCards() {
                    // Initialize popovers since Vue removes events
                    const personPopoverEls = this.$el.querySelectorAll('.person-card')
                    const personPopovers = [...personPopoverEls].map(window.initPersonPopover);
                },
                updatedRSVP($event) {
                    this.$refs[`rsvp-${$event.user_id}`].dataset.rsvp = $event.status
                    this.listInstance.reIndex()
                },
                setAttendance($event, type = 'member') {
                    let target = $event.currentTarget
                    let link = target;
                    let cell = target.closest('td')
                    let url = type === 'member' ? `${baseUrl}/attendance` : `${baseUrl}/guests/attendance`

                    target.innerHTML = window.loadingIcon;

                    var params = {
                        id: target.dataset.id,
                        status: target.dataset.status === 'yes' ? '' :
                            'yes' // for backwards compatibility, don't explicitly set "no"
                    }

                    axios.post(url, params)
                        .then(() => {
                            if (link.dataset.status === 'yes') {
                                cell.dataset.attendance = 'no'
                                link.dataset.status = 'no'
                                link.setAttribute('aria-label', 'mark present');
                                link.innerHTML = window.faIcon('circle-check', 'text-muted')
                            } else {
                                cell.dataset.attendance = 'yes'
                                link.dataset.status = 'yes'
                                link.setAttribute('aria-label', 'mark not present');
                                link.innerHTML = window.faIcon('solid-circle-check', 'text-success')
                            }

                            this.listInstance.reIndex()
                        });
                }
            }
        })

        $(document).on("click", ".send-invite", function() {
            var invite_text = $(this);
            var invite_reminder = 1;
            var group_email = $(this).attr('id');
            return $.ajax({
                url: 'https://app.boardable.com/nexus-3/people/invite',
                data: {
                    group_email,
                    invite_reminder,
                    '_token': 'tMJT22BxahZC1oRUvkx9OL9vUMo7OhYku4m3mLK1',
                },
                beforeSend: function(response) {
                    invite_text.text('Sending...');
                },
                success: function(response) {
                    invite_text.removeClass('send-invite');
                    invite_text.text('Invite Sent!');
                },
                method: 'POST'
            });
        });

        $(document).on('click', '.send-link', function(e) {
            e.preventDefault();
            let target = this
            let currentHTML = target.innerHTML

            target.innerHTML = window.loadingIcon

            axios.post('https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/send-guest-link', {
                    id: target.dataset.id
                })
                .then(response => {
                    target.innerHTML = currentHTML
                    window.$toast.success(`Link sent`)
                });
        });

        $(document).on('change', '.collaborator-select', function(e) {
            let selectedValue = this.options[this.selectedIndex].value;

            var params = {
                user_id: this.dataset.userId,
                status: selectedValue === 'collaborator' ? '1' : '0'
            };

            axios.post('https://app.boardable.com/nexus-3/meetings/5fb1df-testing-2/people/set-collaborator', params)
                .then(response => {
                    window.$toast.success(`User role updated`)
                })
        });
    </script>
        <script>

        let meeting_sidebar_app = new Vue({
            el: '#meeting-sidebar-app',
            name: 'MeetingSidebarApp',
              provide() {
                return {
                  features: {
                    has_groups: true,
                    has_professional_features: true,
                  },
                }
              },
            methods: {
                scrollToBottom() {
                    this.$refs['comments_widget'].scrollToBottom();
                }
            }
        })

        var pageOffCanvas = document.getElementById('page-offcanvas')
        var pageContent = document.getElementById('page-content')
        var pageSb = document.getElementById('page-sb')
        var pageSpacer = document.getElementById('page-spacer')

        var mtgTimeout;
        // Listen for resize events
        window.addEventListener('scroll', function ( event ) {
            if (mtgTimeout) { window.cancelAnimationFrame(mtgTimeout) }
            mtgTimeout = window.requestAnimationFrame(() => {
                positionSb()
                setOffCanvasTop()
            });
        }, false);

        addEventListener('DOMContentLoaded', (event) => {
            pageSpacer.style.transition = 'width 0.3s ease-in-out'
            pageSpacer.style.width = 0
        });

        function setOffCanvasTop() {
            if (pageContent.getBoundingClientRect().top < 1) {
                pageOffCanvas.style.top = ''
            } else {
                pageOffCanvas.style.top = pageContent.getBoundingClientRect().top + 'px'
            }
        }

        function positionSb() {
            if (pageContent.getBoundingClientRect().top < 1) {
                pageSb.style.position = 'fixed'
                pageSb.style.marginTop = 0
                pageSpacer.style.marginRight = pageSb.offsetWidth + parseInt(window.getComputedStyle(pageSb).marginLeft) + 'px'
            } else {
                pageSb.style.position = ''
                pageSb.style.marginTop = ''
                pageSpacer.style.marginRight = ''
            }
        }

        pageOffCanvas.addEventListener('show.bs.offcanvas', function () {
            pageSpacer.style.width = pageOffCanvas.offsetWidth - pageSb.offsetWidth + 'px'
            positionSb();
            setOffCanvasTop();
        })

        pageOffCanvas.addEventListener('shown.bs.offcanvas', () => {
            meeting_sidebar_app.scrollToBottom();
        });

        pageOffCanvas.addEventListener('hide.bs.offcanvas', function () {
            pageSpacer.style.width = 0
        })

        pageOffCanvas.addEventListener('hidden.bs.offcanvas', function () {
            // document.body.style.overflow = ''
            pageOffCanvas.style.position = ''
        })

    </script>
        <script>
        if (document.getElementById('previous-card')) {
            new Vue({
                el: '#previous-card',
                name: 'Previous Meeting Card'
            })
        }
        new Vue({
            el: '#notifications-and-card',
        })
    </script>
<script>
    $('#organization-form').ageAxe({
        success: function(response) {
            window.location = 'https://app.boardable.com/sign-up/complete/' + response.id;
        }
    });
</script>
    <script>
        const invite_app = new Vue({
            el: '#invite-people',
            data() {
                return {
                    org: {
                        num_users: 0,
                        subscribed: false,
                        max_users: 0,
                        groups: []
                    },
                    showFileUploader: false,
                    form: {
                        people: [],
                        role: 'member',
                        groups: [],
                        message: '<p>Boardable is a board management tool that we will be using to schedule meetings, organize documents, start discussions, and maintain an up-to-date people directory. Please log in to set up your profile!</p>'
                    },
                    error: null,
                    submitting: false,
                    loading: true,
                    file: '',
                    empty: false,
                    success: null,
                    invite: false,
                    emails: null,
                    invite_success: null,
                    tagify: null,
                    saved_users: '',
                    not_enough_users: false
                }
            },
            mounted() {
                this.initTagify();
                this.tagify.addTags(this.saved_users)
            },
            methods: {
                init() {
                    this.loading = true;
                    const tooltips = document.querySelectorAll('#invite-people [data-bs-toggle="tooltip"]');

                    tooltips.forEach(tooltip => {
                        Tooltip.getOrCreateInstance(tooltip);
                    });

                    axios.get(Boardable.data_url('people/init-form')).then(response => {
                        this.org = response.data;
                        this.loading = false;
                    });
                },
                initTagify() {
                    let scope = this;
                    let tagify = new Tagify(this.$refs['emails_input'], {
                        delimiters: ",| ",
                        callbacks: {
                            change: e => scope.updateEmails(e.detail.value)
                        }
                    });
                    this.tagify = tagify;
                },
                updateEmails(value) {
                    this.form.people = value ? JSON.parse(value).map(i => {
                        return { email: i.value}
                    }) : [];
                },
                handleFileUpload(){
                    this.file = this.$refs.file.files[0];
                },
                reset() {
                    this.org = {
                        num_users: 0,
                        subscribed: false,
                        max_users: 0,
                        groups: []
                    };
                    this.form.role = 'member';
                    this.form.groups = [];
                    this.form.message = '<p>Boardable is a board management tool that we will be using to schedule meetings, organize documents, start discussions, and maintain an up-to-date people directory. Please log in to set up your profile!</p>';
                    this.empty = false
                    this.showFileUploader = false;
                    this.error = null;
                    this.success = null;
                    this.invite_success = null;
                    this.invite = false;
                    this.submitting = false;
                    this.loading = true;
                    if(!this.not_enough_users){
                        this.form.people = [];
                        this.tagify.removeAllTags();
                    }
                    this.tagify.addTags(this.saved_users)
                },
                submit() {
                    this.submitting = true;
                    this.error = null;
                    this.success = null;

                    if(!this.file && !this.form.people[0]){
                        this.empty = true;
                    }

                    if(this.file) {
                        let formData = new FormData();
                        formData.append('file', this.file);
                        formData.append('role', this.form.role);
                        formData.append('groups', this.form.groups);
                        formData.append('message', this.form.message);
                        var payload = formData;
                        var config = "'Content-Type': 'multipart/form-data'";
                    } else {
                        var payload = this.form;
                        var config = '';
                    }

                    if(!this.invite){

                    axios.post(Boardable.data_url('people/import'), payload,
                          {
                            headers: {
                                config
                            }
                         })
                        .then(response => {
                            this.success = response.data.success;
                            this.invite = true;
                            $events.$emit('people-invited');
                        })
                        .catch(e => {
                            this.error = e.response.data.error;
                            this.not_enough_users = e.response.data.not_enough_users;
                        })
                        .finally(() => {
                            this.submitting = false;
                        });


                    } else {

                        axios.post(Boardable.data_url('people/invite'), payload,
                             {
                                headers: {
                                    config
                                }
                             })
                            .then(response => {
                                this.invite_success = response.data.invite_success;
                                $events.$emit('people-invited');
                            })
                            .catch(e => {
                                this.error = e.response.data.error;
                            })
                            .finally(() => {
                                this.submitting = false;
                            });

                    }
                }
            },
            computed: {
                hasError() {
                    return !!this.error;
                },
                hasErrorText() {
                    if(this.error){
                        return this.error;
                    }
                },
                hasSuccess() {
                    return !!this.success;
                },
                hasSuccessText() {
                    if(this.success){
                        return this.success;
                    }
                },
                hasInviteSuccess() {
                    return !!this.invite_success;
                },
                hasInviteSuccessText() {
                    if(this.invite_success){
                        return this.invite_success;
                    }
                },
                importButtonText() {
                    if(this.showFileUploader){
                        return "Manually enter email addresses";
                    } else {
                        return "Import users from csv/excel file";
                    }
                }
            }
        });
        invite_app.name = 'Invite People Modal';

        const invite_people = document.getElementById('invite-people');

        invite_people.addEventListener('shown.bs.modal', function() {
            invite_app.init();
        });

        invite_people.addEventListener('hide.bs.modal', function() {
            invite_app.reset();
        });
    </script>
    <script charset="utf-8" src="https://js.hscta.net/cta/current.js"></script>
    <script type="text/javascript">
        hbspt.cta.load( 4073229, 'af68ef9e-c658-4224-aa34-37c1ca1e0433', {
            "useNewLoader": "true",
            "region": "na1"
        });
    </script>
            <script src="https://cdn.lr-in.com/LogRocket.min.js" crossorigin="anonymous"></script>
        <script>
            window.LogRocket && window.LogRocket.init('oh1xti/boardable');
            window.LogRocket.identify('323280', {
                                    orgId: '36907',
                    orgSlug: 'nexus-3',
                                releaseStage: 'production',
                appUrl: 'https://app.boardable.com',
            });
        </script>
    
</body>

<script>
    var lastCheck = new Date();
    var caffeineSendDrip = function () {
        var ajax = window.XMLHttpRequest
            ? new XMLHttpRequest
            : new ActiveXObject('Microsoft.XMLHTTP');

        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4 && ajax.status === 204) {
                lastCheck = new Date();
            }
        };

        ajax.open('GET', 'https://app.boardable.com/caffeine-drip');
        ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        ajax.send();
    };

    setInterval(function () {
        caffeineSendDrip();
    }, 300000);

    if (2000 > 0) {
        setInterval(function () {
            if (new Date() - lastCheck >= 43082000) {
                location.reload(true);
            }
        }, 2000);
    }
</script>
</html>