<?php

use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\Refferal;
use App\Models\RefferedCommission;
use App\Models\SectionData;
use App\Models\Language;
use App\Models\PermissionRole;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function makeDirectory($path)
{
    if (file_exists($path)) {
        return true;
    }

    return mkdir($path, 0755, true);
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? unlink($path) : false;
}

function uploadImage($file, $location, $size = null, $old = null, $thumb = null)
{
    $path = makeDirectory($location);

    if (!$path) {
        throw new Exception('File could not been created.');
    }

    if (!empty($old)) {
        removeFile($location . '/' . $old);
        removeFile($location . '/thumb_' . $old);
    }

    $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();

    $image = Image::make($file);

    if (!empty($size)) {
        $size = explode('x', strtolower($size));

        $canvas = Image::canvas(400, 400);

        $image = $image->resize(400, 400, function ($constraint) {
            $constraint->aspectRatio();
        });

        $canvas->insert($image, 'center');
        $canvas->save($location . '/' . $filename);
    } else {
        $image->save($location . '/' . $filename);
    }

    if (!empty($thumb)) {
        $thumb = explode('x', $thumb);
        Image::make($file)->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
    }

    return $filename;
}

function menuActive($routeName)
{

    $class = 'active';

    if (is_array($routeName)) {
        foreach ($routeName as $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}

function verificationCode($length)
{
    if ($length == 0) {
        return 0;
    }

    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}

function gatewayImagePath()
{
    return 'asset/images/gateways';
}

function filePath($folder_name, $default = false)
{
    $general = GeneralSetting::first();

    if ($default) {
        return 'asset/images/' . $folder_name;
    }

    return 'asset/' . $general->theme . '/images/' . $folder_name;
}

function checkPermission($role)
{
    $loginUser = auth()->user();

    if ($loginUser->status != 1) {
        return false;
    }
    if ($loginUser->role_id == null) {
        return true;
    }

    $checkAllow = PermissionRole::where('status', 1)->find($loginUser->role_id);
    if (!$checkAllow) {
        return false;
    }

    if (in_array($role, $checkAllow->permission)) {
        return true;
    } else {
        return false;
    }
}

function frontendFormatter($key)
{
    return ucwords(str_replace('_', ' ', $key));
}

function getFile($folder_name, $filename, $default = false)
{
    $general = GeneralSetting::first();

    if ($default == true) {
        if (file_exists(filePath($folder_name, $default) . '/' . $filename) && $filename != null) {

            return asset('asset/images/' . $folder_name . '/' . $filename);
        }
        return asset('asset/images/default.png');
    }



    if (file_exists(filePath($folder_name) . '/' . $filename) && $filename != null) {
        return asset('asset/' . $general->theme . '/images/' . $folder_name . '/' . $filename);
    }

    return asset('asset/images/default.png');
}

function variableReplacer($code, $value, $template)
{
    return str_replace($code, $value, $template);
}

function sendGeneralMail($data)
{
    $general = GeneralSetting::first();

    if ($general->email_method == 'php') {
        $headers = "From: $general->sitename <$general->site_email> \r\n";
        $headers .= "Reply-To: $general->sitename <$general->site_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        mail($data['email'], $data['subject'], $data['message'], $headers);
    } else {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $general->email_config->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $general->email_config->smtp_username;
            $mail->Password = $general->email_config->smtp_password;
            if ($general->email_config->smtp_encryption == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            $mail->Port = $general->email_config->smtp_port;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($general->site_email, $general->sitename);
            $mail->addAddress($data['email'], $data['name']);
            $mail->addReplyTo($general->site_email, $general->sitename);
            $mail->isHTML(true);
            $mail->Subject = $data['subject'];
            $mail->Body = $data['message'];
            $mail->send();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}

function sendMail($key, array $data, $user)
{
    $general = GeneralSetting::first();
    $template = EmailTemplate::where('name', $key)->first();

    $message = variableReplacer('{username}', $user->username, $template->template);
    $message = variableReplacer('{sent_from}', $general->sitename, $message);

    foreach ($data as $key => $value) {
        $message = variableReplacer("{" . $key . "}", $value, $message);
    }

    if ($general->email_method == 'php') {
        $headers = "From: $general->sitename <$general->site_email> \r\n";
        $headers .= "Reply-To: $general->sitename <$general->site_email> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        mail($user->email, $template->subject, $message, $headers);
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $general->email_config->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $general->email_config->smtp_username;
            $mail->Password = $general->email_config->smtp_password;
            if ($general->email_config->smtp_encryption == 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            $mail->Port = $general->email_config->smtp_port;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($general->site_email, $general->sitename);
            $mail->addAddress($user->email, $user->username);
            $mail->addReplyTo($general->site_email, $general->sitename);
            $mail->isHTML(true);
            $mail->Subject = $template->subject;
            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
function content($key)
{

    $general = GeneralSetting::first();


    return SectionData::where('key', $key)->where('theme', $general->theme)->first();
}

function element($key, $take = 10)
{
    $general = GeneralSetting::first();


    return SectionData::where('key', $key)->where('theme', $general->theme)->take($take)->get();
}

function refferMoney($from, $to, $refferal_type, $amount)
{

    $user_id = $from;

    $level = Refferal::where('status', 1)->where('type', $refferal_type)->first();

    $counter = $level ? count($level->level) : 0;

    $general = GeneralSetting::first();

    for ($i = 0; $i < $counter; $i++) {

        if ($to) {

            $comission = ($level->commision[$i] * $amount) / 100;

            $to->balance = $to->balance + $comission;

            $to->save();

            Transaction::create([
                'trx' => Str::upper(Str::random(16)),
                'user_id' => $to->id,
                'amount' => $comission,
                'charge' => 0,
                'details' => 'Refferal Commission from level ' . $i . ' user',
                'type' => '+',
                'payment_status' => 1,
                'currency' => $general->site_currency
            ]);

            RefferedCommission::create([
                'commission_to' => $to->id,
                'commission_from' => $user_id,
                'amount' => $comission,
                'purpouse' => $refferal_type === 'invest' ? 'Return invest commission' : 'Return Interest Commission'

            ]);

            sendMail('Commission', [
                'refer_user' => $to->username,
                'amount' => $comission,
                'currency' => $general->site_currency,
            ], $to);

            $from = $to->id;
            $to = $to->refferedBy;
        }
    }
}

function colorText($haystack, $needle)
{
    $replace = "<span>{$needle}</span>";

    return str_replace($needle, $replace, $haystack);
}

function singleMenu($routeName)
{
    $class = 'active';

    if (request()->routeIs($routeName)) {
        return $class;
    }

    return '';
}

function activeMenu($route)
{
    if (is_array($route)) {
        if (in_array(url()->current(), $route)) {
            return 'active';
        }
    }
    if ($route == url()->current()) {
        return 'active';
    }
}

function arrayMenu($routeName)
{
    $class = 'open';
    if (is_array($routeName)) {
        foreach ($routeName as $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    }
}


function languageSelection($code)
{

    $default = Language::where('is_default', 1)->first()->short_code;

    if (session()->has('locale')) {
        if (session('locale') == $code) {
            return 'selected';
        }
    } else {
        if ($code == $default) {
            return 'selected';
        }
    }
}


function fileUpload($file, $location)
{
    $path = makeDirectory($location);

    if (!$path) throw new Exception('File could not been created.');

    if (!empty($old)) {
        removeFile($location . '/' . $old);
    }

    $filename = $file->getClientOriginalName();

    $file->move($location, $filename);

    return $filename;
}


function template()
{
    $general = GeneralSetting::first();

    return $general->theme . '.';
}

function templateSection()
{
    $general = GeneralSetting::first();

    return $general->theme;
}

function generateAccountNumber($userId)
{
    $prefix = 'AC-';
    $suffix = '-99';
    $formattedUserId = str_pad($userId, 4, '0', STR_PAD_LEFT);
    $accountNumber = $prefix . $formattedUserId . $suffix;
    return $accountNumber;
}

function generateVoucherNumber($id)
{
    $length = 5;
    $formattedId = str_pad($id, $length, '0', STR_PAD_LEFT);
    return $formattedId;
}
