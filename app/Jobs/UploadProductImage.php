<?php

namespace App\Jobs;

use App\Models\ProductImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class UploadProductImage implements ShouldQueue
{
     use Queueable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $productName,
        public int $productId,
        public string $tmpPath,
        public int $position = 0,
        public bool $isPrimary = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('UploadProductImage 1'. now());
        if (!Storage::disk('local')->exists($this->tmpPath)) {
            return; 
        }

        // генеруємо фінальне ім’я з оригінальним розширенням
        $ext = strtolower(pathinfo($this->tmpPath, PATHINFO_EXTENSION) ?: 'jpg');
        $filename = $this->productId.'_'.$this->position.'_'.Str::uuid().'.'.$ext;

        Log::info($filename);
        Log::info($ext);
        Log::info($this->productId.'_'.$this->position.'.'.$ext);

        $originalRel = "products/original/{$filename}";
        Storage::disk('public')->put($originalRel, Storage::disk('local')->get($this->tmpPath));

        $sizes = [
            'small'  => 100,
            'medium' => 300,
            'large'  => 600,
        ];

        foreach ($sizes as $folder => $dim) {

            $img = Image::make(Storage::disk('public')->path($originalRel))
                        ->fit($dim, $dim)
                        ->encode($ext, 85);

            Storage::disk('public')->put("products/{$folder}/{$filename}", (string) $img);
        }

        // 3) Заносимо в БД один запис — зберігаємо саме basename (файл)
        ProductImage::create([
            'product_id' => $this->productId,
            'path'       => $filename,
            'position'   => $this->position,
            'is_primary' => $this->isPrimary,
        ]);

        // 4) Прибираємо тимчасовий файл
        Storage::disk('local')->delete($this->tmpPath);
    }
}
