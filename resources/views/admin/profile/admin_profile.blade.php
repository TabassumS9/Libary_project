@extends('layouts.admin_master')
@section('page_title', 'Admin - Profile')
@section('admin_main_content')



<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile Settings</h4>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Admin Profile</a>
                </li>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                <form enctype="multipart/form-data"action="{{ route('admin.profile.update') }}" method="post" >
                @csrf
                @method('put')
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ auth()->guard('admin')->user()->profile ? auth()->user()->guard('admin')->profile : env('DICEBEAR_LINK'). auth()->guard('admin')->user()->name }}"
                            alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                            <form action="">
                                <label for="upload" class="btn btn-outline-secondary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Select new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" hidden=""
                                        accept="image/png, image/jpeg"
                                        oninput="imageUploadPreview(event, 'uploadedAvatar')">
                                </label>
                                <button type="button" class="btn btn-primary mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Upload Photo</span>
                                </button>
                            </form>
    
                            <p class="text-muted mb-0"> Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>                           
                <hr class="my-0">
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="post" >
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"> name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{auth()->guard('admin')->user()->name }}" placeholder="Enter your name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email" 
                                value="{{auth()->guard('admin')->user()->email }}" placeholder="Enter your email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    {{-- <span class="input-group-text">BD (+880)</span> --}}
                                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" 
                                    value="{{auth()->guard('admin')->user()->phone }}" placeholder="+880 ">
                                    
                                </div>
                            </div>
                         
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" 
                                value="{{auth()->guard('admin')->user()->address }}"  placeholder="Address">
                                
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            
                        </div>
                      </form>
                    </form>
                </div>
            <!-- /Account -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">Change Password</h5>
            {{-- onsubmit="return false" --}}
            <div class="card-body">
                <form action=" {{ route('admin.profile.password.update') }} " id="formAccountSettings" method="POST" > 
                    @csrf
                    @method('PUT')  
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input class="form-control" type="text" id="current_password" name="password"
                                 autofocus="">
                            @error('password')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror    
                        </div>
                        <div class="mb-3 col-12">
                            <label for="new_password" class="form-label">New Password</label>
                            <input class="form-control" type="text" name="new_password" id="new_password">
                            @error('new_password')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror  
                        </div>
                        <div class="mb-3 col-12">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input class="form-control" type="text" name="new_password_confirmation"
                                id="password_confirmation" >
                                @error('new_password_confirmation')
                                <span class="text-danger d-block">{{ $message }}</span>
                            @enderror  
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>

</div>
@endsection
