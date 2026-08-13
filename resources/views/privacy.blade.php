@extends('layouts.app')

@section('title', 'Privacy Policy - TesheAI')

@section('content')
<div style="background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #022c22 100%); min-height: 100vh; padding: 40px 15px; font-family: system-ui, -apple-system, sans-serif;">
    <div style="max-w: 800px; margin: 0 auto; background: rgba(6, 78, 59, 0.6); backdrop-filter: blur(12px); border: 2px solid #10b981; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);">
        
        <!-- Header -->
        <div style="text-align: center; border-bottom: 2px solid rgba(16, 185, 129, 0.3); padding-bottom: 20px; margin-bottom: 30px;">
            <div style="font-size: 45px; margin-bottom: 10px;">🔒</div>
            <h1 style="color: #34d399; font-size: 32px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 1px; text-shadow: 0 2px 10px rgba(52, 211, 153, 0.3);">
                Privacy Policy
            </h1>
            <p style="color: #facc15; font-size: 13px; font-weight: 600; margin-top: 5px; letter-spacing: 2px; text-transform: uppercase;">
                TesheAI Legal Center
            </p>
        </div>

        <p style="color: #ecfdf5; font-size: 16px; line-height: 1.6; background: rgba(2, 44, 34, 0.7); padding: 18px; border-radius: 14px; border-left: 4px solid #facc15; margin-bottom: 25px;">
            Welcome to <strong style="color: #34d399;">TesheAI</strong>. We value your privacy and are fully committed to protecting your personal data in a secure environment.
        </p>

        <!-- List Sections -->
        <div style="display: flex; flex-direction: column; gap: 18px;">
            
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">01</span>
                    Information We Collect
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    We collect information you provide directly to us when you create an account, enroll in courses, or contact us for technical support.
                </p>
            </div>

            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">02</span>
                    How We Use Your Information
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    We use your information strictly to deliver, improve, and personalize our educational services, manage user access, and send essential platform updates.
                </p>
            </div>

            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">03</span>
                    Cookies and Advertising
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    We may use cookies and third-party advertising partners like Google AdSense to serve relevant ads based on user interactions across the web.
                </p>
            </div>

            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">04</span>
                    Contact Us
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    If you have questions regarding this Privacy Policy, please reach us directly at: 
                    <a href="mailto:tesheyimer86@gmail.com" style="color: #6ee7b7; font-weight: 700; text-decoration: underline;">tesheyimer86@gmail.com</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
