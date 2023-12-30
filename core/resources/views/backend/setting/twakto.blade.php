@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $pageTitle }}</h1>
            </div>

            <div class="row">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">

                                @csrf

                                <div class="row">


                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Allow Tawk.to Live Chat') }}</label>

                                        <select name="twak_allow" id="" class="form-control selectric">

                                            <option value="1" {{ $twakto->twak_allow==1 ? 'selected' : '' }}>
                                                {{ __('Yes') }}</option>
                                            <option value="0" {{ $twakto->twak_allow==0 ? 'selected' : '' }}>
                                                {{ __('No') }}</option>

                                        </select>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <label for="">{{ __('Tawk.to Key') }}</label>

                                        <input type="text" name="twak_key" class="form-control" placeholder="Tawk to Key"
                                            value="{{ $twakto->twak_key }}">

                                    </div>


                                    <div class="form-group col-md-12">


                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('Update Tawk.to Live Chat') }}</button>

                                    </div>


                                </div>


                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
@push('script')
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush