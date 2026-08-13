@extends('layouts.app')

@section('title', 'Terms of Service - TesheAI')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-gray-900/80 border border-gray-800 rounded-2xl p-6 md:p-10 backdrop-blur-sm shadow-xl">
        <div class="flex items-center space-x-3 mb-6 border-b border-gray-800 pb-4">
            <span class="text-3xl">📜</span>
            <h1 class="text-2xl md:text-3xl font-bold text-white">Terms of Service</h1>
        </div>

        <p class="text-gray-300 leading-relaxed mb-8">
            By accessing or using <span class="text-cyan-400 font-semibold">TesheAI</span>, you agree to be bound by these Terms of Service.
        </p>

        <div class="space-y-6">
            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">1. Use of Platform</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    You agree to use our educational content for personal learning purposes only. Redistribution of course content without permission is strictly prohibited.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">2. User Accounts</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">3. Modifications</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    We reserve the right to modify or discontinue services or content at any time without prior notice.
                </p>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800">
                <h2 class="text-lg font-semibold text-cyan-400 mb-2">4. Contact Information</h2>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Questions about the Terms of Service should be sent to: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-cyan-400 underline font-medium hover:text-cyan-300">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
