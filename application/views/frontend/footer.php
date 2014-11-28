<footer class="footer"></footer>
</section>


<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.accordion.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.easing.1.3.js"></script>

        <script type="text/javascript">
            $(function() {
				$('#st-accordion').accordion({
				oneOpenedItem	: true
				});
				});
				$(document).ready(function(){

				$(".toggle_button").click(function(){

				$(".toggle_box1").toggle();

				});
				$(".toggle_button1").click(function(){

				$(".toggle_box2").toggle();

				});
				
			});
		</script>
</body>
</html>