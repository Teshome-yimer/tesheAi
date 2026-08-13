@extends('layouts.app')

@section('title', 'Contact Us - TesheAI')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-gray-900/80 border border-gray-800 rounded-2xl p-6 md:p-10 backdrop-blur-sm shadow-xl text-center">
        <div class="inline-flex p-3 bg-cyan-500/10 rounded-full mb-4 border border-cyan-500/20">
            <span class="text-3xl">✉️</span>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Contact Us</h1>
        <p class="text-gray-400 text-sm mb-8 max-w-md mx-auto">
            Have questions, feedback, or need help with a course? Feel free to reach out to us!
        </p>

        <div class="grid md:grid-cols-2 gap-4 text-left">
            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800 flex items-start space-x-4">
                <span class="text-2xl">📧</span>
                <div>
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Email Address</h2>
                    <a href="mailto:tesheyimer86@gmail.com" class="text-cyan-400 font-medium hover:underline text-sm block mt-1">
                        tesheyimer86@gmail.com
                    </a>
                </div>
            </div>

            <div class="bg-gray-800/40 p-5 rounded-xl border border-gray-800 flex items-start space-x-4">
                <span class="text-2xl">📍</span>
                <div>
                    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Location</h2>
                    <p class="text-gray-200 font-medium text-sm mt-1">Dessie, Ethiopia</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
