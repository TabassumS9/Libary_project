<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Helpers\MyHelpers;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    use MyHelpers;
    function addBooks(){
        $categories = Category::latest()->get();
        $subCategories = Subcategory::latest()->get();
        $authors = Author::latest()->get();
        return view('admin.books.addBook',compact('categories','subCategories','authors'));
    }
    function storeBook(Request $request){
        $request->validate([
            'title'=>'required',
            'featured_img'=>'required',
            'content'=>'required',
        ]);

        if($request->hasFile('featured_img')){
            $image = $this->ImageUplode($request->featured_img, 'Books');
        }
        
        $book = new Book();

        $book->title = $request->title;
        $book->slug = $this->slug_Generator($request->title, Book::class);
        $book->author_id = $request->author;
        $book->category_id = $request->category;
        $book->subcategory_id = $request->subcategory;
        $book->featured_img = $image;
        $book->content = $request->content;
        $book->save();
        return back();
    }
    function allBooks(){
        $categories = Category::latest()->get();
        $subCategories = Subcategory::latest()->get();
        $authors = Author::latest()->get();
        $books = Book::with(['author:id,name','category:id,name'])->paginate(5);
        return view('admin.books.allBook',compact('books','categories','subCategories','authors'));
    }
    public function change_status(Request $request){
        $book = Book::find($request->id);
        if($book->status){
            $book->status = false;
        }else{
            $book->status = true;
        }
        $book->save();

    }
    Public function edit($id){
        $categories = Category::latest()->get();
        $subCategories = Subcategory::latest()->get();
        $authors = Author::latest()->get();
        $editData = Book::find($id, ['id','title','content','category_id','subcategory_id','author_id']);
        return view('admin.books.edit',compact('editData','categories','subCategories','authors'));
        }
        public function update(Request $request, $id){
            $request->validate([
                'title'=>'required',
                'featured_img'=>'required',
                'content'=>'required',
            ]);
            if($request->hasFile('featured_img')){
                $image = $this->ImageUplode($request->featured_img, 'Books');
            }
    
            $book = Book::find($id);
    
            $book->title = $request->title;
            $book->slug = $this->slug_Generator($request->title, Book::class);
            $book->author_id = $request->author;
            $book->category_id = $request->category;
            $book->subcategory_id = $request->subcategory;
            $book->featured_img = $image;
            $book->content = $request->content;
            $book->save();
            alert()->success('Update','Author update successfully');
            return back();
        }
        Public function delete($id){
            $book = Book::find($id);
            $book->delete();
            return back();
        }
    
}
