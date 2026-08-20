<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Interview;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class CompanyDashboardPageController extends Controller
{
    public function __invoke(): View
    {
        try {
            $companyProfile = $this->companyProfile();

            if (!$companyProfile) {
                return view('company.dashboard', $this->fallbackData());
            }

            return view('company.dashboard', [
                'companyName' => $companyProfile->company_name,
                'todayMessage' => "Here's what's happening today.",
                'stats' => $this->stats($companyProfile),
                'activities' => $this->activities($companyProfile),
                'quickActions' => $this->quickActions(),
                'dashboardConfig' => config(
                    'onlyfreshers.company.dashboard',
                    []
                ),
            ]);
        } catch (QueryException) {
            return view('company.dashboard', $this->fallbackData());
        }
    }

    private function companyProfile(): ?CompanyProfile
    {
        $user = Auth::user();

        if ($user && $user->role === 'company') {
            return $user->companyProfile;
        }

        return null;
    }

    private function stats(CompanyProfile $companyProfile): array
    {
        $jobQuery = Job::query()
            ->where('company_profile_id', $companyProfile->id);

        $applicationQuery = JobApplication::query()
            ->whereHas('job', function ($query) use ($companyProfile) {
                $query->where('company_profile_id', $companyProfile->id);
            });

        return [
            [
                'label' => 'Jobs Posted',
                'value' => (string) (clone $jobQuery)->count(),
                'link' => 'View all',
                'href' => '/company/jobs',
                'icon' => 'briefcase',
                'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
            ],
            [
                'label' => 'Applications',
                'value' => (string) (clone $applicationQuery)->count(),
                'link' => 'View all',
                'href' => '/company/applications',
                'icon' => 'users',
                'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
            ],
            [
                'label' => 'Shortlisted',
                'value' => (string) (clone $applicationQuery)
                    ->where('application_status', 'shortlisted')
                    ->count(),
                'link' => 'View all',
                'href' => '/company/shortlisted',
                'icon' => 'star',
                'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
            ],
            [
                'label' => 'Interviews',
                'value' => (string) Interview::query()
                    ->whereHas('jobApplication.job', function ($query) use (
                        $companyProfile
                    ) {
                        $query->where(
                            'company_profile_id',
                            $companyProfile->id
                        );
                    })
                    ->where('status', 'scheduled')
                    ->count(),
                'link' => 'View all',
                'href' => '/company/interviews',
                'icon' => 'calendar',
                'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
            ],
            [
                'label' => 'Hired',
                'value' => (string) (clone $applicationQuery)
                    ->where('application_status', 'hired')
                    ->count(),
                'link' => 'View all',
                'href' => '/company/hired',
                'icon' => 'user-check',
                'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
            ],
        ];
    }

    private function activities(CompanyProfile $companyProfile): array
    {
        $activities = collect();

        JobApplication::query()
            ->whereHas('job', function ($query) use ($companyProfile) {
                $query->where('company_profile_id', $companyProfile->id);
            })
            ->with(['job', 'fresherProfile.user'])
            ->latest('applied_at')
            ->limit(3)
            ->get()
            ->each(function (JobApplication $application) use ($activities) {
                $candidate = $application->fresherProfile?->user?->name
                    ?? 'A candidate';
                $jobTitle = $application->job?->title ?? 'your job';

                $activities->push([
                    'title' => "{$candidate} applied for {$jobTitle}",
                    'time' => optional($application->applied_at)->diffForHumans()
                        ?? optional($application->created_at)->diffForHumans()
                        ?? 'Recently',
                    'icon' => 'briefcase',
                    'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
                ]);
            });

        Interview::query()
            ->whereHas('jobApplication.job', function ($query) use (
                $companyProfile
            ) {
                $query->where('company_profile_id', $companyProfile->id);
            })
            ->with(['jobApplication.fresherProfile.user'])
            ->latest()
            ->limit(2)
            ->get()
            ->each(function (Interview $interview) use ($activities) {
                $candidate = $interview
                    ->jobApplication?->fresherProfile?->user?->name
                    ?? 'candidate';

                $activities->push([
                    'title' => "Interview {$interview->status} with {$candidate}",
                    'time' => optional($interview->created_at)->diffForHumans()
                        ?? 'Recently',
                    'icon' => 'calendar',
                    'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
                ]);
            });

        if ($activities->isEmpty()) {
            return $this->fallbackData()['activities'];
        }

        return $activities
            ->sortByDesc(fn ($activity) => $activity['time'])
            ->take(5)
            ->values()
            ->all();
    }

    private function quickActions(): array
    {
        return [
            [
                'title' => 'Post Opportunity',
                'text' => 'Post a job or internship for freshers',
                'href' => '/company/post-job',
                'icon' => 'briefcase',
                'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
            ],
            [
                'title' => 'View Applications',
                'text' => 'Review candidates who applied',
                'href' => '/company/applications',
                'icon' => 'users',
                'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
            ],
            [
                'title' => 'Shortlist Candidates',
                'text' => 'Pick the best matches',
                'href' => '/company/shortlisted',
                'icon' => 'star',
                'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
            ],
            [
                'title' => 'Schedule Interview',
                'text' => 'Connect with candidates',
                'href' => '/company/interviews/create',
                'icon' => 'calendar',
                'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
            ],
        ];
    }

    private function fallbackData(): array
    {
        return [
            'companyName' => 'Company',
            'todayMessage' => 'Loading dashboard...',
            'stats' => [
                [
                    'label' => 'Jobs Posted',
                    'value' => '0',
                    'link' => 'View all',
                    'href' => '/company/jobs',
                    'icon' => 'briefcase',
                    'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
                ],
                [
                    'label' => 'Applications',
                    'value' => '0',
                    'link' => 'View all',
                    'href' => '/company/applications',
                    'icon' => 'users',
                    'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
                ],
                [
                    'label' => 'Shortlisted',
                    'value' => '0',
                    'link' => 'View all',
                    'href' => '/company/shortlisted',
                    'icon' => 'star',
                    'iconClasses' => 'bg-[#fff5e6] text-[#ff9c22]',
                ],
                [
                    'label' => 'Interviews',
                    'value' => '0',
                    'link' => 'View all',
                    'href' => '/company/interviews',
                    'icon' => 'calendar',
                    'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
                ],
                [
                    'label' => 'Hired',
                    'value' => '0',
                    'link' => 'View all',
                    'href' => '/company/hired',
                    'icon' => 'user-check',
                    'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
                ],
            ],
            'activities' => [
                [
                    'title' => 'New application received for UI/UX Designer',
                    'time' => '2 min ago',
                    'icon' => 'briefcase',
                    'iconClasses' => 'bg-[#eaf2ff] text-[#075fe4]',
                ],
                [
                    'title' => '3 candidates shortlisted for React Developer',
                    'time' => '1 hour ago',
                    'icon' => 'user',
                    'iconClasses' => 'bg-[#e8fbf3] text-[#00ad6f]',
                ],
                [
                    'title' => 'Interview scheduled with Rohit Kumar',
                    'time' => '3 hours ago',
                    'icon' => 'calendar',
                    'iconClasses' => 'bg-[#f0edff] text-[#6c50ff]',
                ],
            ],
            'quickActions' => $this->quickActions(),
            'dashboardConfig' => config(
                'onlyfreshers.company.dashboard',
                []
            ),
        ];
    }
}
