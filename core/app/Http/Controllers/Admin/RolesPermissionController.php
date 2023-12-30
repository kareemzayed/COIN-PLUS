<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RolesPermissionController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة الأدوار المتاحة';
        $data['permissionsActiveClass'] = 'active';
        $data['availavleRolesActiveClass'] = 'active';

        $search['name'] = $request->name;

        $data['roles'] = PermissionRole::when($search['name'], function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search['name'] . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate();
        return view('backend.roles.index', compact('search'))->with($data);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
            'permissions' => 'required|array',
            'permissions.*' => 'integer|not_in:0',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم :max حرفًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.integer' => 'يجب أن تكون الحالة رقمًا صحيحًا.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 0 أو 1.',
            'permissions.required' => 'حقل الصلاحيات مطلوب.',
            'permissions.array' => 'يجب أن تكون الصلاحيات مصفوفة.',
            'permissions.*.integer' => 'يجب أن تكون قيم الصلاحيات أرقام صحيحة.',
            'permissions.*.not_in' => 'قيم الصلاحيات يجب ألا تكون 0.',
        ]);

        PermissionRole::create([
            'name' => $request->name,
            'status' => $request->status,
            'permission' => $request->permissions,
        ]);

        $notify[] = ['success', 'تم إنشاء الدور بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1',
            'permissions' => 'required|array',
            'permissions.*' => 'integer|not_in:0',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم :max حرفًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.integer' => 'يجب أن تكون الحالة رقمًا صحيحًا.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 0 أو 1.',
            'permissions.required' => 'حقل الصلاحيات مطلوب.',
            'permissions.array' => 'يجب أن تكون الصلاحيات مصفوفة.',
            'permissions.*.integer' => 'يجب أن تكون قيم الصلاحيات أرقام صحيحة.',
            'permissions.*.not_in' => 'قيم الصلاحيات يجب ألا تكون 0.',
        ]);

        $role = PermissionRole::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'status' => $request->status,
            'permission' => $request->permissions,
        ]);

        $notify[] = ['success', 'تم تحديث الدور بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function roleDelete($id)
    {
        $role = PermissionRole::with(['roleUsers'])->find($id);
        if (count($role->roleUsers) > 0) {
            $notify[] = ['error', 'This role has users'];
            return redirect()->back()->withNotify($notify);
        }
        $role->delete();
        $notify[] = ['success', 'تم حذف الدور بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function staffList(Request $request)
    {
        $data['pageTitle'] = 'قائمة فريق العمل';
        $data['permissionsActiveClass'] = 'active';
        $data['manageStaffsActiveClass'] = 'active';

        $search['username'] = $request->username;
        $search['email'] = $request->email;

        $data['roleUsers'] = Admin::where('is_owner', 0)
            ->when($search['username'], function ($q) use ($search) {
                $q->where('username', 'LIKE', '%' . $search['username'] . '%');
            })
            ->when($search['email'], function ($q) use ($search) {
                $q->where('email', 'LIKE', '%' . $search['email'] . '%');
            })
            ->orderBy('name', 'asc')->paginate();
        $data['roles'] = PermissionRole::where('status', 1)->orderBy('name', 'asc')->get();

        return view('backend.roles.staffs_index', compact('search'))->with($data);
    }

    public function createStaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:50|unique:admins,username',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'status' => 'required|in:1,0',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم :max حرفًا.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صحيحًا.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني :max حرفًا.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم من قبل مستخدم آخر.',
            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.string' => 'يجب أن يكون اسم المستخدم نصًا.',
            'username.max' => 'يجب ألا يتجاوز اسم المستخدم :max حرفًا.',
            'username.unique' => 'هذا اسم المستخدم مستخدم من قبل مستخدم آخر.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل :min حرفًا.',
            'role.required' => 'حقل الدور مطلوب.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 1 أو 0.',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'status' => $request->status,
            'role_id' => $request->role,
            'is_owner' => 0,
            'password' => Hash::make($request->password),
        ]);

        $notify[] = ['success', 'تم إنشاء فريق العمل بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function updateStaff(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'username' => 'required|string|max:50|unique:admins,username,' . $admin->id,
            'role' => 'required',
            'status' => 'required|in:1,0',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يتجاوز الاسم :max حرفًا.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صحيحًا.',
            'email.max' => 'يجب ألا يتجاوز البريد الإلكتروني :max حرفًا.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم من قبل مستخدم آخر.',
            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.string' => 'يجب أن يكون اسم المستخدم نصًا.',
            'username.max' => 'يجب ألا يتجاوز اسم المستخدم :max حرفًا.',
            'username.unique' => 'هذا اسم المستخدم مستخدم من قبل مستخدم آخر.',
            'role.required' => 'حقل الدور مطلوب.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 1 أو 0.',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'status' => $request->status,
            'role_id' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        $notify[] = ['success', 'تم تعديل فريق العمل بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function loginAsStaff($id)
    {
        $admin = Admin::findOrFail($id);
        Auth::guard('admin')->loginUsingId($admin->id);
        return redirect()->route('admin.home');
    }
}