<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class DetectSQLInjection
{
    /**
     * Common SQL injection keywords or patterns (basic).
     */
    protected $patterns = [
        '/select\s.+\sfrom/i',
        '/union\s+select/i',
        '/insert\s+into/i',
        '/drop\s+table/i',
        '/update\s.+\sset/i',
        '/delete\s+from/i',
        '/--/',                // comment-style injection
        '/\bor\b.+=/i',        // e.g. '1'='1'
        '/\band\b.+=/i',
        '/sleep\(/i',
        '/benchmark\(/i',
        '/information_schema/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && $this->isSQLInjection($value)) {
                return response()->json([
                    'message' => 'Possible SQL injection detected.',
                    'field' => $key
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        return $next($request);
    }

    protected function isSQLInjection(string $input): bool
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        return false;
    }
}
