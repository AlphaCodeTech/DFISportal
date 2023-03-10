<?php

use App\Lib\SendSms;
use App\Mail\SendMail;
use App\Lib\TemplateParser;
use App\Models\SmsTemplate;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\EmailMailTemplate;
use App\Settings\SystemSetting;
use Illuminate\Support\Facades\App;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Mail;

function getLatestVersion()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.viserlab.com/updates/version/' . systemDetails()['name'];
    $result = curlPostContent($url, $param);
    if ($result) {
        return $result;
    } else {
        return null;
    }
}



function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}


//moveable
function getIpInfo()
{
    $ip = $_SERVER["REMOTE_ADDR"];

    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }


    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);


    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');


    return $data;
}

//moveable
function osBrowser()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $osPlatform = "Unknown OS Platform";
    $osArray = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($osArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $osPlatform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browserArray = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browserArray as $regex => $value) {
        if (preg_match($regex, $userAgent)) {
            $browser = $value;
        }
    }

    $data['os_platform'] = $osPlatform;
    $data['browser'] = $browser;

    return $data;
}


function notify($user, $type, $shortCodes = null)
{
    sendEmail($user, $type, $shortCodes);
    // sendSms($user, $type, $shortCodes);
}



// function sendSms($user, $type, $shortCodes = [])
// {
//     $general = GeneralSetting::first();
//     $smsTemplate = SmsTemplate::where('act', $type)->where('sms_status', 1)->first();
//     $gateway = $general->sms_config->name;
//     $sendSms = new SendSms;
//     if ($general->sn == 1 && $smsTemplate) {
//         $template = $smsTemplate->sms_body;
//         foreach ($shortCodes as $code => $value) {
//             $template = shortCodeReplacer('{{' . $code . '}}', $value, $template);
//         }
//         $message = shortCodeReplacer("{{message}}", $template, $general->sms_api);
//         $message = shortCodeReplacer("{{name}}", $user->username, $message);
//         $sendSms->$gateway($user->mobile, $general->sitename, $message, $general->sms_config);
//     }
// }

function sendEmail($user, $type = null, $shortCodes = [])
{
    $general = App::make(SystemSetting::class);

    $config = collect([
        'name' => env('MAIL_MAILER'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'port' => env('MAIL_PORT'),
        'host' => env('MAIL_HOST'),
        'enc' => env('MAIL_ENCRYPTION'),
    ]);


    $mailTemplate = EmailMailTemplate::where('key', $type)->first();

    $templateParser = (new TemplateParser($mailTemplate->body));

    foreach ($shortCodes as $key => $value) {
        $templateParser->$key = $value;
    }
   
    $templateParser->process();

    $message = $templateParser->getCompiled();

    dd($message);
    if ($config['name'] == 'php') {
        sendPhpMail($user->email, $user->username, $mailTemplate->subject, $message, $general);
    } else if ($config['name'] == 'smtp') {
        Mail::to($user->email)->send(new SendMail($mailTemplate->subject, $message));
        // sendSmtpMail($config, $user->email, $user->name, $mailTemplate->subject, $message, $general);
    }
}

function sendPhpMail($receiver_email, $receiver_name, $subject, $message, $general)
{
    $headers = "From: $general->name <$general->email> \r\n";
    $headers .= "Reply-To: $general->name <$general->email> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    @mail($receiver_email, $subject, $message, $headers);
}


function sendSmtpMail($config, $receiver_email, $receiver_name, $subject, $message, $general)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['username'];
        $mail->Password   = $config['password'];
        if ($config['enc'] == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $config['port'];
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($general->email, $general->name);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($general->email, $general->name);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}
