@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Bài viết
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'articles.index' ) }}">Bài viết</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('articles.create') }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" method="GET" action="{{ route('articles.index') }}" id="searchForm">            
            <div class="form-group">
              <label for="email">Danh mục </label>
              <select class="form-control" name="cate_id" id="cate_id">
                <option value="">--Tất cả--</option>
                @if( $cateArr->count() > 0)
                  @foreach( $cateArr as $value )
                  <option value="{{ $value->id }}" {{ $value->id == $cate_id ? "selected" : "" }}>{{ $value->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>            
            <div class="form-group">
              <label for="email">Từ khóa :</label>
              <input type="text" class="form-control" name="title" value="{{ $title }}">
            </div>
            <button type="submit" class="btn btn-default btn-sm">Lọc</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value">{{ $items->total() }} bài viết )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
            {{ $items->appends( ['cate_id' => $cate_id, 'title' => $title] )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>              
              <th>Thumbnail</th>
              <th>Tiêu đề</th>
              <th width="1%;white-space:nowrap">Thao tác</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>       
                <td>
                  <img class="img-thumbnail" src="{{ Helper::showImage($item->image_url)}}" width="145">
                </td>        
                <td>                  
                  <a style="font-size:17px" href="{{ route( 'articles.edit', [ 'id' => $item->id ]) }}">{{ $item->title }}</a>
                  
                  @if( $item->is_hot == 1 )
                  <label class="label label-danger">HOT</label>
                  @endif
                  <div class="block-author">
                      <ul>
                        <li>
                          <span>Tác giả:</span>
                          <span class="name">{!! $item->createdUser->display_name !!}</span>
                        </li>
                        <li>
                            <span>Ngày tạo:</span>
                          <span class="name">{!! date('d/m/Y H:i', strtotime($item->created_at)) !!}</span>
                          
                        </li>
                         <li>
                            <span>Cập nhật:</span>
                          <span class="name">{!! $item->updatedUser->display_name !!} ( {!! date('d/m/Y H:i', strtotime($item->updated_at)) !!} )</span>          
                        </li>  
                        <li>
                          {!! Helper::view($item->id, 2) !!} lượt xem
                        </li>
                      </ul>
                    </div>
                  <p>{{ $item->description }}</p>
                </td>
                <td style="white-space:nowrap"> 
                  <a class="btn btn-default btn-sm" href="{{ route('news-detail', [$item->slug, $item->id ]) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>                 
                  <a href="{{ route( 'articles.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>                 
                  
                  <a onclick="return callDelete('{{ $item->title }}','{{ route( 'articles.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></a>
                  
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
          <div style="text-align:center">
            {{ $items->appends( ['cate_id' => $cate_id, 'title' => $title] )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<input type="hidden" id="table_name" value="articles">
@stop