<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CleanInputData
{
    /**
     * Handle an incoming request and clean all string inputs.
     */
    public function handle(Request $request, Closure $next)
    {
        $cleaned = $this->clean($request->all());

        // Replace the current request input with the cleaned version
        $request->merge($cleaned);

        return $next($request);
    }

    /**
     * Recursively clean input data.
     *
     * @param  mixed  $data
     * @return mixed
     */
    protected function clean($data)
    {
        foreach ($data as $key => $value) {
            // Recursively clean arrays
            if (is_array($value)) {
                $data[$key] = $this->clean($value);
            }

            // Trim strings and convert empty strings to null
            elseif (is_string($value)) {
                $trimmed = trim($value);
                $data[$key] = $trimmed === '' ? null : $trimmed;
            }
        }

        return $data;
    }
}
