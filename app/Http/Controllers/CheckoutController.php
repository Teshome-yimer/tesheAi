<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(string $slug)
    {
        $course = Course::where('slug', $slug)->where('is_published', true)->firstOrFail();

        if (auth()->check() && auth()->user()->isEnrolledIn($course->id)) {
            return redirect()->route('student.course', $slug)->with('info', 'Already enrolled!');
        }

        return view('checkout', compact('course'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string', 'course_id' => 'required|integer']);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();
        $course = Course::find($request->course_id);

        if (!$course) return response()->json(['valid' => false, 'message' => 'Course not found']);
        if (!$coupon || !$coupon->isValid($course->id)) {
            return response()->json(['valid' => false, 'message' => 'ኮፖን ትክክለኛ አይደለም / Invalid coupon']);
        }

        $discountEtb = $coupon->calculateDiscount($course->price_etb);
        $discountUsd = $coupon->calculateDiscount($course->price_usd);

        return response()->json([
            'valid'          => true,
            'discount_etb'   => $discountEtb,
            'discount_usd'   => $discountUsd,
            'final_etb'      => max(0, $course->price_etb - $discountEtb),
            'final_usd'      => max(0, $course->price_usd - $discountUsd),
            'type'           => $coupon->type,
            'value'          => $coupon->value,
            'message'        => 'ኮፖን ተፈጻሚ ሆነ! / Coupon applied successfully!',
        ]);
    }
}
