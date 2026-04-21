<?php

namespace App\Services;

use App\Models\DomainSearchLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DomainSearchService
{
    private $externalApiBaseUrl;

    public function __construct()
    {
        // In a real application, this would be configured in .env
        $this->externalApiBaseUrl = env('EXTERNAL_DOMAIN_API_URL', 'https://api.example.com/domain/');
    }

    /**
     * Searches for domain availability and pricing, with caching.
     *
     * @param string $domain The domain name to search for.
     * @param string|null $ip The IP address of the requester for logging.
     * @return array The search results.
     */
    public function searchDomain(string $domain, ?string $ip = null): array
    {
        // Log the search
        DomainSearchLog::create([
            'domain' => $domain,
            'ip' => $ip,
        ]);

        $cacheKey = 'domain_search_' . md5($domain);
        $ttl = 60 * 60; // Cache for 1 hour

        return Cache::remember($cacheKey, $ttl, function () use ($domain) {
            return $this->callExternalDomainApi($domain);
        });
    }

   private function callExternalDomainApi(string $domain): array
  {
    $baseName = preg_replace('/\.[^.]+$/', '', $domain);
    $baseName = explode('.', $baseName)[0];

    $tlds = ['.com', '.net', '.org', '.io', '.co', '.ge', '.dev', '.app'];

    $prices = [
        '.com' => 12, '.net' => 14, '.org' => 13,
        '.io' => 39, '.co' => 25, '.ge' => 20,
        '.dev' => 18, '.app' => 20,
    ];

    $results = [];

    foreach ($tlds as $tld) {
        $fullDomain = $baseName . $tld;
        
        // DNS lookup - თუ ჩანაწერი არ არის, დომენი თავისუფალია
        $records = @dns_get_record($fullDomain, DNS_A | DNS_NS | DNS_MX);
        $available = empty($records);

        $results[] = [
            'domain'    => $fullDomain,
            'available' => $available,
            'price'     => $prices[$tld] ?? 15,
            'tld'       => $tld,
        ];
    }

    // Available პირველი
    usort($results, fn($a, $b) => $b['available'] - $a['available']);

    Log::info("DNS check for: " . $domain);

    return $results;
  }
}
