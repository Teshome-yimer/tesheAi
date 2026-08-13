@extends('layouts.app')

@section('title', 'Privacy Policy - TesheAI')

@section('content')
<div class="relative min-h-screen py-16 px-4 flex items-center justify-center overflow-hidden bg-gray-950">
    <!-- Golden Background Glow Effects -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-tr from-amber-500/20 via-yellow-500/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-amber-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Centered Golden Card (ሴንትሬግ ሳጥን) -->
    <div class="relative w-full max-w-4xl bg-gray-900/90 backdrop-blur-2xl border-2 border-amber-500/40 rounded-3xl p-8 md:p-14 shadow-[0_0_50px_rgba(245,158,11,0.15)]">
        
        <!-- Header -->
        <div class="flex items-center space-x-5 mb-10 border-b border-amber-500/30 pb-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 via-amber-500 to-amber-700 flex items-center justify-center text-3xl shadow-lg shadow-amber-500/30">
                🔒
            </div>
            <div>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-amber-400 to-yellow-500">
                    Privacy Policy
                </h1>
                <p class="text-xs text-amber-400/90 mt-1 uppercase tracking-widest font-bold">TesheAI Legal Center</p>
            </div>
        </div>

        <p class="text-amber-100/90 text-base leading-relaxed mb-8 bg-amber-950/30 p-5 rounded-2xl border border-amber-500/30">
            Welcome to <span class="text-yellow-400 font-extrabold">TesheAI</span>. We value your privacy and are fully committed to protecting your personal data in a secure environment.
        </p>

        <!-- Content Cards Inside Container -->
        <div class="space-y-6">
            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md hover:shadow-amber-500/10">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">01</span>
                    Information We Collect
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10 font-normal">
                    We collect information you provide directly to us when you create an account, enroll in courses, or contact us for technical support.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md hover:shadow-amber-500/10">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">02</span>
                    How We Use Your Information
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10 font-normal">
                    We use your information strictly to deliver, improve, and personalize our educational services, manage user access, and send essential platform updates.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md hover:shadow-amber-500/10">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">03</span>
                    Cookies and Advertising
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10 font-normal">
                    We may use cookies and third-party advertising partners like Google AdSense to serve relevant ads based on user interactions across the web.
                </p>
            </div>

            <div class="group p-6 rounded-2xl bg-gray-950/60 border border-amber-500/20 hover:border-yellow-400/60 transition-all duration-300 shadow-md hover:shadow-amber-500/10">
                <h2 class="text-xl font-bold text-yellow-400 flex items-center gap-3 mb-2 tracking-wide">
                    <span class="text-xs px-2.5 py-1 rounded-lg bg-amber-500/20 text-yellow-300 border border-amber-500/40 font-black">04</span>
                    Contact Us
                </h2>
                <p class="text-amber-100/80 text-sm leading-relaxed pl-10 font-normal">
                    If you have questions regarding this Privacy Policy, please reach us directly at: 
                    <a href="mailto:tesheyimer86@gmail.com" class="text-yellow-400 font-bold underline hover:text-yellow-300 transition-colors">tesheyimer86@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
