<?php


namespace Webkul\Ecom\Traits;


use Illuminate\Support\Str;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;

trait CategoryTrait
{
    private function importCategories()
    {
        $arEcomId = array_map(fn($item) => $item['id'], $this->data['categories']);
        $this->collection = Category::select(['id', 'ecom_id'])->whereIn('ecom_id', $arEcomId)->get();
//        dd($this->collection);
        return array_map(function ($item) {
            $status = false;
            $type = false;
            $result = ["id" => $item['id'], "type" => &$type, "status" => &$status];
            $catByEcom = $this->getCatsByEcom($item);
            $category = $catByEcom->first();

            if (!empty($category)) {
                $type = 'update';
                $status = $this->categoryUpdate($category, $item);

                return $result;
            }
            $type = 'create';
            $model = new Category();
            $status = $this->categoryCreate($model, $item);
            $status = true;

            return $result;
        }, $this->data['categories']);
    }

    private function exportCategories()
    {
        return true;
    }

    private function getCatsByEcom($item)
    {
        return $this->collection->filter(function ($v) use ($item) {
            return $v->ecom_id == $item['id'];
        });
    }

    private function getParentCatsByEcom($item)
    {
        return $item['parentId'] ? $this->collection->filter(function ($v) use ($item) {
            return $v->ecom_id == $item['parentId'];
        })->first() : false;
    }

    private function categoryUpdate(Category $model, $item)
    {
        $transCollection = $model->translation()->get()->filter(fn ($item) => $item->locale == 'ru');
        $translation = $transCollection->first() ?: false;
        if (!$translation) {
            $translation = new CategoryTranslation();

            $translation->name = $item['name'];
            $translation->slug = Str::slug($item['name']);
            $translation->description = '<p></p>';
            $translation->category_id = $model->id;
            $translation->locale = 'ru';
            $translation->locale_id = null;
            $translation->url_path;

            $translation->save();
        };
        $parent = $this->getParentCatsByEcom($item);
        $parentId = 0;
        if ($parent) {
            $parentId = $parent->id;
        }

//        if ($parentId == 0 && $item['parentId'] != 0)
//            dd($item['parentId'], $parentId);
//        print_r($parentId);

        $model->parent_id = $parentId;
        $model->save();

        $translation->name = $item['name'];

        $translation->save();


        return $model->save();
    }

    private function categoryCreate(Category $model, $item)
    {

        $parent = $this->getParentCatsByEcom($item);
        $parentId = 0;
        if ($parent) {
            $parentId = $parent->id;
        }

        $model->position = 1;
        $model->image = null;
        $model->status = 1;
        $model->_lft = 1;
        $model->_rgt = 14;
        $model->parent_id = $parentId;
        $model->display_mode = 'products_and_description';
        $model->ecom_id = $item['id'];
        $model->save();

        $translation = new CategoryTranslation();

        $translation->name = $item['name'];
        $translation->slug = Str::slug($item['name']);
        $translation->description = '<p></p>';
        $translation->category_id = $model->id;
        $translation->locale = 'ru';
        $translation->locale_id = null;
        $translation->url_path;

        return $translation->save();
    }
}