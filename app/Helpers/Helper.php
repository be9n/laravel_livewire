<?php

use App\Models\Content;
use App\Models\Product;
use App\Models\SectionType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function updateOrStore($request, $modelPath, $with_translation = 1)
{
    $modelName = getModelNameFromPath($modelPath);

//    $data = $request->request->all(); // Get only the sent data without other request parts

    if (!is_array($request))
        $request = $request->toArray();
    // Update

    if (@$request['id']) {
        $item = $modelPath::find($request['id']);
        if (!$item)
            return abort('404');

        if (isset($request['image'])) {
            deleteExistedImage($item->image, $modelName);
            $file_name = saveFile($request['image'], uploadFile . '/' . $modelName);
            $request['image'] = $file_name;
        }
    } // Store
    else {
        if (isset($request['image'])) {

            $file_name = saveFile($request['image'], uploadFile . '/' . $modelName);
            $request['image'] = $file_name;
        }
    }

    $item = $modelPath::updateOrCreate(['id' => @$request['id']], $request);

    if ($with_translation)
        $item->createTranslation($request);


    return $item;
}

//public function createTranslation($request)
//{
//
//    foreach (locales() as $key => $language) {
//        foreach ($this->translatedAttributes as $attribute) {
//            if (array_key_exists($attribute . '_' . $key, $request)) {
//                $this->{$attribute . ':' . $key} = $request[$attribute . '_' . $key];
//            }
//        }
//        $this->save();
//    }
//    return $this;
//}


function updateOrStoreSectionContent($request, $modelPath, $with_translation = 1)
{
    // $modelName = splitStr($modelPath);

    $data = $request->request->all(); // Get only the sent data without other request parts

    // Update
    if ($request->id) {
        $content = $modelPath::find($request->id);
        if (!$content)
            return abort('404');

        $path = $content->type->section->slug . '/' . $content->type->slug;

        if (isset($request->image)) {
            deleteExistedImage($content->image, $path);
            $file_name = saveFile($request->image, uploadFile . '/' . $path);
            $data['image'] = $file_name;
        }
        if (isset($request->video)) {
            $file_name = YoutubeID($request->video);
            $data['video'] = $file_name;
        }

        if (isset($request->file)) {
            deleteExistedImage($content->file, $path);
            $file_name = saveFile($request->file, uploadFile . '/' . $path);
            $data['file'] = $file_name;
        }
    } // Store
    else {

        $type = SectionType::where('slug', $request->type_slug)->select('section_id', 'slug')->first();
        if (!$type)
            return abort('404');

        $path = $type->section->slug . '/' . $type->slug;

        if (isset($request->image)) {
            $file_name = saveFile($request->image, uploadFile . '/' . $path);
            $data['image'] = $file_name;
        }

        if (isset($request->video)) {
            $file_name = YoutubeID($request->video);
            $data['video'] = $file_name;
        }
        if (isset($request->file)) {
            $file_name = saveFile($request->file, uploadFile . '/' . $path);
            $data['file'] = $file_name;
        }
    }
    $content = $modelPath::updateOrCreate(['id' => $request->id], $data);

    if ($with_translation)
        $content->createTranslation($request);

    return $content;
}

function getModelNameFromPath($modelPath)
{
    $arr = explode('\\', $modelPath);
    $totalElements = count($arr);
    return $arr[$totalElements - 1];
}

function saveFile($file, $folder)
{
    //save photo in images folder
    $file_extension = $file->getClientOriginalExtension();
    $file_name = random_int(100, 999999) . time() . '.' . $file_extension;
    $path = $folder;

    //$file->move($path, $file_name);
    $file->storeAs($path, $file_name);

    return $file_name;
}

function deleteExistedImage($oldImage, $modelName)
{
    $destination = getImageDeletePath($oldImage, $modelName);
    // $destination = uploadFile.'/' . $path . '/' . $oldImage;
    if (File::exists($destination)) {
        File::delete($destination);
    }
}

function locales()
{
    $arr = [];
    foreach (LaravelLocalization::getSupportedLocales() as $key => $value) {
        $arr[$key] = __('translate.' . $key);
    }
    return $arr;
}


function YoutubeID($url)
{
    if (strlen($url) > 11) {
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return $match[1];
        } else
            return false;
    }
    return $url;
}

function saveMultipleImages($images, $modelPath, $foreign_key, $obj_id)
{
    $imagesModelPath = $modelPath . 'Image';
    $modelName = getModelNameFromPath($modelPath);

    foreach ($images as $image) {
        $imageName = saveFile($image, uploadFile . '/' . $modelName);
        $imagesModelPath::create([
            'name' => $imageName,
            $foreign_key => $obj_id
        ]);
    }
}

function deleteMultipleImages($deleted_images_id, $modelPath)
{
    $imagesModelPath = $modelPath . 'Image';
    $modelName = getModelNameFromPath($modelPath);

    $image_ids = array();
    foreach ($deleted_images_id as $image_id) {
        array_push($image_ids, $image_id);
        $image = $imagesModelPath::find($image_id);
        $image->delete();
        deleteExistedImage($image->name, $modelName);
    }

    return $image_ids;
}

function getLatestProducts($number)
{

    $products = Product::select('id', 'slug', 'category_id')
        ->with([
            'translations' => function ($q) {
                $q->select('id', 'product_id', 'locale', 'name');
            },
            'category' => function ($q) {
                $q->select('id', 'slug');
            }
        ])->latest()
        ->take($number)->get()
        ->map(function ($product) {
            $product->thumbnail = $product->getThumbnail();
            return $product;
        });

    return $products;
}


// Get Section Type Content
function getContent($section, $type_conditions = null, $content_conditions = null, $latest = null, $take = null, $paginate = null)
{
    $query = Content::query()->
    where(function ($query) use ($content_conditions) {
        if ($content_conditions) {
            foreach (@$content_conditions as $condition) {
                $query->{$condition['operation']}($condition['key'], $condition['operator'], $condition['value']);
            }
        }
    })->
    whereHas('type', function ($query) use ($section, $type_conditions) {
        if ($type_conditions) {
            foreach ($type_conditions as $condition) {
                $query->{$condition['operation']}($condition['key'], $condition['operator'], $condition['value']);
            }
        }

        $query->whereHas('section', function ($query) use ($section) {
            $query->where('slug', $section);
        });
    });

    if ($latest)
        $query->latest();


    if ($paginate) {
        $data = $query->paginate($paginate);

        return $data;
    }

    if ($take)
        $query->take($take);

    $data = $query->get();

    return $data;
}

// Get Image Path
function getImagePath($item)
{
    $image_path = asset(uploadFile . '/' . @$item->type->section->slug . '/' . @$item->type->slug . '/' . @$item->image);

    return $image_path;
}

function collectionPaginate($collection, $paginateCount)
{
    $currentPage = request()->query('page', 1);
    $collection = new LengthAwarePaginator(
        $collection->forPage($currentPage, $paginateCount),
        $collection->count(),
        $paginateCount,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );
    return $collection;
}

function getSearchResults($modelPath, $conditions, $trans_conditions, $selects, $search_query)
{

    $select_arr = ['id', 'category_id', 'slug'];
    if ($selects) {
        array_push($select_arr, ...$selects);
    }

    $query = $modelPath::query()->
    where(function ($query) use ($conditions, $search_query) {
        if ($conditions) {
            foreach ($conditions as $condition) {
                $query->{$condition['operation']}($condition['key'], 'like', '%' . $search_query . '%');
            }
        }
    })
        ->whereHas('translations', function ($query) use ($trans_conditions, $search_query) {

            if ($trans_conditions) {
                foreach ($trans_conditions as $condition) {
                    $query->{$condition['operation']}($condition['key'], 'like', '%' . $search_query . '%');
                }
            }
        })
        ->select(...$select_arr)->latest();


    $result = $query->get();

    return $result;
}

function getParentsLoop($category, $arr = [])
{
    if ($category->parent) {
        array_unshift($arr, $category->parent);
        $arr = getParentsLoop($category->parent, $arr);
    }
    return $arr;
}

function getImageUrl($image, $modelName)
{
    $destination = Storage::disk(uploadFile)->path($modelName . '/' . $image);

    if ($image)
        $imageUrl = Storage::disk(uploadFile)->url($modelName . '/' . $image);
    else
        $imageUrl = Storage::disk(uploadFile)->url('defaultImage.jpg');

    return $imageUrl;
}

function getImageDeletePath($image, $modelName)
{
    return Storage::disk(uploadFile)->path($modelName . '/' . $image);
}
