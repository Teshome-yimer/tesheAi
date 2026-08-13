@extends('layouts.app')

@section('title', 'Privacy Policy - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 overflow-hidden flex items-center justify-center">
    <!-- Glow Background Effects -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-4xl bg-gray-900/60 backdrop-blur-xl border border-gray-800/80 rounded-3xl p-6 md:p-12 shadow-2xl shadow-cyan-950/20">
        <!-- Header -->
        <div class="flex items-center space-x-4 mb-8 border-b border-gray-800/80 pb-6">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center text-2xl shadow-lg shadow-cyan-500/20 animate-pulse">
                🔒
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-cyan-400">
                    Privacy Policy
                </h1>
                <p class="text-xs text-cyan-400/80 mt-1 uppercase tracking-widest font-semibold">TesheAI Legal Center</p>
            </div>
        </div>

        <p class="text-gray-300 text-base leading-relaxed mb-8 bg-gray-800/30 p-4 rounded-xl border border-gray-800/50">
            Welcome to <span class="text-cyan-400 font-bold">TesheAI</span>. We value your privacy and are fully committed to protecting your personal data and ensuring a safe learning environment.
        </p>

        <!-- Cards Container -->
        <div class="space-y-5">
            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300 shadow-sm hover:shadow-cyan-500/5">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">01</span>
                    Information We Collect
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    We collect information you provide directly to us when you create an account, enroll in courses, or contact us for technical support.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300 shadow-sm hover:shadow-cyan-500/5">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">02</span>
                    How We Use Your Information
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    We use your information strictly to deliver, improve, and personalize our educational services, manage user access, and send essential platform updates.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300 shadow-sm hover:shadow-cyan-500/5">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">03</span>
                    Cookies and Advertising
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    We may use cookies and third-party advertising partners like Google AdSense to serve relevant ads based on user interactions across the web.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-800/20 border border-gray-800/80 hover:border-cyan-500/40 hover:bg-gray-800/40 transition-all duration-300 shadow-sm hover:shadow-cyan-500/5">
                <h2 class="text-lg font-bold text-cyan-400 group-hover:text-cyan-300 flex items-center gap-2 mb-2">
                    <span class="text-sm px-2 py-0.5 rounded-full bg-cyan-500/10 border border-cyan-500/20">04</span>
                    Contact Us
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed pl-9">
                    If you have questions regarding this Privacy Policy, please reach us directly at: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-cyan-400 font-semibold underline hover:text-cyan-300 transition-colors">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
