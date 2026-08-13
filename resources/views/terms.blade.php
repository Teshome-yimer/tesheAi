@extends('layouts.app')

@section('title', 'Terms of Service - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 flex items-center justify-center overflow-hidden bg-gray-950">
    <!-- Golden Background Glow Effects -->
    <div class="absolute top-1/4 right-1/2 translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-amber-500/20 via-yellow-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Centered Golden Card -->
    <div class="relative w-full max-w-4xl bg-gray-900/90 backdrop-blur-2xl border-2 border-amber-500/40 rounded-3xl p-8 md:p-14 shadow-[0_0_50px_rgba(245,158,11,0.15)]">
        
        <!-- Header -->
        <div class="flex items-center space-x-5 mb-10 border-b border-amber-500/30 pb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 via-amber-500 to-amber-700 flex items-center justify-center text-3xl shadow-lg shadow-amber-500/30">
                📜
            </div>
            <div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-amber-400 to-yellow-500">
                    Terms of Service
                </h1>
                <p class="text-xs text-amber-400/90 mt-1 uppercase tracking-widest font-bold">TesheAI Platform Guidelines</p>
            </div>
        </div>

        <p class="text-amber-100/90 text-base leading-relaxed mb-8 bg-amber-950/30 p-5 rounded-2xl border border-amber-500/30">
            By using <span class="text-yellow-400 font-extrabold">TesheAI</span>, you agree to comply with and be bound by the following Terms and Conditions of service.
        </p>

        <!-- Content Cards -->
        <div class="space-y-6">
            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">01</span>
                    Use of Platform
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10">
                    All learning materials, code samples, and tutorials are provided for personal educational use only. Unauthorized distribution is strictly prohibited.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">02</span>
                    User Accounts
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10">
                    Users are responsible for keeping their login credentials secure and for all actions taking place within their account.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">03</span>
                    Service Updates
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10">
                    We reserve the right to add, modify, or remove educational content or website features at any time to improve the platform experience.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">04</span>
                    Contact Information
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10">
                    Questions about these Terms should be sent to: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-yellow-400 font-bold underline hover:text-yellow-300 transition-colors">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
