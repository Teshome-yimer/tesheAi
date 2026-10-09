@extends('layouts.app')

@section('title', 'Terms of Service - TesheAI')

@section('content')
<div style="background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #022c22 100%); min-height: 100vh; padding: 40px 15px; font-family: system-ui, -apple-system, sans-serif;">
    <div style="max-width: 800px; margin: 0 auto; background: rgba(6, 78, 59, 0.6); backdrop-filter: blur(12px); border: 2px solid #10b981; border-radius: 24px; padding: 30px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);">
        
        <!-- Header -->
        <div style="text-align: center; border-bottom: 2px solid rgba(16, 185, 129, 0.3); padding-bottom: 20px; margin-bottom: 30px;">
            <div style="font-size: 45px; margin-bottom: 10px;">📜</div>
            <h1 style="color: #34d399; font-size: 32px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 1px; text-shadow: 0 2px 10px rgba(52, 211, 153, 0.3);">
                Terms of Service
            </h1>
            <p style="color: #facc15; font-size: 13px; font-weight: 600; margin-top: 5px; letter-spacing: 2px; text-transform: uppercase;">
                TesheAI Platform Guidelines
            </p>
        </div>

        <p style="color: #ecfdf5; font-size: 16px; line-height: 1.6; background: rgba(2, 44, 34, 0.7); padding: 18px; border-radius: 14px; border-left: 4px solid #facc15; margin-bottom: 25px;">
            By using <strong style="color: #34d399;">TesheAI</strong>, you agree to comply with and be bound by the following Terms and Conditions of service.
        </p>

        <!-- List Sections -->
        <div style="display: flex; flex-direction: column; gap: 18px;">
            
            <!-- 01. Content & Video Disclaimer -->
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">01</span>
                    Content & Video Disclaimer
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0 0 10px 0; padding-left: 32px;">
                    TesheAI Academy functions as an organized educational portal and progress-tracking directory. Third-party video tutorials embedded on this platform are hosted externally (such as on YouTube) and rendered in compliance with standard embedding permissions set by content creators.
                </p>
                <p style="color: #6ee7b7; font-size: 13px; line-height: 1.5; margin: 0; padding-left: 32px; background: rgba(6, 78, 59, 0.4); padding-top: 8px; padding-bottom: 8px; border-radius: 8px;">
                    <strong style="color: #facc15;">Service Fees:</strong> Any enrollment or access fees charged on TesheAI Academy cover our platform services—including curriculum organization, user progress tracking, and certificate issuance. We do not claim ownership of or sell embedded third-party video content. All original intellectual property rights belong to their respective copyright holders.
                </p>
            </div>

            <!-- 02. User Accounts -->
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">02</span>
                    User Accounts
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    Users are responsible for keeping their login credentials secure and for all actions taking place within their account.
                </p>
            </div>

            <!-- 03. Service Updates -->
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">03</span>
                    Service Updates
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    We reserve the right to add, modify, or remove educational content or website features at any time to improve the platform experience.
                </p>
            </div>

            <!-- 04. DMCA & Content Removal -->
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">04</span>
                    Content Removal Requests
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    If you are a copyright owner or content creator and wish to have your embedded video content removed from our course catalog, please notify us. Valid requests will be processed promptly.
                </p>
            </div>

            <!-- 05. Contact Information -->
            <div style="background: rgba(2, 44, 34, 0.8); border: 1px solid #10b981; padding: 20px; border-radius: 16px;">
                <h2 style="color: #facc15; font-size: 18px; font-weight: 700; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
                    <span style="background: #10b981; color: #022c22; font-size: 12px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">05</span>
                    Contact Information
                </h2>
                <p style="color: #d1fae5; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 32px;">
                    Questions regarding these Terms or removal requests should be directed to: 
                    <a href="mailto:tesheyimer86@gmail.com" style="color: #6ee7b7; font-weight: 700; text-decoration: underline;">tesheyimer86@gmail.com</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
