<?php

namespace App\Http\Controllers;

use App\Models\DomainSearchLog;
use Illuminate\Http\Request;

class DomainSearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|min:3|max:100',
        ]);

        $domain = strtolower(trim($request->domain));
        $domain = preg_replace('/^https?:\/\//', '', $domain);
        $domain = rtrim($domain, '/');

        // Log the search
        DomainSearchLog::create([
            'domain' => $domain,
            'ip' => $request->ip(),
        ]);

        // Check availability using DNS
        $results = $this->checkDomain($domain);

        return response()->json($results);
    }

    private function checkDomain(string $domain): array
    {
        $baseName = preg_replace('/\.[^.]+$/', '', $domain);
        $baseName = explode('.', $baseName)[0];

        $tlds = ['.com', '.net', '.org', '.io', '.co', '.ge', '.dev', '.app'];
        $results = [];

        foreach ($tlds as $tld) {
            $fullDomain = $baseName . $tld;
            $available = !$this->domainExists($fullDomain);

            $prices = [
                '.com' => 12, '.net' => 14, '.org' => 13,
                '.io' => 39, '.co' => 25, '.ge' => 20,
                '.dev' => 18, '.app' => 20,
            ];

            $results[] = [
                'domain' => $fullDomain,
                'available' => $available,
                'price' => $prices[$tld] ?? 15,
                'tld' => $tld,
            ];
        }

        // Sort: available first
        usort($results, fn($a, $b) => $b['available'] - $a['available']);

        return $results;
    }

    private function domainExists(string $domain): bool
    {
        return checkdnsrr($domain, 'ANY');
    }
}
