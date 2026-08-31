<?php

final class FlowPdf
{
    private array $pages = [];
    private string $current = '';
    private float $y = 760;
    private int $pageNo = 0;
    private const W = 595.28;
    private const H = 841.89;

    public function addPage(): void
    {
        if ($this->current !== '') {
            $this->footer();
            $this->pages[] = $this->current;
        }

        $this->pageNo++;
        $this->current = '';
        $this->y = 760;
        $this->header();
    }

    public function save(string $path): void
    {
        if ($this->current !== '') {
            $this->footer();
            $this->pages[] = $this->current;
            $this->current = '';
        }

        $objects = [];
        $pageIds = [];
        $fontId = 3;
        foreach ($this->pages as $index => $content) {
            $contentId = 4 + ($index * 2);
            $pageId = $contentId + 1;
            $pageIds[] = $pageId;
            $objects[$contentId] = "<< /Length " . strlen($content) . " >>\nstream\n{$content}endstream";
            $objects[$pageId] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 " . self::W . ' ' . self::H . "] /Resources << /Font << /F1 {$fontId} 0 R >> >> /Contents {$contentId} 0 R >>";
        }

        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        $objects[2] = '<< /Type /Pages /Kids [' . implode(' ', array_map(fn ($id) => "{$id} 0 R", $pageIds)) . '] /Count ' . count($pageIds) . ' >>';
        $objects[$fontId] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';
        ksort($objects);

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$body}\nendobj\n";
        }

        $xref = strlen($pdf);
        $count = max(array_keys($objects)) + 1;
        $pdf .= "xref\n0 {$count}\n0000000000 65535 f \n";
        for ($i = 1; $i < $count; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i] ?? 0);
        }
        $pdf .= "trailer\n<< /Size {$count} /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF";

        file_put_contents($path, $pdf);
    }

    public function cover(): void
    {
        $this->box(36, 636, 523, 146, [7, 95, 228], [7, 95, 228]);
        $this->text(58, 738, 'OnlyFreshers Complete Flow Blueprint', 24, [255, 255, 255]);
        $this->text(58, 711, 'Company, Direct Mode, Fast Track, Training Partner, subscriptions, dates, and hiring.', 10.5, [232, 241, 255]);
        $this->text(58, 689, 'Readable build reference - generated on 29 August 2026', 9, [232, 241, 255]);
        $this->y = 608;
        $this->h1('How to read this PDF');
        $this->p('This document explains the full product journey as one connected system. Use it as a product flow reference while building screens, APIs, database fields, and validations.');
        $this->chips(['Website', 'Company', 'Direct Mode', 'Fast Track', 'Training Partner', 'Certificates', 'Subscriptions']);
    }

    public function h1(string $text): void
    {
        $this->ensure(48);
        $this->text(42, $this->y, $text, 17, [7, 21, 68]);
        $this->y -= 22;
        $this->line(42, $this->y, 553, $this->y, [210, 225, 248]);
        $this->y -= 18;
    }

    public function h2(string $text): void
    {
        $this->ensure(30);
        $this->text(42, $this->y, $text, 12.5, [7, 95, 228]);
        $this->y -= 18;
    }

    public function p(string $text): void
    {
        foreach ($this->wrap($text, 92) as $line) {
            $this->ensure(15);
            $this->text(42, $this->y, $line, 9.5, [39, 52, 82]);
            $this->y -= 13;
        }
        $this->y -= 5;
    }

    public function bullet(array $items): void
    {
        foreach ($items as $item) {
            foreach ($this->wrap($item, 86) as $i => $line) {
                $this->ensure(15);
                $this->text($i === 0 ? 50 : 62, $this->y, ($i === 0 ? '- ' : '  ') . $line, 9.2, [39, 52, 82]);
                $this->y -= 13;
            }
        }
        $this->y -= 7;
    }

    public function chips(array $items): void
    {
        $x = 42;
        foreach ($items as $item) {
            $w = max(64, strlen($item) * 5.4 + 22);
            if ($x + $w > 553) {
                $x = 42;
                $this->y -= 30;
            }
            $this->box($x, $this->y - 17, $w, 24, [238, 246, 255], [190, 215, 248]);
            $this->text($x + 11, $this->y - 9, $item, 8.3, [7, 95, 228]);
            $x += $w + 8;
        }
        $this->y -= 40;
    }

    public function callout(string $title, array $items): void
    {
        $lineCount = 1;
        foreach ($items as $item) {
            $lineCount += count($this->wrap($item, 80));
        }
        $height = 30 + ($lineCount * 13);
        $this->ensure($height + 12);
        $this->box(42, $this->y - $height + 10, 511, $height, [248, 251, 255], [196, 216, 246]);
        $this->text(58, $this->y - 8, $title, 11.3, [7, 21, 68]);
        $yy = $this->y - 28;
        foreach ($items as $item) {
            foreach ($this->wrap($item, 80) as $i => $line) {
                $this->text($i === 0 ? 58 : 69, $yy, ($i === 0 ? '- ' : '  ') . $line, 8.7, [39, 52, 82]);
                $yy -= 13;
            }
        }
        $this->y -= $height + 12;
    }

    public function flow(string $title, array $steps): void
    {
        $heights = [];
        foreach ($steps as $step) {
            $heights[] = max(42, 22 + (count($this->wrap($step, 73)) * 10));
        }
        $height = 34 + array_sum($heights) + ((count($steps) - 1) * 18);
        $this->ensure($height + 16);
        $this->text(42, $this->y, $title, 11.5, [7, 21, 68]);
        $boxY = $this->y - 54;

        foreach ($steps as $index => $step) {
            $this->node(70, $boxY, 455, $heights[$index], $step, $index + 1);
            if ($index < count($steps) - 1) {
                $this->arrow(297.5, $boxY, 297.5, $boxY - 14);
            }
            $boxY -= $heights[$index] + 18;
        }
        $this->y -= $height + 8;
    }

    public function swimlane(string $title, array $rows): void
    {
        $rowHeight = 55;
        $height = 38 + (count($rows) * $rowHeight);
        $this->ensure($height + 12);
        $this->text(42, $this->y, $title, 11.5, [7, 21, 68]);
        $yy = $this->y - 29;
        $cols = [42, 139, 277, 415];
        $widths = [89, 130, 130, 138];
        $headers = ['Actor', 'Starts', 'System Gate', 'Output'];

        foreach ($headers as $i => $header) {
            $this->box($cols[$i], $yy, $widths[$i], 24, [7, 95, 228], [7, 95, 228]);
            $this->text($cols[$i] + 7, $yy + 8, $header, 8.4, [255, 255, 255]);
        }

        $yy -= $rowHeight;
        foreach ($rows as $row) {
            foreach ($row as $i => $cell) {
                $this->box($cols[$i], $yy, $widths[$i], 47, [248, 251, 255], [214, 226, 245]);
                $lineY = $yy + 34;
                foreach (array_slice($this->wrap($cell, (int) floor(($widths[$i] - 14) / 4.8)), 0, 4) as $line) {
                    $this->text($cols[$i] + 7, $lineY, $line, 7.6, [39, 52, 82]);
                    $lineY -= 10;
                }
            }
            $yy -= $rowHeight;
        }
        $this->y -= $height + 6;
    }

    private function header(): void
    {
        $this->text(42, 810, 'OnlyFreshers', 14.5, [7, 95, 228]);
        $this->text(424, 810, 'Complete Flow Blueprint', 8.6, [86, 100, 135]);
        $this->line(42, 794, 553, 794, [225, 233, 246]);
    }

    private function footer(): void
    {
        $this->line(42, 34, 553, 34, [225, 233, 246]);
        $this->text(42, 20, 'OnlyFreshers internal product flow - build reference', 7.8, [110, 123, 152]);
        $this->text(520, 20, (string) $this->pageNo, 7.8, [110, 123, 152]);
    }

    private function ensure(float $needed): void
    {
        if ($this->y - $needed < 54) {
            $this->addPage();
        }
    }

    private function wrap(string $text, int $max): array
    {
        $words = preg_split('/\s+/', trim($text));
        $lines = [];
        $line = '';
        foreach ($words as $word) {
            if (strlen($line . ' ' . $word) > $max && $line !== '') {
                $lines[] = $line;
                $line = $word;
            } else {
                $line = trim($line . ' ' . $word);
            }
        }
        if ($line !== '') {
            $lines[] = $line;
        }
        return $lines;
    }

    private function text(float $x, float $y, string $text, float $size, array $rgb): void
    {
        $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
        $this->current .= sprintf("%.3f %.3f %.3f rg BT /F1 %.2f Tf %.2f %.2f Td (%s) Tj ET\n", $rgb[0] / 255, $rgb[1] / 255, $rgb[2] / 255, $size, $x, $y, $safe);
    }

    private function line(float $x1, float $y1, float $x2, float $y2, array $rgb): void
    {
        $this->current .= sprintf("%.3f %.3f %.3f RG %.2f w %.2f %.2f m %.2f %.2f l S\n", $rgb[0] / 255, $rgb[1] / 255, $rgb[2] / 255, 0.8, $x1, $y1, $x2, $y2);
    }

    private function box(float $x, float $y, float $w, float $h, array $fill, ?array $stroke = null): void
    {
        $stroke ??= $fill;
        $this->current .= sprintf("%.3f %.3f %.3f rg %.3f %.3f %.3f RG %.2f %.2f %.2f %.2f re B\n", $fill[0] / 255, $fill[1] / 255, $fill[2] / 255, $stroke[0] / 255, $stroke[1] / 255, $stroke[2] / 255, $x, $y, $w, $h);
    }

    private function node(float $x, float $y, float $w, float $h, string $label, int $number): void
    {
        $this->box($x, $y, $w, $h, [248, 251, 255], [174, 204, 246]);
        $this->box($x + 10, $y + $h - 25, 18, 18, [7, 95, 228], [7, 95, 228]);
        $this->text($x + 15, $y + $h - 21, (string) $number, 7.7, [255, 255, 255]);
        $yy = $y + $h - 17;
        foreach ($this->wrap($label, (int) max(18, floor(($w - 50) / 5.1))) as $line) {
            $this->text($x + 36, $yy, $line, 8.3, [39, 52, 82]);
            $yy -= 10.5;
        }
    }

    private function arrow(float $x1, float $y1, float $x2, float $y2): void
    {
        $this->line($x1, $y1, $x2, $y2, [7, 95, 228]);
        $dir = $y2 >= $y1 ? 1 : -1;
        $this->line($x2, $y2, $x2 - 4, $y2 - (6 * $dir), [7, 95, 228]);
        $this->line($x2, $y2, $x2 + 4, $y2 - (6 * $dir), [7, 95, 228]);
    }
}

$pdf = new FlowPdf();
$pdf->addPage();
$pdf->cover();

$pdf->h1('One Connected End-to-End Flow');
$pdf->flow('Complete platform journey', [
    'User opens OnlyFreshers website and selects Fresher, Company, Training Partner, or Admin path.',
    'Company registers, completes company profile, receives 500 starting job credits, and waits for Admin approval.',
    'Training Partner registers, completes institute profile, and waits for Admin approval before creating courses.',
    'Admin approves or rejects companies and training partners. Approved users can operate their dashboards.',
    'Company posts a job or internship and chooses hiring mode: Direct Mode or Fast Track Mode.',
    'If the post is published as active, system deducts 50 company job credits. Draft posts do not deduct credits.',
    'Direct Mode freshers apply directly after profile, resume, and initial assessment. Each direct application deducts 50 fresher credits.',
    'Fast Track freshers first enroll in partner course, complete training, pass final assessment, receive certificate, then apply to Fast Track opportunities.',
    'Company receives applications from both Direct Mode and Fast Track pipelines, shortlists candidates, schedules interview, and hires.',
]);
$pdf->swimlane('Actor wise system map', [
    ['Website', 'Home, jobs, courses, direct mode, fast track pages', 'Public browsing and route selection', 'User enters correct role flow'],
    ['Company', 'Register and profile', 'Admin approval plus credit balance', 'Post jobs and hire candidates'],
    ['Direct Fresher', 'Register, profile, resume, initial test', 'Credits and active job deadline', 'Apply directly to company jobs'],
    ['Training Partner', 'Register, profile, course creation', 'Admin approval and course status', 'Train, track, certify freshers'],
    ['Fast Track Fresher', 'Course enrollment and payment', 'Training completion plus final test', 'Certificate plus Fast Track applications'],
    ['Admin', 'Admin login', 'Approvals, statuses, assessments', 'Platform control and monitoring'],
]);

$pdf->h1('Company Flow With Subscription Link');
$pdf->flow('From registration to paid job posting', [
    'Company clicks Company Register from website and creates account.',
    'Company fills profile: name, email, phone, industry, website, address, description, and logo.',
    'System creates company profile with approval_status pending and 500 free job credits.',
    'Admin gets notification and approves the company from Admin Companies.',
    'Approved company opens dashboard and clicks Post Opportunity.',
    'Company enters opportunity details and selects Direct Mode or Fast Track Mode.',
    'Company chooses application last date. Empty means no custom deadline; selected date must be today or future.',
    'Company saves draft or publishes active. Draft does not charge. Active post checks credits.',
    'If credits are 50 or more, 50 credits deduct and job becomes active.',
    'If credits are below 50, publish is blocked and company is linked to /company/billing.',
    'On billing page company selects plan, Razorpay order is created, payment is verified, credits are added, then company returns to /company/post-job.',
]);
$pdf->callout('Company subscription connection', [
    'Posting link: /company/post-job.',
    'Billing link: /company/billing.',
    'Payment purpose: company_subscription.',
    'After successful payment: job_credits increase and subscription_plan is saved.',
    'After payment redirect: /company/post-job.',
]);

$pdf->h1('Direct Mode Flow With Credit Subscription');
$pdf->flow('Direct candidate to company', [
    'Fresher opens Direct Mode from website and registers or logs in.',
    'System creates or uses fresher profile. Starting Direct Mode credits are 250.',
    'Fresher completes phone, qualification, skills, and resume.',
    'Fresher completes initial assessment. Direct Mode applications require this submitted assessment.',
    'Fresher opens Direct Mode jobs and selects an active Direct Mode opportunity.',
    'System checks job status, application last date, duplicate application, profile completeness, resume, and assessment.',
    'If all checks pass and credits are 50 or more, application is created and 50 credits deduct.',
    'If credits are below 50, apply is blocked and fresher is linked to /direct-mode/dashboard#credits.',
    'Fresher chooses Direct Mode plan, Razorpay verifies payment, credits are added, subscription plan and expiry are saved.',
    'Company receives notification and sees the application in company applications.',
]);
$pdf->callout('Direct Mode subscription connection', [
    'Payment purpose: direct_mode_subscription.',
    'Plan adds credits and validity days.',
    'System saves direct_mode_subscription_plan, direct_mode_subscribed_at, and direct_mode_subscription_expires_at.',
    'After successful payment redirect: /direct-mode/dashboard#credits.',
]);

$pdf->h1('Training Partner and Fast Track Connection');
$pdf->flow('Partner course to certificate to hiring', [
    'Training Partner registers from website and completes institute profile.',
    'Admin approves the Training Partner. Without approval, partner should not operate courses as a trusted provider.',
    'Approved partner creates Fast Track course with course details, duration, fees, and status.',
    'Fresher chooses Fast Track and browses available courses.',
    'Fresher enrolls in course. If course has fee, course_enrollment payment flow starts.',
    'Razorpay verifies course payment. Enrollment becomes paid, enrolled, and training_status not_started.',
    'Training Partner tracks fresher progress through training modules and updates training progress.',
    'When training reaches completion, final assessment becomes the important gate.',
    'Fresher takes final assessment. If passed, certification can be generated.',
    'Certificate becomes proof that fresher is Fast Track ready.',
    'Fresher can now apply to Fast Track opportunities posted by companies.',
    'Fast Track application reaches company without Direct Mode credit deduction.',
]);
$pdf->callout('Fast Track link points', [
    'Training Partner links to Fast Track by publishing courses.',
    'Course enrollment links fresher to Training Partner.',
    'Progress and final assessment link training to certificate.',
    'Certificate links fresher readiness to Fast Track hiring.',
    'Fast Track hiring links certified freshers back to Company applications.',
]);

$pdf->h1('How Fast Track Links Back To Company');
$pdf->flow('Certified fresher reaches employer', [
    'Company posts opportunity with hiring_mode fast_track.',
    'Fast Track fresher has course enrollment, training progress, final assessment result, and certificate.',
    'Fresher sees Fast Track job recommendations or job list.',
    'Fresher applies to Fast Track opportunity.',
    'System checks profile and skills. Direct Mode resume and credit deduction rules are lighter for Fast Track in current backend.',
    'Application is saved in same job_applications table as Direct Mode applications.',
    'Company dashboard shows candidate with job, profile, and application status.',
    'Company can move status to under review, shortlisted, rejected, interview, offered, or hired depending on screen logic.',
]);

$pdf->h1('Custom Date and Deadline Logic');
$pdf->flow('Application last date behavior', [
    'Company selects application_last_date while creating or editing job.',
    'System accepts empty value or any date from today onward.',
    'Past dates are rejected during job create or update.',
    'Active job stays visible until deadline logic filters or apply API blocks it.',
    'When fresher clicks Apply, backend checks if application_last_date is older than today.',
    'If expired, application is blocked with last date expired message.',
    'If valid, normal Direct Mode or Fast Track apply checks continue.',
]);
$pdf->callout('Build note for custom date UI', [
    'Use date input in company create/edit forms.',
    'Set min date to today on frontend.',
    'Keep backend validation as final source of truth.',
    'Show deadline on job cards and job details.',
]);

$pdf->h1('Unified Application and Hiring Flow');
$pdf->flow('After application is submitted', [
    'Application is created with application_status applied and applied_at timestamp.',
    'Company receives notification: new application for posted opportunity.',
    'Fresher receives notification: application submitted successfully.',
    'Company opens /company/applications or job details.',
    'Company reviews fresher profile, resume if available, skills, and assessment/training signals.',
    'Company updates status: under review, shortlisted, rejected, hired, or similar final state.',
    'If shortlisted, company schedules interview with interview date, time, mode, and meeting details.',
    'Fresher sees interview under Direct Mode/Fast Track dashboard views.',
    'Company marks result after interview and hiring closes.',
]);

$pdf->h1('Payment Purpose Map');
$pdf->swimlane('What each payment does', [
    ['Company', 'Low job credits or package purchase', 'Razorpay verify', 'Add job credits and save company plan'],
    ['Direct Fresher', 'Low Direct Mode credits or plan purchase', 'Razorpay verify', 'Add direct credits and save expiry date'],
    ['Fast Track Fresher', 'Course enrollment fee', 'Razorpay verify', 'Mark enrollment paid and enrolled'],
]);
$pdf->bullet([
    'Company plans add job posting credits.',
    'Direct Mode plans add fresher application credits plus subscription validity.',
    'Course payments connect fresher to Training Partner course and unlock training journey.',
]);

$pdf->h1('Build Checklist');
$pdf->bullet([
    'Website pages should route users clearly to Company, Direct Mode, Fast Track, Training Partner, and Admin flows.',
    'Company profile save should create pending approval state and initial credits.',
    'Admin approval should unlock company and training partner dashboards.',
    'Job post form should support hiring_mode, status, and application_last_date.',
    'Publishing active job should deduct company credits and redirect to billing when insufficient.',
    'Direct Mode apply should require profile, resume, initial assessment, active job, valid date, and credits.',
    'Fast Track should connect course enrollment, course payment, progress, final assessment, certificate, and job applications.',
    'All payment flows should create Razorpay order, verify signature/payment, update business records, then redirect correctly.',
    'Notifications should be created for registration, approval, application submission, status changes, interviews, and enrollment.',
    'Company applications should combine Direct Mode and Fast Track candidates in one hiring pipeline.',
]);

$output = __DIR__ . '/../../output/pdf/OnlyFreshers_Complete_End_To_End_Flow_Blueprint.pdf';
$pdf->save($output);
echo realpath($output) . PHP_EOL;
