@extends('layouts.app')

@section('title', 'Terms of Service - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 overflow-hidden flex items-center justify-center">
    <!-- Glow Background Effects -->
    <div class="absolute top-1/4 right-1/2 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-4xl bg-gray-900/60 backdrop-blur-xl border border-gray-800/80 rounded-3xl p-6 md:p-12 shadow-2xl shadow-cyan-950/20">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8 border-b border-gray-800/80 pb-6">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-500 to-cyan-400 flex items-center justify-center text-2xl shadow-lg shadow-cyan-500/20">
                📜
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-cyan-400">
                    Terms of Service
                </h1>
                <p class="text-xs text-cyan-400/80 mt-1 uppercase tracking-widest font-semibold">TesheAI Platform Guidelines</p>
            </div>
        </div>

        <p class="text-gray-300 text-base leading-relaxed mb-8 bg-gray-800/30 p-4 rounded-xl border border-gray-800/50">
            By using <span class="text-cyan-400 font-bold">TesheAI</span>, you agree to comply with and be bound by the following Terms and Conditions of service.
        </p>

        <!-- Cards Container -->
        <div class="space-y-5">
            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">01</span>
                    Use of Platform
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    All learning materials, code samples, and tutorials are provided for personal educational use only. Unauthorized distribution or copying is prohibited.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">02</span>
                    User Accounts
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    Users are responsible for keeping their login credentials secure and for all actions taking place within their account.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">03</span>
                    Service Updates
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    We reserve the right to add, modify, or remove educational content or website features at any time to improve the platform experience.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">04</span>
                    Contact Information
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    Questions about these Terms should be sent to: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-cyan-400 font-semibold underline hover:text-cyan-300 transition-colors">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
