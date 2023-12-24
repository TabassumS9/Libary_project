@extends('layouts.admin_master')
@section('admin_main_content')
@stack('additional_css')
    <style>
         .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 50px;
            }
    </style>
<div class="row">

        <div class="col-lg-12">
            <div class="card-style mb-30">
                <div class="card">
                    <div class="card-header"><b>All Books List</b></div>
                    <div class="table-responsive text-nowrap">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>image</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @forelse($books as $key=> $book)
                        <tr>
                            <td>{{ $books->firstItem()+$key }}</td>
                            <td class="min-width">
                                <img class="img-thumbnail" src="{{ asset('storage/Books/'.$book->featured_img)  }}" alt="" width="50">
                            </td>
                            <td>{{ $book->category->name }}</td>
                            <td>{{ $book->author->name }}</td>
                            <td>
                                <div class="form-check form-switch toggle-switch">
                                    <input class="form-check-input change_status" type="checkbox" id="toggleSwitch2" {{ $book->status  ? "checked":"" }} data-book-id="{{ $book->id }}">
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.books.edit',$book->id ) }}" class="btn btn-sm btn-info btn-hober">
                                    <i class='bx bxs-edit-alt'></i>
                                </a>
                                <button class="btn btn-sm btn-danger btn-hober delete_btn">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <form action="{{ route('admin.books.delete',$book->id ) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-danger" style="width: 100%;">
                            <strong>No data found!</strong>
                            </td>
                        </tr>
                        @endforelse
                    </table>
                    <div>
                        {{$books->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@push('additional_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
        const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
         });
         $('.delete_btn').on('click', function(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
           $(this).next('form').submit();
        }
        });
    })

        $('.change_status').on('change', function(){
            $.ajax({
                url: "{{ route('admin.books.change_status') }}",
                method: "GET",
                data:{
                    id: $(this).data('book-id')
                },
                success:function(res){
                    Toast.fire({
                        icon: "success",
                        title: "Status change successfully"
                    });
                }
            })
        })

</script>
@endpush
@endsection