<?php
namespace App\Http\Controllers;

use App\Models\QRCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeFacade;

class QRCodeController extends Controller
{
    public function generate()
    {
        // Generate a random OTP (6 digits)
        $otp = rand(100000, 999999);

        // Generate a unique UUID for the QR code
        $uuid = Str::uuid();

        // Generate QR code with OTP and unique UUID
        $qrCode = QrCodeFacade::size(435)->generate('OTP: ' . $otp . ' ID: ' . $uuid);

        // Store the generated QR code and OTP in the database
        QRCode::create([
            'otp' => $otp,  // Store the OTP in the table
        ]);

        // // Pass QR code and OTP to the view
        return view('qrcode.index', compact('qrCode', 'otp'));

    }

    public function regenerate()
    {
        // Generate a random OTP (6 digits)
        $otp = rand(100000, 999999);
    
        // Generate a new UUID every time this is called
        $uuid = Str::uuid();
    
        // Generate a new QR code with OTP and the new UUID
        $qrCode = QrCodeFacade::size(435)->generate('OTP: ' . $otp . ' ID: ' . $uuid)->toHtml();
    
        QRCode::create([
            'otp' => $otp,
        ]);
    
        // Return the new QR code and OTP data for AJAX updates
        return response()->json([
            'qrCode' => $qrCode,
            'otp' => $otp,
        ]);
    }
    
    
}
