<?

if ($_SERVER['PHP_SELF'] != '/index.php') {

echo '<table style="text-align:center;margin-top: 0px;" cellspacing="0" cellpadding="0">';
echo '</table>';

echo '<div style="text-align:center;padding:0px;opacity: 1; margin-top: 5px;">


</div>';

}else{


echo '<div style="text-align:center;padding:0px;opacity: 1;">

</div>';

}

echo '</div>';

?>
<script>
document.getElementById('overlay').onclick=
document.getElementById('hamburger').onclick=function(){
document.getElementById('nav-icon1').classList.toggle('open_burger')
document.getElementById('sidebar').classList.toggle('opened')
document.getElementById('overlay').classList.toggle('opened')

}
</script>

<script>
document.getElementById('overlay-onew').onclick=
document.getElementById('allthems').onclick=function(){
document.getElementById('allthem-open').classList.toggle('opened')
document.getElementById('overlay-onew').classList.toggle('opened')

}
</script>

<script>
$('#content').on('input', function(){
	this.style.height = '1px';
	this.style.height = (this.scrollHeight + 6) + 'px'; 
});
</script>


<?


echo '</body></html>';

?>
