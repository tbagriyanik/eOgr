<script  type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<script  type="text/javascript" src="lib/jquery.timers-1.1.2.js"></script>
<script  type="text/javascript" src="lib/jquery.ping.js"></script>
<script type="text/javascript">
$(document).ready(function (){
	$('#pingTest').ping({
		interval : 3, 
		unit : ''   
	});
});
</script>
<img id="pingTest" src="img/loadingRect2.gif" alt="ping" title="ping" />