
<?php $component = app('components')->component('foo')->wrapContent(); ?>

<?php $component->endWrapContent(); echo e($component); unset($component); ?>
