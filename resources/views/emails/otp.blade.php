<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation"
                    style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #023047 0%, #219EBC 100%); padding: 40px; text-align: center; border-radius: 16px 16px 0 0;">
                            <div
                                style="width: 80px; height: 80px; margin: 0 auto 20px; background: linear-gradient(135deg, #FB8500, #FFB703); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 40px; color: white;">🚌</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">Sri Maju Trans
                            </h1>
                            <p style="color: rgba(255, 255, 255, 0.9); margin: 10px 0 0; font-size: 14px;">Sistem
                                Manajemen Transportasi</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #023047; margin: 0 0 20px; font-size: 24px; font-weight: 600;">Reset
                                Password</h2>

                            <p style="color: #4b5563; margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $userName }}</strong>,
                            </p>

                            <p style="color: #4b5563; margin: 0 0 30px; font-size: 16px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode OTP di bawah ini
                                untuk melanjutkan proses reset password:
                            </p>

                            <!-- OTP Box -->
                            <div
                                style="background: linear-gradient(135deg, #FB8500 0%, #FFB703 100%); padding: 30px; border-radius: 12px; text-align: center; margin-bottom: 30px;">
                                <p
                                    style="color: #ffffff; margin: 0 0 10px; font-size: 14px; font-weight: 500; text-transform: uppercase; letter-spacing: 2px;">
                                    Kode OTP Anda</p>
                                <h1
                                    style="color: #ffffff; margin: 0; font-size: 48px; font-weight: 800; letter-spacing: 8px;">
                                    {{ $otp }}
                                </h1>
                            </div>

                            <!-- Warning -->
                            <div
                                style="background-color: #fef3cd; border-left: 4px solid #FB8500; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="color: #856404; margin: 0; font-size: 14px;">
                                    <strong>⚠️ Penting:</strong> Kode OTP ini hanya berlaku selama <strong>10
                                        menit</strong>. Jangan bagikan kode ini kepada siapapun.
                                </p>
                            </div>

                            <p style="color: #4b5563; margin: 0 0 20px; font-size: 16px; line-height: 1.6;">
                                Jika Anda tidak merasa meminta reset password, abaikan email ini dan pastikan keamanan
                                akun Anda.
                            </p>

                            <p style="color: #6b7280; margin: 0; font-size: 14px; line-height: 1.6;">
                                Terima kasih,<br>
                                <strong style="color: #023047;">Tim Sri Maju Trans</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 30px; text-align: center; border-radius: 0 0 16px 16px; border-top: 1px solid #e5e7eb;">
                            <p style="color: #9ca3af; margin: 0 0 10px; font-size: 12px;">
                                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                            </p>
                            <p style="color: #9ca3af; margin: 0; font-size: 12px;">
                                &copy; {{ date('Y') }} Sri Maju Trans. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>