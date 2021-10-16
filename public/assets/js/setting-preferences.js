// Preview text color and button
$('#global-text-color').change(function(){
    $('#preview-global-text-color').css('color', $(this).val());
}); 

$('#hr-color').change(function(){
    $('#preview-hr-color').css('border-top', '3.5px solid '+$(this).val());
}); 

$('#button-text-color').change(function(){
    $('#preview-button-text-color').css('color', $(this).val());
    $('#preview-button').css('color', $(this).val());
}); 

$('#button-shadow-color').change(function(){
    $('#preview-button-shadow-color').css('color', $(this).val());
    $('#preview-button').css('box-shadow', '0 7px 10px 0 '+$(this).val());
}); 

$('#button-background-color').change(function(){
    $('#preview-button-background-color').css('color', $(this).val());
    $('#preview-button').css('background-color', $(this).val());
}); 

$('#button-border-color').change(function(){
    $('#preview-button').css('border', '1px solid '+$(this).val());
}); 


// Preview Image
function readURL(input, location) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(location).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
  } else {
        alert('Select a file to see preview');
        $(location).attr('src', '');
  }
}

$("#background-new-draw").change(function() {
    readURL(this, '#preview-background-new-draw');
});

$("#background-recent-draw").change(function() {
    readURL(this, '#preview-background-recent-draw');
});

$("#background-draw-history").change(function() {
    readURL(this, '#preview-background-draw-history');
});

$("#button-image").change(function() {
    readURL(this, '#preview-button-image');
});