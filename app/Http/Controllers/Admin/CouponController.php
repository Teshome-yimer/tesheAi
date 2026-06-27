<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('course')->latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $courses = Course::where('is_published', true)->get();
        return view('admin.coupons.form', ['coupon' => new Coupon(), 'courses' => $courses]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCoupon($request);
        $data['code'] = strtoupper($request->code);
        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created!');
    }

    public function edit(Coupon $coupon)
    {
        $courses = Course::where('is_published', true)->get();
        return view('admin.coupons.form', compact('coupon', 'courses'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->validateCoupon($request));
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Coupon deleted!');
    }

    private function validateCoupon(Request $request): array
    {
        return $request->validate([
            'code'       => 'required|string|max:50',
            'type'       => 'required|in:percentage,fixed',
            'value'      => 'required|numeric|min:0',
            'course_id'  => 'nullable|exists:courses,id',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active'  => 'sometimes|boolean',
        ]);
    }
}
