<! DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SIPANDIK</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color:  #f0f4f8;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse;">
                    
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background:  linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 40px 30px; text-align: center; border-radius: 16px 16px 0 0;">
                            <!-- Logo -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: inline-block; background: rgba(255,255,255,0.2); padding: 15px 20px; border-radius: 12px;">
                                    <span style="font-size: 28px; font-weight: 700; color: #ffffff; letter-spacing: 1px;">🔐 SIPANDIK</span>
                                </div>
                            </div>
                            <p style="color: rgba(255,255,255,0.9); font-size: 14px; margin:  0;">Sistem Informasi Pelaporan Persandian dan Statistik</p>
                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td style="background-color: #ffffff; padding: 50px 40px;">
                            <!-- Welcome Icon -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <div style="display: inline-block; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 20px; border-radius: 50%;">
                                    <span style="font-size: 40px;">✉️</span>
                                </div>
                            </div>

                            <!-- Greeting -->
                            <h1 style="color: #1e3a8a; font-size: 26px; font-weight: 700; text-align: center; margin:  0 0 10px 0;">
                                Halo, {{ $userName }}!  👋
                            </h1>
                            
                            <p style="color: #64748b; font-size: 16px; text-align: center; margin: 0 0 30px 0;">
                                Selamat datang di SIPANDIK
                            </p>

                            <!-- Divider -->
                            <div style="height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent); margin: 30px 0;"></div>

                            <!-- Message -->
                            <p style="color: #475569; font-size: 15px; line-height: 1.8; text-align: center; margin: 0 0 30px 0;">
                                Terima kasih telah mendaftar di <strong>SIPANDIK</strong>.  Untuk mulai menggunakan layanan kami, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini.
                            </p>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin:  35px 0;">
                                <a href="{{ $verificationUrl }}" style="display: inline-block; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; padding: 16px 50px; font-size: 16px; font-weight: 600; border-radius: 50px; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); transition: all 0.3s ease;">
                                    ✓ Verifikasi Email Saya
                                </a>
                            </div>

                            <!-- Timer Notice -->
                            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 12px; padding: 16px 20px; margin: 30px 0;">
                                <p style="color: #92400e; font-size: 14px; margin: 0; text-align: center;">
                                    ⏰ <strong>Perhatian:</strong> Link verifikasi ini akan kadaluarsa dalam <strong>60 menit</strong>
                                </p>
                            </div>

                            <!-- Divider -->
                            <div style="height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent); margin: 30px 0;"></div>

                            <!-- Alternative Link -->
                            <p style="color: #94a3b8; font-size: 13px; text-align: center; margin: 0 0 15px 0;">
                                Jika tombol tidak berfungsi, copy dan paste URL berikut ke browser: 
                            </p>
                            <div style="background-color: #f8fafc; border:  1px solid #e2e8f0; border-radius: 8px; padding: 12px; word-break: break-all;">
                                <a href="{{ $verificationUrl }}" style="color: #3b82f6; font-size: 12px; text-decoration: none;">{{ $verificationUrl }}</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 30px 40px; border-radius: 0 0 16px 16px;">
                            <p style="color: #94a3b8; font-size: 14px; text-align: center; margin: 0 0 15px 0;">
                                Jika Anda tidak mendaftar di SIPANDIK, abaikan email ini.
                            </p>
                            
                            <!-- Social/Contact -->
                            <div style="text-align: center; margin: 20px 0;">
                                <span style="display: inline-block; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 20px; margin:  0 5px;">
                                    <span style="color: #94a3b8; font-size: 12px;">🌐 sipandik.lampungprov.go.id</span>
                                </span>
                            </div>

                            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 20px 0;"></div>
                            
                            <p style="color: #64748b; font-size: 12px; text-align: center; margin: 0;">
                                © {{ date('Y') }} SIPANDIK - Diskominfotik Provinsi Lampung<br>
                                Jl. WR. Monginsidi No.69, Bandar Lampung
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>