<?php


namespace Webkul\Ecom\Service;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Webkul\Category\Models\Category;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Ecom\Repositories\EcomImportRepository;
use Webkul\Ecom\Traits\CategoryTrait;
use Webkul\Ecom\Traits\ErrorTrait;
use Webkul\Ecom\Traits\ProductsTrait;


abstract class CoreEcom
{
    use ErrorTrait;
    use CategoryTrait, ProductsTrait;

    /**
     * @var EcomImportRepository
     */
    protected $importRepository;

    protected $import = false;
    protected $export = false;
    protected $data;
    protected $dataType;

    /**
     * @var Collection
     */
    private Collection $collection;

    public function __construct()
    {
        $this->importRepository = app(EcomImportRepository::class);

    }

    protected function setType($type)
    {
        switch ($type) {
            case 'import':
                $this->import = true;
                break;

            case 'export':
                $this->export = true;
                break;
        }
    }

    protected function importRun()
    {
        switch ($this->dataType) {
            case 'goods':
                return $this->importProducts();
                break;

            case 'categories':
                return $this->importCategories();
                break;
        }

        $this->notDataType('import');
    }

    protected function exportRun()
    {
        switch ($this->dataType) {
            case 'goods':
                return $this->exportProducts();
                break;

            case 'categories':
                return $this->exportCategories();
                break;
        }

        $this->notDataType('export');
    }

}