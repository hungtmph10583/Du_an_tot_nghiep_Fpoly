<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\BookImport as ModelsBookImport;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BookImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $spreadsheet = IOFactory::load(request()->file('file'));
        $i = 0;
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else {
                if ($drawing->getPath()) {
                    // Check if the source is a URL or a file path
                    if ($drawing->getIsURL()) {
                        $imageContents = file_get_contents($drawing->getPath());
                        $filePath = tempnam(sys_get_temp_dir(), 'Drawing');
                        file_put_contents($filePath, $imageContents);
                        $mimeType = mime_content_type($filePath);
                        // You could use the below to find the extension from mime type.
                        // https://gist.github.com/alexcorvi/df8faecb59e86bee93411f6a7967df2c#gistcomment-2722664
                        $extension = File::mime2ext($mimeType);
                        unlink($filePath);
                    } else {
                        if ($drawing->getPath()) {
                            // Check if the source is a URL or a file path
                            if ($drawing->getIsUrl()) {
                                $imageContents = file_get_contents($drawing->getPath());
                                $filePath = tempnam(sys_get_temp_dir(), 'Drawing');
                                file_put_contents($filePath, $imageContents);
                                $mimeType = mime_content_type($filePath);
                                // You could use the below to find the extension from mime type.
                                // https://gist.github.com/alexcorvi/df8faecb59e86bee93411f6a7967df2c#gistcomment-2722664
                                $extension = File::mime2ext($mimeType);
                                unlink($filePath);
                            } else {
                                $zipReader = fopen($drawing->getPath(), 'r');
                                $imageContents = '';
                                while (!feof($zipReader)) {
                                    $imageContents .= fread($zipReader, 1024);
                                }
                                fclose($zipReader);
                                $extension = $drawing->getExtension();
                            }
                        }
                    }
                }
            }
            $myFileName = 'uploads/images/' . time() . ++$i . '.' . $extension;
            file_put_contents('storage/uploads/images/' . $myFileName, $imageContents);
            $book = ModelsBookImport::create([
                'name' => $row['name'],
                'cate_id' => $row['category'],
                'country_id' => $row['country'],
                'image' => $myFileName,
                'price' => $row['price'],
                'status' => $row['status'],
                'quantity' => $row['quantity'],
                'detail' => '123123'
            ]);
            return $book;
        }
    }
}