<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'الأعدادات العامة';
        $data['navGeneralSettingsActiveClass'] = 'active';
        $data['subNavGeneralSettingsActiveClass'] = 'active';
        $data['general'] = GeneralSetting::first();
        return view('backend.setting.general_setting')->with($data);
    }

    public function generalSettingUpdate(Request $request)
    {
        $general = GeneralSetting::first();

        $request->validate([
            'sitename' => 'required',
            'signup_bonus' => 'gte:0',
            'site_currency' => 'required|max:10',
            'preloader_status' => 'required',
            'logo' => [Rule::requiredIf(function () use ($general) {
                return $general == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'icon' => [Rule::requiredIf(function () use ($general) {
                return $general == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'logo_dr' => [Rule::requiredIf(function () use ($general) {
                return $general == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
            'login_image' => [Rule::requiredIf(function () use ($general) {
                return $general == null;
            }), 'image', 'mimes:jpg,png,jpeg'],
        ], [
            'preloader_status.required' => 'حقل حالة الشاشة التحميل مطلوب.',
            'sitename.required' => 'حقل اسم الموقع مطلوب.',
            'signup_bonus.gte' => 'حقل مكافأة التسجيل يجب أن يكون أكبر من أو يساوي 0.',
            'site_currency.required' => 'حقل عملة الموقع مطلوب.',
            'site_currency.max' => 'يجب أن لا يتجاوز عملة الموقع :max حرفًا.',
            'logo.required' => 'حقل الشعار مطلوب عند إضافة موقع جديد.',
            'logo.image' => 'يجب أن يكون الملف المحدد صورة.',
            'logo.mimes' => 'يجب أن يكون نوع الملف صورة من الأنواع التالية: jpg, png, jpeg.',
            'icon.required' => 'حقل الأيقونة مطلوب عند إضافة موقع جديد.',
            'icon.image' => 'يجب أن يكون الملف المحدد صورة.',
            'icon.mimes' => 'يجب أن يكون نوع الملف صورة من الأنواع التالية: jpg, png, jpeg.',
            'logo_dr.required' => 'حقل الشعار DR مطلوب عند إضافة موقع جديد.',
            'logo_dr.image' => 'يجب أن يكون الملف المحدد صورة.',
            'logo_dr.mimes' => 'يجب أن يكون نوع الملف صورة من الأنواع التالية: jpg, png, jpeg.',
            'login_image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'login_image.mimes' => 'يجب أن يكون نوع الملف صورة من الأنواع التالية: jpg, png, jpeg.',
        ]);

        if ($request->has('logo')) {
            $logo = 'logo' . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(filePath('logo', true), $logo);
        }

        if ($request->has('logo_dr')) {
            $logo_dr = 'logo-dr' . '.' . $request->logo_dr->getClientOriginalExtension();
            $request->logo_dr->move(filePath('logo', true), $logo_dr);
        }

        if ($request->has('icon')) {
            $icon = 'icon' . '.' . $request->icon->getClientOriginalExtension();
            $request->icon->move(filePath('icon', true), $icon);
        }

        if ($request->has('login_image')) {
            $login_image = 'login_image' . '.' . $request->login_image->getClientOriginalExtension();
            $request->login_image->move(filePath('login', true), $login_image);
        }

        GeneralSetting::updateOrCreate([
            'id' => 1
        ], [
            'sitename' => $request->sitename,
            'signup_bonus' => $request->signup_bonus,
            'site_currency' => $request->site_currency,
            'preloader_status' => $request->preloader_status,
            'user_reg' => $request->user_reg == 'on' ? 1 : 0,
            'is_email_verification_on' => $request->is_email_verification_on == 'on' ? 1 : 0,
            'is_sms_verification_on' => $request->is_sms_verification_on == 'on' ? 1 : 0,
            'logo' => isset($logo) ? ($logo ?? '') : GeneralSetting::first()->logo,
            'logo_dr' => isset($logo_dr) ? ($logo_dr ?? '') : GeneralSetting::first()->logo_dr,
            'login_image' => isset($login_image) ? ($login_image ?? '') : GeneralSetting::first()->login_image,
            'favicon' => isset($icon) ? ($icon ?? '') : GeneralSetting::first()->favicon,
            'primary_color_theme2' =>  $request->primary_color_theme2 ?? '',
            'copyright' => $request->copyright,
        ]);

        $this->setEnv([
            'NEXMO_KEY' => $request->sms_username,
            'NEXMO_SECRET' => $request->sms_password,
        ]);

        $notify[] = ['success', 'تم تحديث الأعدادات بنجاح'];
        return back()->withNotify($notify);
    }

    private function setEnv($object)
    {
        foreach ($object as $key => $value) {
            file_put_contents(app()->environmentFilePath(), str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents(app()->environmentFilePath())
            ));
        }
    }

    public function cookieConsent()
    {
        $data['pageTitle'] = 'اعدادات الكوكيز';
        $data['navGeneralSettingsActiveClass'] = 'active';
        $data['subNavCookieActiveClass'] = 'active';
        $data['cookie'] = GeneralSetting::first();
        return view('backend.setting.cookie')->with($data);
    }

    public function cookieConsentUpdate(Request $request)
    {
        $data = $request->validate([
            'allow_modal' => 'required|integer',
            'button_text' => 'required|max:100',
            'cookie_text' => 'required'
        ], [
            'allow_modal.required' => 'حقل السماح بالنافذة المنبثقة مطلوب.',
            'allow_modal.integer' => 'يجب أن يكون السماح بالنافذة المنبثقة رقمًا صحيحًا.',
            'button_text.required' => 'حقل نص الزر مطلوب.',
            'button_text.max' => 'يجب أن لا يتجاوز نص الزر :max حرفًا.',
            'cookie_text.required' => 'حقل نص ملف تعريف الارتباط مطلوب.'
        ]);
        GeneralSetting::updateOrCreate(['id' => 1], $data);
        $notify[] = ['success', "Cookie Consent Updated Successfully"];
        return redirect()->back()->withNotify($notify);
    }

    public function recaptcha()
    {
        $data['pageTitle'] = 'جوجل ريكابتشا';
        $data['navGeneralSettingsActiveClass'] = 'active';
        $data['subNavRecaptchaActiveClass'] = 'active';
        $data['recaptcha'] = GeneralSetting::first();
        return view('backend.setting.recaptcha')->with($data);
    }

    public function recaptchaUpdate(Request $request)
    {
        $data = $request->validate([
            'allow_recaptcha' => 'required',
            'recaptcha_key' => 'required',
            'recaptcha_secret' => 'required'
        ], [
            'allow_recaptcha.required' => 'حقل السماح بـ reCAPTCHA مطلوب.',
            'recaptcha_key.required' => 'حقل مفتاح reCAPTCHA مطلوب.',
            'recaptcha_secret.required' => 'حقل سر reCAPTCHA مطلوب.'
        ]);
        GeneralSetting::updateOrCreate(['id' => 1], $data);
        $notify[] = ['success', "تم تحديث ريكابتشا بنجاح"];
        return redirect()->back()->withNotify($notify);
    }

    public function seoManage()
    {
        $data['pageTitle'] = 'Manage SEO';
        $data['navGeneralSettingsActiveClass'] = 'active';
        $data['subNavSEOManagerActiveClass'] = 'active';
        $data['seo'] = GeneralSetting::first();
        return view('backend.setting.seo')->with($data);
    }

    public function seoManageUpdate(Request $request)
    {
        $general = GeneralSetting::first();
        $data = $request->validate([
            'seo_description' => 'required',
        ], [
            'seo_description.required' => 'حقل وصف SEO مطلوب.',
        ]);
        $general->update($data);
        $notify[] = ['success', "Seo Updated Successfully"];
        return redirect()->back()->withNotify($notify);
    }

    public function databaseBackup()
    {
        $mysqlHostName      = env('DB_HOST');
        $mysqlUserName      = env('DB_USERNAME');
        $mysqlPassword      = env('DB_PASSWORD');
        $DbName             = env('DB_DATABASE');

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '';
        foreach ($result as $table) {

            $show_table_query = "SHOW CREATE TABLE " . $table[0] . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table[0] . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);

                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table[0] (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        ob_clean();
        flush();
        readfile($file_name);
        unlink($file_name);
    }

    public function cacheClear()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');
        return back()->with('success', 'تم حذف ذاكرة التخذين المؤقته');
    }
}
