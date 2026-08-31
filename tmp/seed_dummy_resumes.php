<?php

use App\Models\FresherProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$candidates = [
    ['Software Developer', 'B.Tech CSE', 'Noida', 'PHP, Laravel, MySQL, JavaScript'],
    ['Data Analyst', 'B.Sc Statistics', 'Gurugram', 'Excel, SQL, Power BI, Python'],
    ['Frontend Developer', 'BCA', 'Delhi', 'HTML, CSS, React, Tailwind'],
    ['HR Executive', 'BBA', 'Faridabad', 'Recruitment, Screening, Excel'],
    ['Backend Developer', 'MCA', 'Ghaziabad', 'Laravel, APIs, MySQL, Git'],
    ['Digital Marketing', 'B.Com', 'Jaipur', 'SEO, Meta Ads, Analytics'],
    ['UI Designer', 'B.Des', 'Pune', 'Figma, Wireframes, Prototyping'],
    ['Business Analyst', 'MBA', 'Chandigarh', 'Documentation, SQL, Stakeholders'],
    ['QA Tester', 'B.Tech IT', 'Lucknow', 'Manual Testing, Selenium, Jira'],
    ['Content Writer', 'BA English', 'Indore', 'Blogs, SEO Writing, Research'],
    ['Operations Executive', 'BBA', 'Ahmedabad', 'MIS, Coordination, Excel'],
    ['Full Stack Developer', 'B.Tech CSE', 'Kolkata', 'Laravel, Vue, MySQL, REST'],
];

$firstNames = [
    'Aarav', 'Priya', 'Rohan', 'Sneha', 'Kunal', 'Neha', 'Aditya', 'Simran', 'Mohit', 'Isha',
    'Dev', 'Ananya', 'Rahul', 'Pooja', 'Nikhil', 'Meera', 'Varun', 'Kriti', 'Yash', 'Tanvi',
];

$lastNames = [
    'Sharma', 'Mehta', 'Verma', 'Kapoor', 'Singh', 'Gupta', 'Jain', 'Kaur', 'Yadav', 'Agarwal',
    'Patel', 'Roy', 'Mishra', 'Bansal', 'Saxena', 'Rana', 'Chauhan', 'Malhotra', 'Joshi', 'Arora',
];

function dummyResumePdf(string $name, string $category, string $qualification, string $city, string $skills): string
{
    $lines = [
        $name,
        $category,
        $qualification . ' | ' . $city,
        'Skills: ' . $skills,
        'Experience: Fresher',
        'Email: ' . strtolower(str_replace(' ', '.', $name)) . '@onlyfreshers.test',
    ];

    $content = implode('', array_map(function (string $line, int $index) {
        $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $line);
        $y = 760 - ($index * 28);

        return "BT /F1 16 Tf 72 {$y} Td ({$safe}) Tj ET\n";
    }, $lines, array_keys($lines)));

    $stream = "<< /Length " . strlen($content) . " >>\nstream\n{$content}endstream";
    $objects = [
        "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n",
        "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n",
        "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj\n",
        "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n",
        "5 0 obj {$stream} endobj\n",
    ];

    $pdf = "%PDF-1.4\n";
    $offsets = [0];

    foreach ($objects as $object) {
        $offsets[] = strlen($pdf);
        $pdf .= $object;
    }

    $xref = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";

    foreach (array_slice($offsets, 1) as $offset) {
        $pdf .= str_pad((string) $offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
    }

    return $pdf . "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";
}

for ($number = 1; $number <= 100; $number++) {
    $index = $number - 1;
    [$category, $qualification, $city, $skills] = $candidates[$index % count($candidates)];
    $name = $firstNames[$index % count($firstNames)] . ' ' . $lastNames[(int) floor($index / count($firstNames)) % count($lastNames)];
    $email = 'dummy.fresher.' . $number . '@onlyfreshers.test';
    $resumePath = 'fresher/resumes/dummy-resume-' . $number . '.pdf';

    Storage::disk('public')->put($resumePath, dummyResumePdf($name, $category, $qualification, $city, $skills));

    $user = User::updateOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'mobile' => '900000' . str_pad((string) $number, 4, '0', STR_PAD_LEFT),
            'password' => Hash::make('Password@123'),
            'role' => 'fresher',
            'status' => 'active',
        ]
    );

    FresherProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'phone' => $user->mobile,
            'city' => $city,
            'qualification' => $qualification,
            'college_name' => 'OnlyFreshers Demo College',
            'passing_year' => 2026,
            'skills' => $skills,
            'preferred_job_category' => $category,
            'resume' => $resumePath,
            'profile_completion' => 100,
        ]
    );
}

echo "100 dummy resumes ready.\n";
