<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e(config('app.name')); ?></title>
    <link rel="icon" href="<?php echo e(asset('assets/favicon.png')); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/front/main.ts', 'resources/sass/app.scss']); ?>
</head>

<body>
    
    <div id="app" data-app-url="<?php echo e(config('app.url')); ?>" v-cloak></div>
    <!-- Inside your Blade view or a service provider -->
    <?php echo e(\Log::debug(public_path('build/manifest.json'))); ?>


    

    
    <style>
    [v-cloak] {
        display: none;
    }

    .loading {
        display: grid;
        place-content: center;
        background: rgba(0, 0, 0, 0.3);
        z-index: 999;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    #app:not([v-cloak])~.loading {
        display: none;
    }
    </style>

</body>

</html><?php /**PATH D:\SystemsApps\revboard\resources\views/welcome.blade.php ENDPATH**/ ?>