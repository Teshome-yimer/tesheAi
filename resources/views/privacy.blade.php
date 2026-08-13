@extends('layouts.app')

@section('title', 'Privacy Policy - TesheAI')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-gray-900/80 border border-gray-800 rounded-2xl p-6 md:p-10 backdrop-blur-sm shadow-xl">
        <div class="flex items-center space-x-3 mb-6 border-b border-gray-800 pb-4">
            <span class="text-3xl">🔒</span>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Privacy Policy</h1>
        </div>

        <p class="text-gray-300 leading-relaxed mb-8">
            Welcome to <span class="text-cyan-400 font-semibold">TesheAI</span>. We respect your privacy and are fully committed to protecting your personal data.
        </p>

        <div class="space-y-6">
            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">1. Information We Collect</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    We collect information you provide directly to us when you create an account, enroll in courses, or contact us for support.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">2. How We Use Your Information</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    We use your information to provide, maintain, and improve our educational services, communicate with you, and personalize your learning experience.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">3. Cookies and Advertising</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    We may use cookies and similar technologies, including third-party vendor cookies like Google AdSense, to serve ads based on your visit to our website and other websites.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">4. Contact Us</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    If you have any questions about this Privacy Policy, please reach out to us at: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-cyan-400 underline font-medium hover:text-cyan-300">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
