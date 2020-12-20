<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function products() {
      return $this->hasMany('App\Product', 'categoryId');
    }

    public function parent() {
    	if ( $category = Category::find($this->parentId) ) {
    		return $category->name;
    	}else{
    		return '-';
    	}
    }

    public function children() {
       $parentId = $this->id;
       $children = Category::where('parentId', $parentId)->get();
       if ( count($children) ) {
           return $children;
       }
       return false;
    }

}
