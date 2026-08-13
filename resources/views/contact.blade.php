@extends('layouts.app')

@section('title', 'Contact Us - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 flex items-center justify-center overflow-hidden bg-gray-950">
    <!-- Golden Background Glow Effects -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-gradient-to-tr from-amber-500/25 via-yellow-500/15 to-transparent rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Centered Golden Card -->
    <div class="relative w-full max-w-2xl bg-gray-900/90 backdrop-blur-2xl border-2 border-amber-500/40 rounded-3xl p-8 md:p-12 shadow-[0_0_50px_rgba(245,158,11,0.15)] text-center">
        
        <!-- Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-yellow-400 via-amber-500 to-amber-700 text-3xl shadow-xl shadow-amber-500/30 mb-6 hover:scale-105 transition-transform duration-300">
            ✉️
        </div>

        <h1 class="text-3xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-amber-400 to-yellow-500 mb-3">
            Get In Touch
        </h1>
        <p class="text-amber-100/80 text-sm max-w-md mx-auto mb-10 leading-relaxed">
            Have questions, need support, or want to collaborate? Reach out to us anytime!
        </p>

        <!-- Contact Cards -->
        <div class="grid sm:grid-cols-2 gap-5 text-left">
            <a href="mailto:tesheyimer86@gmail.com" class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/30 hover:border-yellow-400 hover:bg-gray-950 transition-all duration-300 flex items-center space-x-4 shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-2xl text-yellow-400">
                    📧
                </div>
                <div>
                    <h2 class="text-xs font-black text-amber-400 uppercase tracking-widest">Email Address</h2>
                    <span class="text-yellow-200 font-bold text-xs md:text-sm block mt-1 group-hover:underline">
                        tesheyimer86@gmail.com
                    </span>
                </div>
            </a>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/30 hover:border-yellow-400 hover:bg-gray-950 transition-all duration-300 flex items-center space-x-4 shadow-lg hover:-translate-y-1">
                <div class="w-12 h-12 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-2xl text-yellow-400">
                    📍
                </div>
                <div>
                    <h2 class="text-xs font-black text-amber-400 uppercase tracking-widest">Location</h2>
                    <p class="text-yellow-100 font-bold text-sm mt-1">Dessie, Ethiopia</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
