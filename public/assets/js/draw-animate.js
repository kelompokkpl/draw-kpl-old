var showEven;
var showOdd;
var hideEven;
var hideOdd;

function randomParticipant(id) {
	let random = Math.floor(Math.random() * countParticipant);
	let show = participant[random].name + '<br><span class="text-lato-thin">' + participant[random].participant_id + '</span>';
 	$("#part"+id).html(show);
}

function hide(id){
	$("#part"+id).html(' ');
}

function start(){
	showEven = setInterval(function(){
		let j;
		for (let i = 0; i < countParticipant; i++) {
			if(i%4==0){
				j = j+1;
			}
			if(i%2==0 && j%2==1){
				hide(i);
			} 
			if(i%2!=0 && j%2==1){
				randomParticipant(i);
			} 

		}
	}, 400)
	hideEven = setInterval(function(){
		let j;
		for (let i = 0; i < countParticipant; i++) {
			if(i%4==0){
				j = j+1;
			}
			if(i%2==0 && j%2==1){
				randomParticipant(i);
			} 
			if(i%2!=0 && j%2==1){
				hide(i);
			} 		
		}
	}, 800)

	hideOdd = setInterval(function(){
		let j;
		for (let i = 0; i < countParticipant; i++) {
			if(i%4==0){
				j = j+1;
			}
			if(i%2==0 && j%2!=1){
				randomParticipant(i);
			}
			if(i%2!=0 && j%2!=1){
				hide(i);
			}
		}
	}, 400)
	showOdd = setInterval(function(){
		let j;
		for (let i = 0; i < countParticipant; i++) {
			if(i%4==0){
				j = j+1;
			}
			if(i%2!=0 && j%2!=1){
				randomParticipant(i);
			}
			if(i%2==0 && j%2!=1){
				hide(i);
			}
		}
	}, 800)
}

function stop(){
	for (let i = 0; i < countParticipant; i++) {
		$("#part"+i).html(' ');
	}
}

// Bind
Mousetrap.bind({
    'enter': stop,
});

$(function() {
	if($('#drawing')[0]){
		start();
	} else{
		console.log('not found')
	}
});