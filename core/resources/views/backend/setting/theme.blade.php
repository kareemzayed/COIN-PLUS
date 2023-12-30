@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __($pageTitle) }}</h1>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card theme-card">
                                            <div class="card-header justify-content-center border">
                                                <h4 class="card-title text-dark font-weight-bold">{{ __('Default Template') }}</h4>
                                            </div>
                                            <div class="card-body m-0 p-0">
                                                <img class="w-100" src="{{ getFile('theme', 'theme1.png', true) }}"
                                                    alt="theme-image">
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" {{ $general->theme == 'default' ? 'disabled' : '' }}
                                                    class="btn btn-primary btn-block mt-3 active-btn"
                                                    data-route="{{ route('admin.manage.theme.update', 'default') }}">
                                                    @if ($general->theme == 'default')
                                                        <span><i class="fas fa-save pr-2"></i>
                                                            {{ __('Active') }}</span>
                                                    @else
                                                        <span><i class="fas fa-save pr-2"></i>
                                                            {{ __('Select As Active') }}</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="card theme-card">
                                            <div class="card-header justify-content-center border">
                                                <h4 class="card-title text-dark font-weight-bold">{{ __('Template Two') }}</h4>
                                            </div>
                                            <div class="card-body m-0 p-0">
                                                <img class="w-100" src="{{ getFile('theme', 'theme2.png', true) }}"
                                                    alt="theme-image">
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" {{ $general->theme == 'theme2' ? 'disabled' : '' }}
                                                    class="btn btn-primary btn-block mt-3 active-btn"
                                                    data-route="{{ route('admin.manage.theme.update', 'theme2') }}">
                                                    @if ($general->theme == 'theme2')
                                                        <span><i class="fas fa-save pr-2"></i>
                                                            {{ __('Active') }}</span>
                                                    @else
                                                        <span><i class="fas fa-save pr-2"></i>
                                                            {{ __('Select As Active') }}</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="activeTheme" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Active Template') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            {{ __('Are you sure to active this template ?') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Active') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .theme-card .card-body {
            max-height: 450px;
            overflow: hidden;
        }

        .theme-card .card-body img {
            height: 100%;
            object-fit: cover;
            -o-object-fit: cover;
        }
    </style>
@endpush


@push('script')
    <script>
        $(function() {
            'use strict'

            $('.active-btn').on('click', function() {
                const modal = $('#activeTheme');

                modal.find('form').attr('action', $(this).data('route'))

                modal.modal('show')
            })
        })
    </script>
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