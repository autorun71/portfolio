<?php


namespace Webkul\Ecom\Service;


use Rkf\EcomLaravel\Facades\EcomLaravel;
use Webkul\Category\Models\Category;
use Webkul\Product\Models\Product;

class Ecom extends CoreEcom
{


    public static function import()
    {
        $class = new self();
        $class->setType('import');

        return $class;
    }

    public static function export()
    {
        $class = new self();
        $class->setType('export');

        return $class;
    }

    public function categories()
    {
        $this->dataType = 'categories';

        if ($this->import) {
            $this->data = EcomLaravel::categories();
        } elseif ($this->export) {
            $this->data = Category::all();
        } else {
            $this->notType();
        }

        return $this;
    }

    public function products()
    {
        $this->dataType = 'goods';

        if ($this->import) {
            $this->data = EcomLaravel::goods();
        } elseif ($this->export) {
            $this->data = Product::all();
        } else {
            $this->notType();
        }


        return $this;
    }

    public function run()
    {
        if ($this->import) {
            return $this->importRun();
        } elseif ($this->export) {
            return $this->exportRun();
        }

        $this->notType();

    }


}