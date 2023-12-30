@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>قائمة المستخدمين</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                @if (checkPermission(6))
                                    <a href="{{ route('user.register') }}" target="_blank" class="btn btn-primary"><i
                                            class="fa fa-plus"></i>
                                        إنشاء مستخدم جديد</a>
                                @endif
                            </h4>
                            <div class="card-header-form">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="رقم الحساب"
                                            name="account_number"
                                            value="{{ isset($search['account_number']) ? $search['account_number'] : '' }}">
                                        <input type="text" class="form-control" placeholder="اسم المستخدم"
                                            name="user_name"
                                            value="{{ isset($search['user_name']) ? $search['user_name'] : '' }}">
                                        <select class="form-control" name="status">
                                            <option disabled selected>حالة المستخدم</option>
                                            <option value="">عرض الكل</option>
                                            <option value="1"
                                                {{ isset($search['status']) && $search['status'] == '1' ? 'selected' : '' }}>
                                                نشط</option>
                                            <option value="0"
                                                {{ isset($search['status']) && $search['status'] == '0' ? 'selected' : '' }}>
                                                غير نشط</option>
                                        </select>
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>رقم الحساب</th>
                                                <th>الأسم بالكامل</th>
                                                <th>رقم الهاتف</th>
                                                <th>البريد الألكتروني</th>
                                                <th>الرصيد الحالي</th>
                                                <th>حالة الحساب</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $key => $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->account_number }}</td>
                                                    <td>{{ $user->fullname }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td class="{{ $user->balance > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($user->balance, 2) . ' ' . $general->site_currency }}
                                                    </td>
                                                    <td>
                                                        @if ($user->status)
                                                            <span class='badge badge-success'>نشط</span>
                                                        @else
                                                            <span class='badge badge-danger'>غير نشط</span>
                                                        @endif
                                                    </td>
                                                    <td style="width: 17%">
                                                        @if (checkPermission(3))
                                                            <a href="{{ route('admin.user.account.statement', $user) }}"
                                                                class="btn btn-md btn-primary">كشف حساب</a>
                                                        @endif

                                                        @if (checkPermission(47))
                                                            <a href="{{ route('admin.user.details', $user) }}"
                                                                class="btn btn-md btn-primary"><i class="fa fa-pen"></i></a>
                                                        @endif

                                                        @if (checkPermission(5))
                                                            <a href="{{ route('admin.login.user', $user) }}"
                                                                target="_blank" class="btn btn-info btn-sm"><i
                                                                    class="fas fa-sign-in-alt"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="text-center" colspan="100%">لم يتم العثور علي مستخدمين</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($users->hasPages())
                                <div class="card-footer">
                                    {{ $users->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
