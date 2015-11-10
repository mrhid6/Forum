
$(function(){
	var latenewsprev="";
	var d= new Date();
		$.get(Basefolder+"/js/latenewstype.php",{mydata:d.getTime()},function(data){
			latenewsprev=data;
			$('.latenews').html(data).fadeIn('slow');
		});
	setInterval(function(){
		d= new Date();
		$.get(Basefolder+"/js/latenewstype.php",{mydata:d.getTime()},function(data){
			if(latenewsprev!=data){
				$('.latenews').fadeOut('slow',function(){;
					$('.latenews').html(data).fadeIn('slow');
				});
				latenewsprev=data;
			}else{}
			
		});
		
	},10000)
	$('#catmins,#option').click(function(){
		var alt=$(this).attr('alt');
		var clicked=$(this);
		var thisheight=$(this).attr('taborder');
		if($("#"+alt).height()=='0'){
			$("#"+alt).animate({
				height:thisheight+"px",
			},1000,function(){
				$(clicked).attr("class","minus");
			});
		}else{
			$("#"+alt).animate({
				height:'0px'
			},1000,function(){
				$(clicked).attr("class","plus");
			});
		}
	});
});