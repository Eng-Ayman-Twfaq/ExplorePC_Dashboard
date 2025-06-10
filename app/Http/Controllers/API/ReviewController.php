<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
   /**
     * عرض جميع التقييمات لمنتج معين
     */
    public function getReviewsByProductId($productId)
    {
        $reviews = Review::with(['user', 'product'])
                        ->where('productId', $productId)
                        ->get();

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    /**
     * إضافة تقييم جديد
     */
    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|exists:products,productId',
            'UserId' => 'required|exists:customs,UserId',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $review = Review::create([
            'productId' => $request->productId,
            'UserId' => $request->UserId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => $review
        ], 201);
    }

    /**
     * عرض تقييم معين
     */
    public function show($id)
    {
        $review = Review::with(['user', 'product'])->find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    /**
     * تحديث تقييم
     */
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|numeric|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    /**
     * حذف تقييم
     */
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found'
            ], 404);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * الحصول على تقييمات منتجات التاجر
     *
     * @param int $merchantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMerchantProductReviews($merchantId)
    {
        // التحقق من وجود التاجر
        $merchant = Merchant::find($merchantId);
        
        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'التاجر غير موجود'
            ], 404);
        }

        // الحصول على تقييمات منتجات التاجر مع معلومات المستخدم والمنتج
        $reviews = Review::with(['user', 'product'])
            ->whereHas('product', function($query) use ($merchantId) {
                $query->where('MerchantId', $merchantId);
            })
            ->orderBy('date', 'desc')
            ->get()
            ->map(function($review) {
                return [
                    'user' => $review->user->UserName, // رقم هاتف المستخدم
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'date' => $review->date,
                    'product' => $review->product->name,
                    'product_id' => $review->product->productId
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'merchant_name' => $merchant->storename
        ]);
    }

    /**
     * تصفية تقييمات منتجات التاجر حسب المنتج والتاريخ
     *
     * @param Request $request
     * @param int $merchantId
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterMerchantReviews(Request $request, $merchantId)
    {
        $merchant = Merchant::find($merchantId);
        
        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'التاجر غير موجود'
            ], 404);
        }

        $query = Review::with(['user', 'product'])
            ->whereHas('product', function($query) use ($merchantId) {
                $query->where('MerchantId', $merchantId);
            });

        // تصفية حسب المنتج
        if ($request->has('product_id') && $request->product_id != 'all') {
            $query->where('productId', $request->product_id);
        }

        // تصفية حسب الترتيب الزمني
        if ($request->has('sort_by')) {
            $query->orderBy('date', $request->sort_by == 'الأحدث' ? 'desc' : 'asc');
        } else {
            $query->orderBy('date', 'desc');
        }

        $reviews = $query->get()
            ->map(function($review) {
                return [
                    'user' => $review->user->Phone,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'date' => $review->date,
                    'product' => $review->product->name,
                    'product_id' => $review->product->productId
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }
}
