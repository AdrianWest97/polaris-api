<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
class ProductController extends Controller
{
    //create and update
    public function store(Request $request){
       // TODO::check image types
        $data = $this->validate($request,[
            'name' => ['required',"string"],
            'description' => ['required',"string"],
            'use_url' => ['nullable'],
            'image_url' => 'required_if:use_url,=,true','string',
            'stock' => ['required','integer'],
            'price' => ['required','numeric'],
            'tags' => ['nullable','string'],
            'category_id' => ['required','numeric'],
            'caption' => ['required','string'],
        ]);

        $id = intval($request->id);
        $use_url = $data["use_url"] == "true" ? true : false;

        $product = $id == 0 ? New Product : Product::findOrfail($id);
        $product->name = $data["name"];
        $product->description = $data["description"];
        $product->image_url = $data["image_url"];
        $product->stock = $data["stock"];
        $product->price = $data["price"];
        $product->tags = $data["tags"];
        $product->category_id = $data["category_id"];
        $product->caption = $data["caption"];
        $product->use_url = $use_url;
        $product->stock <=0
        ?
        $product->visible = false
         : '';
        $product->save();
        //if no image url, then check if it has a image
        if($request->hasFile("image")){
          try {
              $this->saveImage($product, $request->file("image"));
          } catch (Exception $e) {
              if($id == 0){
                  $product->delete();
              }
              throw $e;
          }
       }
        return Product::with(['image','category'])->findOrFail($product->id);
    }

    public function set_visibility(Request $request){
            $product = Product::findOrFail($request->id);
            $product->visible = !$product->visible;
            $product->Save();
            return $product->loadMissing(['image','category']);
    }
       public function set_featured(Request $request){
            $product = Product::findOrFail($request->id);
            $product->is_featured = !$product->is_featured;
            $product->Save();
            return $product->loadMissing(['image','category']);
    }


      public function saveImage(Product $product, $image){
            $this->delete_image($product); //delete existing image
            $destinationPath = 'products/';
            //create directory if not exits
            File::makeDirectory($destinationPath, 0777, true, true);
            $original  = time() . '.' . $image->getClientOriginalExtension();

            //TODO: Change public path to storag_path
            $original_path = public_path($destinationPath . $original);
            Image::make($image->getRealPath())->save($original_path);
            //save thumbnail
            $thumb  = time() . '_thumb.' . $image->getClientOriginalExtension();
            $thumb_path = public_path($destinationPath . $thumb);
            Image::make($image->getRealPath())
            ->resize(50,50,function($contraint){
                $contraint->aspectRatio();
            })
            ->save($thumb_path);
            $product->image()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    "original" => '/products/'.$original,
                    "thumbnail" => '/products/'.$thumb,
                ]
            );
            $product->use_url = false; //user uploads photo, so use image from device
            $product->save();
        }



    public function delete($id){
        $product = Product::findOrfail($id);
        //delete images
        try{
            $this->delete_image($product);
        }catch(Exception $e){
            return response("unable to delete", 422);
        }
            return $product->delete();
        }


    public function delete_image(Product $product){
             if($product->image){
              $image = $product->image;
                //delete image from public/products
                $original = public_path($image->original);
                $thumb = public_path($image->thumbnail);
                File::delete($original, $thumb); //public/products/test.jpg
        }
    }

    public function all(){
        return response(['products' => Product::orderBy("created_at","desc")
        ->get()->loadmissing(['category','image'])],200);
    }

    public function get($id){
        return Product::with(['category','image'])->findOrFail($id);
    }
}
