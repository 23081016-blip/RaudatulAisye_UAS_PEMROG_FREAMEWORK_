<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Bengkel Maju Motor</title>
    <!-- Load Bootstrap 5 dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <!-- Warna Navbar diubah menjadi bg-dark (Hitam Pekat) untuk tema Biru-Hitam -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Maju Motor</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Halo, <?php echo e(Auth::user()->name); ?> (<?php echo e(Auth::user()->role); ?>)</span>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-danger btn-sm fw-bold" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Konten halaman akan dirender di sini -->
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH D:\laragon\www\bengkel-maju-motor\resources\views/layouts/master.blade.php ENDPATH**/ ?>