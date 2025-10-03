<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class DeleteProductImage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $deleteImagesIds,
        public int $productId,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = Product::findOrFail($this->productId);
        $toDelete = $product->images()->whereIn('id', $this->deleteImagesIds)->get();
        foreach ($toDelete as $img) {
            $file = $img->path; 
            Storage::disk('public')->delete([
                "products/original/{$file}",
                "products/small/{$file}",
                "products/medium/{$file}",
                "products/large/{$file}",
            ]);
            $img->delete();
        }

        if ($product->primaryImage()->doesntExist() && $product->images()->exists()) {
            $first = $product->images()->orderBy('position')->first();
            $first->update(['is_primary' => true]);
        }
    }
}
