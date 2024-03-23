<?php

namespace Modules\Product\Admin;

use Modules\Admin\Ui\AdminTable;
use Modules\Product\Entities\Product;

class ProductTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = ['price', 'print_barcode'];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->editColumn('thumbnail', function ($product) {
                return view('admin::partials.table.image', [
                    'file' => $product->base_image,
                ]);
            })
            ->editColumn('price', function (Product $product) {
                return product_price_formatted($product, function ($price, $specialPrice) use ($product) {
                    if ($product->hasSpecialPrice()) {
                        return "<span class='m-r-5'>{$specialPrice}</span>
                            <del class='text-red'>{$price}</del>";
                    }

                    return "<span class='m-r-5'>{$price}</span>";
                });
            })
            ->addColumn('print_barcode', function (Product $product) {
                // Ensure you have a valid barcode value in your product
                if (!empty($product->barcode)) {
                    // Button that calls a JavaScript function 'printBarcode' with the product's barcode as argument
                    return "<button onclick=\"printBarcode('{$product->barcode}')\">P</button>";
                }
                return 'No Barcode'; // Placeholder text or action if no barcode is available
            });
    }
}
