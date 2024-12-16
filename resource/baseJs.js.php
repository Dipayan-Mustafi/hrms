<script type="text/javascript">

window.onload=function(){

	if (document.getElementById('lobBox')){
		setLoginBox();
	}
	
		var wh=window.innerHeight || document.body.clientHeight;
		var ww=window.innerWidth || document.body.clientWidth;
	

		document.getElementById('mainDiv').style.backgroundSize=ww+"px "+wh+"px";
		document.getElementById('mainDiv').style.height=wh+'px';

	
};



	function setLoginBox(){

		var ht=window.innerHeight;
		var md=eval(ht)/2;
		alet (ht);
		var top=(eval(md)-15)+"px";

		var wd=window.innerWidth;
		
		var wmd=eval(wd)/2;
		
		var left=(eval(wmd)-10)+"px";

		

		document.getElementById('logBox').style.left=left;
		document.getElementById('logBox').style.top=top;

	}	


	function changeFY(f,u){

		window.location=u+"setFY?fyr="+f;
		
	}

	function navigate(p){

		window.location=p;
	}
	function PrintDiv(d, t) {    
	     var divToPrint = document.getElementById(d);
	     var popupWin = window.open('', '_blank', 'width=300,height=300');
	     popupWin.document.open();
	     popupWin.document.write('<html><title>'+t+'</title><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
	     popupWin.document.close();
	}
	
function WindowOpen(p,t,h,w, tm,lm){

	window.open(p, t, 'top='+tm+', left='+lm+', height='+h+', width='+w+', toolbars=No, statusbars=No');
}
</script>
