@extends('layouts.app')

@section('title', 'Contact Us - TesheAI')

@section('content')
<div style="background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #022c22 100%); min-height: 100vh; padding: 40px 15px; font-family: system-ui, -apple-system, sans-serif;">
    <div style="max-width: 650px; margin: 0 auto; background: rgba(6, 78, 59, 0.6); backdrop-filter: blur(12px); border: 2px solid #10b981; border-radius: 24px; padding: 35px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); text-align: center;">
        
        <!-- Header -->
        <div style="margin-bottom: 30px;">
            <div style="font-size: 50px; margin-bottom: 10px;">✉️</div>
            <h1 style="color: #34d399; font-size: 34px; font-weight: 800; margin: 0; text-transform: uppercase; text-shadow: 0 2px 10px rgba(52, 211, 153, 0.3);">
                Get In Touch
            </h1>
            <p style="color: #d1fae5; font-size: 14px; margin-top: 10px;">
                Have questions, need support, or want to collaborate? Reach out to us anytime!
            </p>
        </div>

        <!-- Contact Items Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 15px; text-align: left;">
            
            <a href="mailto:tesheyimer86@gmail.com" style="text-decoration: none; background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 18px; border-radius: 16px; display: flex; align-items: center; gap: 15px;">
                <div style="font-size: 28px;">📧</div>
                <div>
                    <h2 style="color: #facc15; font-size: 11px; font-weight: 800; text-transform: uppercase; margin: 0 0 3px 0; letter-spacing: 1px;">Email Address</h2>
                    <span style="color: #6ee7b7; font-size: 13px; font-weight: 700; word-break: break-all;">tesheyimer86@gmail.com</span>
                </div>
            </a>

            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 18px; border-radius: 16px; display: flex; align-items: center; gap: 15px;">
                <div style="font-size: 28px;">📍</div>
                <div>
                    <h2 style="color: #facc15; font-size: 11px; font-weight: 800; text-transform: uppercase; margin: 0 0 3px 0; letter-spacing: 1px;">Location</h2>
                    <span style="color: #ffffff; font-size: 14px; font-weight: 700;">Dessie, Ethiopia</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
