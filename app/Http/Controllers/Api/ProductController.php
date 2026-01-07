<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);

        return ProductResource::collection($products);
    }

    public function show($id)
    {
        // Try finding by ID first, then by slug
        $product = Product::where('id', $id)
            ->orWhere('slug', $id)
            ->with('category')
            ->firstOrFail();

        return new ProductResource($product);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->handleImageUpload($request->file('image'));
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable', // Can be file or string (path)
        ]);

        // Validation for image if it's a file
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
        }

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $imagePath = $this->handleImageUpload($request->file('image'));
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Handle image upload and resizing to 500x500 using GD
     */
    private function handleImageUpload($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
        $tempPath = $file->getRealPath();
        
        // Target dimensions
        $targetWidth = 500;
        $targetHeight = 500;

        // Get original dimensions
        list($width, $height, $type) = getimagesize($tempPath);

        // Create image from source
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($tempPath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($tempPath);
                // Preserve transparency
                imagealphablending($source, true);
                imagesavealpha($source, true);
                break;
            default:
                return $file->store('products', 'public');
        }

        // Create target image
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        // Handle transparency for target if PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($target, false);
            imagesavealpha($target, true);
            $transparent = imagecolorallocatealpha($target, 255, 255, 255, 127);
            imagefilledrectangle($target, 0, 0, $targetWidth, $targetHeight, $transparent);
        }

        // Resize
        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        // Save to temporary buffer then to storage
        ob_start();
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($target, null, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($target);
                break;
        }
        $imageData = ob_get_clean();

        // Store using Laravel Storage
        $path = 'products/' . $filename;
        \Illuminate\Support\Facades\Storage::disk('public')->put($path, $imageData);

        // Cleanup
        imagedestroy($source);
        imagedestroy($target);

        return $path;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
