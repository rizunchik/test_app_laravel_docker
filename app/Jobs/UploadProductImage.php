<?php

namespace App\Jobs;

use App\Models\ProductImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class UploadProductImage implements ShouldQueue
{
     use Queueable;

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

        if (!Storage::disk('local')->exists($this->tmpPath)) {
            return; 
        }

        $ext = strtolower(pathinfo($this->tmpPath, PATHINFO_EXTENSION) ?: 'jpg');
        $filename = $this->productId.'_'.$this->position.'_'.Str::uuid().'.'.$ext;

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

        ProductImage::create([
            'product_id' => $this->productId,
            'path'       => $filename,
            'position'   => $this->position,
            'is_primary' => $this->isPrimary,
        ]);

        Storage::disk('local')->delete($this->tmpPath);
    }
}
