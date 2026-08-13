
@extends('layouts.app')

@section('title', 'Contact Us - TesheAI')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12 text-gray-200">
    <h1 class="text-3xl font-bold mb-6 text-white text-center">Contact Us</h1>
    <p class="text-center mb-8 text-gray-400">Have questions, feedback, or need help with a course? Feel free to reach out to us!</p>

    <div class="bg-gray-800/50 p-6 rounded-lg border border-gray-700 max-w-md mx-auto text-center space-y-4">
        <div>
            <h2 class="text-lg font-semibold text-white">Email Address</h2>
            <p class="text-blue-400 mt-1">
                <a href="mailto:tesheyimer86@gmail.com" class="hover:underline">tesheyimer86@gmail.com</a>
            </p>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-white">Location</h2>
            <p class="text-gray-300 mt-1">Dessie, Ethiopia</p>
        </div>
    </div>
</div>
@endsection
