<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Services\SiteConnectivityProbe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteConnectivityReportController extends Controller
{
    public function index()
    {
        $this->authorizeDeveloper();

        return view('business.connectivity-report');
    }

    public function sites(): JsonResponse
    {
        $this->authorizeDeveloper();

        return response()->json(
            Website::orderBy('id')->get(['id', 'site_name'])->map(fn ($site) => [
                'id'   => $site->id,
                'name' => (string) $site->site_name,
            ])->values()
        );
    }

    public function check(Request $request, SiteConnectivityProbe $probe): JsonResponse
    {
        $this->authorizeDeveloper();

        $data = $request->validate([
            'ids'   => 'required|array|min:1|max:60',
            'ids.*' => 'integer',
        ]);

        set_time_limit(150);

        $sites = Website::whereIn('id', $data['ids'])->orderBy('id')->get()->map(fn ($site) => [
            'id'       => $site->id,
            'name'     => (string) $site->site_name,
            'host'     => trim((string) $site->db_host),
            'port'     => (int) ($site->db_port ?: 3306),
            'database' => trim((string) $site->db_name),
            'username' => trim((string) $site->db_username),
            'password' => (string) $site->db_password,
        ])->all();

        return response()->json(['results' => $probe->run($sites)]);
    }

    private function authorizeDeveloper(): void
    {
        if (!auth()->user()->roles->contains('name', 'developer')) {
            abort(403);
        }
    }
}