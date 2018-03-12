<table class="table table-bordered" id="table-list-data">
    <tr>
        <th style="width: 1%">#</th>        
        <th>Ngày hẹn</th>
        <th>Ghi chú</th>        
    </tr>
    <tbody>
        @if( $items->count() > 0 )
        <?php $i = 0; ?>
        @foreach( $items as $item )
        <?php $i ++; ?>
        <tr id="row-{{ $item->id }}">
            <td><span class="order">{{ $i }}</span></td>
           
            <td>
                {{ date('d-m-Y', strtotime($item->ngay_hen)) }}
            </td>                                   
            <td>
                {{ $item->ghi_chu }}
            </td>            
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="9">Không có dữ liệu.</td>
        </tr>
        @endif
    </tbody>
</table>