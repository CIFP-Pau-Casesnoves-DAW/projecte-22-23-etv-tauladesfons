<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IDIOMES</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $idiomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idioma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($idioma->ID_IDIOMA); ?></td>
        <td><?php echo e($idioma->NOM_IDIOMA); ?></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>


</body>
</html>
<?php
 ?><?php /**PATH /var/www/EjerciciosPHP/ETVDB/resources/views/idiomes.blade.php ENDPATH**/ ?>