@extends('layouts.admin_master')
@section('admin_main_content')
<!-- Content wrapper -->  
<div class="content-wrapper">
            <!-- Content -->

            <div class="container">
                <div class="card my-2" ">
                    <div class="card-header"><b>Update Book</b></div>
                    <div class="card-body">
                        <form action="{{ route('admin.books.update',$editData->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="my-2">
                                <input name="title" class="form-control " type="text" placeholder="Title" value="{{ $editData->title }}">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="my-2">
                                <input name="featured_img" class="form-control mt-4" type="file">
                                @error('featured_img')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <select name="category" id="" class=" form-control categorySelect  niceSelect mt-3">
                                        <option disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select name="subcategory" id="" class="form-control subcategorySelect mt-3" >
                                        <option disabled selected>Select Sub_Category</option>
                                        @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select name="author" id="" class="form-control  mt-3" >
                                        <option disabled selected>Select Author</option>
                                        @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endforeach
                                        
                                        
                                    </select>
                                </div>
                                <div class="my-2 mt-4" >
                                    <textarea  id="editor" name="content"  placeholder="Content Here......">{{ $editData->content }}</textarea>
                                    @error('featured_img')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3">Update Book</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- / Content -->

@push('additional_js')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    function getSubcategory(){
        $.ajax({
            url:`{{ route('admin.subcategory.get') }}`,
            method: 'get',
            data: {
                categoryId: $(this).val()
            },
            success: function(res){
                // Response Data array
                
                let options = []
                if(res.length > 0){
                    res.forEach(subcategory => {
                    
                    let optionTag = `<option value="${subcategory.id}">${subcategory.name}</option>`
                    options.push(optionTag)
                })
                $('.subcategorySelect').html(options)

                }else{
                    let optionTag = `<option disabled selected>No sub_category  found</option>`
                    $('.subcategorySelect').html(optionTag)
                }
                
            }
        })
    }
    $('.categorySelect').change(getSubcategory)
</script>

@endpush
@endsection