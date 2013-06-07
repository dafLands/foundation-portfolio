<footer class="content-info row full-width" role="contentinfo">
	<div class="large-12 columns">
		<div class="copyright">
			<p>
				&copy;
				<?php echo date('Y'); ?>
				<?php bloginfo('name'); ?></p>
		</div>
	</div>
</footer>
<?php if (is_singular( 'portfolio' )): ?>
	<script>jQuery(document).ready(function($){if($(".content.portfolio").length){$portThumb=$(".portfolio-thumbnail");$screenieWrap=$(".screenshot-wrap");$screenieWrap.addClass("active");$(".portfolio-thumbnail a").on("mouseenter click",function(e){var $this=$(this),$screenShot=$("img.screen-shot"),$currImage=$screenShot.attr("src"),$newImage=$this.attr("data-image");$portThumb.removeClass("active");$screenieWrap.removeClass("active");$this.parent("li").addClass("active");$("img.screen-shot").attr("src",
	$newImage).delay(100).parent("span").addClass("active");return false})}});</script>
<?php endif ?>
<?php if (is_front_page()): ?>
	<script>
		// Short script to encode our SVG in base64
		// This can be reversed using window.atob('base64')
		var svg = document.getElementsByTagName('svg')[0];

		// Convert the SVG node to HTML.
		var div = document.createElement('div');
		div.appendChild(svg.cloneNode(true));

		// Encode the SVG as base64
		var b64 = 'data:image/svg+xml;base64,'+window.btoa(div.innerHTML);
		var url = 'url("' + b64 + '")';

		codeCss = 'background-image: ' + url + ';';
		$('#jumbotron').attr('style', codeCss);
	</script>
<?php endif; ?>
<?php wp_footer(); ?>
<script>jQuery(document).foundation();</script>