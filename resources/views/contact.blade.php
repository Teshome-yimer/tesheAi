@extends('layouts.app')

@section('title', 'Contact Us - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 overflow-hidden flex items-center justify-center">
    <!-- Glow Background Effects -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-cyan-500/15 to-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-2xl bg-gray-900/60 backdrop-blur-xl border border-gray-800/80 rounded-3xl p-8 md:p-12 shadow-2xl shadow-cyan-950/20 text-center">
        <!-- Animated Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-tr from-cyan-500 to-blue-600 text-3xl shadow-xl shadow-cyan-500/25 mb-6 hover:scale-105 transition-transform duration-300">
            ✉️
        </div>

        <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-100 to-cyan-400 mb-3">
            Get In Touch
        </h1>
        <p class="text-gray-400 text-sm max-w-md mx-auto mb-10 leading-relaxed">
            Have questions, need support, or want to collaborate? Reach out to us anytime!
        </p>

        <!-- Contact Info Cards -->
        <div class="grid sm:grid-cols-2 gap-4 text-left">
            <a href="mailto:tesheyimer86@gmail.com" class="group p-6 rounded-2xl bg-gray-800/30 border border-gray-800/80 hover:border-cyan-500/50 hover:bg-gray-800/60 transition-all duration-300 flex items-center space-x-4 shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-xl text-cyan-400 group-hover:scale-110 transition-transform">
                    📧
                </div>
                <div>
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Email Address</h2>
                    <span class="text-cyan-400 font-medium text-xs md:text-sm block mt-1 group-hover:underline">
                        tesheyimer86@gmail.com
                    </span>
                </div>
            </a>

            <div class="group p-6 rounded-2xl bg-gray-800/30 border border-gray-800/80 hover:border-cyan-500/50 hover:bg-gray-800/60 transition-all duration-300 flex items-center space-x-4 shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-xl text-blue-400 group-hover:scale-110 transition-transform">
                    📍
                </div>
                <div>
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Location</h2>
                    <p class="text-gray-200 font-medium text-sm mt-1">Dessie, Ethiopia</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
