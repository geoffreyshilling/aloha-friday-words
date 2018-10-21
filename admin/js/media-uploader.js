jQuery(document).ready(function($){
    var mediaUploader;
    $('#upload_image_button').click(function(e) {
      e.preventDefault();
        if (mediaUploader) {
        mediaUploader.open();
        return;
      }
      mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
        text: 'Choose Image'
      }, multiple: false });
      mediaUploader.on('select', function() {
        var attachment = mediaUploader.state().get('selection').first().toJSON();
        $('#default_featured_image').val(attachment.url);
        var div1 = document.getElementById('image-preview');
        div1.innerHTML = '<img src="' + attachment.url + '" width="400px">';
        $('#image-preview').val(attachment.url);
      });
      mediaUploader.open();
    });
  });