@if( !empty( $rsUpload ))
	<?php $i = 0; ?>
	<ul>
	@foreach( $rsUpload as $tmp)
	<?php $i++; ?>
	<li>
		<div class="register-avata" style="background: url('{{ Helper::showImage($tmp['image_path']) }}') no-repeat scroll 0% 0%; background-color: transparent; background-size: 94px 94px;">
				<a href="javascript:void(0)" class="upload-item-delete remove-image" data-value="{{ $tmp['image_path'] }}"></a>
				<input type="hidden" name="image_tmp_url[]" value="{{ $tmp['image_path'] }}">
				<input type="hidden" name="image_tmp_name[]" value="{{ $tmp['image_name'] }}">
			    
			    <input style="display:none" type="radio" name="thumbnail_id" class="thumb" value="{{ $tmp['image_path'] }}" {{ $i == 1 ? "checked" : "" }} >	    
		</div>
	</li>
	@endforeach
	</ul>
@endif