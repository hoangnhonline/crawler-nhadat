@if($tienIchLists)
	<?php $i_ti = 0; ?>
	@foreach($tienIchLists as $ti)
	<?php $i_ti++; ?>
	<div class="col-md-4">
		<input type="checkbox" value="{{ $ti->id }}" name="tien_ich[]" id="tien_ich_{{ $i_ti }}"> 
		<label style="cursor:poiter;text-transform:uppercase; font-weight:normal" for="tien_ich_{{ $i_ti }}">{{ $ti->name }}</label>
	</div>
	@endforeach	
@else
<p>Chưa có tiện ích nào.</p>
@endif
<div class="clearfix"></div>