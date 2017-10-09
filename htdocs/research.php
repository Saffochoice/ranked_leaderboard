<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Secret Ayanot</title>
	<link rel="stylesheet" href="css/style.css">

<style>
	
</style>

</head>

<body>
	<div class="wrapper">
		<div class="header">
			<h1>Data input</h1>
		</div>
		<div class="table">
			<table >
					
			</table>
			<div class="table_button" >research</div>
			<div class="tempdiv">
				<form action="index.php" method="get">
					<input class="tempform" type="textarea" name="username" value="<?php echo(file_get_contents("info.txt")) ?>"/>
					
				</form>
				
			</div>
		</div>

		<div class="popup_shadow">
			
		</div>
		<div class="popup_wrapper">
			<h1 style="text-align:center; text-transform: uppercase; font-family: sans-serif;padding-top: 20px;">Выбор игроков</h1>
			<div class="popup_table" id="one">
				
			</div>
			
			<div class="popup_button">
				Connect
			</div>
		</div>

		
	</div>
	<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

  <script>

  	$( document ).ready(function() {
  	class Player  {

	  constructor(name) {
	    this.name = name;
	    this.elo = 0;
	    this.win = 0;
	    this.lost = 0;
	    this.liberal_win = 0;
	    this.liberal_lost = 0;
	    this.facist_win = 0;
	    this.facist_lost = 0;
	    this.hitler_count = 0;
	    this.hitler_fuhrer = 0;
	    this.dead_hitler = 0;

	  }

	  sayHi() {
	    alert(this.name);
	  }

	}

	function Research(profiles,played){
		var win_elo = 0;
		var lost_elo = 0;
		var win_counter = 0;
		var lost_counter = 0;
		var liberal_wins = false;
		var HitlerCheck = 0;
		for(i=0;i<played.length;i++){
			for(j=0;j<profiles.length;j++){
				if(played[i][0]==profiles[j].name&&played[i][1]==true){
					win_elo += parseInt(profiles[j].elo);
					win_counter ++;
				}
				if(played[i][0]==profiles[j].name&&played[i][1]==false){
					lost_elo += parseInt(profiles[j].elo);
					lost_counter ++;
				}
			}
		}
		win_elo = win_elo/win_counter;
		lost_elo = lost_elo/lost_counter;
		liberal_wins = (win_counter>lost_counter);

		for(i=0;i<played.length;i++){
			if(played[i][2]=='Dead Hitler'){
				HitlerCheck = 1;
			}
			if(played[i][2]=='Hitler Fuhrer'){
				HitlerCheck = 2;
			}
		}

		for(i=0;i<played.length;i++){
			for(j=0;j<profiles.length;j++){
				if(played[i][0]==profiles[j].name&&played[i][1]==true){
					if(liberal_wins){
						var l = 1;
						var k = lost_elo - profiles[j].elo;
						if(k>=0&&k<=200)
							k = 20+Math.abs(k/6.66);
						if(k<-200)
							k = 20;
						if(k<0&&k>=-200)
							k = 20+Math.abs(k/6.66);
						if(k>200)
							k=50;
						
						if(HitlerCheck==1){
							profiles[j].dead_hitler = parseInt(profiles[j].dead_hitler)+1;
							l=1.25;
						}
						profiles[j].elo = parseInt(profiles[j].elo)+parseInt(k*l);
						profiles[j].win = parseInt(profiles[j].win)+1;
						//profiles[j].lost = parseInt(profiles[j].lost)+1;
						profiles[j].liberal_win = parseInt(profiles[j].liberal_win)+1;
						//profiles[j].liberal_lost = parseInt(profiles[j].liberal_lost)+1;

					}
					if(!liberal_wins){
						var l = 1;
						var k = lost_elo - profiles[j].elo;
						if(k>=0&&k<=200)
							k = 20+Math.abs(k/6.66);
						if(k<-200)
							k = 20;
						if(k<0&&k>=-200)
							k = 20+Math.abs(k/6.66);
						if(k>200)
							k=50;
						
						if(HitlerCheck==2){
							profiles[j].hitler_fuhrer = parseInt(profiles[j].hitler_fuhrer)+1;
							l=1.25;
						}

						if(played[i][2]=="Hitler")
							profiles[j].hitler_count ++;

						profiles[j].elo = parseInt(profiles[j].elo)+parseInt(k*l);
						profiles[j].win = parseInt(profiles[j].win)+1;
						profiles[j].facist_win = parseInt(profiles[j].facist_win)+1;
					}
				}
				if(played[i][0]==profiles[j].name&&played[i][1]==false){
					if(liberal_wins){
						var l = 0.75;
						var k = win_elo - profiles[j].elo;
						if(k>=0)
							k=20;
						if(k<-200)
							k = 50;
						if(k>-200&&k<0)
							k = 20+parseInt(Math.abs(k/6.66));

						if(played[i][2]=="Hitler")
							profiles[j].hitler_count ++;

						profiles[j].elo = parseInt(profiles[j].elo-parseInt(k*l));
						profiles[j].lost = parseInt(profiles[j].lost)+1;
						profiles[j].facist_lost = parseInt(profiles[j].facist_lost)+1;

					}
					if(!liberal_wins){
						var l = 0.75;
						var k = win_elo - profiles[j].elo;
						if(k>=0)
							k=20;
						if(k<-200)
							k = 50;
						if(k>-200&&k<0)
							k = 20+parseInt(Math.abs(k/6.66));
						profiles[j].elo = parseInt(profiles[j].elo-parseInt(k*l));
						profiles[j].lost = parseInt(profiles[j].lost)+1;
						profiles[j].liberal_lost = parseInt(profiles[j].liberal_lost)+1;

					}
				}
			}
		}
		var str_final='';
		for(i=0;i<profiles.length;i++){
			str_final += profiles[i].name + ' ' + profiles[i].elo + ' ' + profiles[i].win + ' ' + profiles[i].lost + ' ' + profiles[i].liberal_win + ' ' + profiles[i].liberal_lost + ' ' + profiles[i].facist_win + ' ' + profiles[i].facist_lost + ' ' + profiles[i].hitler_count + ' ' + profiles[i].hitler_fuhrer + ' ' + profiles[i].dead_hitler + ';';
		}
		$('.tempform').val(str_final);
		$.ajax({
        	type: 'GET',
        	url: 'ajax.php',
        	data: {'str':str_final}
        	
        	//success: function(response) { alert(response); }
     	});
		location.reload();
		console.log(str_final);
	}
	
	//reader.readAsText(file.txt);
	//var str = $('.tempdiv').html();
	//str = str.split(';');
	//alert(str);
  	var players = [];
  	var played_players =[];
  	var php_str = $('.tempform').val();
  	php_str = php_str.split(';');
  	var player_objs = [];
  	for(var i=0;i<php_str.length-1;i++){

  		php_str[i]=php_str[i].split(' ');
  		players.push(php_str[i][0]);
  		player_objs[i] = new Player(php_str[i][0]);
		player_objs[i].elo = php_str[i][1];
		player_objs[i].win = php_str[i][2];
		player_objs[i].lost = php_str[i][3];
		player_objs[i].liberal_win = php_str[i][4];
		player_objs[i].liberal_lost = php_str[i][5];
		player_objs[i].facist_win = php_str[i][6];
		player_objs[i].facist_lost = php_str[i][7];
		player_objs[i].hitler_count = php_str[i][8];
		player_objs[i].hitler_fuhrer = php_str[i][9];
		player_objs[i].dead_hitler = php_str[i][10];

 
  		
  	}
  	

  	$('.table_button').click(function(){
  		for (i=0;i<$('table tr').length;i++){
  			played_players.push([$('table tr').eq(i).find('td').eq(0).text(),$('table tr').eq(i).find('input').eq(0).is(':checked'),$('table tr').eq(i).find('select').eq(0).val()]);
  		}
  		Research(player_objs,played_players);
  		console.log(player_objs);
	});

  	
  	for (var i =0;i<players.length;i++) {
  		$('.popup_table').append('<div class="popup_table_item"><input type="checkbox" />'+players[i]+'</div>');
  	}
  	$('.popup_button').click(function(){
  		for (var i =0;i<players.length;i++) {
  			if($('.popup_table_item input').eq(i).prop("checked")){
  				$('.table table').append('<tr><td>'+players[i]+'</td><td><input type="checkbox" placeholder="Win"/></td><td><select name="" id=""><option value="Human">Human</option><option value="Hitler">Hitler</option><option value="Dead Hitler">Dead Hitler</option><option value="Hitler Fuhrer">Hitler Fuhrer</option></select></td></tr>');

  			}
  		}
  		$('.popup_wrapper').fadeOut(300);
  		$('.popup_shadow').fadeOut(300);
  		var str3 = 'ewfwef';
  		
  	});
  });
  </script>

 
</body>
</html>

