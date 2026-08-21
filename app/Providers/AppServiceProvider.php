<?php

namespace App\Providers;

use App\Models\CompanyProfile;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\TrainingPartnerProfile;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.public.footer', function ($view) {
            $view->with('footerCta', config('onlyfreshers.footer.cta', []));
            $view->with('footerActions', config('onlyfreshers.footer.actions', []));
            $view->with('footerStats', $this->footerStats());
        });
    }

    private function footerStats(): array
    {
        $fallback = config('onlyfreshers.footer.stats', []);

        try {
            return Cache::remember('onlyfreshers.public_footer_stats', 300, function () use ($fallback) {
                return [
                    [
                        'value' => $this->compactCount(Job::query()->where('status', 'active')->count()),
                        'label' => 'Jobs Listed',
                    ],
                    [
                        'value' => $this->compactCount(
                            JobApplication::query()
                                ->where('application_status', 'hired')
                                ->count()
                        ),
                        'label' => 'Freshers Hired',
                    ],
                    [
                        'value' => $this->compactCount(
                            CompanyProfile::query()
                                ->where('approval_status', 'approved')
                                ->count()
                        ),
                        'label' => 'Companies',
                    ],
                    [
                        'value' => $this->compactCount(
                            TrainingPartnerProfile::query()
                                ->where('approval_status', 'approved')
                                ->count()
                        ),
                        'label' => 'Training Partners',
                    ],
                ];
            });
        } catch (QueryException) {
            return $fallback;
        }
    }

    private function compactCount(int $count): string
    {
        if ($count >= 1000) {
            return number_format(floor($count / 100) / 10, 1) . 'k+';
        }

        return number_format($count) . '+';
    }
}
