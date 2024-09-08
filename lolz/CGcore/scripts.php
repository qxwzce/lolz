<script>
setTimeout(function(){
	document.body.classList.add('body');
}, 25);setTimeout(function(){
	document.body.classList.add('body');
}, 25);
</script>

<script>
/* Когда пользователь нажимает на кнопку,
переключение между скрытием и отображением раскрывающегося содержимого */
function myFunction() {
  document.getElementById("dropdown").classList.toggle("show");
}

// Закройте выпадающее меню, если пользователь щелкает за его пределами
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>



<script type="text/javascript"> 
$(document).ready(function(){ 
$('.spoiler-title').click(function(){ 
$(this).parent().children('div.spoiler-content').toggle('fast');
return false;
});
});
</script>

<script>
function refreshPage(){
    window.location.reload();
} 
</script>

<script>
$(document).on({
  'click': function (e) {
    var target,
        href;
    if (!e.isDefaultPrevented() && (e.which === 1 || e.which === 2)) {
      target = $(this).data('target') || '_self';
      href = $(this).data('href');
      if (e.ctrlKey || e.shiftKey || e.which === 2) {
        target = '_blank'; //close enough
      }
      open(href, target);
    }
  },
  'keydown': function (e) {
    if (e.which === 13 && !e.isDefaultPrevented()) {
      $(this).trigger({
        type: 'click',
        ctrlKey: e.ctrlKey,
        altKey: e.altKey,
        shiftKey: e.shiftKey
      });
    }
  }
}, '[role="link"]');

$('[aria-disabled="true"]').on('click', function (e) {
  e.preventDefault();
});
</script>

<script>
$("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = 0;
  this.style.height = (this.scrollHeight) + "px";
});
</script>



<script>

	var need_old_jquery = jQuery.noConflict();
	
</script>

<script language="javascript">
(function() {
    var pre = document.getElementsByTagName('pre'),
        pl = pre.length;
    for (var i = 0; i < pl; i++) {
        pre[i].innerHTML = '<span class="line-number"></span>' + pre[i].innerHTML + '<span class="cl"></span>';
        var num = pre[i].innerHTML.split(/\n/).length;
        for (var j = 0; j < num; j++) {
            var line_num = pre[i].getElementsByTagName('span')[0];
            line_num.innerHTML += '<span>' + (j + 1) + '</span>';
        }
    }
})();
</script>


<script>
window.yandex.autofill.getProfileData(['name', 'email', 'phone', 'address'])
    .then((result) => {
      console.log(result);
    },(error) => {
      console.log(error);
});
</script>

<script>
$('.modal').mouseup(function (e) {
   let modalContent = $(".modal-content");
   if (!modalContent.is(e.target) && modalContent.has(e.target).length === 0) {
     $(this).classAdd('modalni');
   }
 });
</script>

<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(95468867, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>