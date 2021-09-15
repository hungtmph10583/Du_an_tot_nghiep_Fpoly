<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\BookGalleriesImport;
use App\Models\BookImport as ModelsBookImport;
use App\Models\Category;
use App\Models\Country;
use App\Models\ImageImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Throwable;

class BookImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cate = Category::where('name', 'like', '%' . $row['category'] . '%')->first();
        $country = Country::where('name', 'like', '%' . $row['country'] . '%')->first();
        $book = ModelsBookImport::create([
            'name' => $row['name'],
            'cate_id' => $cate['id'],
            'country_id' => $country['id'],
            'price' => $row['price'],
            'status' => $row['status'],
            'quantity' => $row['quantity'],
            'detail' => '123123'
        ]);
        return $book;
        // $spreadsheet = IOFactory::load(request()->file('file'));
        // $i = 0;
        // $myFile = "";
        // foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
        //     if ($drawing instanceof MemoryDrawing) {
        //         ob_start();
        //         call_user_func(
        //             $drawing->getRenderingFunction(),
        //             $drawing->getImageResource()
        //         );
        //         $imageContents = ob_get_contents();
        //         ob_end_clean();
        //         switch ($drawing->getMimeType()) {
        //             case MemoryDrawing::MIMETYPE_PNG:
        //                 $extension = 'png';
        //                 break;
        //             case MemoryDrawing::MIMETYPE_GIF:
        //                 $extension = 'gif';
        //                 break;
        //             case MemoryDrawing::MIMETYPE_JPEG:
        //                 $extension = 'jpg';
        //                 break;
        //         }
        //     } else {
        //         $zipReader = fopen($drawing->getPath(), 'r');
        //         $imageContents = '';
        //         while (!feof($zipReader)) {
        //             $imageContents .= fread($zipReader, 1024);
        //         }
        //         fclose($zipReader);
        //         $extension = $drawing->getExtension();
        //     }
        //     $myFileName = 'uploads/images/' . time() . ++$i . '.' . $extension;
        //     file_put_contents('storage/' . $myFileName, $imageContents);
        // }
        // $myl = rtrim($myFile, ',');
        // $myls = rtrim($myl);
        // $Myfile = explode(',', $myls);
    }
    public function onError(Throwable $e)
    {
    }
    public function rules(): array
    {
        return [];
    }
}