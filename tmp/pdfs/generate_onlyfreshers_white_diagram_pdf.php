<?php

final class DiagramPdf
{
    private array $pages = [];
    private string $current = '';
    private int $pageNo = 0;
    private const W = 595.28;
    private const H = 841.89;

    public function addPage(string $title): void
    {
        if ($this->current !== '') {
            $this->footer();
            $this->pages[] = $this->current;
        }

        $this->pageNo++;
        $this->current = '';
        $this->text(36, 804, 'OnlyFreshers Flow Diagram', 12, [7, 95, 228]);
        $this->text(36, 778, $title, 22, [7, 21, 68]);
        $this->line(36, 760, 559, 760, [222, 230, 242], 1);
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

    public function node(float $x, float $y, float $w, float $h, string $title, string $body = '', array $fill = [255, 255, 255], array $stroke = [166, 190, 226]): void
    {
        $this->box($x, $y, $w, $h, $fill, $stroke, 1.2);
        $this->text($x + 12, $y + $h - 20, $title, 10.8, [7, 21, 68]);
        if ($body !== '') {
            $yy = $y + $h - 38;
            foreach (array_slice($this->wrap($body, (int) floor(($w - 24) / 5)), 0, 4) as $line) {
                $this->text($x + 12, $yy, $line, 8.3, [63, 75, 103]);
                $yy -= 11;
            }
        }
    }

    public function label(float $x, float $y, string $text, array $rgb = [63, 75, 103]): void
    {
        $this->text($x, $y, $text, 8.2, $rgb);
    }

    public function arrow(float $x1, float $y1, float $x2, float $y2, string $label = ''): void
    {
        $this->line($x1, $y1, $x2, $y2, [7, 95, 228], 1);
        $angle = atan2($y2 - $y1, $x2 - $x1);
        $len = 7;
        $a1 = $angle + 2.6;
        $a2 = $angle - 2.6;
        $this->line($x2, $y2, $x2 + cos($a1) * $len, $y2 + sin($a1) * $len, [7, 95, 228], 1);
        $this->line($x2, $y2, $x2 + cos($a2) * $len, $y2 + sin($a2) * $len, [7, 95, 228], 1);
        if ($label !== '') {
            $this->text(($x1 + $x2) / 2 - 18, ($y1 + $y2) / 2 + 7, $label, 7.6, [7, 95, 228]);
        }
    }

    public function decision(float $cx, float $cy, float $w, float $h, string $text): void
    {
        $x1 = $cx;
        $y1 = $cy + ($h / 2);
        $x2 = $cx + ($w / 2);
        $y2 = $cy + $h;
        $x3 = $cx + $w;
        $y3 = $cy + ($h / 2);
        $x4 = $cx + ($w / 2);
        $y4 = $cy;
        $this->current .= sprintf("1.000 1.000 1.000 rg 0.651 0.745 0.886 RG 1.20 w %.2f %.2f m %.2f %.2f l %.2f %.2f l %.2f %.2f l h B\n", $x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4);
        $yy = $cy + ($h / 2) + 7;
        foreach (array_slice($this->wrap($text, (int) floor($w / 5)), 0, 3) as $line) {
            $this->text($cx + 16, $yy, $line, 8.6, [7, 21, 68]);
            $yy -= 11;
        }
    }

    public function note(float $x, float $y, float $w, array $items): void
    {
        $h = 22 + count($items) * 15;
        $this->box($x, $y, $w, $h, [248, 251, 255], [214, 226, 245], 1);
        $yy = $y + $h - 18;
        foreach ($items as $item) {
            $this->text($x + 12, $yy, '- ' . $item, 8, [63, 75, 103]);
            $yy -= 15;
        }
    }

    private function footer(): void
    {
        $this->line(36, 36, 559, 36, [222, 230, 242], 1);
        $this->text(36, 20, 'White page diagram blueprint - no code', 8, [110, 123, 152]);
        $this->text(524, 20, (string) $this->pageNo, 8, [110, 123, 152]);
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

    private function line(float $x1, float $y1, float $x2, float $y2, array $rgb, float $width): void
    {
        $this->current .= sprintf("%.3f %.3f %.3f RG %.2f w %.2f %.2f m %.2f %.2f l S\n", $rgb[0] / 255, $rgb[1] / 255, $rgb[2] / 255, $width, $x1, $y1, $x2, $y2);
    }

    private function box(float $x, float $y, float $w, float $h, array $fill, array $stroke, float $width): void
    {
        $this->current .= sprintf("%.3f %.3f %.3f rg %.3f %.3f %.3f RG %.2f w %.2f %.2f %.2f %.2f re B\n", $fill[0] / 255, $fill[1] / 255, $fill[2] / 255, $stroke[0] / 255, $stroke[1] / 255, $stroke[2] / 255, $width, $x, $y, $w, $h);
    }
}

$pdf = new DiagramPdf();

$pdf->addPage('1. Master Flowchart');
$pdf->node(222, 684, 150, 52, 'Website', 'User opens OnlyFreshers');
$pdf->node(48, 582, 128, 58, 'Company Side', 'Register, profile, admin approval');
$pdf->node(234, 582, 128, 58, 'Fresher Side', 'Choose Direct Mode or Fast Track');
$pdf->node(420, 582, 128, 58, 'Partner Side', 'Training partner approval and courses');
$pdf->arrow(297, 674, 112, 626, 'company');
$pdf->arrow(297, 674, 298, 626, 'fresher');
$pdf->arrow(297, 674, 484, 626, 'partner');
$pdf->node(48, 458, 128, 62, 'Post Opportunity', 'Job or internship mode selected');
$pdf->node(234, 458, 128, 62, 'Mode Selection', 'Direct apply or Fast Track course');
$pdf->node(420, 458, 128, 62, 'Course System', 'Training, progress, certificate');
$pdf->arrow(112, 568, 112, 510);
$pdf->arrow(298, 568, 298, 510);
$pdf->arrow(484, 568, 484, 510);
$pdf->node(142, 324, 150, 62, 'Direct Application', 'Profile + resume + initial test + credits');
$pdf->node(314, 324, 150, 62, 'Fast Track Application', 'Course + final test + certificate');
$pdf->arrow(234, 448, 217, 380, 'direct');
$pdf->arrow(484, 448, 389, 380, 'fast track');
$pdf->node(222, 206, 150, 62, 'Company Hiring', 'Review, shortlist, interview, hire');
$pdf->arrow(217, 318, 270, 256);
$pdf->arrow(389, 318, 326, 256);
$pdf->node(70, 92, 150, 54, 'Subscription Link', 'Company credits and Direct Mode credits');
$pdf->node(374, 92, 150, 54, 'Final Output', 'Candidate hired by company');
$pdf->arrow(222, 119, 270, 206);
$pdf->arrow(374, 119, 326, 206);

$pdf->addPage('2. Company Posting + Subscription');
$pdf->node(48, 674, 130, 52, 'Company Register', 'Account from company register page');
$pdf->node(232, 674, 130, 52, 'Profile Submit', 'Company details saved as pending');
$pdf->node(416, 674, 130, 52, 'Admin Approval', 'Approve or reject company');
$pdf->arrow(178, 700, 232, 700);
$pdf->arrow(362, 700, 416, 700);
$pdf->node(232, 574, 130, 54, '500 Free Credits', 'Added when first profile is created');
$pdf->arrow(297, 674, 297, 628);
$pdf->node(48, 472, 130, 58, 'Post Job', 'Fill title, skills, salary, mode, last date');
$pdf->decision(238, 462, 118, 74, 'Publish Active?');
$pdf->node(416, 484, 130, 46, 'Draft Saved', 'No credit deduction');
$pdf->arrow(178, 501, 238, 501);
$pdf->arrow(356, 501, 416, 507, 'no');
$pdf->decision(238, 340, 118, 74, 'Credits >= 50?');
$pdf->arrow(297, 462, 297, 414, 'yes');
$pdf->node(48, 284, 130, 54, 'Active Job Live', '50 credits deducted');
$pdf->node(416, 284, 130, 54, 'Billing Page', 'Choose hiring plan');
$pdf->arrow(238, 377, 178, 312, 'yes');
$pdf->arrow(356, 377, 416, 312, 'no');
$pdf->node(416, 180, 130, 54, 'Razorpay Verify', 'Payment success');
$pdf->node(232, 180, 130, 54, 'Credits Added', 'Return to post job');
$pdf->arrow(481, 284, 481, 234);
$pdf->arrow(416, 207, 362, 207);
$pdf->note(56, 86, 482, [
    'Active post cost: 50 company credits.',
    'Billing links back to posting after payment.',
    'Application last date is selected inside job form.'
]);

$pdf->addPage('3. Direct Mode Credit Flow');
$pdf->node(44, 674, 128, 52, 'Direct Register', 'Fresher account');
$pdf->node(232, 674, 128, 52, 'Profile Complete', 'Phone, qualification, skills, resume');
$pdf->node(420, 674, 128, 52, 'Initial Assessment', 'Submitted before applying');
$pdf->arrow(172, 700, 232, 700);
$pdf->arrow(360, 700, 420, 700);
$pdf->node(232, 574, 128, 52, '250 Free Credits', 'Starting Direct Mode credits');
$pdf->arrow(296, 674, 296, 626);
$pdf->node(44, 462, 128, 58, 'Open Jobs', 'Direct Mode active jobs');
$pdf->decision(232, 452, 128, 78, 'Checks Pass?');
$pdf->node(420, 468, 128, 52, 'Blocked', 'Incomplete profile, expired date, duplicate, inactive job');
$pdf->arrow(172, 491, 232, 491);
$pdf->arrow(360, 491, 420, 494, 'no');
$pdf->decision(232, 326, 128, 78, 'Credits >= 50?');
$pdf->arrow(296, 452, 296, 404, 'yes');
$pdf->node(44, 268, 128, 54, 'Apply Success', '50 credits deducted');
$pdf->node(420, 268, 128, 54, 'Buy Plan', 'Direct subscription');
$pdf->arrow(232, 365, 172, 295, 'yes');
$pdf->arrow(360, 365, 420, 295, 'no');
$pdf->node(232, 168, 128, 54, 'Company Gets App', 'Notification and review');
$pdf->arrow(108, 268, 232, 195);
$pdf->arrow(420, 268, 360, 195, 'after pay');
$pdf->note(58, 82, 480, [
    'Direct plan adds credits and expiry date.',
    'Direct application uses same company application table.',
    'Direct Mode requires resume and initial assessment.'
]);

$pdf->addPage('4. Fast Track + Training Partner');
$pdf->node(48, 684, 130, 48, 'Partner Register', 'Institute account');
$pdf->node(232, 684, 130, 48, 'Admin Approval', 'Verified training partner');
$pdf->node(416, 684, 130, 48, 'Create Course', 'Fast Track course listed');
$pdf->arrow(178, 708, 232, 708);
$pdf->arrow(362, 708, 416, 708);
$pdf->node(48, 570, 130, 52, 'Fresher Enrolls', 'Chooses partner course');
$pdf->node(232, 570, 130, 52, 'Course Payment', 'Razorpay enrollment payment');
$pdf->node(416, 570, 130, 52, 'Training Starts', 'Partner tracks progress');
$pdf->arrow(481, 684, 113, 622);
$pdf->arrow(178, 596, 232, 596);
$pdf->arrow(362, 596, 416, 596);
$pdf->node(48, 448, 130, 54, 'Progress 100%', 'Training complete');
$pdf->node(232, 448, 130, 54, 'Final Assessment', 'Pass gate');
$pdf->node(416, 448, 130, 54, 'Certificate', 'Fast Track ready proof');
$pdf->arrow(481, 570, 113, 502);
$pdf->arrow(178, 475, 232, 475);
$pdf->arrow(362, 475, 416, 475);
$pdf->node(142, 300, 130, 56, 'Fast Track Job', 'Company posted fast_track opportunity');
$pdf->node(324, 300, 130, 56, 'Apply to Company', 'No Direct Mode credit deduction');
$pdf->arrow(481, 448, 389, 356);
$pdf->arrow(272, 328, 324, 328);
$pdf->node(232, 178, 130, 56, 'Hiring Pipeline', 'Shortlist, interview, hire');
$pdf->arrow(389, 300, 297, 234);
$pdf->note(56, 84, 482, [
    'Training Partner connects to Fast Track through courses.',
    'Certificate connects trained fresher back to company hiring.',
    'Fast Track application joins the same company review flow.'
]);

$pdf->addPage('5. Deadline + Final Hiring');
$pdf->node(48, 676, 132, 52, 'Company Form', 'Select application last date');
$pdf->decision(238, 664, 120, 78, 'Date Today/Future?');
$pdf->node(416, 682, 132, 46, 'Save Job', 'Deadline stored');
$pdf->arrow(180, 702, 238, 703);
$pdf->arrow(358, 703, 416, 705, 'yes');
$pdf->node(232, 574, 132, 48, 'Validation Error', 'Past date blocked');
$pdf->arrow(298, 664, 298, 622, 'no');
$pdf->node(48, 464, 132, 54, 'Fresher Clicks Apply', 'Direct or Fast Track');
$pdf->decision(238, 452, 120, 78, 'Deadline Expired?');
$pdf->node(416, 470, 132, 46, 'Apply Blocked', 'Last date expired');
$pdf->node(232, 342, 132, 50, 'Application Saved', 'Status: applied');
$pdf->arrow(114, 464, 238, 491);
$pdf->arrow(358, 491, 416, 493, 'yes');
$pdf->arrow(298, 452, 298, 392, 'no');
$pdf->node(48, 238, 132, 54, 'Company Review', 'Profile, resume, assessment, certificate');
$pdf->node(232, 238, 132, 54, 'Shortlist', 'Move candidate forward');
$pdf->node(416, 238, 132, 54, 'Interview', 'Date, time, mode');
$pdf->arrow(298, 342, 114, 292);
$pdf->arrow(180, 265, 232, 265);
$pdf->arrow(364, 265, 416, 265);
$pdf->node(232, 124, 132, 54, 'Final Result', 'Hired or rejected');
$pdf->arrow(482, 238, 298, 178);
$pdf->note(56, 62, 482, [
    'Custom date controls application deadline.',
    'After application, Direct and Fast Track candidates use one hiring flow.',
]);

$output = __DIR__ . '/../../output/pdf/OnlyFreshers_Visual_Flowchart_Diagram.pdf';
$pdf->save($output);
echo realpath($output) . PHP_EOL;
