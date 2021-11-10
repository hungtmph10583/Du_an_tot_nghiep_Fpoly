<?php

namespace App\Imports;

use App\Models\Age;
use App\Models\Breed;
use App\Models\Category;
use App\Models\Coupons;
use App\Models\Gender;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProductImport implements ToModel, SkipsOnError, WithValidation, SkipsOnFailure
{
    use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $cate = Category::where('name', 'like', '%' . $row['category'] . '%')->first();
        $breed = Breed::where('name', 'like', '%' . $row['breed'] . '%')->first();
        $age = Age::where('age', 'like', '%' . $row['age'] . '%')->first();
        $gender = Gender::where('gender', 'like', '%' . $row['gender'] . '%')->first();
        $coupon = Coupons::where('code', 'like', '%' . $row['coupon'] . '%')->first();
        $user_id = Auth::id();
        $book = Product::create([
            'name' => $row['name'],
            'user_id' => $user_id,
            'category_id' => $cate['id'] ? $cate['id'] : '',
            'slug' => $row['slug'],
            'weight' => $row['weight'],
            'breed_id' => $breed['id'] ? $breed['id'] : '',
            'age_id' => $age['id'] ? $age['id'] : '',
            'gender_id' => $gender['id'] ? $gender['id'] : '',
            'price' => $row['price'],
            'coupon_id' => $coupon['id'] ? $coupon['id'] : '',
            'discount' => $row['discount'] ? $row['discount'] : '',
            'discount_type' => $row['discount_type'] ? $row['discount_type'] : '',
            'discount_start_date' => $row['discount_start_date'] ? $row['discount_start_date'] : '',
            'discount_end_date' => $row['discount_end_date'] ? $row['discount_end_date'] : '',
            'status' => $row['status'],
            'quantity' => $row['quantity'],
            'description' => $row['description'] ? $row['description'] : 'Chưa có thông tin'
        ]);
        return $book;
    }

    public function rules(): array
    {
        return [
            '*.name' => ['name', 'unique:products,name'],
            '*.slug' => ['slug', 'unique:products,slug']
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    }
}