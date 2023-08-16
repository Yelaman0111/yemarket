<?php

namespace App\Repositories;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function storeProduct(ProductRequest $request)
    {
        $product = new Product();
        $imageName = '';

        if ($image = $request->file('image')) {
            $imageName = time() . "." . $image->extension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image       =  $imageName;
        }

        $product->category_id       =  $request->category_id;
        $product->brand_id          =  $request->brand_id;
        $product->name              =  $request->name;
        $product->description       =  $request->description;
        $product->save();

        return $product;
    }

    public function getCompanyProducts($company_id)
    {
        return Product::whereHas('companiesProduct', function ($query) use ($company_id) {
            $query->where('approved',  '1');
            $query->where('company_id',  $company_id);
        })
            ->with(['companiesProduct' => function ($query) use ($company_id) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
                $query->where('company_id', $company_id);
                $query->with('company');
            }])
            ->paginate();
    }


    public function getCompanyAllProducts($company_id)
    {
        return Product::whereHas('companiesProduct', function ($query) use ($company_id) {
            $query->where('company_id',  $company_id);
        })
            ->with(['companiesProduct' => function ($query) use ($company_id) {
                $query->orderBy('price', 'asc');
                $query->where('company_id', $company_id);
            }])
            ->paginate();
    }

    public function getApprovedProductsWithoutCompanyProducts()
    {
        return Product::where('approved',  '1')->paginate();
    }

    public function searchProductOfCompany($search_text, $company_id)
    {
        return Product::where('name', 'like', '%' . $search_text . '%')
            ->whereHas('companiesProduct', function ($query) use ($company_id) {
                $query->where('company_id',  $company_id);
            })
            ->with(['companiesProduct' => function ($query) use ($company_id) {
                $query->orderBy('price', 'asc');
                $query->where('company_id', $company_id);
            }])
            ->paginate();
    }

    public function searchProductForConnect($search_text)
    {
        return Product::where('name', 'like', '%' . $search_text . '%')
            ->where('approved', '1')
            ->paginate();
    }

    public function getAllProducts()
    {
        return Product::with('brand', 'category')
            ->with(['companiesProduct' => function ($query) {
                $query->where('approved', 1);
                $query->orderBy('price', 'asc');
                $query->with('company');
            }])->paginate();
    }

    public function changeApprovedStatus($approved_status, $id)
    {
        $productCompany = Product::find($id);
        $productCompany->approved = $approved_status;
        $productCompany->save();

        return  $productCompany;
    }

    public function getProductsByCategory($category_id)
    {
        return Product::where('category_id', $category_id)->where('approved', '1')
            ->whereHas('companiesProduct', function ($query) {
                $query->where('approved', '1');
            })
            ->with(['companiesProduct' => function ($query) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
                $query->with(['company']);
            }])->paginate(10);
    }

    public function getProductsByBrand($brand_id)
    {
        return Product::where('brand_id', $brand_id)->where('approved', '1')
            ->whereHas('companiesProduct', function ($query) {
                $query->where('approved', '1');
            })
            ->with(['companiesProduct' => function ($query) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
                $query->with(['company']);
            }])
            ->paginate();
    }

    public function getProductsByCompany($company_id)
    {
        return Product::where('approved', '1')
            ->whereHas('companiesProduct', function ($query) use ($company_id) {
                $query->where('approved',  '1');
                $query->where('company_id',  $company_id);
            })
            ->with(['companiesProduct' => function ($query) use ($company_id) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
                $query->where('company_id', $company_id);
                $query->with('company');
            }])
            ->paginate();
    }

    public function searchProducts($search_text)
    {

        return Product::where('name', 'like', '%' . $search_text . '%')
            ->where('approved', '1')
            ->whereHas('companiesProduct', function ($query) {
                $query->where('approved', '1');
            })
            ->with(['companiesProduct' => function ($query) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
                $query->with(['company']);
            }])
            ->paginate();
    }

    public function getSpecificProduct($id)
    {
        return Product::where('approved', '1')
            ->where('id', $id)
            ->whereHas('companiesProduct', function ($query) {
                $query->where('approved', '1');
            })
            ->with(['companiesProduct.company', 'companiesProduct' => function ($query) {
                $query->orderBy('price', 'asc');
                $query->where('approved', '1');
            }])
            ->with('brand')
            ->with('category')
            ->get();
    }
}
