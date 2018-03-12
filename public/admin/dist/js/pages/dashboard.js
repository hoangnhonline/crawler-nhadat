var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);

function singleUpload(obj) {
    window.KCFinder = {};
    window.KCFinder.callBack = function(url) {
      console.log($('#app_url').val());
       $('#' + obj.data('set')).val(url);
        $('#' + obj.data('image')).attr('src', $('#app_url').val() + url);
       $('#' + 'thumbnail_' + obj.data('set')).attr('src', $('#app_url').val() + url);
        window.KCFinder = null;
    };
    window.open($('#url_open_kc_finder').val(), 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
}
function singleUploadFile() {
    window.KCFinder = {};
    window.KCFinder.callBack = function(url) {
    };
    window.open($('#url_open_kc_finder_files').val(), 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
}
function multiUpload() {
    window.KCFinder = {};
    window.KCFinder.callBackMultiple = function(files) {
        var strHtml = '';
        for (var i = 0; i < files.length; i++) {
             strHtml += '<div class="col-md-3">';

        strHtml += '<img class="img-thumbnail" src="' +  $('#app_url').val() + files[i]  + '" style="width:100%">';
         strHtml += '<div class="checkbox">';
         strHtml += '<input type="hidden" name="image_tmp_url[]" value="' + files[i]  + '">';
        
        strHtml += '<label><input type="radio" name="thumbnail_id" class="thumb" value="' + files[i]  + '"> &nbsp;  Ảnh đại diện </label>';
        strHtml += '<button class="btn btn-danger btn-sm remove-image" type="button" data-value="' +  $('#app_url').val() + files[i]  + '" data-id="" ><span class="glyphicon glyphicon-trash"></span></button></div></div>';      
        }
        $('#div-image').append(strHtml);
            if( $('#div-image input.thumb:checked').length == 0){
              $('#div-image input.thumb').eq(0).prop('checked', true);
            }
        window.KCFinder = null;
    };
      window.open($('#url_open_kc_finder').val(), 'kcfinder_multiple','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
}

$(document).ready(function(){

  "use strict";

  $(".select2").select2();
  $('#is_sale').change(function(){
    if($(this).prop('checked') == true){
      $('#price_sale, #sale_percent').addClass('req');
    }else{
      $('#price_sale, #sale_percent').val('').removeClass('req');
    }
  });
  $('.btnSingleUploadFile').click(function(){
    singleUploadFile();
  });
  if( $('form.productForm').length == 1 ){
    $('#btnSave').click(function(){
        var errReq = 0;
        $('#dataForm .req').each(function(){
          var obj = $(this);
          if(obj.val() == '' || obj.val() == '0'){
            errReq++;
            obj.addClass('error');
          }else{
            obj.removeClass('error');
          }
        });
        if(errReq > 0){          
         $('html, body').animate({
              scrollTop: $("#dataForm .req.error").eq(0).parents('div').offset().top
          }, 500);
          return false;
        }
        if( $('#div-image img.img-thumbnail').length == 0){
          if(confirm('Bạn chưa upload hình sản phẩm. Vẫn tiếp tục lưu ?')){
            return true;
          }else{
            $('html, body').animate({
                scrollTop: $("#dataForm").offset().top
            }, 500);
            $('a[href="#settings"]').click();            
             return false;
          }
        }

      });
  }

  $(document).on('click', '.remove-image', function(){
    if( confirm ("Bạn có chắc chắn không ?")){
      $(this).parents('.col-md-3').remove();
    }
  });
  $('#dataForm .req').blur(function(){    
      if($(this).val() != ''){
        $(this).removeClass('error');
      }else{
        $(this).addClass('error');
      }
    });
  $('.btnSingleUpload').click(function(){        
    singleUpload($(this));
  });
  $('.btnMultiUpload').click(function(){        
    multiUpload();
  });
  if($('#content').length == 1){
    CKEDITOR.replace('content');
  }
  $('#dataForm #name').change(function(){
       var name = $.trim( $(this).val() );         
        $.ajax({
          url: $('#route_get_slug').val(),
          type: "POST",
          async: false,      
          data: {
            str : name
          },              
          success: function (response) {
            if( response.str ){                  
              $('#dataForm #slug').val( response.str );
            }                
          }
        });         
    });
  $('#dataForm #title').change(function(){
       var name = $.trim( $(this).val() );         
        $.ajax({
          url: $('#route_get_slug').val(),
          type: "POST",
          async: false,      
          data: {
            str : name
          },              
          success: function (response) {
            if( response.str ){                  
              $('#dataForm #slug').val( response.str );
            }                
          }
        });         
    });

});
var toolbar = [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: ['Image', 'Bold', 'Italic', 'Underline', 'Subscript', 'Superscript', 'NumberedList', 'BulletedList', 'Link', 'Unlink' ] },                             
    { name: 'styles', items: [ 'Format' ] },
    { name: 'tools', items: [ 'Maximize' ] },                      
];