<?php
	$lang = session()->get('lang') == 'ar' ? 'ar' : 'en';
?>

<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>" <?php if($lang == 'ar'): ?> dir="rtl" <?php endif; ?> class="semi-dark">

	<head>
		<meta charset="UTF-8">
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="icon" type="image/x-icon" href="<?php echo e(siteFavicon()); ?>">
		<title><?php echo e(gs('site_name')); ?> - <?php echo e(__(@$title ?? '')); ?></title>
		<?php if($lang == 'ar'): ?>
			<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap.rtl.min.css')); ?>">
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>">
		<?php endif; ?>
		<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap-extended.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/bootstrap-toggle.min.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/all.min.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>">

		<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/icons.css')); ?>">

		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

		<?php echo $__env->yieldPushContent('style-lib'); ?>

		<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/select2.min.css')); ?>">

		<?php if($lang == 'ar'): ?>
			<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/rtl_style.css')); ?>">
		<?php else: ?>
			<link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/style.css')); ?>">
		<?php endif; ?>

		
		<link rel="stylesheet" href="<?php echo e(assistantAsset('assets/admin/css/premium.css')); ?>">

		<?php echo $__env->yieldPushContent('style'); ?>

	</head>

	<body>
		<div class="wrapper">
			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<script src="<?php echo e(asset('assets/global/js/jquery.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>

		
		<script src="<?php echo e(asset('assets/admin/js/simplebar.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/admin/js/metisMenu.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/admin/js/perfect-scrollbar.js')); ?>"></script>

		<script src="<?php echo e(asset('assets/admin/js/bootstrap-toggle.min.js')); ?>"></script>

		<?php echo $__env->make('partials.notify', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<?php echo $__env->yieldPushContent('script-lib'); ?>

		<script src="<?php echo e(asset('assets/admin/js/nicEdit.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/admin/js/cuModal.js')); ?>"></script>

		<script src="<?php echo e(asset('assets/admin/js/select2.min.js')); ?>"></script>

		<script src="<?php echo e(asset('assets/admin/js/app.js')); ?>"></script>

		

		<script>
			"use strict";

			$(".langSel").on("click", function() {
				var langCode = $(this).data('lang');
				window.location.href = "<?php echo e(route('home')); ?>/change/" + langCode;
			});


			bkLib.onDomLoaded(function() {
				$(".nicEdit, nicEdit2").each(function(index) {
					$(this).attr("id", "nicEditor" + index);
					new nicEditor({
						fullPanel: true
					}).panelInstance('nicEditor' + index, {
						hasPanel: true
					});
				});
			});

			(function($) {
				$(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
					$('.nicEdit-main').focus();
				});
			})(jQuery);


			$(document).ready(function() {
				$('.select2-multiple').select2();
			});
		</script>

		<?php echo $__env->yieldPushContent('script'); ?>

	</body>

</html>
<?php /**PATH C:\laragon\www\3s-medicare\resources\views/admin/layouts/master.blade.php ENDPATH**/ ?>