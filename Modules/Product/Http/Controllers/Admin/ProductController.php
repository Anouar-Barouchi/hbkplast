<?php

namespace Modules\Product\Http\Controllers\Admin;

use Modules\Product\Entities\Product;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Product\Http\Requests\SaveProductRequest;
use PDF;
use DNS1D;
use Illuminate\Http\Request;


class ProductController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'product::products.product';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'product::admin.products';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveProductRequest::class;


    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                // ->orWhere('ref', 'LIKE', '%' . request('search.value') . '%')
                // ->orWhere('barcode', 'LIKE', '%' . request('search.value') . '%')
                ->limit($request->get('limit', 10))
                ->get();
        }
        
        if ($request->has('table')) {
            return $request->all();
            return $this->getModel()->table($request);
        }

        return view("{$this->viewPath}.index");
    }


    public function printBarcode(Product $product)
    {
        $barcodeHTML = DNS1D::getBarcodeHTML($product->barcode, 'C128');
        
        // Load view with barcode HTML passed as a variable
        $pdf = PDF::loadView('public.products.barcode', compact('barcodeHTML', 'product'));
        
        // Return the PDF stream
        return $pdf->stream('barcode.pdf');
    }
}


