<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

</head>
<title>Registration</title>

<body>
    <style>
        body {
            background: #f0f0f0;
            font-family: 'Latto', sans-serif;
        }
        
        .font-cizel * {
            font-family: 'Cinzel', serif !important;
            
        }
    
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 10px 0;
            padding: 0;
            font-weight: normal;
        }
    
        p {
            font-size: 13px;
        }
    </style>
    
    <!-- BODY-->
    <div style="max-width: 700px; width: 100%; background: #fff;margin: 30px auto;">
    
        <div style="padding:30px 60px;">
            <div style="text-align: center; padding: 20px 0 0 0;">
                <img src="{{ Setting::get_company_logo_storage_path() }}" alt="company logo" width="175" />
            </div>

            <div style="text-align: center; opacity: .75;" class="font-cizel">
                <small>REPUBLIC OF THE PHILIPPINES</small>
                <br />
                <h2 style="border-bottom: 1px solid #e1e1e1; margin: 0px;">PRESIDENTIAL LEGISLATIVE LIAISON OFFICE</h2>
                <small>Office of the President of the Republic of the Philippines</small>
            </div>
    
            <br />
            <br />

            <p>
                Hi, {{ $user->name }}!
            </p>

            <br />
            
            <p>
                Your account has been appoved! Please click the link below to complete your Profile. You can check the WikiPllo for the tutorial on how to use the website
            </p>
    
            <br />

            <p>
                Thank you!
            </p>
            
            <br />

            <div style="text-align: center;">
                <a href="{{ route('member.login') }}" target="_blank" style="padding: 10px 20px; background: #3b5d90; color: #fff;text-decoration: none;font-size: 14px; border-radius: 3px;">COMPLETE PROFILE </a>
            </div>

            <br />

            <br />
    
        </div>

        <div style="width: 96%; background-color: #4e4e4e; padding: 14px; color: white; font-weight: 600;">
            <p>Problems or questions? Email us at support@pllo.gov.ph</p>
        </div>

        <br />
    
        <div style="padding: 30px;background: #fff;margin-top: 20px;border-top: solid 1px #eee;text-align: center;color: #aaa;">
            <p style="font-size: 12px;">
                <strong>{{ $setting->company_name }}</strong> 
                <br /> 
                {{ $setting->company_address }}
                <br /> 
                {{ $setting->tel_no }} | ({{ $setting->mobile_no }})
                <br />
                <br /> 
                {{ url('/') }}
            </p>
        </div>
    </div>
    {{-- {!! $emailContent !!} --}}
</body>

</html>
