<script language="javascript" type="text/javascript" src="lib/jquery.ping.js"></script>
<script type="text/javascript">
/*
pingTest:
sayfadan sunucuya ping testi
*/
$(document).ready(function (){
	$('#pingTest').ping({
		interval : 3, 
		unit : ''   
	});
});
</script>

<img id="pingTest" src="img/loadingRect2.gif" alt="ping" title="ping" />