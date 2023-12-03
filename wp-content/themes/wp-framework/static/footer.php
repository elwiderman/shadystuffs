</div>

<footer class="footer">
	<?php
	get_template_part('parts/footer/footer', 'top');
	get_template_part('parts/footer/footer', 'middle');
	get_template_part('parts/footer/footer', 'bottom');
	
	?>
</footer>

<?php
// add the sharethis script
$sharethis	= get_field('sharethis_key', 'option');

if ((is_singular(['product']) || is_page_template('templates/page-woo-myaccount.php')) && !empty($sharethis)) : ?>
	<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=<?php echo $sharethis;?>&source=platform" async="async"></script>
<?php endif; ?>

<?php wp_footer(); ?>

	</body>
</html>
