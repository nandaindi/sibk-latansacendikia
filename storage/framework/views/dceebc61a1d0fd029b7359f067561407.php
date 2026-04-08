<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Bimbingan Konseling'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-caveat { font-family: 'Caveat', cursive; }
    </style>
</head>
<body class="bg-[#f5f7fa] min-h-screen text-[#1a1a1a] flex flex-col p-0 m-0">

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/bimbinganKonselingNanda/resources/views/layouts/guest.blade.php ENDPATH**/ ?>