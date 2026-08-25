<?php

final class SimplePdf
{
    private array $pages = [];
    private string $current = '';
    private float $x = 42;
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
        $this->x = 42;
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
        $fontId = 3;
        $pageIds = [];

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

    public function title(string $text): void
    {
        $this->box(36, 666, 523, 116, [7, 95, 228]);
        $this->text(58, 738, $text, 24, [255, 255, 255]);
        $this->text(58, 710, 'Updated tester documentation aligned with the current Laravel project flow.', 11, [230, 240, 255]);
        $this->text(58, 690, 'Generated on 22 August 2026', 9, [230, 240, 255]);
        $this->y = 642;
    }

    public function h1(string $text): void
    {
        $this->ensure(42);
        $this->text(42, $this->y, $text, 18, [7, 21, 68]);
        $this->y -= 24;
        $this->line(42, $this->y, 553, $this->y, [210, 225, 248]);
        $this->y -= 18;
    }

    public function h2(string $text): void
    {
        $this->ensure(32);
        $this->text(42, $this->y, $text, 13, [7, 95, 228]);
        $this->y -= 18;
    }

    public function p(string $text): void
    {
        foreach ($this->wrap($text, 92) as $line) {
            $this->ensure(16);
            $this->text(42, $this->y, $line, 10, [39, 52, 82]);
            $this->y -= 14;
        }
        $this->y -= 5;
    }

    public function bullet(array $items): void
    {
        foreach ($items as $item) {
            foreach ($this->wrap($item, 86) as $i => $line) {
                $this->ensure(16);
                $this->text($i === 0 ? 50 : 62, $this->y, ($i === 0 ? '- ' : '  ') . $line, 10, [39, 52, 82]);
                $this->y -= 14;
            }
        }
        $this->y -= 6;
    }

    public function callout(string $title, array $items): void
    {
        $height = 34 + (count($items) * 18);
        $this->ensure($height + 12);
        $this->box(42, $this->y - $height + 12, 511, $height, [245, 249, 255], [196, 216, 246]);
        $this->text(58, $this->y - 8, $title, 12, [7, 21, 68]);
        $yy = $this->y - 30;
        foreach ($items as $item) {
            $this->text(58, $yy, '- ' . $item, 9.4, [39, 52, 82]);
            $yy -= 17;
        }
        $this->y -= $height + 12;
    }

    public function flowDiagram(string $title, array $steps, string $mode = 'vertical'): void
    {
        $boxW = 455;
        $boxHeights = [];
        foreach ($steps as $step) {
            $lines = $this->wrap($step, 74);
            $boxHeights[] = max(44, 24 + (count($lines) * 11));
        }
        $height = 36 + array_sum($boxHeights) + ((count($steps) - 1) * 22);
        $this->ensure($height + 18);
        $top = $this->y;
        $this->text(42, $top, $title, 12, [7, 21, 68]);

        $x = 70;
        $boxY = $top - 58;

        foreach ($steps as $index => $step) {
            $boxH = $boxHeights[$index];
            $this->node($x, $boxY, $boxW, $boxH, $step, $index + 1);
            if ($index < count($steps) - 1) {
                $this->arrow($x + ($boxW / 2), $boxY, $x + ($boxW / 2), $boxY - 16);
            }
            $boxY -= $boxH + 22;
        }

        $this->y -= $height + 8;
    }

    public function matrix(string $title, array $rows): void
    {
        $rowHeight = 48;
        $height = 38 + (count($rows) * $rowHeight);
        $this->ensure($height + 12);
        $this->text(42, $this->y, $title, 12, [7, 21, 68]);
        $yy = $this->y - 28;
        $cols = [42, 168, 308, 438];
        $widths = [118, 132, 122, 115];
        $headers = ['Flow', 'Starts With', 'Main Gate', 'Ends At'];

        foreach ($headers as $i => $header) {
            $this->box($cols[$i], $yy, $widths[$i], 24, [7, 95, 228], [7, 95, 228]);
            $this->text($cols[$i] + 8, $yy + 8, $header, 8.5, [255, 255, 255]);
        }

        $yy -= $rowHeight;
        foreach ($rows as $row) {
            foreach ($row as $i => $cell) {
                $this->box($cols[$i], $yy, $widths[$i], 40, [248, 251, 255], [214, 226, 245]);
                $lines = $this->wrap($cell, (int) floor(($widths[$i] - 14) / 4.9));
                $lineY = $yy + 27;
                foreach (array_slice($lines, 0, 3) as $line) {
                    $this->text($cols[$i] + 7, $lineY, $line, 7.8, [39, 52, 82]);
                    $lineY -= 10;
                }
            }
            $yy -= $rowHeight;
        }

        $this->y -= $height + 6;
    }

    private function header(): void
    {
        $this->text(42, 810, 'OnlyFreshers', 15, [7, 95, 228]);
        $this->text(445, 810, 'Flow Tracker', 9, [86, 100, 135]);
        $this->line(42, 794, 553, 794, [225, 233, 246]);
    }

    private function footer(): void
    {
        $this->line(42, 34, 553, 34, [225, 233, 246]);
        $this->text(42, 20, 'OnlyFreshers project documentation - internal testing copy', 8, [110, 123, 152]);
        $this->text(520, 20, (string) $this->pageNo, 8, [110, 123, 152]);
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
        $this->box($x + 10, $y + $h - 26, 18, 18, [7, 95, 228], [7, 95, 228]);
        $this->text($x + 15, $y + $h - 22, (string) $number, 8, [255, 255, 255]);

        $lines = $this->wrap($label, (int) max(18, floor(($w - 48) / 5.1)));
        $yy = $y + $h - 18;
        foreach ($lines as $line) {
            $this->text($x + 36, $yy, $line, 8.6, [39, 52, 82]);
            $yy -= 11;
        }
    }

    private function arrow(float $x1, float $y1, float $x2, float $y2): void
    {
        $this->line($x1, $y1, $x2, $y2, [7, 95, 228]);

        if (abs($x2 - $x1) >= abs($y2 - $y1)) {
            $dir = $x2 >= $x1 ? 1 : -1;
            $this->line($x2, $y2, $x2 - (6 * $dir), $y2 + 4, [7, 95, 228]);
            $this->line($x2, $y2, $x2 - (6 * $dir), $y2 - 4, [7, 95, 228]);
        } else {
            $dir = $y2 >= $y1 ? 1 : -1;
            $this->line($x2, $y2, $x2 - 4, $y2 - (6 * $dir), [7, 95, 228]);
            $this->line($x2, $y2, $x2 + 4, $y2 - (6 * $dir), [7, 95, 228]);
        }
    }
}

$pdf = new SimplePdf();
$pdf->addPage();
$pdf->title('OnlyFreshers Product Flow Document');

$pdf->h1('Product Flow Overview');
$pdf->p('This document explains the OnlyFreshers flow through diagrams. Jobs and internships follow the same opportunity posting and application journey.');

$pdf->matrix('Role flow summary', [
    ['Fresher', 'Direct/Fast Track', 'Assessment or training', 'Apply and get hired'],
    ['Company', 'Register', 'Admin approval', 'Post and hire'],
    ['Training Partner', 'Register', 'Admin approval', 'Train and certify'],
    ['Admin', 'Login', 'Approve/manage', 'Monitor platform'],
]);
$pdf->flowDiagram('Main Platform Flow', [
    'User opens OnlyFreshers website.',
    'User selects Fresher, Company, or Training Partner.',
    'Fresher chooses Direct Mode or Fast Track.',
    'Company and Training Partner wait for Admin approval.',
    'Company posts jobs/internships. Training Partner publishes courses.',
    'Fresher applies, gets shortlisted, attends interview, receives offer, and gets hired.',
]);

$pdf->h1('Entry Routes');
$pdf->bullet([
    'Fresher: /direct-mode/register or /fresher/register',
    'Company: /company/register',
    'Training Partner: /training-partner/register',
    'Admin: /admin/login',
]);

$pdf->h1('Company Flow');
$pdf->flowDiagram('Company Registration and Posting', [
    'Company registers from /company/register.',
    'System gives 500 free job credits.',
    'Company profile goes to Admin approval.',
    'Admin approves company from /admin/companies.',
    'Company opens dashboard and creates job or internship.',
    'If opportunity is active, 50 credits are deducted.',
    'Applications come to company dashboard.',
    'Company shortlists, schedules interview, offers, and hires.',
]);
$pdf->callout('Company rules', [
    'Starting credits: 500.',
    'Active job/internship post cost: 50 credits.',
    'Draft post cost: 0 credits.',
    'Low credits route: /company/billing.',
]);

$pdf->h1('Direct Mode Flow');
$pdf->flowDiagram('Fresher Direct Application', [
    'Fresher registers from /direct-mode/register.',
    'System gives 250 Direct Mode credits.',
    'Fresher completes profile, skills, resume, and initial assessment.',
    'Fresher opens /direct-mode/jobs.',
    'Fresher applies to active job or internship.',
    'System deducts 50 credits.',
    'Application appears in /direct-mode/applications.',
    'Company reviews the application and continues hiring process.',
]);
$pdf->callout('Direct Mode rules', [
    'Starting credits: 250.',
    'Application cost: 50 credits.',
    'Required before apply: profile, skills, resume, initial assessment.',
    'Low credits route: /direct-mode/dashboard#credits.',
]);

$pdf->h1('Fast Track Flow');
$pdf->flowDiagram('Training to Hiring', [
    'Fresher chooses Fast Track.',
    'Fresher selects course from approved Training Partner.',
    'Fresher enrolls and completes payment.',
    'Training Partner updates training progress.',
    'At 100 percent progress, final assessment unlocks.',
    'Fresher passes final assessment.',
    'Certificate is generated.',
    'Fresher applies to Fast Track company opportunities.',
]);
$pdf->callout('Fast Track rules', [
    'Final assessment pass percentage: 60.',
    'Maximum final assessment attempts: 3.',
    'Fast Track apply does not cut Direct Mode credits.',
    'Hiring is handled by Company flow after training.',
]);

$pdf->h1('Training Partner Flow');
$pdf->flowDiagram('Course and Certificate Flow', [
    'Training Partner registers from /training-partner/register.',
    'Partner completes institute profile.',
    'Profile waits for Admin approval.',
    'Admin approves partner from /admin/training-partners.',
    'Partner creates course from /training-partner/add-course.',
    'Freshers enroll in course.',
    'Partner updates progress and manages enrollments.',
    'Partner issues certificate after training completion.',
    'After this, hiring continues in Fast Track and Company flow.',
]);

$pdf->h1('Admin Flow');
$pdf->flowDiagram('Approval and Control Flow', [
    'Admin logs in from /admin/login.',
    'Admin approves or rejects companies.',
    'Admin approves or rejects training partners.',
    'Admin manages assessment questions.',
    'Admin monitors jobs, courses, applications, and enrollments.',
    'Admin checks notifications and system activity.',
]);

$pdf->h1('Subscription Flow');
$pdf->flowDiagram('Company credit logic', [
    'Company starts with 500 credits.',
    'Company publishes active opportunity.',
    'System checks if credits are 50 or more.',
    'If yes, publish succeeds and 50 credits are deducted.',
    'If no, publish is blocked.',
    'Company is sent to /company/billing.',
]);
$pdf->flowDiagram('Direct Mode fresher credit logic', [
    'Fresher starts with 250 credits.',
    'Fresher applies to Direct Mode opportunity.',
    'System checks if credits are 50 or more.',
    'If yes, apply succeeds and 50 credits are deducted.',
    'If no, apply is blocked.',
    'Fresher is sent to /direct-mode/dashboard#credits.',
]);

$pdf->h1('Jobs vs Internships');
$pdf->flowDiagram('Internship uses same opportunity flow', [
    'Company creates internship as opportunity.',
    'Active internship post deducts 50 company credits.',
    'Fresher sees internship in jobs/opportunities list.',
    'Direct Mode fresher applies after profile and assessment.',
    'Direct Mode apply deducts 50 fresher credits.',
    'Company processes application like a job application.',
]);

$pdf->h1('Notification Flow');
$pdf->flowDiagram('Bell notification behavior', [
    'Event happens: registration, approval, application, interview, enrollment, or status update.',
    'Notification is created for target user.',
    'Top bell badge shows unread count.',
    'User opens bell popup.',
    'User clicks notification.',
    'Notification becomes read.',
    'Badge count reduces or hides at zero.',
]);
$pdf->callout('Notification targets', [
    'Admin: new Company registration and new Training Partner registration/profile submission.',
    'Company: approval/rejection result and new fresher application.',
    'Fresher: application status changes, interview schedule, offer or hire result.',
    'Training Partner: approval/rejection result and new course enrollment.',
]);

$pdf->h1('Route Map');
$pdf->bullet([
    'Public: /, /direct-mode, /fast-track, /training-partners, /jobs, /courses',
    'Fresher Direct Mode: /direct-mode/register, /direct-mode/login, /direct-mode/dashboard, /direct-mode/jobs, /direct-mode/applications, /direct-mode/interviews',
    'Fast Track: /fast-track/dashboard, /fast-track/courses, /fast-track/training-progress, /fast-track/final-assessment, /fast-track/job-recommendations',
    'Company: /company/register, /company/login, /company/dashboard, /company/post-job, /company/jobs, /company/applications, /company/billing',
    'Training Partner: /training-partner/register, /training-partner/login, /training-partner/dashboard, /training-partner/add-course, /training-partner/enrollments',
    'Admin: /admin/login, /admin/dashboard, /admin/companies, /admin/training-partners, /admin/jobs, /admin/courses, /admin/notifications',
]);

$pdf->h1('Final Flow Checklist');
$pdf->bullet([
    'Company registration creates admin notification and 500 credits.',
    'Company approval unlocks company dashboard and job/internship posting.',
    'Company active posting deducts 50 credits.',
    'Company low credit state blocks posting and opens billing.',
    'Fresher registration creates 250 Direct Mode credits.',
    'Direct Mode apply deducts 50 credits.',
    'Direct Mode low credit state blocks apply and opens credits section.',
    'Training Partner registration requires admin approval before course creation.',
    'Fast Track final assessment is locked until training completion.',
    'Notifications appear in top bell popup and become read after clicking.',
]);

$output = __DIR__ . '/../../output/pdf/OnlyFreshers_Updated_Documentation_Flow_Tracker_EN.pdf';
$pdf->save($output);
echo $output . PHP_EOL;
