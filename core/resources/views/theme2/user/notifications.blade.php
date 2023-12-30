@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ $pageTitle }}</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table site-table text-center">
                                <thead>
                                    <tr>
                                        <th class="col-1" scope="col">الإشعار</th>
                                        <th class="col-1" scope="col">التاريخ</th>
                                        <th class="col-1" scope="col">
                                            <a href="#" id="mark-all">
                                                تعليم الكل كمقروء
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notifications as $noti)
                                        <tr class="alert">
                                            <td data-caption="الإشعار" class="text-center">{{ $noti->data['message'] }}</td>
                                            <td data-caption="التاريخ">{{ $noti->created_at->format('d/m/Y g:i A') }}</td>
                                            <td data-caption="تعليم الكل كمقروء">
                                                <a href="#" class="mark-as-read" data-id="{{ $noti->id }}">
                                                    تعليم كمقروء
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور على إشعارات</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict'
        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('user.markNotification') }}", {
                method: 'POST',
                data: {
                    _token : "{{csrf_token()}}",
                    id
                }
            });
        }
        $(function() {
            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'),);
                request.done(() => {
                    $(this).parents('tr.alert').fadeOut(400, function(){
                        $(this).remove();
                    });
                });
            });
            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                request.done(() => {
                    $('tr.alert').fadeOut(400 , function(){
                        $(this).remove();
                    });
                })
            });
        });
    </script>
@endpush
