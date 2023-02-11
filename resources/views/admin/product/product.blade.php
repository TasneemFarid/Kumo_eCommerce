@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('product') }}">Product</a>
        </li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
       @can('add_product')
       <div class="card">
        <div class="card-header">
            <h3>Add Product</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('product_store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <select name="category_id" id="" class="form-control category_id">
                            <option value="">--Select Category--</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <select name="subcategory_id" id="subcategory" class="form-control">
                            <option value="">--Select Subcategory--</option>
                            @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}">{{$subcategory->subcategory_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <select name="brand" id="" class="form-control">
                            <option value="">--Select Brand--</option>
                            @foreach ($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <input type="text" name="price" class="form-control" placeholder="Product Price">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <input type="text" name="discount" class="form-control" placeholder="Product Discount">
                    </div>
                    <div class="col-lg-12 mt-3">
                        <input type="text" name="short_desp" class="form-control" placeholder="Short Description">
                    </div>
                    <div class="col-lg-12 mt-3">
                        <textarea id="summernote" name="long_desp" class="form-control" placeholder="Long Description"></textarea>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label for="" class="form-label">Product Preview</label>
                        <input type="file" name="preview" class="form-control">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label for="" class="form-label">Product Thumbnails</label>
                        <input type="file" name="thumbnail[]" multiple class="form-control">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
       @endcan
    </div>
</div>
@endsection

@section('footer_script')
    <script>
        $('.category_id').change(function(){
            var category_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getSubcategory',
                data:{'category_id': category_id},
                success:function(data_from_method){
                    $('#subcategory').html(data_from_method);
                }
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection