<footer class="content-info" role="contentinfo">
	<div class="row">
		<div class="large-12 columns">
			<div class="copyright">
				<p>
					&copy;
					<?php echo date('Y'); ?>
					<?php bloginfo('name'); ?></p>
			</div>
		</div>
	</div>

</footer>
<?php if (is_singular( 'portfolio' )): ?>
	<script>jQuery(document).ready(function($){if($(".content.portfolio").length){$portThumb=$(".portfolio-thumbnail");$screenieWrap=$(".screenshot-wrap");$screenieWrap.addClass("active");$(".portfolio-thumbnail a").on("mouseenter click",function(e){var $this=$(this),$screenShot=$("img.screen-shot"),$currImage=$screenShot.attr("src"),$newImage=$this.attr("data-image");$portThumb.removeClass("active");$screenieWrap.removeClass("active");$this.parent("li").addClass("active");$("img.screen-shot").attr("src",
	$newImage).delay(100).parent("span").addClass("active");return false})}});</script>
<?php endif ?>
<?php wp_footer(); ?>
<script>
jQuery(document).foundation();var $bodyH=$("body").height(),$windowH=window.innerHeight;if($bodyH<$windowH)$("footer.content-info").addClass("fixed-footer");
</script>