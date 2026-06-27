<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Order;
use App\Models\User;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;

class EnrollmentService
{
    public function completePurchase(Order $order): Enrollment
    {
        // Mark order paid
        $order->update(['status' => 'paid']);

        // Create or retrieve enrollment
        $enrollment = Enrollment::firstOrCreate(
            ['user_id' => $order->user_id, 'course_id' => $order->course_id],
            ['enrolled_at' => now()]
        );

        // Increment coupon usage
        if ($order->coupon_code) {
            Coupon::where('code', $order->coupon_code)->increment('used_count');
        }

        // Send confirmation email
        try {
            Mail::to($order->user->email)->send(new EnrollmentConfirmation($order));
        } catch (\Exception $e) {
            \Log::warning('Could not send enrollment email: ' . $e->getMessage());
        }

        return $enrollment;
    }

    public function applyCoupon(string $code, int $courseId, float $originalPrice): array
    {
        $coupon = Coupon::where('code', strtoupper($code))->first();

        if (!$coupon || !$coupon->isValid($courseId)) {
            return ['valid' => false, 'message' => 'ኮፖን ትክክለኛ አይደለም / Invalid coupon'];
        }

        $discount = $coupon->calculateDiscount($originalPrice);
        $finalPrice = max(0, $originalPrice - $discount);

        return [
            'valid'       => true,
            'discount'    => $discount,
            'final_price' => $finalPrice,
            'type'        => $coupon->type,
            'value'       => $coupon->value,
            'message'     => 'ኮፖን ተፈጻሚ ሆነ! / Coupon applied!',
        ];
    }

    public function getCourseProgress(int $userId, int $courseId): array
    {
        $course = Course::with('lessons')->find($courseId);
        if (!$course) return ['percentage' => 0, 'completed' => 0, 'total' => 0];

        $total = $course->lessons->count();
        if ($total === 0) return ['percentage' => 0, 'completed' => 0, 'total' => 0];

        $completed = LessonProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->count();

        return [
            'percentage' => (int) round(($completed / $total) * 100),
            'completed'  => $completed,
            'total'      => $total,
        ];
    }
}
