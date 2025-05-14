<?php

namespace App\Providers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {
        // Gate للتحقق إذا كان المستخدم مديرًا
    Gate::define('manage-leave-requests', function ($user) {
        return $user->is_admin;  // إذا كان المستخدم مديرًا
    });

    // Gate للتحقق إذا كان المستخدم يمكنه تعديل طلبه
    Gate::define('edit-own-request', function ($user, $leaveRequest) {
        return $user->id === $leaveRequest->employee_id;  // إذا كان هو الموظف صاحب الطلب
    });
    /* if (Route::has('locale.switch')) {
                Filament::registerNavigationItems([
                    NavigationItem::make()
                        ->label('🇸🇦 عربي')
                        ->url(route('locale.switch', ['lang' => 'ar']))
                        ->icon('heroicon-o-language')
                        ->group('Language'),

                    NavigationItem::make()
                        ->label('🇬🇧 English')
                        ->url(route('locale.switch', ['lang' => 'en']))
                        ->icon('heroicon-o-language')
                        ->group('Language'),

                    // عنصر لتغيير اللغة إلى العربية
                    NavigationItem::make()
                        ->label('Change Language')
                        ->url(route('locale.switch', ['lang' => 'ar'])) // تغيير اللغة إلى العربية
                        ->icon('heroicon-o-language') // أيقونة تغيير اللغة
                        ->group('Language') // تخصيص المجموعة
                        ->order(100), // ترتيب الزر في الشريط الجانبي
                ]);
            }*/

    App::setLocale(Session::get('locale', config('app.locale')));
    }
}
