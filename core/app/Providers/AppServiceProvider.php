<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Language;
use App\Models\GeneralSetting;
use App\Models\TransactionReport;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $general = GeneralSetting::first();

        setlocale(LC_TIME, App::currentLocale());

        View::composer('backend.layout.sidebar', function ($view) {
            $numOfPendingTickets = Ticket::where('status', 2)->count();
            $view->with('numOfPendingTickets',  $numOfPendingTickets);
        });

        View::composer('backend.layout.navbar', function ($view) {
            $notifications = auth()->guard('admin')->user()->unreadNotifications;
            $view->with('notifications',  $notifications);
        });

        View::composer('backend.layout.sidebar', function ($view) {
            $pendingReports = TransactionReport::where('replied', 0)->count();
            $view->with('pendingReports',  $pendingReports);
        });

        Paginator::useBootstrap();

        view()->share('general', $general);

        $urlSections = [];

        $jsonUrl = resource_path('views/') . templateSection() . '/' . 'sections.json';

        $urlSections = array_filter(json_decode(file_get_contents($jsonUrl), true));

        $pages = Page::where('theme', $general->theme)->where('name', '!=', 'home')->where('status', 1)->get();

        view()->share('pages', $pages);
        view()->share('urlSections', $urlSections);
        view()->share('language_top', Language::latest()->get());
    }
}
