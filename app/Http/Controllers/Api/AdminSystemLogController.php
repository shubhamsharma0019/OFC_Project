<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class AdminSystemLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user();

        if (!$admin || $admin->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can access system logs.',
            ], 403);
        }

        $logFiles = collect(File::files(storage_path('logs')))
            ->filter(fn($file) => $file->getExtension() === 'log')
            ->map(fn($file) => [
                'name' => $file->getFilename(),
                'size' => $file->getSize(),
                'updated_at' => date('Y-m-d H:i:s', $file->getMTime()),
            ])
            ->values();

        $validated = $request->validate([
            'file' => [
                'nullable',
                'string',
                Rule::in($logFiles->pluck('name')->all()),
            ],
            'level' => ['nullable', Rule::in(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'])],
            'search' => ['nullable', 'string', 'max:200'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $selectedFile = $validated['file'] ?? ($logFiles->first()['name'] ?? null);
        $entries = collect();

        if ($selectedFile) {
            $path = storage_path('logs/' . $selectedFile);
            $lines = File::exists($path) ? File::lines($path)->all() : [];
            $entries = $this->parseLines(array_slice($lines, -1000), $selectedFile);
        }

        $entries = $entries
            ->when($validated['level'] ?? null, fn($items, $level) => $items->where('level', $level))
            ->when($validated['search'] ?? null, function ($items, string $search) {
                $needle = strtolower($search);

                return $items->filter(
                    fn($entry) => str_contains(strtolower($entry['message']), $needle)
                        || str_contains(strtolower($entry['context']), $needle)
                        || str_contains(strtolower($entry['file']), $needle)
                );
            })
            ->values();

        $perPage = $validated['per_page'] ?? 20;
        $page = $validated['page'] ?? 1;
        $total = $entries->count();
        $pagedEntries = $entries
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'System logs fetched successfully.',
            'data' => [
                'files' => $logFiles,
                'selected_file' => $selectedFile,
                'stats' => [
                    'total_files' => $logFiles->count(),
                    'total_entries' => $total,
                    'errors' => $entries->whereIn('level', ['error', 'critical', 'alert', 'emergency'])->count(),
                    'warnings' => $entries->where('level', 'warning')->count(),
                ],
                'logs' => [
                    'data' => $pagedEntries,
                    'current_page' => $page,
                    'last_page' => (int) max(1, ceil($total / $perPage)),
                    'per_page' => $perPage,
                    'total' => $total,
                ],
            ],
        ]);
    }

    private function parseLines(array $lines, string $file): \Illuminate\Support\Collection
    {
        $entries = collect();
        $current = null;

        foreach ($lines as $line) {
            $line = rtrim($line, "\r\n");

            if (preg_match('/^\[(?<time>[^\]]+)\]\s+(?<env>[^.]+)\.(?<level>[^:]+):\s*(?<message>.*)$/', $line, $matches)) {
                if ($current) {
                    $entries->push($current);
                }

                $current = [
                    'file' => $file,
                    'timestamp' => $matches['time'],
                    'environment' => $matches['env'],
                    'level' => strtolower($matches['level']),
                    'message' => $matches['message'],
                    'context' => '',
                ];

                continue;
            }

            if ($current) {
                $current['context'] = trim($current['context'] . "\n" . $line);
            } elseif ($line !== '') {
                $entries->push([
                    'file' => $file,
                    'timestamp' => null,
                    'environment' => null,
                    'level' => 'info',
                    'message' => $line,
                    'context' => '',
                ]);
            }
        }

        if ($current) {
            $entries->push($current);
        }

        return $entries->reverse()->values();
    }
}
