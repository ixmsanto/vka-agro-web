<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Post-deploy hook for hosts without shell access. The GitHub Actions workflow
 * FTPs the files, then POSTs here so migrations and cache-warming run on the
 * server. Guarded by a shared secret; if DEPLOY_TOKEN is unset the route 404s.
 */
class DeployController extends Controller
{
    public function run(Request $request): JsonResponse
    {
        $expected = (string) config('app.deploy_token');
        $given = (string) ($request->header('X-Deploy-Token') ?? $request->input('token', ''));

        abort_if($expected === '' || ! hash_equals($expected, $given), 404);

        $output = [];

        Artisan::call('migrate', ['--force' => true]);
        $output['migrate'] = trim(Artisan::output());

        // First deploy: an empty database gets the default content + admin user.
        if (User::count() === 0) {
            Artisan::call('db:seed', ['--force' => true]);
            $output['seed'] = trim(Artisan::output());
        }

        // Warm the caches. storage:link is deliberately skipped — uploads are
        // served straight from public_html/uploads, so no symlink is needed.
        foreach (['config:cache', 'route:cache', 'view:cache'] as $command) {
            Artisan::call($command);
            $output[$command] = trim(Artisan::output()) ?: 'ok';
        }

        return response()->json(['status' => 'ok', 'steps' => $output]);
    }
}
