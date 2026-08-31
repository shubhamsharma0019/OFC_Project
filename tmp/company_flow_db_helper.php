<?php

$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=onlyfreshers;charset=utf8mb4',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$mode = $argv[1] ?? 'show';

if ($mode === 'show') {
    $rows = $pdo->query(
        "SELECT u.id AS user_id, u.name, u.email, u.role,
                cp.id AS profile_id, cp.company_name, cp.email AS company_email,
                cp.phone, cp.industry, cp.website, cp.address, cp.description,
                cp.approval_status, cp.job_credits, cp.total_job_credits_used,
                cp.subscription_plan, cp.subscribed_at
         FROM users u
         LEFT JOIN company_profiles cp ON cp.user_id = u.id
         WHERE u.role = 'company' OR u.name LIKE '%Ritik%' OR u.email LIKE '%ritik%'
         ORDER BY u.id"
    )->fetchAll();

    echo json_encode($rows, JSON_PRETTY_PRINT) . PHP_EOL;
    exit;
}

if ($mode === 'summary') {
    $name = $argv[2] ?? 'Ritik Tyagi';

    $stmt = $pdo->prepare(
        "SELECT u.name AS candidate, j.title AS job_title, j.hiring_mode, fp.city,
                fp.qualification, fp.skills, ja.application_status,
                MAX(CASE WHEN aa.assessment_type = 'initial' THEN ar.overall_score END) AS initial_score,
                MAX(CASE WHEN aa.assessment_type = 'final' THEN ar.overall_score END) AS final_score
         FROM (
             SELECT cp.id
             FROM users cu
             JOIN company_profiles cp ON cp.user_id = cu.id
             WHERE cu.role = 'company' AND cu.name LIKE ?
             ORDER BY cu.id DESC
             LIMIT 1
         ) latest_company
         JOIN company_profiles cp ON cp.id = latest_company.id
         JOIN jobs j ON j.company_profile_id = cp.id
         JOIN job_applications ja ON ja.job_id = j.id
         JOIN fresher_profiles fp ON fp.id = ja.fresher_profile_id
         JOIN users u ON u.id = fp.user_id
         LEFT JOIN assessment_attempts aa ON aa.fresher_profile_id = fp.id AND aa.status = 'submitted'
         LEFT JOIN assessment_results ar ON ar.attempt_id = aa.id
         GROUP BY u.name, j.title, j.hiring_mode, fp.city, fp.qualification, fp.skills, ja.application_status
         ORDER BY j.hiring_mode, u.name"
    );
    $stmt->execute(['%' . $name . '%']);
    echo json_encode($stmt->fetchAll(), JSON_PRETTY_PRINT) . PHP_EOL;
    exit;
}

if ($mode === 'prepare') {
    $name = $argv[2] ?? 'Ritik Tyagi';

    $stmt = $pdo->prepare(
        "SELECT u.id AS user_id, cp.id AS profile_id
         FROM users u
         LEFT JOIN company_profiles cp ON cp.user_id = u.id
         WHERE u.role = 'company' AND u.name LIKE ?
         ORDER BY u.id DESC
         LIMIT 1"
    );
    $stmt->execute(['%' . $name . '%']);
    $company = $stmt->fetch();

    if (! $company || ! $company['profile_id']) {
        fwrite(STDERR, "Company profile not found for {$name}." . PHP_EOL);
        exit(1);
    }

    $profileId = (int) $company['profile_id'];

    $pdo->prepare(
        "UPDATE company_profiles
         SET company_name = COALESCE(NULLIF(company_name, ''), 'Ritik Tyagi Hiring Pvt Ltd'),
             email = COALESCE(NULLIF(email, ''), 'hr@ritiktyagi.test'),
             phone = COALESCE(NULLIF(phone, ''), '9999999999'),
             industry = COALESCE(NULLIF(industry, ''), 'IT Services'),
             website = COALESCE(NULLIF(website, ''), 'https://ritiktyagi.test'),
             address = COALESCE(NULLIF(address, ''), 'Noida, Uttar Pradesh, India'),
             description = COALESCE(NULLIF(description, ''), 'Hiring freshers for direct and fast track opportunities.'),
             approval_status = 'approved',
             rejection_reason = NULL,
             job_credits = 0,
             total_job_credits_used = GREATEST(COALESCE(total_job_credits_used, 0), 500),
             subscription_plan = NULL,
             subscribed_at = NULL,
             updated_at = NOW()
         WHERE id = ?"
    )->execute([$profileId]);

    echo "Prepared company profile {$profileId}: approved, complete, free credits exhausted." . PHP_EOL;
    exit;
}

if ($mode === 'custom') {
    $name = $argv[2] ?? 'Ritik Tyagi';
    $credits = (int) ($argv[3] ?? 10000);

    $stmt = $pdo->prepare(
        "SELECT cp.id AS profile_id
         FROM users u
         JOIN company_profiles cp ON cp.user_id = u.id
         WHERE u.role = 'company' AND u.name LIKE ?
         ORDER BY u.id DESC
         LIMIT 1"
    );
    $stmt->execute(['%' . $name . '%']);
    $company = $stmt->fetch();

    if (! $company) {
        fwrite(STDERR, "Company profile not found for {$name}." . PHP_EOL);
        exit(1);
    }

    $pdo->prepare(
        "UPDATE company_profiles
         SET subscription_plan = 'custom',
             subscribed_at = NOW(),
             job_credits = ?,
             updated_at = NOW()
         WHERE id = ?"
    )->execute([$credits, (int) $company['profile_id']]);

    echo "Custom subscription enabled with {$credits} credits." . PHP_EOL;
    exit;
}

if ($mode === 'seed-applicants') {
    $name = $argv[2] ?? 'Ritik Tyagi';

    $stmt = $pdo->prepare(
        "SELECT cp.id AS profile_id
         FROM users u
         JOIN company_profiles cp ON cp.user_id = u.id
         WHERE u.role = 'company' AND u.name LIKE ?
         ORDER BY u.id DESC
         LIMIT 1"
    );
    $stmt->execute(['%' . $name . '%']);
    $company = $stmt->fetch();

    if (! $company) {
        fwrite(STDERR, "Company profile not found for {$name}." . PHP_EOL);
        exit(1);
    }

    $companyProfileId = (int) $company['profile_id'];

    $jobStmt = $pdo->prepare(
        "INSERT INTO jobs
            (company_profile_id, title, description, required_skills, qualification, location, salary, job_type, immediate_joiner, openings, hiring_mode, application_last_date, status, created_at, updated_at)
         VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'active', NOW(), NOW())"
    );

    $jobs = [
        'direct' => ['Software Developer Fresher', 'JavaScript, PHP, Laravel, SQL', 'B.Tech, BCA, MCA', 'Noida', '3-5 LPA', 'Full Time', 1, 8, 'direct'],
        'fast_track' => ['Fast Track Full Stack Trainee', 'React, Laravel, API, Git', 'B.Tech, BCA, MCA', 'Noida', '4-6 LPA', 'Full Time', 1, 10, 'fast_track'],
    ];

    $jobIds = [];

    foreach ($jobs as $key => $job) {
        $existing = $pdo->prepare("SELECT id FROM jobs WHERE company_profile_id = ? AND title = ? LIMIT 1");
        $existing->execute([$companyProfileId, $job[0]]);
        $jobId = $existing->fetchColumn();

        if (! $jobId) {
            $jobStmt->execute([
                $companyProfileId,
                $job[0],
                'Dummy opportunity for testing company filters and resume review.',
                $job[1],
                $job[2],
                $job[3],
                $job[4],
                $job[5],
                $job[6],
                $job[7],
                $job[8],
            ]);
            $jobId = $pdo->lastInsertId();
        }

        $jobIds[$key] = (int) $jobId;
    }

    $candidates = [
        ['Aarav Sharma', 'aarav.direct@example.test', 'direct', 'Noida', 'B.Tech CSE', 'JavaScript,Laravel,SQL', 72, null, 'Software Developer'],
        ['Bhavna Singh', 'bhavna.direct@example.test', 'direct', 'Delhi', 'BCA', 'PHP,MySQL,HTML,CSS', 64, null, 'Software Developer'],
        ['Chirag Verma', 'chirag.direct@example.test', 'direct', 'Ghaziabad', 'MCA', 'React,API,Git', 81, null, 'Software Developer'],
        ['Deepika Rao', 'deepika.fast@example.test', 'fast_track', 'Noida', 'B.Tech IT', 'React,Laravel,Git,Communication', 52, 84, 'Full Stack Development'],
        ['Farhan Ali', 'farhan.fast@example.test', 'fast_track', 'Gurugram', 'BCA', 'PHP,Laravel,SQL,API', 58, 76, 'Full Stack Development'],
        ['Kritika Mehta', 'kritika.fast@example.test', 'fast_track', 'Delhi', 'MCA', 'React,JavaScript,UI,Git', 61, 88, 'Full Stack Development'],
        ['Mohit Kumar', 'mohit.fast@example.test', 'fast_track', 'Noida', 'B.Tech CSE', 'Laravel,MySQL,Testing', 45, 69, 'Aptitude Booster'],
        ['Neha Jain', 'neha.direct@example.test', 'direct', 'Pune', 'B.Tech ECE', 'SQL,Excel,Communication', 55, null, 'Data Analyst'],
    ];

    $password = password_hash('password', PASSWORD_BCRYPT);
    $userStmt = $pdo->prepare(
        "INSERT INTO users (name, email, password, role, status, created_at, updated_at)
         VALUES (?, ?, ?, 'fresher', 'active', NOW(), NOW())"
    );
    $profileStmt = $pdo->prepare(
        "INSERT INTO fresher_profiles
            (user_id, phone, city, qualification, college_name, passing_year, skills, preferred_job_category, resume, profile_completion, direct_mode_credits, total_direct_mode_credits_used, created_at, updated_at)
         VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, 100, 250, 0, NOW(), NOW())"
    );
    $attemptStmt = $pdo->prepare(
        "INSERT INTO assessment_attempts (fresher_profile_id, course_enrollment_id, assessment_type, started_at, submitted_at, status, created_at, updated_at)
         VALUES (?, NULL, ?, NOW(), NOW(), 'submitted', NOW(), NOW())"
    );
    $resultStmt = $pdo->prepare(
        "INSERT INTO assessment_results (attempt_id, technical_score, aptitude_score, communication_score, overall_score, recommended_track, result, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, ?, 'pass', NOW(), NOW())"
    );
    $applicationStmt = $pdo->prepare(
        "INSERT INTO job_applications (job_id, fresher_profile_id, application_status, applied_at, created_at, updated_at)
         VALUES (?, ?, ?, NOW(), NOW(), NOW())"
    );

    foreach ($candidates as $index => $candidate) {
        [$candidateName, $email, $flow, $city, $qualification, $skills, $initialScore, $finalScore, $preferredRole] = $candidate;

        $existingUser = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $existingUser->execute([$email]);
        $userId = $existingUser->fetchColumn();

        if (! $userId) {
            $userStmt->execute([$candidateName, $email, $password]);
            $userId = $pdo->lastInsertId();
        }

        $existingProfile = $pdo->prepare("SELECT id FROM fresher_profiles WHERE user_id = ? LIMIT 1");
        $existingProfile->execute([$userId]);
        $profileId = $existingProfile->fetchColumn();

        if (! $profileId) {
            $profileStmt->execute([
                $userId,
                '90000000' . ($index + 10),
                $city,
                $qualification,
                'OnlyFreshers Demo College',
                2026,
                $skills,
                $preferredRole,
                'fresher/resumes/demo-candidate-' . ($index + 1) . '.pdf',
            ]);
            $profileId = $pdo->lastInsertId();
        }

        $attemptStmt->execute([$profileId, 'initial']);
        $initialAttemptId = $pdo->lastInsertId();
        $resultStmt->execute([
            $initialAttemptId,
            max(35, $initialScore - 3),
            max(35, $initialScore - 8),
            min(100, $initialScore + 5),
            $initialScore,
            $preferredRole,
        ]);

        if ($flow === 'fast_track') {
            $attemptStmt->execute([$profileId, 'final']);
            $finalAttemptId = $pdo->lastInsertId();
            $resultStmt->execute([
                $finalAttemptId,
                max(35, $finalScore - 2),
                max(35, $finalScore - 6),
                min(100, $finalScore + 4),
                $finalScore,
                $preferredRole,
            ]);
        }

        $existingApp = $pdo->prepare("SELECT id FROM job_applications WHERE job_id = ? AND fresher_profile_id = ? LIMIT 1");
        $existingApp->execute([$jobIds[$flow], $profileId]);

        if (! $existingApp->fetchColumn()) {
            $statuses = ['applied', 'under_review', 'shortlisted', 'interview_scheduled'];
            $applicationStmt->execute([$jobIds[$flow], $profileId, $statuses[$index % count($statuses)]]);
        }
    }

    $resumeDir = dirname(__DIR__) . '/storage/app/public/fresher/resumes';
    if (! is_dir($resumeDir)) {
        mkdir($resumeDir, 0777, true);
    }

    foreach ($candidates as $index => $candidate) {
        [$candidateName, $email, $flow, $city, $qualification, $skills, $initialScore, $finalScore] = $candidate;
        $resumePath = $resumeDir . '/demo-candidate-' . ($index + 1) . '.pdf';
        $finalLine = $flow === 'fast_track' ? "Final Score: {$finalScore}%" : 'Final Score: Not applicable for Direct Mode';
        $content = "BT /F1 18 Tf 72 720 Td (OnlyFreshers Demo Resume) Tj /F1 12 Tf 0 -36 Td (Name: {$candidateName}) Tj 0 -22 Td (Email: {$email}) Tj 0 -22 Td (Flow: " . ucfirst(str_replace('_', ' ', $flow)) . ") Tj 0 -22 Td (City: {$city}) Tj 0 -22 Td (Qualification: {$qualification}) Tj 0 -22 Td (Skills: {$skills}) Tj 0 -22 Td (Initial Score: {$initialScore}%) Tj 0 -22 Td ({$finalLine}) Tj ET";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length ' . strlen($content) . " >>\nstream\n{$content}\nendstream",
        ];
        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $number => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($number + 1) . " 0 obj\n{$object}\nendobj\n";
        }
        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= str_pad((string) $offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }
        $pdf .= "trailer << /Root 1 0 R /Size " . (count($objects) + 1) . " >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF\n";
        file_put_contents($resumePath, $pdf);
    }

    echo "Seeded " . count($candidates) . " dummy applicants for company profile {$companyProfileId}." . PHP_EOL;
    exit;
}

fwrite(STDERR, "Unknown mode: {$mode}" . PHP_EOL);
exit(1);
