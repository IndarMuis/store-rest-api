<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit');

        $show_product = $request->input('show_product');

        if ($id)
        {
            $productCategory = ProductCategory::with(['products'])->find($id);
            return ResponseFormatter::success(
                $productCategory,
                'Data kategori produk berhasil diambil'
            );
        }
        else
        {
            return ResponseFormatter::error(
                null,
                'Data ketegori produk tidak ada',
                404
            );
        }

        $productCategory = ProductCategory::query();

        if ($name)
        {
            $productCategory->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product)
        {
            $productCategory->with(['products']);
        }

        return ResponseFormatter::success(
            $productCategory->paginate($limit),
            'Data list kategori berhasil diambil'
        );
    }
}
